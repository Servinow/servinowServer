(function(ep, template){
    var template = template.PRODUCTOSAGRUPADOSTABLA;
    ep.Interfaz.Entidad.ProductosAgrupadosTablaElementoGrafico = function() {
	this.element = null;
	this.productosAgrupadosEG = {};
	this.create = function(finalState){
	    var data = {
		finalState: finalState
	    };
	    this.element = $(new EJS({
		url: template
	    }).render(data));
	    this.hide();
	    
	    return this;
	}
	this.addProductoAgrupado = function(productoAgrupadoElementGraphic){
	    this.productosAgrupadosEG['productoAgrupado'+productoAgrupadoElementGraphic.producto.id] = productoAgrupadoElementGraphic;
	    this.element.append(productoAgrupadoElementGraphic.element);
	}
	this.hasProductoAgrupadoLineaPedido = function(lineaPedido){
	    for(var pa in this.productosAgrupadosEG) {
		if(this.productosAgrupadosEG[pa].hasLineaPedido(lineaPedido) == true) return true;
	    }
	    return false;
	}
	this.hasProductoAgrupado = function(producto){
	    for(var pa in this.productosAgrupadosEG) {
		if(this.productosAgrupadosEG[pa].producto.id == producto.id) return true;
	    }
	    return false;
	}
	this.show = function(){
	   this.element.css('display', 'table');
	}
	this.hide = function(){
	   this.element.css('display', 'none');
	}
    }
})(ep, template);
