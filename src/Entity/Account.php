<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AccountRepository")
 */
class Account implements UserInterface
{
    private $roles = [];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(max=255)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $password;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date()
     */
    private $validity;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Employee", inversedBy="accounts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $employee;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $Email): self
    {
        $this->email = $Email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $Password): self
    {
        $this->password = $Password;

        return $this;
    }

    public function getValidity(): ?\DateTimeInterface
    {
        return $this->validity;
    }

    public function setValidity(\DateTimeInterface $Validity = null): self
    {
        $this->validity = $Validity;

        return $this;
    }



    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function getEmployeeId(): ?Int
    {
        return $this->employee->getId();
    }

    public function setEmployee(?Employee $Employee): self
    {
        $this->employee = $Employee;

        return $this;
    }

    public function getUsername(): string
    {
        return (string) $this->email;
    }


    public function getRoles(): array
    {
        $functions = $this->employee->getFunctions();
        $isAdmin = false;

        foreach ($functions as $function) {
            if($function->getName() === "WebAdmin"){
                $isAdmin = true;
            }
        }

        if($isAdmin)
            $roles[] = 'ROLE_ADMIN';
        else
            $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

}
