<?php

namespace Servinow\EntitiesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Servinow\EntitiesBundle\Entity\Restaurante
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Servinow\EntitiesBundle\Entity\RestauranteRepository")
 */
class Restaurante
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
     * @var string $nombre
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string $emailCuentaPaypal
     *
     * @ORM\Column(name="emailCuentaPaypal", type="string", length=255)
     */
    private $emailCuentaPaypal;

    /**
     * @var float $impuesto
     *
     * @ORM\Column(name="impuesto", type="float")
     */
    private $impuesto;
    
    /**
     * @ORM\OneToMany(targetEntity="Pedido", mappedBy="restaurante")
     */
    private $pedidos;
    
    /**
     * @ORM\OneToMany(targetEntity="Producto", mappedBy="restaurante")
     */
    private $productos;
    
    /**
     * @ORM\OneToMany(targetEntity="Mesa", mappedBy="restaurante")
     */
    private $mesas;

    
    public function __construct() {
        $this->pedidos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->productos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->mesas = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set ultimaActualizacion
     *
     * @param integer $ultimaActualizacion
     * @return Restaurante
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
     * Set nombre
     *
     * @param string $nombre
     * @return Restaurante
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    
        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set emailCuentaPaypal
     *
     * @param string $emailCuentaPaypal
     * @return Restaurante
     */
    public function setEmailCuentaPaypal($emailCuentaPaypal)
    {
        $this->emailCuentaPaypal = $emailCuentaPaypal;
    
        return $this;
    }

    /**
     * Get emailCuentaPaypal
     *
     * @return string 
     */
    public function getEmailCuentaPaypal()
    {
        return $this->emailCuentaPaypal;
    }

    /**
     * Set impuesto
     *
     * @param float $impuesto
     * @return Restaurante
     */
    public function setImpuesto($impuesto)
    {
        $this->impuesto = $impuesto;
    
        return $this;
    }

    /**
     * Get impuesto
     *
     * @return float 
     */
    public function getImpuesto()
    {
        return $this->impuesto;
    }

    /**
     * Add pedidos
     *
     * @param Servinow\EntitiesBundle\Entity\Pedido $pedidos
     * @return Restaurante
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
     * Add productos
     *
     * @param Servinow\EntitiesBundle\Entity\Producto $productos
     * @return Restaurante
     */
    public function addProducto(\Servinow\EntitiesBundle\Entity\Producto $productos)
    {
        $this->productos[] = $productos;
    
        return $this;
    }

    /**
     * Remove productos
     *
     * @param Servinow\EntitiesBundle\Entity\Producto $productos
     */
    public function removeProducto(\Servinow\EntitiesBundle\Entity\Producto $productos)
    {
        $this->productos->removeElement($productos);
    }

    /**
     * Get productos
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getProductos()
    {
        return $this->productos;
    }

    /**
     * Add mesas
     *
     * @param Servinow\EntitiesBundle\Entity\Mesa $mesas
     * @return Restaurante
     */
    public function addMesa(\Servinow\EntitiesBundle\Entity\Mesa $mesas)
    {
        $this->mesas[] = $mesas;
    
        return $this;
    }

    /**
     * Remove mesas
     *
     * @param Servinow\EntitiesBundle\Entity\Mesa $mesas
     */
    public function removeMesa(\Servinow\EntitiesBundle\Entity\Mesa $mesas)
    {
        $this->mesas->removeElement($mesas);
    }

    /**
     * Get mesas
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getMesas()
    {
        return $this->mesas;
    }
}