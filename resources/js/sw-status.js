

export default class StatusHandler {
    static get OPERATION() {
        return {
            SAVE: 1,
            DELETE: 2,
            UPDATE: 3,
            DEFAULT: 4
        }
    };

    static get STATUS() {
        return {
            FAIL: 0,
            SUCCESS: 1
        };
    }

    static Confirm($title = null,$text = null) {
        return Swal.fire({
            title: $title == null ? "¿Está usted seguro?" : $title,
            text: $text == null ? "¡No podrás revertir esto! ":$text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, ¡Continuar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            return result.isConfirmed;
        })
    }

    static LShow($title = null, $subtitle = null) {
        var title = $title == null ? "¡ Procesando datos ¡" : $title;
        var sub = $subtitle == null ? "Por favor, espere..." : $subtitle;
        let node = `<div class='lds-dual-ring'></div></br><span>${sub}</span>`;
        Swal.fire({
            title: title,
            html: node,
            showConfirmButton: false,
            allowOutsideClick: false
        });
    }

    static LClose() {
        Swal.close();
    }

    static Exception(target_msg, data_ex) {
        console.error(data_ex);
        //HTTP 401 la petición (request) no ha sido ejecutada porque carece de credenciales
        if (data_ex?.response?.status == 401) {//para volver al inicio/login 
            window.location.reload();
        } else {
            let msg = "El proceso (" + target_msg + ")no se ha podido completar, póngase con soporte técnico."
            this.ShowStatus(msg, null, StatusHandler.STATUS.FAIL);
        }
    }

    static ValidationMsg(mensaje) {
        Swal.fire({
            icon: 'info',
            title: 'Informe de validación',
            text: mensaje,
            showCloseButton: true
        })
    }


    static ShowStatus(mensaje, tipo, estado) {
        let msgContent = "";
        let msgTitle = "";
        let msgIcon = "";
        msgContent = mensaje;

        if (estado == this.STATUS.FAIL) {
            msgIcon = 'error';
            msgTitle = "ERROR EN LA OPERACION";
        } else if (estado == this.STATUS.SUCCESS) {
            msgIcon = "success";
            switch (tipo) {
                case this.OPERATION.INSERT:
                    msgTitle = "Informe de Registro";
                    break;
                case this.OPERATION.UPDATE:
                    msgTitle = "Informe de Actualizacion";
                    break;
                case this.OPERATION.DELETE:
                    msgTitle = "Informe de Eliminacion";
                    break;
                default:
                    msgIcon = "info";
                    msgTitle = "Informe de Operacion";
                    break;
            }
        }

        Swal.fire({
            icon: msgIcon,
            title: msgTitle,
            text: msgContent,
            showCloseButton: true
        })
    }
}