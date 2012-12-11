(function(ep){
	var lineaPedidos = {};
	ep.Manejador.LineaPedidoManager = function(){
		this.add = function(id, producto, cantidad, estado){
			if(lineaPedidos["id"+id] != null) return lineaPedidos["id"+id];
			
			var lineaPedido = new ep.Entidad.LineaPedido(producto, cantidad, estado);
			lineaPedido.id = id;

			lineaPedidos["id"+id] = lineaPedido;
			
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
					estado: estado
				},
				dataType: "json",
				success: onSuccess
			});
		}
	}
})(ep);
