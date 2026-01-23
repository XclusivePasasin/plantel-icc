export function getAllEstandaresByOrderCode(code, turno){
    return axios.get(`/estandares/orders/all/${code}/${turno}`);
}

export function getEstandarById(id){
    return axios.get(`/estandares/${id}`);
}

export function getJsonModelEstandares(code, turno){
    return axios.get(`/estandares/model/${code}/${turno}`);
}