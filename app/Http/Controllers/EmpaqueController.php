<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Packing;
use App\MixOrder;
use App\EmpaqueMaterial;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Extension para ver reportar logs en caso de error o informacion
use Carbon\Carbon; // Extension para manejo de fechas
use App\ValidacionTanque;

class EmpaqueController extends Controller
{
    public function statusProgress(Request $request,$order_code){
        $salida = [
            "code" => 0,
            "msg" => "",
            "data" => null
        ];
        //Permission here
        //Buscando en registros locales
        $order = null;
        $order = Packing::where('num_id',$order_code)->first();
        if(!$order){
            $salida["msg"] = "La orden no fue encontrada";
            return $salida;
        }
        $estandares = $order->estandares;
        $controles = $order->controles;
        $inspecciones = $order->inspecciones;

        $data["master"] = ["msgs"=>"","complete"=>false];
        $data["estandares"] = ["msgs"=>"","complete"=>false];
        $data["controles"] = ["msgs"=>"","complete"=>false];
        $data["inspecciones"] = ["msgs"=>"","complete"=>false];

        switch($order->status){
            case 2: {$data["master"]["msgs"] = "Pendiente de aprobación\n";break;}
            case 3: {$data["master"]["msgs"] = "Pendiente de finalizar\n";break;}
            case 4: {$data["master"]["msgs"] = "Finalizada\n"; $data["master"]["complete"] = true; break;}
            default: {$data["water"]["msgs"] .= "Inconsistencia de estado \n";break;}
        }

        $estandares_def = [1]; // turnos requeridos
        $estandares_init = [];

        if ($estandares != null) {
            foreach ($estandares as $es) {
                $estandares_init[$es->turno] = true;

                if ($es->seccion < 8) {
                    $piv = $es->seccion + 1;
                    $data["estandares"]["msgs"] .= "Sección $piv pendiente de llenar/verificar para turno $es->turno\n";
                }

                if ($es->seccion == 8) {
                    $data["estandares"]["msgs"] .= "Verificado, pendiente de autorización para turno $es->turno\n";
                }

                if ($es->seccion == 9) {
                    $data["estandares"]["msgs"] .= "✔️ Proceso completado para turno $es->turno\n";
                    $data["estandares"]["complete_turnos"][$es->turno] = true; // ✅ Marca el turno como terminado
                }

                if ($es->seccion > 9) {
                    $data["estandares"]["msgs"] .= "⚠️ Inconsistencia de estado para turno $es->turno\n";
                }
            }
        }

        // Detecta turnos faltantes
        foreach ($estandares_def as $es_def) {
            if (!isset($estandares_init[$es_def])) {
                $data["estandares"]["msgs"] .= "Hoja sin llenar para turno $es_def\n";
            }
        }

        // Si todos los turnos definidos están completos:
        $data["estandares"]["complete"] = count($estandares_def) === count(array_filter($estandares_init, function($turno) use ($data) {
            return isset($data["estandares"]["complete_turnos"][$turno]);
        }));


        $controles_def = [1]; // turnos requeridos
        $controles_init = [];

        if ($controles != null) {
            foreach ($controles as $con) {
                $controles_init[$con->turno] = true;

                // ✅ Verificar si el turno ya completó 25 campos válidos
                $atributos = collect($con->getAttributes());
                $camposLlenos = $atributos->filter(fn($v, $k) => !is_null($v) && $k !== 'id' && $k !== 'turno' && $k !== 'created_at' && $k !== 'updated_at');

                if ($camposLlenos->count() >= 25) {
                    $data["controles"]["msgs"] .= "✔️ Proceso completado para turno $con->turno (25 campos llenos)\n";
                    $data["controles"]["complete_turnos"][$con->turno] = true;
                    continue; // omitir chequeo por seccion
                }

                // Validación por seccion (si no está completo aún)
                if ($con->seccion < 50) {
                    $piv2 = $con->seccion + 1;
                    $data["controles"]["msgs"] .= "Sección $piv2 pendiente de llenar/verificar para turno $con->turno\n";
                }

                if ($con->seccion == 50) {
                    $data["controles"]["msgs"] .= "Verificado, pendiente de aprobación para turno $con->turno\n";
                }

                if ($con->seccion == 51) {
                    $data["controles"]["msgs"] .= "✔️ Proceso completado para turno $con->turno\n";
                    $data["controles"]["complete_turnos"][$con->turno] = true;
                }

                if ($con->seccion > 51) {
                    $data["controles"]["msgs"] .= "⚠️ Inconsistencia de estado para turno $con->turno\n";
                }
            }
        }

        // 🧾 Detectar turnos no iniciados
        foreach ($controles_def as $con_def) {
            if (!isset($controles_init[$con_def])) {
                $data["controles"]["msgs"] .= "Hoja sin llenar para turno $con_def\n";
            }
        }

        // ✅ Validar si todos los turnos requeridos están completos
        $data["controles"]["complete"] = count($controles_def) === count(array_filter($controles_def, function ($turno) use ($data) {
            return isset($data["controles"]["complete_turnos"][$turno]);
        }));


        if(!$inspecciones){
            $data["inspecciones"]["msgs"] = "Hoja de inspecciones sin llenar\n";
        }else{
            switch($inspecciones->estado){
                case 1: {
                    $data["inspecciones"]["msgs"] .= "Inspección 1 pendiente de verificar\n";break;
                }
                case 2: {
                    $data["inspecciones"]["msgs"] .= "Inspección 2 sin llenar \n";break;
                }
                case 3: {
                    $data["inspecciones"]["msgs"] .= "Inspección 2 pendiente de verificar\n";break;
                }
                case 4: {
                    $data["inspecciones"]["msgs"] .= "Pendiente de finalizar\n";break;
                }
                case 5: {
                    // $data["inspecciones"]["msgs"] .= "Pendiente de autorización\n";break;
                    $data["inspecciones"]["msgs"] .= "Finalizada\n";
                    $data["inspecciones"]["complete"] = true;
                    break;
                }
                // case 6: {
                //     $data["inspecciones"]["msgs"] .= "Finalizada\n";
                //     $data["inspecciones"]["complete"] = true;
                //     break;
                // }
                default: {
                    $data["inspecciones"]["msgs"] .= "Inconsistencia de estado\n";break;
                }
            }
        }

        $salida["code"] = 1;
        $salida["data"] = $data;
        $salida["msg"] = "Request completed";
        return $salida;
    }

