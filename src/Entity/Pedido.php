<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PedidoRepository")
 */
class Pedido
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha_creacion;

    /**
     * @ORM\Column(type="float")
     */
    private $importe;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Producto", inversedBy="pedidos")
     */
    private $productos;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cliente", inversedBy="pedidos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cliente;

    public function __construct()
    {
        $this->productos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFechaCreacion(): ?\DateTimeInterface
    {
        return $this->fecha_creacion;
    }

    public function setFechaCreacion(\DateTimeInterface $fecha_creacion): self
    {
        $this->fecha_creacion = $fecha_creacion;

        return $this;
    }

    public function getImporte(): ?float
    {
        return $this->importe;
    }

    public function setImporte(float $importe): self
    {
        $this->importe = $importe;

        return $this;
    }

    /**
     * @return Collection|Producto[]
     */
    public function getProductos(): Collection
    {
        return $this->productos;
    }

    public function addProducto(Producto $producto): self
    {
        if (!$this->productos->contains($producto)) {
            $this->productos[] = $producto;
        }

        return $this;
    }

    public function removeProducto(Producto $producto): self
    {
        if ($this->productos->contains($producto)) {
            $this->productos->removeElement($producto);
        }

        return $this;
    }

    public function setProductos(Producto $productos)
    {
        $this->productos = $productos;
    
        return $this;
    }

    public function getCliente(): ?Cliente
    {
        return $this->cliente;
    }

    public function setCliente(?Cliente $cliente): self
    {
        $this->cliente = $cliente;

        return $this;
    }
}
