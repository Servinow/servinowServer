<?php

namespace Servinow\RestaurantDrawerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Servinow\RestaurantDrawerBundle\Entity\SimpleObject
 */
class SimpleObject
{
    /**
     * @var integer $id
     */
    private $id;

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
     * @return SimpleObject
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
     * Set _restaurant
     *
     * @param Servinow\EntitiesBundle\Entity\Restaurante $restaurant
     * @return SimpleObject
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
     * @return SimpleObject
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
    /**
     * @var integer $x
     */
    private $x;

    /**
     * @var integer $y
     */
    private $y;

    /**
     * @var integer $wide
     */
    private $wide;

    /**
     * @var integer $tall
     */
    private $tall;

    /**
     * @var string $name
     */
    private $name;


    /**
     * Set x
     *
     * @param integer $x
     * @return SimpleObject
     */
    public function setX($x)
    {
        $this->x = $x;
    
        return $this;
    }

    /**
     * Get x
     *
     * @return integer 
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * Set y
     *
     * @param integer $y
     * @return SimpleObject
     */
    public function setY($y)
    {
        $this->y = $y;
    
        return $this;
    }

    /**
     * Get y
     *
     * @return integer 
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * Set wide
     *
     * @param integer $wide
     * @return SimpleObject
     */
    public function setWide($wide)
    {
        $this->wide = $wide;
    
        return $this;
    }

    /**
     * Get wide
     *
     * @return integer 
     */
    public function getWide()
    {
        return $this->wide;
    }

    /**
     * Set tall
     *
     * @param integer $tall
     * @return SimpleObject
     */
    public function setTall($tall)
    {
        $this->tall = $tall;
    
        return $this;
    }

    /**
     * Get tall
     *
     * @return integer 
     */
    public function getTall()
    {
        return $this->tall;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return SimpleObject
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
}