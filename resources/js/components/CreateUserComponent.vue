<template>
    <div>
       
        <div class="row py-4">
            <div style="width:25%;">
                <label for="inputName" class="form-label">Nombre</label> 
            </div>
            <div style="width:50%;">
                <input
                    type="text"
                    id="inputName"
                    class="form-control"
                    v-model="name"
                /> 
            </div>
        </div>

        <div class="row py-4">
            <div style="width:25%;">
                <label for="inputEmail" class="form-label">Correo electrónico / Usuario</label> 
            </div>
            <div style="width:50%;">
                <input
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
            <div style="width:25%;">
                <label for="inputPassword" class="form-label">Password</label> 
            </div>
            <div style="width:50%;">
                <input
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
                <select class="form-select" id="inputRolAlternativo" v-model="rol_alternativo">
                    <option selected value="">--Seleccione un rol alternativo--</option>
                    <option value="CIP">CIP</option>
                    <option value="Materia Prima">Materia Prima</option>
                    <option value="Material de Empaque">Material de Empaque</option>
                    <option value="Analista de Calidad">Analista de Calidad</option>
                    <option value="Supervisor de Calidad">Supervisor de Calidad</option>
                    <option value="Auxiliar de Ctrl de Calidad">Auxiliar de Ctrl de Calidad</option>
                    <option value="Mezclado">Mezclado</option>
                    <option value="Supervisor de producción">Supervisor de producción</option>
                    <option value="Administrador">Administrador</option>
                    <option value="Producción">Producción</option>
                    <option value="Jefe de Producción">Jefe de Producción</option>
                    <option value="Jefe Control de Calidad">Jefe Control de Calidad</option>
                    <option value="Testigo de Pesado">Testigo de Pesado</option>
                    <option value="Auxiliar de Calidad Producto a Granel">Auxiliar de Calidad Producto a Granel</option>
                    <option value="Muestreo MP">Muestreo MP</option>
                </select>
            </div>
        </div>

        <div class="row py-4">
            <div style="width:25%;">
                <label for="inputRol" class="form-label">Rol</label> 
            </div>
            <div style="width:50%;">
                <select class="form-select" id="inputRol" v-model="rol">
                    <option selected>--Seleccione un rol--</option>
                    <option v-for="rol in roles" :key="rol.id" :value="rol.id">{{rol.name}}</option>
                </select>
            </div>
        </div>

        <div class="text-end mt-6 py-4">
            <div class="col-auto">
                <button type="button" class="btn btn-success" @click="saveUser" :disabled="msg_password_match==true || msg_invalid_user==true">Guardar</button>
            </div>            
        </div>  
    </div>
</template>

<script>
const { createUser } = require("../service.js");

export default {
  props: ['users', 'roles'],
  
   data: function(){
        return {
            msg_password_match : false,
            msg_invalid_user: false,
            name : '',
            email : '',
            password : '',
            password_confirm : '',
            rol : '',
            rol_alternativo: '',
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
                    rol: this.rol,
                    rol_alternativo: this.rol_alternativo,
                }

                var confirm = await StatusHandler.Confirm("!Confirmar guardado!");
                if(!confirm)return;
                
                StatusHandler.LShow();
               
                createUser(data).then(result=>{
                    let response = result.data;
                    if(response.code == 0){
                        StatusHandler.ShowStatus(response.msg,StatusHandler.OPERATION.DEFAULT,StatusHandler.STATUS.FAIL);
                        return;
                    }
                    // StatusHandler.LClose();
                    StatusHandler.ShowStatus("Guardado Existoso!",StatusHandler.OPERATION.DEFAULT,StatusHandler.STATUS.SUCCESS); 
                    window.location.href='/admin/users';               
                }).catch(ex=>{
                    // StatusHandler.LClose();
                    StatusHandler.Exception("Guardar usuario",ex); 
                    window.location.reload();
                });
            },
     }
};
</script>