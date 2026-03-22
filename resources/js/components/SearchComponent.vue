<template>

    <div class="px-4 py-5 my-5">
        <div class="col-lg-6 mx-auto text-center text-dark shadow-none p-0 p-md-3">

            <span class="d-block brand-fix3"><i class="bi bi-file-earmark-ruled" style="font-size: 2.4rem;"></i></span>
            <h5 class="fw-bold m-0" style="color: black !important;">CARGAR ORDEN</h5>

            <p class="lead mb-4">Ingrese número de orden para realizar la carga</p>

            <div class="input-group mb-4 mt-2">
                <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                <input @keydown="enterKey($event)" type="text" v-model="search_val" class="form-control" placeholder="Código de orden . . "
                    aria-label="Codigo de orden" aria-describedby="basic-addon1" />
                <!-- <p v-if="helpers.h1">Código de orden no encontrado</p> -->
            </div>

            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mb-5 mt-3">
                <button @click="sendValue" type="button" class="btnfix1">
                    <i class="bi bi-upload"></i>
                    Cargar
                    </button>
            </div>
            <div class="col-lg-12 text-center text-dark">
            <div class="row" id="pnlSecondary">
                <div v-for="order in activeOrders" 
                    :key="order.id" 
                    :class="getColClass" 
                    class="mx-auto">
                    <div>
                    <a href="#" @click="goActiveOrder(order.num_id)" class="info-box">
                        <div class="info-box-icon pendiente-aprobacion-pesaje">
                        <i class="bi bi-file-text-fill"></i>
                        </div>
                        <div class="info-box-content">
                            <span class="info-box-text"><strong>#{{ order.num_id }} </strong> -- {{ order.product_name }} -- LOT. {{ order.lot_num }}</span><br>
                            <span class="info-box-number">{{ getStatusDescription(order.status) }}</span>
                        </div>
                    </a>
                    </div>
                </div>
                <br>
                </div>
        </div>
        </div>

    </div>
</template>

<script>
    export default {
        props: {
            title: {type: String,required:true,default:""},
            aorders: { type: Array, required: false, default: () => [] },
            typeorder: { type: String, required: false, default: ""},
        },
        data() {
            return {
                search_val: "",
                activeOrders: this.aorders
            };
        },
        methods: {
            sendValue: function(){
                this.$emit('load-order',this.search_val.trim());
            },
            enterKey: function(e){
                if(e.key === 'Enter') {
                    this.sendValue();  
                }
            },
            getColClass() {
                const count = this.activeOrders.length;
                if (count === 1) return 'col-lg-12';
                if (count === 2) return 'col-lg-6';
                return 'col-lg-4';
            },
            goActiveOrder(id){
                this.$emit('load-order',id);
            },
    getStatusDescription(status) {
        console.log("TIPO DE ORDEN",this.typeorder)
        switch (status) {
            case 0:
                if(this.typeorder == "packing") {
                    return "Validación de Tanque Completada (Lista para cargar empaque)";
                }
                return "Estado desconocido";
            case 1:
                if(this.typeorder == "packing"){
                    return "Empaque Cargado (Pendiente)";
                }
                return "Estado desconocido";
            case 2:
                {
                    let message = "";
                    if(this.typeorder == "mix"){
                        message = "Falta registrar pesaje o pendiente de aprobar de pesaje";
                    }
                    if(this.typeorder == "packing"){
                        message = "Empaque cargado (Pendiente de autorizar)";
                    }
                    return message;
                }
            case 3:
                {
                    let message = "";
                    if(this.typeorder == "mix"){
                        message = "Pesaje aprobado (Pendiente de recibir materia prima o revisar orden)";
                    }
                    if(this.typeorder == "packing"){
                        message = "Empaque autorizado (Pendiente de finalizar)";
                    }
                    return message;
                }
            case 4:
                if(this.typeorder == "packing"){
                    return "Orden de empaque finalizada";
                }
                return "Orden de mezcla autorizada (Pendiente de iniciar proceso)";
            case -1:
                if(this.typeorder == "packing"){
                    return "Orden de empaque finalizada";
                }
                return "Mezcla revisada de materia prima";
            case 5:
                if(this.typeorder == "packing"){
                    return "Orden de empaque finalizada";
                }
                return "Mezcla en proceso...";
            case 6:
                if(this.typeorder == "packing"){
                    return "Orden de empaque finalizada";
                }
                return "Mezcla finalizada (Pendiente de autorización de finalizado)";
            case 7:
                if(this.typeorder == "packing"){
                    return "Orden de empaque finalizada";
                }
                return "Mezcla autorizada de finalización";
            default:
                return "Estado desconocido";
        }
    }
}
}
</script>
<style>
.info-box {
    display: flex;
    align-items: center;
    background: #fff;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: 0.3s;
    text-decoration: none;
    color: inherit;
    margin-bottom: 10px;
}
.info-box:hover {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}
.info-box-icon {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    margin-right: 15px;
    font-size: 24px;
    color: white;
}
.pendiente-aprobacion-pesaje {
  background: #ffc107; /* Amarillo - Pendiente */
}

.pesaje-aprobado {
  background: #28a745; /* Verde - Aprobado */
}

.pesaje-autorizado {
  background: #007bff; /* Azul - Autorizado */
}

.mezcla-revisada {
  background: #dc3545; /* Rojo - Revisada (Negativa) */
}

.mezcla-en-proceso {
  background: #17a2b8; /* Celeste - En Proceso */
}

.info-box-content {
    flex-grow: 1;
    justify-content: flex-start;
}
.info-box-text {
    font-size: 14px;
    color: #666;
    align-self: flex-start;
}
.info-box-number {
    font-size: 16px;
    font-weight: bold;
    align-self: flex-start;
}
</style>