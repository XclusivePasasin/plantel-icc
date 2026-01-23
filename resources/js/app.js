require('./bootstrap.js');
// Importar Bootstrap Icons (primero)
require('bootstrap-icons/font/bootstrap-icons.css');
window.Vue = require('vue');
window.$ = window.jQuery = require('jquery');
window.moment = require('moment');  
window.moment.locale('es-us');

// Configuración de Bootstrap Datepicker
require('bootstrap-datepicker');
require('bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css');
require('bootstrap-datepicker/js/locales/bootstrap-datepicker.es');
require('bootstrap-timepicker/css/bootstrap-timepicker.min.css');
require('bootstrap-timepicker/js/bootstrap-timepicker.min.js');


/**Sweet Alert */
window.Swal = require('sweetalert2');
/*This file handle the alerts*/
window.StatusHandler = require('./sw-status').default;

