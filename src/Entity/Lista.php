<?php

namespace App\Entity;

use App\Repository\ListaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ListaRepository::class)]
class Lista
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /*
    *@var \User
    *
    *@ORM\ManyToOne(targetEntity="User")
    *@ORM\JoinColumns({
    *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
    *  })
    */
    private $user;




    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCancion(): ?int
    {
      return $this->cancion;   
    }

    public function getUser()
    {
        return $this->user;
    }

  
    
}
