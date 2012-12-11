<?php

namespace Servinow\GestionPedidosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {

    public function indexAction($restaurantID, $tipoEmpleado) {
	switch ($tipoEmpleado) {
	    case 'camarero':
		$tipoEmpleadoInt = 1;
		break;
	    case 'cocinero':
		$tipoEmpleadoInt = 0;
		break;
	    default:
	}
	return $this->render('ServinowGestionPedidosBundle:GestionPedidos:index.html.twig', array(
		    'restaurantID' => $restaurantID,
		    'tipoEmpleado' => $tipoEmpleadoInt
		));
    }

}

?>
