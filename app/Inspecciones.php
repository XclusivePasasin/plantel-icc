<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Inspecciones extends Model
{
    protected $table = "inspecciones";
    protected $fillable = ['estado', 'mix_order_id'];

    public function search($order_code, $obj)
    {
        $salida = [
            "code" => 0,
            "msg" => "",
            "data" => null
        ];

        $usuario = [
            'username' => $obj->nombre,
            'rolname' => $obj->rolabv
        ];

        // 🔍 El código tal cual lo recibimos (con espacios y guiones)
        $originalOrderCode = $order_code;

        // 🔍 Para comparar con base de datos: quitar espacios solamente
        $normalizedDbCode = str_replace(' ', '', $originalOrderCode);

        // 🔎 Buscar orden en BD (ej. "3526-10")
        $order = Packing::whereRaw("REPLACE(num_id, ' ', '') = ?", [$normalizedDbCode])->first();

        // Si no existe, buscar en API usando el código original tal como viene (ej. "3526 - 10")
        if (!$order) {
            // $url = "https://192.168.6.26/wsPlantel/empaque.php";
            $url = "https://data.industriascuscatlan.com:7322/wsPlantel/empaque.php";
            try {
                $response = Http::withoutVerifying()
                    ->timeout(60)
                    ->get($url);
            } catch (\Illuminate\Http\Client\RequestException $e) {
                \Log::error("Error de conexión con la API: " . $e->getMessage());
                $salida["msg"] = "Error: Tiempo de espera agotado al consultar la API.";
                return $salida;
            }

            $body = $response->body();
            \Log::info('API Response (raw): ' . $body);

            $cleanBody = preg_replace('/^\xEF\xBB\xBF/', '', $body);
            $cleanBody = preg_replace('/[\x00-\x1F\x7F]/u', '', $cleanBody);
            $items = json_decode(utf8_encode($cleanBody), true);

            if (json_last_error() !== JSON_ERROR_NONE || !is_array($items)) {
                \Log::error('Error al decodificar JSON: ' . json_last_error_msg());
                \Log::error('Contenido recibido (limpio): ' . $cleanBody);
                $salida["msg"] = "Error: La API no devolvió resultados válidos.";
                return $salida;
            }

            foreach ($items as $el) {
                $e = (object)$el;
                $apiCode = trim($e->num ?? '');

                // ✅ Comparar sin modificar el código original
                if ($apiCode === $originalOrderCode) {
                    $e->num_id = $e->num;
                    $e->origin = "API";

                    if (isset($e->date)) {
                        $e->date = Carbon::parse($e->date)->format('Y-m-d H:i:s');
                    }

                    $e->materials = collect($e->materials ?? [])->map(function ($material) {
                        $material = (object)$material;
                        $material->process = $material->process ?? 'Empaque';
                        return $material;
                    })->all();

                    $salida["code"] = 1;
                    $salida["msg"] = "Processed Successfully";
                    $salida["data"] = [
                        "order" => $e,
                        "inspecciones" => null,
                        "user" => $usuario
                    ];
                    return $salida;
                }
            }

            $salida["msg"] = "No se encontró la orden en la API.";
            return $salida;
        }

        // Buscar inspección local
        $inspecciones = Inspecciones::where('packing_id', $order->id)->first();

        if ($inspecciones) {
            $inspecciones = $this->formatDate($inspecciones);
            $salida["code"] = 1;
            $salida["msg"] = "Processed Successfully";
            $salida["data"] = [
                "order" => $order,
                "inspecciones" => $inspecciones,
                "user" => $usuario
            ];
        } else {
            $inspecciones = $this->getNewObject($order, $usuario);
            $salida["code"] = 2;
            $salida["msg"] = "No existen inspecciones para esa orden";
            $salida["data"] = [
                "order" => $order,
                "inspecciones" => $inspecciones,
                "user" => $usuario
            ];
        }

        return $salida;
    }




    // public function search($order_code, $obj){
    //     $salida = [
    //         "code" => 0,
    //         "msg" => "",
    //         "data" => null
    //     ];

    //     $user=$obj->nombre;

    //     $usuario = array('username' => $obj->nombre, 'rolname' => $obj->rolabv);
    //     $order = null;
    //     $order = Packing::where('num_id', $order_code)->first();
    //     if($order){
    //         $inspecciones= Inspecciones::where('packing_id', $order->id)->first();
    //         if($inspecciones){
    //             $inspecciones = $this->formatDate($inspecciones);
    //             $salida["code"] = 1;
    //             $salida["msg"] = "Processed Successfully";
    //             $salida["data"]["order"] = $order;
    //             $salida["data"]["inspecciones"] = $inspecciones;
    //             $salida["data"]["user"] = $usuario;
    //         }
    //         else{
    //             $inspecciones= $this->getNewObject($order, $usuario);
    //             $salida["code"] = 2;
    //             $salida["msg"] = "No existen inspecciones para esa orden";
    //             $salida["data"]["order"] = $order;
    //             $salida["data"]["inspecciones"] = $inspecciones;
    //             $salida["data"]["user"] = $usuario;
    //         }
    //     }
    //     return $salida;
    // }


    public function getNewObject($order, $usuario){

        $inspecciones= new Inspecciones();

        $inspecciones->estado = 0;
        $inspecciones->lote = $order->lot_num;

        $inspecciones->tanque = '';

        $inspecciones->fechahoraconxtanque1 = '';
        $inspecciones->fechahoraconxtanque2 = '';

        $inspecciones->supervisorconxtanque1 = '';
        $inspecciones->supervisorconxtanque2 = '';

        $inspecciones->ctrlcalidadconxtanque1 = '';
        $inspecciones->ctrlcalidadconxtanque2 = '';

        $inspecciones->opmaquinaconxtanque1 = '';
        $inspecciones->opmaquinaconxtanque2 = '';

        $inspecciones->rechazadosfecha1 = '';
        $inspecciones->rechazadosfecha2 = '';
        $inspecciones->rechazadosfecha3 = '';
        $inspecciones->rechazadosfecha4 = '';

        $inspecciones->rechazadoscantidadund1 = '';
        $inspecciones->rechazadoscantidadund2 = '';
        $inspecciones->rechazadoscantidadund3 = '';
        $inspecciones->rechazadoscantidadund4 = '';

        $inspecciones->totalunidadesrechazadas = 0;

        $inspecciones->vaciosfecha1 = '';
        $inspecciones->vaciosfecha2 = '';
        $inspecciones->vaciosfecha3 = '';
        $inspecciones->vaciosfecha4 = '';

        $inspecciones->vacioscantidadkgs1 = '';
        $inspecciones->vacioscantidadkgs2 = '';
        $inspecciones->vacioscantidadkgs3 = '';
        $inspecciones->vacioscantidadkgs4 = '';

        $inspecciones->totalkilogramosvacios = 0;

        $inspecciones->productoterminado1 = '';
        $inspecciones->productoterminado2 = '';

        $inspecciones->pt = 0;
        $inspecciones->capacidad = 0;
        $inspecciones->ptotal = 0;
        $inspecciones->rendimientomezcla = '';
        $inspecciones->consumobobina = '';
        $inspecciones->packing_id = $order->id;

        return $inspecciones;
    }

    public function formatDate($inspecciones)
    {
        $inspecciones->fechahoraconxtanque1 = (!empty($inspecciones->fechahoraconxtanque1)) ? date("d-m-Y H:i", strtotime($inspecciones->fechahoraconxtanque1)) : NULL;
        $inspecciones->fechahoraconxtanque2 = (!empty($inspecciones->fechahoraconxtanque2)) ? date("d-m-Y H:i", strtotime($inspecciones->fechahoraconxtanque2)) : NULL;
        
        $inspecciones->rechazadosfecha1 = (!empty($inspecciones->rechazadosfecha1)) ? date("d-m-Y", strtotime($inspecciones->rechazadosfecha1)) : NULL;
        $inspecciones->rechazadosfecha2 = (!empty($inspecciones->rechazadosfecha2)) ? date("d-m-Y", strtotime($inspecciones->rechazadosfecha2)) : NULL;
        $inspecciones->rechazadosfecha3 = (!empty($inspecciones->rechazadosfecha3)) ? date("d-m-Y", strtotime($inspecciones->rechazadosfecha3)) : NULL;
        $inspecciones->rechazadosfecha4 = (!empty($inspecciones->rechazadosfecha4)) ? date("d-m-Y", strtotime($inspecciones->rechazadosfecha4)) : NULL;
        
        $inspecciones->vaciosfecha1 = (!empty($inspecciones->vaciosfecha1)) ? date("d-m-Y", strtotime($inspecciones->vaciosfecha1)) : NULL;
        $inspecciones->vaciosfecha2 = (!empty($inspecciones->vaciosfecha2)) ? date("d-m-Y", strtotime($inspecciones->vaciosfecha2)) : NULL;
        $inspecciones->vaciosfecha3 = (!empty($inspecciones->vaciosfecha3)) ? date("d-m-Y", strtotime($inspecciones->vaciosfecha3)) : NULL;
        $inspecciones->vaciosfecha4 = (!empty($inspecciones->vaciosfecha4)) ? date("d-m-Y", strtotime($inspecciones->vaciosfecha4)) : NULL;

        return $inspecciones;
    }
}