    public function search($order_code)
    {
        $salida = [
            "code" => 0,
            "msg" => "",
            "data" => null
        ];

        if (!Auth::user()->hasRole("Bodega") && !Auth::user()->hasRole("Produccion")) {
            $salida["msg"] = "Operación denegada";
            return $salida;
        }

        // Normalizar el código ingresado (quitar espacios)
        $normalizedOrderCode = preg_replace('/\s+/', '', $order_code);

        // Generar la variante de búsqueda: si termina en -10 -> buscar también por -20
        $searchNormalizedOrderCode = $normalizedOrderCode;
        if (preg_match('/-10$/', $normalizedOrderCode)) {
            $searchNormalizedOrderCode = preg_replace('/-10$/', '-20', $normalizedOrderCode);
        }

        $salida["data"] = ["origin" => "DB", "order" => null];

        // ⚠️ Validación tanque previa a todo — buscar por la variante original O por la transformada
        $validacion = ValidacionTanque::where('estado', 3)
                        ->where(function ($q) use ($normalizedOrderCode, $searchNormalizedOrderCode) {
                            $q->whereRaw("REPLACE(numero_orden, ' ', '') = ?", [$normalizedOrderCode]);
                            if ($searchNormalizedOrderCode !== $normalizedOrderCode) {
                                $q->orWhereRaw("REPLACE(numero_orden, ' ', '') = ?", [$searchNormalizedOrderCode]);
                            }
                        })->first();

        if (!$validacion) {
            $salida["msg"] = "Debe completar la validación de tanque antes de acceder a esta orden.";
            return $salida;
        }

        // Buscar la orden en Packing usando cualquiera de las dos variantes
        $order = Packing::where(function ($q) use ($normalizedOrderCode, $searchNormalizedOrderCode) {
                    $q->whereRaw("REPLACE(num_id, ' ', '') = ?", [$normalizedOrderCode]);
                    if ($searchNormalizedOrderCode !== $normalizedOrderCode) {
                        $q->orWhereRaw("REPLACE(num_id, ' ', '') = ?", [$searchNormalizedOrderCode]);
                    }
                })->first();

        if (!$order) {
            $salida["data"]["origin"] = "API";
            $url = "https://data.industriascuscatlan.com:7322/wsPlantel/empaque.php";

            $response = Http::withoutVerifying()->get($url);
            $body = $response->body();

            \Log::info('API Response (raw): ' . $body);

            $cleanBody = preg_replace('/^\xEF\xBB\xBF/', '', $body);
            $cleanBody = preg_replace('/[\x00-\x1F\x7F]/u', '', $cleanBody);

            $items = json_decode($cleanBody, true);

            if (json_last_error() !== JSON_ERROR_NONE || !is_array($items)) {
                \Log::error('Error al decodificar JSON: ' . json_last_error_msg());
                \Log::error('Cuerpo después de limpiar: ' . $cleanBody);

                $cleanBody = preg_replace('/[^[:print:]]/', '', $cleanBody);
                $items = json_decode($cleanBody, true);

                if (json_last_error() !== JSON_ERROR_NONE || !is_array($items)) {
                    \Log::error('Error persistente en decodificación: ' . json_last_error_msg());
                    $salida["msg"] = "Error: La API no devolvió resultados válidos.";
                    return $salida;
                }
            }

            foreach ($items as $el) {
                $e = (object)$el;

                // Normalizar el código devuelto por la API
                $normalizedApiCode = preg_replace('/\s+/', '', (string)($e->num ?? ''));

                // Comparar códigos: contra la original y contra la variante -20 (si aplica)
                $match = ($normalizedApiCode === $normalizedOrderCode);
                if (!$match && $searchNormalizedOrderCode !== $normalizedOrderCode) {
                    $match = ($normalizedApiCode === $searchNormalizedOrderCode);
                }

                if ($match) {
                    $order = $e;
                    $order->lot_num = $e->lote ?? null;
                    break;
                }
            }

            if (!$order) {
                $salida["msg"] = "No se encontró la orden en la API.";
                return $salida;
            }
        } else {
            $order->load('materials');
        }

        // Formatear la fecha aquí
        if (isset($order->date)) {
            $order->date = Carbon::parse($order->date)->format('Y-m-d H:i:s');
        }

        // Manejar los materiales correctamente sin modificar indirectamente
        $materials = collect($order->materials)->map(function ($material) {
            $material = (object)$material; // Asegurar que sea un objeto
            if (!isset($material->process) || $material->process === null) {
                $material->process = 'Empaque'; // Asignar valor por defecto
            }
            return $material;
        })->all();

        $order->materials = $materials;

        // ⚠️ NO manipular lot_num aquí - lo maneja searchDB()
        
        $salida["code"] = 1;
        $salida["msg"] = "Processed Successfully";
        $salida["data"]["order"] = $order;
        return $salida;
    }

