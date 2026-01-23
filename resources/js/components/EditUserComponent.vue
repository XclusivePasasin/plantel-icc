<template>
<div>
    <div class="row g-4 align-items-center">
        <div class="col">
           <h1 class="h3 m-0">{{this.user.name}}</h1>
        </div>
        
        <div class="col-auto d-flex">
            <button href="#" class="btn btn-danger me-3" :hidden="status=='Inactivo'" @click=changeStatus>Desactivar</button>
            <button href="#" class="btn btn-success me-3" :hidden="status=='Activo'" @click=changeStatus>Activar</button> 
            <button href="#" class="btn btn-dark" :disabled="edit_mode==true" :hidden="status=='Inactivo'" @click="edit_mode=true">Editar</button>
        </div>
    </div>


    
    <div class="sa-entity-layout sa-entity-layout--size--md" data-sa-container-query="{&quot;920&quot;:&quot;sa-entity-layout--size--md&quot;}">
        <div class="sa-entity-layout__body">
            <div class="sa-entity-layout__sidebar">
                <div class="card">
                    <div class="card-body d-flex flex-column align-items-center">
                       <div class="text-center mt-4">
                            <div class="fs-exact-16 fw-medium">
                                {{this.user.name}}
                            </div>

                        </div>
                        
                        <div class="sa-divider my-5"></div>
                        
                        <div class="w-100">
                            <dl class="list-unstyled m-0">
                                <dt class="fs-exact-14 fw-medium">{{this.user.email}}</dt>
                                <dd class="fs-exact-13 text-muted mb-0 mt-1">Correo electrónico <a href="app-order.html"></a></dd>
                            </dl>
                            
                            <dl class="list-unstyled m-0 mt-4"><dt class="fs-exact-14 fw-medium">{{rol_user_name}}</dt>
                                <dd class="fs-exact-13 text-muted mb-0 mt-1">Rol</dd>
                            </dl>

                            <dl class="list-unstyled m-0 mt-4"><dt class="fs-exact-14 fw-medium">{{this.user.status}}</dt>
                                <dd class="fs-exact-13 text-muted mb-0 mt-1">Estado</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="sa-entity-layout__main">
               
                <div class="card mt-5">
                    <div class="card-body px-5 py-4 d-flex align-items-center justify-content-between">
                        <h2 class="mb-0 fs-exact-18 me-4">Permisos</h2>
                        <div class="text-muted fs-exact-14 text-end">
                            Listado de persmisos para {{this.user.name}}
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="sa-table text-nowrap">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="permission in permissions" :key="permission.id">
                                    <td></td>
                                    <td>
                                        {{permission.name}}
                                    </td>
                                    <td>
                                        {{permission.description}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="sa-divider"></div>
                   
                </div>
                
               
                <div class="card mt-5" :hidden="!(edit_mode)">
                    <div class="card-body px-5 py-4 d-flex align-items-center justify-content-between">
                        <h2 class="mb-0 fs-exact-18 me-4">Usuario</h2>
                    </div>
                    <div class="sa-divider"></div>
                        <div class="container" style="padding-left:15%;">
                            <div class="col-12">
                                <div class="row py-4">
                                    <div style="width:25%;">
                                        <label for="inputName" class="form-label">Nombre</label>
                                    </div>
                                    <div style="width:50%;">
                                        <input
                                            :disabled="!(edit_mode)"
                                            type="text"
                                            id="inputName"
                                            class="form-control"
                                            v-model="name"
                                            
                                        /> 
                                    </div>
                                </div>

                                <div class="row py-4">
                                    <div style="width:25%;">
                                        <label for="inputEmail" class="form-label">Correo electrónico</label> 
                                    </div>
                                    <div style="width:50%;">
                                        <input
                                            :disabled="!(edit_mode)"
                                            type="email"
                                            id="inputEmail"
                                            class="form-control"
                                            v-model="email"
                                            @change="validate_user"
                                        /> 
                                    </div>
                                </div>

                                <div class="row py-4"  style="width:75%; text-align:center;" :hidden="!(this.msg_invalid_user)">
                                    <span class="invalid-feedback" role="alert" style="display: block !important;">
                                        <strong>Este usuario ya está registrado</strong>
                                    </span> 
                                </div>

                                <div class="sa-divider"></div>

                                <div class="row py-4">
                                    <span class="badge badge-sa-light py-4">Solo si desea cambiar la contraseña, haga uso de los siguiente campos</span>
                                    <div style="width:25%;">
                                        <label for="inputPassword" class="form-label">Contraseña</label> 
                                    </div>
                                    <div style="width:50%;">
                                        <input
                                            :disabled="!(edit_mode)"
                                            type="password"
                                            id="inputPassword"
                                            class="form-control"
                                            v-model="password"
                                        /> 
                                    </div>
                                </div>

                                 <div class="row py-4">
                                   
                                    <div style="width:25%;">
                                        <label for="inputPasswordConfirmation" class="form-label">Confirmación de contraseña</label> 
                                    </div>
                                    <div style="width:50%;">
                                        <input
                                            :disabled="!(edit_mode)"
                                            type="password"
                                            id="inputPasswordConfirmation"
                                            class="form-control"
                                            v-model="password_confirm"
                                            @change="password_confirmation"
                                        /> 
                                    </div>
                                </div>

                                <div class="row py-4"  style="width:75%; text-align:center;" :hidden="!(this.msg_password_match)">
                                    <span class="invalid-feedback" role="alert" style="display: block !important;">
                                        <strong>Las contraseñas no coinciden</strong>
                                    </span> 
                                </div>


                                <div class="sa-divider"></div>
        
                                <div class="row py-4">
                                    <div style="width:25%;">
                                        <label for="inputRolAlternativo" class="form-label">Rol Alternativo</label> 
                                    </div>
                                    <div style="width:50%;">
                                        <select class="form-select" id="inputRolAlternativo" v-model="rol_alternativo" :disabled="!(edit_mode)">
                                            <option selected value="">--Seleccione un rol alternativo--</option>
                                            <option value="CIP">CIP</option>
                                            <option value="Materia Prima">Materia Prima</option>
                                            <option value="Material de Empaque">Material de Empaque</option>
                                            <option value="Analista de Calidad">Analista de Calidad</option>
                                            <option value="Supervisor de Calidad">Supervisor de Calidad</option>
                                            <option value="Auxiliar de Ctrl de Calidad">Auxiliar de Ctrl de Calidad</option>
                                            <option value="Mezclado">Mezclado</option>
                                            <option value="Mezcla">Mezcla</option>
                                            <option value="Supervisor de producción">Supervisor de producción</option>
                                            <option value="Administrador">Administrador</option>
                                            <option value="Producción">Producción</option>
                                            <option value="Jefe de Producción">Jefe de Producción</option>
                                            <option value="Jefe Control de Calidad">Jefe Control de Calidad</option>
                                            <option value="Auxiliar de Calidad Producto a Granel">Auxiliar de Calidad Producto a Granel</option>
                                            <option value="Muestreo MP">Muestreo MP</option>
                                            <option value="Testigo De Pesado">Testigo De Pesado</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row py-4">
                                    <div style="width:25%;">
                                        <label for="inputRol" class="form-label">Rol</label> 
                                    </div>
                                    <div style="width:50%;">
                                        <select class="form-select" id="inputRol" v-model="rol_option" :disabled="!(edit_mode)" >
                                            <option v-for="rol in roles" :key="rol.id" :value="rol.name">{{rol.name}}</option>
                                        </select>
                                    </div>
                                </div>
 
                                <div class="text-end mt-6 py-4">
                                    <div class="col-auto">
                                        <button type="button" class="btn btn-success" :disabled="edit_mode==false || msg_password_match==true || msg_invalid_user==true" @click="saveUser">Guardar</button>
                                    </div>            
                                </div>  
                            </div> 
                        </div> 
                   </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

const { updateUser, changeStatusUser } = require("../service.js");

export default {
    props: ['user', 'permissions', 'rol_user', 'roles', 'users'],
    
    data: function(){
            return {
                edit_mode: false,
                name : this.user.name,
                email : this.user.email,
                rol_user_name : this.rol_user[0],
                status : this.user.status,
                password : '',
                password_confirm : '',
                msg_password_match : false,
                msg_invalid_user: false,
                rol_option : this.rol_user[0],
                rol_alternativo: this.user.rol_alternativo || '',
            }
    },

     methods: {

         validate_user(){
            for (var i=0; i<this.users.length; i++){
                if(this.users[i].email==this.email){
                    this.msg_invalid_user = true
                    break
                }
                else{
                    this.msg_invalid_user = false
                }
            }
        },

         password_confirmation(){
           if(this.password!=this.password_confirm){
               this.msg_password_match = true;
           }
           else{
               this.msg_password_match = false;
           } 
         },

         saveUser: async function(){

                var data = {
                    name : this.name,
                    email: this.email,
                    password: this.password,
                    rol_option: this.rol_option,
                    rol_alternativo: this.rol_alternativo,
                }
               
                var confirm = await StatusHandler.Confirm("!Confirmar actualizado!");
                if(!confirm)return;
                
                StatusHandler.LShow();
               
                updateUser(this.user.id, data).then(result=>{
                    let response = result.data;
                    if(response.code == 0){
                        StatusHandler.ShowStatus(response.msg,StatusHandler.OPERATION.DEFAULT,StatusHandler.STATUS.FAIL);
                        return;
                    }
                    // StatusHandler.LClose();
                    StatusHandler.ShowStatus("Actualizado Existoso!",StatusHandler.OPERATION.SUCCESS,StatusHandler.STATUS.SUCCESS); 
                    window.location.href=`/admin/users/edit/${this.user.id}`
                                    
                }).catch(ex=>{
                    // StatusHandler.LClose();
                    StatusHandler.Exception("Actualizar usuario",ex);                    
                });
        },

        changeStatus: async function(){
                
                var msg_confirm = this.user.status == 'Activo' ? '!Confirmar desactivado!' : '!Confirmar activado!'
                var confirm = await StatusHandler.Confirm(msg_confirm);
                
                if(!confirm)return;
                
                StatusHandler.LShow();
               
                changeStatusUser(this.user.id).then(result=>{
                    let response = result.data;
                    if(response.code == 0){
                        StatusHandler.ShowStatus(response.msg,StatusHandler.OPERATION.DEFAULT,StatusHandler.STATUS.FAIL);
                        return;
                    }
                    StatusHandler.LClose();
                    StatusHandler.ShowStatus("Desactivado Existoso!",StatusHandler.OPERATION.DEFAULT,StatusHandler.STATUS.SUCCESS); 
                                    
                }).catch(ex=>{
                    StatusHandler.LClose();
                    StatusHandler.Exception("Desactivar usuario",ex);             
                });

                window.location.reload();
            },
        

        
     }
     
}

</script>
