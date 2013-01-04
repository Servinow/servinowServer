<?php

namespace Servinow\EntitiesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Servinow\EntitiesBundle\Entity\Categoria
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Servinow\EntitiesBundle\Entity\CategoriaRepository")
 */
class Categoria
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string $nombre
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string $imagen
     *
     * @ORM\Column(name="imagen", type="string", length=2083)
     */
    private $imagen;

    /**
     * @ORM\ManyToMany(targetEntity="Producto", inversedBy="categorias")
     * @ORM\JoinTable(name="categorias_productos")
     */
    private $productos;
    
    /**
     * @ORM\ManyToOne(targetEntity="Restaurante", inversedBy="categorias")
     * @ORM\JoinColumn(name="restaurante_id", referencedColumnName="id")
     */
    private $restaurante;

    
    public function __construct() {
        $this->productos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nombre
     *
     * @param string $nombre
     * @return Categoria
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
     * Set imagen
     *
     * @param string $imagen
     * @return Categoria
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;
    
        return $this;
    }

    /**
     * Get imagen
     *
     * @return string 
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * Add productos
     *
     * @param Servinow\EntitiesBundle\Entity\Producto $productos
     * @return Categoria
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
     * Set restaurante
     *
     * @param Servinow\EntitiesBundle\Entity\Restaurante $restaurante
     * @return Categoria
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