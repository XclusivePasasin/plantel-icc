<?php

namespace App\Http\Controllers;

use App\ResultadoAnalisisAgua;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
class ResultadoAnalisisAguaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Asegura que el usuario esté autenticado
    }

    // Crear nuevo registro
    public function store(Request $request)
    {
        $validated = $request->validate([
            'resultado_ph' => 'nullable|string|max:100',
            'resultado_conductividad' => 'nullable|string|max:100',
            'resultado_cloro_libre' => 'nullable|string|max:100',
            'observaciones' => 'nullable|string',
        ]);

        // Desactivar el registro activo anterior (si existe)
        ResultadoAnalisisAgua::where('estado', 1)->update(['estado' => 0]);

        // Crear el nuevo registro como activo
        $validated['estado'] = 1;
        $validated['usuario_crea'] = $this->getCurrentUserName();
        $validated['rol_crea'] = $this->getCurrentUserRole();

        $registro = ResultadoAnalisisAgua::create($validated);

        return response()->json([
            'message' => 'Nuevo análisis creado y activado',
            'data' => $registro
        ], 201);
    }

    // Actualizar un registro existente
    public function update(Request $request, $id)
    {
        $registro = ResultadoAnalisisAgua::findOrFail($id);

        $validated = $request->validate([
            'resultado_ph' => 'nullable|string|max:100',
            'resultado_conductividad' => 'nullable|string|max:100',
            'resultado_cloro_libre' => 'nullable|string|max:100',
            'observaciones' => 'nullable|string',
            'estado' => 'nullable|integer|in:0,1',
        ]);

        $registro->update($validated);

        return response()->json([
            'message' => 'Registro actualizado exitosamente',
            'data' => $registro
        ]);
    }

    // Mostrar el único registro existente
    public function show()
    {
        $registro = ResultadoAnalisisAgua::where('estado', 1)->first();

        if (!$registro) {
            return response()->json([
                'message' => 'No se puede crear la orden, pendiente de crear análisis de agua'
            ], 404);
        }

        return response()->json($registro);
    }

    // Métodos auxiliares para obtener información del usuario
    protected function getCurrentUserName()
    {
        return session('user_cur_fullname') ?? Auth::user()->name ?? 'sistema';
    }

    protected function getCurrentUserRole()
    {
        return session('role_cur_user') ?? Auth::user()->getRoleNames()->first() ?? 'desconocido';
    }

    // public function analisisagua(Request $request,$order_code){
    //     $tmp = new AnalisisAgua();
    //     $usuario= $this->obtenerUsuario($request);
    //     $analisis= $tmp->search($order_code, $usuario);
    //     $analisis= json_decode(json_encode($analisis),FALSE);
    //     if($analisis->code == 1 && $analisis->data->analisis->status==3 || $analisis->data->analisis->status==4){
    //         $especificacion= $tmp->getEspecificacionObject($analisis->data->analisis->especificacion);
    //         //var_dump($especificacion);
    //         //exit();
    //         $data = ['data' => $analisis->data, 'especificacion' => $especificacion];
    //         $pdf = PDF::loadView('reports.analisisagua', $data);
    //         $fechaActual= date('Y-m-d');
    //         return $pdf->download('AnalisisAgua'.$fechaActual.'.pdf');
    //     }
    //     else{
    //         return "Orden no encontrada";
    //     }
    // }

}