<?php

namespace Servinow\EntitiesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Servinow\EntitiesBundle\Entity\Mesa
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Servinow\EntitiesBundle\Entity\MesaRepository")
 */
class Mesa
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer $ultimaActualizacion
     *
     * @ORM\Column(name="ultimaActualizacion", type="integer")
     */
    private $ultimaActualizacion;

    /**
     * @ORM\OneToMany(targetEntity="Pedido", mappedBy="mesa")
     */
    private $pedidos;
    
    /**
     * @ORM\ManyToOne(targetEntity="Restaurante", inversedBy="mesas")
     * @ORM\JoinColumn(name="restaurante_id", referencedColumnName="id")
     */
    private $restaurante;

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
     * Set ultimaActualizacion
     *
     * @param integer $ultimaActualizacion
     * @return Mesa
     */
    public function setUltimaActualizacion($ultimaActualizacion)
    {
        $this->ultimaActualizacion = $ultimaActualizacion;
    
        return $this;
    }

    /**
     * Get ultimaActualizacion
     *
     * @return integer 
     */
    public function getUltimaActualizacion()
    {
        return $this->ultimaActualizacion;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->pedidos = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add pedidos
     *
     * @param Servinow\EntitiesBundle\Entity\Pedido $pedidos
     * @return Mesa
     */
    public function addPedido(\Servinow\EntitiesBundle\Entity\Pedido $pedidos)
    {
        $this->pedidos[] = $pedidos;
    
        return $this;
    }

    /**
     * Remove pedidos
     *
     * @param Servinow\EntitiesBundle\Entity\Pedido $pedidos
     */
    public function removePedido(\Servinow\EntitiesBundle\Entity\Pedido $pedidos)
    {
        $this->pedidos->removeElement($pedidos);
    }

    /**
     * Get pedidos
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPedidos()
    {
        return $this->pedidos;
    }

    /**
     * Set restaurante
     *
     * @param Servinow\EntitiesBundle\Entity\Restaurante $restaurante
     * @return Mesa
     */
    public function setRestaurante(\Servinow\EntitiesBundle\Entity\Restaurante $restaurante = null)
    {
        $this->restaurante = $restaurante;
    
        return $this;
    }

    /**
     * Get restaurante
     *
     * @return Servinow\EntitiesBundle\Entity\Restaurante 
     */
    public function getRestaurante()
    {
        return $this->restaurante;
    }

}