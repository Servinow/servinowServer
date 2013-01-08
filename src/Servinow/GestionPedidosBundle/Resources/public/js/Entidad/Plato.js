(function(ep){
    ep.Entidad.Plato = function(nombre){
	this.id = null;

	this.nombre = nombre;
	
	this.type = ep.Constant.PLATO;

	this.cantidad = null;
    }
})(ep);
