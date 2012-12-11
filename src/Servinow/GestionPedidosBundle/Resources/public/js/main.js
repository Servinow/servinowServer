var ep = {};

ep.Entidad = {};
ep.Entidad.Estado = {};
ep.Util = {};
ep.Interfaz = {};
ep.Interfaz.Entidad = {};
ep.Manejador = {};
ep.Constant ={};

ep.Constant.TIME_TO_REMOVE_FINAL_ORDER = 5000;
ep.Constant.TIME_TO_REMOVE_NOFINAL_ORDER = 1000;

ep.Constant.ESTADO_COLA = 0;
ep.Constant.ESTADO_COCINA = 1;
ep.Constant.ESTADO_PREPARADO = 2;
ep.Constant.ESTADO_TRANSITO = 3;
ep.Constant.ESTADO_SERVIDO = 4;

ep.Constant.COCINERO = 0;
ep.Constant.CAMARERO = 1;

ep.Constant.PLATO = 0;
ep.Constant.BEBIDA = 0;

ep.Constant.EVENT_NEXT_STATE = 0;


var template = {}
template.PANEL = "../../../../bundles/servinowgestionpedidos/Templates/PanelTemplate.html.ejs";
template.ESTADO = "../../../../bundles/servinowgestionpedidos/Templates/EstadoTemplate.html.ejs";
template.PEDIDO = "../../../../bundles/servinowgestionpedidos/Templates/PedidoTemplate.html.ejs";
template.PRODUCTO = "../../../../bundles/servinowgestionpedidos/Templates/ProductoFilaTemplate.html.ejs";
template.PRODUCTOSAGRUPADOSPEDIDOS = "../../../../bundles/servinowgestionpedidos/Templates/ProductosAgrupadosPedidosTemplate.html.ejs";

$(document).ready(function() {
    // Comprobar si el usuario es un camarero o cocinero

    var im = new ep.Interfaz.InterfazManager();
    var em = new ep.Manejador.EventManager();
    
    em.addEventNextState(function(e){
	e.stopPropagation();
	var lineaPedido = $(this).parents(".lineaPedido").data("obj");
	var pedido = $(this).parents(".pedido").data("obj");
	var panel = $(this).parents(".panel").data("obj");
	var estado = lineaPedido.estado.tipo+1;
		
	im.saveUpdateEstadoLineaPedido(panel, pedido, lineaPedido, estado, function(data){
	    im.drawUpdateEstadoLineaPedido(panel, pedido, lineaPedido, estado);
	});
    });

    var panel;
    if(ep.panelActivo == ep.Constant.COCINERO){
	panel = im.cargarPanelCocinero($('#content'));
    } else{
	panel = im.cargarPanelCamarero($('#content'));
    }
        
    im.loadPedidos(function(pedidos){
	im.drawNewPedidos(panel, pedidos);
    });
	
    em.addEventNewOrders(function(){
	im.loadPedidos(function(pedidos){
	    im.drawNewPedidos(panel, pedidos);
	});
    });
	
});
