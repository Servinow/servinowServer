<?php

namespace Servinow\RestaurantDrawerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Servinow\RestaurantDrawerBundle\Entity\FloorObject
 */
class FloorObject
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var integer $p
     */
    private $p;

    /**
     * @var boolean $used
     */
    private $used;

    /**
     * @var Servinow\EntitiesBundle\Entity\Restaurante
     */
    private $_restaurant;

    /**
     * @var Servinow\RestaurantDrawerBundle\Entity\Drawer
     */
    private $_drawer;


    /**
     * Set id
     *
     * @param integer $id
     * @return FloorObject
     */
    public function setId($id)
    {
        $this->id = $id;
    
        return $this;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set p
     *
     * @param integer $p
     * @return FloorObject
     */
    public function setP($p)
    {
        $this->p = $p;
    
        return $this;
    }

    /**
     * Get p
     *
     * @return integer 
     */
    public function getP()
    {
        return $this->p;
    }

    /**
     * Set used
     *
     * @param boolean $used
     * @return FloorObject
     */
    public function setUsed($used)
    {
        $this->used = $used;
    
        return $this;
    }

    /**
     * Get used
     *
     * @return boolean 
     */
    public function getUsed()
    {
        return $this->used;
    }

    /**
     * Set _restaurant
     *
     * @param Servinow\EntitiesBundle\Entity\Restaurante $restaurant
     * @return FloorObject
     */
    public function setRestaurant(\Servinow\EntitiesBundle\Entity\Restaurante $restaurant = null)
    {
        $this->_restaurant = $restaurant;
    
        return $this;
    }

    /**
     * Get _restaurant
     *
     * @return Servinow\EntitiesBundle\Entity\Restaurante 
     */
    public function getRestaurant()
    {
        return $this->_restaurant;
    }

    /**
     * Set _drawer
     *
     * @param Servinow\RestaurantDrawerBundle\Entity\Drawer $drawer
     * @return FloorObject
     */
    public function setDrawer(\Servinow\RestaurantDrawerBundle\Entity\Drawer $drawer = null)
    {
        $this->_drawer = $drawer;
    
        return $this;
    }

    /**
     * Get _drawer
     *
     * @return Servinow\RestaurantDrawerBundle\Entity\Drawer 
     */
    public function getDrawer()
    {
        return $this->_drawer;
    }
}