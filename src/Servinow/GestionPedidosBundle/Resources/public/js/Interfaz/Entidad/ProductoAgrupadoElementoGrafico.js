(function(ep, template){
    var template = template.PRODUCTOAGRUPADO;
    ep.Interfaz.Entidad.ProductoAgrupadoElementoGrafico = function() {
	this.element = null;
	this.lineasPedido = {};
	
	this.create = function(producto, finalState){
	    var data = {
		producto: producto,
		finalState: finalState
	    };
	    
	    this.producto = producto;
	    
	    this.element = $(new EJS({
		url: template
	    }).render(data));
	    
	    this.element.data("element", this);
	    this.element.data("obj", producto);
	    
	    this.cantidadElement = this.element.find('.cantidad');
	    
	    this.cantidad = 0;
	    
	    this.cambiarCantidad();
	    
	    return this;
	}
	this.cambiarCantidad = function(){
	    this.cantidadElement.text(this.cantidad);
	}
	this.addLineaPedido = function(lineaPedido){
	    this.show();
	    this.cantidad += lineaPedido.cantidad;
	    this.cambiarCantidad();
	    
	    this.lineasPedido['lineaPedido'+lineaPedido.id] = lineaPedido;
	}
	this.hasLineaPedido = function(lineaPedido){
	    for(var lp in this.lineasPedido) {
		if(this.lineasPedido[lp].id == lineaPedido.id) return true;
	    }
	    
	    return false;
	}
	this.removeLineaPedido = function(lineaPedido){
	    delete this.lineasPedido['lineaPedido'+lineaPedido.id];
	    
	    this.cantidad -= lineaPedido.cantidad;
	    this.cambiarCantidad();
	    
	    if(this.cantidad == 0) this.hide();
	    
	}
	this.show = function(){
	    this.element.css('display', 'table-row');
	}
	this.hide = function(){
	    this.element.css('display', 'none');
	}
	
    }
})(ep, template);