    public function saveOrUpdate(Request $request){
        $salida = [
            "code" => 0,
            "msg" => "",
            "data" => null
        ];

        if (!Auth::user()->hasRole("Bodega") && !Auth::user()->hasRole("SupCalidad") &&
            !Auth::user()->hasRole("Produccion") && !Auth::user()->hasRole("AuxControlCalidad")) {
            $salida["msg"] = "Operación denegada";
            return $salida;
        }

        $validator = Validator::make($request->all(), [
            "date" => "required|date",
            "num_id" => "required|string",
            "product_code" => "required",
            "product_name" => "required",
            "lot_size" => "required|numeric",
            "total_units" => "required|numeric|min:0",
        ]);

        if ($validator->fails()) {
            $salida["msg"] = "Error en validación de campos (" . $validator->errors()->first() . ")";
            return $salida;
        }

        DB::beginTransaction();
        try {
            $order = null;
            if ($request->order_id != 0) {
                $order = Packing::find($request->order_id);
                if ($order == null) {
                    throw new \Exception("Inconsistencia en recuperar orden");
                }
            } else {
                $order = new Packing();
            }

            $materials_count = count($request->materials);

            $order->order_date = $request->date;
            $order->num_id = preg_replace('/\s+/', '', $request->num_id);
            $order->product_code = $request->product_code;
            $order->product_name = $request->product_name;
            $order->lot_num = $request->lot_num;
            $order->lot_size = $request->lot_size;
            $order->total_units = $request->total_units;
            $order->materials = $materials_count;
            $order->observations = $request->observations;

            if (Auth::user()->hasRole("Bodega")) {
                $order->user_entrega = session('user_cur_fullname');
            }

            // Decodificar times para revisar si se debe firmar automáticamente
            $times = json_decode(json_encode($request->times), true);
            $validStart = collect($times)->contains(function ($t) {
                return isset($t['date_init'], $t['time_init']) && !empty($t['date_init']) && !empty($t['time_init']);
            });

            if ($validStart && !$order->user_recibe) {
                $order->user_recibe = session('user_cur_fullname');
            }

            $order->status = 2; // pendiente de aprobación

            // ========================================
            // 🔹 FUSIONAR TIMES (mantener datos previos)
            // ========================================
            $existingTimes = json_decode($order->times ?? '[]', true);
            $newTimes = is_array($request->times) ? $request->times : json_decode($request->times, true);
            
            foreach ($newTimes as $index => $newTime) {
                if (isset($existingTimes[$index])) {
                    // Fusionar: solo sobrescribir si el nuevo valor no está vacío
                    foreach ($newTime as $key => $value) {
                        if (!empty($value) || $value === 0) {
                            $existingTimes[$index][$key] = $value;
                        }
                    }
                } else {
                    // Agregar nuevo elemento
                    $existingTimes[$index] = $newTime;
                }
            }
            $order->times = json_encode($existingTimes);

            // ========================================
            // 🔹 FUSIONAR OPERARIOS (mantener nombres previos)
            // ========================================
            $existingOperarios = json_decode($order->operarios ?? '[]', true);
            $newOperarios = is_array($request->operarios) ? $request->operarios : json_decode($request->operarios, true);
            
            foreach ($newOperarios as $index => $newOperario) {
                if (isset($existingOperarios[$index])) {
                    // Fusionar: solo sobrescribir si el nuevo valor no está vacío
                    foreach ($newOperario as $key => $value) {
                        if (!empty($value) || $value === 0) {
                            $existingOperarios[$index][$key] = $value;
                        }
                    }
                } else {
                    // Agregar nuevo elemento
                    $existingOperarios[$index] = $newOperario;
                }
            }
            $order->operarios = json_encode($existingOperarios);

            // ========================================
            // 🔹 FUSIONAR ENTREGAS (mantener firmas previas)
            // ========================================
            $existingEntregas = json_decode($order->entregas ?? '[]', true);
            $newEntregas = is_array($request->entregas) ? $request->entregas : json_decode($request->entregas, true);
            
            foreach ($newEntregas as $index => $newEntrega) {
                if (isset($existingEntregas[$index])) {
                    // Fusionar: solo sobrescribir si el nuevo valor no está vacío
                    foreach ($newEntrega as $key => $value) {
                        if (!empty($value) || $value === 0) {
                            $existingEntregas[$index][$key] = $value;
                        }
                    }
                } else {
                    // Agregar nuevo elemento
                    $existingEntregas[$index] = $newEntrega;
                }
            }
            $order->entregas = json_encode($existingEntregas);

            $order->save();

            // Guardar materiales
            $material_passed = 0;
            while ($material_passed < $materials_count) {
                $target = (object)$request->materials[$material_passed];
                if ($target->material_id != 0) {
                    $mats = EmpaqueMaterial::find($target->material_id);
                    if ($mats == null) {
                        throw new \Exception("Inconsistencia recuperar materiales");
                    }
                } else {
                    $mats = new EmpaqueMaterial();
                }

                $mats->code = $target->code;
                $mats->description = $target->description;
                $mats->process = $target->process;
                $mats->required_amount = $target->required_amount;
                $mats->unit = $target->unit;
                $mats->stock = $target->stock;
                $mats->almacen = $target->almacen;
                $mats->lot1 = $target->lot1;
                $mats->entrega1 = $target->entrega1;
                $mats->entrega2 = $target->entrega2;
                $mats->return = $target->return;
                $mats->packing_id = $order->id;
                $mats->save();
                $material_passed++;
            }

            $order->refresh();
            DB::commit();
            $salida["code"] = 1;
            $salida["msg"] = "Processed Successfully";
            $salida["data"] = $order->load('materials');

        } catch (\Exception $ex) {
            DB::rollback();
            $salida["msg"] = "Error en la operación, consulte soporte técnico.\n" . $ex->getMessage();
        }

        return $salida;
    }

    /**
     * Consulta el UXC de una orden de empaque desde la API externa
     * Retorna únicamente el valor numérico del UXC
     */
    public function getUXCByOrder($order_code)
    {
        $salida = [
            "code" => 0,
            "msg" => "",
            "uxc" => null
        ];

        try {
            $url = "https://data.industriascuscatlan.com:7322/wsPlantel/empaque.php";
            \Log::info("🌐 getUXCByOrder: consultando {$url}");

            $response = Http::withoutVerifying()->get($url);

            if (!$response->successful()) {
                $salida["msg"] = "Error al conectar con API externa";
                \Log::error("❌ Error HTTP: " . $response->status());
                return response()->json($salida, 500);
            }

            $body = $response->body();
            \Log::info("📦 Longitud body recibido: " . strlen($body));

            // 🔹 Limpieza base (BOM y caracteres de control)
            $cleanBody = preg_replace('/^\xEF\xBB\xBF/', '', $body);
            $cleanBody = preg_replace('/[\x00-\x1F\x7F]/u', '', $cleanBody);

            // Primer intento de decodificación
            $items = json_decode($cleanBody, true);
            $jsonError = json_last_error_msg();
            \Log::info("🧩 Resultado primer decode: {$jsonError}");

            // Si falla, intentar limpieza profunda
            if (json_last_error() !== JSON_ERROR_NONE || !is_array($items)) {
                \Log::warning("⚠️ JSON inicial inválido, aplicando limpieza avanzada...");
                \Log::debug("🧾 Fragmento (inicio): " . substr($cleanBody, 0, 300));

                // Quitar caracteres no imprimibles y símbolos invisibles
                $cleanBody = preg_replace('/[^[:print:]]/', '', $cleanBody);
                $cleanBody = preg_replace('/,\s*([\]}])/m', '$1', $cleanBody); // eliminar comas colgantes
                $cleanBody = trim($cleanBody);

                $items = json_decode($cleanBody, true);
                $jsonError2 = json_last_error_msg();
                \Log::info("🔁 Segundo intento decode: {$jsonError2}");

                if (json_last_error() !== JSON_ERROR_NONE || !is_array($items)) {
                    \Log::error("💥 Error persistente al decodificar JSON: {$jsonError2}");
                    $salida["msg"] = "Error al decodificar JSON remoto";
                    return response()->json($salida, 500);
                }
            }

            $normalizedNoSpaces = preg_replace('/\s+/', '', $order_code); // 100-10
            $normalizedWithSpaces = preg_replace('/-/', ' - ', $normalizedNoSpaces); // 100 - 10
            \Log::info("🔍 Buscando orden '{$order_code}' | variantes '{$normalizedNoSpaces}' y '{$normalizedWithSpaces}'");

            $uxc = null;
            foreach ($items as $el) {
                if (!isset($el['num'])) continue;

                $apiRaw = trim($el['num']);
                $apiNoSpaces = preg_replace('/\s+/', '', $apiRaw);
                $apiWithSpaces = preg_replace('/-/', ' - ', $apiNoSpaces);

                if ($apiNoSpaces === $normalizedNoSpaces || $apiWithSpaces === $normalizedWithSpaces) {
                    $uxc = isset($el['uxc']) ? floatval($el['uxc']) : null;
                    \Log::info("✅ Coincidencia: {$apiRaw} → UXC={$uxc}");
                    break;
                }
            }

            if ($uxc === null || !is_numeric($uxc)) {
                $salida["msg"] = "No se encontró la orden o el UXC es inválido";
                \Log::warning("⚠️ Orden no encontrada: {$order_code}");
                return response()->json($salida, 404);
            }

            $salida["code"] = 1;
            $salida["msg"] = "OK";
            $salida["uxc"] = $uxc;
            \Log::info("🎯 Resultado final: " . json_encode($salida));

            return response()->json($salida);

        } catch (\Throwable $th) {
            \Log::error("💥 Error interno getUXCByOrder: {$th->getMessage()} en línea {$th->getLine()}");
            $salida["msg"] = "Error interno al consultar el UXC";
            return response()->json($salida, 500);
        }
    }



