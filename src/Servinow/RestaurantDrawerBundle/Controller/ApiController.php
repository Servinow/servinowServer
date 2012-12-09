<?php

namespace Servinow\RestaurantDrawerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Servinow\EntitiesBundle\Entity\Mesa;
use Servinow\RestaurantDrawerBundle\Entity\Drawer;
use Servinow\RestaurantDrawerBundle\Entity\FloorObject;
use Servinow\RestaurantDrawerBundle\Entity\SimpleObject;
use Servinow\RestaurantDrawerBundle\Entity\TableObject;

/**
 * @author bloodsucker
 */
class ApiController extends Controller {

	public function addTableAction($restaurantID) {
		$peticion = $this->getRequest();
		$min = $peticion->request->get('min');
		$max = $peticion->request->get('max');
		
		$em = $this->getDoctrine()->getEntityManager();
		
		$restaurant = $em->getRepository('ServinowEntitiesBundle:Restaurante')->find($restaurantID);
		$newTable = new Mesa();
		$newTable->setRestaurante($restaurant);
		$newTable->setUltimaActualizacion(123);
		$newTable->setMin($min);
		$newTable->setMax($max);
		$restaurant->addMesa( $newTable );
		
		$em->persist($newTable);
		$em->flush();
			
		$response = array(
			'id' => $newTable->getId(),
			'min' => $newTable->getMin(),
			'max' => $newTable->getMax()
		);

		return new Response(json_encode($response), 200, array(
					'Content-type' => 'text/json'
				));
	}
	
	public function saveDrawerAction ($restaurantID) {
		$peticion = $this->getRequest();
		$objects = $peticion->request->get('objects');
		if( !is_array($objects) )
			$objects = array();
		$tables = $peticion->request->get('tables');
		if( !is_array($tables) )
			$tables = array();
		$floors = $peticion->request->get('floor');
		if( !is_array($floors) )
			$floors = array();
		
		$em = $this->getDoctrine()->getEntityManager();
		$drawer = $em->getRepository('ServinowRestaurantDrawerBundle:Drawer')->findOneBy(array(
			'_restaurant'	=>	  $restaurantID
		));
		
		if($drawer) {
			$em->remove($drawer);
			$em->flush();
		}
		
		$restaurant = $em->getRepository('ServinowEntitiesBundle:Restaurante')->find($restaurantID);
		$newDrawer = new Drawer();
		$newDrawer->setRestaurant($restaurant);
		
		foreach($objects as $object){
			$newSObject = new SimpleObject();
			$newSObject->setRestaurant($restaurant);
			$newSObject->setDrawer($newDrawer);
			
			$newSObject->setName($object['name']);
			$newSObject->setX($object['x']);
			$newSObject->setY($object['y']);
			$newSObject->setWide($object['wide']);
			$newSObject->setTall($object['tall']);
			
			$newDrawer->addSimpleObject($newSObject);
		}
		
		$tableRepository = $em->getRepository('ServinowEntitiesBundle:Mesa');
		foreach($tables as $table){
			$tableRef =$tableRepository->find($table['id']);
			
			$newTable = new TableObject();
			$newTable->setRestaurant($restaurant);
			$newTable->setDrawer($newDrawer);
			$newTable->setTable($tableRef);
			
			$newTable->setX($table['x']);
			$newTable->setY($table['y']);
			$newTable->setWide($table['wide']);
			$newTable->setTall($table['tall']);
			
			$newDrawer->addTableObject($newTable);
		}
		
		foreach ($floors as $pos => $used) {
			$newFloor = new FloorObject();
			$newFloor->setRestaurant($restaurant);
			$newFloor->setDrawer($newDrawer);
			
			$newFloor->setP($pos);
			$newFloor->setUsed(($used == "true")? true:false);
			
			$newDrawer->addFloor($newFloor);
		}
		
		$em->persist($newDrawer);
		$em->flush();
		
		return new Response("Ok");
	}

}

?>
