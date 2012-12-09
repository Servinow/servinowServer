(function(ep){
	ep.Entidad.LineaPedido = function(producto, cantidad, estado){
		this.id = null;

		this.producto = producto;
		this.cantidad = cantidad;
		
		this.estado = estado;
	}
})(ep);
