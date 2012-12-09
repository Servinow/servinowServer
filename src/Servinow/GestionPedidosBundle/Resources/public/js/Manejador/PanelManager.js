(function(ep){
	var paneles = [];
	ep.Manejador.PanelManager = function(){
		this.add = function(tipo, estados){
			var panel = new ep.Entidad.Panel(tipo, estados);
			
			paneles.push(panel);
			
			return panel;
		}
	}
})(ep);
