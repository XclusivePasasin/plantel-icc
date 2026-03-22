<template>
    <div class="py-4">
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="p-4">
                    <input
                        type="text"
                        placeholder="Ingrese el nombre, correo electrónico o rol del usuario..."
                        class="form-control form-control--search mx-auto"
                        id="table-search"
                        v-model="searchQuery"
                    />
                </div>
                <div class="sa-divider"></div>
                <div
                    id="DataTables_Table_0_wrapper"
                    class="dataTables_wrapper dt-bootstrap5 no-footer"
                >
                    <div class="sa-datatables">
                        <div class="sa-datatables__table">
                            <table
                                class="sa-datatables-init dataTable no-footer"
                                data-order='[[ 1, "asc" ]]'
                                data-sa-search-input="#table-search"
                                id="DataTables_Table_0"
                                role="grid"
                                aria-describedby="DataTables_Table_0_info"
                            >
                                <thead>
                                    <tr role="row">
                                        <th
                                            class="min-w-20x sorting sorting_asc"
                                            tabindex="0"
                                            aria-controls="DataTables_Table_0"
                                            rowspan="1"
                                            colspan="1"
                                            aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending"
                                            style="width: 320px"
                                        >
                                            Nombre
                                        </th>
                                        <th
                                            class="sorting"
                                            tabindex="0"
                                            aria-controls="DataTables_Table_0"
                                            rowspan="1"
                                            colspan="1"
                                            aria-label="Registered: activate to sort column ascending"
                                            style="width: 114.609px"
                                        >
                                            Correo
                                        </th>
                                        <th
                                            class="sorting"
                                            tabindex="0"
                                            aria-controls="DataTables_Table_0"
                                            rowspan="1"
                                            colspan="1"
                                            aria-label="Country: activate to sort column ascending"
                                            style="width: 52.7188px"
                                        >
                                            Rol
                                        </th>
                                        <th
                                            class="sorting"
                                            tabindex="0"
                                            aria-controls="DataTables_Table_0"
                                            rowspan="1"
                                            colspan="1"
                                            aria-label="Group: activate to sort column ascending"
                                            style="width: 55.2812px"
                                        >
                                            Estado
                                        </th>
                                        <th
                                            class="sorting"
                                            tabindex="0"
                                            aria-controls="DataTables_Table_0"
                                            rowspan="1"
                                            colspan="1"
                                            aria-label="Spent: activate to sort column ascending"
                                            style="width: 55.2969px"
                                        >
                                            Acción
                                        </th>
                                        <th
                                            class="w-min sorting_disabled"
                                            data-orderable="false"
                                            rowspan="1"
                                            colspan="1"
                                            aria-label=""
                                            style="width: 25px"
                                        ></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr
                                        class="odd"
                                        v-for="user in filteredUsers"
                                        :key="user.id"
                                    >
                                        <td class="sorting_1">
                                            <div
                                                class="d-flex align-items-center"
                                            >
                                                <div>
                                                    <a
                                                        href="#"
                                                        class="text-reset"
                                                        @click="editUser(user.id)"
                                                        >{{ user.name }}</a
                                                    >
                                                </div>
                                            </div>
                                        </td>

                                        <td class="text-nowrap">
                                            {{ user.email }}
                                        </td>
                                        <td>{{ user.roles.length > 0 ? user.roles[0].name : 'Sin rol' }}</td>
                                        <td :hidden="user.status == 'Inactivo'"><span class="badge badge-sa-pill badge-sa-success">{{user.status}}</span></td>
                                        <td :hidden="user.status == 'Activo'"><span class="badge badge-sa-pill badge-sa-danger">{{user.status}}</span></td>
                                        <td>
                                            <div class="dropdown">
                                                <button
                                                    class="btn btn-sa-muted btn-sm"
                                                    type="button"
                                                    id="customer-context-menu-1"
                                                    data-bs-toggle="dropdown"
                                                    aria-expanded="false"
                                                    aria-label="More"
                                                >
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        width="3"
                                                        height="13"
                                                        fill="currentColor"
                                                    >
                                                        <path
                                                            d="M1.5,8C0.7,8,0,7.3,0,6.5S0.7,5,1.5,5S3,5.7,3,6.5S2.3,8,1.5,8z M1.5,3C0.7,3,0,2.3,0,1.5S0.7,0,1.5,0 S3,0.7,3,1.5S2.3,3,1.5,3z M1.5,10C2.3,10,3,10.7,3,11.5S2.3,13,1.5,13S0,12.3,0,11.5S0.7,10,1.5,10z"
                                                        ></path>
                                                    </svg>
                                                </button>
                                                <ul
                                                    class="dropdown-menu dropdown-menu-end"
                                                    aria-labelledby="customer-context-menu-1"
                                                >
                                                    <li>
                                                        <a
                                                            class="dropdown-item"
                                                            href="#"
                                                            @click="editUser(user.id)"
                                                            >Administrar usuario</a
                                                        >
                                                    </li>
                                                    <li>
                                                        <hr
                                                            class="dropdown-divider"
                                                        />
                                                    </li>
                                                    <li>
                                                        <a 
                                                            class="dropdown-item text-danger"
                                                            href="#"
                                                            @click="changeStatus(user.id, user.status)"
                                                            >{{user.status == 'Activo' ? 'Desactivar' : 'Activar'}}</a
                                                        >
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
const { getUsers, changeStatusUser } = require("../service.js");

export default {
    data() {
        return {
            users: [],
            searchQuery: null,
        };
    },

     mounted() {
        getUsers().then((response) => (this.users = response.data.data.users));
    },

    computed: {
       filteredUsers (){
       if(this.searchQuery){
        return this.users.filter((item)=>{
            const roleName = item.roles && item.roles.length > 0 ? item.roles[0].name.toLowerCase() : '';
            return this.searchQuery.toLowerCase().split(' ')
            .every(u => 
            item.email.toLowerCase().includes(u) || item.name.toLowerCase().includes(u) || roleName.includes(u))

        })
        }else{
            return this.users;
        }
    }
    },

    methods: {
            editUser(user_id){
                window.location.href=`/admin/users/edit/${user_id}`;
            },

            changeStatus: async function(user_id, user_status){
                
                var msg_confirm = user_status == 'Activo' ? '!Confirmar desactivado!' : '!Confirmar activado!'
                var confirm = await StatusHandler.Confirm(msg_confirm);
                
                if(!confirm)return;
                
                StatusHandler.LShow();
               
                changeStatusUser(user_id).then(result=>{
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
     
};
</script>
