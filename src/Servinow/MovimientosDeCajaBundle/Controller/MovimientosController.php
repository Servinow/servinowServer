<?php

namespace Servinow\MovimientosDeCajaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MovimientosController extends Controller
{
    public function movimientosAction($restaurantID)
    {   
        $request = Request::createFromGlobals();
        
        $fecha = "";
        if($request->query->has('fecha')){
            $fecha = $request->query->get('fecha');
        }
        else{
            // Conseguir la fecha de inicio = fecha actual - 30 días
            $fecha = date("Ymd");
        }
        if($fecha == ""){
            $fecha = date("Ymd");
        }
        
        $repository = $this->getDoctrine()
                ->getRepository('ServinowEntitiesBundle:Pedido');
        
        $pedidos = $repository->findPedidosMovimientos($fecha, $restaurantID);
        
        $balance = $repository->findBalance($fecha, $restaurantID);
        
        return $this->render('ServinowMovimientosDeCajaBundle:Movimientos:movimientos.html.twig',
                array('restaurantID'=>$restaurantID,
                    'fecha'=>$fecha,
                    'pedidos'=> $pedidos,
                    'balance' => $balance));
    }
}
