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

        if (!Auth::user()->hasRole("Bodega") && !Auth::user()->hasRole("Bodega PT") && !Auth::user()->hasRole("Produccion")) {
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

        // 🛑 (Opcional) Bloquear si hay una reconexión en curso — Comentado para permitir carga en Empaque
        /*
        if ($validacion->reconexion_estado > 0 && $validacion->reconexion_estado < 3) {
            $salida["msg"] = "Hay una reconexión a tanque en proceso de autorización. Debe completarse antes de acceder a la orden.";
            return $salida;
        }
        */

        // Buscar la orden en Packing usando cualquiera de las dos variantes
        $order = Packing::where(function ($q) use ($normalizedOrderCode, $searchNormalizedOrderCode) {
                    $q->whereRaw("REPLACE(num_id, ' ', '') = ?", [$normalizedOrderCode]);
                    if ($searchNormalizedOrderCode !== $normalizedOrderCode) {
                        $q->orWhereRaw("REPLACE(num_id, ' ', '') = ?", [$searchNormalizedOrderCode]);
                    }
                })->first();

        if ($order) {
            $order->load('empaqueMaterials');
            \Log::info("DB Order found. ID: {$order->id}, Materials count: " . $order->empaqueMaterials->count());
        }

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
            $order->load('empaqueMaterials');
        }

        // Formatear la fecha aquí
        if (isset($order->date)) {
            $order->date = Carbon::parse($order->date)->format('Y-m-d H:i:s');
        }

        // 🎯 Sincronizar LOTE desde Validación Tanque si está autorizado
        // Prioridad: Reconexión Autorizada > Validación Inicial Autorizada > Valor actual (API/Mix)
        if ($validacion) {
            if ($validacion->reconexion_estado == 3 && !empty($validacion->reconexion_lote)) {
                $order->lot_num = $validacion->reconexion_lote;
            } elseif ($validacion->estado == 3 && !empty($validacion->lote)) {
                $order->lot_num = $validacion->lote;
            }
        }

        // Manejar los materiales correctamente sin modificar indirectamente
        // Si $order->empaqueMaterials es una colección Eloquent, la convertimos a array primero
        $rawMaterials = $order->empaqueMaterials ?? $order->materials ?? [];
        if ($rawMaterials instanceof \Illuminate\Support\Collection) {
            $rawMaterials = $rawMaterials->all();
        }

        $materials = collect($rawMaterials)->map(function ($material) {
            // Si es un modelo, convertir a array primero para asegurar acceso limpio
            if ($material instanceof \Illuminate\Database\Eloquent\Model) {
                $material = $material->toArray();
            }
            
            $material = (object)$material; // Asegurar que sea un objeto stdClass

            if (!isset($material->process) || $material->process === null) {
                $material->process = 'Empaque'; // Asignar valor por defecto
            }

            // Si viene de la API, el campo se llama 'tipo_prod' según el ejemplo.
            // Si viene de la DB local, ahora también se llama 'tipo_prod'.
            if (!isset($material->tipo_prod) && isset($material->tipo_prod)) {
                 // Esto es redundante pero asegura que el objeto stdClass lo tenga
            }
            
            return $material;
        })->values()->all();

        // -----------------------------------------------------------
        // 🔍 Lógica para buscar Orden de Mezcla y asignar real_performance + lote
        // -----------------------------------------------------------
        
        // 1. Calcular código de mezcla (-10 -> -20)
        $mixOrderCode = null;
        if (preg_match('/-10$/', $normalizedOrderCode)) {
            $mixOrderCode = preg_replace('/-10$/', '-20', $normalizedOrderCode);
        }

        if ($mixOrderCode) {
            \Log::info("Buscando MixOrder variante: {$mixOrderCode} (Original: {$normalizedOrderCode})");
            
            $mixOrder = MixOrder::whereRaw("REPLACE(num_id, ' ', '') = ?", [$mixOrderCode])->first();
            
            if ($mixOrder) {
                // Siempre asignar el lote de la orden de mezcla al registro principal de la orden de empaque actual
                $order->lot_num = $mixOrder->lot_num ?? null;

                \Log::info("MixOrder encontrada. ID: {$mixOrder->id}, RealPerformance: " . ($mixOrder->real_performance ?? 'NULL'));
                
                // Asignar el lote del bulk y el rendimiento real al material COSTEO
                foreach ($materials as $key => $mat) {
                    $processDB = strtoupper($mat->process ?? '');
                    $processAPI = strtoupper($mat->proceso ?? '');

                    if ($processDB === 'COSTEO' || $processAPI === 'COSTEO') {
                        // Asignamos el lote de la orden de mezcla en lote 1 del material (Columna LOTE)
                        if (!empty($mixOrder->lot_num)) {
                            \Log::info("Asignando lot_num {$mixOrder->lot_num} a material index {$key} (COSTEO) en lot1");
                            $materials[$key]->lot1 = $mixOrder->lot_num;
                        }

                        // Asignar rendimiento en primera entrega
                        if (!empty($mixOrder->real_performance)) {
                            $realPerformance = $mixOrder->real_performance;
                            \Log::info("Asignando real_performance {$realPerformance} a material index {$key} (COSTEO) en entrega1");
                            $materials[$key]->entrega1 = $realPerformance;
                        }
                        break; 
                    }
                }
            } else {
                \Log::warning("MixOrder NO encontrada para código: {$mixOrderCode}");
            }
        }
        // -----------------------------------------------------------

        // Asignar materiales modificados al objeto/modelo como propiedad dinámica 'materials'
        // (para mantener compatibilidad con el frontend que espera 'materials')
        $order->materials = $materials;

        // 🔧 FIX: Si es un modelo Eloquent, sobrescribir la relación cargada
        if ($order instanceof \Illuminate\Database\Eloquent\Model) {
            $order->setRelation('empaqueMaterials', collect($materials)->values());
        }

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
            !Auth::user()->hasRole("Produccion") && !Auth::user()->hasRole("AuxControlCalidad") &&
            !Auth::user()->hasRole("Bodega PT")) {
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
            if ($request->filled('observations')) {
                $order->observations = $this->syncPackingBitacora(
                    $order->observations,
                    (string)$request->observations
                );
            }
            // $order->observations = $request->observations;

            // if (Auth::user()->hasRole("Bodega")) {
            //     $order->user_entrega = session('user_cur_fullname');
            // }

            // Decodificar times para revisar si se debe firmar automáticamente
            $times = json_decode(json_encode($request->times), true);
            $validStart = collect($times)->contains(function ($t) {
                return isset($t['date_init'], $t['time_init']) && !empty($t['date_init']) && !empty($t['time_init']);
            });

            // if ($validStart && !$order->user_recibe) {
            //     $order->user_recibe = session('user_cur_fullname');
            // }

            // Solo cambiar a status 2 si la orden no está ya en un estado avanzado (3=autorizada, 4=finalizada)
            if ($order->status < 3) {
                $order->status = 2; // pendiente de aprobación
            }

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
                $mats->tipo_prod = $target->tipo_prod ?? null;
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
            $salida["data"] = $order->load('empaqueMaterials');

        } catch (\Exception $ex) {
            DB::rollback();
            $salida["msg"] = "Error en la operación, consulte soporte técnico.\n" . $ex->getMessage();
        }

        return $salida;
    }

    private function extractBitacoraMessage(string $line): string
{
    $line = trim($line);
    if ($line === '') return '';

    // Si ya viene formateado: "ROL - Nombre (YYYY-MM-DD HH:MM:SS): Mensaje"
    // extraemos solo el mensaje para evitar "doble prefijo"
    if (preg_match('/^\s*.+\(\d{4}-\d{2}-\d{2}\s+\d{2}:\d{2}:\d{2}\)\s*:\s*(.+)\s*$/', $line, $m)) {
        return trim($m[1]);
    }

    // Si viene sin formato, lo tomamos tal cual como mensaje
    return $line;
}

    private function syncPackingBitacora(?string $existing, string $incomingFullText): string
    {
        $existing = str_replace("\r\n", "\n", trim((string)$existing));
        $incomingFullText = str_replace("\r\n", "\n", trim($incomingFullText));

        $existingLines = $existing !== '' ? preg_split('/\n+/', $existing) : [];
        $existingLines = array_values(array_filter(array_map('trim', $existingLines), fn($l) => $l !== ''));

        $incomingLines = $incomingFullText !== '' ? preg_split('/\n+/', $incomingFullText) : [];
        $incomingLines = array_values(array_filter(array_map('trim', $incomingLines), fn($l) => $l !== ''));

        $result = [];
        $max = count($incomingLines);

        for ($i = 0; $i < $max; $i++) {
            $newMsg = $this->extractBitacoraMessage($incomingLines[$i]);
            if ($newMsg === '') continue;

            if (isset($existingLines[$i])) {
                $oldMsg = $this->extractBitacoraMessage($existingLines[$i]);

                // Si el texto no cambió, mantener la línea original (misma fecha/autor)
                if ($newMsg === $oldMsg) {
                    $result[] = $existingLines[$i];
                } else {
                    // Si cambió, reescribir SOLO esa línea con nuevo rol/fecha
                    $result[] = $this->formatBitacoraLine($newMsg);
                }
            } else {
                // Línea nueva agregada al final
                $result[] = $this->formatBitacoraLine($newMsg);
            }
        }

        // Si el usuario borró líneas, aquí se respeta (no se re-agregan).
        return implode("\n", $result);
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
            "entregas" => "required|json",
            "materials" => "nullable|json"
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
            
            // 🔹 NOTA: El campo 'recibe' es para cantidades numéricas (cajas/unidades)
            // NO debe ser firmado automáticamente con nombres de usuario
            // Se eliminó la lógica de firma automática que causaba confusión de datos
        }

        // Verificar si hay al menos un inicio para firmar user_recibe
        $validStart = collect($existingTimes)->contains(function ($t) {
            return isset($t['date_init'], $t['time_init']) && 
                !empty($t['date_init']) && 
                !empty($t['time_init']);
        });

        // if ($validStart && !$order->user_recibe) {
        //     $order->user_recibe = session('user_cur_fullname');
        // }

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

        if ($request->filled('observations')) {
            $order->observations = $this->syncPackingBitacora(
                $order->observations,
                (string)$request->observations
            );
        }

        // ========================================
        // 🔹 ACTUALIZAR MATERIALES (incluyendo Devoluciones)
        // ========================================
        if ($request->filled('materials')) {
            $materials = json_decode($request->materials, true);
            if (is_array($materials)) {
                foreach ($materials as $target) {
                    $target = (object)$target;
                    // Solo actualizar si existe el material_id
                    if (isset($target->material_id) && $target->material_id != 0) {
                        $mats = \App\EmpaqueMaterial::find($target->material_id);
                        if ($mats) {
                            // Actualizar solo los campos que Producción puede modificar o que vienen del frontend
                            $mats->lot1 = $target->lot1 ?? $mats->lot1;
                            $mats->entrega1 = $target->entrega1 ?? $mats->entrega1;
                            $mats->entrega2 = $target->entrega2 ?? $mats->entrega2;
                            $mats->return = $target->return ?? $mats->return;
                            $mats->tipo_prod = $target->tipo_prod ?? $mats->tipo_prod;
                            $mats->save();
                        }
                    }
                }
            }
        }

        if (!$order->save()) {
            $salida["msg"] = "Ocurrió un problema al guardar la orden";
            return $salida;
        }

        $order->refresh();
        $order->load('empaqueMaterials');

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


    private function currentUserLabel(): string
    {
        $name = session('user_cur_fullname') ?? (Auth::user()->name ?? 'N/D');

        $role = 'N/A';
        if (Auth::check()) {
            // Si usas Spatie:
            // getRoleNames() devuelve colección; tomamos el primero
            $roles = method_exists(Auth::user(), 'getRoleNames') ? Auth::user()->getRoleNames() : [];
            if (!empty($roles) && isset($roles[0])) {
                $role = (string)$roles[0];
            } elseif (method_exists(Auth::user(), 'roles') && Auth::user()->roles()->exists()) {
                $role = (string) optional(Auth::user()->roles()->first())->name ?: 'N/D';
            }
        }

        return "{$role} - {$name}";
    }

    private function appendPackingBitacora(?string $existing, array $texts): string
{
    $existing = str_replace("\r\n", "\n", trim((string)$existing));

    // Convertir textos a líneas con formato Rol-Nombre(fecha): texto
    $newLines = [];
    foreach ($texts as $t) {
        $line = $this->formatBitacoraLine((string)$t);
        if ($line !== '') $newLines[] = $line;
    }

    if (count($newLines) === 0) return $existing;

    // líneas existentes
    $lines = [];
    if ($existing !== '') {
        $lines = preg_split('/\n+/', $existing);
        $lines = array_values(array_filter(array_map('trim', $lines), fn($l) => $l !== ''));
    }

    // No duplicar EXACTO (misma línea completa)
    foreach ($newLines as $l) {
        if (!in_array($l, $lines, true)) {
            $lines[] = $l;
        }
    }

    return implode("\n", $lines);
}


    private function formatBitacoraLine(string $text): string
    {
        $text = trim($text);
        if ($text === '') return '';

        $userLabel = $this->currentUserLabel();
        $now = now('America/El_Salvador')->format('Y-m-d H:i:s');

        return "{$userLabel} ({$now}): {$text}";
    }

   

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
        // $order->observations = $request->observations;
        if ($request->filled('observations')) {
            $order->observations = $this->appendPackingBitacora(
                $order->observations,
                [(string)$request->observations]
            );
        }

        // $order->user_recibe = session('user_cur_fullname');
        $order->status = 4;

        if(!$order->save()){
            $salida["msg"] = "Ocurrio un problema al guardar la orden";
            return $salida;
        }

        $order->refresh();
        $order->load('empaqueMaterials');

        $salida["code"] = 1;
        $salida["msg"] = "Processed Successfully";
        $salida["data"] = $order;

        return $salida;
    }

    public function searchDB(Request $request, $code)
    {
        $salida = [
            "code" => 0,
            "msg" => "",
            "data" => null
        ];

        if (!Auth::user()->hasRole("SupCalidad") && !Auth::user()->hasRole("Produccion") && !Auth::user()->hasRole("AuxControlCalidad") && !Auth::user()->hasRole("Bodega PT")) {
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

        $order->load('empaqueMaterials');

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
        if ($order->status == 2 || $order->status == 3) {
            $lotNum = $order->lot_num; // Valor por defecto
            
            // Prioridad 1: Siempre tomamos el número de lote de la orden de mezcla si existe
            if ($mixQuery && !empty($mixQuery->lot_num)) {
                $lotNum = $mixQuery->lot_num;
                \Log::info("✅ [searchDB] Asignando lot_num de MixOrder: {$lotNum}");
            } else {
                // 🎯 Prioridad 2: Sincronizar LOTE desde Validación Tanque si hay uno autorizado y NO hay mix
                $vt = ValidacionTanque::whereRaw("REPLACE(numero_orden, ' ', '') = ?", [$normalizedOrderCode])->first();
                if ($vt) {
                    if ($vt->reconexion_estado == 3 && !empty($vt->reconexion_lote)) {
                        $lotNum = $vt->reconexion_lote;
                        \Log::info("✅ [searchDB] Asignando lot_num de reconexión autorizada: {$lotNum}");
                    } elseif ($vt->estado == 3 && !empty($vt->lote)) {
                        if (empty($order->lot_num) || $order->lot_num === 'Pendiente de recibir') {
                             $lotNum = $vt->lote;
                             \Log::info("✅ [searchDB] Asignando lot_num de validación inicial: {$lotNum}");
                        }
                    }
                }
            }

            // Sobrescribir el lot_num
            $order->lot_num = $lotNum;
            \Log::info("🎯 [searchDB] Lot_num final asignado: " . ($lotNum ?? 'NULL'));
        }

        // -----------------------------------------------------------
        // 🔍 Asignar real_performance y lote de MixOrder a entrega1 / lot1 si aplica
        // -----------------------------------------------------------
        if ($mixQuery) {
            $realPerformance = $mixQuery->real_performance;
            $mixLotNum = $mixQuery->lot_num;
            
            // Recorrer los materiales recién cargados
            foreach ($order->empaqueMaterials as $mat) {
                $processDB = strtoupper($mat->process ?? '');
                
                if ($processDB === 'COSTEO') {
                    // Asignar lote a lot1 (LOTE COLUMN)
                    if (!empty($mixLotNum)) {
                        if (empty($mat->lot1) || $order->status < 4) {
                            $mat->lot1 = $mixLotNum;
                            \Log::info("✅ [searchDB] Inyectando lot_num ({$mixLotNum}) en lot1 de material ID: {$mat->id}");
                        }
                    }

                    // Asignar performance a entrega1 (PRIMERA ENTREGA)
                    if (!empty($realPerformance)) {
                        if (empty($mat->entrega1) || $order->status < 4) {
                            $mat->entrega1 = $realPerformance;
                            \Log::info("✅ [searchDB] Inyectando real_performance ({$realPerformance}) en entrega1 de material ID: {$mat->id}");
                        }
                    }
                }
            }
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
        $order->load('empaqueMaterials');

        $salida["code"] = 1;
        $salida["msg"] = "Processed Successfully";
        $salida["data"] = $order;

        return $salida;
    }



    public function signOrder(Request $request, $id) {
        $salida = [
            "code" => 0,
            "msg" => "",
            "data" => null
        ];

        try {
            $order = Packing::find($id);
            if (!$order) {
                $salida["msg"] = "Orden no encontrada";
                return $salida;
            }

            $type = $request->input('type'); // 'entrega' or 'recibe'
            $user_fullname = session('user_cur_fullname');

            if ($type === 'entrega') {
                $order->user_entrega = $user_fullname;
            } elseif ($type === 'recibe') {
                $order->user_recibe = $user_fullname;
            } else {
                $salida["msg"] = "Tipo de firma no valido";
                return $salida;
            }

            $order->save();
            $order->refresh();

            $salida["code"] = 1;
            $salida["msg"] = "Firmado correctamente";
            $salida["data"] = $order;

        } catch (\Exception $ex) {
            $salida["msg"] = "Error: " . $ex->getMessage();
        }

        return $salida;
    }
}
