(function(ep){
	var lineaPedidos = {};
	ep.Manejador.LineaPedidoManager = function(){
		this.add = function(id, pedidoId, producto, cantidad, estado){
			if(lineaPedidos["id"+id+"pedidoId"+pedidoId] != null) return lineaPedidos["id"+id+"pedidoId"+pedidoId];
			
			var lineaPedido = new ep.Entidad.LineaPedido(pedidoId, producto, cantidad, estado);
			lineaPedido.id = id;

			lineaPedidos["id"+id+"pedidoId"+pedidoId] = lineaPedido;
			
			return lineaPedido;
		}
		this.updateEstado = function(lineaPedido, estado){
			lineaPedido.estado = estado;
		}
		this.saveUpdateEstado = function(lineaPedido, estado, onSuccess){
			$.ajax({
				url: '../API/update/estado/lineapedido',
				type: "POST",
				data: {
					id: lineaPedido.id,
                                        pedido: lineaPedido.pedidoId,
					estado: estado
				},
				dataType: "json",
				success: onSuccess
			});
		}
	}
})(ep);
