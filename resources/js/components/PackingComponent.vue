<template>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <h5 class="text-center m-0">DISTRIBUIDORA CUSCATLAN, S.A. DE C.V.</h5>
                    <p class="text-center m-0">ICC LABORATORIES</p>
                    <p class="text-center">REQUERIMIENTO DE MATERIAL DE EMPAQUE</p>
                </div>
            </div>

            <div class="row mb-md-4 mb-2">
                <div class="col-12 col-md-6">
                    <table class="table table-sm mb-0">
                        <tbody>
                            <tr>
                                <th style="width: 50%;">FECHA DE LA ORDEN</th>
                                <td style="width: 50%;">{{data.date}}</td>
                            </tr>
                            <tr>
                                <th>NUMERO DE ORDEN</th>
                                <td>{{data.num_id}}</td>
                            </tr>
                            <tr>
                                <th>CÓDIGO DEL PRODUCTO</th>
                                <td>{{data.product_code}}</td>
                            </tr>
                            <tr>
                                <th>NOMBRE DEL PRODUCTO</th>
                                <td>{{data.product_name}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-12 col-md-6">
                    <table class="table table-sm mb-0">
                        <tbody>
                            <tr>
                                <th style="width: 50%;">NÚMERO DE LOTE</th>
                                <td style="width: 50%;">
                                    <!-- <input type="text"  :disabled="!edit_mode || !((data.status == 1 && has_cap('cap-bodega')) || (data.status == 2 && has_cap('cap-auxcontrol-calidad')))" v-model="data.lot_num" placeholder="Ingresar número lote" class="form-control form-control-sm defblue1" /> -->
                                    <input type="text"  :disabled="!edit_mode || !((data.status == 2 && has_cap('cap-auxcontrol-calidad')))" v-model="data.lot_num" placeholder="Ingresar número lote" class="form-control form-control-sm defblue1" />
                                </td>
                            </tr>
                            <tr>
                                <th>TAMAÑO DEL LOTE </th>
                                <td>{{data.lot_size}}</td>
                            </tr>
                            <tr>
                                <th>TOTAL UNIDADES</th>
                                <td>{{data.total_units}}</td>
                            </tr>
                            <tr>
                                <th>RENDIMIENTO TEÓRICO</th>
                                <td>
                                    <input type="text" readonly v-model="data.performance_teorico" placeholder="Ingresar rendimiento teorico" class="form-control form-control-sm defblue1" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!--BLOQUE DE REPETICION-->
            <div v-for="(e,index) of data.times" :key=" 'times' + index " class="row border border-dark  p-2 mt-2">

                <div class="col-12">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="row">
                               <div class="col-12 col-md-6">
                                <span class="fw-bold">FECHA DE INICIO</span>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="input-group date">
                                        <input
                                            type="date"
                                            placeholder="DD/MM/AAAA"
                                            v-model="e.date_init"
                                            :disabled="!(edit_mode && has_cap('cap-produccion') && parseInt(data.status) === 2) || !!originalTimes[index].date_init"
                                            class="form-control form-control-sm defblue1"
                                            @focus="autoFillDateTime(index)"
                                        />

                                        <!-- <input type="text"
                                            :disabled="!(edit_mode && has_cap('cap-produccion') && (data.status == 2 || data.status == 3)) || originalTimes[index].date_init"
                                            placeholder="DD/MM/YYYY"
                                            v-model="e.date_init"
                                            class="form-control form-control-sm defblue1 datepicker-init"
                                            :id="'date-init-'+index"
                                            autocomplete="off"
                                            @keydown.prevent
                                            @paste.prevent
                                        /> -->
                                        <!-- <span class="input-group-text"><i class="bi bi-calendar"></i></span> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="row">

                                <div class="col-12 col-md-5">
                                    <span class="fw-bold">HORA DE INICIO</span>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="input-group">
                                        <input type="time"
                                            :disabled="!(edit_mode && has_cap('cap-produccion') && parseInt(data.status) === 2) || !!originalTimes[index].time_init"
                                            v-model="e.time_init"
                                            class="form-control form-control-sm defblue1"
                                        />

                                       <!-- <input type="text"
                                            v-mask="'##:##'"
                                            :disabled="!(edit_mode && has_cap('cap-produccion') && (data.status == 2 || data.status == 3)) || originalTimes[index].time_init"
                                            placeholder="HH:mm"
                                            v-model="e.time_init"
                                            :data-index="index"
                                            class="form-control form-control-sm defblue1 timepicker-init"
                                            autocomplete="off"
                                            @keydown.prevent
                                            @paste.prevent
                                        /> -->
                                        <!-- <span class="input-group-text"><i class="bi bi-clock"></i></span> -->
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mt-2">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <span class="fw-bold">FECHA DE FINALIZACIÓN</span>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="input-group date">
                                        <input
                                            type="date"
                                            placeholder="DD/MM/AAAA"
                                            v-model="e.date_end"
                                            :disabled="!(edit_mode && has_cap('cap-produccion') && parseInt(data.status) === 3)"
                                            class="form-control form-control-sm defblue1"
                                            @focus="autoFillDateTime(index, 'end')"
                                        />

                                        <!-- <input type="text"
                                            :id="'fecha-fin-'+index"
                                            :disabled="! (has_cap('cap-produccion') && data.status == 3 && edit_mode) || originalTimes[index].date_end"
                                            placeholder="DD/MM/YYYY"
                                            v-model="e.date_end"
                                            class="form-control form-control-sm defblue1 datepicker-end"
                                            autocomplete="off"
                                            @keydown.prevent
                                            @paste.prevent
                                        /> -->
                                        <!-- <span class="input-group-text"><i class="bi bi-calendar"></i></span> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="row">

                                <div class="col-12 col-md-5">
                                    <span class="fw-bold">HORA DE FINALIZACIÓN</span>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="input-group">
                                        <input
                                            type="time"
                                            :disabled="!(edit_mode && has_cap('cap-produccion') && parseInt(data.status) === 3)"
                                            v-model="e.time_end"
                                            class="form-control form-control-sm defblue1"
                                        />

                                        <!-- <span class="input-group-text"><i class="bi bi-clock"></i></span> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 text-end">
                    <!-- <a href="javascript:void(0);" v-if="(has_cap('cap-produccion') && data.status == 3 && edit_mode)" @click="removeTimeItem(index)" class="text-danger"><u>Eliminar ítem</u></a> -->
                </div>
            </div>
            <!--END BLOQUE DE REPETICION-->
            <div class="text-center mt-3">
                    <!-- <button v-if="(has_cap('cap-produccion') && data.status == 3 && edit_mode)" type="button" @click="addTimes" class="btn btn-secondary">Adicionar nuevo ítem</button> -->
            </div>

            <!-- <div class="row">
                <div class="col-12">
                    <label for="">RENDIMIENTO</label>
                    <input type="text" :disabled="!(edit_end && has_cap('cap-produccion') && data.status == 3)" class="form-control form-control-sm defblue1" v-model="data.performance"/>
                </div>
            </div> -->

            <h5 class="mt-5">OPERARIOS RESPONSABLES</h5>
            <!--INIT BLOQUE DE REPETICION-->
            <div class="row" v-for="(e,index) of data.operarios" :key=" 'ope'+index">
                <div class="col-12 col-md-6">
                    <table class="table table-sm mb-0">
                        <tbody>
                            <tr>
                                <th style="width: 50%;">NOMBRE:</th>
                                <td style="width: 50%;"><input :id="'operario-nom-'+index" type="text"
                                v-model="e.fullname"
                                disabled="true"
                                class="form-control form-control-sm defblue1"/></td>
                            </tr>
                            <!-- Se quitan los parametros disable por logica, dado que ahora se llenan "automaticamnente"-->
                            <!-- :disabled="! (has_cap('cap-produccion') && data.status == 3 && edit_mode)  || originalOperarios[index].fullname" -->
                        </tbody>
                    </table>
                </div>
                <div class="col-12 col-md-6">
                    <table class="table table-sm mb-0">
                        <tbody>
                            <tr>
                                <th style="width: 50%;">FECHA:</th>
                                <td style="width: 50%;"><input :id="'operario-fec-'+index" type="text"
                                    v-mask="'##/##/####'"
                                    placeholder="DD/MM /YYYY"
                                    v-model="e.date"
                                    disabled="true"
                                    class="form-control form-control-sm defblue1"/></td>
                            </tr>
                            <!-- Se quitan los parametros disable por logica, dado que ahora se llenan "automaticamnente"-->
                            <!-- :disabled="! (has_cap('cap-produccion') && data.status == 3 && edit_mode) || originalOperarios[index].date" -->
                        </tbody>
                    </table>
                </div>
                <div class="col-12 text-end">
                    <!-- <a href="javascript:void(0);" v-if="(has_cap('cap-produccion') && data.status == 3 && edit_mode)" @click="removeOperator(index)" class="text-danger"><u>Eliminar ítem</u></a> -->
                </div>
            </div>
            <!--END BLOQUE DE REPETICION-->
            <div class="text-center mt-3">
                    <!-- <button v-if="(has_cap('cap-produccion') && data.status == 3 && edit_mode)" type="button" @click="addOperator" class="btn btn-secondary">Adicionar nuevo ítem</button> -->
            </div>

            <div class="table-responsive mt-5">
                <table class="table">
                    <thead>
                        <tr>
                            <th>CÓDIGO</th>
                            <th>DESCRIPCIÓN</th>
                            <th>PROCESO</th>
                            <th>CANTIDAD REQUERIDA</th>
                            <th style="display: none;">INVENTARIO</th>
                            <th>UNI</th>
                            <th>ALM</th>
                            <th>LOTE <i class="bi bi-info-circle" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="right" title='Escribe el primer número de lote y luego una "/" para el duplicado de lotes'></i></th>
                            <th>PRIMERA ENTREGA</th>
                            <th>SEGUNDA ENTREGA</th>
                            <th>DEVOLUCIÓN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(e,index) of data.materials" :key="index">
                            <td>{{e.code}}</td>
                            <td>{{e.description}}</td>
                            <td>{{e.process}}</td>
                            <td>{{e.required_amount}}</td>
                            <td style="display: none;">{{e.stock}}</td>
                            <td>{{e.unit}}</td>
                            <td>{{e.almacen}}</td>
                            <td class="text-center">
                                <input type="text" :disabled="!canEditMaterialsField" v-model="e.lot1" @input="handleInputUppercase('lot1', index)"  @keydown="checkIfDuplicateLote($event,index)" style="width: 200px;" placeholder="Ingresar valor ..." class="form-control form-control-sm defblue1" />
                            </td>
                            <td class="text-center">
                                <input type="text" :disabled="!canEditMaterialsField" v-model="e.entrega1"  style="width: 180px;" placeholder="Ingresar valor ..."  class="form-control form-control-sm defblue1"  @input="e.entrega1 = e.entrega1.replace(/[^0-9.]/g, '')" />
                            </td>
                            <td class="text-center">
                                <input type="text" :disabled="!canEditMaterialsField" v-model="e.entrega2"  style="width: 180px;" placeholder="Ingresar valor ..." class="form-control form-control-sm defblue1" @input="e.entrega2 = e.entrega2.replace(/[^0-9.]/g, '')" />
                            </td>
                            <td class="text-center">
                                <input type="text" :disabled="!canEditReturnField" v-model="e.return"  style="width: 180px;" placeholder="Ingresar valor ..." class="form-control form-control-sm defblue1" @input="e.return = e.return.replace(/[^0-9.]/g, '')" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <h6 class="px-3 fw-bold mt-6">OBSERVACIONES</h6>
            <textarea  :disabled="data.status == 4 || data.status == 1 || !((has_cap('cap-produccion') || has_cap('cap-auxcontrol-calidad') || has_cap('cap-bodega')) && edit_mode)" v-model="data.observations" placeholder="OBSERVACIONES: " class="form-control defblue1" rows="6"></textarea>

            <h6 class="px-3 fw-bold mt-6">PROCEDIMIENTO DE LLENADO Y EMPAQUE (Ver Hoja de verificación de envasado y empacado de sachet)</h6>
            <p class="px-3">Para Envases Flexibles: verificar que todos los insumos estén completos para el llenado del producto, mezclado y material de empaque, para el caso de sachet, el laminado aprobado previamente se ajusta en máquina y se procede al envasado, posteriormente se empaca en las cajas según contenido especificado.
                            Las especificaciones de envasado del producto (peso y volumen), se encuentran en la hoja de controles en proceso, anexa en cada orden de empaque. Los estándares relevantes para el consumidor (CRQS), se encuentran en cada orden de empaque.</p>

            <h6 class="px-3 fw-bold mt-6">ENTREGAS A PRODUCTO TERMINADO</h6>
            <div class="separator1 mb-2"></div>
            <!--START BLOQUE DE REPETICION-->
            <div class="row mt-2" v-for="(eg,index) of data.entregas" :key=" 'en' + index">
                <div class="col-12 col-md-3">
                <div class="row">
                    <div class="col-5">
                        FECHA:
                    </div>
                    <div class="col-7">
                        <input 
                            :id="'entrega-fec-'+index" 
                            type="text"
                            v-mask="'##/##/####'"
                            disabled
                            placeholder="DD/MM/YYYY"
                            class="form-control form-control-sm defblue1" 
                            v-model="eg.date" 
                        />
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="row">
                    <div class="col-5">
                        CANTIDAD (C/U)
                    </div>
                    <div class="col-7">
                        <div class="d-flex align-items-center">
                            <input 
                                type="number"
                                :disabled="!canEditCantidad(index)"
                                placeholder="Cajas"
                                class="form-control form-control-sm defblue1 me-1"
                                :value="getPart(eg.cantidad, 0)"
                                @input="updateCompositeField(index, 'cantidad', 0, $event.target.value)"
                                style="width: 50%"
                                />

                                <input 
                                type="number"
                                :disabled="!canEditCantidad(index)"
                                placeholder="Unid"
                                class="form-control form-control-sm defblue1 ms-1"
                                :value="getPart(eg.cantidad, 1)"
                                @input="updateCompositeField(index, 'cantidad', 1, $event.target.value)"
                                style="width: 50%"
                                />

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="row">
                    <div class="col-5">
                        ENTREGADO
                    </div>
                    <div class="col-7">
                        <input
                            :id="'entrega-entregado-'+index"
                            type="text"
                            disabled
                            placeholder="..."
                            class="form-control form-control-sm defblue1"
                            v-model="eg.entrega"
                        />
                    </div>

                   
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="row">
                    <div class="col-5">
                        RECIBIDO (C/U)
                    </div>
                    <div class="col-7">
                        <div class="d-flex align-items-center">
                            <input 
                                type="number"
                                :disabled="!canEditRecibido(index)"
                                placeholder="Cajas"
                                class="form-control form-control-sm defblue1 me-1"
                                :value="getPart(eg.recibe, 0)"
                                @input="updateCompositeField(index, 'recibe', 0, $event.target.value)"
                                style="width: 50%"
                            />

                            <input 
                                type="number"
                                :disabled="!canEditRecibido(index)"
                                placeholder="Unid"
                                class="form-control form-control-sm defblue1 ms-1"
                                :value="getPart(eg.recibe, 1)"
                                @input="updateCompositeField(index, 'recibe', 1, $event.target.value)"
                                style="width: 50%"
                            />

                        </div>
                    </div>
                </div>
            </div>
                <div class="col-12 text-end">
                    <!-- Opcional: botón para eliminar -->
                </div>
                <div class="col-12 text-end">
                    <!-- <a href="javascript:void(0);" v-if="(has_cap('cap-produccion') && data.status == 3 && edit_mode)" @click="removeEntregasItem(index)" class="text-danger"><u>Eliminar ítem</u></a> -->
                </div>
            </div>
            <!--END BLOQUE DE REPETICION-->
            <div class="text-center mt-3">
                    <!-- <button v-if="(has_cap('cap-produccion') && data.status == 3 && edit_mode)" type="button" @click="addEntregas" class="btn btn-secondary">Adicionar nuevo ítem</button> -->
            </div>
            <div class="separator1 mt-2"></div>

            <div class="row mt-6">
                <div class="col-12 col-md-4 text-center">
                    <input disabled="true" :value="data.auditor.user_entrega" type="text" class="form-control form-control-sm text-center d-block defblue1">
                    <label for="">ENTREGADO BODEGA</label>
                </div>
                <div class="col-12 col-md-4 text-center">
                    <input disabled="true" :value="data.status >= 3 ? data.auditor.user_autoriza : null" type="text" class="form-control form-control-sm text-center d-block defblue1">
                    <label for="">AUTORIZADO</label>
                </div>
                <div class="col-12 col-md-4 text-center">
                    <input disabled="true" :value="data.auditor.user_recibe" type="text" class="form-control form-control-sm text-center d-block defblue1">
                    <label for="">RECIBIDO PRODUCCION</label>
                </div>
            </div>


            <div class="modal fade" id="confirmSignModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ confirmModal.title }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>

                    <div class="modal-body">
                        <p class="mb-0">{{ confirmModal.message }}</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" :disabled="confirmModal.loading">
                        Cancelar
                        </button>

                        <button type="button" class="btn btn-info" @click="confirmAndSign" :disabled="confirmModal.loading">
                        <span v-if="confirmModal.loading" class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                        Confirmar
                        </button>
                    </div>
                    </div>
                </div>
                </div>



            <div class="text-end mt-6">
                <div class="col-auto">
                    <button type="button" v-if="data.order_id != 0" @click="generatedReport" class="btn btn-dark"><i class="bi bi-file-earmark-pdf"></i> Generar</button>
                    <!--
                    <button type="button" v-if="(data.status == 1 || data.status == 2) && (has_cap('cap-bodega') || has_cap('cap-supcalidad') || has_cap('cap-produccion')) " @click="edit_mode = true;" class="btn btn-primary">Modificar</button>
                    <button type="button" v-if="edit_mode && (data.status == 1 || data.status == 2) && (has_cap('cap-bodega') || has_cap('cap-supcalidad') || has_cap('cap-produccion'))" @click="takeOrder" class="btn btn-success">Guardar</button> -->

                   <button
                        type="button"
                        v-if="canEdit && !edit_mode"
                        :disabled="data.verificacion_lote == 1 && has_cap('cap-bodega') && !has_cap('cap-produccion')"
                        @click="edit_mode = true;"
                        class="btn btn-primary"
                        >
                        Modificar
                    </button>

                    <!-- boton guardar -->
                    <button 
                        type="button" 
                        v-if="edit_mode && canShowSaveButton" 
                        @click="takeOrder" 
                        class="btn btn-success"
                    >
                        Guardar
                    </button>

                    <!-- <button 
                    type="button" 
                    v-if="edit_mode && (((data.status == 1 || data.status == 2) && (has_cap('cap-supcalidad') || has_cap('cap-produccion') || has_cap('cap-auxcontrol-calidad'))) || (data.status == 2 && has_cap('cap-bodega')))" 
                    @click="takeOrder" 
                    class="btn btn-success"
                    >
                    Guardar
                    </button> -->

                    <!-- <button type="button" v-if="edit_mode && data.status == 2 && has_cap('cap-supcalidad')" @click="authorize" class="btn btn-success">Guardar</button>                 -->

                    <!-- <button type="button"  v-if="canEdit2 && !edit_mode" @click="edit_mode = true" class="btn btn-warning">Modificar</button> -->

                    <button type="button" v-if="edit_mode && data.status == 3 && has_cap('cap-produccion')" @click="updateTracking" class="btn btn-success">Guardar</button>
                    
                    <button type="button" v-if="edit_mode == false && data.status == 2 && has_cap('cap-auxcontrol-calidad')"  :disabled="data.verificacion_lote == 0" @click="authorize" class="btn btn-success">Autorizar</button>

                    <button type="button" v-if="edit_end == false && edit_mode == false && parseInt(data.status) === 3 && has_cap('cap-produccion')" @click="preFinish" class="btn btn-success">Finalizar</button>
                    <button type="button" v-if="edit_end && data.status == 3 && has_cap('cap-produccion')" @click="finishOrder" class="btn btn-success">Confirmar</button>

                    <!-- Botones exclusivos para Bodega PT: editar Recibidos -->
                    <button
                        type="button"
                        v-if="has_cap('cap-bodegapt') && !edit_mode_bodegapt && parseInt(data.status) == 4"
                        @click="edit_mode_bodegapt = true"
                        class="btn btn-warning"
                    >
                        Modificar Recibidos
                    </button>
                    <button
                        type="button"
                        v-if="has_cap('cap-bodegapt') && edit_mode_bodegapt"
                        @click="saveBodegaPT"
                        class="btn btn-success"
                    >
                        Guardar Recibidos
                    </button>
                    <!-- Botón Verificar / Estado -->
                    <button
                        type="button"
                        v-if="data.status == 2 && (has_cap('cap-auxcontrol-calidad') || has_cap('cap-jefecontrol-calidad'))"
                        @click="handleVerifyLot"
                        :disabled="verifying || data.verificacion_lote == 1 || edit_mode == true"
                        class="btn"
                        :class="data.verificacion_lote == 1 ? 'btn-secondary' : 'btn-success'">
                        <template v-if="verifying">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Verificando...
                        </template>
                        <template v-else>
                            <span v-if="data.verificacion_lote == 1">
                                Verificado ✓ <small class="ms-2">({{ data.user_verifico || '—' }})</small>
                            </span>
                            <span v-else>
                                Verificar
                            </span>
                        </template>
                    </button>



                    <button
                        type="button"
                        v-if="has_cap('cap-bodega') && data.status >= 1 && data.status < 4 && !data.auditor.user_entrega"
                        :disabled="data.verificacion_lote != 1"
                        @click="openConfirmModal('entrega')"
                        class="btn btn-info"
                        >
                        Entregar Materiales
                    </button>

                    <button
                        type="button"
                        v-if="has_cap('cap-produccion') && data.status >= 1 && data.status < 4 && !data.auditor.user_recibe"
                        :disabled="!data.auditor.user_entrega"
                        @click="openConfirmModal('recibe')"
                        class="btn btn-info">
                        Recibir Materiales
                    </button>

                </div>
            </div>

        </div>
    </div>

</template>

<script>
    const {upsertOrderPacking,authorizePacking,updateTracking,finishPacking, obtenerLotePorOrden, verifyPackingLot, getPackingOrderDB, getUXCByOrder, signPackingOrder} = require("../service.js");
    const {formatPackingDB,getJSONTimes,getJSONOperarios,getJSONEntregas} = require("../helpers.js");


import { data } from 'jquery';
import moment from 'moment';
    import { VueMaskDirective } from 'v-mask'
    Vue.directive('mask', VueMaskDirective);

    export default ({
        props: {
            source: {type: Object,required: true}
        },
        data: function(){
            return {
                data: this.source,
                app_vars: {},
                flags: {
                    F1: false,
                    F2: false
                },
                edit_mode: false,
                edit_mode_bodegapt: false, // flag independiente para cap-bodegapt
                edit_end: false,//para campos antes de cierre de orden
                originalTimes: [],
                originalOperarios: [],
                originalEntregas: [],
                lockedEntregas: [], // 🔒 Locks en memoria para bloqueo inmediato
                verifying: false,
                confirmModal: {
                type: null,     // 'entrega' | 'recibe'
                title: '',
                message: '',
                loading: false,
                instance: null, // bootstrap modal instance
                },
            }
        },
        mounted() {
        // Al cargar los datos, almacenas los valores originales de `date_init`
        this.reloadOriginalTimes();
        this.reloadOriginalOperarios();
        this.reloadOriginalEntregas();
        this.initializeLockedEntregas(); // 🔒 Inicializar locks en memoria
        this.checkIfEndDateFilled();
           this.$nextTick(() => {
                this.initDatepickers(); // Espera a que Vue haya terminado de renderizar
            });
        // 🔹 Sincronizar fechas al inicio
        // this.syncEndDatesWithOperarios();
            // Inicializa el modal (Bootstrap 5)
            const el = document.getElementById('confirmSignModal');
            if (el && window.bootstrap) {
                this.confirmModal.instance = new window.bootstrap.Modal(el, { backdrop: 'static', keyboard: false });
            }
        },
        computed: {
            // canEdit() {
            //     const isEditableStatus = this.data.status === 1 || this.data.status === 2;
            //     const hasMainCaps = this.has_cap('cap-supcalidad') || this.has_cap('cap-produccion') || this.has_cap('cap-auxcontrol-calidad');
            //     const bodegaCondition = this.data.status === 2 && this.has_cap('cap-bodega');

            //     return (isEditableStatus && hasMainCaps) || bodegaCondition;
            // }
            canEdit() {
                // Estado <= 3: Bodega puede editar
                if (this.data.status <= 3 && this.has_cap('cap-bodega')) {
                    return true;
                }
                
                // Producción puede editar (en estado 2 o 3) SOLO si ya se entregó y recibió materiales
                if (this.has_cap('cap-produccion') && (this.data.status === 2 || this.data.status === 3)) {
                    if (this.data.auditor.user_entrega && this.data.auditor.user_recibe) {
                        return true;
                    }
                }

                // Otros roles autorizados para modificar en estados iniciales (Supervisor, Auxiliar)
                if (this.data.status === 1 || this.data.status === 2) {
                    if (this.has_cap('cap-supcalidad') || this.has_cap('cap-auxcontrol-calidad')) {
                        return true;
                    }
                }

                return false;
            },
            canEdit2() {
                // Para otros estados, mantener la lógica original
                const hasMainCaps = this.has_cap('cap-supcalidad') || this.has_cap('cap-produccion') || this.has_cap('cap-auxcontrol-calidad');
                return (this.data.status === 3 || this.data.status === 4) && hasMainCaps;
            },
            canShowSaveButton() {
                // Estado <= 3: solo bodega
                if (this.data.status <= 3 && this.has_cap('cap-bodega')) {
                    return true;
                }
                
                // Producción en status 3 usa su propio botón (updateTracking), no este
                // Producción solo puede usar este botón en status 2 (antes de autorización)
                if (this.has_cap('cap-produccion') && this.data.status === 2) {
                    if (this.data.auditor.user_entrega && this.data.auditor.user_recibe) {
                        return true;
                    }
                }
                
                // Otros casos para supcalidad y auxcontrol-calidad (manteniendo la lógica original)
                return (this.data.status == 1 || this.data.status == 2) && 
                    (this.has_cap('cap-supcalidad') || this.has_cap('cap-auxcontrol-calidad'));
            },
            canEditMaterialsField() {
                 // Solo permitir edición si el estado es menor a 4 (no finalizado)
                 if (this.data.status >= 4) {
                     return false;
                 }
                 
                 return this.edit_mode && (
                    (this.has_cap('cap-bodega') && this.data.status <= 3) ||
                    (this.has_cap('cap-supcalidad') && this.data.status == 1)
                 );
            },
            canEditReturnField() {
                 if (this.data.status >= 4) {
                     return false;
                 }
                 return this.edit_mode && this.has_cap('cap-produccion');
            }
        },
        created: function(){
            this.app_vars = window.AppVars;
             // Establecer el rendimiento teórico igual al total de unidades
            // if (this.data.total_units && !this.data.performance_teorico) {
            //     this.data.performance_teorico = this.data.total_units;
            // }
        },
        methods: {
            // syncEndDatesWithOperarios() {
            //         if (this.data.times && this.data.operarios) {
            //             this.data.times.forEach((t, index) => {
            //                 if (this.data.operarios[index]?.date) {
            //                     t.date_end = this.data.operarios[index].date;
            //                 }
            //             });
            //         }
            // },
            canEditCantidad(index) {
                // Orden finalizada: todo bloqueado
                if (parseInt(this.data.status) >= 4) return false;

                // La entrega solo se habilita si la línea de tiempo correspondiente tiene fecha de finalización
                const time = this.data.times && this.data.times[index];
                if (!time || !time.date_end) return false;

                // El rol que finaliza (Producción) puede editar durante la finalización
                if (this.edit_end && this.has_cap('cap-produccion')) return true;

                if (!this.edit_mode) return false;

                const status = parseInt(this.data.status);

                // Permitir si es Producción y status <= 3
                return this.has_cap('cap-produccion') && status <= 3;
            },

            canEditRecibido(index) {
                // "Recibido" es exclusivo de cap-bodegapt
                if (!this.has_cap('cap-bodegapt')) return false;

                // La entrega solo se habilita si la línea de tiempo tiene fecha de finalización
                const time = this.data.times && this.data.times[index];
                if (!time || !time.date_end) return false;

                const status = parseInt(this.data.status);

                // En status 4 (finalizada): solo permitir si edit_mode_bodegapt está activo
                if (status >= 4) {
                    return this.edit_mode_bodegapt;
                }

                // En status <= 3: permitir con edit_mode, edit_end o edit_mode_bodegapt
                return this.edit_mode || this.edit_end || this.edit_mode_bodegapt;
            },

            getPart(value, partIndex) {
                if (!value && value !== 0) return ''; // Permite valor 0
                const parts = String(value).split('/');
                return parts[partIndex] || '';
            },
            updateCompositeField(index, field, partIndex, newValue) {
                let currentValue = this.data.entregas[index][field];
                if (currentValue === null || currentValue === undefined) currentValue = '';
                
                let parts = String(currentValue).split('/');
                if (parts.length < 2) parts = [parts[0] || '', ''];
                
                // Guardar el valor anterior ANTES de actualizar (para comparar con recibe)
                const oldPartValue = parts[partIndex];
                
                // Actualizar la parte correspondiente
                parts[partIndex] = newValue;
                this.data.entregas[index][field] = parts.join('/');

                // 🔄 Sincronizar CANTIDAD → RECIBIDO si aún están en sintonía
                if (field === 'cantidad') {
                    let currentRecibe = this.data.entregas[index]['recibe'];
                    if (currentRecibe === null || currentRecibe === undefined) currentRecibe = '';
                    let recibeParts = String(currentRecibe).split('/');
                    if (recibeParts.length < 2) recibeParts = [recibeParts[0] || '', ''];

                    // Actualizar recibe si:
                    // - Recibe está vacío (primera vez), O
                    // - Recibe tiene el mismo valor que el ANTERIOR de cantidad (siguen en sincronía)
                    if (!recibeParts[partIndex] || recibeParts[partIndex].trim() === '' || recibeParts[partIndex] === oldPartValue) {
                        recibeParts[partIndex] = newValue;
                        this.data.entregas[index]['recibe'] = recibeParts.join('/');
                    }
                }
                
                this.$forceUpdate(); 
            },


            // Auto-rellena fecha y hora con la fecha/hora actual si están vacías
            // type: 'init' (por defecto) o 'end'
            autoFillDateTime(index, type) {
                const e = this.data.times[index];
                if (type === 'end') {
                    if (!e.date_end && !e.time_end) {
                        const now = moment();
                        e.date_end = now.format('YYYY-MM-DD');
                        e.time_end = now.format('HH:mm');
                        this.$forceUpdate();
                    }
                } else {
                    if (!e.date_init && !e.time_init) {
                        const now = moment();
                        e.date_init = now.format('YYYY-MM-DD');
                        e.time_init = now.format('HH:mm');
                        this.$forceUpdate();
                    }
                }
            },

            canEditEntrega(index) {

                if (!this.edit_mode) return false;

                let status = parseInt(this.data.status);

                // Permitir a Bodega en estados <= 3
                if (this.has_cap('cap-bodega') && status <= 3) {
                     return true; 
                }

                // Verificar permisos y estado para Producción
                if (this.has_cap('cap-produccion') && status == 3) {
                    // Verificar que exista el time correspondiente
                    if (!this.data.times || !this.data.times[index]) {
                        return false;
                    }

                    const time = this.data.times[index];

                    // Verificar que fecha y hora de inicio estén llenas
                    const hasInit = time.date_init && time.date_init !== null && 
                                time.time_init && time.time_init !== null;

                    // Solo habilitar si (inicio) están llenos
                    return hasInit;
                }

                return false;
            },
            isFieldLocked(index, fieldName) {
                // Bloqueo total si la orden está finalizada
                if (Number(this.data.status) >= 4) {
                    return true; 
                }

                // Para Cantidad y Recibe, permitir edición hasta el final (status < 4)
                if (fieldName === 'cantidad' || fieldName === 'recibe') {
                    return false;
                }

                // 🔒 Para otros campos (como firmas), verificar locks en memoria (bloqueo inmediato)
                if (this.lockedEntregas[index] && this.lockedEntregas[index][fieldName]) {
                    return true;
                }

                // Verificar si existe el índice en los datos originales (bloqueo desde BD)
                if (!this.originalEntregas || !this.originalEntregas[index]) {
                    return false;
                }

                const originalValue = this.originalEntregas[index][fieldName];
                if (originalValue === null || originalValue === undefined) return false;

                const strVal = String(originalValue).trim();
                return strVal !== '';
            },
            // 1. MODIFICAR la inicialización de los datepickers para actualizar el modelo Vue
            initDatepickers() {
                const self = this; // Referencia a la instancia de Vue
                
                // Configuración de datepickers
                $('.datepicker-init').datepicker({
                    format: 'dd/mm/yyyy',
                    language: 'es',
                    autoclose: true,
                    todayHighlight: true,
                    clearBtn: true,
                    weekStart: 1
                }).on('changeDate', function(e) {
                    // Actualizar el modelo Vue cuando cambia la fecha
                    const index = $(this).attr('id').split('-')[2];
                    self.data.times[index].date_init = $(this).val();
                    // Forzar actualización del modelo de Vue
                    self.$forceUpdate();
                });

                $('.datepicker-end').datepicker({
                    format: 'dd/mm/yyyy',
                    language: 'es',
                    autoclose: true,
                    todayHighlight: true,
                    clearBtn: true,
                    weekStart: 1
                }).on('changeDate', function(e) {
                    // Actualizar el modelo Vue cuando cambia la fecha
                    const index = $(this).attr('id').split('-')[2];
                    self.data.times[index].date_end = $(this).val();
                    // Forzar actualización del modelo de Vue
                    self.$forceUpdate();
                });

                // Configuración de timepickers
                // FIXED: Timepicker configuration with proper Vue model binding
               $('.timepicker-init').timepicker({
                    showMeridian: false,
                    minuteStep: 1,
                    defaultTime: false,
                    showInputs: true,
                    template: 'dropdown',
                    modalBackdrop: true,
                    icons: {
                    up: 'bi bi-chevron-up',
                    down: 'bi bi-chevron-down'
                    }
                }).on('changeTime.timepicker', function (e) {
                    const index = $(this).data('index');
                    const hour = e.time.hours.toString().padStart(2, '0');
                    const minute = e.time.minutes.toString().padStart(2, '0');
                    self.data.times[index].time_init = `${hour}:${minute}`;
                    self.$forceUpdate();
                });

                $('.timepicker-end').timepicker({
                    showMeridian: false,
                    minuteStep: 1,
                    defaultTime: false,
                    showInputs: true,
                    template: 'dropdown',
                    modalBackdrop: true,
                    icons: {
                    up: 'bi bi-chevron-up',
                    down: 'bi bi-chevron-down'
                    }
                }).on('changeTime.timepicker', function (e) {
                    const index = $(this).data('index');
                    const hour = e.time.hours.toString().padStart(2, '0');
                    const minute = e.time.minutes.toString().padStart(2, '0');
                    self.data.times[index].time_end = `${hour}:${minute}`;
                    self.$forceUpdate();
                });
            },
            addTimes: function(){
                this.data.times.push(getJSONTimes());
            },
            removeTimeItem: async function(index){
                if(this.data.times.length == 1){
                    StatusHandler.ValidationMsg("Se requiere al menos un item sobre control de tiempo");
                    return;
                }

                var confirm = await StatusHandler.Confirm("!Confirmar eliminación!");
                if(!confirm)return;

                this.data.times.splice(index,1);
            },
            addOperator: function(){
                this.data.operarios.push(getJSONOperarios());
            },
            removeOperator: async function(index){
                if(this.data.operarios.length == 1){
                    StatusHandler.ValidationMsg("Se requiere al menos un item de operadores responsables");
                    return;
                }

                var confirm = await StatusHandler.Confirm("!Confirmar eliminación!");
                if(!confirm)return;

                this.data.operarios.splice(index,1);
            },
            addEntregas: function (){
                this.data.entregas.push(getJSONEntregas());
            },
            openConfirmModal(type) {
                this.confirmModal.type = type;

                const isEntrega = type === 'entrega';
                this.confirmModal.title = isEntrega ? 'Confirmar entrega' : 'Confirmar recepción';
                this.confirmModal.message = isEntrega
                    ? '¿Deseas confirmar la entrega de materiales? Esta acción quedará registrada.'
                    : '¿Deseas confirmar la recepción de materiales? Esta acción quedará registrada.';

                this.confirmModal.loading = false;

                if (this.confirmModal.instance) this.confirmModal.instance.show();
            },
            async confirmAndSign() {
                if (!this.confirmModal.type) return;

                try {
                this.confirmModal.loading = true;

                // Ejecuta tu lógica actual
                await this.signOrder(this.confirmModal.type);

                // Cierra modal si todo ok (tu signOrder ya muestra mensajes)
                if (this.confirmModal.instance) this.confirmModal.instance.hide();
                } finally {
                this.confirmModal.loading = false;
                this.confirmModal.type = null;
                }
            },
            async signOrder(type) {
                try {
                const response = await signPackingOrder(this.data.order_id, type);

                if (response.data.code === 1) {
                    StatusHandler.ValidationMsg("Firmado correctamente");

                    // Actualizar localmente para reflejar el cambio inmediato
                    if (type === 'entrega') this.data.auditor.user_entrega = response.data.data.user_entrega;
                    if (type === 'recibe') this.data.auditor.user_recibe = response.data.data.user_recibe;

                    this.$forceUpdate();
                } else {
                    StatusHandler.ValidationMsg(response.data.msg);
                }
                } catch (e) {
                StatusHandler.Exception("Error al firmar", e);
                }
            },
            removeEntregasItem: async function(index){
                if(this.data.entregas.length == 1){
                    StatusHandler.ValidationMsg("Se requiere al menos un item de entregas");
                    return;
                }

                var confirm = await StatusHandler.Confirm("!Confirmar eliminación!");
                if(!confirm)return;

                this.data.entregas.splice(index,1);
            },
            checkIfStartDateFilled(){
                const formattedDate = moment().format('DD/MM/YYYY');
                let anyStartSet = false;

                this.data.times.forEach((time, index) => {
                    if (time.date_init && time.time_init) {
                        anyStartSet = true;
                    }
                });

                // Si se llenó al menos un campo de inicio, asignamos firma
                if (anyStartSet) {
                    this.data.auditor.user_recibe = this.app_vars.current_user.user_fullname;
                }
            },

            takeOrder: async function(){
                // Validaciones de permisos previas
                // Si es usuario de Bodega, no puede ejecutar esta acción aquí
                // if (this.has_cap('cap-bodega') && !this.has_cap('cap-produccion')) {
                //     StatusHandler.ValidationMsg("Operación denegada: usuario de Bodega no tiene autorización para ejecutar esta acción. Espere verificación de Producción.");
                //     return;
                // }

                // Si es usuario de Producción, exigir que la orden ya haya sido verificada
                // (verificacion_lote === 1 y user_verifico distinto de null/empty)
                if (this.has_cap('cap-produccion')) {
                    if (!(Number(this.data.verificacion_lote) === 1 && this.data.user_verifico && this.data.user_verifico.trim() !== '')) {
                        StatusHandler.ValidationMsg("Primero debe verificar la orden para proceder con el llenado de fechas y horas de inicio.");
                        return;
                    }
                }

                // Lote: required , entrega1: required (tu validación vieja)
                var flag3 = false;
                var msg3 = "";
              
                if(flag3){ StatusHandler.ValidationMsg(msg3); return; }

                var confirm = await StatusHandler.Confirm("!Confirmar guardado!","");
                if(!confirm) return;

                StatusHandler.LShow();

                if(this.data.status == 1){
                    // Si está pendiente de tomar se limpia JSONs como logic tuya
                    this.data.operarios[0] = getJSONOperarios();
                    this.data.operarios[1] = getJSONOperarios();
                    this.data.operarios[2] = getJSONOperarios();

                    this.data.entregas[0] = getJSONEntregas();
                    this.data.entregas[1] = getJSONEntregas();
                    this.data.entregas[2] = getJSONEntregas();
                }

                // DEBUG
                // console.log(this.data.lot_num)
                // console.log(this.data.observations)

                try {
                    const result = await upsertOrderPacking(this.data);
                    const response = result.data;
                    if(response.code == 0){
                        StatusHandler.ShowStatus(response.msg, StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
                        return;
                    }

                    // Actualizamos el modelo local (usando tu helper)
                    this.data = formatPackingDB(response.data);
                    this.edit_mode = false;
                    
                    // 🔒 Reinicializar locks después de guardar
                    this.reloadOriginalTimes();
                    this.reloadOriginalOperarios();
                    this.reloadOriginalEntregas();
                    this.initializeLockedEntregas();

                    StatusHandler.LClose();
                    StatusHandler.ShowStatus("Guardado Existoso!", StatusHandler.OPERATION.CREATE, StatusHandler.STATUS.SUCCESS);
                } catch(ex) {
                    StatusHandler.LClose();
                    StatusHandler.Exception("Guardar orden", ex);
                }
            },

            saveBodegaPT: async function() {
                var confirm = await StatusHandler.Confirm("¿Confirmar guardado de recibidos?", "");
                if (!confirm) return;

                StatusHandler.LShow();
                try {
                    const result = await upsertOrderPacking(this.data);
                    const response = result.data;
                    if (response.code == 0) {
                        StatusHandler.ShowStatus(response.msg, StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
                        return;
                    }

                    this.data = formatPackingDB(response.data);
                    this.edit_mode_bodegapt = false;

                    this.reloadOriginalTimes();
                    this.reloadOriginalOperarios();
                    this.reloadOriginalEntregas();
                    this.initializeLockedEntregas();

                    StatusHandler.LClose();
                    StatusHandler.ShowStatus("Recibidos guardados exitosamente!", StatusHandler.OPERATION.CREATE, StatusHandler.STATUS.SUCCESS);
                } catch (ex) {
                    StatusHandler.LClose();
                    StatusHandler.Exception("Guardar recibidos", ex);
                }
            },

        async handleVerifyLot() {
            // Protege contra doble click
            if (this.verifying) return;

            // Confirmación
            const confirm = await StatusHandler.Confirm("¿Confirmar que desea marcar la verificación de lote?");
            if (!confirm) return;

            try {
                this.verifying = true;
                StatusHandler.LShow();

                // 1️⃣ Llamar al endpoint de verificación
                const res = await verifyPackingLot(this.data.order_id, { lot_num: this.data.lot_num });
                const payload = res.data;

                if (!payload || payload.code !== 1) {
                    StatusHandler.LClose();
                    StatusHandler.ShowStatus(
                        payload ? payload.msg : "Respuesta inesperada",
                        StatusHandler.OPERATION.DEFAULT,
                        StatusHandler.STATUS.FAIL
                    );
                    this.verifying = false;
                    return;
                }

                // 2️⃣ RECARGAR toda la orden desde searchDB
                const resultSearch = await getPackingOrderDB(this.data.num_id);
                const responseSearch = resultSearch.data;

                if (responseSearch.code === 0) {
                    StatusHandler.LClose();
                    StatusHandler.ShowStatus(
                        responseSearch.msg,
                        StatusHandler.OPERATION.DEFAULT,
                        StatusHandler.STATUS.FAIL
                    );
                    this.verifying = false;
                    return;
                }

                // 3️⃣ Actualizar el modelo local con los datos completos
                this.data = formatPackingDB(responseSearch.data);

                // 4️⃣ Recargar datos originales para el tracking
                this.reloadOriginalTimes();
                this.reloadOriginalOperarios();
                this.reloadOriginalEntregas();
                this.initializeLockedEntregas(); // 🔒 Reinicializar locks

                StatusHandler.LClose();
                StatusHandler.ShowStatus(
                    "Verificación registrada correctamente",
                    StatusHandler.OPERATION.CREATE,
                    StatusHandler.STATUS.SUCCESS
                );

            } catch (ex) {
                StatusHandler.LClose();
                StatusHandler.Exception("Verificar lote", ex);
            } finally {
                this.verifying = false;
            }
        },
            authorize: async function(){
                console.log("AUTORIZE")

                if(this.data.lot_num == null || this.data.lot_num.length < 1){
                    StatusHandler.ValidationMsg("Ingrese el numero de lote");
                    return;
                }
                var confirm = await StatusHandler.Confirm("!Confirmar Autorización!");
                if(!confirm)return;

                if(this.data.order_id == 0){alert("Inconsistencia identificador");return;}

                StatusHandler.LShow();
                var data_send = {
                    lot_num: this.data.lot_num
                }
                authorizePacking(this.data.order_id,data_send).then(result=>{
                    let response = result.data;
                    if(response.code == 0){
                        StatusHandler.ShowStatus(response.msg,StatusHandler.OPERATION.DEFAULT,StatusHandler.STATUS.FAIL);
                        return;
                    }

                    this.data = formatPackingDB(response.data);
                    
                    // 🔒 Reinicializar locks después de autorizar
                    this.reloadOriginalTimes();
                    this.reloadOriginalOperarios();
                    this.reloadOriginalEntregas();
                    this.initializeLockedEntregas();

                    // StatusHandler.LClose();
                    StatusHandler.ShowStatus("Aprobado con exito!",StatusHandler.OPERATION.CREATE,StatusHandler.STATUS.SUCCESS);
                }).catch(ex=>{
                    // StatusHandler.LClose();
                    StatusHandler.Exception("Guardar orden",ex);
                });
            },
            // 2. MODIFICAR la función updateTracking para validar correctamente las fechas
            updateTracking: async function(){
                console.log("UPDATETRACKING");
                
                // Validate dates and times
                let invalidDates = false;
                let invalidMessage = "";
                
                this.data.times.forEach((time, index) => {
                    // If start date entered, verify that start time is also entered
                    if (time.date_init && !time.time_init) {
                        invalidDates = true;
                        invalidMessage = `Ítem ${index+1}: Se ingresó fecha de inicio pero no hora de inicio`;
                    }
                    
                    // If end date entered, verify that end time is also entered
                    if (time.date_end && !time.time_end) {
                        invalidDates = true;
                        invalidMessage = `Ítem ${index+1}: Se ingresó fecha de finalización pero no hora de finalización`;
                    }
                    
                    // End date requires start date
                    if (time.date_end && !time.date_init) {
                        invalidDates = true;
                        invalidMessage = `Ítem ${index+1}: No puede ingresar fecha de finalización sin fecha de inicio`;
                    }
                });
                
                if (invalidDates) {
                    StatusHandler.ValidationMsg(invalidMessage);
                    return;
                }

                // Validate end dates to automatically fill in responsible parties
                this.checkIfEndDateFilled();

                // Validate performance data
                if(this.data.performance_teorico != null && isNaN(parseInt(this.data.performance_teorico))){
                    StatusHandler.ValidationMsg("Rendimiento teorico no valido");
                    return;
                }

                if(this.data.performance != null && isNaN(parseInt(this.data.performance))){
                    StatusHandler.ValidationMsg("Rendimiento no valido");
                    return;
                }

                var confirm = await StatusHandler.Confirm("!Confirmar guardado!", "");
                if(!confirm) return;

                if(this.data.order_id == 0){
                    alert("Inconsistencia identificador");
                    return;
                }
                // ✅ Asignar firma si corresponde
                // (Se ha eliminado la llamada automática a checkIfStartDateFilled según petición)
                // this.checkIfStartDateFilled();
                // DEBUG: Log time data before sending
                console.log("Times data before save:", JSON.stringify(this.data.times));

                var data_send = {
                    times: JSON.stringify(this.data.times),
                    operarios: JSON.stringify(this.data.operarios),
                    entregas: JSON.stringify(this.data.entregas),
                    materials: JSON.stringify(this.data.materials),
                    // performance_teorico: this.data.total_units,
                    performance: this.data.performance,
                    observations: this.data.observations
                }

                StatusHandler.LShow();
                updateTracking(this.data.order_id, data_send).then(result=>{
                    let response = result.data;
                    if(response.code == 0){
                        StatusHandler.ShowStatus(response.msg, StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
                        return;
                    }

                    this.data = formatPackingDB(response.data);
                    this.edit_mode = false;
                    this.reloadOriginalTimes();
                    this.reloadOriginalOperarios();
                    this.reloadOriginalEntregas();
                    this.initializeLockedEntregas(); // 🔒 Reinicializar locks después de guardar
                    StatusHandler.LClose();
                    StatusHandler.ShowStatus("Modificado con exito!", StatusHandler.OPERATION.CREATE, StatusHandler.STATUS.SUCCESS);
                }).catch(ex=>{
                    StatusHandler.LClose();
                    StatusHandler.Exception("Guardar orden", ex);
                });
            },
            // updateTracking: async function(){
            //     console.log("UPDATETRACKING")
            //     //validar fechas y horas aqui

            //     // Se valida las fechas de finalizacion para llenar automaticamente los responsables

            //     this.checkIfEndDateFilled();


            //     if(this.data.performance_teorico != null  && isNaN(parseInt(this.data.performance_teorico))){
            //         StatusHandler.ValidationMsg("Rendimiento teorico no valido");
            //         return;
            //     }

            //     if(this.data.performance != null && isNaN(parseInt(this.data.performance))){
            //         StatusHandler.ValidationMsg("Rendimiento no valido");
            //         return;
            //     }


            //     var confirm = await StatusHandler.Confirm("!Confirmar guardado!", "");
            //     if(!confirm)return;

            //     if(this.data.order_id == 0){alert("Inconsistencia identificador");return;}


            //     var data_send = {
            //         times: JSON.stringify(this.data.times),
            //         operarios: JSON.stringify(this.data.operarios),
            //         entregas: JSON.stringify(this.data.entregas),
            //         performance_teorico: this.data.total_units,
            //         performance: this.data.performance,
            //         observations: this.data.observations
            //     }

            //     StatusHandler.LShow();
            //     updateTracking(this.data.order_id,data_send).then(result=>{
            //         let response = result.data;
            //         if(response.code == 0){
            //             StatusHandler.ShowStatus(response.msg,StatusHandler.OPERATION.DEFAULT,StatusHandler.STATUS.FAIL);
            //             return;
            //         }

            //         this.data = formatPackingDB(response.data);
            //         this.edit_mode = false;
            //         this.reloadOriginalTimes();
            //         this.reloadOriginalOperarios();
            //         this.reloadOriginalEntregas();
            //         StatusHandler.LClose();
            //         StatusHandler.ShowStatus("Modificado con exito!",StatusHandler.OPERATION.DEFAULT,StatusHandler.STATUS.SUCCESS);
            //     }).catch(ex=>{
            //         StatusHandler.LClose();
            //         StatusHandler.Exception("Guardar orden",ex);
            //     });
            // },

            preFinish: async function() {
                this.edit_end = true;

                // Calcular cajas/unidades
                let sum_cajas = 0, sum_unidades = 0;
                for (let eg of this.data.entregas) {
                    if (eg.cantidad && typeof eg.cantidad === 'string') {
                        const [cajas, unidades] = eg.cantidad.split('/').map(p => parseInt(p.trim(), 10) || 0);
                        sum_cajas += cajas;
                        sum_unidades += unidades || 0;
                    }
                }

                const orderCode = this.data.num_id?.trim();
                if (!orderCode) {
                    StatusHandler.ValidationMsg("No se puede asignar rendimiento teórico: número de orden no disponible");
                    return;
                }

                // 🔄 Mostrar pantalla de carga
                StatusHandler.LShow("Cargando...");

                try {
                    // 🔹 Obtener UXC desde backend (sin CORS)
                    const uxc = await getUXCByOrder(orderCode);

                    if (!uxc || isNaN(uxc)) {
                        StatusHandler.LClose();
                        StatusHandler.ValidationMsg("UXC inválido o no encontrado");
                        return;
                    }

                    // 🧮 Calcular rendimiento teórico
                    const total = (sum_cajas * uxc) + sum_unidades;

                    if (!isNaN(total)) {
                        this.data.performance_teorico = total;

                        // Formatear número con separador de miles
                        const total_fmt = total.toLocaleString('es-SV');

                        StatusHandler.LClose();
                        StatusHandler.ShowStatus(
                            `Rendimiento teórico calculado correctamente.`,
                            StatusHandler.OPERATION.CREATE,
                            StatusHandler.STATUS.SUCCESS
                        );

                        console.log(`✅ UXC=${uxc}, Total calculado=${total_fmt}`);
                    } else {
                        StatusHandler.LClose();
                        StatusHandler.ValidationMsg("Error en cálculo de rendimiento teórico");
                    }

                } catch (error) {
                    StatusHandler.LClose();
                    console.error('❌ Error al calcular rendimiento teórico:', error);
                    StatusHandler.ValidationMsg("Error al obtener datos de UXC desde el servidor");
                }
            },

           finishOrder: async function() {
                try {
                    // Si aún no se ha calculado, intenta calcularlo primero
                    if (!Number.isFinite(Number(this.data.performance_teorico)) || Number(this.data.performance_teorico) <= 0) {
                        // Opcional: recalcular usando preFinish para asegurar consistencia
                        await this.preFinish();
                    }

                    const perf = Number(this.data.performance_teorico);

                    if (!Number.isFinite(perf) || perf <= 0) {
                        StatusHandler.ValidationMsg("Rendimiento teórico inválido o no calculado");
                        return;
                    }

                    const confirm = await StatusHandler.Confirm("¡Confirmar finalización!");
                    if (!confirm) return;

                    if (!this.data.order_id) {
                        alert("Inconsistencia identificador");
                        return;
                    }

                    const data_send = {
                        performance_teorico: perf,          // ✅ ahora enviamos el rendimiento real
                        // performance: this.data.performance,
                        observations: this.data.observations
                    };

                    StatusHandler.LShow();

                    const result = await finishPacking(this.data.order_id, data_send);
                    const response = result.data;

                    if (response.code === 0) {
                        StatusHandler.LClose();
                        StatusHandler.ShowStatus(
                            response.msg,
                            StatusHandler.OPERATION.DEFAULT,
                            StatusHandler.STATUS.FAIL
                        );
                        return;
                    }

                    this.data = formatPackingDB(response.data);
                    this.edit_mode = false;

                    // StatusHandler.LClose();
                    StatusHandler.ShowStatus(
                        "¡Finalizado con éxito!",
                        StatusHandler.OPERATION.CREATE,
                        StatusHandler.STATUS.SUCCESS
                    );
                } catch (ex) {
                    // StatusHandler.LClose();
                    StatusHandler.Exception("Guardar orden", ex);
                }
            },

            generatedReport: function(){
                var open_url = this.app_vars.base_url + `/report/packing/${this.data.order_id}`;
                window.open(open_url, '_blank').focus();
            },
            has_cap(e){
                return window.has_cap == undefined ? false : window.has_cap(e);
            },
            handleInputUppercase(field, index) {
                // Convierte a mayúsculas y asigna el valor
                this.data.materials[index][field] = this.data.materials[index][field].toUpperCase();
            },
            // Método para verificar si un texto es alfanumérico
            isAlphanumeric(value) {
                // Modificar la expresión regular para requerir al menos una letra y un número
                const alfanumerico = /^(?=.*[A-Z])(?=.*[0-9])[A-Z0-9]+$/;
                const isValid = alfanumerico.test(value);
                //console.log(`Verificando valor: ${value} - Alfanumérico: ${isValid}`);
                return isValid;
            },
            validateLotes() {
                for (let e of this.data.materials) {

                    if (e.lot1) {
                        if (!this.isAlphanumeric(e.lot1)) {
                            StatusHandler.ValidationMsg(`"${e.description}" - Lote 1 debe ser alfanumérico.`);
                            return false;
                        }
                    }
                }
                return true;
            },
            reloadOriginalTimes(){
                this.originalTimes = this.data.times.map(time => ({ ...time }));
            },
            reloadOriginalOperarios(){
                this.originalOperarios = this.data.operarios.map(operario => ({ ...operario }));
            },
            reloadOriginalEntregas(){
                this.originalEntregas = this.data.entregas.map(entrega => ({ ...entrega }));
            },
            // 🔒 Inicializar locks en memoria basados en valores existentes
            initializeLockedEntregas() {
                this.lockedEntregas = this.data.entregas.map(entrega => {
                    const locks = {
                        cantidad: false,
                        entrega: false,
                        recibe: false
                    };
                    
                    // Bloquear 'cantidad' si ya tiene valor
                    if (entrega.cantidad) {
                        const strVal = String(entrega.cantidad).trim();
                        if (strVal !== '' && strVal !== '/') {
                            const parts = strVal.split('/');
                            const part0 = parts[0] ? parts[0].trim() : '';
                            const part1 = parts[1] ? parts[1].trim() : '';
                            if (part0 !== '' || part1 !== '') {
                                locks.cantidad = true;
                            }
                        }
                    }
                    
                    // Bloquear 'entrega' si ya tiene valor
                    if (entrega.entrega && String(entrega.entrega).trim() !== '') {
                        locks.entrega = true;
                    }
                    
                    // Bloquear 'recibe' si ya tiene valor
                    if (entrega.recibe) {
                        const strVal = String(entrega.recibe).trim();
                        if (strVal !== '' && strVal !== '/') {
                            // Puede ser texto o formato numérico
                            if (strVal.includes('/')) {
                                const parts = strVal.split('/');
                                const part0 = parts[0] ? parts[0].trim() : '';
                                const part1 = parts[1] ? parts[1].trim() : '';
                                if (part0 !== '' || part1 !== '') {
                                    locks.recibe = true;
                                }
                            } else if (strVal !== '') {
                                locks.recibe = true;
                            }
                        }
                    }
                    
                    return locks;
                });
            },
            // 🔒 Bloquear campo si tiene valor (llamar después de cada input)
            lockFieldIfFilled(index, fieldName) {
                // Asegurar que existe el objeto de locks para este índice
                if (!this.lockedEntregas[index]) {
                    this.$set(this.lockedEntregas, index, {
                        cantidad: false,
                        entrega: false,
                        recibe: false
                    });
                }
                
                const currentValue = this.data.entregas[index][fieldName];
                
                if (!currentValue) {
                    return; // No bloquear si está vacío
                }
                
                const strVal = String(currentValue).trim();
                
                // Para campos compuestos (cantidad, recibe)
                if (fieldName === 'cantidad' || fieldName === 'recibe') {
                    if (strVal !== '' && strVal !== '/') {
                        if (strVal.includes('/')) {
                            const parts = strVal.split('/');
                            const part0 = parts[0] ? parts[0].trim() : '';
                            const part1 = parts[1] ? parts[1].trim() : '';
                            // Bloquear si cualquiera de las partes tiene valor
                            if (part0 !== '' || part1 !== '') {
                                this.$set(this.lockedEntregas[index], fieldName, true);
                            }
                        } else if (strVal !== '') {
                            // Texto sin "/" (para compatibilidad con datos antiguos)
                            this.$set(this.lockedEntregas[index], fieldName, true);
                        }
                    }
                } else {
                    // Para campos simples (entrega)
                    if (strVal !== '') {
                        this.$set(this.lockedEntregas[index], fieldName, true);
                    }
                }
            },
            // 3. MODIFICAR checkIfEndDateFilled para manejar correctamente los datos
           checkIfEndDateFilled() {
                const formattedDate = moment().format('DD/MM/YYYY');
                this.data.times.forEach((time, index) => {
                    if (time.date_end && time.time_end) {
                    // Convertir date_end de YYYY-MM-DD a DD/MM/YYYY
                    let formattedEndDate;
                    try {
                        formattedEndDate = moment(time.date_end, 'YYYY-MM-DD').format('DD/MM/YYYY');
                    } catch (e) {
                        formattedEndDate = time.date_end; // Usar valor original si hay error
                    }

                    // Actualizar operarios si el índice existe
                    if (index < this.data.operarios.length) {
                        this.data.operarios[index].fullname = this.data.operarios[index].fullname || this.app_vars.current_user.user_fullname;
                        this.data.operarios[index].date = formattedEndDate;
                    }

                    // Actualizar entregas SOLO si no hay firma previa en 'recibe'
                    if (index < this.data.entregas.length) {
                        this.data.entregas[index].entrega = this.data.entregas[index].entrega || this.app_vars.current_user.user_fullname;
                        this.data.entregas[index].date = formattedEndDate;
                        // if (!this.data.entregas[index].recibe) {
                        // this.data.entregas[index].recibe = this.app_vars.current_user.user_fullname;
                        // }
                    }
                    }
                });
                },
                            
            async checkIfDuplicateLote(e, index) {
                console.log(e.key)
                if (e.key === '/') {  // Verifica si la tecla presionada es "/"
                    e.preventDefault();
                    if(!e.target.value.includes('/')){ //veirifica que no se haya insertado una fleca
                        const confirm = await StatusHandler.Confirm("¿Desea duplicar el número de lote?", '');
                        if (!confirm) {
                            this.data.materials[index].lot1 = this.data.materials[index].lot1.replace(/\//g, '');
                        }else{
                            this.data.materials[index].lot1 = this.data.materials[index].lot1 + " / ";
                            this.data.materials[index].duplicated = true;
                            this.arrowRightEvent(e.target);
                        }
                    }
                }

                if(e.key === 'Backspace' && !e.target.value.includes('/')){ //verifica si 
                    this.data.materials[index].duplicated = false;
                } 
                
            },

            arrowRightEvent(input) {
                // Mover el cursor al final del input
                const inputElement = input;

                // Establecer el cursor al final del texto del input
                inputElement.setSelectionRange(inputElement.value.length, inputElement.value.length);
                
                // Focalizar el input para asegurarse de que el cursor esté en el lugar correcto
                inputElement.focus();
            }

        }
    })
</script>

<style>
.datepicker {
    z-index: 1060 !important;
}

.input-group-text {
    cursor: pointer;
    background-color: #f8f9fa;
    border: 1px solid #ced4da;
}

.bi-calendar, .bi-clock {
    font-size: 14px;
    color: #495057;
}

/* Mejorar la apariencia de los controles del timepicker */
.bootstrap-timepicker-widget table td a {
    padding: 2px;
    border: 1px solid #ddd;
    border-radius: 4px;
    background-color: #f8f9fa;
}

.bootstrap-timepicker-widget table td a:hover {
    background-color: #e9ecef;
}

.bootstrap-timepicker-widget table td a i {
    font-size: 8px !important; /* Asegurar que los iconos sean visibles */
}

/* Fallback para usar símbolos en lugar de iconos si no se cargan */
.bootstrap-timepicker-widget .glyphicon-chevron-up:before {
    content: "▲";
}

.bootstrap-timepicker-widget .glyphicon-chevron-down:before {
    content: "▼";
}

</style>