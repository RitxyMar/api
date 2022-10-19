<?php

namespace App\Entity;

use App\Repository\CancionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CancionRepository::class)]
class Cancion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titulo = null;

    #[ORM\Column(length: 255)]
    private ?string $artista = null;

     /*
     *@ORM\ManyToOne(targetEntity="App\Entity\Lista")
     */
    private $lista;

    public function getLista(): ¿int
    {
        return $this->lista;
    }

    public function setLista()
    {
        $this->lista = $lista;
        return $this;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): self
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getArtista(): ?string
    {
        return $this->artista;
    }

    public function setArtista(string $artista): self
    {
        $this->artista = $artista;

        return $this;
    }
}
