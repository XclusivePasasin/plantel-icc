/*
 * Obtiene los items pendientes de orden de produccion mezcla 
 */
export function getMezclaOrder() {
    return new Promise((resolve, reject) => {
        axios.get("/mezcla/orders").then(response => {
            resolve(response);
        }).catch(e => {
            reject(e);
        })
    })
}

/**
 * 
 * @returns {Promise}
 */
export function getOrderByCode(code) {
    return new Promise((resolve, reject) => {
        axios.get(`/mix/orders/${code}`).then(response => {
            resolve(response);
        }).catch(e => {
            reject(e);
        })
    })
}

/**
 * Obtiene una orden de mezcla estrictamente desde la Base de Datos 
 * @returns {Promise}
 */
export function getOrderByCodeStrict(code) {
    return new Promise((resolve, reject) => {
        axios.get(`/mix/find/${code}`).then(response => {
            resolve(response);
        }).catch(e => {
            reject(e);
        })
    })
}


/**
 * 
 * @returns {Promise}
 */
export function getAnalisisByOrderCode(code) {
    return new Promise((resolve, reject) => {
        axios.get(`/analisisagua/orders/${code}`).then(response => {
            resolve(response);
        }).catch(e => {
            reject(e);
        })
    })
}


/**
 * 
 * @returns {Promise}
 */
export function getGranelByOrderCode(code) {
    return new Promise((resolve, reject) => {
        axios.get(`/granel/orders/${code}`).then(response => {
            resolve(response);
        }).catch(e => {
            reject(e);
        })
    })
}

/**
 * 
 * @returns {Promise}
 */
export function getEstandaresByOrderCode(code, turno) {
    return new Promise((resolve, reject) => {
        axios.get(`/estandares/orders/${code}/${turno}`).then(response => {
            resolve(response);
        }).catch(e => {
            reject(e);
        })
    })
}



/**
 * 
 * @returns {Promise}
 */
export function upsertEstandares(data) {
    return new Promise((resolve, reject) => {
        axios.post(`/estandares/orders`, data).then(response => {
            resolve(response);
        }).catch(e => {
            reject(e);
        })
    })
}



/**
 * 
 * @returns {Promise}
 */
export function getControlesByOrderCode(code, turno) {
    return new Promise((resolve, reject) => {
        axios.get(`/controles/orders/${code}/${turno}`).then(response => {
            resolve(response);
        }).catch(e => {
            reject(e);
        })
    })
}

/**
 * 
 * @returns {Promise}
 */
export function upsertControles(data) {
    return new Promise((resolve, reject) => {
        axios.post(`/controles/orders`, data).then(response => {
            resolve(response);
        }).catch(e => {
            reject(e);
        })
    })
}

/**
 * 
 * @returns {Promise}
 */
export function getInspeccionesByOrderCode(code) {
    return new Promise((resolve, reject) => {
        axios.get(`/inspecciones/orders/${code}`).then(response => {
            resolve(response);
        }).catch(e => {
            reject(e);
        })
    })
}

/**
 * 
 * @returns {Promise}
 */
export function upsertInspecciones(data) {
    return new Promise((resolve, reject) => {
        axios.post(`/inspecciones/orders`, data).then(response => {
            resolve(response);
        }).catch(e => {
            reject(e);
        })
    })
}

/**
 * 
 * @returns {Promise}
 */
export function approveInspecciones(code, action) {
    return new Promise((resolve, reject) => {
        axios.post(`/inspecciones/orders/approve/${code}/${action}`).then(response => {
            resolve(response);
        }).catch(e => {
            reject(e);
        })
    })
}

/**
 * 
 * @returns {Promise}
 */
export function upsertGranel(data) {
    return new Promise((resolve, reject) => {
        axios.post(`/granel/orders`, data).then(response => {
            resolve(response);
        }).catch(e => {
            reject(e);
        })
    })
}


/**
 * 
 * @returns {Promise}
 */
export function approvePeso(order_id) {
    return new Promise((resolve, reject) => {
        axios.post(`/peso/approve/${order_id}`).then(response => {
            resolve(response);
        }).catch(e => {
            reject(e);
        })
    })
}


/**
 * 
 * @returns {Promise}
 */
export function updateWaterMix(order_id, data) {
    return new Promise((resolve, reject) => {
        axios.post(`/mix/order/upwater/${order_id}`, data).then(response => {
            resolve(response);
        }).catch(e => {
            reject(e);
        })
    })
}


