<?php

namespace Servinow\GestionPedidosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class APIController extends Controller {

    public function stateStrToInt($stateString) {
	switch ($stateString) {
	    case "cola":
		return 0;
		break;
	    case "cocinandose":
		return 1;
		break;
	    case "preparado":
		return 2;
		break;
	    case "transito":
		return 3;
		break;
	    case "servido":
		return 4;
		break;
	    default:
		break;
	}
    }

    public function stateIntToStr($stateInt) {
	switch ($stateInt) {
	    case 0:
		return "cola";
		break;
	    case 1:
		return "cocinandose";
		break;
	    case 2:
		return "preparado";
		break;
	    case 3:
		return "transito";
		break;
	    case 4:
		return "servido";
		break;
	    default:
		break;
	}
    }

    public function pedidosAction($restaurantID) {

	$em = $this->getDoctrine()->getEntityManager();

	$pedidos = $em->getRepository('ServinowEntitiesBundle:Pedido')->findBy(array(
	    'restaurante' => $restaurantID
		));

	$pedidosOut = array();
	for ($i = 0; $i < count($pedidos); ++$i) {
	    $pedido = array();
	    $pedido['id'] = $pedidos[$i]->getId();

	    $lineasPedido = $pedidos[$i]->getLineasPedido();
	    $pedido['lineasPedido'] = array();
	    for ($j = 0; $j < count($lineasPedido); ++$j) {
		$lineaPedido = array();
		$lineaPedido['id'] = $lineasPedido[$j]->getId();
		$lineaPedido['cantidad'] = $lineasPedido[$j]->getCantidad();
		$lineaPedido['estado'] = $this->stateStrToInt($lineasPedido[$j]->getEstado());

		$producto = array();
		$producto['id'] = $lineasPedido[$j]->getProducto()->getId();
		$producto['nombre'] = $lineasPedido[$j]->getProducto()->getNombre();

		$lineaPedido['producto'] = $producto;

		$pedido['lineasPedido'][] = $lineaPedido;
	    }
	    $pedidosOut[] = $pedido;
	}
	return new Response(json_encode($pedidosOut), 200, array(
			//	'Content-Type' => 'text/json'
		));
    }

    public function updateEstadoLineaPedidoAction($restaurantID) {
	$em = $this->getDoctrine()->getEntityManager();

	$peticion = $this->getRequest();

	$idLineaPedido = $peticion->request->get("id");
	$estadoLineaPedido = $peticion->request->get("estado");

	$lineaPedido = $em->getRepository('ServinowEntitiesBundle:LineaPedido')->find($idLineaPedido);
	$lineaPedido->setEstado($this->stateIntToStr($estadoLineaPedido));
	$em->persist($lineaPedido);
	$em->flush();

	return new Response(json_encode($estadoLineaPedido));
    }

}

?>
