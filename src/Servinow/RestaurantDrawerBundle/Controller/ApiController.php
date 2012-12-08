<?php

namespace Servinow\RestaurantDrawerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author bloodsucker
 */
class ApiController extends Controller {

	public function addTableAction() {

		$response = array(
			'id' => 2,
			'x' => 5,
			'y' => 7,
			'wide' => 1,
			'tall' => 2,
			'min' => 2,
			'max' => 4
		);

		return new Response(json_encode($response), 200, array(
//					'Content-type' => 'text/json'
				));
	}

}

?>
