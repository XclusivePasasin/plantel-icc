<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResultadoAnalisisAguaController;
use App\Http\Controllers\TanqueController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login.show');
});

Route::get('home','DashboardController@index')->name('admin.home')->middleware('auth');



Route::get('login','Auth\LoginController@showLogin')->name('login.show')->middleware('guest');
Route::post('login','Auth\LoginController@login')->name('login');
Route::post('logout','Auth\LoginController@logout')->name('logout');

#Carga el blade con componente de busqueda orden desde API o DB
Route::get('mix/order/load','DashboardController@pesaje')->name('mix.load')->middleware('auth','role:MateriaPrima');
# Realiza una busqueda de orden de mezcla desde API o BD
Route::get('mix/orders/{code}','MixController@search')->name('mix.search')->middleware('auth');
# Guarda o actualiza una orden de mezcla
Route::post('mix/orders','MixController@saveOrUpdate')->name('mix.upsert')->middleware('auth');
# Actualiza el analisis de Agua u observaciones
Route::post('mix/order/upwater/{id}','MixController@upwater')->name('mix.upwater')->middleware('auth');
#AJAX Autoriza una orden de mezcla
Route::post('mix/order/authorize/{id}','MixController@authorizeOrder')->name('mix.authorize')->middleware('auth');
#AJAX Revisa una orden de mezcla
Route::post('mix/order/revisar/{id}','MixController@revisarOrder')->name('mix.revisar')->middleware('auth');
#AJAX  Inicio el proceso de mezcla de una orden
Route::post('mix/order/init/{id}','MixController@init')->name('mix.init')->middleware('auth');
#AJAX  finaliza el proceso de mezcla de una orden
Route::post('mix/order/finish/{id}','MixController@finish')->name('mix.finish')->middleware('auth');
#AJAX  autoriza la finalizacion del proceso de mezcla de una orden
Route::post('mix/order/autorizaefinishedorder/{id}','MixController@autorizefinished')->name('mix.autorizefinish')->middleware('auth');
#Carga el blade mixorder pendiente de aprovar pesaje, autorizar y iniciar proceso
Route::get('peso/approve','DashboardController@pesajeApprove')->name('peso.approve')->middleware('auth');
#Carga una orden de mezcla estrcitamente desde la Base de datos
Route::get('mix/find/{code}','MixController@searchDB')->name('mix.search.strict')->middleware('auth');

Route::post('peso/approve/{id}','MixController@approvePesaje')->name('mix.peso.approve')->middleware('auth');
#Carga blade para ver estados de la orden produccion mezcla
Route::get('mix/status','DashboardController@mixStatus')->name('mix.status')->middleware('auth');
Route::get('mix/status/{code}','MixController@statusProgress')->name('mix.status.find')->middleware('auth');
// AJAX Actualiza la entrega de los materiales
Route::post('mix/order/update-materials-delivery', 'MixController@updateMaterialsDelivery')
    ->name('mix.update.materials.delivery')
    ->middleware('auth');

// AJAX Actualiza el estado de recepción de materiales en la orden
Route::post('mix/order/{id}/update-materials-received', 'MixController@updateOrderMaterialsReceived')
    ->name('mix.update.order.materials.received')
    ->middleware('auth');

# Actualiza el usuario que entrega materia prima
Route::post('mix/order/update-user-entrega-mp/{id}', 'MixController@updateUserEntregaMp')
    ->name('mix.update.user.entrega.mp')
    ->middleware('auth');

# Actualizo de un lote para un material
// Route::post('/mix/change-lot/{material_id}', [MixController::class, 'changeLot']);

# Rutas para control único de resultado de análisis de agua
#Carga el único resultado de análisis de agua
Route::get('agua/resultado', 'ResultadoAnalisisAguaController@show')
    ->name('agua.resultado.show')
    ->middleware('auth');

#Guarda el resultado si no existe aún
Route::post('agua/resultado', 'ResultadoAnalisisAguaController@store')
    ->name('agua.resultado.store')
    ->middleware('auth');

