<?php

namespace Servinow\GestionPedidosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($restaurantID)
    {
        return $this->render('ServinowGestionPedidosBundle:GestionPedidos:index.html.twig', array(
			'restaurantID' => $restaurantID
		));
    }
}

?>