/**
 * 
 * @returns {Promise}
 */
export function authorizeMixOrder(order_id) {
    return new Promise((resolve, reject) => {
        axios.post(`/mix/order/authorize/${order_id}`).then(response => {
            resolve(response);
        }).catch(e => {
            reject(e);
        })
    })
}

/**
 * 
 * @returns {Promise}
 */
export function revisarMixOrder(data, order_id) {
    return new Promise((resolve, reject) => {
        axios.post(`/mix/order/revisar/${order_id}`, data).then(response => {
            resolve(response);
        }).catch(e => {
            reject(e);
        })
    })
}

/**
 * 
 * @returns {Promise}
 */
export function initMixOrder(order_id, data) {
    return new Promise((resolve, reject) => {
        axios.post(`/mix/order/init/${order_id}`, data).then(response => {
            resolve(response);
        }).catch(e => {
            reject(e);
        })
    })
}


/**
 * 
 * @returns {Promise}
 */
export function upsertOrder(data) {
    return new Promise((resolve, reject) => {
        axios.post(`/mix/orders`, data).then(response => {
            resolve(response);
        }).catch(e => {
            reject(e);
        })
    })
}

/**
 * Actualiza entrega3 de materiales
 */
export function updateMaterialsDelivery(data) {
    return new Promise((resolve, reject) => {
        axios.post('/mix/order/update-materials-delivery', data)
            .then(response => {
                resolve(response);
            })
            .catch(e => {
                reject(e);
            });
    });
}

/**
 * Actualiza el estado de recepción de materiales en la orden
 */
export function updateOrderMaterialsReceived(orderId) {
    return new Promise((resolve, reject) => {
        axios.post(`/mix/order/${orderId}/update-materials-received`)
            .then(response => {
                resolve(response);
            })
            .catch(e => {
                reject(e);
            });
    });
}

/**
 * 
 * @returns {Promise}
 */
export function upsertOrderPacking(data) {
    return new Promise((resolve, reject) => {
        axios.post(`/packing/orders`, data).then(response => {
            resolve(response);
        }).catch(e => {
            reject(e);
        })
    })
}


/**
 * Obtiene una orden de empaque estrictamente desde la Base de Datos 
 * @returns {Promise}
 */
export function getPackingByCodeStrict(code) {
    return new Promise((resolve, reject) => {
        axios.get(`/packing/find/${code}`).then(response => {
            resolve(response);
        }).catch(e => {
            reject(e);
        })
    })
}

/**
 * 
 * @returns {Promise}
 */
export function authorizePacking(order_id, data) {
    return new Promise((resolve, reject) => {
        axios.post(`/packing/order/authorize/${order_id}`, data).then(response => {
            resolve(response);
        }).catch(e => {
            reject(e);
        })
    })
}



/**
 * 
 * @returns {Promise}
 */
export function updateTracking(order_id, data) {
    return new Promise((resolve, reject) => {
        axios.post(`/packing/tracking/${order_id}`, data).then(response => {
            resolve(response);
        }).catch(e => {
            reject(e);
        })
    })
}

/**
 * 
 * @returns {Promise}
 */
export function finishPacking(order_id, data) {
    return new Promise((resolve, reject) => {
        axios.post(`/packing/order/finish/${order_id}`, data).then(response => {
            resolve(response);
        }).catch(e => {
            reject(e);
        })
    })
}






/**
 * 
 * @returns {Promise}
 */
export function upsertAnalisis(data) {
    return new Promise((resolve, reject) => {
        axios.post(`/analisisagua/orders`, data).then(response => {
            resolve(response);
        }).catch(e => {
            reject(e);
        })
    })
}

/**
 * 
 * @returns {Promise}
 */
export function finishOrder(order_id, data) {
    return new Promise((resolve, reject) => {
        axios.post(`/mix/order/finish/${order_id}`, data).then(response => {
            resolve(response);
        }).catch(e => {
            reject(e);
        })
    })
}

// /**
//  * 
//  * @returns {Promise}
//  */
// export function autorizeFinishedOrder(data) {
//     return new Promise((resolve, reject) => {
//         axios.post(`/mix/order/autorizaefinishedorder/${data}`).then(response => {
//             resolve(response);
//         }).catch(e => {
//             reject(e);
//         })
//     })
// }

/**
 * 
 * @returns {Promise}
 */
