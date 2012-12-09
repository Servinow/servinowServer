<?php

namespace Servinow\RestaurantDrawerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Servinow\EntitiesBundle\Entity\Mesa;
use Servinow\RestaurantDrawerBundle\Entity\Drawer;
use Servinow\RestaurantDrawerBundle\Entity\FloorObject;
use Servinow\RestaurantDrawerBundle\Entity\SimpleObject;
use Servinow\RestaurantDrawerBundle\Entity\TableObject;

class DrawerController extends Controller {

	public function indexAction($restaurantID) {
		$em = $this->getDoctrine()->getEntityManager();
		$drawer = $em->getRepository('ServinowRestaurantDrawerBundle:Drawer')->findOneBy(array(
			'_restaurant'	=>	$restaurantID
		));
		
		$drawerKnowledge = array(
			'objects' => array(),
			'tables' => array(),
			'floor'	=> array()
		);
		
		if ( $drawer ) {
			$sobjects = $drawer->getSimpleObjects();
			foreach($sobjects as $sobject){
				$drawerKnowledge['objects'][] = array(
					'id' => $sobject->getId(),
					'x' => $sobject->getX(),
					'y' => $sobject->getY(),
					'wide' => $sobject->getWide(),
					'tall' => $sobject->getTall(),
					'name' => $sobject->getName()
				);
			}
			
			$tables = $drawer->getTableObjects();
			foreach($tables as $table){
				$tableref = $table->getTable();
				$drawerKnowledge['tables'][] = array(
					'id' => $tableref->getId(),
					'x' => $table->getX(),
					'y' => $table->getY(),
					'wide' => $table->getWide(),
					'tall' => $table->getTall(),
					'min' => $tableref->getMin(),
					'max' => $tableref->getMax()
				);
			}
			
			$floors = $drawer->getFloors();
			foreach($floors as $floor){
				$drawerKnowledge['floor'][$floor->getP()] = $floor->getUsed();
			}
		}
		
		/*$drawerKnowledge = array(
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
		);*/
		
		return $this->render('ServinowRestaurantDrawerBundle:Drawer:index.html.twig'
						, array('restaurantID' => $restaurantID,
								'drawerKnowledge' => json_encode($drawerKnowledge)
							));
	}

}
