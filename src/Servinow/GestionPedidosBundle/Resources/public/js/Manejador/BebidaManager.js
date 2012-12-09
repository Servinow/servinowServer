(function(ep){
	var bebidas = {};
	ep.Manejador.BebidaManager = function(){
		this.add = function(id, nombre){
			if(bebidas["id"+id] != null) return bebidas["id"+id];
			
			var bebida = new ep.Entidad.Bebida(nombre);
			bebida.id = id;

			bebidas["id"+id] = bebida;
			
			return bebida;
		}
	}
})(ep);
