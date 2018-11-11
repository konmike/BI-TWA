<?php

namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


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
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(max=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Role", inversedBy="employees")
     */
    private $functions;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(max=255)
     */
    private $surname;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $room;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max=255)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\Length(max=100)
     * @Assert\Url()
     */
    private $web;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Length(max=512)
     */
    private $otherInfo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Account", mappedBy="employee")
     */
    private $accounts;

    public function __construct()
    {
        $this->functions = new ArrayCollection();
        $this->accounts = new ArrayCollection();
    }

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

    /**
     * @return Collection|Role[]
     */
    public function getFunctions(): Collection
    {
        return $this->functions;
    }

    public function addFunction(Role $function): self
    {
        if (!$this->functions->contains($function)) {
            $this->functions[] = $function;
        }

        return $this;
    }

    public function removeFunction(Role $function): self
    {
        if ($this->functions->contains($function)) {
            $this->functions->removeElement($function);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function printFunctions(){
        return implode(", ",array_map(function($val){
            return $val->getName();
        },$this->functions->getValues()));
    }

    /**
     * @return Collection|Account[]
     */
    public function getAccounts(): Collection
    {
        return $this->accounts;
    }

    public function addAccount(Account $account): self
    {
        if (!$this->accounts->contains($account)) {
            $this->accounts[] = $account;
            $account->setEmployee($this);
        }

        return $this;
    }

    public function removeAccount(Account $account): self
    {
        if ($this->accounts->contains($account)) {
            $this->accounts->removeElement($account);

            if ($account->getEmployee() === $this) {
                $account->setEmployee(null);
            }
        }

        return $this;
    }


}