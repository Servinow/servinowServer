<?php

namespace Servinow\EntitiesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Servinow\EntitiesBundle\Entity\Pedido
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Servinow\EntitiesBundle\Entity\PedidoRepository")
 */
class Pedido
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
     * @var integer $fecha
     *
     * @ORM\Column(name="fecha", type="integer")
     */
    private $fecha;

    /**
     * @var boolean $pagado
     *
     * @ORM\Column(name="pagado", type="boolean")
     */
    private $pagado;

    /**
     * @var boolean $confirmado
     *
     * @ORM\Column(name="confirmado", type="boolean")
     */
    private $confirmado;
    
    /**
     * @var boolean $metodoPago
     *
     * @ORM\Column(name="metodo_pago", type="string", length=255, nullable=true)
     */
    private $metodoPago;

    /**
     * @ORM\OneToMany(targetEntity="LineaPedido", mappedBy="pedido")
     */
    private $lineasPedido;
    
    /**
     * @ORM\ManyToOne(targetEntity="Restaurante", inversedBy="pedidos")
     * @ORM\JoinColumn(name="restaurante_id", referencedColumnName="id")
     */
    private $restaurante;
    
    /**
     * @ORM\ManyToOne(targetEntity="Mesa", inversedBy="pedidos")
     * @ORM\JoinColumn(name="mesa_id", referencedColumnName="id")
     */
    private $mesa;
    
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
     * Set fecha
     *
     * @param integer $fecha
     * @return Pedido
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    
        return $this;
    }

    /**
     * Get fecha
     *
     * @return integer 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set pagado
     *
     * @param boolean $pagado
     * @return Pedido
     */
    public function setPagado($pagado)
    {
        $this->pagado = $pagado;
    
        return $this;
    }

    /**
     * Get pagado
     *
     * @return boolean 
     */
    public function getPagado()
    {
        return $this->pagado;
    }

    /**
     * Set confirmado
     *
     * @param boolean $confirmado
     * @return Pedido
     */
    public function setConfirmado($confirmado)
    {
        $this->confirmado = $confirmado;
    
        return $this;
    }

    /**
     * Get confirmado
     *
     * @return boolean 
     */
    public function getConfirmado()
    {
        return $this->confirmado;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->lineasPedido = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add lineasPedido
     *
     * @param Servinow\EntitiesBundle\Entity\LineaPedido $lineasPedido
     * @return Pedido
     */
    public function addLineasPedido(\Servinow\EntitiesBundle\Entity\LineaPedido $lineasPedido)
    {
        $this->lineasPedido[] = $lineasPedido;
    
        return $this;
    }

    /**
     * Remove lineasPedido
     *
     * @param Servinow\EntitiesBundle\Entity\LineaPedido $lineasPedido
     */
    public function removeLineasPedido(\Servinow\EntitiesBundle\Entity\LineaPedido $lineasPedido)
    {
        $this->lineasPedido->removeElement($lineasPedido);
    }

    /**
     * Get lineasPedido
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getLineasPedido()
    {
        return $this->lineasPedido;
    }

    /**
     * Set restaurante
     *
     * @param Servinow\EntitiesBundle\Entity\Restaurante $restaurante
     * @return Pedido
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

    /**
     * Set mesa
     *
     * @param Servinow\EntitiesBundle\Entity\Mesa $mesa
     * @return Pedido
     */
    public function setMesa(\Servinow\EntitiesBundle\Entity\Mesa $mesa = null)
    {
        $this->mesa = $mesa;
    
        return $this;
    }

    /**
     * Get mesa
     *
     * @return Servinow\EntitiesBundle\Entity\Mesa 
     */
    public function getMesa()
    {
        return $this->mesa;
    }

    /**
     * Set metodoPago
     *
     * @param string $metodoPago
     * @return Pedido
     */
    public function setMetodoPago($metodoPago)
    {
        $this->metodoPago = $metodoPago;
    
        return $this;
    }

    /**
     * Get metodoPago
     *
     * @return string 
     */
    public function getMetodoPago()
    {
        return $this->metodoPago;
    }
}