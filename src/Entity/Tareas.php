<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TareasRepository")
 */
class Tareas
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Listas", inversedBy="tareas")
     */
    private $lista;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\Column(type="text")
     */
    private $nota;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fecha_vencimiento;

    /**
     * @ORM\Column(type="boolean")
     */
    private $importante;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $estado;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLista(): ?Listas
    {
        return $this->lista;
    }

    public function setLista(?Listas $lista): self
    {
        $this->lista = $lista;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getNota(): ?string
    {
        return $this->nota;
    }

    public function setNota(string $nota): self
    {
        $this->nota = $nota;

        return $this;
    }

    public function getFechaVencimiento(): ?\DateTimeInterface
    {
        return $this->fecha_vencimiento;
    }

    public function setFechaVencimiento(\DateTimeInterface $fecha_vencimiento): self
    {
        $this->fecha_vencimiento = $fecha_vencimiento;

        return $this;
    }

    public function getImportante(): ?bool
    {
        return $this->importante;
    }

    public function setImportante(bool $importante): self
    {
        $this->importante = $importante;

        return $this;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): self
    {
        $this->estado = $estado;

        return $this;
    }
}
