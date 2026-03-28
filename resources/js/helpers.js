export function formatOrderDB(data) {
  return {
    status: data.status,
    status_receive_materials: data.status_receive_materials,
    order_id: data.id,
    lot1_changes: data.lot1_changes,
    date: data.order_date,
    num_id: data.num_id,
    product_code: data.product_code,
    strict_modification: data.strict_modification,
    product_name: data.product_name,
    lot_num: data.lot_num,
    lot_size: data.lot_size,
    observations: data.observaciones,
    times: {
      init_date: data.datetime_init ? moment(data.datetime_init, 'YYYY/MM/DD hh:mm:ss').format("DD/MM/YYYY") : null,
      end_date: data.datetime_end ? moment(data.datetime_end, 'YYYY/MM/DD hh:mm:ss').format("DD/MM/YYYY") : null,
      init_time: data.datetime_init ? moment(data.datetime_init, 'YYYY/MM/DD hh:mm:ss').format("HH:mm") : null,
      end_time: data.datetime_end ? moment(data.datetime_end, 'YYYY/MM/DD hh:mm:ss').format("HH:mm") : null,
      pesaje_inicio: data.pesaje_inicio
        ? moment(data.pesaje_inicio, 'DD/MM/YYYY hh:mm:ss').format("DD/MM/YYYY HH:mm")
        : null,

      pesaje_fin: data.pesaje_fin
        ? moment(data.pesaje_fin, 'DD/MM/YYYY hh:mm:ss').format("DD/MM/YYYY HH:mm")
        : null,



    },
    water: {
      check: data.water_check,
      firma: data.water_firma,
      date: data.water_date != null ? moment(data.water_date).format("DD/MM/YYYY") : null
    },
    revisiones: data.revisiones ? JSON.parse(data.revisiones).map(piv => {
      if (piv.date != null) {
        //piv.date = moment(piv.date).format("DD/MM/YYYY");
        piv.date = piv.date;
      }
      return piv;
    }) : [],
    cod_formula_master: data.cod_formula_master,
    real_performance: data.real_performance,
    auditor: {
      verified_by: data.verified_by,
      user_entrega: data.user_entrega,
      user_entrega_mp: data.user_entrega_mp,
      user_autoriza: data.user_autoriza,
      user_recibe: data.user_recibe,
      user_autoriza_finish: data.user_autoriza_finish || null,     // 👈 aquí
      autorize_finish_order: data.autorize_finish_order || null,
      materials_received_by: data.materials_received_by
    },
    materials: data.materials.map(ng => {
      return {
        material_id: ng.id,
        code: ng.code,
        description: ng.description,
        required_amount: ng.required_amount,
        amount1: ng.amount1,
        amount2: ng.amount2,
        unit: ng.unit,
        stock: ng.stock,
        almacen: ng.almacen,
        entrega1: ng.entrega1,
        entrega_duplicada1: ng.entrega_duplicada1 !== undefined && ng.entrega_duplicada1 !== null ? (ng.entrega_duplicada1 == 1) : false,
        lot1: ng.lot1,
        old_lot1: ng.old_lot1,
        entrega2: ng.entrega2,
        lot2: ng.lot2,
        entrega3: ng.entrega3
      }
    })
  }
}


export function formatOrderAPI(e) {
  return {
    status: 1, //pendiente de tomar
    order_id: 0,
    date: e.date,
    num_id: e.num,
    product_code: e.code_product,
    product_name: e.product,
    lot_num: null,
    lot_size: e.lot_size,
    observations: null,
    times: {
      init_date: null,
      end_date: null,
      init_time: null,
      end_time: null,
      finish_order_at: null,
      pesaje_inicio: null,
      pesaje_fin: null
    },
    water: {
      check: false,
      firma: null,
      date: null
    },
    revisiones: [],
    cod_formula_master: e.master_formula,
    real_performance: null,
    auditor: {
      verified_by: null,
      user_entrega: null,
      user_entrega_mp: null,
      user_autoriza: null,
      user_recibe: null,
      user_finish: null,
      finish_order_at: null
    },
    materials: e.materials.map(ng => {
      return {
        material_id: 0,
        code: ng.code,
        description: ng.description,
        required_amount: ng.required_amount,
        unit: ng.unity,
        stock: ng.stock,
        almacen: ng.almacen,
        entrega1: false,
        entrega_duplicada1: false,
        lot1: "",
        entrega2: false,
        lot2: ""
      }
    })
  }
}

