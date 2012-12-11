(function(ep, template){
    var template = template.ESTADO;
    ep.Interfaz.Entidad.EstadoElementoGrafico = function() {
	this.element = null;
	this.estado = null;
	this.vistaAgrupadaPedido = null;
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
			
	    this.contentDiv = this.element.find('.contentDiv');
			
	    this.cantidadProductosElement = this.element.find('.cantidadProductos');
	    this.cantidadProduct = 0;
	    this.cambiarCantidadProductos();
	    return this;
	}
	this.addVistaProductosAgrupadosPedidos= function(vistaPedidosElementoGrafico){
	    this.vistaAgrupadaPedido = vistaPedidosElementoGrafico;
	    this.contentDiv.append(vistaPedidosElementoGrafico.element);
	}
	this.cambiarCantidadProductos = function(){
	    this.cantidadProductosElement.text("("+this.cantidadProduct+")");
	}
	this.incrLineasPedido = function(){
	    this.cantidadProduct++;
	    this.cambiarCantidadProductos();
	}
	this.decrLineasPedido = function(){
	    this.cantidadProduct--;
	    this.cambiarCantidadProductos();
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
	this.addLineaPedido = function(pedidoElementGraphic, productoElementGraphic){
	    pedidoElementGraphic.show();
	    pedidoElementGraphic.addLineaPedido(productoElementGraphic);
	    this.incrLineasPedido();
                        
	    if(this.finalState){
		if(pedidoElementGraphic.lineasPedidoCont >= pedidoElementGraphic.lineasPedidoTotal) {
		    pedidoElementGraphic.hide();
		    this.cantidadProduct -= pedidoElementGraphic.lineasPedidoCont;
		    this.cambiarCantidadProductos();
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
			estadoElementGraphic.cambiarCantidadProductos();
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
