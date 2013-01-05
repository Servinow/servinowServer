(function(ep, template){
    var template = template.ESTADO;
    ep.Interfaz.Entidad.EstadoElementoGrafico = function() {
	this.element = null;
	this.estado = null;
	this.vistaAgrupadaPedido = null;
	this.vistaAgrupadaProductos = null;
	this.create = function(estado, finalState){
	    var data = {
		estado: estado,
		finalState: finalState
	    };
	    this.finalState = finalState;
	    this.element = $(new EJS({
		url: template
	    }).render(data));
			
	    this.estado = estado;
	    
	    this.element.data("element", this);
			
	    this.contentDiv = this.element.find('.contentDiv');
			
	    this.cantidadProductosElement = this.element.find('.cantidadProductos');
	    this.cantidadProduct = 0;
	    this.cantidadProductAgrupados = 0;
	    this.cambiarCantidadProductos(this.cantidadProduct);
	    return this;
	}
	this.changeVistaProductosAgrupadosPedidos = function(){
	    this.vistaAgrupadaProductos.hide();
	    this.vistaAgrupadaPedido.show();
	    this.cambiarCantidadProductos();
	    this.cambiarCantidadProductos(this.cantidadProduct);
	}
	this.changeVistaProductosAgrupados = function(){
	    this.vistaAgrupadaPedido.hide();
	    this.vistaAgrupadaProductos.show();
	    this.cambiarCantidadProductos(this.cantidadProductAgrupados);
	}
	this.addVistaProductosAgrupadosPedidos= function(vistaPedidosElementoGrafico){
	    this.vistaAgrupadaPedido = vistaPedidosElementoGrafico;
	    this.contentDiv.append(vistaPedidosElementoGrafico.element);
	}
	this.addVistaProductosAgrupados= function(vistaProductosElementoGrafico){
	    this.vistaAgrupadaProductos = vistaProductosElementoGrafico;
	    this.contentDiv.append(vistaProductosElementoGrafico.element);
	}
	this.cambiarCantidadProductos = function(cantidad){
	    this.cantidadProductosElement.text("("+cantidad+")");
	}
	this.incrLineasPedido = function(){
	    this.cantidadProduct++;
	    this.cambiarCantidadProductos(this.cantidadProduct);
	}
	this.decrLineasPedido = function(){
	    this.cantidadProduct--;
	    this.cambiarCantidadProductos(this.cantidadProduct);
	}
	this.addPedido = function(pedidoElementGraphic){			
	    this.vistaAgrupadaPedido.addPedido(pedidoElementGraphic);
	}
	this.hasPedido = function(pedido){
	    return this.vistaAgrupadaPedido.hasPedido(pedido);
	}
	this.getPedido = function(pedido){
	    return this.vistaAgrupadaPedido.getPedido(pedido);
	}
	this.removePedido = function(pedido){
	    this.vistaAgrupadaPedido.removePedido(pedido);
	}
	this.removeLineaPedido = function(pedidoElementGraphic, productoElementGraphic){
	    pedidoElementGraphic.removeLineaPedido(productoElementGraphic);
	    this.decrLineasPedido();
			
	    this.putTimerToRemovePedido(pedidoElementGraphic);
	}
	this.hasProductoAgrupadoLineaPedido = function(lineaPedido){
	    return this.vistaAgrupadaProductos.hasProductoAgrupadoLineaPedido(lineaPedido);
	}
	this.hasProductoAgrupado = function(producto){
	    return this.vistaAgrupadaProductos.hasProductoAgrupado(producto);
	}
	this.addProductoAgrupado = function(productoAgrupadoElementGraphic){
	    this.cantidadProductAgrupados++;
	    this.cambiarCantidadProductos(this.cantidadProductAgrupados);
	    this.vistaAgrupadaProductos.addProductoAgrupado(productoAgrupadoElementGraphic);
	}
	this.addLineaPedidoVistaAgrupada = function(productoAgrupadoElementGraphic, lineaPedido){
	    productoAgrupadoElementGraphic.addLineaPedido(lineaPedido);
	}
	this.addLineaPedido = function(pedidoElementGraphic, productoElementGraphic){
	    pedidoElementGraphic.show();
	    pedidoElementGraphic.addLineaPedido(productoElementGraphic);
	    this.incrLineasPedido();
                        
	    if(this.finalState){
		if(pedidoElementGraphic.lineasPedidoCont >= pedidoElementGraphic.lineasPedidoTotal) {
		    pedidoElementGraphic.hide();
		    this.cantidadProduct -= pedidoElementGraphic.lineasPedidoCont;
		    this.cambiarCantidadProductos(this.cantidadProduct);
		}	
	    } else {
		if(pedidoElementGraphic.lineasPedidoNextStates >= pedidoElementGraphic.lineasPedidoTotal) {
		    pedidoElementGraphic.hide();
		}				
	    }
	}
	this.addLineaPedidoFromEstado = function(pedidoElementGraphic, productoElementGraphic){
	    pedidoElementGraphic.show();
	    if(this.finalState){
		productoElementGraphic.create(productoElementGraphic.lineaPedido, this.finalState);
	    }
                    
	    pedidoElementGraphic.addLineaPedido(productoElementGraphic);
	    this.incrLineasPedido();
                    
	    this.putTimerToRemovePedido(pedidoElementGraphic);
	}
	this.putTimerToRemovePedido = function(pedidoElementGraphic){
	    if(this.finalState){
		if(pedidoElementGraphic.lineasPedidoCont >= pedidoElementGraphic.lineasPedidoTotal) {
		    this.cantidadProduct -= pedidoElementGraphic.lineasPedidoTotal;
		    var estadoElementGraphic = this;
		    setTimeout(function(){
			estadoElementGraphic.removePedido(pedidoElementGraphic.pedido);
			estadoElementGraphic.cambiarCantidadProductos(this.cantidadProduct);
		    },ep.Constant.TIME_TO_REMOVE_FINAL_ORDER);
		}	
	    } else {
		if(pedidoElementGraphic.lineasPedidoNextStates >= pedidoElementGraphic.lineasPedidoTotal) {
		    setTimeout(function(){
			pedidoElementGraphic.remove();
		    }, ep.Constant.TIME_TO_REMOVE_NOFINAL_ORDER);
		}				
	    }
	}
    }
})(ep, template);