    public function tracking(Request $request, $id) {
        $salida = [
            "code" => 0,
            "msg" => "",
            "data" => null
        ];

        if (!Auth::user()->hasRole("Produccion")) {
            $salida["msg"] = "Operación denegada";
            return $salida;
        }

        $validator = Validator::make($request->all(), [
            "times" => "required|json",
            "operarios" => "required|json",
            "entregas" => "required|json"
        ]);

        if ($validator->fails()) {
            $salida["msg"] = "Inconsistencia de campos requeridos";
            return $salida;
        }

        $order = Packing::find($id);

        if (!$order) {
            $salida["msg"] = "No se encontró la orden";
            return $salida;
        }

        if ($order->status != 3) {
            $salida["msg"] = "Inconsistencia de estado";
            return $salida;
        }

        // ========================================
        // 🔹 FUSIONAR TIMES (sin sobrescribir valores existentes)
        // ========================================
        $existingTimes = json_decode($order->times ?? '[]', true);
        $newTimes = json_decode($request->times, true);
        
        foreach ($newTimes as $index => $newTime) {
            if (isset($existingTimes[$index])) {
                // Solo actualizar campos que están vacíos en los datos existentes
                foreach ($newTime as $key => $value) {
                    if ((!isset($existingTimes[$index][$key]) || 
                        empty($existingTimes[$index][$key])) && 
                        (!empty($value) || $value === 0)) {
                        $existingTimes[$index][$key] = $value;
                    }
                }
            } else {
                $existingTimes[$index] = $newTime;
            }
        }

        // ========================================
        // 🔹 FUSIONAR OPERARIOS (sin sobrescribir nombres existentes)
        // ========================================
        $existingOperarios = json_decode($order->operarios ?? '[]', true);
        $newOperarios = json_decode($request->operarios, true);

        foreach ($newOperarios as $index => $newOperario) {
            if (isset($existingOperarios[$index])) {
                // Solo actualizar campos que están vacíos en los datos existentes
                foreach ($newOperario as $key => $value) {
                    if (
                        (!isset($existingOperarios[$index][$key]) || 
                        empty($existingOperarios[$index][$key])) && 
                        (!empty($value) || $value === 0)
                    ) {
                        $existingOperarios[$index][$key] = $value;
                    }
                }
            } else {
                // Agregar nuevo elemento
                $existingOperarios[$index] = $newOperario;
            }
        }

        // 🔹 SINCRONIZAR FECHAS (times.date_end -> operarios.date)
        if (is_array($existingOperarios) && is_array($existingTimes)) {
            foreach ($existingTimes as $index => $time) {
                if (!empty($time['date_end']) && isset($existingOperarios[$index])) {
                    // Convertir times.date_end (YYYY-MM-DD) a DD/MM/YYYY
                    try {
                        $dateEnd = \Carbon\Carbon::createFromFormat('Y-m-d', $time['date_end'])->format('d/m/Y');
                        $existingOperarios[$index]['date'] = $dateEnd;
                    } catch (\Exception $e) {
                        // Si el formato no es válido, usar el valor original
                        $existingOperarios[$index]['date'] = $time['date_end'];
                    }
                }
            }
        }

        // ========================================
        // 🔹 FUSIONAR ENTREGAS (sin sobrescribir firmas existentes)
        // ========================================
        $existingEntregas = json_decode($order->entregas ?? '[]', true);
        $newEntregas = json_decode($request->entregas, true);
        
        foreach ($newEntregas as $index => $newEntrega) {
            if (isset($existingEntregas[$index])) {
                // Fusionar: solo sobrescribir si el nuevo valor no está vacío
                foreach ($newEntrega as $key => $value) {
                    if ($key === 'recibe') {
                        // Si 'recibe' ya tiene un valor en existingEntregas, NO sobrescribir
                        if (!empty($existingEntregas[$index]['recibe'])) {
                            continue;
                        }
                        // Si el valor enviado desde el frontend no está vacío, usarlo
                        if (!empty($value) || $value === 0) {
                            $existingEntregas[$index][$key] = $value;
                        }
                        continue;
                    }
                    if ((!isset($existingEntregas[$index][$key]) || 
                        empty($existingEntregas[$index][$key])) && 
                        (!empty($value) || $value === 0)) {
                        $existingEntregas[$index][$key] = $value;
                    }
                }
            } else {
                // Agregar nuevo elemento
                $existingEntregas[$index] = $newEntrega;
            }
            
            // Firmar SOLO si no existe firma previa
            if (
                isset($existingEntregas[$index]['date'], 
                    $existingEntregas[$index]['cantidad'], 
                    $existingEntregas[$index]['entrega']) &&
                !empty($existingEntregas[$index]['date']) &&
                !empty($existingEntregas[$index]['cantidad']) &&
                !empty($existingEntregas[$index]['entrega']) &&
                (empty($existingEntregas[$index]['recibe']) || 
                $existingEntregas[$index]['recibe'] === null)
            ) {
                $existingEntregas[$index]['recibe'] = session('user_cur_fullname');
            }
        }

        // Verificar si hay al menos un inicio para firmar user_recibe
        $validStart = collect($existingTimes)->contains(function ($t) {
            return isset($t['date_init'], $t['time_init']) && 
                !empty($t['date_init']) && 
                !empty($t['time_init']);
        });

        if ($validStart && !$order->user_recibe) {
            $order->user_recibe = session('user_cur_fullname');
        }

        // Asignar valores fusionados
        $order->times = json_encode($existingTimes);
        $order->operarios = json_encode($existingOperarios);
        $order->entregas = json_encode($existingEntregas);

        if ($request->performance_teorico != null) {
            $order->performance_teorico = $request->performance_teorico;
        }

        if ($request->performance != null) {
            $order->performance = $request->performance;
        }

        if ($request->observations != null) {
            $order->observations = $request->observations;
        }

        if (!$order->save()) {
            $salida["msg"] = "Ocurrió un problema al guardar la orden";
            return $salida;
        }

        $order->refresh();
        $order->load('materials');

        $salida["code"] = 1;
        $salida["msg"] = "Processed Successfully";
        $salida["data"] = $order;

        return $salida;
    }

