(function(ep){
    ep.Entidad.Estado.COLA = {
	tipo: ep.Constant.ESTADO_COLA,
	nombre: "Cola"
    };
    ep.Entidad.Estado.COCINA = {
	tipo: ep.Constant.ESTADO_COCINA,
	nombre: "Cocinandose"
    };
    ep.Entidad.Estado.PREPARADO = {
	tipo: ep.Constant.ESTADO_PREPARADO,
	nombre: "Preparado"
    };
    ep.Entidad.Estado.TRANSITO = {
	tipo: ep.Constant.ESTADO_TRANSITO,
	nombre: "Transito"
    };
    ep.Entidad.Estado.SERVIDO = {
	tipo: ep.Constant.ESTADO_SERVIDO,
	nombre: "Servido"
    };
})(ep);
