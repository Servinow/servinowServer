<?php

namespace Servinow\FacturaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RestauranteType
 *
 * @author escrichov
 */
class RestauranteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre', 'text', array(
            'label'  => 'Nombre'
        ));
        $builder ->add('nombreCompletoTitular', 'text', array(
            'label'  => 'Nombre Titular'
        ));
        $builder->add('NIFTitular', 'text', array(
            'label'  => 'NIF'
        ));
        $builder->add('direccion', 'text', array(
            'label'  => 'Direccion'
        ));
        $builder->add('ciudad', 'text', array(
            'label'  => 'Ciudad'
        ));
        $builder->add('codigoPostal', 'integer', array(
            'label'  => 'Código Postal'
        ));
        $builder->add('provincia', 'text', array(
            'label'  => 'Provincia'
        ));
        $builder->add('telefonoFijo', 'number', array(
            'label'  => 'Teléfono Fijo'
        ));
        $builder->add('telefonoMovil', 'number', array(
            'label'  => 'Teléfono Móvil'
        ));
        $builder->add('fax', 'number', array(
            'label'  => 'Fax',
            'required'  => false
        ));
    }

    public function getName()
    {
        return 'restaurante';
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Servinow\EntitiesBundle\Entity\Restaurante'
        ));
    }
}