export function autorizeFinishedOrder(data) {
    return new Promise((resolve, reject) => {
        axios.post(`/mix/order/autorizaefinishedorder/${data.order_id}`, data)
            .then(response => {
                resolve(response);
            }).catch(e => {
                reject(e);
            })
    })
}


/*
 * Obtiene la lista de usuarios
 */
export function getUsers() {
    return new Promise((resolve, reject) => {
        axios.get("/admin/users/index").then(response => {
            resolve(response);
        }).catch(e => {
            reject(e);
        })
    })
}


/**
 * 
 */
export function createUser(data) {
    return new Promise((resolve, reject) => {
        axios.post("/admin/users/store", data).then(response => {
            resolve(response);
        }).catch(e => {
            reject(e);
        })
    })
}

/**
 * 
 */
export function getEditUser(user_id) {
    return new Promise((resolve, reject) => {
        axios.get(`/admin/users/edit/${user_id}`, user_id).then(response => {
            resolve(response);
        }).catch(e => {
            reject(e);
        })
    })
}

/**
 * 
 */
export function updateUser(user_id, data) {
    return new Promise((resolve, reject) => {
        axios.post(`/admin/users/update/${user_id}`, data).then(response => {
            resolve(response);
        }).catch(e => {
            reject(e);
        })
    })
}

/**
 * 
 */
export function changeStatusUser(user_id) {
    return new Promise((resolve, reject) => {
        axios.post(`/admin/users/status_user/${user_id}`).then(response => {
            resolve(response);
        }).catch(e => {
            reject(e);
        })
    })
}
/**
 * 
 * @returns {Promise}
 */
export function fetchOrderEmpaque(code) {
    return new Promise((resolve, reject) => {
        axios.get(`/packing/orders/${code}`).then(response => {
            resolve(response);
        }).catch(e => {
            reject(e);
        })
    })
}


/**
 * @returns {Promise}
 */
export function statusProgressMix(code) {
    return new Promise((resolve, reject) => {
        axios.get(`/mix/status/${code}`).then(response => {
            resolve(response);
        }).catch(e => {
            reject(e);
        })
    })
}

/**
 * @returns {Promise}
 */
export function statusProgressPacking(code) {
    return new Promise((resolve, reject) => {
        axios.get(`/packing/status/${code}`).then(response => {
            resolve(response);
        }).catch(e => {
            reject(e);
        })
    })
}

/**
 * Obtiene el único resultado del análisis de agua
 * @returns {Promise}
 */
export function getResultadoAgua() {
    return new Promise((resolve, reject) => {
        axios.get(`/agua/resultado`).then(response => {
            resolve(response);
        }).catch(e => {
            reject(e);
        });
    });
}

/**
 * Registra cambio de lote para un material
 * @param {Number} material_id
 * @param {Object} data
 * @returns {Promise}
 */
export function changeLot(material_id, data) {
    return new Promise((resolve, reject) => {
        axios.post(`/mix/order/change-lot/${material_id}`, data).then(response => {
            resolve(response);
        }).catch(e => {
            reject(e);
        });
    });
}

export function changeLotsBulk(payload) {
    return axios.post("/mix/order/change-lots-bulk", payload);
}

/**
 * Crea el resultado de análisis de agua (solo si no existe uno)
 * @param {Object} data
 * @returns {Promise}
 */
export function createResultadoAgua(data) {
    return new Promise((resolve, reject) => {
        axios.post(`/agua/resultado`, data).then(response => {
            resolve(response);
        }).catch(e => {
            reject(e);
        });
    });
}

/**
 * Actualiza el único resultado de análisis de agua
 * @param {Number} id
 * @param {Object} data
 * @returns {Promise}
 */
export function updateResultadoAgua(id, data) {
    return new Promise((resolve, reject) => {
        axios.post(`/agua/resultado/${id}`, data).then(response => {
            resolve(response);
        }).catch(e => {
            reject(e);
        });
    });
}

// Control producto funciones
/**
 * Obtiene el análisis de agua
 * @returns {Promise}
 */
export function getAnalisisAgua() {
    return axios.get('/agua/resultado')
        .then(response => response.data)
        .catch(error => {
            console.error("Error obteniendo análisis de agua:", error);
            throw error;
        });
}


/**
 * Verifica si existe un control de producto
 * @param {String} numero_orden 
 * @returns {Promise}
 */
export function getControlProductoByOrder(numero_orden) {
    return axios.get(`/controlproducto/orders/${numero_orden}`)
        .then(response => response.data)
        .catch(error => {
            console.error("Error verificando control producto:", error);
            throw error;
        });
}