#Actualiza el único resultado existente
Route::post('agua/resultado/{id}', 'ResultadoAnalisisAguaController@update')
    ->name('agua.resultado.update')
    ->middleware('auth');

// Nueva ruta para registrar múltiples cambios de lote a la vez
Route::post('mix/order/change-lots-bulk', 'MixController@changeLotsBulk')
    ->name('mix.change.lots.bulk')
    ->middleware('auth');
    

# Rutas para materia prima adicional (extra_materials)
Route::post('mix/order/{id}/extra-materials', 'MixController@storeExtraMaterials')
    ->name('mix.extra.materials.store')
    ->middleware('auth');

Route::get('mix/order/{id}/extra-materials', 'MixController@getExtraMaterials')
    ->name('mix.extra.materials.get')
    ->middleware('auth');

# JefeProduccion puede actualizar observaciones
Route::post('mix/order/{id}/update-observaciones', 'MixController@updateObservaciones')
    ->name('mix.update.observaciones')
    ->middleware('auth');


# Nueva ruta para obtener solo el UXC desde API remota (proxy sin CORS)
Route::get('packing/order/uxc/{order_code}', 'EmpaqueController@getUXCByOrder')
    ->name('packing.getUXC')
    ->middleware('auth');
#Carga el blade con componente de busqueda orden desde API o DB
Route::get('packing/load','DashboardController@showPacking')->name('packing.load')->middleware('auth', 'role:Bodega|Produccion|Bodega PT');
# Realiza busqueda de orden de empaque desde API o DB
Route::get('packing/orders/{code}','EmpaqueController@search')->name('packing.search')->middleware('auth');
# AJAX Guarda o actualiza una orden de empaque
Route::post('packing/orders','EmpaqueController@saveOrUpdate')->name('packing.upsert')->middleware('auth');
#Carga el blade con componente busqueda desde la DB, (Seguimiento)
Route::get('packing/tracking','DashboardController@packing')->name('packing.seg')->middleware('auth');
# AJAX Obtiene orden de empaque desde DB para seguimiento
Route::get('packing/find/{code}','EmpaqueController@searchDB')->name('packing.search.strict')->middleware('auth');
#AJAX Autoriza una orden de empaque
Route::post('packing/order/authorize/{id}','EmpaqueController@authorizeOrder')->name('packing.authorize')->middleware('auth');
Route::post('packing/order/sign/{id}','EmpaqueController@signOrder')->name('packing.sign')->middleware('auth');
# AJAX para modificar el seguimiento de los tiempos,operarios,entregas, observaciones
Route::post('packing/tracking/{id}','EmpaqueController@tracking')->name('packing.tracking')->middleware('auth');
# AJAX finaliza el proceso de empaque de una orden
Route::post('packing/order/finish/{id}','EmpaqueController@finish')->name('packing.finish')->middleware('auth');
# AJAX Produccion entrega devoluciones (opcional)
Route::post('packing/order/entregar-devolucion/{id}','EmpaqueController@entregarDevolucion')->name('packing.entregar.devolucion')->middleware('auth');
# AJAX Bodega PT recibe devoluciones (opcional)
Route::post('packing/order/recibir-devolucion/{id}','EmpaqueController@recibirDevolucion')->name('packing.recibir.devolucion')->middleware('auth');
# AJAX para guardar el chequeo individual de recepcion de retorno
Route::post('packing/order/save-return-receipt/{id}','EmpaqueController@saveReturnReceipt')->name('packing.save.return.receipt')->middleware('auth');
#Carga blade para visualizar estados orden de produccion empaque
Route::get('packing/status','DashboardController@packingStatus')->name('packing.status')->middleware('auth');
Route::get('packing/status/{code}','EmpaqueController@statusProgress')->name('packing.status.find')->middleware('auth');
# Nueva ruta para verificar la orden de empaque
Route::post('packing/order/verify/{id}', 'EmpaqueController@markVerifyLot')
    ->name('packing.verify.lot')
    ->middleware('auth');


    