//**** FOR JSON SECTION INSIDE PACKING ORDER ****//
export function getJSONTimes() {
  return {
    time_id: 0,
    date_init: null,
    time_init: null,
    format_init: null,
    date_end: null,
    time_end: null,
    format_end: null
  }
}

export function getJSONOperarios() {
  return {
    ope_id: 0,
    fullname: "",
    date: null
  }
}

export function getJSONEntregas() {
  return {
    date: null,
    cantidad: null,
    entrega: null,
    recibe: null,
    firma_bodegapt: null
  }
}
//**** END - FOR JSON SECTION INSIDE PACKING ORDER ****//

export function getJSONRevision() {
  return {
    username: null,
    firma: null,
    date: null
  }
}

export function formatPackingAPI(data) {
  return {
    status: 1, //pendiente de tomar
    order_id: 0,
    date: data.date,
    num_id: data.num,
    product_code: data.code_product,
    product_name: data.product,
    lot_size: data.lot_size,
    presentacion: data.presentacion,
    lot_num: data.lot_num,
    total_units: data.total_units,
    performance_teorico: null,
    performance: null,
    observations: "",
    auditor: {
      user_entrega: null,
      user_autoriza: null,
      user_recibe: null
    },
    times: [],
    operarios: [],
    entregas: [],
    // nuevos campos por si la API los entrega
    verificacion_lote: data.verificacion_lote ?? 0,
    user_verifico: data.user_verifico ?? null,
    materials: data.materials.map(ng => {
      return {
        material_id: 0,
        code: ng.code,
        description: ng.description,
        process: ng.proceso,
        required_amount: ng.required_amount,
        unit: ng.unity,
        almacen: ng.almacen,
        stock: ng.stock,
        tipo_prod: ng.tipo_prod || "",
        lot1: ng.lot1 || null,
        entrega1: (ng.entrega1 !== undefined && ng.entrega1 !== null) ? ng.entrega1 : null,
        entrega2: null,
        return: null
      }
    })
  }
}

function _normalizeDateForInput(raw) {
  if (raw === null || typeof raw === 'undefined') return null;
  // si viene con barras escapadas por JSON, quitar backslashes
  raw = String(raw).replace(/\\/g, '').trim();

  // Ya está en formato ISO yyyy-mm-dd
  if (/^\d{4}-\d{2}-\d{2}$/.test(raw)) return raw;

  // Formato dd/mm/yyyy -> convertir a yyyy-mm-dd
  if (/^\d{2}\/\d{2}\/\d{4}$/.test(raw)) {
    const parts = raw.split('/');
    const d = parts[0].padStart(2, '0');
    const m = parts[1].padStart(2, '0');
    const y = parts[2];
    return `${y}-${m}-${d}`;
  }

  // Si viene vacío o cualquier otro formato, devolver null para que el input aparezca vacío
  if (raw === '' || raw.toLowerCase() === 'null') return null;

  // último recurso: intentar parsear con Date y formatear a ISO si válido
  const dt = new Date(raw);
  if (!isNaN(dt.getTime())) {
    const yyyy = dt.getFullYear();
    const mm = String(dt.getMonth() + 1).padStart(2, '0');
    const dd = String(dt.getDate()).padStart(2, '0');
    return `${yyyy}-${mm}-${dd}`;
  }

  return null;
}