/**
 * Crea un nuevo control de producto
 * @param {Object} data 
 * @returns {Promise}
 */
export function createControlProducto(data) {
    return axios.post('/controlproducto/orders', data)
        .then(response => response.data);
}

/**
 * Actualiza un control de producto existente
 * @param {String} numero_orden 
 * @param {Object} data 
 * @returns {Promise}
 */
export function updateControlProducto(numero_orden, data) {
    return axios.post(`/controlproducto/orders/update/${numero_orden}`, data)
        .then(response => response.data);
}

/**
 * Verifica una orden de control de producto
 * @param {String} numero_orden 
 * @returns {Promise}
 */
export function verificarControlProducto(numero_orden) {
    return axios.post(`/controlproducto/orders/verificar/${numero_orden}`)
        .then(response => response.data)
        .catch(error => {
            console.error('Error en verificarControlProducto:', error);
            throw error;
        });
}


// /**
//  * Verifica si existe una orden de control de producto y devuelve sus datos
//  * @param {String} numero_orden
//  * @returns {Promise}
//  */
export function getControlProductoByNumeroOrden(numero_orden) {
    return new Promise((resolve, reject) => {
        axios.get(`/controlproducto/orders/${numero_orden}`)
            .then(response => resolve(response))
            .catch(error => reject(error));
    });
}

/**
 * Obtiene las órdenes de control de producto pendientes
 */
export function getOrdenesControlProductoPendientes() {
    console.log('📡 Solicitando órdenes pendientes...');
    return axios.post('/controlproducto/orders/control-producto')
        .then(response => {
            const res = response.data;
            console.log('✅ Respuesta /pendientes:', res);

            if (res && res.success && Array.isArray(res.data)) {
                return res.data;
            } else {
                console.warn('⚠️ Formato inesperado en /pendientes:', res);
                return [];
            }
        })
        .catch(error => {
            console.error('❌ Error al obtener órdenes pendientes:', error);
            return [];
        });
}




/**
    Genera un reporte de control de producto
 */
export function downloadControlProductoReport(order_code) {
    const link = document.createElement('a');
    link.href = `/report/controlproducto/${order_code}`;
    link.download = ''; // Esto sugiere al navegador que descargue el archivo
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}




/**
 * Autoriza una orden de control de producto
 * @param {String} numero_orden 
 * @returns {Promise}
 */
export const autorizarControlProducto = (data) => {
    return axios
        .post(`/control-producto/autorizar/${data.numero_orden}`, data)
        .then(response => response.data)
        .catch(error => {
            console.error('Error en autorizarControlProducto:', error);
            throw error;
        });
};


/**
 * Envía el código de orden por POST para buscar la validación de tanque
 * @param {String} numero_orden
 * @returns {Promise}
 */
export function getValidacionTanque(numero_orden) {
    return axios.post('/validacion-tanque/buscar', { query: numero_orden });
}


/**
 * Guarda (crea o actualiza) los datos de validación de tanque
 * @param {Object} data
 * @returns {Promise}
 */
// export function saveValidacionTanque(data) {
//     return new Promise((resolve, reject) => {
//         axios.post('/tanque/guardar', data)
//             .then(response => resolve(response))
//             .catch(error => reject(error));
//     });
// }


export async function buscarOrdenValidacionTanque(query) {
    try {
        // ✅ Envía el valor tal cual
        const response = await axios.post('/validacion-tanque/buscar', {
            query: query
        });

        return response;
    } catch (error) {
        console.error('Error en buscarOrdenValidacionTanque:', error);
        throw error;
    }
}

export async function getOrdenesValidacionTanquePendientes() {
    const res = await axios.get('/tanque/pendientes');
    return res.data; // 👈 debe ser array tipo [{ id, numero_orden, ... }]
}


/**
 * Verifica la validación de tanque (estado 2)
 */
// export function verificarValidacionTanque(numero_orden) {
//     return axios.post(`/tanque/verificar/${numero_orden}`);
// }

/**
 * Autoriza la validación de tanque (estado 3)
 */
// export function autorizarValidacionTanque(numero_orden) {
//     return axios.post(`/tanque/autorizar/${numero_orden}`);
// }


// export function saveValidacionTanque(data) {
//   return axios.post('/tanque/guardar', data);
// }

export async function saveValidacionTanque(data) {
    const response = await axios.post('/tanque/guardar', data);
    return response.data; // ✅ Devuelve directamente la data del backend
}

