<?php

namespace Servinow\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Servinow\EntitiesBundle\Entity\Pedido;
use Servinow\EntitiesBundle\Entity\Restaurante;
use Servinow\EntitiesBundle\Entity\LineaPedido;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends Controller
{
    public function confirmarAction($restaurantID)
    {
        $request = $this->getRequest();
        
        $json = "";
        
        if($request->request->has('DATA')){
            $json = $request->request->get('DATA');
        }
        else{
            return new Response();
        }
        
        // Returns a object (false). True -> returns a associative array
        $data = json_decode($json, false); 
        
        // Gets the entity manager
        $em = $this->getDoctrine()->getManager();

        $mesa_id = $data->mesa_id;
        $lineas_pedido = $data->lineas_pedido;
        // Conseguir la fecha de fin = fecha actual
        $fecha = date("Ymd");
        $pagado = 0;
        $confirmado = 1;
        $restaurante = $em->getRepository('ServinowEntitiesBundle:Restaurante')->find($restaurantID);
        $mesa = $em->getRepository('ServinowEntitiesBundle:Mesa')->find($mesa_id);
        
        $pedido = new Pedido();
        $pedido->setMesa($mesa);
        $pedido->setConfirmado($confirmado);
        $pedido->setFecha($fecha);
        $pedido->setPagado($pagado);
        $pedido->setRestaurante($restaurante);
        
                
        // insertar el pedido en la base de datos
        $em->persist($pedido);
        $em->flush();
        
        $id_pedido_online = $pedido->getId();
        
        // insertar las lineas de pedido en la base de datos
        foreach ($lineas_pedido as $lp) {
            $linea_pedido_id = $lp->linea_pedido_id;
            $producto_id = $lp->producto_id;
            $cantidad = $lp->cantidad;
            $estado = "cola";
            $producto = $em->getRepository('ServinowEntitiesBundle:Producto')->find($producto_id);
            
            $linea_pedido = new LineaPedido();
            $linea_pedido->setId($linea_pedido_id);
            $linea_pedido->setPedido($pedido);
            $linea_pedido->setProducto($producto);
            $linea_pedido->setCantidad($cantidad);
            $linea_pedido->setEstado($estado);
            $em->persist($linea_pedido);           
        }
        $em->flush();
        
        $json_response = json_encode($id_pedido_online);
        
        $response = new Response($json_response);
        $response->headers->set('Content-Type', 'text/json');
        $response->setStatusCode(200);
        
        return $response;
    }
    
    public function borrarAction($restaurantID)
    {
        $request = $this->getRequest();
        
        $json = "";
        if($request->request->has('DATA')){
            $json = $request->request->get('DATA');
        }
        else{
            Return new Response();
        }
        
        $data = json_decode($json, false);
        
        // Gets the entity manager
        $em = $this->getDoctrine()->getManager();
        
        $pedido_id_online = $data->pedido_id_online;
        $mesa_id = $data->mesa_id;
        $linea_pedido_local = $data->linea_pedido_local;
        $cantidad = $data->cantidad;
        
        $linea_pedido = $em->getRepository('ServinowEntitiesBundle:LineaPedido')->findOneBy(array(
            'id'=> $linea_pedido_local,
            'pedido'=> $pedido_id_online
            ));
        $ok = 1;
        if($linea_pedido == null){
            $ok=0;
        }
        else{
            $cantidad_actual = $linea_pedido->getCantidad() - $cantidad;
            if($cantidad_actual >= 1 )
            {
                $linea_pedido->setCantidad($cantidad_actual);
            }
            else
            {
                $em->remove($linea_pedido);
            }
            $em->flush();
            
            $lineas_pedido = $em->getRepository('ServinowEntitiesBundle:LineaPedido')
                    ->findBy(array('pedido' => $pedido_id_online));

            $numero_lineas_pedido = count($lineas_pedido);
            if($numero_lineas_pedido < 1){
                $pedido = $em->getRepository('ServinowEntitiesBundle:Pedido')
                        ->find($pedido_id_online);
                $em->remove($pedido);
                $em->flush();
            }
        }
        
        $json_response = json_encode($ok);
        
        $response = new Response($json_response);
        $response->headers->set('Content-Type', 'text/json');
        $response->setStatusCode(200);
        
        return $response;
    }
    
    public function consultarAction($restaurantID)
    {
        $request = $this->getRequest();
        
        $json = "";
        if($request->request->has('DATA')){
            $json = $request->request->get('DATA');
        }
        else{
            Return new Response();
        }
        
        $data = json_decode($json, false);
        
        // Gets the entity manager
        $em = $this->getDoctrine()->getManager();
        
        $mesa_id = $data->mesa_id;
        $pedido_id_online = $data->pedido_id_online;
        
        $data_response = array();
        $i=0;
        foreach ($pedido_id_online as $pIdOnline) {
            $pedidoId = $pIdOnline->pedido_id_online;
            $data_response[$i]['pedido_id_online'] = $pedidoId;
            $lineas_pedido = $em->getRepository('ServinowEntitiesBundle:LineaPedido')
                    ->findBy(array('pedido' => $pedidoId));
            $j=0;
            $data_response[$i]['lineas_pedido'] = array();
            foreach ($lineas_pedido as $linea_pedido) {                
                $data_response[$i]['lineas_pedido'][$j]['linea_pedido_id'] = $linea_pedido->getId();
                $data_response[$i]['lineas_pedido'][$j]['estado'] = $linea_pedido->getEstado();
                $j++;
            }
            $i++;
        }
        
        
        $json_response = json_encode($data_response);
        
        $response = new Response($json_response);
        $response->headers->set('Content-Type', 'text/json');
        $response->setStatusCode(200);
        
        return $response;
    }
    
    public function pagarAction($restaurantID)
    {
        $request = $this->getRequest();
        
        $json = "";
        if($request->request->has('DATA')){
            $json = $request->request->get('DATA');
        }
        else{
            Return new Response();
        }
        
        $data = json_decode($json, false);
        
        // Gets the entity manager
        $em = $this->getDoctrine()->getManager();
        
        $mesa_id = $data->mesa_id;
        $pedido_id_online = $data->pedido_id_online;
        
        foreach ($pedido_id_online as $pIdOnline) {
            $pedidoId = $pIdOnline->pedido_id_online;
            $metodo_pago = $pIdOnline->metodo_pago;
            
            $pedido = $em->getRepository('ServinowEntitiesBundle:Pedido')->find($pedidoId);
            $pedido->setMetodoPago($metodo_pago);
            $pedido->setPagado(1);
        }
        
        $em->flush();
        
        $response = new Response();
        $response->headers->set('Content-Type', 'text/json');
        $response->setStatusCode(200);
        
        return $response;
    }
    
    public function categoriaAction($restaurantID)
    {
        $request = $this->getRequest();
        
        $categoria_id = ""; 
        if($request->query->has('categoryid'))
        {
            $categoria_id = $request->query->get('categoryid');
        }
        else
        {
            return new Response();
        }
        
        $em = $this->getDoctrine()->getManager();
        
        $categoria = $em->getRepository('ServinowEntitiesBundle:Categoria')
                ->find($categoria_id);
        
        $data_response = array();
        if($categoria != null){
            $i=0;
            $productos = $categoria->getProductos();
            foreach ($productos as $producto) {
                $data_response[$i] = $producto->getId();
                $i++;
            }
        }
        
        $json_response = json_encode($data_response);
        
        $response = new Response($json_response);
        $response->headers->set('Content-Type', 'text/json');
        $response->setStatusCode(200);
        
        return $response;
    }
    
    public function restauranteAction($restaurantID){
        
        $request = $this->getRequest();
        
        $mesa_id = "";
        if($request->query->has('placeid'))
        {
            $mesa_id = $request->query->get('placeid');
        }
        
        $em = $this->getDoctrine()->getManager();
        
        $restaurante = $em->getRepository('ServinowEntitiesBundle:Restaurante')
                ->find($restaurantID);
        
        $data_response['onlineID'] = $restaurantID;
        $data_response['lastUpdate'] = $restaurante->getUltimaActualizacion();
        $data_response['name'] = $restaurante->getNombre();
        $data_response['tax'] = $restaurante->getImpuesto();
        $data_response['emailPayPalAccount'] = $restaurante->getemailCuentaPaypal();
        
        $data_response['places'] = array();
        $mesas = $restaurante->getMesas();
        $i=0;
        foreach ($mesas as $mesa) {
            $data_response['places'][$i]['onlineID'] = $mesa->getId();
            $data_response['places'][$i]['lastUpdate'] = $mesa->getUltimaActualizacion();
            $i++;
        }
        
        $data_response['categories'] = array();
        $categorias = $restaurante->getCategorias();
        $i=0;
        foreach ($categorias as $categoria) {
            $data_response['categories'][$i]['id'] = $categoria->getId();
            $data_response['categories'][$i]['nombre'] = $categoria->getNombre();
            $data_response['categories'][$i]['imageName'] = $categoria->getImagen();
            $i++;
        }
        
        $data_response['products'] = array();
        $productos = $restaurante->getProductos();
        $i=0;
        foreach ($productos as $producto) {
            $data_response['products'][$i]['id'] = $producto->getId();
            $data_response['products'][$i]['nombre'] = $producto->getNombre();
            $data_response['products'][$i]['descripcion'] = $producto->getDescripcion();
            $data_response['products'][$i]['tipo'] = "PLATO";
            $data_response['products'][$i]['precio'] = $precio = $producto->getPrecio();
            $disponible = true;
            if($producto->getDisponible() == 0){
                $disponible = false;
            }
            $data_response['products'][$i]['disponible'] = $disponible;
            $data_response['products'][$i]['imageName'] = $producto->getImagen();
            $i++;
        }
        
        $json_response = json_encode($data_response);
        
        $response = new Response($json_response);
        $response->headers->set('Content-Type', 'text/json');
        $response->setStatusCode(200);
        
        return $response;
    }
}
