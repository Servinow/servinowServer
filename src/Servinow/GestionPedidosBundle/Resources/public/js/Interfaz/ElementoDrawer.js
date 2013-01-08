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
			var productoElementGraphic = elements['lineapedido'+lineaPedido.id + 'pedido' + lineaPedido.pedidoId];
			if(typeof(productoElementGraphic) == 'undefined'){				
				productoElementGraphic = new ep.Interfaz.Entidad.ProductoElementoGrafico();
				productoElementGraphic.create(lineaPedido, finalState);
				
				elements['lineapedido'+lineaPedido.id + 'pedido' + lineaPedido.pedidoId] = productoElementGraphic;
			}
			return productoElementGraphic;
		}
		this.createProductoAgrupado = function(panel, lineaPedido, finalState){
			var productoAgrupadoElementGraphic = elements['estado'+lineaPedido.estado.tipo+'productosAgrupados'+lineaPedido.producto.id];
			if(typeof(productoAgrupadoElementGraphic) == 'undefined'){				
				productoAgrupadoElementGraphic = new ep.Interfaz.Entidad.ProductoAgrupadoElementoGrafico();
				productoAgrupadoElementGraphic.create(lineaPedido.producto, finalState);
				
				elements['estado'+lineaPedido.estado.tipo+'productosAgrupados'+lineaPedido.producto.id] = productoAgrupadoElementGraphic;
			}
			return productoAgrupadoElementGraphic;
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
			this.drawVistaProductosAgrupados(panel, estado, finalState);
			
			estadoElementGraphic.changeVistaProductosAgrupadosPedidos();
		}
		this.drawVistaProductosAgrupados = function(panel, estado, finalState){
		    var panelElementGraphic = this.createPanelCocinero(panel);
		    var estadoElementGraphic = this.createEstado(estado);
		   
		    var vistaProductosElementGraphic = new ep.Interfaz.Entidad.ProductosAgrupadosTablaElementoGrafico();
		    vistaProductosElementGraphic.create(finalState);
		    
		    estadoElementGraphic.addVistaProductosAgrupados(vistaProductosElementGraphic);
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
            var panelElementGraphic = this.createPanelCocinero(panel);
            var estadoMin = pedido.lineasPedido[0].estado.tipo;
            var estadoMax = 0;
			for(var j = 0; j < pedido.lineasPedido.length; ++j){
				var lineaPedido = pedido.lineasPedido[j];
				var estado = lineaPedido.estado;
                
				if(panelElementGraphic.hasEstado(estado) && panel.estados[estado.tipo].tipoProductos.indexOf(lineaPedido.producto.type) != -1){
					var estadoElementGraphic = panelElementGraphic.getEstado(estado);
					if(!estadoElementGraphic.hasPedido(pedido)){
						this.drawPedidoEnEstado(panel, pedido, estado);
					}
					
					this.drawLineaPedido(panel, pedido, lineaPedido);
                                        
					if(estadoMin > estado.tipo) estadoMin = estado.tipo;
					if(estadoMax < estado.tipo) estadoMax = estado.tipo;
				}
			}
                        
                        for(var state = estadoMin+1; state < estadoMax; ++state){
                            estado = panel.estados[state];
                            if(panelElementGraphic.hasEstado(estado)){
								this.drawPedidoEnEstado(panel, pedido, estado);                                        
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
			
			this.drawLineaPedidoVistaAgrupadaProducto(panel, pedido, lineaPedido);
		}
		
		this.drawLineaPedidoVistaAgrupadaProducto = function(panel, pedido, lineaPedido){
		    var panelElementGraphic = this.createPanelCocinero(panel);
		    var estadoElementGraphic = panelElementGraphic.getEstado(lineaPedido.estado); 
		    var pedidoElementGraphic = estadoElementGraphic.getPedido(pedido);
		    
		    var productoAgrupadoElementGraphic = this.createProductoAgrupado(panel, lineaPedido, pedidoElementGraphic.finalState);
		    if(!estadoElementGraphic.hasProductoAgrupado(lineaPedido.producto)){
			estadoElementGraphic.addProductoAgrupado(productoAgrupadoElementGraphic);
		    }
		    if(!estadoElementGraphic.hasProductoAgrupadoLineaPedido(lineaPedido)){
			estadoElementGraphic.addLineaPedidoVistaAgrupada(productoAgrupadoElementGraphic, lineaPedido);
		    }
		}
		this.redrawLineaPedido = function(panel, pedido, lineaPedido){
			delete elements['lineapedido'+lineaPedido.id + 'pedido' + lineaPedido.pedidoId];
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
				var pedidoNuevoEstadoElementGraphic = estadoNuevoElementGraphic.getPedido(pedido);
				
				estadoNuevoElementGraphic.addLineaPedidoFromEstado(pedidoNuevoEstadoElementGraphic, productoElementGraphic);
				
				productoElementGraphic.enableNextStateButtonLineaPedido();
			}
			
			var productoAgrupadoElementGraphic = estadoAnteriorElementGraphic.getProductoAgrupado(lineaPedido);
			estadoAnteriorElementGraphic.removeLineaPedidoProductoAgrupado(productoAgrupadoElementGraphic, lineaPedido);
			
			this.drawLineaPedidoVistaAgrupadaProducto(panel, pedido, lineaPedido);		
			
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
