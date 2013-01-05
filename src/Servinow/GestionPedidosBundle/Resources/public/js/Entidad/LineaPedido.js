(function(ep){
    ep.Entidad.LineaPedido = function(pedidoId, producto, cantidad, estado){
	this.id = null;

        this.pedidoId = pedidoId;
	this.producto = producto;
	this.cantidad = cantidad;
		
	this.estado = estado;
    }
})(ep);
