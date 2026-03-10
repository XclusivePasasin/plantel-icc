<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MixOrder;
use App\Packing;

class DashboardController extends Controller
{

    public function index(Request $request){
        $request->page_pass = $request->page_pass == null ? "Panel Principal" : $request->page_pass;
        return view('admin.home',['page_title' => $request->page_pass]);
    }

    public function pesajeApprove(Request $request){
        if (!$request->user()->hasRole("Mezcla") && !$request->user()->hasRole("SupCalidad") && !$request->user()->hasRole("AuxControlCalidad") && !$request->user()->hasRole("Calidad") && !$request->user()->hasRole("Produccion") && !$request->user()->hasRole("JefeProduccion") && !$request->user()->hasRole("Muestreo") && !$request->user()->hasRole("JefeControlCalidad") ) {
            return redirect()->route('login.show');
        }

        return view('mixorder.pesaje-approve',
            ['page_title' => $request->page_pass, 'aorders' => $this->searchActiveOrdersDB() ]
        );
    }

    public function pesaje(Request $request){
        return view('mixorder.pesaje-load',
            ['page_title' => $request->page_pass, 'aorders' => $this->searchActiveOrdersDB()]
        );
    }

    public function analisisAgua(Request $request){
        if(!$this->validateSession($request)) return redirect()->route('login.show');
        if (! $request->user()->hasRole("Calidad") && !$request->user()->hasRole("Mezcla") && !$request->user()->hasRole("SupCalidad") && !$request->user()->hasRole("JefeControlCalidad") && !$request->user()->hasRole("Muestreo") && !$request->user()->hasRole("AuxControlCalidad") ) {
            return redirect()->route('login.show');
        }
        return view('admin.anagua',
            ['page_title' => $request->page_pass, 'aorders' => $this->searchActiveOrdersDB()]
        );
    }
    public function controlProducto(Request $request){
        if(!$this->validateSession($request)) return redirect()->route('login.show');
        if (! $request->user()->hasRole("Calidad") && !$request->user()->hasRole("Mezcla") && !$request->user()->hasRole("AuxControlCalidad") && !$request->user()->hasRole("SupCalidad") && !$request->user()->hasRole("JefeControlCalidad") && !$request->user()->hasRole("Muestreo")) {
            return redirect()->route('login.show');
        }
        return view('controlproducto.controlproducto',
            ['page_title' => $request->page_pass, 'aorders' => $this->searchActiveOrdersDB()]
        );
    }

    public function informacionTanque(Request $request){
        if(!$this->validateSession($request)) return redirect()->route('login.show');
        if (! $request->user()->hasRole("AuxControlCalidad") && !$request->user()->hasRole("Produccion") && !$request->user()->hasRole("SupProduccion") ) {
            return redirect()->route('login.show');
        }
        return view('tanque.tanque',
            ['page_title' => $request->page_pass, 'aorders' => $this->searchActiveOrdersDB()]   
        );
    }


    public function addGranel(Request $request){
        if(!$this->validateSession($request)) return redirect()->route('login.show');
        if (!$request->user()->hasRole("Mezcla") && !$request->user()->hasRole("Calidad") && !$request->user()->hasRole("Muestreo") && !$request->user()->hasRole("SupCalidad") && !$request->user()->hasRole("AuxControlCalidad") && !$request->user()->hasRole("JefeControlCalidad")) {
            return redirect()->route('login.show');
        }
        return view('admin.addgranel',
            ['page_title' => $request->page_pass, 'aorders' => $this->searchActiveOrdersDB()]
        );
    }

    public function listUsers(Request $request){
        if (!$request->user()->hasRole("Admin")) {
            return redirect()->route('login.show');
        }
        return view('users.list',['page_title' => $request->page_pass]);
    }

    public function showPacking(Request $request){
        // Verifica si el usuario tiene el rol de "Bodega", "Bodega PT", o "Producción"
        if (!$request->user()->hasRole("Bodega") && !$request->user()->hasRole("Bodega PT") && !$request->user()->hasRole("Produccion") && !$request->user()->hasRole("AuxControlCalidad")) {
            return redirect()->route('login.show'); // Redirige si no tiene ninguno de los roles
        }
        return view('packing.fetch-packing',
            ['page_title' => $request->page_pass, 'aorders' => $this->searchActivePackingOrdersDB()]
        );
    }