    // public function search($order_code)
    // {
    //     $salida = [
    //         "code" => 0,
    //         "msg" => "",
    //         "data" => null
    //     ];

    //     if (!Auth::user()->hasRole("Bodega") && !Auth::user()->hasRole("Produccion")) {
    //         $salida["msg"] = "Operación denegada";
    //         return $salida;
    //     }

    //     // Normalizar el código ingresado (quitar espacios)
    //     $normalizedOrderCode = preg_replace('/\s+/', '', $order_code);

    //     // Generar la variante de búsqueda: si termina en -10 -> buscar también por -20
    //     $searchNormalizedOrderCode = $normalizedOrderCode;
    //     if (preg_match('/-10$/', $normalizedOrderCode)) {
    //         $searchNormalizedOrderCode = preg_replace('/-10$/', '-20', $normalizedOrderCode);
    //     }

    //     $salida["data"] = ["origin" => "DB", "order" => null];

    //     // ⚠️ Validación tanque previa a todo — buscar por la variante original O por la transformada
    //     $validacion = ValidacionTanque::where('estado', 3)
    //                     ->where(function ($q) use ($normalizedOrderCode, $searchNormalizedOrderCode) {
    //                         $q->whereRaw("REPLACE(numero_orden, ' ', '') = ?", [$normalizedOrderCode]);
    //                         if ($searchNormalizedOrderCode !== $normalizedOrderCode) {
    //                             $q->orWhereRaw("REPLACE(numero_orden, ' ', '') = ?", [$searchNormalizedOrderCode]);
    //                         }
    //                     })->first();

    //     if (!$validacion) {
    //         $salida["msg"] = "Debe completar la validación de tanque antes de acceder a esta orden.";
    //         return $salida;
    //     }

    //     // Buscar la orden en Packing usando cualquiera de las dos variantes
    //     $order = Packing::where(function ($q) use ($normalizedOrderCode, $searchNormalizedOrderCode) {
    //                 $q->whereRaw("REPLACE(num_id, ' ', '') = ?", [$normalizedOrderCode]);
    //                 if ($searchNormalizedOrderCode !== $normalizedOrderCode) {
    //                     $q->orWhereRaw("REPLACE(num_id, ' ', '') = ?", [$searchNormalizedOrderCode]);
    //                 }
    //             })->first();

    //     if (!$order) {
    //         $salida["data"]["origin"] = "API";
    //         $url = "https://data.industriascuscatlan.com:7322/wsPlantel/empaque.php";

    //         $response = Http::withoutVerifying()->get($url);
    //         $body = $response->body();

    //         \Log::info('API Response (raw): ' . $body);

    //         $cleanBody = preg_replace('/^\xEF\xBB\xBF/', '', $body);
    //         $cleanBody = preg_replace('/[\x00-\x1F\x7F]/u', '', $cleanBody);

    //         $items = json_decode($cleanBody, true);

    //         if (json_last_error() !== JSON_ERROR_NONE || !is_array($items)) {
    //             \Log::error('Error al decodificar JSON: ' . json_last_error_msg());
    //             \Log::error('Cuerpo después de limpiar: ' . $cleanBody);

    //             $cleanBody = preg_replace('/[^[:print:]]/', '', $cleanBody);
    //             $items = json_decode($cleanBody, true);

    //             if (json_last_error() !== JSON_ERROR_NONE || !is_array($items)) {
    //                 \Log::error('Error persistente en decodificación: ' . json_last_error_msg());
    //                 $salida["msg"] = "Error: La API no devolvió resultados válidos.";
    //                 return $salida;
    //             }
    //         }

    //         foreach ($items as $el) {
    //             $e = (object)$el;

    //             // Normalizar el código devuelto por la API
    //             $normalizedApiCode = preg_replace('/\s+/', '', (string)($e->num ?? ''));

    //             // Comparar códigos: contra la original y contra la variante -20 (si aplica)
    //             $match = ($normalizedApiCode === $normalizedOrderCode);
    //             if (!$match && $searchNormalizedOrderCode !== $normalizedOrderCode) {
    //                 $match = ($normalizedApiCode === $searchNormalizedOrderCode);
    //             }

    //             if ($match) {
    //                 $order = $e;
    //                 $order->lot_num = $e->lote ?? null;
    //                 break;
    //             }
    //         }

    //         if (!$order) {
    //             $salida["msg"] = "No se encontró la orden en la API.";
    //             return $salida;
    //         }
    //     } else {
    //         $order->load('materials');
    //     }

    //     // Formatear la fecha aquí
    //     if (isset($order->date)) {
    //         $order->date = Carbon::parse($order->date)->format('Y-m-d H:i:s');
    //     }

    //     // Manejar los materiales correctamente sin modificar indirectamente
    //     $materials = collect($order->materials)->map(function ($material) {
    //         $material = (object)$material; // Asegurar que sea un objeto
    //         if (!isset($material->process) || $material->process === null) {
    //             $material->process = 'Empaque'; // Asignar valor por defecto
    //         }
    //         return $material;
    //     })->all();

    //     $order->materials = $materials;
    //     // ============================
    //     // Obtener lot_num desde mix_orders (buscar por original O por la variante)
    //     // ============================
    //     $mixQuery = MixOrder::where(function ($q) use ($normalizedOrderCode, $searchNormalizedOrderCode) {
    //         $q->whereRaw("REPLACE(num_id, ' ', '') = ?", [$normalizedOrderCode]);
    //         if ($searchNormalizedOrderCode !== $normalizedOrderCode) {
    //             $q->orWhereRaw("REPLACE(num_id, ' ', '') = ?", [$searchNormalizedOrderCode]);
    //         }
    //     })->first();

