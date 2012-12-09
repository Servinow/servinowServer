<?php

namespace Servinow\RestaurantDrawerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Servinow\RestaurantDrawerBundle\Entity\Drawer
 */
class Drawer
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $simpleObjects;

    /**
     * @var Servinow\EntitiesBundle\Entity\Restaurante
     */
    private $_restaurant;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->simpleObjects = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set id
     *
     * @param integer $id
     * @return Drawer
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
     * Add simpleObjects
     *
     * @param Servinow\RestaurantDrawerBundle\Entity\SimpleObject $simpleObjects
     * @return Drawer
     */
    public function addSimpleObject(\Servinow\RestaurantDrawerBundle\Entity\SimpleObject $simpleObjects)
    {
        $this->simpleObjects[] = $simpleObjects;
    
        return $this;
    }

    /**
     * Remove simpleObjects
     *
     * @param Servinow\RestaurantDrawerBundle\Entity\SimpleObject $simpleObjects
     */
    public function removeSimpleObject(\Servinow\RestaurantDrawerBundle\Entity\SimpleObject $simpleObjects)
    {
        $this->simpleObjects->removeElement($simpleObjects);
    }

    /**
     * Get simpleObjects
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getSimpleObjects()
    {
        return $this->simpleObjects;
    }

    /**
     * Set _restaurant
     *
     * @param Servinow\EntitiesBundle\Entity\Restaurante $restaurant
     * @return Drawer
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
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $tableObjects;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $floors;


    /**
     * Add tableObjects
     *
     * @param Servinow\RestaurantDrawerBundle\Entity\TableObject $tableObjects
     * @return Drawer
     */
    public function addTableObject(\Servinow\RestaurantDrawerBundle\Entity\TableObject $tableObjects)
    {
        $this->tableObjects[] = $tableObjects;
    
        return $this;
    }

    /**
     * Remove tableObjects
     *
     * @param Servinow\RestaurantDrawerBundle\Entity\TableObject $tableObjects
     */
    public function removeTableObject(\Servinow\RestaurantDrawerBundle\Entity\TableObject $tableObjects)
    {
        $this->tableObjects->removeElement($tableObjects);
    }

    /**
     * Get tableObjects
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTableObjects()
    {
        return $this->tableObjects;
    }

    /**
     * Add floors
     *
     * @param Servinow\RestaurantDrawerBundle\Entity\FloorObject $floors
     * @return Drawer
     */
    public function addFloor(\Servinow\RestaurantDrawerBundle\Entity\FloorObject $floors)
    {
        $this->floors[] = $floors;
    
        return $this;
    }

    /**
     * Remove floors
     *
     * @param Servinow\RestaurantDrawerBundle\Entity\FloorObject $floors
     */
    public function removeFloor(\Servinow\RestaurantDrawerBundle\Entity\FloorObject $floors)
    {
        $this->floors->removeElement($floors);
    }

    /**
     * Get floors
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getFloors()
    {
        return $this->floors;
    }
}