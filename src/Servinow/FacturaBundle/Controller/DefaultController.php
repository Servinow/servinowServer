<?php

namespace Servinow\FacturaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use  Servinow\EntitiesBundle\Entity\Restaurante;

class DefaultController extends Controller
{
    public function indexAction($restaurantID)
    {
        // create a task and give it some dummy data for this example
        $restaurante = $this->getDoctrine()
                ->getRepository('ServinowEntitiesBundle:Restaurante')
                ->find($restaurantID);

        $form = $this->createFormBuilder($restaurante)
            ->add('nombre', 'text')
            ->add('nombreCompletoTitular', 'text')
            ->add('NIFTitular', 'text')
            ->add('direccion', 'text')
            ->add('ciudad', 'text')
            ->add('codigoPostal', 'text')
            ->add('provincia', 'text')
            ->add('telefonoFijo', 'text')
            ->add('telefonoMovil', 'text')
            ->add('fax', 'text')
            ->getForm();

        return $this->render('ServinowFacturaBundle:Default:index.html.twig', array(
            'form' => $form->createView(),
            'restaurantID' => $restaurantID
        ));
    }
}