    //     // Nueva lógica: si existe registro en mix_orders usamos SU lot_num (si está vacío => null).
    //     // NO usamos $validacion->lote como fallback cuando mix_orders no tiene lote.
    //     if ($mixQuery) {
    //         $lotNum = (isset($mixQuery->lot_num) && $mixQuery->lot_num !== '') ? $mixQuery->lot_num : null;
    //     } else {
    //         // Si no existe registro en mix_orders, forzamos null (como pediste).
    //         $lotNum = null;
    //     }

    //     // Sobrescribimos el posible $order->lot_num (provenga de API o DB)
    //     $order->lot_num = $lotNum;

    //     $salida["code"] = 1;
    //     $salida["msg"] = "Processed Successfully";
    //     $salida["data"]["order"] = $order;
    //     return $salida;
    // }

    public function markVerifyLot(Request $request, $id)
    {
        $salida = ["code" => 0, "msg" => "", "data" => null];

        if (!Auth::user()->hasRole("SupCalidad") && !Auth::user()->hasRole("AuxControlCalidad") && !Auth::user()->hasRole("Produccion")) {
            $salida["msg"] = "Operación denegada";
            return $salida;
        }

        $order = Packing::find($id);
        if (!$order) {
            $salida["msg"] = "La orden no fue encontrada";
            return $salida;
        }

        try {
            $userName = Auth::check() ? (Auth::user()->name ?? session('user_cur_fullname')) : session('user_cur_fullname');

            $order->verificacion_lote = 1;
            $order->user_verifico = $userName;

            // 🔹 NUEVO: guardar el número de lote si viene del frontend
            if ($request->has('lot_num')) {
                $order->lot_num = $request->input('lot_num');
            }

            $order->save();
            $order->refresh();

            $salida["code"] = 1;
            $salida["msg"] = "Verificación registrada correctamente";
            $salida["data"] = $order;
            return $salida;
        } catch (\Throwable $ex) {
            \Log::error("Error al marcar verificación de lote (Packing ID {$id}): " . $ex->getMessage());
            $salida["msg"] = "Ocurrió un error al registrar la verificación";
            return $salida;
        }
    }



    // public function search($order_code)
    // {
    //     $salida = [
    //         "code" => 0,
    //         "msg" => "",
    //         "data" => null
    //     ];

    //     if (!Auth::user()->hasRole("Bodega") && !Auth::user()->hasRole("Produccion")) {
    //         $salida["msg"] = "Operación denegada";
    //         return $salida;
    //     }

    //     // Normalizar el código ingresado
    //     $normalizedOrderCode = preg_replace('/\s+/', '', $order_code);

    //     $salida["data"] = ["origin" => "DB", "order" => null];


    //     // ⚠️ Validación tanque previa a todo
    //     $validacion = ValidacionTanque::whereRaw("REPLACE(numero_orden, ' ', '') = ?", [$normalizedOrderCode])
    //                     ->where('estado', 3)
    //                     ->first();

    //     if (!$validacion) {
    //         $salida["msg"] = "Debe completar la validación de tanque antes de acceder a esta orden.";
    //         return $salida;
    //     }
        
    //     $order = Packing::whereRaw("REPLACE(num_id, ' ', '') = ?", [$normalizedOrderCode])->first();

    //     if (!$order) {
    //         $salida["data"]["origin"] = "API";
    //         // $url = "https://192.168.6.26/wsPlantel/empaque.php";
    //         $url = "https://data.industriascuscatlan.com:7322/wsPlantel/empaque.php";

    //         $response = Http::withoutVerifying()->get($url);
    //         $body = $response->body();

    //         \Log::info('API Response (raw): ' . $body);

    //         $cleanBody = preg_replace('/^\xEF\xBB\xBF/', '', $body);
    //         $cleanBody = preg_replace('/[\x00-\x1F\x7F]/u', '', $cleanBody);

    //         $items = json_decode($cleanBody, true);

    //         if (json_last_error() !== JSON_ERROR_NONE || !is_array($items)) {
    //             \Log::error('Error al decodificar JSON: ' . json_last_error_msg());
    //             \Log::error('Cuerpo después de limpiar: ' . $cleanBody);

    //             $cleanBody = preg_replace('/[^[:print:]]/', '', $cleanBody);
    //             $items = json_decode($cleanBody, true);

    //             if (json_last_error() !== JSON_ERROR_NONE || !is_array($items)) {
    //                 \Log::error('Error persistente en decodificación: ' . json_last_error_msg());
    //                 $salida["msg"] = "Error: La API no devolvió resultados válidos.";
    //                 return $salida;
    //             }
    //         }

    //         foreach ($items as $el) {
    //             $e = (object)$el;

    //             // Normalizar el código devuelto por la API
    //             $normalizedApiCode = preg_replace('/\s+/', '', $e->num);

    //             // Comparar códigos normalizados
    //             if ($normalizedApiCode == $normalizedOrderCode) {
    //                 $order = $e;
    //                 $order->lot_num = $e->lote ?? null;
    //                 break;
    //             }
    //         }

    //         if (!$order) {
    //             $salida["msg"] = "No se encontró la orden en la API.";
    //             return $salida;
    //         }
    //     } else {
    //         $order->load('materials');
    //     }

    //     // Formatear la fecha aquí
    //     if (isset($order->date)) {
    //         $order->date = Carbon::parse($order->date)->format('Y-m-d H:i:s');
    //     }

    //     // Manejar los materiales correctamente sin modificar indirectamente
    //     $materials = collect($order->materials)->map(function ($material) {
    //         $material = (object)$material; // Asegurar que sea un objeto
    //         if (!isset($material->process) || $material->process === null) {
    //             $material->process = 'Empaque'; // Asignar valor por defecto
    //         }
    //         return $material;
    //     })->all(); // Convertir de vuelta a arreglo si es necesario

    //     $order->materials = $materials; // Reasignar los materiales procesados
    //     // ✅ Agregar el número de lote de ValidacionTanque
    //     $order->lot_num = $validacion->lote ?? null;

    //     $salida["code"] = 1;
    //     $salida["msg"] = "Processed Successfully";
    //     $salida["data"]["order"] = $order;
    //     return $salida;
    // }

