(function(ep){
    ep.Manejador.EventManager = function(){
        this.addEventNextState = function(onTrigger){
            var element = $('.nextState');
	    element.live("click", onTrigger);
        }    
	this.addEventNewOrders = function(newOrders){
	    setInterval(function(){
		newOrders();
	    },10000);
	}
	this.addEventChangeVistaPedidos = function(onTrigger){
	    var element = $('.vistaPedidos');
	    element.live("click", onTrigger);
	}
	this.addEventChangeVistaProductos = function(onTrigger){
	    var element = $('.vistaProductos');
	    element.live("click", onTrigger);
	}
    }
    
})
(ep);