#Rutas agregadas para realizar el proceso de analisis de agua
Route::get('admin/analisis','DashboardController@analisisAgua')->name('admin.anagua');
Route::get('analisisagua/orders/{code}','AnalisisAguaController@search')->name('analisisagua.search')->middleware('auth');
Route::post('analisisagua/orders','AnalisisAguaController@saveOrUpdate')->name('analisisagua.upsert')->middleware('auth');


# Rutas para el proceso de control de producto
Route::get('admin/controlproducto','DashboardController@controlProducto')->name('admin.controlproducto');
# Verifica si existe una orden de control de producto por número
Route::get('controlproducto/orders/{numero_orden}', 'ControlProductoController@verificarExistenciaBD')
    ->name('controlproducto.search')
    ->middleware('auth');

# Guarda una nueva orden de control de producto
Route::post('controlproducto/orders', 'ControlProductoController@crear')
    ->name('controlproducto.upsert')
    ->middleware('auth');

# Actualiza los datos de una orden ya registrada
Route::post('controlproducto/orders/update/{numero_orden}', 'ControlProductoController@modificar')
    ->name('controlproducto.update')
    ->middleware('auth');

# Verifica una orden de control de producto
Route::post('controlproducto/orders/verificar/{numero_orden}', 'ControlProductoController@verificar')
    ->name('controlproducto.verificar')
    ->middleware('auth');

# Autoriza una orden de control de producto
Route::post('control-producto/autorizar/{numero_orden}', 'ControlProductoController@autorizar')
    ->name('controlproducto.autorizar')
    ->middleware('auth');

// Ruta para obtener órdenes pendientes
Route::post('/controlproducto/orders/control-producto', 'ControlProductoController@obtenerOrdenesControlProducto')
    ->middleware('auth');

// Ruta para actualizar roles de firma en estado autorizado
Route::post('/controlproducto/orders/update-role/{id}', 'ControlProductoController@updateSignatureRole')
    ->middleware('auth');


# Carga la vista blade del módulo
// Route::get('admin/controlproducto', 'DashboardController@controlProducto')
//     ->name('admin.controlproducto')
//     ->middleware('auth');


#Rutas agregadas para realizar el proceso de granel
Route::get('admin/addgranel','DashboardController@addGranel')->name('admin.addgranel');
Route::get('granel/orders/{code}','GranelController@search')->name('granel.search')->middleware('auth');
Route::post('granel/orders','GranelController@saveOrUpdate')->name('granel.upsert')->middleware('auth');
Route::post('granel/orders/search', 'GranelController@searchOrderSpecs')
    ->name('granel.search.specs')
    ->middleware('auth');

#Rutas agregadas para realizar el proceso de estandares
Route::get('admin/addestandares','DashboardController@addEstandares')->name('admin.addestandares');

Route::get('estandares/orders/{code}/{turno}','EstandaresController@search')->name('estandares.search')->middleware('auth');
Route::post('estandares/orders','EstandaresController@saveOrUpdate')->name('estandares.upsert')->middleware('auth');
Route::get('estandares/orders/all/{code}/{turno}','EstandaresController@allByPackingCode')->name('estandares.search')->middleware('auth');
Route::get('estandares/{id}','EstandaresController@findById')->name('estandares.findById')->middleware('auth');
Route::get('estandares/model/{code}/{turno}','EstandaresController@model')->name('estandares.getModel')->middleware('auth');
// Siguiente seccion
Route::post('/estandares/orders/next-section', 'EstandaresController@nextSection');


#Rutas agregadas para realizar el proceso de controles
Route::get('admin/addcontroles','DashboardController@addControles')->name('admin.addcontroles');

Route::get('controles/orders/{code}/{turno}', 'ControlesController@search')->name('controles.search')->middleware('auth');
Route::post('controles/orders', 'ControlesController@saveOrUpdate')->name('controles.upsert')->middleware('auth');
Route::get('controles/orders/all/{code}/{turno}', 'ControlesController@allByPackingCode')->name('controles.search')->middleware('auth');
Route::get('controles/{id}', 'ControlesController@findById')->name('controles.findById')->middleware('auth');
Route::get('controles/model/{code}/{turno}', 'ControlesController@model')->name('controles.getModel')->middleware('auth');


