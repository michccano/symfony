<?php

namespace App\Entity;

use App\Repository\MemberRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MemberRepository::class)
 */
class Member
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

  
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

     /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;



    public function getId(): ?int
    {
        return $this->id;
    }



    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->email;
    }

    public function setPassword(string $email): self
    {
        $this->password = $email;

        return $this;
    }


}
