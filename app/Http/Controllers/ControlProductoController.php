<?php

namespace App\Http\Controllers;

use App\ControlProducto;
use App\MixOrder;
use App\ResultadoAnalisisAgua;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class ControlProductoController extends Controller
{


    protected function getCurrentUserName()
    {
        return session('user_cur_fullname') ?? Auth::user()->name ?? 'sistema';
    }

    protected function getCurrentUserRole()
    {
        // Prioridad: 1. Rol alternativo (Sesión/BD), 2. Sesión manual, 3. Primer rol de Spatie, 4. Fallback
        return $this->getRolAlternativo() 
            ?? session('role_cur_user') 
            ?? Auth::user()->getRoleNames()->first() 
            ?? 'desconocido';
    }

    protected function getRolAlternativo()
    {
        // Check session first, then fresh DB data
        return session('rol_alternativo') 
            ?: (\App\User::find(Auth::id())->rol_alternativo ?? null);
    }

    /**
     * Obtener análisis de agua con lógica de fallback en cascada
     * Prioridad: 1) mix_orders.analisis_agua, 2) control_producto, 3) resultado_analisis_agua
     */
    protected function getAnalisisAguaConFallback($numero_orden, $mixOrder = null)
    {
        // Normalizar número de orden
        $normalized = preg_replace('/\s+/', '', $numero_orden);
        
        // 1. Intentar obtener de mix_orders.analisis_agua
        if ($mixOrder && !empty($mixOrder->analisis_agua) && is_array($mixOrder->analisis_agua)) {
            Log::info("Análisis de agua obtenido de mix_orders.analisis_agua");
            return $mixOrder->analisis_agua;
        }
        
        // 2. Intentar obtener de control_producto
        $controlProducto = ControlProducto::whereRaw("REPLACE(numero_orden, ' ', '') = ?", [$normalized])->first();
        
        if ($controlProducto && 
            (!empty($controlProducto->ph_agua) || 
             !empty($controlProducto->conductividad_agua) || 
             !empty($controlProducto->cloro_libre_agua))) {
            
            Log::info("Análisis de agua obtenido de control_producto");
            return [
                'ph' => $controlProducto->ph_agua,
                'conductividad' => $controlProducto->conductividad_agua,
                'cloro_libre' => $controlProducto->cloro_libre_agua,
                'origen' => 'control_producto'
            ];
        }
        
        // 3. Intentar obtener de resultado_analisis_agua (registro activo más reciente)
        $resultadoAgua = ResultadoAnalisisAgua::where('estado', 1)
            ->orderBy('fecha_registro', 'desc')
            ->first();
        
        if ($resultadoAgua) {
            Log::info("Análisis de agua obtenido de resultado_analisis_agua");
            return [
                'ph' => $resultadoAgua->resultado_ph,
                'conductividad' => $resultadoAgua->resultado_conductividad,
                'cloro_libre' => $resultadoAgua->resultado_cloro_libre,
                'observaciones' => $resultadoAgua->observaciones,
                'fecha_registro' => $resultadoAgua->fecha_registro,
                'origen' => 'resultado_analisis_agua'
            ];
        }
        
        // Si no se encuentra en ninguna fuente, retornar null
        Log::warning("No se encontró análisis de agua para la orden: {$numero_orden}");
        return null;
    }

   // Verificar existencia de orden y devolver datos si existe
   public function verificarExistenciaBD($numero_orden)
    {
        $normalized = preg_replace('/\s+/', '', $numero_orden);

        // 1. Buscar en BD
        $producto = ControlProducto::whereRaw("REPLACE(numero_orden, ' ', '') = ?", [$normalized])->first();

        if ($producto) {
            return response()->json([
                'existe' => true,
                'origen' => 'BD',
                'producto' => $producto
            ]);
        }

        // 2. Si no existe en control_producto, buscar en mix_orders
        $mixOrder = MixOrder::whereRaw("REPLACE(num_id, ' ', '') = ?", [$normalized])->first();
        
        if ($mixOrder) {
            Log::info("Orden encontrada en mix_orders: ".json_encode($mixOrder));
            
            // 🔹 Validar si las especificaciones están vacías y buscarlas en el web service
            if (empty($mixOrder->especificaciones_ph) || 
                empty($mixOrder->especificaciones_viscosidad) || 
                empty($mixOrder->especificaciones_densidad)) {
                
                Log::info("Especificaciones vacías, buscando en web service...");
                
                try {
                    $url = "https://data.industriascuscatlan.com:7322/wsPlantel/mezcla.php";
                    $response = Http::withoutVerifying()->timeout(60)->get($url);
                    
                    if ($response->successful()) {
                        $body = $response->body();
                        
                        // Limpiar BOM y caracteres no imprimibles
                        if (substr($body, 0, 3) == pack('CCC', 0xEF, 0xBB, 0xBF)) {
                            $body = substr($body, 3);
                        }
                        $body = preg_replace('/[^\x20-\x7E]/', '', $body);
                        
                        $items = json_decode($body, true);
                        
                        if (json_last_error() === JSON_ERROR_NONE && is_array($items)) {
                            // Buscar la orden en el web service
                            foreach ($items as $el) {
                                $e = (object)$el;
                                $ordenApi = preg_replace('/\s+/', '', $e->num ?? '');
                                
                                if ($ordenApi === $normalized) {
                                    // Actualizar las especificaciones en mix_orders
                                    $mixOrder->especificaciones_ph = $e->especificaciones_ph ?? null;
                                    $mixOrder->especificaciones_viscosidad = $e->especificaciones_viscosidad ?? null;
                                    $mixOrder->especificaciones_densidad = $e->especificaciones_densidad ?? null;
                                    $mixOrder->save();
                                    
                                    Log::info("Especificaciones actualizadas desde web service");
                                    break;
                                }
                            }
                        }
                    }
                } catch (\Exception $e) {
                    Log::error("Error al buscar especificaciones en web service: " . $e->getMessage());
                    // Continuar sin especificaciones si falla
                }
            }
            
            // Obtener análisis de agua con lógica de fallback
            $analisisAgua = $this->getAnalisisAguaConFallback($numero_orden, $mixOrder);
            
            // Preparar la respuesta con los datos de la orden y el análisis de agua
            $ordenData = [
                'num_id' => $mixOrder->num_id,
                'product_code' => $mixOrder->product_code,
                'product_name' => $mixOrder->product_name,
                'lot_size' => $mixOrder->lot_size,
                'order_date' => $mixOrder->order_date,
                'analisis_agua' => $analisisAgua, // Obtenido con lógica de fallback
                'especificaciones_ph' => $mixOrder->especificaciones_ph,
                'especificaciones_viscosidad' => $mixOrder->especificaciones_viscosidad,
                'especificaciones_densidad' => $mixOrder->especificaciones_densidad,
            ];
            
            return response()->json([
                'existe' => true, // true porque encontramos datos válidos en mix_orders
                'origen' => 'MixOrder',
                'producto' => $ordenData
            ]);
        }

        // 3. Si no existe en BD ni en mix_orders, buscar en Web Service
        // $url = "https://192.168.6.26/wsPlantel/mezcla.php";
        $url = "https://data.industriascuscatlan.com:7322/wsPlantel/mezcla.php";    
        
        try {
            $response = Http::withoutVerifying()
                ->timeout(60) // Timeout de 10 segundos
                ->get($url);

            if ($response->failed()) {
                Log::error("Error HTTP al conectar con la API: {$response->status()}");
                return response()->json([
                    'existe' => false,
                    'msg' => 'Error al conectar con el servicio externo',
                    'producto' => null
                ]);
            }

            // Limpieza más robusta del contenido
            $body = $response->body();
            
            // Eliminar BOM si existe
            if (substr($body, 0, 3) == pack('CCC', 0xEF, 0xBB, 0xBF)) {
                $body = substr($body, 3);
            }
            
            // Eliminar caracteres no imprimibles
            $body = preg_replace('/[^\x20-\x7E]/', '', $body);
            
            // Intentar decodificar JSON
            $items = json_decode($body, true);
            
            // Si falla, intentar detectar y corregir problemas comunes
            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('Error JSON: '.json_last_error_msg().' - Contenido: '.$body);
                
                // Intentar extraer JSON manualmente si está mal formado
                if (preg_match('/\{.*\}/s', $body, $matches)) {
                    $items = json_decode($matches[0], true);
                }
                
                if (json_last_error() !== JSON_ERROR_NONE) {
                    return response()->json([
                        'existe' => false,
                        'msg' => 'La API devolvió un formato inválido',
                        'producto' => null
                    ]);
                }
            }

            // Buscar la orden en los datos
            foreach ($items as $el) {
                $e = (object) $el;
                $ordenApi = preg_replace('/\s+/', '', $e->num ?? '');
                
                if ($ordenApi === $normalized) {
                    Log::info("Orden encontrada en API: ".json_encode($e));
                    
                    return response()->json([
                        'existe' => true,
                        'origen' => 'API',
                        'producto' => $e
                    ]);
                }
            }

            Log::warning("Orden no encontrada en API: {$numero_orden}");
            return response()->json([
                'existe' => false,
                'msg' => 'No se encontró la orden en el sistema externo',
                'producto' => null
            ]);

        } catch (\Exception $e) {
            $errorMsg = $e->getMessage(); // Mensaje real del error

            Log::error("Excepción al conectar con la API: ".$errorMsg, [
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'existe' => false,
                'msg' => "Error de conexión con el servicio externo: {$errorMsg}",
                'producto' => null
            ]);
        }
    }

    // Método auxiliar para mapear roles a descripciones
    private function mapRoleToDescription($role)
    {
        $map = [
            "Mezcla" => "Mezcla",
            "Calidad" => "Analista De Calidad",
            "Produccion" => "Producción",
            "JefeProduccion" => "Jefe De Producción",
            "Muestreo" => "Muestreo",
            "SupCalidad" => "Supervisor De Calidad",
            "JefeControlCalidad" => "Jefe Control De Calidad",
            "AuxControlCalidad" => "Auxiliar Control De Calidad",
        ];

        return $map[$role] ?? $role;
    }

    // Crear una nueva orden con todos los campos
    public function crear(Request $request)
    {
        $validated = $request->validate([
            'numero_orden' => 'required|string|max:100|unique:control_producto,numero_orden',
            'codigo_producto' => 'required|string|max:100',
            'nombre_producto' => 'required|string|max:255',
            'ph_agua' => 'nullable|string|max:50',
            'conductividad_agua' => 'nullable|string|max:50',
            'cloro_libre_agua' => 'nullable|string|max:50',
            'ph_producto' => 'nullable|string|max:50',
            'especificacion_ph_producto' => 'nullable|string|max:50',
            'viscosidad_producto' => 'nullable|string|max:50',
            'especificacion_viscosidad_producto' => 'nullable|string|max:50',
            'densidad_producto' => 'nullable|string|max:50',
            'especificacion_densidad_producto' => 'nullable|string|max:50',
            'apariencia_producto' => 'boolean',
            'color_producto' => 'boolean',
            'olor_producto' => 'boolean',
            'observaciones_producto' => 'nullable|string',
            'estado' => 'nullable|integer',
        ]);

        $validated['estado'] = 1; // Asignar estado por defecto
        $validated['usuario_crea'] = $this->getCurrentUserName();
        // 🔹 Usar mapeo para guardar descripción completa
        $validated['rol_crea'] = $this->mapRoleToDescription($this->getCurrentUserRole());

        $producto = ControlProducto::create($validated);

        return response()->json([
            'message' => 'Orden creada exitosamente',
            'producto' => $producto
        ], 201);
    }

      /**
     * Obtener órdenes pendientes (estado 1 o 2)
     */
    public function obtenerOrdenesControlProducto()
    {
        try {
            $ordenes = ControlProducto::whereIn('estado', [1, 2])
                ->orderByDesc('created_at')
                ->get()
                ->map(function ($orden) {
                    return [
                        'id' => $orden->id,
                        'numero_orden' => $orden->numero_orden,
                        'codigo_producto' => $orden->codigo_producto,
                        'nombre_producto' => $orden->nombre_producto,
                        'estado' => $orden->estado,
                        'estado_descripcion' => $this->getDescripcionEstado($orden->estado),
                        'fecha' => $orden->created_at->format('Y-m-d H:i')
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $ordenes,
                'count' => $ordenes->count()
            ]);
        } catch (\Exception $e) {
            Log::error('Error al obtener pendientes: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener órdenes pendientes'
            ], 500);
        }
    }

    
   /**
     * Descripción legible de estados
     */
    public function getDescripcionEstado($estado)
    {
        switch ($estado) {
            case 1: return 'Pendiente de verificación';
            case 2: return 'Pendiente de autorización';
            case 3: return 'Autorizado';
            default: return 'Desconocido';
        }
    }
    


    // Modificar una orden existente por numero_orden
    public function modificar(Request $request, $numero_orden)
    {
        $producto = ControlProducto::where('numero_orden', $numero_orden)->firstOrFail();

        $validated = $request->validate([
            'ph_agua' => 'nullable|string|max:50',
            'conductividad_agua' => 'nullable|string|max:50',
            'cloro_libre_agua' => 'nullable|string|max:50',
            'ph_producto' => 'nullable|string|max:50',
            'especificacion_ph_producto' => 'nullable|string|max:50',
            'viscosidad_producto' => 'nullable|string|max:50',
            'especificacion_viscosidad_producto' => 'nullable|string|max:50',
            'densidad_producto' => 'nullable|string|max:50',
            'especificacion_densidad_producto' => 'nullable|string|max:50',
            'apariencia_producto' => 'boolean',
            'color_producto' => 'boolean',
            'olor_producto' => 'boolean',
            'observaciones_producto' => 'nullable|string',
            'estado' => 'nullable|integer',
        ]);

        $producto->update($validated);

        return response()->json([
            'message' => 'Orden actualizada exitosamente',
            'producto' => $producto
        ]);
    }

    // Marcar una orden como verificada
    public function verificar($numero_orden)
    {
        $producto = ControlProducto::where('numero_orden', $numero_orden)->firstOrFail();

        $updateData = [
            'estado' => 2, // Estado para "Verificado"
            'usuario_verifica' => $this->getCurrentUserName(), // Obtenido del backend
            // 🔹 Usar mapeo
            'rol_verifica' => $this->mapRoleToDescription($this->getCurrentUserRole()), 
            'fecha_verificacion' => now(),
        ];

        $producto->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Orden verificada exitosamente',
            'data' => $producto->fresh()
        ]);
    }


    // Marcar una orden como autorizada
    public function autorizar(Request $request, $numero_orden)
    {
        $producto = ControlProducto::where('numero_orden', $numero_orden)->firstOrFail();

        $updateData = [
            'estado' => 3, // Estado para "Autorizado"
            'usuario_autoriza' => $this->getCurrentUserName(),
            // 🔹 Usar mapeo
            'rol_autoriza' => $this->mapRoleToDescription($this->getCurrentUserRole()),
            'fecha_autorizacion' => now(),
        ];

        // Actualizar si vienen en el request
        if ($request->has('apariencia_producto')) {
            $updateData['apariencia_producto'] = $request->input('apariencia_producto');
        }
        if ($request->has('olor_producto')) {
            $updateData['olor_producto'] = $request->input('olor_producto');
        }

        $producto->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Orden autorizada exitosamente',
            'data' => $producto->fresh()
        ]);
    }

    // Actualizar rol de firma (Realizó, Verificó, Autorizó)
    public function updateSignatureRole(Request $request, $id)
    {
        $producto = ControlProducto::findOrFail($id);
        
        $validated = $request->validate([
            'column' => 'required|in:rol_crea,rol_verifica,rol_autoriza',
            'role_key' => 'required|string'
        ]);

        $roleMap = [
            "Mezcla" => "Mezcla",
            "Calidad" => "Analista De Calidad",
            "Produccion" => "Producción",
            "JefeProduccion" => "Jefe De Producción",
            "Muestreo" => "Muestreo",
            "SupCalidad" => "Supervisor De Calidad",
            "JefeControlCalidad" => "Jefe Control De Calidad",
            "AuxControlCalidad" => "Auxiliar Control De Calidad",
        ];

        // Validar que la llave exista en nuestro mapa permitido
        if (!array_key_exists($validated['role_key'], $roleMap)) {
             return response()->json([
                'success' => false,
                'message' => 'Rol no válido'
            ], 400);
        }

        $description = $roleMap[$validated['role_key']];
        $column = $validated['column'];

        $producto->$column = $description;
        $producto->save();

        return response()->json([
            'success' => true,
            'message' => 'Rol actualizado exitosamente',
            'data' => [
                'column' => $column,
                'description' => $description
            ]
        ]);
    }


}
