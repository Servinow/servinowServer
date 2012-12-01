<?php

namespace Servinow\NavigationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NavigationController extends Controller {

	public function indexAction($restaurantID) {
		//TODO
		return $this->render('ServinowNavigationBundle:Navigation:index.html.twig', array(
			'restaurantID' => $restaurantID
		));
	}

	public function userAccountBlockAction($restaurantID) {
		//TODO
		return $this->render('ServinowNavigationBundle:Navigation:userAccountBlock.html.twig',
				array(
					'userName' => 'Paquito',
					'job' => 'Camarero'));
	}

}
