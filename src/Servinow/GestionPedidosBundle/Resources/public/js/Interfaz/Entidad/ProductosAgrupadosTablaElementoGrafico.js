(function(ep, template){
    var template = template.PRODUCTOSAGRUPADOSTABLA;
    ep.Interfaz.Entidad.ProductosAgrupadosTablaElementoGrafico = function() {
	this.element = null;
	this.create = function(){
	    var data = {};
	    this.element = $(new EJS({
		url: template
	    }).render(data));
	    return this;
	}
    }
})(ep, template);