export async function verificarValidacionTanque(numero_orden) {
    const response = await axios.post(`/tanque/verificar/${numero_orden}`);
    return response.data; // ✅ solo devuelve el objeto útil
}


export async function autorizarValidacionTanque(numero_orden) {
    const response = await axios.post(`/tanque/autorizar/${numero_orden}`);
    return response.data;
}

export async function verificarReconexionTanque(numero_orden) {
    const response = await axios.post(`/tanque/verificar-reconexion/${numero_orden}`);
    return response.data;
}

export async function autorizarReconexionTanque(numero_orden) {
    const response = await axios.post(`/tanque/autorizar-reconexion/${numero_orden}`);
    return response.data;
}

export async function obtenerLotePorOrden(numero_orden) {
    const response = await axios.get(`/tanque/lote/${numero_orden}`);
    return response.data; // ✅ Retorna { message, lote }
}

/**
 * Busca la orden de mezcla en la tabla granel
 * Transforma el número de orden de empaque (ej: 12892-10) a orden de mezcla (ej: 12892-20)
 * @param {String} numero_orden - Número de orden de empaque
 * @returns {Promise} - Retorna { existe, lote, tanque, orden_mezcla }
 */
export async function buscarOrdenMezcla(numero_orden) {
    try {
        const response = await axios.post('/validacion-tanque/buscar-mezcla', {
            query: numero_orden
        });
        return response.data;
    } catch (error) {
        console.error('Error en buscarOrdenMezcla:', error);
        throw error;
    }
}


/*
 * Obtiene especificaciones de una orden por código
 */
export function getOrderSpecs(orderCode) {
    return new Promise((resolve, reject) => {
        axios.get(`/granel/orders/informacion/${orderCode}`)
            .then(response => {
                resolve(response.data);
            })
            .catch(e => {
                reject(e);
            });
    });
}
/**
 * Marca la verificación de lote en Packing — guarda user_verifico, verificacion_lote = 1 y lot_num
 * @param {Number} order_id
 * @param {Object} data (opcional) Ej: { lot_num: "ABC123" }
 * @returns {Promise}
 */
export function verifyPackingLot(order_id, data = {}) {
    return new Promise((resolve, reject) => {
        axios.post(`/packing/order/verify/${order_id}`, data)
            .then(response => resolve(response))
            .catch(error => reject(error));
    });
}

/**
 * Obtiene el valor UXC de una orden de empaque desde backend proxy
 * @param {String} order_code
 * @returns {Promise<Number>} uxc
 */
export async function getUXCByOrder(order_code) {
    try {
        const response = await axios.get(`/packing/order/uxc/${order_code}`);
        if (response.data && response.data.code === 1) {
            return response.data.uxc;
        } else {
            throw new Error(response.data.msg || 'Error al obtener UXC');
        }
    } catch (error) {
        console.error('❌ Error getUXCByOrder:', error);
        throw error;
    }
}


/**
 * Obtiene una orden de empaque desde searchDB (con lógica de lot_num)
 * @param {String} code
 * @returns {Promise}
 */
export async function getPackingOrderDB(code) {
    return await axios.get(`/packing/find/${code}`);
}

/**
 * Avanza a la siguiente sección de estandares (sin llenar nombres de usuario)
 * @returns {Promise}
 */
export function nextSectionEstandares(data) {
    return new Promise((resolve, reject) => {
        axios.post(`/estandares/orders/next-section`, data).then(response => {
            resolve(response);
        }).catch(e => {
            reject(e);
        })
    })
}

/**
 * Actualiza el campo user_entrega_mp con el usuario actual
 * @param {Number} orderId 
 * @returns {Promise}
 */
export function updateUserEntregaMp(orderId) {
    return new Promise((resolve, reject) => {
        axios.post(`/mix/order/update-user-entrega-mp/${orderId}`)
            .then(response => {
                resolve(response);
            })
            .catch(error => {
                reject(error);
            });
    });
}

/**
 * Firma orden de empaque (entrega o recibe)
 * @param {Number} id
 * @param {String} type 'entrega' | 'recibe'
 * @returns {Promise}
 */
export function signPackingOrder(id, type) {
    return new Promise((resolve, reject) => {
        axios.post(`/packing/order/sign/${id}`, { type: type }).then(response => {
            resolve(response);
        }).catch(e => {
            reject(e);
        })
    })
}