    public function finish(Request $request,$id){
        $salida = [
            "code" => 0,
            "msg" => "",
            "data" => null
        ];

        if (!Auth::user()->hasRole("Produccion")) {
            $salida["msg"] = "Operación denegada";
            return $salida;
        }

        $validator = Validator::make($request->all(),[
            "performance_teorico" => "required",
            // "performance" => "required"
        ]);

        if($validator->fails()){
            $salida["msg"] = "Inconsistencia de campos requeridos";
            return $salida;
        }

        $order = null;
        $order = Packing::find($id);

        if(!$order){
            $salida["msg"] = "No se encontro la orden";
            return $salida;
        }

        if($order->status != 3){
            $salida["msg"] = "Inconsistencia de estado";
            return $salida;
        }

        $order->performance_teorico = $request->performance_teorico;
        // $order->performance = $request->performance;
        $order->observations = $request->observations;
        // $order->user_recibe = session('user_cur_fullname');
        $order->status = 4;

        if(!$order->save()){
            $salida["msg"] = "Ocurrio un problema al guardar la orden";
            return $salida;
        }

        $order->refresh();
        $order->load('materials');

        $salida["code"] = 1;
        $salida["msg"] = "Processed Successfully";
        $salida["data"] = $order;

        return $salida;
    }

   

    // public function tracking(Request $request, $id) {
    //     $salida = [
    //         "code" => 0,
    //         "msg" => "",
    //         "data" => null
    //     ];

    //     if (!Auth::user()->hasRole("Produccion")) {
    //         $salida["msg"] = "Operación denegada";
    //         return $salida;
    //     }

    //     $validator = Validator::make($request->all(), [
    //         "times" => "required|json",
    //         "operarios" => "required|json",
    //         "entregas" => "required|json"
    //     ]);

    //     if ($validator->fails()) {
    //         $salida["msg"] = "Inconsistencia de campos requeridos";
    //         return $salida;
    //     }

    //     $order = Packing::find($id);

    //     if (!$order) {
    //         $salida["msg"] = "No se encontró la orden";
    //         return $salida;
    //     }

    //     if ($order->status != 3) {
    //         $salida["msg"] = "Inconsistencia de estado";
    //         return $salida;
    //     }

    //     // 🔹 Decodificar como arreglos asociativos
    //     $times = json_decode($request->times, true);
    //     $operarios = json_decode($request->operarios, true);
    //     $entregas = json_decode($request->entregas, true);

    //     // 🔹 Sincronizar fechas de finalización (date_end) con las fechas de operarios (operarios.date)
    //     if (is_array($operarios) && is_array($times)) {
    //         foreach ($operarios as $index => $operario) {
    //             if (!empty($operario['date']) && isset($times[$index])) {
    //                 $times[$index]['date_end'] = $operario['date'];
    //             }
    //         }
    //     }

    //     // 🔹 Verificar si hay al menos un inicio para firmar user_recibe
    //     $validStart = collect($times)->contains(function ($t) {
    //         return isset($t['date_init'], $t['time_init']) && !empty($t['date_init']) && !empty($t['time_init']);
    //     });

    //     if ($validStart && !$order->user_recibe) {
    //         $order->user_recibe = session('user_cur_fullname');
    //     }

    //     // 🔹 Firmar entregas si corresponde
    //     foreach ($entregas as &$entrega) {
    //         if (
    //             isset($entrega['date'], $entrega['cantidad'], $entrega['entrega']) &&
    //             !empty($entrega['date']) &&
    //             !empty($entrega['cantidad']) &&
    //             !empty($entrega['entrega']) &&
    //             (empty($entrega['recibe']) || $entrega['recibe'] === null)
    //         ) {
    //             $entrega['recibe'] = session('user_cur_fullname');
    //         }
    //     }

    //     // 🔹 Asignar valores actualizados al modelo
    //     $order->times = json_encode($times); // guardando times sincronizados
    //     $order->operarios = $request->operarios;
    //     $order->entregas = json_encode($entregas); // guardando entregas firmadas

    //     if ($request->performance_teorico != null) {
    //         $order->performance_teorico = $request->performance_teorico;
    //     }

    //     if ($request->performance != null) {
    //         $order->performance = $request->performance;
    //     }

    //     if ($request->observations != null) {
    //         $order->observations = $request->observations;
    //     }

    //     if (!$order->save()) {
    //         $salida["msg"] = "Ocurrió un problema al guardar la orden";
    //         return $salida;
    //     }

    //     $order->refresh();
    //     $order->load('materials');

    //     $salida["code"] = 1;
    //     $salida["msg"] = "Processed Successfully";
    //     $salida["data"] = $order;

    //     return $salida;
    // }


    public function searchDB(Request $request, $code)
    {
        $salida = [
            "code" => 0,
            "msg" => "",
            "data" => null
        ];

        if (!Auth::user()->hasRole("SupCalidad") && !Auth::user()->hasRole("Produccion") && !Auth::user()->hasRole("AuxControlCalidad")) {
            $salida["msg"] = "Operación denegada";
            return $salida;
        }

        // Normalizar el código ingresado (quitar espacios)
        $normalizedOrderCode = preg_replace('/\s+/', '', $code);

        // Buscar en registros locales
        $order = Packing::whereRaw("REPLACE(num_id, ' ', '') = ?", [$normalizedOrderCode])->first();

        if (!$order) {
            $salida["msg"] = "La orden no fue encontrada";
            return $salida;
        }

        $order->load('materials');

        // ============================
        // Obtener lot_num desde mix_orders con validación de estado de Packing
        // ============================
        
        // Buscar en mix_orders - SIEMPRE buscar con -20 (transformar -10 a -20)
        $mixOrderSearchCode = $normalizedOrderCode;
        if (preg_match('/-10$/', $normalizedOrderCode)) {
            $mixOrderSearchCode = preg_replace('/-10$/', '-20', $normalizedOrderCode);
        }
        
        \Log::info("🔍 [searchDB] Buscando en mix_orders con código: {$mixOrderSearchCode}");
        
        $mixQuery = MixOrder::whereRaw("REPLACE(REPLACE(num_id, ' ', ''), ' - ', '-') = ?", [$mixOrderSearchCode])->first();
        
        \Log::info("📦 [searchDB] Mix Order encontrada: " . ($mixQuery ? "SÍ (lot_num: " . ($mixQuery->lot_num ?? 'NULL') . ")" : "NO"));
        \Log::info("📋 [searchDB] Status de la orden: " . $order->status);
        \Log::info("   [searchDB] Lot_num actual: " . ($order->lot_num ?? 'NULL'));

        // Validar si la orden de PACKING tiene status 2 y lot_num vacío
        if ($order->status == 2) {
            // Verificar si lot_num en la orden de packing está vacío
            $packingLotEmpty = !isset($order->lot_num) || $order->lot_num === '' || $order->lot_num === null;
            
            \Log::info("✅ [searchDB] Orden tiene status 2. Lot_num vacío: " . ($packingLotEmpty ? "SÍ" : "NO"));
            
            if ($packingLotEmpty) {
                // Buscar en mix_orders
                if ($mixQuery && isset($mixQuery->lot_num) && $mixQuery->lot_num !== '') {
                    $lotNum = $mixQuery->lot_num;
                    \Log::info("✅ [searchDB] Asignando lot_num de mix_orders: {$lotNum}");
                } else {
                    // Si no existe en mix_orders, está pendiente de recibir
                    $lotNum = 'Pendiente de recibir';
                    \Log::info("⚠️ [searchDB] No hay lot_num en mix_orders, asignando: Pendiente de recibir");
                }
            } else {
                // Si ya tiene lot_num en packing, mantenerlo
                $lotNum = $order->lot_num;
                \Log::info("ℹ️ [searchDB] Manteniendo lot_num existente: {$lotNum}");
            }
            
            // Sobrescribir el lot_num
            $order->lot_num = $lotNum;
            \Log::info("🎯 [searchDB] Lot_num final asignado: " . ($lotNum ?? 'NULL'));
        }

        $salida["code"] = 1;
        $salida["msg"] = "Processed Successfully";
        $salida["data"] = $order;
        return $salida;
    }

