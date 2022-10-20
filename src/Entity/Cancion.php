<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cancion
 *
 * @ORM\Table(name="cancion")
 * @ORM\Entity
 */
class Cancion
{
    /**
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=255, nullable=false)
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="artista", type="string", length=255, nullable=false)
     */
    private $artista;

    /**
     * @var int|null
     *
     * @ORM\Column(name="lista_id", type="integer", nullable=true)
     */
    private $listaId;

    /**
     * @var \Lista
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Lista")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id", referencedColumnName="id")
     * })
     */
    private $id;



    /**
     * Get the value of titulo
     *
     * @return  string
     */ 
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set the value of titulo
     *
     * @param  string  $titulo
     *
     * @return  self
     */ 
    public function setTitulo(string $titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get the value of artista
     *
     * @return  string
     */ 
    public function getArtista()
    {
        return $this->artista;
    }

    /**
     * Set the value of artista
     *
     * @param  string  $artista
     *
     * @return  self
     */ 
    public function setArtista(string $artista)
    {
        $this->artista = $artista;

        return $this;
    }

    /**
     * Get the value of listaId
     *
     * @return  int|null
     */ 
    public function getListaId()
    {
        return $this->listaId;
    }

    /**
     * Set the value of listaId
     *
     * @param  int|null  $listaId
     *
     * @return  self
     */ 
    public function setListaId($listaId)
    {
        $this->listaId = $listaId;

        return $this;
    }

    /**
     * Get the value of id
     *
     * @return  \Lista
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param  \Lista  $id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}
