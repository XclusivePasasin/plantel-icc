<template>
    <div class="card">
            <h5 class="card-header text-center">
                    DISTRIBUIDORA CUSCATLAN, S.A. DE C.V.
                    <p class="text-center m-0">ORDEN DE PRODUCCIÓN</p>
            </h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <table class="table table-sm mb-0">
                            <tbody>
                                <tr>
                                    <th style="width: 50%;">Fecha de orden </th>
                                    <td style="width: 50%;">{{data.date}}</td>
                                </tr>
                                <tr>
                                    <th>Numero de orden </th>
                                    <td>{{data.num_id}}</td>
                                </tr>
                                <tr>
                                    <th>Código del producto </th>
                                    <td>{{data.product_code}}</td>
                                </tr>
                                <tr>
                                    <th>Nombre del producto </th>
                                    <td>{{data.product_name}}</td>
                                </tr>
                                <tr>
                                    <th>Número de lote </th>
                                    <td>
                                        <input type="text"
                                            :disabled="!(edit_mode && has_cap('cap-mezcla') && data.status == 4)"
                                            v-model="data.lot_num"
                                            placeholder="Ingresar número lote"
                                            class="form-control form-control-sm defblue1"
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tamaño de lote </th>
                                    <td>{{data.lot_size}}</td>
                                </tr>
                                <tr>
                                    <th style="width: 50%;">Fecha de inicio de pesado</th>
                                    <td style="width: 50%;">
                                        <input 
                                        disabled
                                            type="text"
                                            placeholder="DD/MM/YYYY"
                                            v-model="data.times.pesaje_inicio"
                                            class="form-control form-control-sm defblue1" />
                                    </td>
                                </tr>
                               
                                <tr>
                                    <th>Fecha de finalización de pesado</th>
                                    <td><input  
                                        disabled
                                            type="text"
                                            placeholder="DD/MM/YYYY"
                                            v-model="data.times.pesaje_fin"
                                            class="form-control form-control-sm defblue1" /></td>
                                </tr>
                              
                            </tbody>
                        </table>
                    </div>
                    <div class="col-12 col-md-6">
                        <table class="table table-sm mb-0">
                            <tbody>
                                <tr>
                                    <th style="width: 50%;">Fecha de inicio fabricación</th>
                                    <td style="width: 50%;">
                                        <input  disabled
                                            type="text"
                                            v-mask="'##/##/####'"
                                            placeholder="DD/MM/YYYY"
                                            v-model="data.times.init_date"
                                            class="form-control form-control-sm defblue1" />
                                    </td>
                                </tr>
                                <tr>
                                    <th>Hora de inicio fabricación</th>
                                    <td><input  disabled
                                                type="text"
                                                v-mask="'##:##'"
                                                placeholder="HH:mm"
                                                v-model="data.times.init_time"
                                                class="form-control form-control-sm defblue1" /></td>
                                </tr>
                                <tr>
                                    <th>Fecha de finalización fabricación</th>
                                    <td><input  
                                            disabled
                                            type="text"
                                            v-mask="'##/##/####'"
                                            placeholder="DD/MM/YYYY"
                                            v-model="data.times.end_date"
                                            class="form-control form-control-sm defblue1" /></td>
                                </tr>
                                <tr>
                                    <th>Hora de finalización fabricación</th>
                                    <td><input  disabled
                                                type="text"
                                                v-mask="'##:##'"
                                                placeholder="HH:mm"
                                                v-model="data.times.end_time"
                                                class="form-control form-control-sm defblue1" /></td>
                                </tr>
                                <tr>
                                    <th>Numero de formula maestra</th>
                                    <td><input disabled="true"
                                            :value="data.cod_formula_master"
                                            type="text" class="form-control form-control-sm defblue1" /></td>
                                </tr>
                                <tr>
                                    <th>Pesado y verificado por </th>
                                    <td><input type="text" :value="data.auditor.verified_by" disabled="true" class="form-control form-control-sm defblue1" /></td>
                                </tr>
                                <tr>
                                    <th>Rendimiento real </th>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <input
                                            disabled
                                            v-model="data.real_performance"
                                            type="text"
                                            class="form-control defblue1"
                                            />
                                            <span class="input-group-text defblue1">KG</span>
                                        </div>
                                    </td>
                                    <!-- <td><input :disabled="!(edit_mode && has_cap('cap-mezcla') && data.status == FLAGS.MEZCLA_EN_PROCESO)"
                                            v-model="data.real_performance"
                                            type="text" class="form-control form-control-sm defblue1" />
                                    </td> -->
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="table-responsive mt-5">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Descripción</th>
                                <th>Cantidad Requeridad</th>
                                <th>Revisión Materiales</th>
                                <th>Unidad</th>
                                <th class="invisible d-none">Cantidad</th>
                                <th>Almacen </th>
                                <th>Primer entrega</th>
                                <th>Lote <i class="bi bi-info-circle" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="right" title='Escribe el primer número de lote y luego una "/" para el duplicado de lotes'></i></th>
                                <th>Segunda entrega</th>
                                <th>Lote</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(e,index) of data.materials" :key="index">
                                <!-- Codigo -->
                                <td>{{e.code}}</td>
                                <!-- Descripción -->
                                <td>{{e.description}}</td>

                                <td>
                                    <div v-if="data.materials[index]['duplicated'] || ((data.materials[index]['amount2'] != null) && (data.materials[index]['amount2']) != null)">
                                        <!-- Mostrar cantidad requerida -->
                                        <div>
                                            {{formatDecimal(e.required_amount)}}
                                        </div>
                                        
                                        <!-- Primer campo de entrada (editable) -->
                                        <div class="d-flex align-items-center mb-2">
                                            <input type="text"
                                                pattern="[0-9]*\.?[0-9]*"
                                                placeholder="Cantidad No.1"
                                                :disabled="
                                                    e.code === '003007000089'
                                                        ? isSpecialVerificationSubmitted || !(data.status === FLAGS.MEZCLA_EN_PROCESO && (has_cap('cap-materiaprima') || has_cap('cap-calidad') || has_cap('cap-supcalidad') || has_cap('cap-muestreo') || has_cap('cap-auxcontrol-calidad') || has_cap('cap-jefecontrol-calidad')))
                                                        : !(has_cap('cap-materiaprima') && (edit_mode || strict_mode))
                                                "
                                                v-model="e.amount1"
                                                @input="handleInputChange(index, 'amount1')"
                                                @blur="handleBlur(index, 'amount1')"
                                                @keypress="allowOnlyDecimal"
                                                style="width: 120px;"
                                                class="form-control form-control-sm defblue1">
                                        </div>
                                        
                                        <!-- Segundo campo de entrada (solo lectura) -->
                                        <div class="d-flex align-items-center">
                                            <input type="text"
                                                pattern="[0-9]*\.?[0-9]*"
                                                placeholder="Cantidad No.2"
                                                readonly
                                                v-model="e.amount2"
                                                style="width: 120px;"
                                                class="form-control form-control-sm defblue1">
                                        </div>
                                        
                                        <!-- Mensaje de error si se excede la cantidad -->
                                        <div v-if="showExceedError(index)" class="text-danger small mt-1">
                                            ¡La suma excede la cantidad requerida!
                                        </div>
                                    </div>
                                    <div v-else>
                                        {{formatDecimal(e.required_amount)}}
                                    </div>
                                </td>

                                <td class="text-center">
                                    <input
                                        type="checkbox"
                                        :disabled="
                                            e.code === '003007000089'
                                                ? isSpecialVerificationSubmitted || !(data.status === FLAGS.MEZCLA_EN_PROCESO && (has_cap('cap-calidad') || has_cap('cap-supcalidad') || has_cap('cap-muestreo') || has_cap('cap-auxcontrol-calidad') || has_cap('cap-jefecontrol-calidad'))) || (!e.lot1 || e.lot1.trim() === '')
                                                : !(data.status === FLAGS.PESAJE_APROBADO && (has_cap('cap-calidad') || has_cap('cap-supcalidad') || has_cap('cap-muestreo') || has_cap('cap-auxcontrol-calidad') || has_cap('cap-jefecontrol-calidad')) && data.status_receive_materials == 1)
                                        "
                                        v-model="e.entrega3"
                                        class="form-check-input is-valid"
                                    />
                                </td>
                                <!-- Unidades -->
                                <td>{{e.unit}}</td>
                                <!-- Stock -->
                                <td class="invisible d-none">{{e.stock}}</td>
                                <!-- Almacen -->
                                <td class="text-center">{{e.almacen}}</td>
                                <!-- Entrega -->
                                <td class="text-center" v-if="e.code !== '809909900100'">
                                    <input 
                                        type="checkbox" 
                                        :disabled="
                                            e.code === '003007000089'
                                                ? isSpecialVerificationSubmitted || !(data.status === FLAGS.MEZCLA_EN_PROCESO && ( has_cap('cap-supcalidad') || has_cap('cap-calidad') || has_cap('cap-muestreo') || has_cap('cap-jefecontrol-calidad'))) || (!e.lot1 || e.lot1.trim() === '')
                                                : !(edit_mode && (has_cap('cap-supcalidad') || has_cap('cap-calidad') || has_cap('cap-muestreo') || has_cap('cap-jefecontrol-calidad')))
                                        " 
                                        v-model="e.entrega1" 
                                        class="form-check-input is-valid" 
                                    />
                                </td>
                                <!-- Lote -->
                                <td class="text-center position-relative" v-if="e.code !== '809909900100'">
                                    <input 
                                        type="text"
                                        :disabled="
                                            e.code === '003007000089' 
                                                ? isSpecialVerificationSubmitted || !(data.status === FLAGS.MEZCLA_EN_PROCESO && (has_cap('cap-materiaprima') || has_cap('cap-supcalidad') || has_cap('cap-calidad') || has_cap('cap-muestreo') || has_cap('cap-jefecontrol-calidad')))
                                                : !(has_cap('cap-materiaprima') && (edit_mode || strict_mode))
                                        "
                                        :value="e.lot1"
                                        @input="onLot1Input($event.target.value, index)"
                                        style="width: 200px;"
                                        placeholder="Ingresar valor"
                                        class="form-control form-control-sm defblue1 pe-4"
                                        required
                                    />
                                </td>

                                <!-- <td class="text-center position-relative" v-if="e.code !== '809909900100'">
                                    <input 
                                        type="text"
                                        :disabled="!(has_cap('cap-materiaprima') && (edit_mode || strict_mode))"
                                        :value="e.lot1"
                                        @input="onLot1Input($event.target.value, index)"
                                        style="width: 200px;"
                                        placeholder="Ingresar valor"
                                        class="form-control form-control-sm defblue1 pe-4"
                                        required
                                    />
                                </td> -->
                                    <!-- Entrega 2 -->
                                <td class="text-center" v-if="e.code !== '809909900100'">
                                    <input 
                                        type="checkbox" 
                                        :disabled="
                                            e.code === '003007000089'
                                                ? isSpecialVerificationSubmitted || !(data.status === FLAGS.MEZCLA_EN_PROCESO && (has_cap('cap-materiaprima') || has_cap('cap-supcalidad') || has_cap('cap-calidad') || has_cap('cap-muestreo') || has_cap('cap-jefecontrol-calidad')))
                                                : !(edit_mode && has_cap('cap-supcalidad'))
                                        " 
                                        v-model="e.entrega2" 
                                        class="form-check-input is-valid" 
                                    />
                                </td>
                                <!-- Lote 2 -->
                                <td class="text-center" v-if="e.code !== '809909900100'">
                                    <input 
                                        type="text" 
                                        :disabled="
                                            e.code === '003007000089'
                                                ? isSpecialVerificationSubmitted || !(data.status === FLAGS.MEZCLA_EN_PROCESO && (has_cap('cap-materiaprima') || has_cap('cap-supcalidad') || has_cap('cap-calidad') || has_cap('cap-muestreo') || has_cap('cap-jefecontrol-calidad')))
                                                : !(edit_mode && has_cap('cap-materiaprima'))
                                        " 
                                        v-model="e.lot2" 
                                        @input="handleInputUppercase('lot2', index)" 
                                        style="width: 200px;" 
                                        placeholder="Ingresar valor ..." 
                                        class="form-control form-control-sm defblue1" 
                                    />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- <div class="border  rounded border-secondary p-3 mt-6">
                    <h6 class="border-bottom py-2 fw-bold">ANÁLISIS DE DUREZA DE AGUA</h6>
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="row">
                                <div class="col-12">
                                    <span class="form-check-label">CUMPLE: </span>
                                    <input :disabled="!(edit_water && has_cap('cap-supcalidad') && data.status < 4)"  v-model="data.water.check" type="checkbox" class="form-check-input" />
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <label for="inputPassword6" class="col-form-label">FIRMA</label>
                                </div>
                                <div class="col-12 col-md-8">
                                    <input disabled="true"   v-model="data.water.firma" type="text" class="form-control form-control-sm defblue1" />
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <label for="inputPassword6" class="col-form-label">FECHA:</label>
                                </div>
                                <div class="col-12 col-md-8">
                                    <input :disabled="!(edit_water && has_cap('cap-supcalidad') && data.status < 4)"  v-model="data.water.date" type="text" v-mask="'##/##/####'" placeholder="DD/MM /YYYY" class="form-control form-control-sm defblue1" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->

                <!-- <textarea :disabled="!(edit_mode && has_cap('cap-materiaprima') && data.status < 4)"  v-model="data.observations" placeholder="OBSERVACIONES: " class="form-control mt-6 defblue1" rows="2"></textarea> -->
                <textarea
                    :disabled="!(edit_mode && (has_cap('cap-materiaprima') || has_cap('cap-supcalidad')))"
                    v-model="data.observations"
                    placeholder="OBSERVACIONES:"
                    class="form-control mt-6 defblue1"
                    rows="10">
                </textarea>
                <!-- <div class="text-end mt-6">
                    <div class="col-auto">
                        <button v-if="edit_water == false && data.status < 4 && has_cap('cap-supcalidad')" class="btn btn-primary" @click="edit_water = true;">Modificar</button>
                        <button v-if="edit_water && data.status < 4 && has_cap('cap-supcalidad')" class="btn btn-success" @click="updateWater">Guardar</button>
                    </div>
                </div> -->

                <h6 class="mt-3 px-3 fw-bold">INDICACIONES PREVIAS A UTILIZAR EL ÁREA DE FABRICACIÓN: </h6>
                <p class="px-3">Antes del inicio de cualquier operación para este producto, deberá observarse que las paredes, piso, cielo, ventanas y luminarias estén en buenas condiciones. Todo el equipo a utilizar, recipientes y utensilios deben estar sanitizados. Todas las materias extrañas, deben ser retiradas antes de iniciar.</p>


                <div class="border  rounded border-secondary p-4 mt-6">
                    <h6 class="border-bottom py-2 fw-bold">REVISIÓN DE MATERIA PRIMA ANTES DEL FABRICADO</h6>

                    <!--END BLOQUE DE REPETICION-->
                    <div class="row" v-for="(revs, index) in data.revisiones" :key="'rev' + index" >
                        <div class="col-12 col-md-4">
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <label for="inputPassword6" class="col-form-label text-center">RESPONSABLE DE LA REVISIÓN</label>
                                </div>
                                <div class="col-12 col-md-8">
                                    <input disabled="true" :value="revs.username"  type="text" class="form-control form-control-sm defblue1 text-center ms-md-4" />
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="row">
                                <div class="col-12 col-md-4 text-center">
                                    <label for="inputPassword6" class="col-form-label text-center">FIRMA</label>
                                </div>
                                <div class="col-12 col-md-8">
                                    <input disabled="true" :value="revs.firma" type="text" class="form-control form-control-sm defblue1 text-center" />
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="row">
                                 <div class="col-12 col-md-4 text-center">
                                    <label for="inputPassword6" class="col-form-label">FECHA:</label>
                                </div>
                                <div class="col-12 col-md-8">
                                    <input
                                        type="date"
                                        v-model="revs.date"
                                        :disabled="!((has_cap('cap-calidad') || has_cap('cap-supcalidad') || has_cap('cap-muestreo') || has_cap('cap-auxcontrol-calidad') || has_cap('cap-jefecontrol-calidad')) && data.status == 3 && data.status_receive_materials == 1)"
                                        class="form-control form-control-sm text-center defblue1"
                                        :id="'revisionDatePicker_' + index"
                                    />
                                <!-- <input
                                        :disabled="!( (has_cap('cap-calidad') || has_cap('cap-supcalidad')) && data.status == 3 && data.status_receive_materials == 1)"
                                        type="text"
                                        v-model="revs.date"
                                        v-mask="'##/##/####'"
                                        placeholder="DD/MM/YYYY"
                                        class="form-control form-control-sm revision-datepicker text-center defblue1"
                                        :id="'revisionDatePicker_' + index"
                                        autocomplete="off"
                                        @keydown="handleDateInput"
                                        @input="formatDateInput"
                                        @blur="validateDate" 
                                    /> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--END BLOQUE DE REPETICION-->
                </div>

                <div class="row mt-6  justify-content-center">
                    <div class="col-12 col-md-4 text-center">
                        <input
                            disabled
                            :value="data.user_entrega_mp || data.auditor.user_entrega_mp"
                            type="text"
                            class="form-control form-control-sm d-block defblue1 text-center"
                        >
                        <label>ENTREGADO BODEGA MP</label>
                    </div>

                    <!-- <div class="col-12 col-md-4 text-center">
                        <input disabled="true" :value="data.auditor.user_entrega_mp" type="text" class="form-control form-control-sm d-block defblue1 text-center">
                        <label for="">ENTREGADO BODEGA MP</label>
                    </div> -->
                    <!-- <div class="col-12 col-md-4 text-center">
                        <input disabled="true" :value="data.auditor.user_autoriza" type="text" class="form-control form-control-sm d-block defblue1 text-center">
                        <label for="">AUTORIZADO</label>
                    </div> -->
                    <div class="col-12 col-md-4 text-center">
                        <input disabled="true" :value="data.auditor.materials_received_by" type="text" class="form-control form-control-sm d-block defblue1 text-center">
                        <label for="">RECIBIDO PRODUCCION</label>
                    </div>
                    <!-- <div class="col-12 col-md-4 text-center">
                        <input disabled="true" :value="data.auditor.materials_received_by" type="text" class="form-control form-control-sm d-block defblue1 text-center">
                        <label for="">RECIBIDO MATERIALES</label>
                    </div> -->
                </div>

             <!--Modal para contraseña de autorizacion-->
             <!-- Modal para verificar contraseña -->
            <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="passwordModalLabel">Verificación de seguridad</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="passwordInput" class="form-label">Ingrese su contraseña para modificar:</label>
                                <input type="password" class="form-control" id="passwordInput" v-model="password" autocomplete="off" @keyup.enter="verifyPassword">
                                <div v-if="passwordError" class="text-danger mt-2">{{ passwordError }}</div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary" @click="verifyPassword">Verificar</button>
                        </div>
                    </div>
                </div>
            </div>


                <div class="text-end mt-6">
                    <div class="col-auto">
                        <div class="dropdown" style="display: inline-block;" v-if="data.order_id != 0">
                            <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            Generar PDF
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item" href="#"  @click="generatedReport(1)">Orden de producción</a></li>
                            <li><a class="dropdown-item" href="#"  @click="generatedReport(2)">Viñetas de productos</a></li>
                        </ul>
                        </div>
                        <!-- <button type="button" v-if="data.order_id != 0" @click="generatedReport" class="btn btn-dark"><i class="bi bi-file-earmark-pdf"></i> Generar PDF </button>
                        <button type="button" v-if="data.order_id != 0" @click="generatedReport" class="btn btn-dark"><i class="bi bi-file-earmark-pdf"></i> Generar Fichas</button> -->

                        <!-- Botón con validación de contraseña (SOLO para estado exacto PESAJE_APROBADO = 4) -->
                       <button 
                            type="button" 
                            v-if="showStrictButton" 
                            @click="showPasswordModal" 
                            class="btn btn-primary">
                            Modificación Estricta
                        </button>

                        <button 
                            type="button" 
                            v-if="showSaveLotButton" 
                            @click="saveLotChanges" 
                            class="btn btn-success text-white">
                            Guardar cambios de lote
                        </button>



                        <!-- Botón directo sin contraseña (para estados MENORES a PENDIENTE_APROVACION_PESAJE, es decir <=2) (Miguel) --> 
                        <button type="button" 
                                v-if="edit_mode == false
                                    && (data.lot1_changes === undefined || data.lot1_changes < 1)
                                    && data.status < FLAGS.PESAJE_APROBADO 
                                    && data.status !== FLAGS.MEZCLA_REVISADA 
                                    && has_cap('cap-materiaprima')"
                                @click="edit_mode = true" 
                                class="btn btn-secondary">
                            Modificar 
                        </button>


                        <button type="button" 
                                v-if="edit_mode==false && data.status < FLAGS.PESAJE_APROBADO && data.status !== FLAGS.MEZCLA_REVISADA && (has_cap('cap-supcalidad') || has_cap('cap-muestreo') || has_cap('cap-calidad') || has_cap('cap-jefecontrol-calidad'))" 
                                @click="edit_mode = true" 
                                class="btn btn-secondary">
                            Modificar
                        </button>

                    
                        <!-- <button type="button" v-if="edit_mode==false && data.status <= FLAGS.PENDIENTE_APROVACION_PESAJE && (has_cap('cap-materiaprima') || has_cap('cap-supcalidad'))" @click="edit_mode = true;" class="btn btn-primary">Modificar</button> -->
                        <!-- <button type="button" 
                                v-if="edit_mode==false && data.status <= FLAGS.PENDIENTE_APROVACION_PESAJE && (has_cap('cap-materiaprima') || has_cap('cap-supcalidad'))" 
                                @click="showPasswordModal" 
                                class="btn btn-primary">
                            Modificar
                        </button>  -->

                        <button type="button" v-if="edit_mode && data.status <= FLAGS.PENDIENTE_APROVACION_PESAJE && (has_cap('cap-materiaprima') || has_cap('cap-supcalidad') || has_cap('cap-muestreo') || has_cap('cap-jefecontrol-calidad') || has_cap('cap-calidad'))" @click="saveOrUpdate" class="btn btn-success">Guardar</button>

                        <!-- <button type="button" v-if="edit_mode == false && data.status == FLAGS.PENDIENTE_APROVACION_PESAJE && has_cap('cap-supcalidad')" @click="edit_mode = true" class="btn btn-success">Aprobar pesaje</button> -->
                        <!-- {{ data.status }}
                        {{ has_cap('cap-supcalidad') }} -->

                        <button
                            type="button"
                            v-if="
                                !edit_mode &&
                                data.status === FLAGS.PENDIENTE_APROVACION_PESAJE &&
                                (has_cap('cap-calidad') || has_cap('cap-supcalidad') || has_cap('cap-muestreo') || has_cap('cap-jefecontrol-calidad')) &&
                                isAprovePagePass &&
                                validateCheckboxes() &&
                                validateMaterialLots({ silent: true })
                            "
                            @click="ApprovePesaje"
                            class="btn btn-success"
                            >
                            Aprobar pesaje
                        </button>
                        <!-- <button type="button" v-if="edit_mode==false && data.status == FLAGS.PENDIENTE_APROVACION_PESAJE && has_cap('cap-supcalidad')"  @click="ApprovePesaje" class="btn btn-success">Aprobar pesaje</button> -->

                        <!-- <button type="button"  v-if="(edit_mode == false && data.status == FLAGS.PESAJE_APROBADO && has_cap('cap-supcalidad'))" @click="revisar" class="btn btn-success">Revisar</button> -->
                        <!-- <button type="button" 
                                v-if="(data.status == FLAGS.PESAJE_APROBADO && has_cap('cap-supcalidad') && data.status_receive_materials == 1)" 
                                @click="revisar" 
                                class="btn btn-success">
                            Revisar Viejo
                        </button> -->
                        <button 
                            type="button" 
                            v-if="data.status === FLAGS.PESAJE_APROBADO && (has_cap('cap-calidad') || has_cap('cap-supcalidad') || has_cap('cap-muestreo') || has_cap('cap-auxcontrol-calidad') || has_cap('cap-jefecontrol-calidad')) && isReviewPage" 
                            :disabled="data.status_receive_materials !== 1" 
                            @click="revisar" 
                            class="btn btn-success">
                            Revisar
                        </button>
                        
                        <!-- Botón Verificación Especial para material 003007000089 en estado 5 -->
                        <button 
                            type="button" 
                            v-if="!isSpecialVerificationSubmitted && hasSpecialMaterial && data.status == 5 && ( has_cap('cap-materiaprima') || has_cap('cap-calidad') || has_cap('cap-supcalidad') || has_cap('cap-muestreo') || has_cap('cap-auxcontrol-calidad') || has_cap('cap-jefecontrol-calidad'))" 
                            @click="verificacionEspecial" 
                            class="btn btn-warning text-white">
                            <i class="fas fa-check-double me-1"></i> Verificación Especial
                        </button>
                        
                        <button type="button" v-if="edit_mode == false && data.status == FLAGS.MEZCLA_REVISADA && (has_cap('cap-calidad') || has_cap('cap-supcalidad')) && isAuthorizedPagePass" @click="authorize" class="btn btn-success">Autorizar</button>

                        <!-- <button type="button" v-if="edit_mode == false && data.status == FLAGS.PESAJE_AUTORIZADO && has_cap('cap-mezcla')" @click="edit_mode = true" class="btn btn-success">Iniciar mezcla</button> -->
                        <button type="button" 
                                v-if="edit_mode == false && data.status == FLAGS.PESAJE_AUTORIZADO && has_cap('cap-mezcla') && isStartPage" 
                                @click="setCurrentDateTime(); edit_mode = true" 
                                class="btn btn-success">
                            Iniciar mezcla
                        </button>
                        <button type="button" v-if="edit_mode && data.status == FLAGS.PESAJE_AUTORIZADO && has_cap('cap-mezcla')" @click="initProcess" class="btn btn-success">Guardar</button>

                        <!-- <button type="button" v-if="edit_mode == false && data.status == FLAGS.MEZCLA_EN_PROCESO && has_cap('cap-mezcla')" @click="edit_mode = true" class="btn btn-success">Finalizar </button> -->
                        <button type="button" 
                                v-if="edit_mode == false && data.status == FLAGS.MEZCLA_EN_PROCESO && has_cap('cap-mezcla') && isFinalizePage" 
                                @click="setEndDateTime(); edit_mode = true" 
                                class="btn btn-success">
                            Finalizar
                        </button>
                        <button
                            type="button"
                            v-if="has_cap('cap-jefeproduccion') && data.status !== null && data.status !== 0"
                            :disabled="data.auditor.user_autoriza_finish || data.auditor.autorize_finish_order"
                            @click="autorizeFinishedOrder"
                            class="btn btn-success"
                        >
                            {{ data.auditor.user_autoriza_finish ? 'Autorizada' : 'Autorizar mezcla' }}
                        </button>

                        <button type="button" v-if="edit_mode && data.status == FLAGS.MEZCLA_EN_PROCESO && has_cap('cap-mezcla')" @click="finishProcess" class="btn btn-success">Guardar</button>
                        <!-- <button 
                            type="button" 
                            v-if="data.status === FLAGS.PESAJE_APROBADO && has_cap('cap-mezcla') && data.status_receive_materials == 0" 
                            @click="updateAllMaterialsDelivery" 
                            class="btn btn-info"
                        >
                            Recibir Materiales Viejo
                        </button> -->



                <!-- Botón Entregar Materiales -->
               <!-- DEBUG: Agrega esto temporalmente para ver los valores -->
                <!-- <div class="alert alert-warning" style="font-size: 12px;">
                    <strong>DEBUG:</strong><br>
                    data.status: {{ data.status }}<br>
                    FLAGS.PESAJE_APROBADO: {{ FLAGS.PESAJE_APROBADO }}<br>
                    FLAGS.PENDIENTE_APROVACION_PESAJE: {{ FLAGS.PENDIENTE_APROVACION_PESAJE }}<br>
                    has_cap('cap-materiaPrima'): {{ has_cap('cap-materiaprima') }}<br>
                    data.status_receive_materials: {{ data.status_receive_materials }}<br>
                    data.user_entrega_mp: {{ data.user_entrega_mp }}<br>
                </div> -->

                <!-- Botón Entregar Materiales -->
                <button
                    type="button"
                    v-if="(data.status === FLAGS.PESAJE_APROBADO) 
                        && has_cap('cap-materiaprima')"
                    @click="registrarEntregaMP"
                    class="btn btn-info"
                    :disabled="(data.user_entrega_mp && data.user_entrega_mp !== '') || data.status_receive_materials !== 0 || edit_mode == true"
                >
                    Entregar Materiales
                </button>

                <!-- Botón Recibir Materiales -->
                <button 
                    type="button" 
                    v-if="data.status === FLAGS.PESAJE_APROBADO && has_cap('cap-mezcla') && data.status_receive_materials == 0" 
                    @click="updateAllMaterialsDelivery" 
                    class="btn btn-info"
                    :disabled="!data.auditor.user_entrega_mp || data.auditor.user_entrega_mp === null || data.auditor.user_entrega_mp === ''"
                >
                    <i class="fas fa-check-circle"></i> Recibir Materiales
                </button>


                        
                        <!-- <button 
                            type="button" 
                            v-if="data.status === FLAGS.PESAJE_APROBADO && has_cap('cap-mezcla') && data.status_receive_materials == 0" 
                            @click="updateAllMaterialsDelivery" 
                            class="btn btn-info"
                        >
                            Recibir Materiales
                        </button>
                        <button 
                            type="button" 
                            v-if="data.status === FLAGS.PESAJE_APROBADO && has_cap('cap-mezcla') && data.status_receive_materials == 0" 
                            @click="registrarEntregaMP" 
                            class="btn btn-info"
                        >
                            Entregar Materiales
                        </button> -->


                         <!-- Botón Modificar Especial para Mezcla (estado PESAJE_APROBADO) -->
                         <!-- <button type="button" 
                                v-if="edit_mode==false && 
                                    data.status === FLAGS.PESAJE_APROBADO && 
                                    has_cap('cap-mezcla') && data.status_receive_materials == 0" 
                                @click="edit_mode = true" 
                                class="btn btn-warning text-white">
                            <i class="fas fa-edit me-1"></i> Actualizar
                        </button> -->
                    </div>
                </div>
            </div>
    </div>