export function formatPackingDB(data) {
  console.log("formatPackingDB receiving data:", JSON.stringify(data.recepcion_retorno_json));
  // Asegurarse de no romper si data.materials no es un array
  let materialsArray = [];
  if (Array.isArray(data.materials)) {
    materialsArray = data.materials;
  } else if (data.materials && typeof data.materials === 'object') {
    // En caso que venga como objeto (keyed by ID, etc.), lo convertimos a array
    materialsArray = Object.values(data.materials);
  }

  // parse times / operarios / entregas guardados en JSON en DB
  let timesParsed = [];
  try {
    timesParsed = data.times ? JSON.parse(data.times) : [];
  } catch (e) {
    timesParsed = [];
  }

  // Normalizar formatos de fecha para inputs type="date"
  timesParsed = timesParsed.map(t => {
    return {
      ...t,
      date_init: _normalizeDateForInput(t.date_init),
      date_end: _normalizeDateForInput(t.date_end)
    };
  });

  return {
    status: data.status, //pendiente de tomar
    order_id: data.id,
    date: data.order_date,
    num_id: data.num_id,
    product_code: data.product_code,
    product_name: data.product_name,
    lot_size: data.lot_size,
    lot_num: data.lot_num,
    total_units: data.total_units,
    presentacion: data.presentacion,
    performance_teorico: data.performance_teorico,
    performance: data.performance,
    observations: data.observations,
    auditor: {
      user_entrega: data.user_entrega,
      user_autoriza: data.user_autoriza,
      user_recibe: data.user_recibe,
      user_entrega_devolucion: data.user_entrega_devolucion ?? null,
      user_recibe_devolucion: data.user_recibe_devolucion ?? null,
      devolucion_entregada: data.devolucion_entregada ?? 0,
      devolucion_recibida: data.devolucion_recibida ?? 0,
    },
    verificacion_lote: (typeof data.verificacion_lote !== 'undefined') ? Number(data.verificacion_lote) : 0,
    user_verifico: data.user_verifico ?? null,
    recepcion_retorno_json: (function() {
      if (!data.recepcion_retorno_json) return {};
      if (typeof data.recepcion_retorno_json === 'object') {
        return Array.isArray(data.recepcion_retorno_json) ? {} : data.recepcion_retorno_json;
      }
      try {
        let parsed = JSON.parse(data.recepcion_retorno_json);
        if (Array.isArray(parsed)) return {};
        if (!parsed) return {};
        return parsed;
      } catch (e) {
        console.error("Error parsing recepcion_retorno_json:", e);
        return {};
      }
    })(),

    times: timesParsed,
    operarios: data.operarios ? JSON.parse(data.operarios) : [],
    entregas: data.entregas ? JSON.parse(data.entregas) : [],
    materials: materialsArray.map(ng => {
      // Normalizar objeto si viene envuelto
      let mat = ng || {};

      return {
        material_id: mat.id || 0,
        code: mat.code || "",
        description: mat.description || "",
        process: mat.process || mat.proceso || "",
        required_amount: mat.required_amount || 0,
        unit: mat.unit || mat.unity || "",
        stock: mat.stock || 0,
        almacen: mat.almacen || "",
        tipo_prod: mat.tipo_prod || "",
        lot1: (mat.lot1 !== undefined && mat.lot1 !== null) ? mat.lot1 : null,
        entrega1: (mat.entrega1 !== undefined && mat.entrega1 !== null) ? mat.entrega1 : null,
        entrega2: (mat.entrega2 !== undefined && mat.entrega2 !== null) ? mat.entrega2 : null,
        return: (mat.return !== undefined && mat.return !== null) ? mat.return : null
      }
    })
  }
}


export function getJSONResultadoAgua() {
  return {
    resultado_ph: '',
    resultado_conductividad: '',
    resultado_cloro_libre: '',
    observaciones: ''
  };
}

/**
 * Helper reactivo para Control de Producto
 */
