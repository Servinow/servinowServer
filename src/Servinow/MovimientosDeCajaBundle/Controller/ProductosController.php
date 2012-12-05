<?php

namespace Servinow\MovimientosDeCajaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductosController extends Controller
{
    public function productosAction($restaurantID)
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
                ->getRepository('ServinowEntitiesBundle:Producto');
        
        $productoID = "";
        if($request->query->has('producto')){
            $productoID = $request->query->get('producto');
            $producto = $repository->findProductoCantidadIngresos($productoID, $fecha_inicio, $fecha_fin, $restaurantID);
            return $this->render('ServinowMovimientosDeCajaBundle:Productos:productos_id.html.twig',
                array('restaurantID' =>$restaurantID,
                    'fecha_inicio'=> $fecha_inicio,
                    'fecha_fin' => $fecha_fin,
                    'producto' => $producto));
        }
        
        
        $productosIngresosAll = $repository->findProductosTop10Ingresos($fecha_inicio, $fecha_fin, $restaurantID);
        
        $productosCantidadAll = $repository->findProductosTop10Cantidad($fecha_inicio, $fecha_fin, $restaurantID);
        
        
        $productosIngresos = array();
        $productosCantidad = array();
        
        for($i=0; $i<10 && $i < count($productosIngresosAll); $i++){
            $productosIngresos[$i] = $productosIngresosAll[$i];
            $productosCantidad[$i] = $productosCantidadAll[$i];
        }
        
        return $this->render('ServinowMovimientosDeCajaBundle:Productos:productos.html.twig',
                array('restaurantID' =>$restaurantID,
                    'fecha_inicio'=> $fecha_inicio,
                    'fecha_fin' => $fecha_fin,
                    'productosIngresos' => $productosIngresos,
                    'productosCantidad' => $productosCantidad));
    }
}
