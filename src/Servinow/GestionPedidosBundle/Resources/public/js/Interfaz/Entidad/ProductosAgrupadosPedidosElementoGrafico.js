(function(ep, template){
    var template = template.PRODUCTOSAGRUPADOSPEDIDOS;
    ep.Interfaz.Entidad.ProductosAgrupadosPedidosElementoGrafico = function() {
	this.element = null;
	this.pedidosEG = {};
	this.create = function(){
	    var data = {};
	    this.element = $(new EJS({
		url: template
	    }).render(data));
	    return this;
	}
	this.addPedido = function(pedidoElementoGrafico){
	    this.pedidosEG['pedido'+pedidoElementoGrafico.pedido.id] = pedidoElementoGrafico;
	    this.element.append(pedidoElementoGrafico.element);
	}
	this.hasPedido = function(pedido){
	    return (typeof(this.pedidosEG['pedido'+pedido.id]) == 'undefined')? false: true;
	}
	this.getPedido = function(pedido){
	    return this.pedidosEG['pedido'+pedido.id];
	}
	this.removePedido = function(pedido){
	    var pedidoElementoGrafico = this.getPedido(pedido);
	    pedidoElementoGrafico.hide();
	}
    }
})(ep, template);
