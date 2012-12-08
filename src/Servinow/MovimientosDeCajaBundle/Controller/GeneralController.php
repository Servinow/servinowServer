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
        
        //Date madness starts here...
        $fecha = $fecha_inicio;
        while(strtotime($fecha) <= strtotime($fecha_fin)) {
            $dia_pedidos[$fecha]['fecha'] = date("d-m-Y", strtotime($fecha));
            $dia_pedidos[$fecha]['total'] = 0;
            $fecha = date("Ymd", strtotime("+1 day", strtotime($fecha)));
        }
        for($j=0, $sizePedidos = count($pedidos); $j < $sizePedidos; $j++) {
            $dia_pedidos[$pedidos[$j]['fecha']]['total'] += $pedidos[$j]['total'];
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
        
        //Date madness starts here...
        $fecha = $fecha_inicio;
        while(strtotime($fecha) <= strtotime($fecha_fin)) {
            $dia_pedidos[$fecha]['fecha'] = date("d-m-Y", strtotime($fecha));
            $dia_pedidos[$fecha]['pedidos'] = 0;
            $fecha = date("Ymd", strtotime("+1 day", strtotime($fecha)));
        }
        for($j=0, $sizePedidos = count($pedidos); $j < $sizePedidos; $j++) {
            $dia_pedidos[$pedidos[$j]['fecha']]['pedidos'] += $pedidos[$j]['1'];
        }
        
        $total = $repository->totalPedidosCantidadIngresos($fecha_inicio, $fecha_fin, $restaurantID);
        
        $mediaIngresosPedido = $total['ingresos'] / $total['pedidos'];
        
        return $this->render('ServinowMovimientosDeCajaBundle:General:pedidos.html.twig',
                array('restaurantID' =>$restaurantID,
                    'fecha_inicio'=> $fecha_inicio,
                    'fecha_fin' => $fecha_fin,
                    'dia_pedidos' => $dia_pedidos,
                    'mediaIngresosPedido' => number_format($mediaIngresosPedido,2)));
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
