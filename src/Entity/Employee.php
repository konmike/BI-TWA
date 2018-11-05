<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmployeeRepository")
 */
class Employee
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
    private $name;

    /**
     * @ORM\Column(type="simple_array")
     */
    private $functionsId;

    /**
     * @ORM\Column(type="simple_array")
     */
    private $accountsId;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $surname;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $room;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $web;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $otherInfo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $Name): self
    {
        $this->name = $Name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $Surname): self
    {
        $this->surname = $Surname;

        return $this;
    }

    public function getRoom(): ?int
    {
        return $this->room;
    }

    public function setRoom(?int $Room): self
    {
        $this->room = $Room;

        return $this;
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

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(?int $Phone): self
    {
        $this->phone = $Phone;

        return $this;
    }

    public function getWeb(): ?string
    {
        return $this->web;
    }

    public function setWeb(?string $Web): self
    {
        $this->web = $Web;

        return $this;
    }

    public function getOtherInfo()
    {
        return $this->otherInfo;
    }

    public function setOtherInfo($otherInfo): self
    {
        $this->otherInfo = $otherInfo;

        return $this;
    }

    public function getFunctionsId()
    {
        return $this->functionsId;
    }

    public function setFunctionsId($functionsId): self
    {
        $this->functionsId = $functionsId;

        return $this;
    }

    public function getAccountsId()
    {
        return $this->accountsId;
    }


    public function setAccountsId($accountsId): self
    {
        $this->accountsId = $accountsId;

        return $this;
    }


}
