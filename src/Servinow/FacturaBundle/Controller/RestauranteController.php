<?php

namespace Servinow\FacturaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Servinow\EntitiesBundle\Entity\Restaurante;
use Servinow\FacturaBundle\Form\Type\RestauranteType;


class RestauranteController extends Controller
{
    public function newAction($restaurantID)
    {
       $request = $this->getRequest();
       
       $repository = $this->getDoctrine()
                ->getRepository('ServinowEntitiesBundle:Restaurante');
       
       // just setup a fresh $task object (remove the dummy data)
       $restaurante = $repository->find($restaurantID);
       
       $form = $this->createForm(new RestauranteType(), $restaurante);
       
       if ($request->isMethod('POST')) {
           $form->bind($request);

           if ($form->isValid()) {
               // perform some action, such as saving the task to the database
               $nombre = $form->get('nombre')->getData();
               $nombreCompletoTitular = $form->get('nombreCompletoTitular')->getData();
               $NIFTitular = $form->get('NIFTitular')->getData();
               $direccion = $form->get('direccion')->getData();
               $ciudad = $form->get('ciudad')->getData();
               $codigoPostal = $form->get('codigoPostal')->getData();
               $provincia = $form->get('provincia')->getData();
               $telefonoFijo = $form->get('telefonoFijo')->getData();
               $telefonoMovil = $form->get('telefonoMovil')->getData();
               $fax = $form->get('fax')->getData();
               
               $repository->actualizarRestaurante(
                       $restaurantID, 
                       $nombre,
                       $nombreCompletoTitular,
                       $NIFTitular,
                       $direccion,
                       $ciudad,
                       $codigoPostal,
                       $provincia,
                       $telefonoFijo,
                       $telefonoMovil,
                       $fax
               );

               return $this->redirect($this->generateUrl('servinow_factura_success', 
                       array('restaurantID' => $restaurantID)));
           }
           else{
                return $this->render('ServinowFacturaBundle:Restaurante:index.html.twig', array(
                    'form' => $form->createView(),
                    'restaurantID' => $restaurantID
                ));
           }
       }
       else if($request->isMethod('GET')){
            return $this->render('ServinowFacturaBundle:Restaurante:index.html.twig', array(
                'form' => $form->createView(),
                'restaurantID' => $restaurantID
            ));
       }
    }
    public function successAction($restaurantID){
        return $this->render('ServinowFacturaBundle:Restaurante:success.html.twig',array(
            'restaurantID' => $restaurantID
        ));
    }
}
