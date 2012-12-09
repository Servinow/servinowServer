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
    }
    
})
(ep);


