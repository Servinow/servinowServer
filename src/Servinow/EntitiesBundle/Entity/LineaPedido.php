<?php

namespace Servinow\EntitiesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Servinow\EntitiesBundle\Entity\LineaPedido
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Servinow\EntitiesBundle\Entity\LineaPedidoRepository")
 */
class LineaPedido
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     */
    private $id;

    /**
     * @var integer $cantidad
     *
     * @ORM\Column(name="cantidad", type="integer")
     */
    private $cantidad;

    /**
     * @var string $estado
     *
     * @ORM\Column(name="estado", type="string", length=255)
     */
    private $estado;
    
    /**
     * @ORM\ManyToOne(targetEntity="Pedido", inversedBy="lineasPedido")
     * @ORM\Id
     * @ORM\JoinColumn(name="pedido_id", referencedColumnName="id")
     */
    private $pedido;
    
    /**
     * @ORM\ManyToOne(targetEntity="Producto", inversedBy="lineasPedido")
     * @ORM\JoinColumn(name="producto_id", referencedColumnName="id")
     */
    private $producto;
    

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
     * Set cantidad
     *
     * @param integer $cantidad
     * @return LineaPedido
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    
        return $this;
    }

    /**
     * Get cantidad
     *
     * @return integer 
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set estado
     *
     * @param string $estado
     * @return LineaPedido
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    
        return $this;
    }

    /**
     * Get estado
     *
     * @return string 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set pedido
     *
     * @param Servinow\EntitiesBundle\Entity\Pedido $pedido
     * @return LineaPedido
     */
    public function setPedido(\Servinow\EntitiesBundle\Entity\Pedido $pedido = null)
    {
        $this->pedido = $pedido;
    
        return $this;
    }

    /**
     * Get pedido
     *
     * @return Servinow\EntitiesBundle\Entity\Pedido 
     */
    public function getPedido()
    {
        return $this->pedido;
    }

    /**
     * Set producto
     *
     * @param Servinow\EntitiesBundle\Entity\Producto $producto
     * @return LineaPedido
     */
    public function setProducto(\Servinow\EntitiesBundle\Entity\Producto $producto = null)
    {
        $this->producto = $producto;
    
        return $this;
    }

    /**
     * Get producto
     *
     * @return Servinow\EntitiesBundle\Entity\Producto 
     */
    public function getProducto()
    {
        return $this->producto;
    }

    /**
     * Set id
     *
     * @param integer $id
     * @return LineaPedido
     */
    public function setId($id)
    {
        $this->id = $id;
    
        return $this;
    }
}