    public function authorizeOrder(Request $request,$id){
        $salida = [
            "code" => 0,
            "msg" => "",
            "data" => null
        ];

        if(!Auth::user()->hasRole("AuxControlCalidad")){
            $salida["msg"] = "Operación denegada";
            return $salida;
        }

        $validator = Validator::make($request->all(),[
            "lot_num" => "required|string|min: 0"
        ]);

        if($validator->fails()){
            $salida["msg"] = "Inconsistencia de campos requeridos";
            return $salida;
        }

        $order = Packing::find($id);
        if(!$order){
            $salida["msg"] = "La orden no fue encontrada";
            return $salida;
        }

        if($order->status != 2){
            $salida["msg"] = "Inconsistencia de estado";
            return $salida;
        }

        $order->status = 3;
        $order->user_autoriza = session('user_cur_fullname');
        $order->lot_num = $request->lot_num;

        if(!$order->save()){
            $salida["msg"] = "Ocurrio un problema en la aprobacion";
            return $salida;
        }

        $order->refresh();
        $order->load('materials');

        $salida["code"] = 1;
        $salida["msg"] = "Processed Successfully";
        $salida["data"] = $order;

        return $salida;
    }


    // public function saveOrUpdate(Request $request){
    //     $salida = [
    //         "code" => 0,
    //         "msg" => "",
    //         "data" => null
    //     ];

    //     if (!Auth::user()->hasRole("Bodega") && !Auth::user()->hasRole("SupCalidad") &&
    //         !Auth::user()->hasRole("Produccion") && !Auth::user()->hasRole("AuxControlCalidad")) {
    //         $salida["msg"] = "Operación denegada";
    //         return $salida;
    //     }

    //     $validator = Validator::make($request->all(), [
    //         "date" => "required|date",
    //         "num_id" => "required|string",
    //         "product_code" => "required",
    //         "product_name" => "required",
    //         "lot_size" => "required|numeric",
    //         "total_units" => "required|numeric|min:0",
    //     ]);

    //     if ($validator->fails()) {
    //         $salida["msg"] = "Error en validación de campos (" . $validator->errors()->first() . ")";
    //         return $salida;
    //     }

    //     DB::beginTransaction();
    //     try {
    //         $order = null;
    //         if ($request->order_id != 0) {
    //             $order = Packing::find($request->order_id);
    //             if ($order == null) {
    //                 throw new \Exception("Inconsistencia en recuperar orden");
    //             }
    //         } else {
    //             $order = new Packing();
    //         }

    //         $materials_count = count($request->materials);

    //         $order->order_date = $request->date;
    //         $order->num_id = preg_replace('/\s+/', '', $request->num_id);
    //         $order->product_code = $request->product_code;
    //         $order->product_name = $request->product_name;
    //         $order->lot_num = $request->lot_num;
    //         $order->lot_size = $request->lot_size;
    //         $order->total_units = $request->total_units;
    //         $order->materials = $materials_count;
    //         $order->observations = $request->observations;

    //         if (Auth::user()->hasRole("Bodega")) {
    //             $order->user_entrega = session('user_cur_fullname');
    //         }

    //         // Decodificar times para revisar si se debe firmar automáticamente
    //         $times = json_decode(json_encode($request->times), true); // asegurar que sea arreglo
    //         $validStart = collect($times)->contains(function ($t) {
    //             return isset($t['date_init'], $t['time_init']) && !empty($t['date_init']) && !empty($t['time_init']);
    //         });

    //         if ($validStart && !$order->user_recibe) {
    //             $order->user_recibe = session('user_cur_fullname');
    //         }

    //         $order->status = 2; // pendiente de aprobación
    //         $order->times = json_encode($request->times);
    //         $order->operarios = json_encode($request->operarios);
    //         $order->entregas = json_encode($request->entregas);
    //         $order->save();

    //         $material_passed = 0;
    //         while ($material_passed < $materials_count) {
    //             $target = (object)$request->materials[$material_passed];
    //             if ($target->material_id != 0) {
    //                 $mats = EmpaqueMaterial::find($target->material_id);
    //                 if ($mats == null) {
    //                     throw new \Exception("Inconsistencia recuperar materiales");
    //                 }
    //             } else {
    //                 $mats = new EmpaqueMaterial();
    //             }

    //             $order->num_id = preg_replace('/\s+/', '', $request->num_id);

    //             $mats->code = $target->code;
    //             $mats->description = $target->description;
    //             $mats->process = $target->process;
    //             $mats->required_amount = $target->required_amount;
    //             $mats->unit = $target->unit;
    //             $mats->stock = $target->stock;
    //             $mats->almacen = $target->almacen; // Asegurando que almacen se guarde
    //             $mats->lot1 = $target->lot1;
    //             $mats->entrega1 = $target->entrega1;
    //             $mats->entrega2 = $target->entrega2;
    //             $mats->return = $target->return;
    //             $mats->packing_id = $order->id;
    //             $mats->save();
    //             $material_passed++;
    //         }

    //         $order->refresh();
    //         DB::commit();
    //         $salida["code"] = 1;
    //         $salida["msg"] = "Processed Successfully";
    //         $salida["data"] = $order->load('materials');

    //     } catch (\Exception $ex) {
    //         DB::rollback();
    //         $salida["msg"] = "Error en la operación, consulte soporte técnico.\n" . $ex->getMessage();
    //     }

    //     return $salida;
    // }


}
