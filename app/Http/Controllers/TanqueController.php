<?php

namespace App\Http\Controllers;

use App\ValidacionTanque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class TanqueController extends Controller
{

     // Métodos auxiliares para obtener información del usuario
    protected function getCurrentUserName()
    {
        return session('user_cur_fullname') ?? Auth::user()->name ?? 'sistema';
    }


    // ✅ Verifica (cambia estado a 2)
    public function verificar(Request $request, $numero_orden)
    {
        $registro = ValidacionTanque::where('numero_orden', $numero_orden)->firstOrFail();

        $registro->estado = 2;
        $registro->supervisor = $this->getCurrentUserName(); // ← aquí se asigna el usuario actual
        $registro->save();

        return response()->json([
            'message' => 'Orden verificada correctamente.',
            'data'    => $registro
        ]);
    }


    // ✅ Autoriza (cambia estado a 3)
    public function autorizar(Request $request, $numero_orden)
    {
        $registro = ValidacionTanque::where('numero_orden', $numero_orden)->firstOrFail();

        $registro->estado = 3;
        $registro->control_calidad = $this->getCurrentUserName(); // ← nombre de quien autoriza
        $registro->save();

        return response()->json([
            'message' => 'Orden autorizada correctamente.',
            'data'    => $registro
        ]);
    }


    /**
     * Almacena o actualiza la validación de tanque para una orden.
     */
    public function storeOrUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'numero_orden'   => 'required|string|max:50',
            'fecha_hora'     => 'required|date',
            'operaria'       => 'nullable|string|max:100',
            'supervisor'     => 'nullable|string|max:100',
            'control_calidad'=> 'nullable|string|max:100',
            'lote'           => 'required|string|max:50',
            'numero_tanque'  => 'required|string|max:50',
            'codigo_empaque' => 'nullable|string|max:100',
            'estado'         => 'nullable|integer|min:0|max:3'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Datos inválidos',
                'errors'  => $validator->errors()
            ], 422);
        }

        $data = $request->only([
            'numero_orden',
            'fecha_hora',
            'operaria',
            'supervisor',
            'control_calidad',
            'lote',
            'numero_tanque',
            'codigo_empaque',
            'estado',
        ]);

        // ✅ Si es estado 0 o 1, registrar nombre como operaria
        if (in_array($data['estado'], [0, 1])) {
            $data['operaria'] = $this->getCurrentUserName();
        }

        $registro = ValidacionTanque::updateOrCreate(
            ['numero_orden' => $data['numero_orden']],
            $data
        );

        return response()->json([
            'message' => 'Validación de tanque guardada correctamente',
            'data'    => $registro
        ]);
    }

    // public function storeOrUpdate(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'numero_orden'   => 'required|string|max:50',
    //         'fecha_hora'     => 'required|date',
    //         'operaria'       => 'nullable|string|max:100',
    //         'supervisor'     => 'nullable|string|max:100',
    //         'control_calidad'=> 'nullable|string|max:100',
    //         'lote'           => 'required|string|max:50',
    //         'numero_tanque'  => 'required|string|max:50',
    //         'codigo_empaque' => 'nullable|string|max:100',
    //         'estado'         => 'nullable|integer|min:0|max:3'
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'message' => 'Datos inválidos',
    //             'errors'  => $validator->errors()
    //         ], 422);
    //     }

    //     $data = $request->only([
    //         'numero_orden',
    //         'fecha_hora',
    //         'operaria',
    //         'supervisor',
    //         'control_calidad',
    //         'lote',
    //         'numero_tanque',
    //         'codigo_empaque',
    //         'estado',
    //     ]);

    //     $registro = ValidacionTanque::updateOrCreate(
    //         ['numero_orden' => $data['numero_orden']],
    //         $data
    //     );

    //     return response()->json([
    //         'message' => 'Validación de tanque guardada correctamente',
    //         'data'    => $registro
    //     ]);
    // }

    public function buscarOrden(Request $request)
    {
        // 1️⃣ Normalizar número de orden — quitar espacios, conservar guiones
        $numero_orden = trim($request->input('query'));
        $normalized = preg_replace('/\s+/', '', $numero_orden); // ej: "12488-10"

        // 2️⃣ Buscar primero en la base de datos
        $registro = ValidacionTanque::whereRaw("REPLACE(numero_orden, ' ', '') = ?", [$normalized])
            ->orWhereRaw("REPLACE(codigo_empaque, ' ', '') = ?", [$normalized])
            ->first();

        if ($registro) {
            return response()->json([
                'existe' => true,
                'origen' => 'BD',
                'orden'  => $registro
            ]);
        }

        // 3️⃣ Si no existe localmente, consultar SAP
        $url = 'https://data.industriascuscatlan.com:7322/wsPlantel/empaque.php';

        try {
            $response = Http::withoutVerifying()
                ->timeout(10)
                ->retry(3, 100)
                ->get($url);

            if ($response->failed()) {
                return response()->json([
                    'existe' => false,
                    'msg'    => 'Error al conectar con SAP',
                    'error'  => $response->status()
                ]);
            }

            $body  = $this->cleanResponseBody($response->body());
            $items = json_decode($body, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return response()->json([
                    'existe' => false,
                    'msg'    => 'Error de formato en SAP',
                    'error'  => json_last_error_msg()
                ]);
            }

            // 4️⃣ Buscar coincidencia en SAP con el mismo formato (sin espacios)
            foreach ($items as $el) {
                $num = preg_replace('/\s+/', '', $el['num'] ?? '');
                if ($num === $normalized) {
                    // Guardar solo si NO existe (por si otra persona ya lo creó)
                    $existe = ValidacionTanque::whereRaw("REPLACE(numero_orden, ' ', '') = ?", [$normalized])->exists();
                    if (!$existe) {
                        $this->storeSapResult((object) $el, $numero_orden);
                    }

                    return response()->json([
                        'existe' => true,
                        'origen' => 'SAP',
                        'orden'  => $el
                    ]);
                }
            }

            return response()->json([
                'existe' => false,
                'msg'    => 'No se encontró la orden en ningún sistema'
            ]);

        } catch (\Exception $e) {
            Log::error("Error buscando orden SAP: " . $e->getMessage());
            return response()->json([
                'existe' => false,
                'msg'    => 'Error de conexión con SAP',
                'error'  => $e->getMessage()
            ], 500);
        }
    }

    

    // public function buscarOrden(Request $request)
    // {
    //     // 1. Obtener y normalizar el parámetro enviado por POST
    //     $numero_orden = $request->input('query');     // o $request->input('numero_orden')
    //     $query        = preg_replace('/[^A-Za-z0-9]/', '', $numero_orden); // Limpiar en PHP

    //     // 2. Buscar primero en la base de datos
    //     $registro = ValidacionTanque::where(function ($q) use ($query) {
    //             $q->whereRaw("REPLACE(numero_orden, ' ', '') = ?", [$query]) // Usar REPLACE sin REGEXP_REPLACE
    //             ->orWhereRaw("REPLACE(codigo_empaque, ' ', '') = ?", [$query]);
    //         })
    //         ->first();

    //     if ($registro) {
    //         return response()->json([
    //             'existe' => true,
    //             'origen' => 'BD',
    //             'orden'  => $registro
    //         ]);
    //     }

    //     // 3. Si no existe localmente, consultar SAP
    //     // $url = 'https://192.168.6.26/wsPlantel/empaque.php';
    //     $url = 'https://data.industriascuscatlan.com:7322/wsPlantel/empaque.php';

    //     try {
    //         $response = Http::withoutVerifying()
    //             ->timeout(10)
    //             ->retry(3, 100)
    //             ->get($url);

    //         if ($response->failed()) {
    //             return response()->json([
    //                 'existe' => false,
    //                 'msg'    => 'Error al conectar con SAP',
    //                 'error'  => $response->status()
    //             ]);
    //         }

    //         $body  = $this->cleanResponseBody($response->body());
    //         $items = json_decode($body, true);

    //         if (json_last_error() !== JSON_ERROR_NONE) {
    //             return response()->json([
    //                 'existe' => false,
    //                 'msg'    => 'Error de formato en SAP',
    //                 'error'  => json_last_error_msg()
    //             ]);
    //         }

    //         foreach ($items as $el) {
    //             $e        = (object) $el;
    //             $ordenSAP = preg_replace('/[^A-Za-z0-9]/', '', $e->num ?? ''); // Limpiar en PHP

    //             if ($ordenSAP === $query) {
    //                 $this->storeSapResult($e, $query);

    //                 return response()->json([
    //                     'existe' => true,
    //                     'origen' => 'SAP',
    //                     'orden'  => $e
    //                 ]);
    //             }
    //         }

    //         return response()->json([
    //             'existe' => false,
    //             'msg'    => 'No se encontró la orden en ningún sistema'
    //         ]);

    //     } catch (\Exception $e) {
    //         Log::error("Error buscando orden SAP: " . $e->getMessage());
    //         return response()->json([
    //             'existe' => false,
    //             'msg'    => 'Error de conexión con SAP',
    //             'error'  => $e->getMessage()
    //         ], 500);
    //     }
    // }


    // Métodos auxiliares se mantienen igual
    protected function cleanResponseBody($body)
    {
        if (substr($body, 0, 3) == pack('CCC', 0xEF, 0xBB, 0xBF)) {
            $body = substr($body, 3);
        }
        return preg_replace('/[^\x20-\x7E]/', '', $body);
    }

    protected function storeSapResult($sapData, $query)
    {
        try {
            ValidacionTanque::updateOrCreate(
                ['numero_orden' => $query],
                [
                    'numero_orden' => $query,
                    'fecha_hora' => now(),
                    'codigo_empaque' => $sapData->codigo_empaque ?? null,
                    'estado' => 1
                ]
            );
        } catch (\Exception $e) {
            Log::error("Error guardando resultado SAP: " . $e->getMessage());
        }
    }

    public function index()
    {
        return view('tanque.tanque');
    }

    public function pendientes()
    {
        $pendientes = ValidacionTanque::where('estado', '<', 3)
                        ->orderBy('fecha_hora', 'desc')
                        ->take(10)
                        ->get();

        return response()->json($pendientes);
    }


   /**
     * Obtiene la validación de tanque por número de orden.
     */
    public function show($numero_orden)
    {
        // Elimina espacios y decodifica posibles caracteres URL (ej. %20)
        $query = preg_replace('/\s+/', '', urldecode($numero_orden));

        $registro = ValidacionTanque::whereRaw("REPLACE(numero_orden, ' ', '') = ?", [$query])->first();

        if (!$registro) {
            return response()->json([
                'message' => 'No se encontró validación para esta orden'
            ], 404);
        }

        return response()->json([
            'validacion' => $registro
        ]);
    }
    
    /**
     * Retorna el número de lote para una orden de tanque específica.
     */
    public function getLotePorOrden($numero_orden)
    {
        $registro = ValidacionTanque::where('numero_orden', $numero_orden)->first();

        if (!$registro) {
            return response()->json([
                'message' => 'Orden no encontrada',
                'lote'    => null
            ], 404);
        }

        return response()->json([
            'message' => 'Lote encontrado correctamente',
            'lote'    => $registro->lote
        ]);
    }



}
