(function(ep, template){
    var template = template.PEDIDO;
    ep.Interfaz.Entidad.PedidoElementoGrafico = function() {
	this.element = null;
	this.pedido = null;
	this.lineaPedidoEG = {};
	this.create = function(estado, pedido, finalState){
	    this.lineasPedidoCont = 0;
	    this.lineasPedidoNextStates = 0;
	    this.lineasPedidoTotal = pedido.lineasPedido.length;
			
	    this.pedido = pedido;
	    this.estado = estado;
	    this.finalState = finalState;
			
	    var data = {
		pedido: pedido,
		finalState: finalState
	    };
	    this.element = $(new EJS({
		url: template
	    }).render(data));
	    this.pedido = pedido;
			
	    this.listaProductosElement = this.element.find('.listaProductos');
	    this.element.data("obj", pedido);
	    this.progressBarElement = this.element.find('.progressbar');
	    this.progressElement = this.element.find('.progressbar .progress');
	    this.percentElement = this.element.find('.progressbar .progress .percent');
			
	    this.initProgressBar();
				
	    return this;
	}
	this.addLineaPedido = function(productoElementGraphic){
	    this.lineaPedidoEG['lineaPedido'+productoElementGraphic.lineaPedido.id] = productoElementGraphic;
	    this.listaProductosElement.append(productoElementGraphic.element);
			
	    this.lineasPedidoCont++;
			
	    this.updateProgressBar();
	}
	this.remove = function(){
	    this.element.remove();
	    delete this;
	}
	this.initProgressBar = function(){
	    for(var i = 0; i < this.lineasPedidoTotal; ++i){
		var lineaPedido = this.pedido.lineasPedido[i];
				
		if(lineaPedido.estado.tipo > this.estado.tipo){
		    this.lineasPedidoNextStates++;					
		}
	    }
	    this.updateProgressBar();
	}
	this.updateProgressBar = function(){
	    var percent = (!this.finalState)
	    ? this.lineasPedidoNextStates/this.lineasPedidoTotal
	    : this.lineasPedidoCont/this.lineasPedidoTotal;
	    var percentText = (percent*100).toFixed(2);
	    this.progressElement.css("width", percentText+"%");
	    this.percentElement.text(percentText+" %");
	    
	}
	this.getLineaPedido = function(lineaPedido){
	    return this.lineaPedidoEG['lineaPedido'+lineaPedido.id];
			
	}
	this.removeLineaPedido = function(productoElementGraphic){
	    this.lineasPedidoNextStates++;
	    this.getLineaPedido(productoElementGraphic.lineaPedido).element.detach();
	    delete this.lineaPedidoEG['lineaPedido'+productoElementGraphic.lineaPedido.id];
			
	    this.updateProgressBar();
	}
	this.hasLineaPedido = function(lineaPedido){
	    return (typeof( this.lineaPedidoEG['lineaPedido'+lineaPedido.id]) == 'undefined')? false: true;
			
	}
	this.hide = function(){
	    this.element.css('display', 'none');
	}
	this.show = function(){
	    this.element.css('display', 'block');
	}
    }
})(ep, template);
