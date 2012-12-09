(function(ep, template){
	var template = template.PANEL;
	ep.Interfaz.Entidad.PanelElementoGrafico = function() {
		this.element = null;
		this.panel = null;
		this.estadosEG = {};
	
		this.create = function(panel){
			var data = {
				panel: panel
			};
			this.element = $(new EJS({url: template}).render(data));
			
			this.panel = panel;
                        
            this.element.data("obj", panel);

			return this;
		}
		this.addEstado = function(estadoElementoGrafico){
			this.estadosEG['estado'+estadoElementoGrafico.estado.tipo] = estadoElementoGrafico;
			this.element.append(estadoElementoGrafico.element);
		}
		this.addPedido = function(estadoElementoGrafico, pedidoElementoGrafico){
			estadoElementoGrafico.addPedido(pedidoElementoGrafico);
		}
		this.addTo = function(elementParent){
			elementParent.append(this.element);
		}
		this.hasEstado = function(estado){
			return (typeof(this.getEstado(estado)) == 'undefined')? false: true;
		}
		this.getEstado = function(estado) {
			return this.estadosEG['estado'+estado.tipo];			
		}
	}
})(ep, template);
