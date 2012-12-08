<?php

namespace Servinow\RestaurantDrawerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DrawerController extends Controller {

	public function indexAction($restaurantID) {
		//TODO
		
		$drawerKnowledge = array(
			'objects' => array(
				array(
					'id' => 1,
					'x' => 0,
					'y' => 0,
					'wide' => 1,
					'tall' => 1,
					'name' => 'portón'
				),
				array(
					'id' => 2,
					'x' => 7,
					'y' => 4,
					'wide' => 2,
					'tall' => 1,
					'name' => 'ventana'
				),
				array(
					'id' => 3,
					'x' => 0,
					'y' => 3,
					'wide' => 1,
					'tall' => 4,
					'name' => 'barr2a'
				),
			),
			'tables' => array(
				array(
					'id' => 1,
					'x' => 0,
					'y' => 3,
					'wide' => 1,
					'tall' => 4,
					'min' => 2,
					'max' => 4
				),
				array(
					'id' => 2,
					'x' => 5,
					'y' => 7,
					'wide' => 1,
					'tall' => 2,
					'min' => 2,
					'max' => 4
				),
				array(
					'id' => 4,
					'x' => 8,
					'y' => 3,
					'wide' => 2,
					'tall' => 2,
					'min' => 6,
					'max' => 8
				)
			),
			'floor' => array(
				1 => true,
				2 => true,
				50 => true,
				51 => true,
				30 => false
			)
		);
		
		return $this->render('ServinowRestaurantDrawerBundle:Drawer:index.html.twig'
						, array('restaurantID' => $restaurantID,
								'drawerKnowledge' => json_encode($drawerKnowledge)
							));
	}

}
