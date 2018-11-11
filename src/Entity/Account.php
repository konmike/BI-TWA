<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AccountRepository")
 */
class Account
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $password;

    /**
     * @ORM\Column(type="date")
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

    public function setValidity(\DateTimeInterface $Validity): self
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
}