</template>

<script>
    const {upsertOrder,approvePeso,authorizeMixOrder,initMixOrder,finishOrder,autorizeFinishedOrder,updateWaterMix, changeLotsBulk, revisarMixOrder, updateMaterialsDelivery,updateOrderMaterialsReceived, changeLot, updateUserEntregaMp  } = require("../service.js");
    const {formatOrderDB,getJSONRevision,convertServerDate,convertServerDateTime} = require("../helpers.js");

    import { VueMaskDirective } from 'v-mask'
    Vue.directive('mask', VueMaskDirective);

    export default {
        props: {
            source: {type: Object,required: true}
        },
        data: function(){
            this.source.revisiones.splice(1,1);
            console.log("REVISIONES",this.source.revisiones)
            return {
                FLAGS: {
                    PENDIENTE_APROVACION_PESAJE: 2,
                    PESAJE_APROBADO: 3,
                    PESAJE_AUTORIZADO: 4,
                    MEZCLA_REVISADA: -1,
                    MEZCLA_EN_PROCESO: 5,
                    MEZCLA_FINALIZADA: 6,
                    MEZCLA_AUTORIZADA_DE_FINALIZACION: 7

                },
                data: this.source,
                edit_mode: false,
                edit_water: false,
                app_vars: {},
                // variables para almacenar la contraseña
                password: '',
                passwordError: '',
                passwordModal: null, // Para almacenar la instancia del modal
                showValidation: false, // validacion para los inputs de lote1
                isSubmitting: false,
                strict_mode: false,
                isSpecialVerificationSubmitted: false, // Controla si ya se guardó la verificación especial
            }
        },
        mounted() {
            const urlParams = new URLSearchParams(window.location.search);
            console.log('Esta es la url de la pagina',urlParams.get('Pesaje'));
            console.log('Permisos actuales:', window.AppVars.permissions);
            // alert('Permisos: ' + JSON.stringify(window.AppVars.permissions));
            this.$nextTick(() => {
                // this.initRevisionDatepickers();
            });

            this.$nextTick(() => {
                // this.initRevisionDatepickers();
            });

            // Verificar si el material especial ya está completado al cargar
            // Si ya tiene todo lleno (entrega1, entrega3 y lot1), asumimos que ya fue verificado
            // y lo bloqueamos de inicio.
            if (this.data && this.data.materials) {
                const specMat = this.data.materials.find(m => m.code === '003007000089');
                // Validamos que tenga entrega1, entrega3 y algún valor en el lote
                if (specMat && specMat.entrega1 && specMat.entrega3 && specMat.lot1 && specMat.lot1.trim() !== '') {
                    this.isSpecialVerificationSubmitted = true;
                }
            } 
            
            // Observar cambios en el estado o permisos
            this.$watch(
                () => [this.data.status, this.edit_mode], 
                () => {
                    this.data.revisiones.forEach((_, index) => {
                        this.updateRevisionDatepickerState(index);
                    });
                },
                { deep: true }
            );
                    // Inicializar el modal cuando el componente esté montado
            this.passwordModal = new bootstrap.Modal(document.getElementById('passwordModal'));
        },
      
        computed: {
          showStrictButton() {
                const isFirstTime = this.data.status === this.FLAGS.PESAJE_APROBADO && this.data.status_receive_materials === 0;
                const hasPendingChanges = this.data.status < this.FLAGS.PESAJE_APROBADO && this.data.lot1_changes > 0;

                return (
                    !this.strict_mode &&
                    !this.edit_mode &&
                    this.has_cap('cap-materiaprima') &&
                    (isFirstTime || hasPendingChanges) &&
                    this.data.status_receive_materials === 0 // <- condición clave
                );
            },
            showSaveLotButton() {
                return (
                this.strict_mode &&
                (this.data.status < this.FLAGS.PESAJE_APROBADO || this.data.status === this.FLAGS.PESAJE_APROBADO  )&&
                this.has_cap('cap-materiaprima')
                );
            },
            isAuthorizedPagePass() {
                const urlParams = new URLSearchParams(window.location.search);
                const pagePass = urlParams.get('page_pass');
                return pagePass === 'Autorizar orden mezcla';
            },
            isAprovePagePass() {
                const urlParams = new URLSearchParams(window.location.search);
                const pagePass = urlParams.get('page_pass');
                return pagePass === 'Aprobar Pesaje';
            },
            isReviewPage() {
                const urlParams = new URLSearchParams(window.location.search);
                const pagePass = urlParams.get('page_pass');
                return pagePass === 'Revisar orden Mezcla' || pagePass === 'Revisar orden de Mezcla';
            },
            isFinalizePage() {
                const urlParams = new URLSearchParams(window.location.search);
                const pagePass = urlParams.get('page_pass');
                return pagePass === 'Seguimiento mezcla';
            },
            isStartPage() {
                const urlParams = new URLSearchParams(window.location.search);
                const pagePass = urlParams.get('page_pass');
                return pagePass === 'Iniciar proceso';
            },
            hasSpecialMaterial() {
                // Verifica si existe el material especial '003007000089' en la orden
                return this.data.materials.some(material => material.code === '003007000089');
            },
            isSpecialMaterialVerified() {
                // Busca el material especial
                const m = this.data.materials.find(material => material.code === '003007000089');
                // Si no existe, consideramos que no está verificado (aunque el botón no saldría por hasSpecialMaterial)
                if (!m) return false;
                
                // Verifica si ya está completo: entrega1, entrega3 y lote1
                // Nota: entrega2 y lot2 son opcionales o dependen de si se dividió el lote
                return m.entrega1 && m.entrega3 && m.lot1 && m.lot1.trim() !== '';
            },


        },
        created() {
            this.app_vars = window.AppVars;

            // Asegura que revisiones siempre sea un array
            if (!Array.isArray(this.data.revisiones)) {
                if (!this.data.revisiones) {
                    this.data.revisiones = [];
                } else {
                    this.data.revisiones = [this.data.revisiones];
                }
            }

            // Asegura que materiales tengan las props necesarias
            this.data.materials.forEach(material => {
                if (material.code === '809909900100') {
                    material.entrega1 = true;
                    material.entrega2 = true;
                    material.lot1 = 'N/A';
                    material.lot2 = 'N/A';
                }
                if (typeof material.duplicated === 'undefined') material.duplicated = false;
                if (typeof material.amount1 === 'undefined') material.amount1 = null;
                if (typeof material.amount2 === 'undefined') material.amount2 = null;
            });
        },
        methods: {
            // rolEs(roleName) {
            // // Verifica si el usuario actual tiene un rol en particular
            // // Asegúrate de que window.AppVars.current_user.role exista
            // return window.AppVars?.current_user?.role === roleName;
            // },

            registrarEntregaMP: async function() {
                if (!this.data.order_id) {
                    StatusHandler.ValidationMsg("No hay orden cargada");
                    return;
                }

                const confirm = await StatusHandler.Confirm("¿Desea registrar la entrega de materiales?");
                if (!confirm) return;

                StatusHandler.LShow();

                try {
                    const result = await updateUserEntregaMp(this.data.order_id);
                    const response = result.data;

                    if (response.code === 0) {
                        StatusHandler.ShowStatus(
                            response.msg,
                            StatusHandler.OPERATION.DEFAULT,
                            StatusHandler.STATUS.FAIL
                        );
                        return;
                    }

                    // ✅ Extraer la nueva data del backend
                    const updatedData = response.data;

                    // ✅ Actualizar los campos principales de forma reactiva
                    this.$set(this.data, "user_entrega_mp", updatedData.user_entrega_mp);
                    this.$set(this.data, "status_receive_materials", updatedData.status_receive_materials ?? 0);

                    // ✅ Actualizar los materiales (para mantener consistencia)
                    if (Array.isArray(updatedData.materials)) {
                        this.$set(this.data, "materials", updatedData.materials);
                    }

                    // ✅ Actualizar la fecha/hora de actualización
                    if (updatedData.updated_at) {
                        this.$set(this.data, "updated_at", updatedData.updated_at);
                    }

                    // ✅ Refrescar reactivamente el DOM
                    this.$forceUpdate();

                    // ✅ Notificar éxito
                    StatusHandler.LClose();
                    StatusHandler.ShowStatus(
                        "Entrega de materiales registrada exitosamente",
                        StatusHandler.OPERATION.CREATE,
                        StatusHandler.STATUS.SUCCESS
                    );

                    // Emitir evento si lo necesitas para componentes padres
                    this.$emit("materials-delivered", this.data);

                } catch (error) {
                    StatusHandler.LClose();
                    StatusHandler.Exception("Registrar entrega MP", error);
                }
            },

             handleDateInput(e) {
                const key = e.key;
                const value = e.target.value;
                
                // Teclas permitidas: números, barras (/), Backspace, Delete, flechas, Tab
                const allowedKeys = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '/', 'Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'Tab'];
                
                if (!allowedKeys.includes(key)) {
                    e.preventDefault();
                    return;
                }

                // Validación adicional para barras en posiciones correctas
                if (key === '/') {
                    const currentPos = e.target.selectionStart;
                    if (currentPos !== 2 && currentPos !== 5) {
                        e.preventDefault();
                    }
                }
            },

             formatDateInput(e) {
                let value = e.target.value.replace(/[^0-9]/g, ''); // Elimina todo excepto números
                
                // Auto-insertar barras en las posiciones correctas
                if (value.length > 2) {
                    value = value.substring(0, 2) + '/' + value.substring(2);
                }
                if (value.length > 5) {
                    value = value.substring(0, 5) + '/' + value.substring(5, 9); // Acepta hasta 4 dígitos para el año
                }

                // Validar día (01-31), mes (01-12) y año (ej. 2025)
                const parts = value.split('/');
                if (parts[0] && (parseInt(parts[0]) > 31 || parseInt(parts[0]) < 1)) {
                    parts[0] = '31'; // Corrige día inválido
                }
                if (parts[1] && (parseInt(parts[1]) > 12 || parseInt(parts[1]) < 1)) {
                    parts[1] = '12'; // Corrige mes inválido
                }

                this.revs.date = parts.join('/').substring(0, 10); // Limita a 10 caracteres (DD/MM/YYYY)
            },

            validateDate() {
                const dateRegex = /^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/([0-9]{4})$/;
                if (!dateRegex.test(this.revs.date)) {
                    alert("Formato de fecha inválido. Use DD/MM/YYYY (ej. 01/07/2025)");
                    this.revs.date = ''; // Opcional: Limpiar si no es válido
                }
            },

            updateWater: async function(){

                var data_send = {
                    // water_check: this.data.water.check,
                    // water_date: convertServerDate(this.data.water.date),
                    observaciones: this.data.observations
                }

                    // if(data_send.water_date == null){alert("Fecha incorrecta");return;}//pending

                var confirm = await StatusHandler.Confirm("!Confirmar guardado!");
                if(!confirm)return;

                StatusHandler.LShow();
                updateWaterMix(this.data.order_id,data_send).then(result=>{
                    let response = result.data;
                    if(response.code == 0){
                        StatusHandler.ShowStatus(response.msg,StatusHandler.OPERATION.DEFAULT,StatusHandler.STATUS.FAIL);
                        return;
                    }

                    this.data = formatOrderDB(response.data);
                    this.edit_water = false;

                    StatusHandler.LClose();
                    StatusHandler.ShowStatus("Guardado Existoso!",StatusHandler.OPERATION.DEFAULT,StatusHandler.STATUS.SUCCESS);
                }).catch(ex=>{
                    StatusHandler.LClose();
                    StatusHandler.Exception("Guardar orden",ex);
                });
            },
            initRevisionDatepickers() {
                this.data.revisiones.forEach((rev, index) => {
                    $(`#revisionDatePicker_${index}`).datepicker({
                        format: 'dd/mm/yyyy',
                        autoclose: true,
                        todayHighlight: true,
                        language: 'es',
                        weekStart: 1,
                        orientation: 'auto'
                    }).on('changeDate', (e) => {
                        // Formatear la fecha seleccionada
                        const formattedDate = e.format('dd/mm/yyyy');
                        this.$set(this.data.revisiones[index], 'date', formattedDate);
                    });
                    
                    // Actualizar estado inicial
                    this.updateRevisionDatepickerState(index);
                });
            },
            isValidDate(dateStr) {
                const regex = /^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/\d{4}$/;
                return regex.test(dateStr);
            },
            
            updateRevisionDatepickerState(index) {
                const isDisabled = !(
                    (this.has_cap('cap-calidad') || this.has_cap('cap-supcalidad')) && 
                    this.data.status == 3
                );
                
                $(`#revisionDatePicker_${index}`).datepicker(isDisabled ? 'disable' : 'enable');
            },
            validateCheckboxes() {
                let allValid = true;
                
                this.data.materials.forEach(material => {
                    // Mostrar todos los materiales en el log, incluyendo el agua
                    /*console.log(`Material ${material.code} (${material.description}): 
                        Entrega1: ${material.entrega1}, 
                        Entrega2: ${material.entrega2}`);*/
                    
                    // Excepción: El material especial '003007000089' solo se valida cuando el estado es >= 5 (MEZCLA_EN_PROCESO)
                    if (material.code === '003007000089' && this.data.status < this.FLAGS.MEZCLA_EN_PROCESO) {
                        // No validar este material hasta el estado 5
                        return;
                    }
                    
                    // Validar solo la primera entrega (entrega1)
                    if (!material.entrega1) {
                        console.warn(`¡Material ${material.code} no tiene la primera entrega marcada!`);
                        allValid = false;
                    }
                    
                    // La segunda entrega (entrega2) es opcional, no se valida
                });
                
                return allValid;
            },
            validateMaterialLots() {
                let isValid = true;
                const missingCount = this.data.materials.reduce((count, material) => {
                    // Excluir el agua (809909900100) siempre
                    if (material.code === '809909900100') {
                        return count;
                    }
                    
                    // Excepción: El material especial '003007000089' solo se valida cuando el estado es >= 5 (MEZCLA_EN_PROCESO)
                    if (material.code === '003007000089' && this.data.status < this.FLAGS.MEZCLA_EN_PROCESO) {
                        return count; // No contar como faltante hasta el estado 5
                    }
                    
                    // Validar que tenga lote
                    if (!material.lot1 || material.lot1.trim() === '') {
                        return count + 1;
                    }
                    
                    return count;
                }, 0);
                
                if (missingCount > 0) {
                    isValid = false;
                    StatusHandler.ValidationMsg(`Debes completar el número de lote para ${missingCount} material(es) antes de continuar.`);
                }
                
                return isValid;
            },
            // Método para verificar si un texto es alfanumérico
            isAlphanumeric(value) {
                // Modificar la expresión regular para requerir al menos una letra y un número
                const alfanumerico = /^(?=.*[A-Z])(?=.*[0-9])[A-Z0-9]+$/;
                const isValid = alfanumerico.test(value);
                //console.log(`Verificando valor: ${value} - Alfanumérico: ${isValid}`);
                return isValid;
            },
            isValidAmount(index) {
                const material = this.data.materials[index];
                const amount1 = parseFloat(material.amount1) || 0;
                const amount2 = parseFloat(material.amount2) || 0;
                const total = amount1 + amount2;
                const required = parseFloat(material.required_amount);
                return Math.abs(total - required) < 0.000001;
            },
            showPasswordModal() {
                this.password = '';
                this.passwordError = '';
                this.passwordModal.show();
            },
            verifyPassword() {
                const hardcodedPassword = "123"; // Cambia esto por una contraseña segura
                
                if (this.password === hardcodedPassword) {
                    this.passwordError = '';
                    this.strict_mode = true;
                    this.passwordModal.hide();
                } else {
                    this.passwordError = 'Contraseña incorrecta';
                }
            },
            

           // Método mejorado para formatear decimales con ceros dinámicos
            formatDecimal(value) {
                if (value === null || value === undefined) {
                    // Si no hay valor, mostrar ceros basados en el valor por defecto (6)
                    return '0'.padEnd(7, '0'); // "0.000000"
                }
                
                const num = Number(value);
                if (isNaN(num)) return '0.0000000';
                
                const decimalCount = this.getDecimalCount(value);
                const formatted = num.toFixed(decimalCount);
                
                // Asegurar que siempre muestre los ceros necesarios
                const [integerPart, decimalPart] = formatted.split('.');
                
                if (decimalPart === undefined) {
                    // Si es entero, agregar . y los ceros correspondientes
                    return decimalCount > 0 
                        ? `${integerPart}.${'0'.repeat(decimalCount)}`
                        : integerPart;
                }
                
                // Si tiene decimales pero menos que los requeridos, completar con ceros
                if (decimalPart.length < decimalCount) {
                    return `${integerPart}.${decimalPart.padEnd(decimalCount, '0')}`;
                }
                
                return formatted;
            },
            isHalfComplete(index, field) {
                const material = this.data.materials[index];
                const value = parseFloat(material[field]) || 0;
                const max = parseFloat(material.required_amount);
                return value >= max * 0.4;
            },
           // Manejar cambios en tiempo real con validación de máximo
            handleInputChange(index, field) {
                const material = this.data.materials[index];
                let value = material[field];
                
                // Validar entrada
                if (value && !/^\d*\.?\d*$/.test(value)) {
                    material[field] = '';
                    return;
                }
                
                // Convertir a número y validar si excede el máximo
                const numValue = parseFloat(value) || 0;
                const max = parseFloat(material.required_amount);
                const decimals = this.getDecimalCount(material.required_amount);
                
                if (numValue > max) {
                    // Si excede, establecer el valor máximo
                    material[field] = max.toFixed(decimals);
                }
                
                // Calcular el campo complementario inmediatamente
                this.calculateComplementaryField(index, field);
            },
            // Manejar entrada con validación mejorada
            handleDecimalInput(event, index, field) {
                const material = this.data.materials[index];
                let value = event.target.value;
                
                // Permitir borrado completo
                if (value === '') {
                    material[field] = '';
                    return;
                }
                
                // Validar sólo números y punto decimal
                if (/^\d*\.?\d*$/.test(value)) {
                    // Guardar valor temporal sin formatear
                    material[field] = value;
                } else {
                    event.preventDefault();
                }
            },

            // Método para contar decimales conservando exactamente el formato original
            getDecimalCount(num) {
                if (num === null || num === undefined) return 6;
                
                // Convertir a string manteniendo la representación exacta
                const numStr = num.toString();
                
                // Manejar notación científica (ej: 1e-6)
                if (numStr.includes('e-')) {
                    return parseInt(numStr.split('e-')[1]);
                }
                
                // Extraer parte decimal
                const parts = numStr.split('.');
                
                // Si no tiene punto decimal, verificar si es entero con .0
                if (parts.length === 1) {
                    // Si el número original era un entero, devolver 0
                    if (Number.isInteger(num)) {
                        return 0;
                    }
                    // Para números como 123.0 que pueden convertirse a "123" al toString()
                    // Verificar si el número tiene decimales cero
                    if (num % 1 === 0) {
                        return 0;
                    }
                }
                
                // Si tiene parte decimal
                if (parts.length === 2) {
                    // Conservar TODOS los dígitos decimales, incluyendo ceros a la derecha
                    return parts[1].length;
                }
                
                return 0;
            },
            // Nuevo método para actualizar el campo complementario
            updateComplementaryField(index, changedField) {
                const material = this.data.materials[index];
                const max = parseFloat(material.required_amount);
                const decimals = this.getDecimalCount(material.required_amount);
                const otherField = changedField === 'amount1' ? 'amount2' : 'amount1';
                
                const currentValue = parseFloat(material[changedField]) || 0;
                const remaining = max - currentValue;
                
                // Solo actualizar si el otro campo está vacío o es menor que el restante
                if (!material[otherField] || parseFloat(material[otherField]) > remaining) {
                    material[otherField] = remaining > 0 ? remaining.toFixed(decimals) : '0'.toFixed(decimals);
                }
                
                // Validar el total
                this.validateTotalAmount(index);
            },


            // Manejar blur con validación adicional
            handleBlur(index, field) {
                const material = this.data.materials[index];
                const decimals = this.getDecimalCount(material.required_amount);
                
                // Si está vacío, establecer en 0
                if (material[field] === '' || material[field] === null) {
                    material[field] = '0'.toFixed(decimals);
                } else {
                    // Formatear el valor y validar máximo
                    const numValue = parseFloat(material[field]) || 0;
                    const max = parseFloat(material.required_amount);
                    
                    if (numValue > max) {
                        material[field] = max.toFixed(decimals);
                    } else {
                        material[field] = numValue.toFixed(decimals);
                    }
                }
                
                // Recalcular el campo complementario
                this.calculateComplementaryField(index, field);
            },

            setCurrentDateTime() {
                // Obtener fecha y hora actual
                const now = new Date();
                
                // Formatear fecha como DD/MM/YYYY
                const day = String(now.getDate()).padStart(2, '0');
                const month = String(now.getMonth() + 1).padStart(2, '0');
                const year = now.getFullYear();
                const currentDate = `${day}/${month}/${year}`;
                
                // Formatear hora como HH:mm
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const currentTime = `${hours}:${minutes}`;
                
                // Asignar valores
                this.data.times.init_date = currentDate;
                this.data.times.init_time = currentTime;
            },
            
            setEndDateTime() {
                // Obtener fecha y hora actual
                const now = new Date();
                
                // Formatear fecha como DD/MM/YYYY
                const day = String(now.getDate()).padStart(2, '0');
                const month = String(now.getMonth() + 1).padStart(2, '0');
                const year = now.getFullYear();
                const currentDate = `${day}/${month}/${year}`;
                
                // Formatear hora como HH:mm (24 horas)
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const currentTime = `${hours}:${minutes}`;
                
                // Asignar valores
                this.data.times.end_date = currentDate;
                this.data.times.end_time = currentTime;
                this.data.real_performance = this.data.lot_size;    
            },

            
            // Método mejorado para calcular campos complementarios
            calculateComplementaryField(index, changedField) {
                const material = this.data.materials[index];
                const max = parseFloat(material.required_amount);
                const decimals = this.getDecimalCount(material.required_amount);
                const otherField = changedField === 'amount1' ? 'amount2' : 'amount1';
                
                let currentValue = parseFloat(material[changedField]) || 0;
                
                // Asegurar que no exceda el máximo
                if (currentValue > max) {
                    currentValue = max;
                    material[changedField] = currentValue.toFixed(decimals);
                }
                
                const remaining = max - currentValue;
                
                // Calcular el valor restante con precisión
                const remainingValue = Math.max(0, remaining); // No permitir valores negativos
                material[otherField] = remainingValue.toFixed(decimals);
                
                // Forzar actualización del DOM para evitar inconsistencias visuales
                this.$forceUpdate();
            },

            // Método mejorado para validación total
            validateTotalAmount(index) {
                const material = this.data.materials[index];
                const max = parseFloat(material.required_amount);
                const amount1 = parseFloat(material.amount1) || 0;
                const amount2 = parseFloat(material.amount2) || 0;
                const total = amount1 + amount2;
                const decimals = this.getDecimalCount(material.required_amount);
                
                // Manejar posibles errores de redondeo flotante
                if (Math.abs(total - max) > 0.000001) { // Tolerancia de 0.000001
                    // Ajustar proporcionalmente si hay pequeña diferencia
                    if (total > 0) {
                        const ratio = max / total;
                        material.amount1 = (amount1 * ratio).toFixed(decimals);
                        material.amount2 = (amount2 * ratio).toFixed(decimals);
                    } else {
                        // Si ambos son 0, establecer valores por defecto
                        const half = max / 2;
                        material.amount1 = half.toFixed(decimals);
                        material.amount2 = half.toFixed(decimals);
                    }
                }
            },

            recalculateAmounts(index) {
                const material = this.data.materials[index];
                const max = parseFloat(material.required_amount);
                const decimals = this.getDecimalCount(material.required_amount);
                
                // Si ambos campos tienen valores, verificar que no excedan el máximo
                if (material.amount1 && material.amount2) {
                    const total = parseFloat(material.amount1) + parseFloat(material.amount2);
                    if (total > max) {
                        // Ajustar proporcionalmente
                        const ratio = max / total;
                        material.amount1 = (parseFloat(material.amount1) * ratio).toFixed(decimals);
                        material.amount2 = (parseFloat(material.amount2) * ratio).toFixed(decimals);
                    }
                }
                
                // Si solo uno tiene valor, calcular el otro
                if (material.amount1 && !material.amount2) {
                    material.amount2 = (max - parseFloat(material.amount1)).toFixed(decimals);
                } else if (!material.amount1 && material.amount2) {
                    material.amount1 = (max - parseFloat(material.amount2)).toFixed(decimals);
                }
                
                // Asegurar que no haya valores negativos
                if (material.amount1 && parseFloat(material.amount1) < 0) {
                    material.amount1 = '0.00';
                    material.amount2 = max.toFixed(decimals);
                }
                if (material.amount2 && parseFloat(material.amount2) < 0) {
                    material.amount2 = '0.00';
                    material.amount1 = max.toFixed(decimals);
                }
            },
            // Calcular cantidad restante
            calculateRemaining(index) {
                const material = this.data.materials[index];
                if (!material.amount1) return this.formatDecimal(material.required_amount);
                
                const amount1 = parseFloat(material.amount1) || 0;
                const remaining = material.required_amount - amount1;
                return this.formatDecimal(remaining > 0 ? remaining : 0);
            },

            // Resto de métodos permanecen iguales...
            formatDecimalInput(index, field) {
                const material = this.data.materials[index];
                if (material[field] === '' || material[field] === null) {
                    material[field] = '';
                    return;
                }
                
                const decimalCount = this.getDecimalCount(material.required_amount);
                const numValue = parseFloat(material[field]);
                
                if (isNaN(numValue)) {
                    material[field] = '';
                } else {
                    material[field] = numValue.toFixed(decimalCount);
                }
            },

            // Cálculos con validación estricta
            calculateSecondAmount(index) {
                const material = this.data.materials[index];
                if (material.amount1 && material.required_amount) {
                    const decimalCount = this.getDecimalCount(material.required_amount);
                    let amount1 = parseFloat(material.amount1) || 0;
                    
                    // Asegurar que no exceda el total
                    if (amount1 > material.required_amount) {
                        amount1 = material.required_amount;
                        material.amount1 = amount1.toFixed(decimalCount);
                    }
                    
                    material.amount2 = (material.required_amount - amount1).toFixed(decimalCount);
                    
                    // Validación adicional
                    if (parseFloat(material.amount2) < 0) {
                        material.amount1 = material.required_amount.toFixed(decimalCount);
                        material.amount2 = (0).toFixed(decimalCount);
                    }
                }
            },
            calculateFirstAmount(index) {
                const material = this.data.materials[index];
                if (material.amount2 && material.required_amount) {
                    const decimalCount = this.getDecimalCount(material.required_amount);
                    let amount2 = parseFloat(material.amount2) || 0;
                    
                    // Asegurar que no exceda el total
                    if (amount2 > material.required_amount) {
                        amount2 = material.required_amount;
                        material.amount2 = amount2.toFixed(decimalCount);
                    }
                    
                    material.amount1 = (material.required_amount - amount2).toFixed(decimalCount);
                    
                    // Validación adicional
                    if (parseFloat(material.amount1) < 0) {
                        material.amount2 = material.required_amount.toFixed(decimalCount);
                        material.amount1 = (0).toFixed(decimalCount);
                    }
                }
            },
            // Método para contar decimales mejorado
            getDecimalCount(num) {
                if (num === null || num === undefined) return 6;
                
                // Convertir a string y manejar notación científica
                const numStr = num.toString();
                if (numStr.indexOf('e-') > -1) {
                    return parseInt(numStr.split('e-')[1]);
                }
                
                if (Number.isInteger(num)) return 0;
                const decimalPart = numStr.split('.')[1];
                return decimalPart ? Math.min(decimalPart.length, 6) : 0; // Máximo 6 decimales
            },
            // Método mejorado para verificar si se excedió la cantidad
            showExceedError(index) {
                const material = this.data.materials[index];
                if (!material.amount1 || !material.amount2) return false;
                
                const amount1 = parseFloat(material.amount1) || 0;
                const amount2 = parseFloat(material.amount2) || 0;
                const total = amount1 + amount2;
                const required = parseFloat(material.required_amount);
                
                // Usar una pequeña tolerancia para manejar errores de redondeo flotante
                return total > required + 0.000001; // Tolerancia de 0.000001
            },
            allowOnlyDecimal(event) {
                const key = event.key;
                // Solo permitir dígitos, un solo punto, y teclas de control (como backspace)
                const allowedKeys = ['Backspace', 'Tab', 'ArrowLeft', 'ArrowRight', 'Delete'];
                const isNumber = /^[0-9]$/.test(key);
                const isDot = key === '.' && !event.target.value.includes('.');

                if (!isNumber && !isDot && !allowedKeys.includes(key)) {
                    event.preventDefault();
                }
            },

            validateLotes() {

                for (let e of this.data.materials) {

                    if (e.lot1) {
                        if (!this.isAlphanumeric(e.lot1)) {
                            StatusHandler.ValidationMsg(`"${e.description}" - Lote 1 debe ser alfanumérico.`);
                            return false;
                        }
                    }

                    if (e.lot2) {
                        if (!this.isAlphanumeric(e.lot2)) {
                            StatusHandler.ValidationMsg(`"${e.description}" - Lote 2 debe ser alfanumérico.`);
                            return false;
                        }
                    }
                }

                return true;
            },

            
            async updateAllMaterialsDelivery() {
                try {
                    const shouldProceed = await StatusHandler.Confirm(
                        "Confirmar recepción de materiales",
                        "¿Está seguro que desea registrar la recepción de estos materiales?"
                    );
                    if (!shouldProceed) return;

                    StatusHandler.LShow();

                    // Llamada al backend
                    const orderResult = await updateOrderMaterialsReceived(this.data.order_id);

                    console.log("Respuesta del backend (recepción materiales):", orderResult.data);

                    if (orderResult.data.code !== 1) {
                        throw new Error(orderResult.data.msg);
                    }

                    // ✅ Solo actualizar el campo deseado de forma reactiva
                    this.$set(this.data, 'status_receive_materials', 1);

                    // Emitir evento opcional si es necesario
                    this.$emit('materials-received', this.data);

                     StatusHandler.ShowStatus("Recepcion de materiales exitosa!",StatusHandler.OPERATION.CREATE,StatusHandler.STATUS.SUCCESS);

                } catch (error) {
                    console.error("Error al recibir materiales:", error);
                    StatusHandler.Exception("Error al recibir materiales", error.message);
                } finally {
                    // StatusHandler.LClose();
                }
            },

            async receiveMaterials() {
                // Validación de que todos los checkbox estén activos
                if (!this.validateAllMaterialsReceived()) {
                    await StatusHandler.ValidationMsg('Todos los materiales deben estar marcados como recibidos para continuar');
                    return;
                }

                // Validación básica
                if (!this.validateMaterialsForReceipt()) {
                    await StatusHandler.ValidationMsg('Debe verificar todos los materiales antes de confirmar la recepción');
                    return;
                }

                this.edit_mode = false; // Desactivar modo edición inmediatamente

                // Confirmación
                try {
                    const shouldProceed = await StatusHandler.Confirm(
                        "Confirmar recepción de materiales",
                        "¿Está seguro que desea registrar la recepción de estos materiales?"
                    );
                    if (!shouldProceed) return;
                } catch (error) {
                    console.error("Error en confirmación:", error);
                    return;
                }

                StatusHandler.LShow();
                
                try {
                    const filteredMaterials = this.data.materials.filter(m => m.code !== '809909900100');
                    
                    // 1. Primero actualizamos los materiales
                    const materialsPayload = {
                        order_id: this.data.order_id,
                        materials: filteredMaterials.map(m => {
                            if (!m.material_id) {
                                throw new Error(`El material ${m.description} no tiene ID`);
                            }
                            return {
                                material_id: m.material_id,
                                entrega3: m.entrega3
                            };
                        })
                    };
                    
                    // Actualizar materiales
                    const materialsResult = await updateMaterialsDelivery(materialsPayload);

                    if (materialsResult.data.code !== 1) {
                        throw new Error(materialsResult.data.msg);
                    }

                    // 2. Luego actualizamos el estado de la orden
                    const orderResult = await updateOrderMaterialsReceived(this.data.order_id);

                    if (orderResult.data.code !== 1) {
                        throw new Error(orderResult.data.msg);
                    }

                    // Actualizar datos locales con ambas respuestas
                    this.data = {
                        ...this.data,
                        ...materialsResult.data.data.order,
                        ...orderResult.data.data.order,
                        materials: materialsResult.data.data.materials || this.data.materials
                    };
                    
                    StatusHandler.ShowStatus("Recepción de materiales completada exitosamente", StatusHandler.OPERATION.SUCCESS);
                    this.$emit('materials-received', this.data);
                    
                } catch (error) {
                    console.error("Error en receiveMaterials:", error);
                    StatusHandler.Exception("Error al recibir materiales", error.message);
                } finally {
                    StatusHandler.LClose();
                }
            },

            async updateMaterialDelivery(material) {
                // Solo si estamos en modo edición y tenemos los permisos
                if (!this.edit_mode || !this.has_cap('cap-mezcla') || this.data.status !== this.FLAGS.PESAJE_APROBADO) {
                    return;
                }

                try {
                    const payload = {
                        order_id: this.data.order_id,
                        materials: [{
                            material_id: material.material_id,
                            entrega3: material.entrega3
                        }]
                    };

                    const result = await updateMaterialsDelivery(payload);

                    if (result.data.code === 1) {
                        // Actualizar el material localmente con la respuesta del servidor
                        const updatedMaterial = result.data.data.materials[0];
                        const index = this.data.materials.findIndex(m => m.material_id === updatedMaterial.id);
                        if (index !== -1) {
                            this.$set(this.data.materials, index, updatedMaterial);
                        }
                    } else {
                        // Revertir el cambio si falla
                        material.entrega3 = !material.entrega3;
                        StatusHandler.ShowStatus(result.data.msg, StatusHandler.OPERATION.ERROR);
                    }
                } catch (error) {
                    console.error("Error al actualizar material:", error);
                    // Revertir el cambio
                    material.entrega3 = !material.entrega3;
                    StatusHandler.Exception("Error al actualizar material", error.message);
                }
            },
            /**
             * Valida que todos los materiales estén marcados como recibidos (entrega3 = true)
             * Excepción: El material especial '003007000089' solo se valida cuando el estado es >= 5 (MEZCLA_EN_PROCESO)
             */
            validateAllMaterialsReceived() {
                return this.data.materials.every(m => {
                    // Excepción: Omitir el material especial '003007000089' si el estado es < 5
                    if (m.code === '003007000089' && this.data.status < this.FLAGS.MEZCLA_EN_PROCESO) {
                        return true; // No validar este material hasta el estado 5
                    }
                    
                    // Validar que entrega3 tenga un valor "truthy"
                    return Boolean(m.entrega3);
                });
            },


            /**
             * Valida los materiales antes de recepción
             */
            validateMaterialsForReceipt() {
                return this.data.materials.every(m => {
                    
                    return m.entrega3 !== undefined && m.entrega3 !== null;
                });
            },

            async saveOrUpdate() {
                // 1. Validación de checkboxes para cap-supcalidad

                // if (this.has_cap('cap-supcalidad') && !this.validateCheckboxes()) {
                //     await StatusHandler.ValidationMsg(
                //         'Por favor, verifique que todos los materiales han sido entregados marcando las casillas correspondientes antes de aprobar el pesaje.'
                //     );
                //     return;
                // }

                // // 2. Validación de lotes (nueva validación)
                // if (!this.validateMaterialLots()) {
                //     return;
                // }

                // 2.1 (extra) Validación de lotes comentada
                var flag3 = false;
                var msg3 = "";
                if (flag3) {
                    StatusHandler.ValidationMsg(msg3);
                    return;
                }

                // 3. Confirmación del usuario
                var confirm = await StatusHandler.Confirm("!Confirmar guardado!");
                if (!confirm) return;

                // 4. Limpieza de datos si el estado es 1 (pendiente)
                if (this.data.status == 1) {
                    this.data.revisiones[0] = getJSONRevision();
                }

                // 🐞 DEPURACIÓN: revisar datos antes de enviar
                console.log("🟡 Payload completo antes de enviar:", JSON.stringify(this.data, null, 2));
                console.log("🟡 Materiales (solo stock y almacen):", this.data.materials.map(m => ({
                    code: m.code,
                    stock: m.stock,
                    almacen: m.almacen
                })));

                // 5. Mostrar loader
                StatusHandler.LShow();

                // 6. Llamada al backend
                upsertOrder(this.data)
                    .then(result => {
                        let response = result.data;

                        // 🐞 DEPURACIÓN: revisar respuesta cruda del backend
                        console.log("🟢 Respuesta backend:", response);

                        if (response.code == 0) {
                            StatusHandler.ShowStatus(response.msg, StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
                            return;
                        }

                        // Actualizas tu data local con lo que retorne el servidor
                        this.data = formatOrderDB(response.data);
                        this.edit_mode = false;

                        StatusHandler.LClose();
                        StatusHandler.ShowStatus(
                            "Guardado Exitoso!",
                            StatusHandler.OPERATION.CREATE,
                            StatusHandler.STATUS.SUCCESS
                        );
                    })
                    .catch(ex => {
                        StatusHandler.LClose();
                        StatusHandler.Exception("Guardar orden", ex);
                    });
            },

            ApprovePesaje: async function(){

                // Validación de checkboxes para cap-supcalidad
                if (this.has_cap('cap-supcalidad') && !this.validateCheckboxes()) {
                    await StatusHandler.ValidationMsg('Por favor, verifique que todos los materiales han sido entregados marcando las casillas correspondientes antes de aprobar el pesaje.');
                    return;
                }

                // Opcional: puedes validar también si tienes datos sin guardar
                if (this.edit_mode == true) {
                    await StatusHandler.ValidationMsg('Hay cambios pendientes sin guardar. Por favor, guarda primero.');
                    return;
                }

                 // 2. Validación de lotes (nueva validación)
                if (!this.validateMaterialLots()) {
                    return;
                }

                var adap = [];
                for(let revs of this.data.revisiones){
                    adap.push({
                        username: null,//se agregan en el backend
                        firma: null,
                        date: null //ahora se agregan en el backend
                    });
                }

                var confirm = await StatusHandler.Confirm("!Confirmar guardado!");
                if(!confirm)return;

                StatusHandler.LShow();

                approvePeso(this.data.order_id).then(result=>{
                    let response = result.data;
                    if(response.code == 0){
                        StatusHandler.ShowStatus(response.msg,StatusHandler.OPERATION.DEFAULT,StatusHandler.STATUS.FAIL);
                        return;
                    }

                    this.data = formatOrderDB(response.data);
                    this.edit_mode = false;
                    // StatusHandler.LClose();
                    StatusHandler.ShowStatus("Guardado Existoso!",StatusHandler.OPERATION.CREATE,StatusHandler.STATUS.SUCCESS);
                    
                }).catch(ex=>{
                    // StatusHandler.LClose();
                    StatusHandler.Exception("Guardar orden",ex);
                });

                // console.log("Enviando esto");
                // console.log(data_send);
            }, 

            authorize: async function(){

                var confirm = await StatusHandler.Confirm("!Confirmar guardado!");
                if(!confirm)return;

                StatusHandler.LShow();

                if (this.has_cap('cap-supcalidad') && !this.validateCheckboxes()) {
                    await StatusHandler.ValidationMsg(
                        'Por favor, verifique que todos los materiales han sido entregados marcando las casillas correspondientes antes de aprobar el pesaje.'
                    );
                    return;
                }

                // 2. Validación de lotes (nueva validación)
                if (!this.validateMaterialLots()) {
                    return;
                }

                authorizeMixOrder(this.data.order_id).then(result=>{
                    let response = result.data;
                    if(response.code == 0){
                        StatusHandler.ShowStatus(response.msg,StatusHandler.OPERATION.DEFAULT,StatusHandler.STATUS.FAIL);
                        return;
                    }

                    this.data = formatOrderDB(response.data);

                    StatusHandler.LClose();
                    StatusHandler.ShowStatus("Guardado Existoso!",StatusHandler.OPERATION.CREATE,StatusHandler.STATUS.SUCCESS);
                }).catch(ex=>{
                    StatusHandler.LClose();
                    StatusHandler.Exception("Guardar orden",ex);
                });
            },

            async revisar() {
                if (this.data.status_receive_materials == 0) {
                    StatusHandler.ValidationMsg("No se puede revisar. Faltan materiales por recibir.");
                    return;
                }

                if (this.data.user_entrega_mp != null) {
                    StatusHandler.ValidationMsg("No se puede revisar. Faltan materiales por entregar.");
                    return;
                }

                if (!this.validateAllMaterialsReceived()) {
                    await StatusHandler.ValidationMsg('Todos los materiales deben estar marcados como recibidos antes de revisar');
                    return;
                }

                if (this.data.revisiones[0].date == null) {
                    StatusHandler.ValidationMsg("Campo fecha de revisión requerido");
                    return;
                }

                const confirm = await StatusHandler.Confirm(
                    "Confirmar revisión",
                    "¿Está seguro que desea registrar la revisión de estos materiales?"
                );
                if (!confirm) return;

                StatusHandler.LShow();

                try {
                    // Actualizar materiales (ya no excluye el de agua)
                    const materialsPayload = {
                        order_id: this.data.order_id,
                        materials: this.data.materials.map(m => ({
                            material_id: m.material_id,
                            entrega3: m.entrega3
                        }))
                    };

                    const materialsResult = await updateMaterialsDelivery(materialsPayload);
                    if (materialsResult.data.code !== 1) {
                        throw new Error(materialsResult.data.msg);
                    }

                    // Ejecutar revisión
                    const reviewResult = await revisarMixOrder(this.data, this.data.order_id);
                    if (reviewResult.data.code === 0) {
                        throw new Error(reviewResult.data.msg);
                    }

                    // ✅ Actualizar status desde backend
                    this.$set(this.data, 'status', reviewResult.data.data.status || -1);

                    // ✅ Parsear revisiones y actualizar reactivamente
                    if (reviewResult.data.data.revisiones) {
                        try {
                            const parsedRevs = JSON.parse(reviewResult.data.data.revisiones);

                            // Si quieres setear el usuario actual como responsable/firma:
                            if (this.currentUser) {
                                parsedRevs[0].username = this.currentUser.name;
                                parsedRevs[0].firma = this.currentUser.name;
                            }

                            this.$set(this.data, 'revisiones', parsedRevs);
                        } catch (e) {
                            console.error("Error parseando revisiones:", e);
                        }
                    }

                    // ✅ Actualizar materiales desde backend
                    this.$set(this.data, 'materials', reviewResult.data.data.materials || this.data.materials);

                    this.edit_mode = false;
                    this.$emit('materials-received', this.data);

                    StatusHandler.ShowStatus("Guardado Existoso!",StatusHandler.OPERATION.CREATE,StatusHandler.STATUS.SUCCESS);

                } catch (error) {
                    console.error("Error en revisar:", error);
                    StatusHandler.Exception("Error al revisar orden", error.message);
                } finally {
                    // StatusHandler.LClose();
                }
            },

            async verificacionEspecial() {
                // Validar que estamos en el estado correcto
                if (this.data.status !== this.FLAGS.MEZCLA_EN_PROCESO) {
                    StatusHandler.ValidationMsg("Esta verificación solo está disponible durante el proceso de mezcla (Estado 5).");
                    return;
                }

                // Confirmación
                const confirm = await StatusHandler.Confirm(
                    "Confirmar Verificación Especial",
                    "¿Desea guardar el avance y/o verificar la orden?"
                );
                if (!confirm) return;

                StatusHandler.LShow();

                try {
                    // 1. Guardar explícitamente los checks de entrega (especialmente entrega3)
                    const materialsPayload = {
                        order_id: this.data.order_id,
                        materials: this.data.materials.map(m => ({
                            material_id: m.material_id,
                            entrega3: m.entrega3
                        }))
                    };

                    const materialsResult = await updateMaterialsDelivery(materialsPayload);
                    if (materialsResult.data.code !== 1) {
                        throw new Error("Error al guardar revisión de materiales: " + materialsResult.data.msg);
                    }

                    // 2. Guardar el resto de datos (lotes, cantidades) usando upsertOrder directamente
                    // Esto evita la doble confirmación que tiene saveOrUpdate internamente
                    const orderResult = await upsertOrder(this.data);
                    
                    if (orderResult.data.code === 0) {
                         throw new Error(orderResult.data.msg);
                    }

                    // Actualizar datos locales con la respuesta del servidor
                    this.data = formatOrderDB(orderResult.data.data);
                    
                    // 3. Verificamos SI el material especial está completo para ocultar el botón
                    const specMat = this.data.materials.find(m => m.code === '003007000089');
                    let isComplete = false;

                    if (specMat) {
                        const hasEntrega1 = !!specMat.entrega1;
                        const hasEntrega3 = !!specMat.entrega3;
                        const hasLot1 = specMat.lot1 && specMat.lot1.trim() !== '';
                        
                        if (hasEntrega1 && hasEntrega3 && hasLot1) {
                            isComplete = true;
                        }
                    }

                    if (isComplete) {
                        this.isSpecialVerificationSubmitted = true;
                        StatusHandler.ShowStatus("Verificación Completada", StatusHandler.OPERATION.CREATE,StatusHandler.STATUS.SUCCESS);
                    } else {
                        this.isSpecialVerificationSubmitted = false;
                        StatusHandler.ShowStatus("Avance Guardado", StatusHandler.OPERATION.CREATE,StatusHandler.STATUS.SUCCESS);
                    }

                } catch (error) {
                    console.error("Error en verificación especial:", error);
                    StatusHandler.Exception("Error al realizar verificación especial", error.message);
                } finally {
                     // saveOrUpdate o StatusHandler manejan el cierre del loader generalmente
                }
            },

            initProcess: async function(){

                //Validaciones de campos requeridos aqui
                if(this.data.times.init_date == null || this.data.times.init_date.length < 10){StatusHandler.ValidationMsg("Campo fecha de inicio requerido");return;}
                if(this.data.times.init_time == null || this.data.times.init_time.length < 5){StatusHandler.ValidationMsg("Campo hora de inicio requerido");return;}


                var init_datetime = convertServerDateTime(this.data.times.init_date.trim() + " " +this.data.times.init_time.trim()+":00");
                var real_performance = this.data.real_performance;
                if(init_datetime == null){alert("ERROR, Fecha inconsistente");return;}


                if(this.data.lot_num == null || this.data.lot_num.length == 0){
                    StatusHandler.ValidationMsg("Número de lote requerido");
                    return;
                }

                // Assuming 'data' is a property of the component instance
                // and 'isSpecialVerificationSubmitted' is a new property to be added to it.
                // This assumes 'this.data' is the object where the new property should reside.
                this.$set(this.data, 'isSpecialVerificationSubmitted', false); // Controla si ya se guardó la verificación especial


                var data_send = {
                    init_datetime,
                    lot_num: this.data.lot_num
                }

                var confirm = await StatusHandler.Confirm("!Confirmar guardado!");
                if(!confirm)return;


                StatusHandler.LShow();
                initMixOrder(this.data.order_id,data_send).then(result=>{
                    let response = result.data;
                    if(response.code == 0){
                        StatusHandler.ShowStatus(response.msg,StatusHandler.OPERATION.DEFAULT,StatusHandler.STATUS.FAIL);
                        return;
                    }

                    this.data = formatOrderDB(response.data);
                    this.edit_mode = false;
                    StatusHandler.LClose();
                    StatusHandler.ShowStatus("Guardado Existoso!",StatusHandler.OPERATION.CREATE,StatusHandler.STATUS.SUCCESS);

                    

                }).catch(ex=>{
                    StatusHandler.LClose();
                    StatusHandler.Exception("Guardar orden",ex);
                });
            },
            generatedReport: function(type){
                var open_url;
                if(type == 1){
                    open_url = this.app_vars.base_url + `/report/mixorder/${this.data.order_id}`;
                }else{
                    open_url = this.app_vars.base_url + `/report/vinietas/${this.data.order_id}`;
                }

                window.open(open_url, '_blank').focus();
            },

            finishProcess: async function(){

                //Validaciones de campos requeridos aqui
                if(this.data.times.end_date == null || this.data.times.end_date.length < 10){StatusHandler.ValidationMsg("Campo fecha de finalización requerido");return;}
                if(this.data.times.end_time == null || this.data.times.end_time.length < 5){StatusHandler.ValidationMsg("Campo hora de finalización requerido");return;}
                if(this.data.real_performance == null || this.data.real_performance.length < 1){StatusHandler.ValidationMsg("Campo rendimiento real requerido");return;}

                var end_datetime = convertServerDateTime(this.data.times.end_date + " " +this.data.times.end_time+":00");
                var real_performance = this.data.real_performance;

                if(end_datetime == null){alert("ERROR, Fecha inconsistente");return;}
                var data_send = {
                    real_performance,
                    end_datetime,
                }

                var confirm = await StatusHandler.Confirm("!Confirmar finalizado!");
                if(!confirm)return;


                StatusHandler.LShow();
                finishOrder(this.data.order_id,data_send).then(result=>{
                    let response = result.data;
                    if(response.code == 0){
                        StatusHandler.LClose();
                        StatusHandler.ShowStatus(response.msg,StatusHandler.OPERATION.DEFAULT,StatusHandler.STATUS.FAIL);
                        return;
                    }

                    this.data = formatOrderDB(response.data);

                    StatusHandler.LClose();
                    StatusHandler.ShowStatus("Finalizado Existoso!",StatusHandler.OPERATION.CREATE,StatusHandler.STATUS.SUCCESS);
                }).catch(ex=>{
                    StatusHandler.LClose();
                    StatusHandler.Exception("Finalizar orden",ex);
                });
            },

          autorizeFinishedOrder: async function(){
                var confirm = await StatusHandler.Confirm("¡Confirmar autorización de finalizado!");
                if(!confirm) return;

                // 👉 Forzar al menos una revisión antes de enviar
                if (!this.data.revisiones || this.data.revisiones.length === 0) {
                    this.data.revisiones = [ getJSONRevision() ];
                } else {
                    this.data.revisiones[0] = getJSONRevision();
                }

                StatusHandler.LShow();

                // 🐞 DEPURACIÓN: revisar qué datos mandamos al backend
                console.log("🟡 Payload que se enviará en autorizeFinishedOrder:", JSON.stringify(this.data, null, 2));

                autorizeFinishedOrder(this.data).then(result => {
                    let response = result.data;
                    if(response.code == 0){
                        StatusHandler.LClose();
                        StatusHandler.ShowStatus(response.msg, StatusHandler.OPERATION.DEFAULT, StatusHandler.STATUS.FAIL);
                        return;
                    }

                    this.data = formatOrderDB(response.data);

                    StatusHandler.LClose();
                    StatusHandler.ShowStatus("¡Autorización Exitosa!", StatusHandler.OPERATION.CREATE, StatusHandler.STATUS.SUCCESS);
                }).catch(ex => {
                    StatusHandler.LClose();
                    StatusHandler.Exception("Autorización de finalización", ex);
                });
            },






            has_cap(e){
                return window.has_cap == undefined ? false : window.has_cap(e);
            },


              onLot1Input(value, index) {
                // siempre en mayúsculas
                value = (value || '').toUpperCase();
                const material = this.data.materials[index];

                // asignamos el valor al modelo
                this.$set(material, 'lot1', value);

                // si no hay pleca, no hay duplicado
                if (!value.includes('/')) {
                material.duplicated = false;
                material.amount1 = null;
                material.amount2 = null;
                return;
                }

                // si ya estaba duplicado, no volver a preguntar
                if (material.duplicated) return;

                // primera vez que se escribe una pleca
                StatusHandler.Confirm('¿Desea duplicar el número de lote?')
                .then(confirm => {
                    if (!confirm) {
                    // quitar la pleca si el usuario dice que no
                    material.lot1 = value.replace(/\//g, '');
                    material.duplicated = false;
                    return;
                    }

                    // dejar la pleca “bonita”
                    material.lot1 = value.replace('/', ' / ');
                    material.duplicated = true;

                    // inicializar cantidades
                    const required = parseFloat(material.required_amount) || 0;
                    const decimals = this.getDecimalCount(material.required_amount);

                    material.amount1 = required.toFixed(decimals);
                    material.amount2 = (0).toFixed(decimals);
                });
            },

            handleInputUppercase(field, index) {
                // Convierte a mayúsculas y asigna el valor
                this.data.materials[index][field] = this.data.materials[index][field].toUpperCase();
            },

            async checkIfDuplicateLote(e, index) {
                console.log(e.key)
                if (e.key === '/') {  // Verifica si la tecla presionada es "/"
                    e.preventDefault();
                    if(!e.target.value.includes('/')){ //verifica que no se haya insertado una fleca
                        const confirm = await StatusHandler.Confirm("¿Desea duplicar el número de lote?", '');
                        if (!confirm) {
                            this.data.materials[index].lot1 = this.data.materials[index].lot1.replace(/\//g, '');
                        }else{
                            this.data.materials[index].lot1 = this.data.materials[index].lot1 + " / ";
                            this.data.materials[index].duplicated = true;
                            
                            // Inicializar los valores de cantidad
                            const material = this.data.materials[index];
                            const decimals = this.getDecimalCount(material.required_amount);
                            
                            // Establecer amount1 con el total requerido
                            material.amount1 = parseFloat(material.required_amount).toFixed(decimals);
                            // Establecer amount2 en 0
                            material.amount2 = (0).toFixed(decimals);
                            
                            this.arrowRightEvent(e.target);
                        }
                    }
                }

                if(e.key === 'Backspace' && !e.target.value.includes('/')){ //verifica si 
                    this.data.materials[index].duplicated = false;
                    // Limpiar los valores cuando se desactiva el duplicado
                    this.data.materials[index].amount1 = null;
                    this.data.materials[index].amount2 = null;
                } 
            },

            arrowRightEvent(input) {
                // Mover el cursor al final del input
                const inputElement = input;

                // Establecer el cursor al final del texto del input
                inputElement.setSelectionRange(inputElement.value.length, inputElement.value.length);
                
                // Focalizar el input para asegurarse de que el cursor esté en el lugar correcto
                inputElement.focus();
            },

            // async saveLotChanges() {
            //     try {
            //         const confirm = await StatusHandler.Confirm("¿Confirmar registro de cambios de lote?");
            //         if (!confirm) return;

            //         StatusHandler.LShow();

            //         for (const m of this.data.materials) {
            //             if (m.code === '809909900100') continue;

            //             // Solo enviar el lote 1 (excluyendo lote2)
            //             const payload = {
            //                 lot1: m.lot1 || null
            //             };

            //             const response = await changeLot(m.material_id, payload); // ⚠️ Usa el endpoint correcto aquí

            //             if (response.data.code !== 1) {
            //                 throw new Error(response.data.msg || "Error al actualizar lote");
            //             }

            //             const updatedMaterial = response.data.data?.material;
            //             if (updatedMaterial) {
            //                 const idx = this.data.materials.findIndex(mat => mat.material_id === updatedMaterial.id);
            //                 if (idx !== -1) {
            //                     this.$set(this.data.materials, idx, {
            //                         ...this.data.materials[idx],
            //                         ...updatedMaterial
            //                     });
            //                 }
            //             }

            //             if (response.data.data?.observaciones) {
            //                 this.data.observations = response.data.data.observaciones;
            //             }

            //             this.data.status = 2;
            //         }

            //         this.edit_mode = false;
            //         StatusHandler.ShowStatus("Cambios de lote registrados correctamente", StatusHandler.OPERATION.SUCCESS);

            //     } catch (error) {
            //         StatusHandler.Exception("Guardar cambios de lote", error.message);
            //     } finally {
            //         StatusHandler.LClose();
            //     }
            // }

           
        async saveLotChanges() {
            if (this.isSubmitting) return;
            this.isSubmitting = true;

            try {
                const confirm = await StatusHandler.Confirm("¿Confirmar registro de cambios?");
                if (!confirm) {
                    this.isSubmitting = false;
                    return;
                }

                StatusHandler.LShow();

                const changesByLot = {};
                let totalChanges = 0;

                for (const m of this.data.materials) {
                    if (m.code === '809909900100') continue;

                    const currentLotBase = (m.lot1 ?? '').replace(/\*+$/, '').trim();
                    const originalLotBase = (m.original_lot1 ?? '').replace(/\*+$/, '').trim();

                    const amount1Changed = parseFloat(m.amount1) !== parseFloat(m.original_amount1);
                    const amount2Changed = parseFloat(m.amount2) !== parseFloat(m.original_amount2);
                    const lotChanged = currentLotBase !== originalLotBase;

                    // Evitar enviar materiales sin cambios
                    if (!lotChanged && !amount1Changed && !amount2Changed) {
                        continue;
                    }

                    if (!changesByLot[currentLotBase]) {
                        changesByLot[currentLotBase] = [];
                    }

                    changesByLot[currentLotBase].push({
                        material_id: m.material_id,
                        new_lot: currentLotBase,
                        amount1: m.amount1 !== undefined && m.amount1 !== null ? parseFloat(m.amount1) : null,
                        amount2: m.amount2 !== undefined && m.amount2 !== null ? parseFloat(m.amount2) : null
                    });

                    totalChanges++;
                }

                this.data.lot1_changes = totalChanges;

                if (totalChanges === 0) {
                    StatusHandler.ValidationMsg("No hay cambios para guardar.");
                    this.isSubmitting = false;
                    StatusHandler.LClose();
                    return;
                }

                const lotKeys = Object.keys(changesByLot);
                let allUpdatedMaterials = [];

                for (const lotKey of lotKeys) {
                    const lotChanges = changesByLot[lotKey];
                    const response = await changeLotsBulk({ changes: lotChanges });

                    if (response.data.code !== 1) {
                        throw new Error(response.data.msg || `Error al actualizar lote ${lotKey}`);
                    }

                    const updatedMaterials = response.data.data?.materials || [];
                    allUpdatedMaterials.push(...updatedMaterials);

                    // ✅ FIX: Usar directamente la respuesta del backend para las observaciones
                    // El backend ya se encarga de formatear y concatenar correctamente.
                    if (response.data.data?.observaciones) {
                        this.data.observations = response.data.data.observaciones;
                    }
                }

                for (const updated of allUpdatedMaterials) {
                    const idx = this.data.materials.findIndex(m => m.material_id === updated.id);
                    if (idx !== -1) {
                        const decs = this.getDecimalCount(this.data.materials[idx].required_amount);
                        this.$set(this.data.materials, idx, {
                            ...this.data.materials[idx],
                            lot1: updated.lot1,
                            old_lot1: updated.old_lot1,
                            modification_count: updated.modification_count,
                            modified_by: updated.modified_by,
                            modification_date: updated.modification_date,
                            bitacora: updated.bitacora,
                            material_id: updated.id,
                            entrega1: updated.entrega1,
                            amount1: updated.amount1 !== null ? Number(updated.amount1).toFixed(decs) : '',
                            amount2: updated.amount2 !== null ? Number(updated.amount2).toFixed(decs) : '',
                            entrega2: false,
                            lot2: ''
                        });

                        // Actualizar valores originales para evitar falsos positivos
                        this.data.materials[idx].original_lot1 = updated.lot1;
                        this.data.materials[idx].original_amount1 = updated.amount1;
                        this.data.materials[idx].original_amount2 = updated.amount2;
                    }
                }

                this.data.status = 2;
                this.data.strict_modification = true;
                this.strict_mode = false;

                StatusHandler.ShowStatus("Cambios registrados correctamente", StatusHandler.OPERATION.SUCCESS);

            } catch (error) {
                StatusHandler.Exception("Guardar cambios", error.message);
            } finally {
                this.isSubmitting = false;
                StatusHandler.LClose();
            }
        }



        }
    }
</script>

<style>
.is-half-complete {
    border-color: #4CAF50;
    background-color: #f8fff8;
}

/* Estilo base del checkbox */
.form-check-input-mezcla.is-valid {
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;
  width: 15px;
  height: 15px;
  border: 1px solid #4CAF50;
  border-radius: 3px;
  outline: none;
  cursor: pointer;
  transition: all 0.2s ease;
}

/* Estilo cuando está checked */
.form-check-input-mezcla.is-valid:checked {
  background-color: #00b4d8;
  border-color: #0096c7;
  position: relative;
}

/* Checkmark perfectamente centrado */
.form-check-input-mezcla.is-valid:checked::after {
  content: "";
  position: absolute;
  left: 48%;
  top: 50%;
  width: 4px;
  height: 8px;
  border: solid white;
  border-width: 0 0px 0px 0;
  transform: translate(-50%, -60%) rotate(45deg); /* Ajuste fino en el eje Y */
}

/* Estilo cuando está disabled */
.form-check-input-mezcla.is-valid:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}
</style>
