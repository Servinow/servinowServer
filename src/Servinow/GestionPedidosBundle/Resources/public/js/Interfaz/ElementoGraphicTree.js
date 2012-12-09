(function(ep){
    var elements = {};
    ep.Interfaz.ElementoGraphicTree = function(){
        this.newPanel = function(panel){
            if(elements["panel"+panel.tipo] == null){
                elements["panel"+panel.tipo] = {};
                elements["panel"+panel.tipo].estados = {};
            }
        }
        this.newPanelElement = function(panelElementGraphic, panel){
            this.newPanel(panel);
            elements["panel"+panel.tipo].element = panelElementGraphic;
        }
        this.getPanelElement = function(panel){
            return elements["panel"+panel.tipo];
            
        }
        this.deletePanelElement = function(panel){
            elements["panel"+panel.tipo] = null;            
        }
        this.newEstado = function(panel, estado){
            this.newPanel(panel);
            if(elements["panel"+panel.tipo].estados["estado"+estado.tipo] == null){
                elements["panel"+panel.tipo].estados["estado"+estado.tipo] = {};
                elements["panel"+panel.tipo].estados["estado"+estado.tipo].vistaPedidos = {};
                elements["panel"+panel.tipo].estados["estado"+estado.tipo].vistaPedidos.pedidos = {};
            }
        }
        this.newEstadoElement = function(estadoElementGraphic, panel, estado){
            this.newEstado(panel, estado);
            elements["panel"+panel.tipo].estados["estado"+estado.tipo].element = estadoElementGraphic;
        }
        this.getEstadoElement = function(panel, estado){ 
            return elements["panel"+panel.tipo].estados["estado"+estado.tipo];
            
        }
		this.existEstadoElement = function(panel, estado){
			var estadoElement = this.getEstadoElement(panel, estado);
            return (typeof(estadoElement) != 'undefined');
        }
        this.deleteEstadoElement = function(panel, estado){
            elements["panel"+panel.tipo].estados["estado"+estado.tipo] = null;
        }
        this.newVistaPedidosElement = function(vistaPedidosElementGraphic, panel, estado){
            this.newEstado(panel, estado);
            elements["panel"+panel.tipo].estados["estado"+estado.tipo].vistaPedidos.element = vistaPedidosElementGraphic;
        }
        this.getVistaPedidosElement = function(panel, estado){ 
            return elements["panel"+panel.tipo].estados["estado"+estado.tipo].vistaPedidos;
        }
        this.newPedido = function(panel, estado, pedido){
            this.newEstado(panel, estado);
            if(elements["panel"+panel.tipo].estados["estado"+estado.tipo].vistaPedidos.pedidos["pedido"+pedido.id] == null){
                elements["panel"+panel.tipo].estados["estado"+estado.tipo].vistaPedidos.pedidos["pedido"+pedido.id] = {};
                elements["panel"+panel.tipo].estados["estado"+estado.tipo].vistaPedidos.pedidos["pedido"+pedido.id].productos = {};
            }
        }
        this.newPedidoElement = function(pedidoElementGraphic, panel, estado, pedido){
            this.newPedido(panel, estado, pedido);
            elements["panel"+panel.tipo].estados["estado"+estado.tipo].vistaPedidos.pedidos["pedido"+pedido.id].element = pedidoElementGraphic;
        }
        this.getPedidoElement = function(panel, estado, pedido){
            return elements["panel"+panel.tipo].estados["estado"+estado.tipo].vistaPedidos.pedidos["pedido"+pedido.id];
        }
        this.deletePedidoElement = function(panel, estado, pedido){ 
            elements["panel"+panel.tipo].estados["estado"+estado.tipo].vistaPedidos.pedidos["pedido"+pedido.id] = null;
        }
        this.newLineaPedido = function(panel, estado, pedido, lineaPedido){
            this.newPedido(panel, estado, pedido);
            if(elements["panel"+panel.tipo].estados["estado"+estado.tipo].vistaPedidos.pedidos["pedido"+pedido.id].productos["producto"+lineaPedido.producto.id] == null){
                elements["panel"+panel.tipo].estados["estado"+estado.tipo].vistaPedidos.pedidos["pedido"+pedido.id].productos["producto"+lineaPedido.producto.id] = {};
            }
        }
        this.newLineaPedidoElement = function(lineaPedidoElementGraphic, panel, estado, pedido, lineaPedido){
            this.newLineaPedido(panel, estado, pedido, lineaPedido);
            elements["panel"+panel.tipo].estados["estado"+estado.tipo].vistaPedidos.pedidos["pedido"+pedido.id].productos["producto"+lineaPedido.producto.id].element = lineaPedidoElementGraphic;
        }
        this.getLineaPedidoElement = function(panel, estado, pedido, lineaPedido){
            return elements["panel"+panel.tipo].estados["estado"+estado.tipo].vistaPedidos.pedidos["pedido"+pedido.id].productos["producto"+lineaPedido.producto.id];
        }
        this.deleteLineaPedidoElement = function(panel, estado, pedido, lineaPedido){ 
            elements["panel"+panel.tipo].estados["estado"+estado.tipo].vistaPedidos.pedidos["pedido"+pedido.id].productos["producto"+lineaPedido.producto.id] = null;
        }
        
    }    
})(ep);

