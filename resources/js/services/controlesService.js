import axios from 'axios';

export async function getAllControlesByOrderCode(code, turno) {
    try {
        const response = await axios.get(`/controles/orders/all/${code}/${turno}`);
        return response;
    } catch (error) {
        // Manejo de errores específico si es necesario
        console.error("Error al obtener controles por código de orden:", error);
        throw error;
    }
}

export async function getControlById(id) {
    try {
        const response = await axios.get(`/controles/${id}`);
        return response;
    } catch (error) {
        console.error("Error al obtener control por ID:", error);
        throw error;
    }
}

export async function getJsonModelControles(code, turno) {
    console.log("Cargando el service");
        return axios.get(`/controles/model/${code}/${turno}`);
}
