(function(ep){
	var platos = {};
	ep.Manejador.PlatoManager = function(){
		this.add = function(id, nombre){
			if(platos["id"+id] != null) return platos["id"+id];
			
			var plato = new ep.Entidad.Plato(nombre);
			plato.id = id;

			platos["id"+id] = plato;
			
			return plato;
		}
	}
})(ep);