export function useProductControl() {
  // Estado reactivo
  const state = reactive({
    agua: {
      ph: "",
      conductividad: "",
      cloroLibre: "",
    },
    producto: {
      ph: "",
      viscosidad: "",
      densidad: "",
      apariencia: false,
      color: false,
      olor: false,
      especificaciones: {
        ph: "4.20 - 4.80",
        viscosidad: "50,000 - 250,000 mPas",
        densidad: "0.974 - 1.000 gml",
      },
    },
    firmas: {
      realizo: {
        nombre: "",
        fecha: null,
        firmado: false,
        rol: "analista",
      },
      verifico: {
        nombre: "",
        fecha: null,
        firmado: false,
        rol: "supervisor",
      },
      autorizo: {
        nombre: "",
        fecha: null,
        firmado: false,
        rol: "gerente",
      },
    },
    observaciones: "",
    aguaCargada: false,
    estado: null
  });

  /**
   * Formatea los datos de la API para el control de producto
   * @param {Object} apiData - Datos de la API
   * @returns {Object} Datos formateados
   */
  const formatFromAPI = (apiData) => {
    return {
      numero_orden: apiData.num,
      producto: {
        num: apiData.num,
        code: apiData.code_product,
        name: apiData.product,
        master_formula: apiData.master_formula,
        lot_size: apiData.lot_size
      },
      origen: 'API'
    };
  };

  /**
   * Formatea los datos de la base de datos para el control de producto
   * @param {Object} dbData - Datos de la base de datos
   * @returns {Object} Datos formateados
   */
  const formatFromDB = (dbData) => {
    // Actualiza el estado reactivo con los datos de la DB
    state.producto.ph = dbData.ph_producto || "";
    state.producto.viscosidad = dbData.viscosidad_producto || "";
    state.producto.densidad = dbData.densidad_producto || "";
    state.producto.apariencia = Boolean(dbData.apariencia_producto);
    state.producto.color = Boolean(dbData.color_producto);
    state.producto.olor = Boolean(dbData.olor_producto);
    state.producto.especificaciones = {
      ph: dbData.especificacion_ph_producto || "4.20 - 4.80",
      viscosidad: dbData.especificacion_viscosidad_producto || "50,000 - 250,000 mPas",
      densidad: dbData.especificacion_densidad_producto || "0.974 - 1.000 gml",
    };

    state.observaciones = dbData.observaciones_producto || "";

    // Firmas
    if (dbData.usuario_crea) {
      state.firmas.realizo = {
        nombre: dbData.usuario_crea,
        fecha: dbData.created_at,
        firmado: true,
        rol: dbData.rol_crea || "analista",
      };
    }
    if (dbData.usuario_verifica) {
      state.firmas.verifico = {
        nombre: dbData.usuario_verifica,
        fecha: dbData.updated_at,
        firmado: true,
        rol: dbData.rol_verifica || "supervisor",
      };
    }
    if (dbData.usuario_autoriza) {
      state.firmas.autorizo = {
        nombre: dbData.usuario_autoriza,
        fecha: dbData.updated_at,
        firmado: true,
        rol: dbData.rol_autoriza || "gerente",
      };
    }

    return {
      numero_orden: dbData.numero_orden,
      producto: {
        num: dbData.numero_orden,
        ph: dbData.ph_producto,
        viscosidad: dbData.viscosidad_producto,
        densidad: dbData.densidad_producto,
        apariencia: dbData.apariencia_producto,
        color: dbData.color_producto,
        olor: dbData.olor_producto,
        especificaciones: {
          ph: dbData.especificacion_ph_producto,
          viscosidad: dbData.especificacion_viscosidad_producto,
          densidad: dbData.especificacion_densidad_producto,
        }
      },
      origen: 'BD'
    };
  };

  /**
   * Prepara los datos para guardar
   * @returns {Object} Datos listos para enviar al servidor
   */
  const prepareSaveData = () => {
    return {
      numero_orden: state.numero_orden,
      ph_agua: state.agua.ph,
      conductividad_agua: state.agua.conductividad,
      cloro_libre_agua: state.agua.cloroLibre,
      ph_producto: state.producto.ph,
      especificacion_ph_producto: state.producto.especificaciones.ph,
      viscosidad_producto: state.producto.viscosidad,
      especificacion_viscosidad_producto: state.producto.especificaciones.viscosidad,
      densidad_producto: state.producto.densidad,
      especificacion_densidad_producto: state.producto.especificaciones.densidad,
      apariencia_producto: state.producto.apariencia,
      color_producto: state.producto.color,
      olor_producto: state.producto.olor,
      observaciones_producto: state.observaciones,
      usuario_crea: state.firmas.realizo.firmado ? state.firmas.realizo.nombre : null,
      rol_crea: state.firmas.realizo.firmado ? state.firmas.realizo.rol : null,
      usuario_verifica: state.firmas.verifico.firmado ? state.firmas.verifico.nombre : null,
      rol_verifica: state.firmas.verifico.firmado ? state.firmas.verifico.rol : null,
      usuario_autoriza: state.firmas.autorizo.firmado ? state.firmas.autorizo.nombre : null,
      rol_autoriza: state.firmas.autorizo.firmado ? state.firmas.autorizo.rol : null,
    };
  };

  /**
   * Limpia los campos editables
   */
  const resetEditableFields = () => {
    state.producto.ph = "";
    state.producto.viscosidad = "";
    state.producto.densidad = "";
    state.producto.apariencia = false;
    state.producto.color = false;
    state.producto.olor = false;
    state.observaciones = "";
  };

  /**
   * Carga datos iniciales del análisis de agua
   * @param {Object} aguaData - Datos del análisis de agua
   */
  const loadWaterData = (aguaData) => {
    state.agua = {
      ph: aguaData.resultado_ph || "",
      conductividad: aguaData.resultado_conductividad || "",
      cloroLibre: aguaData.resultado_cloro_libre || "",
    };
    state.aguaCargada = true;
  };

  return {
    ...toRefs(state),
    formatFromAPI,
    formatFromDB,
    prepareSaveData,
    resetEditableFields,
    loadWaterData
  };
}

