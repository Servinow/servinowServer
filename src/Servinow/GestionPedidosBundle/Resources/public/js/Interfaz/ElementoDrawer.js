(function(ep){
	var elements = {};
	ep.Interfaz.ElementoDrawer = function(){
		this.checkPedidoIsDrawed = function(estado, pedido){
			var pedidoElementGraphic = elements['estado'+estado.tipo+'pedido'+pedido.id];
			return (typeof(pedidoElementGraphic) != 'undefined');
		}
		this.createPanelCocinero = function(panel){
			var panelElementGraphic = elements['panel'+panel.tipo];
			if(typeof(panelElementGraphic) == 'undefined'){
				panelElementGraphic = new ep.Interfaz.Entidad.PanelElementoGrafico();
				panelElementGraphic.create(panel);
				
				elements['panel'+panel.tipo] = panelElementGraphic;
			}
			
			return panelElementGraphic;
		}
		this.createEstado = function(estado, finalState){
			var estadoElementGraphic = elements['estado'+estado.tipo];
			if(typeof(estadoElementGraphic) == 'undefined'){
				estadoElementGraphic = new ep.Interfaz.Entidad.EstadoElementoGrafico();
				estadoElementGraphic.create(estado, finalState);
				
				elements['estado'+estado.tipo] = estadoElementGraphic;
			}
			
			return estadoElementGraphic;
		}
		this.createPedidoEnEstado = function(estado, pedido, finalState){
			var pedidoElementGraphic = elements['estado'+estado.tipo+'pedido'+pedido.id];
			if(typeof(pedidoElementGraphic) == 'undefined'){
				pedidoElementGraphic = new ep.Interfaz.Entidad.PedidoElementoGrafico();
				pedidoElementGraphic.create(estado, pedido, finalState);
				
				elements['estado'+estado.tipo+'pedido'+pedido.id] = pedidoElementGraphic;
			}
			return pedidoElementGraphic;		
		}
		this.createLineaPedido = function(panel ,lineaPedido, finalState){
			var productoElementGraphic = elements['lineapedido'+lineaPedido.id];
			if(typeof(productoElementGraphic) == 'undefined'){				
				productoElementGraphic = new ep.Interfaz.Entidad.ProductoElementoGrafico();
				productoElementGraphic.create(lineaPedido, finalState);
				
				elements['lineapedido'+lineaPedido.id] = productoElementGraphic;
			}
			return productoElementGraphic;
		}
		this.drawPanelCocinero = function(elementParent, panel){
			var panelElementGraphic = this.createPanelCocinero(panel);
			
			for(var i = 0; i < panel.estados.length; ++i){
				this.drawEstado(panel, panel.estados[i], panel.estados[i].finalState);
			}
			
			panelElementGraphic.addTo(elementParent);
		}
		this.drawPanelCamarero = function(panel){
			elements["panel"+panel.tipo].estados = {};
			elements["panel"+panel.tipo].pedidos = {};
			elements["panel"+panel.tipo].productos = {};
		}
		this.drawEstado = function(panel, estado, finalState){
			var panelElementGraphic = this.createPanelCocinero(panel);
			var estadoElementGraphic = this.createEstado(estado, finalState);
			
			panelElementGraphic.addEstado(estadoElementGraphic);
			
			this.drawVistaProductosAgrupadosPedidos(panel, estado);
		}
		this.drawVistaProductosAgrupadosPedidos = function (panel, estado){
			var panelElementGraphic = this.createPanelCocinero(panel);
			var estadoElementGraphic = this.createEstado(estado);
			
			var vistaPedidosElementGraphic = new ep.Interfaz.Entidad.ProductosAgrupadosPedidosElementoGrafico();
			vistaPedidosElementGraphic.create();
			
			estadoElementGraphic.addVistaProductosAgrupadosPedidos(vistaPedidosElementGraphic);
		}
		this.drawPedidos = function(panel, pedidos){
			for(var i = 0; i < pedidos.length; ++i){
				if(!this.checkPedidoIsDrawed(pedido[i])) this.drawPedido(panel, pedido[i]);
			}
		}
		this.drawPedido = function(panel, pedido){
			for(var j = 0; j < pedido.lineasPedido.length; ++j){
				var panelElementGraphic = this.createPanelCocinero(panel);
				var lineaPedido = pedido.lineasPedido[j];
				var estado = lineaPedido.estado;
				if(panelElementGraphic.hasEstado(estado)){
					this.drawPedidoEnEstado(panel, pedido, estado);
					this.drawLineaPedido(panel, pedido, lineaPedido);
				}
			}
		}
		this.drawPedidoEnEstado = function(panel, pedido, estado){
			var panelElementGraphic = this.createPanelCocinero(panel);
			var estadoElementGraphic = panelElementGraphic.getEstado(estado);
			
			var pedidoElementGraphic = this.createPedidoEnEstado(estado, pedido, estadoElementGraphic.finalState);

			estadoElementGraphic.addPedido(pedidoElementGraphic);      
		}
		this.drawLineaPedido = function(panel, pedido, lineaPedido){
			var panelElementGraphic = this.createPanelCocinero(panel);
			var estadoElementGraphic = panelElementGraphic.getEstado(lineaPedido.estado);         
			var pedidoElementGraphic = estadoElementGraphic.getPedido(pedido);
			
			var productoElementGraphic = this.createLineaPedido(panel, lineaPedido, pedidoElementGraphic.finalState);
			
			if(!pedidoElementGraphic.hasLineaPedido(lineaPedido)){
				estadoElementGraphic.addLineaPedido(pedidoElementGraphic, productoElementGraphic);
			}
		}
		this.redrawLineaPedido = function(panel, pedido, lineaPedido){
			delete elements['lineapedido'+lineaPedido.id];
			this.drawLineaPedido(panel, pedido, lineaPedido);
		}
		this.drawUpdatedEstadoLineaPedido = function(panel, pedido, lineaPedido, estado){
			var panelElementGraphic = this.createPanelCocinero(panel);
			var estadoAnteriorElementGraphic = panelElementGraphic.getEstado(estado);
			var pedidoAnteriorElementGraphic = estadoAnteriorElementGraphic.getPedido(pedido);
			var productoElementGraphic = pedidoAnteriorElementGraphic.getLineaPedido(lineaPedido);
			productoElementGraphic.disableNextStateButtonLineaPedido();
			
			estadoAnteriorElementGraphic.removeLineaPedido(pedidoAnteriorElementGraphic, productoElementGraphic);
            
			var estadoSiguiente = lineaPedido.estado;
			if(panelElementGraphic.hasEstado(estadoSiguiente)){
				var estadoNuevoElementGraphic = panelElementGraphic.getEstado(estadoSiguiente);
				this.drawPedidoEnEstado(panel, pedido, estadoSiguiente);
				if(estadoNuevoElementGraphic.finalState){
					this.redrawLineaPedido(panel, pedido, lineaPedido);
				} else {
					var pedidoNuevoEstadoElementGraphic = estadoNuevoElementGraphic.getPedido(pedido);
				
					estadoNuevoElementGraphic.addLineaPedido(pedidoNuevoEstadoElementGraphic, productoElementGraphic);
				
					productoElementGraphic.enableNextStateButtonLineaPedido();
				}
			}
		}
		this.disableNextStateButtonLineaPedido = function(panel, pedido, lineaPedido){
			var panelElementGraphic = this.createPanelCocinero(panel);
			var estadoElementGraphic = panelElementGraphic.getEstado(lineaPedido.estado);         
			var pedidoElementGraphic = estadoElementGraphic.getPedido(pedido);
			var productoElementGraphic = pedidoElementGraphic.getLineaPedido(lineaPedido);
			
			productoElementGraphic.disableNextStateButtonLineaPedido();
		}
	}
})(ep);