#Rutas agregadas para realizar el proceso de inspección
Route::get('admin/addinspecciones','DashboardController@addInspecciones')->name('admin.addinspecciones')->middleware('auth');
Route::get('inspecciones/orders/{code}','InspeccionesController@search')->name('inspecciones.search')->middleware('auth');
Route::post('inspecciones/orders','InspeccionesController@saveOrUpdate')->name('inspecciones.upsert')->middleware('auth');
Route::post('inspecciones/orders/approve/{code}/{action}','InspeccionesController@approve')->name('inspecciones.approve')->middleware('auth');

#Rutas destinadas para reporteria
Route::get('report/mixorder/{id}','ReportController@mixorder')->name('report.mixorder');
Route::get('report/vinietas/{id}','ReportController@vinietas')->name('report.vinietas');
Route::get('report/packing/{id}','ReportController@packing')->name('report.packing');
Route::get('report/analisisagua/{id}','ReportController@analisisagua')->name('report.analisisagua');
Route::get('report/granel/{id}','ReportController@granel')->name('report.granel');
Route::get('report/controlproducto/{order_code}', 'ReportController@controlProducto')->name('report.controlproducto');

#Rutas para la administración de usuarios
Route::get('admin/users','DashboardController@listUsers')->name('usuarios.list')->middleware('auth');
Route::get('admin/users/index','UserController@index')->name('usuarios.index')->middleware('auth');
Route::get('admin/users/create','UserController@create')->name('usuarios.create')->middleware('auth');
Route::post('admin/users/store','UserController@store')->name('usuarios.store')->middleware('auth');
Route::get('admin/users/edit/{id}','UserController@edit')->name('usuarios.edit')->middleware('auth');
Route::post('admin/users/update/{id}','UserController@update')->name('usuarios.update')->middleware('auth');
Route::post('admin/users/status_user/{id}','UserController@status_user')->name('usuarios.status_user')->middleware('auth');

Route::get('report/estandarescalidad/{id}/{turno}','ReportController@estandaresCalidad')->name('report.estandarescalidad');
Route::get('report/controlescalidad/{id}/{turno}','ReportController@controlesCalidad')->name('report.controlescalidad');
Route::get('report/inspeccionescalidad/{id}','ReportController@inspeccionesCalidad')->name('report.inspeccionescalidad')->middleware('auth');


# Rutas para el Tanque
Route::prefix('tanque')->group(function () {
    Route::get('/pendientes', [TanqueController::class, 'pendientes']);
    Route::get('/{numero_orden}', [TanqueController::class, 'show']);
    Route::post('/guardar', [TanqueController::class, 'storeOrUpdate']);
    Route::post('/verificar/{numero_orden}', [TanqueController::class, 'verificar'])->name('tanque.verificar');
    Route::post('/autorizar/{numero_orden}', [TanqueController::class, 'autorizar'])->name('tanque.autorizar');
    Route::post('/verificar-reconexion/{numero_orden}', [TanqueController::class, 'verificarReconexion'])->name('tanque.verificar-reconexion');
    Route::post('/autorizar-reconexion/{numero_orden}', [TanqueController::class, 'autorizarReconexion'])->name('tanque.autorizar-reconexion');
    Route::get('/lote/{numero_orden}', [TanqueController::class, 'getLotePorOrden'])->name('tanque.lote');
});

Route::get('/validacion-tanque', [TanqueController::class, 'index'])->name('tanque.tanque');
// Cambia a POST y recibe el parámetro en el body
Route::post('/validacion-tanque/buscar', [TanqueController::class, 'buscarOrden']);
Route::post('/validacion-tanque/buscar-mezcla', [TanqueController::class, 'buscarOrdenMezcla']);