/**
 * Helper para formatear fechas
 */
export const dateHelper = {
  formatDate: (date, format = 'DD/MM/YYYY') => {
    if (!date) return null;
    return moment(date).format(format);
  },

  formatDateTime: (dateTime, format = 'DD/MM/YYYY HH:mm') => {
    if (!dateTime) return null;
    return moment(dateTime).format(format);
  },

  toServerDate: (date) => {
    if (!date) return null;
    return moment(date, 'DD/MM/YYYY').format('YYYY-MM-DD');
  },

  toServerDateTime: (dateTime) => {
    if (!dateTime) return null;
    return moment(dateTime, 'DD/MM/YYYY HH:mm').format('YYYY-MM-DD HH:mm:ss');
  }
};


export function convertServerDate(date) {
  let test = /[0-9]{2}\/[0-9]{2}\/[0-9]{4}/.test(date);
  if (!test) { return null; }
  var momentObj = moment(date, 'DD/MM/YYYY');
  if (!momentObj.isValid()) { return null; }
  return momentObj.format('YYYY-MM-DD');
}

export function convertServerDate2(date) {
  //validar aqui con regex, si not match devolver null
  //validar que sea diferente de null donde se halla utilizado
  /**Moment devuelve un string indicando que la fecha fue invalida si es el caso
   * toca validar ese string y devolver null para tal caso
   */
  var momentObj = moment(date, 'DD/MM/YYYY');
  if (!momentObj.isValid()) { return null; }
  return momentObj;
}

export function convertServerDateTime(date_time) {
  let test = /[0-9]{2}\/[0-9]{2}\/[0-9]{4} [0-9]{2}:[0-9]{2}:[0-9]{2}/.test(date_time);
  if (!test) { return null; }
  var momentObj = moment(date_time, 'DD/MM/YYYY HH:mm:ss');
  if (!momentObj.isValid()) { return null; }
  return momentObj.format('YYYY-MM-DD HH:mm:ss');
}

/**
 *
 * @param {string} target_date in format YYYY/MM/DD
 * @param {string} start_date in format YYYY/MM/DD
 * @param {string} end_date in format YYYY/MM/DD
 * @returns {boolean}
 */
export function dateRange(target_date, start_date, end_date) {
  if (target_date == null || start_date == null || end_date == null) { return false; }
  let startDate = moment(start_date, "YYYY/MM/DD");
  let endDate = moment(end_date, "YYYY/MM/DD");
  return moment(target_date, "YYYY/MM/DD").isBetween(startDate, endDate);
}

// export function validateDateNow(target_date) {
//     if (target_date == null) { return false; }
//     let hoy = moment();
//     hoy= moment(hoy, "DD/MM/YYYY");
//     return hoy.diff(target_date, 'days') <= 0;
// }
export function validateDateNow(target_date) {
  return target_date != null;
}


/**
 * @param {string} target_date in format YYYY/MM/DD
 * @returns {null | string} null invalid date, string date valid
 */
export function validateDate(target_date) {
  return moment(target_date, "YYYY/MM/DD").isValid() ? target_date : null;
}

export function validateDate2(target_date) {
  if (!target_date) return null;

  // Si el valor contiene "-" se asume que es del tipo "YYYY-MM-DD" y se convierte
  if (target_date.indexOf('-') !== -1) {
    target_date = moment(target_date, "YYYY-MM-DD").format("DD/MM/YYYY");
  }

  // Se valida el formato DD/MM/YYYY de forma estricta
  return moment(target_date, "DD/MM/YYYY", true).isValid() ? target_date : null;
}
