<?php

namespace Servinow\MovimientosDeCajaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Servinow\EntitiesBundle\Entity\Pedido;
use Symfony\Component\HttpFoundation\Response;

class GeneralController extends Controller
{
    public function ingresosAction($restaurantID)
    {
        
        $request = Request::createFromGlobals();
        
        $fecha_inicio = "";
        if($request->query->has('fecha_inicio')){
            $fecha_inicio = $request->query->get('fecha_inicio');
        }
       
        $fecha_fin = "";
        if($request->query->has('fecha_fin')){
            $fecha_fin = $request->query->get('fecha_fin');
        }
        $ingresos ="";
        if($fecha_fin == "" || $fecha_inicio == ""){
            // Conseguir la fecha de inicio = fecha actual - 30 días
            $fecha_inicio = date("Ymd", strtotime("-30 day"));
            // Conseguir la fecha de fin = fecha actual
            $fecha_fin = date("Ymd");
        }
        
        $repository = $this->getDoctrine()
                ->getRepository('ServinowEntitiesBundle:Pedido');
        $pedidos = $repository->findPedidosIngresos($fecha_inicio, $fecha_fin, $restaurantID);
        
        $dia_pedidos = array();
        $j=0;
        for($i=$fecha_inicio; $i <= $fecha_fin; $i++){
            $dia_pedidos[$i-$fecha_inicio]['fecha'] = $i;
            if($j < count($pedidos) && $pedidos[$j]['fecha'] == $i && $pedidos[$j]['fecha'] != null){
                $dia_pedidos[$i-$fecha_inicio]['total'] = $pedidos[$j]['total'];
                $j++;
            }
            else{
                $dia_pedidos[$i-$fecha_inicio]['total'] = 0;
            }
        }
        
        return $this->render('ServinowMovimientosDeCajaBundle:General:ingresos.html.twig',
                array('restaurantID' =>$restaurantID,
                    'fecha_inicio'=> $fecha_inicio,
                    'fecha_fin' => $fecha_fin,
                    'dia_pedidos'=> $dia_pedidos));
    }
    
    public function pagoAction($restaurantID)
    {
        
        $request = Request::createFromGlobals();
        
        $fecha_inicio = "";
        if($request->query->has('fecha_inicio')){
            $fecha_inicio = $request->query->get('fecha_inicio');
        }
       
        $fecha_fin = "";
        if($request->query->has('fecha_fin')){
            $fecha_fin = $request->query->get('fecha_fin');
        }
        
        $repository = $this->getDoctrine()
                ->getRepository('ServinowEntitiesBundle:Pedido');
        if($fecha_fin != "" && $fecha_inicio != ""){
            $num_pedidos_paypal = $repository->findPedidosPago($fecha_inicio, $fecha_fin, "'paypal'", $restaurantID);

            $num_pedidos_efectivo = $repository->findPedidosPago($fecha_inicio, $fecha_fin, "'efectivo'", $restaurantID);
        }
        else{
            // Conseguir la fecha de inicio = fecha actual - 30 días
            $fecha_inicio = date("Ymd", strtotime("-30 day"));
            // Conseguir la fecha de fin = fecha actual
            $fecha_fin = date("Ymd");
            $num_pedidos_paypal = $repository->findPedidosPago($fecha_inicio, $fecha_fin, "'paypal'", $restaurantID);

            $num_pedidos_efectivo = $repository->findPedidosPago($fecha_inicio, $fecha_fin, "'efectivo'", $restaurantID);
        }
        
        return $this->render('ServinowMovimientosDeCajaBundle:General:pago.html.twig',
                array('restaurantID'=>$restaurantID, 
                    'pedidosPaypal'=> $num_pedidos_paypal,
                    'pedidosEfectivo'=> $num_pedidos_efectivo,
                    'fecha_inicio' => $fecha_inicio,
                    'fecha_fin'=> $fecha_fin));
    }
    
    public function pedidosAction($restaurantID)
    {
        $request = Request::createFromGlobals();
        
        $fecha_inicio = "";
        if($request->query->has('fecha_inicio')){
            $fecha_inicio = $request->query->get('fecha_inicio');
        }
       
        $fecha_fin = "";
        if($request->query->has('fecha_fin')){
            $fecha_fin = $request->query->get('fecha_fin');
        }
        $pedidos ="";
        if($fecha_fin == "" || $fecha_inicio == ""){
            // Conseguir la fecha de inicio = fecha actual - 30 días
            $fecha_inicio = date("Ymd", strtotime("-30 day"));
            // Conseguir la fecha de fin = fecha actual
            $fecha_fin = date("Ymd");
        }

        $repository = $this->getDoctrine()
                ->getRepository('ServinowEntitiesBundle:Pedido');
        $pedidos = $repository->findPedidosCantidad($fecha_inicio, $fecha_fin, $restaurantID);
        
        $dia_pedidos = array();
        $j=0;
        for($i=$fecha_inicio; $i <= $fecha_fin; $i++){
            $dia_pedidos[$i-$fecha_inicio]['fecha'] = $i;
            if($j < count($pedidos) && $pedidos[$j]['fecha'] == $i){
                $dia_pedidos[$i-$fecha_inicio]['pedidos'] = $pedidos[$j]['1'];
                $j++;
            }
            else{
                $dia_pedidos[$i-$fecha_inicio]['pedidos'] = 0;
            }
        }
        
        $total = $repository->totalPedidosCantidadIngresos($fecha_inicio, $fecha_fin, $restaurantID);
        
        $mediaIngresosPedido = $total['ingresos'] / $total['pedidos'];
        
        return $this->render('ServinowMovimientosDeCajaBundle:General:pedidos.html.twig',
                array('restaurantID' =>$restaurantID,
                    'fecha_inicio'=> $fecha_inicio,
                    'fecha_fin' => $fecha_fin,
                    'dia_pedidos' => $dia_pedidos,
                    'mediaIngresosPedido' => $mediaIngresosPedido));
    }
    
    public function mesasAction($restaurantID)
    {
        $request = Request::createFromGlobals();
        
        $fecha_inicio = "";
        if($request->query->has('fecha_inicio')){
            $fecha_inicio = $request->query->get('fecha_inicio');
        }
       
        $fecha_fin = "";
        if($request->query->has('fecha_fin')){
            $fecha_fin = $request->query->get('fecha_fin');
        }
        if($fecha_fin == "" || $fecha_inicio == ""){
            // Conseguir la fecha de inicio = fecha actual - 30 días
            $fecha_inicio = date("Ymd", strtotime("-30 day"));
            // Conseguir la fecha de fin = fecha actual
            $fecha_fin = date("Ymd");
        }
        
        $repository = $this->getDoctrine()
                ->getRepository('ServinowEntitiesBundle:Mesa');
        $mesas = $repository->findMesasIngresosCantidad($fecha_inicio, $fecha_fin, $restaurantID);
        
        return $this->render('ServinowMovimientosDeCajaBundle:General:mesas.html.twig',
                array('restaurantID' =>$restaurantID,
                    'fecha_inicio'=> $fecha_inicio,
                    'fecha_fin' => $fecha_fin,
                    'mesas'=> $mesas));
    }
}
