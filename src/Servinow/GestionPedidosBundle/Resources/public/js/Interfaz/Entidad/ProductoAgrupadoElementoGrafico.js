(function(ep, template){
	var template = template.PRODUCTOAGRUPADO;
	ep.Interfaz.Entidad.ProductoAgrupadoElementoGrafico = function() {
		this.element = null;
		this.create = function(producto){
			var data = {
				producto: producto
			};
			this.element = $(new EJS({url: template}).render(data));
			return this;
		}
	}
})(ep, template);
