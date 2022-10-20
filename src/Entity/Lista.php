<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lista
 *
 * @ORM\Table(name="lista")
 * @ORM\Entity(repositoryClass="App\Repository\ListaRepository")
 * 
 */
class Lista
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="listas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     * })
     */
    private $usuarioId;

    /**
     * @ORM\OneToMany(targetEntity="Cancion", mappedBy="listaId")
     */
    private $canciones;

    /**
     * @var \User
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;



    /**
     * Get the value of name
     *
     * @return  string
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param  string  $name
     *
     * @return  self
     */ 
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of usuarioId
     *
     * @return  \User
     */ 
    public function getUsuarioId()
    {
        return $this->usuarioId;
    }

    /**
     * Set the value of usuarioId
     *
     * @param  \User  $usuarioId
     *
     * @return  self
     */ 
    public function setUsuarioId($usuarioId)
    {
        $this->usuarioId = $usuarioId;

        return $this;
    }

    /**
     * Get the value of id
     *
     * @return  int
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param  int  $id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of canciones
     */ 
    public function getCanciones()
    {
        return $this->canciones;
    }

    /**
     * Set the value of canciones
     *
     * @return  self
     */ 
    public function setCanciones($canciones)
    {
        $this->canciones = $canciones;

        return $this;
    }
}
