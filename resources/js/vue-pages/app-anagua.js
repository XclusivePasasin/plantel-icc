Vue.component('analisisagua', require('../components/VerificacionAnalisisAguaComponent.vue').default);

const analisisLoader = new Vue({
  el: "#analisisLoader",
  data: {
    helpers: {
      h1: false,
      bandera: true, // Para mostrar directamente el componente
      estado: 0,
    },
    panels: {
      p1: false
    },
    order: [], // No necesario si no usas datos de orden
    order_code: '' // Puedes eliminar esto también si no se usa
  }
});