    public function packing(Request $request){
        if (! $request->user()->hasRole("SupCalidad") && !$request->user()->hasRole("Produccion") && !$request->user()->hasRole("AuxControlCalidad")) {
            return redirect()->route('login.show');
        }
        return view('packing.packing',
            ['page_title' => $request->page_pass, 'aorders' => $this->searchActivePackingOrdersDB()]
        );
    }

    public function addEstandares(Request $request){
        if(!$this->validateSession($request)) return redirect()->route('login.show');
        if (! $request->user()->hasRole("Calidad") && !$request->user()->hasRole("Produccion") && !$request->user()->hasRole("SupProduccion") && !$request->user()->hasRole("AuxControlCalidad")) {
            return redirect()->route('login.show');
        }
        return view('admin.addestandares',
        ['page_title' => $request->page_pass, 'aorders' => $this->searchActivePackingOrdersDB()]
        );
    }

    public function addControles(Request $request){
        if(!$this->validateSession($request)) return redirect()->route('login.show');
        if (! $request->user()->hasRole("Calidad") && !$request->user()->hasRole("Produccion") && !$request->user()->hasRole("SupProduccion") && !$request->user()->hasRole("JefeProduccion")) {
            return redirect()->route('login.show');
        }
        return view('admin.addcontroles',
            ['page_title' => $request->page_pass, 'aorders' => $this->searchActivePackingOrdersDB()]
        );
    }

    public function addInspecciones(Request $request){
        if (!$request->user()->hasRole("Produccion") && !$request->user()->hasRole("Calidad") && !$request->user()->hasRole("SupProduccion") && !$request->user()->hasRole("AuxControlCalidad")) {
            return redirect()->route('login.show');
        }

        return view('admin.addinspecciones',
            ['page_title' => $request->page_pass, 'aorders' => $this->searchActivePackingOrdersDB()]
        );
    }


    public function validateSession(Request $request){
        return ($request->session()->exists('role_cur_user') && $request->session()->has('role_cur_user') );
    }

    public function  mixStatus(Request $request){
        return view('mixorder.estados',
            ['page_title' => $request->page_pass, 'aorders' => $this->searchActiveOrdersDB()]
        );
    }

    public function  packingStatus(Request $request){
        return view('packing.estados',
            ['page_title' => $request->page_pass, 'aorders' => $this->searchActivePackingOrdersDB()]
        );
    }

    private function searchActiveOrdersDB(){
        //Buscando ordenes de mezcla registros locales
        $order = MixOrder::where('status', '!=', 7)->get();
        return $order;
    }

    private function searchActivePackingOrdersDB(){
        //Buscando ordenes de empaque registros locales
        $orders = Packing::where('status', '!=', 5)->get();

        // 2. Ordenes de tanque validadas y listas
        $tanques = \App\ValidacionTanque::where('estado', 3)
            ->where(function($q) {
                $q->where('reconexion_estado', 0)
                  ->orWhere('reconexion_estado', 3);
            })
            ->get();

        $merged = collect($orders);

        foreach ($tanques as $t) {
            $exists = collect($orders)->contains(function ($val) use ($t) {
                return str_replace(' ', '', $val->num_id) === str_replace(' ', '', $t->numero_orden);
            });

            if (!$exists) {
                $lote = ($t->reconexion_estado == 3 && !empty($t->reconexion_lote)) ? $t->reconexion_lote : $t->lote;
                
                // Intenta obtener nombre del producto desde mix order o API
                $mixId = preg_replace('/-10$/', '-20', str_replace(' ', '', $t->numero_orden));
                $mix = \App\MixOrder::whereRaw("REPLACE(num_id, ' ', '') = ?", [$mixId])->first();
                $productName = $mix ? $mix->product_name : 'Validación completada';

                $merged->push((object)[
                    'id' => 't_' . $t->id,
                    'num_id' => $t->numero_orden,
                    'product_name' => $productName, 
                    'lot_num' => $lote,
                    'status' => 0 // Custom state maps to "Validación de Tanque Completada (Lista para cargar)"
                ]);
            }
        }

        return $merged;
    }
}
