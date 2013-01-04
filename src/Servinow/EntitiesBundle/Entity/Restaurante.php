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
     * @var string $nombreCompletoTitular
     *
     * @ORM\Column(name="nombreCompletoTitular", type="string", length=255)
     */
    private $nombreCompletoTitular;
    
    /**
     * @var string $CIFTitular
     *
     * @ORM\Column(name="CIFTitular", type="string", length=255)
     */
    private $CIFTitular;
    
    /**
     * @var string $NIFTitular
     *
     * @ORM\Column(name="NIFTitular", type="string", length=255)
     */
    private $NIFTitular;
    
    /**
     * @var string $direccion
     *
     * @ORM\Column(name="direccion", type="string", length=255)
     */
    private $direccion;
    
    /**
     * @var string $ciudad
     *
     * @ORM\Column(name="ciudad", type="string", length=255)
     */
    private $ciudad;
    
    /**
     * @var string $provincia
     *
     * @ORM\Column(name="provincia", type="string", length=255)
     */
    private $provincia;
    
    /**
     * @var integer $codigoPostal
     *
     * @ORM\Column(name="codigoPostal", type="integer")
     */
    private $codigoPostal;
    
    /**
     * @var string $telefonoFijo
     *
     * @ORM\Column(name="telefonoFijo", type="string")
     */
    private $telefonoFijo;
    
    /**
     * @var string $telefonoFijo
     *
     * @ORM\Column(name="telefonoMovil", type="string")
     */
    private $telefonoMovil;
    
    /**
     * @var string $fax
     *
     * @ORM\Column(name="fax", type="string")
     */
    private $fax;

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
    
    /**
     * @ORM\OneToMany(targetEntity="Categoria", mappedBy="restaurante")
     */
    private $categorias;

    
    public function __construct() {
        $this->pedidos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->productos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->mesas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->categorias = new \Doctrine\Common\Collections\ArrayCollection();
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

    /**
     * Set direccion
     *
     * @param string $direccion
     * @return Restaurante
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    
        return $this;
    }

    /**
     * Get direccion
     *
     * @return string 
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set ciudad
     *
     * @param string $ciudad
     * @return Restaurante
     */
    public function setCiudad($ciudad)
    {
        $this->ciudad = $ciudad;
    
        return $this;
    }

    /**
     * Get ciudad
     *
     * @return string 
     */
    public function getCiudad()
    {
        return $this->ciudad;
    }

    /**
     * Set provincia
     *
     * @param string $provincia
     * @return Restaurante
     */
    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;
    
        return $this;
    }

    /**
     * Get provincia
     *
     * @return string 
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

    /**
     * Set codigoPostal
     *
     * @param integer $codigoPostal
     * @return Restaurante
     */
    public function setCodigoPostal($codigoPostal)
    {
        $this->codigoPostal = $codigoPostal;
    
        return $this;
    }

    /**
     * Get codigoPostal
     *
     * @return integer 
     */
    public function getCodigoPostal()
    {
        return $this->codigoPostal;
    }

    /**
     * Set telefonoFijo
     *
     * @param string $telefonoFijo
     * @return Restaurante
     */
    public function setTelefonoFijo($telefonoFijo)
    {
        $this->telefonoFijo = $telefonoFijo;
    
        return $this;
    }

    /**
     * Get telefonoFijo
     *
     * @return string
     */
    public function getTelefonoFijo()
    {
        return $this->telefonoFijo;
    }

    /**
     * Set telefonoMovil
     *
     * @param string $telefonoMovil
     * @return Restaurante
     */
    public function setTelefonoMovil($telefonoMovil)
    {
        $this->telefonoMovil = $telefonoMovil;
    
        return $this;
    }

    /**
     * Get telefonoMovil
     *
     * @return string 
     */
    public function getTelefonoMovil()
    {
        return $this->telefonoMovil;
    }

    /**
     * Set fax
     *
     * @param string $fax
     * @return Restaurante
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
    
        return $this;
    }

    /**
     * Get fax
     *
     * @return string
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set nombreCompletoTitular
     *
     * @param string $nombreCompletoTitular
     * @return Restaurante
     */
    public function setNombreCompletoTitular($nombreCompletoTitular)
    {
        $this->nombreCompletoTitular = $nombreCompletoTitular;
    
        return $this;
    }

    /**
     * Get nombreCompletoTitular
     *
     * @return string 
     */
    public function getNombreCompletoTitular()
    {
        return $this->nombreCompletoTitular;
    }

    /**
     * Set CIFTitular
     *
     * @param string $cIFTitular
     * @return Restaurante
     */
    public function setCIFTitular($cIFTitular)
    {
        $this->CIFTitular = $cIFTitular;
    
        return $this;
    }

    /**
     * Get CIFTitular
     *
     * @return string 
     */
    public function getCIFTitular()
    {
        return $this->CIFTitular;
    }

    /**
     * Set NIFTitular
     *
     * @param string $nIFTitular
     * @return Restaurante
     */
    public function setNIFTitular($nIFTitular)
    {
        $this->NIFTitular = $nIFTitular;
    
        return $this;
    }

    /**
     * Get NIFTitular
     *
     * @return string 
     */
    public function getNIFTitular()
    {
        return $this->NIFTitular;
    }

    /**
     * Add categorias
     *
     * @param Servinow\EntitiesBundle\Entity\Categoria $categorias
     * @return Restaurante
     */
    public function addCategoria(\Servinow\EntitiesBundle\Entity\Categoria $categorias)
    {
        $this->categorias[] = $categorias;
    
        return $this;
    }

    /**
     * Remove categorias
     *
     * @param Servinow\EntitiesBundle\Entity\Categoria $categorias
     */
    public function removeCategoria(\Servinow\EntitiesBundle\Entity\Categoria $categorias)
    {
        $this->categorias->removeElement($categorias);
    }

    /**
     * Get categorias
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getCategorias()
    {
        return $this->categorias;
    }
}