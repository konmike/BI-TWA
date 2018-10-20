<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 17.10.18
 * Time: 11:40
 */

namespace App\Model;


class Employee
{
    /** @var int */
    protected $id;

    /** @var string */
    protected $name;

    /** @var string */
    protected $surname;

    /** @var string[] */
    protected $functions = [];

    /** @var int */
    protected $room;

    /** @var string */
    protected $email;

    /** @var string */
    protected $phone;

    /** @var string */
    protected $web;

    /** @var string */
    protected $otherInfo;

    /**
     * Employee constructor.
     * @param int $id
     * @param string $name
     * @param string $surname
     * @param int $room
     * @param string $email
     * @param string $phone
     * @param string $web
     * @param string $otherInfo
     */
    public function __construct(int $id, string $name, string $surname, int $room, string $email,
                                string $phone, string $web, string $otherInfo)
    {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->room = $room;
        $this->email = $email;
        $this->phone = $phone;
        $this->web = $web;
        $this->otherInfo = $otherInfo;
    }


    /**
     * @param int $id
     * @param string $name
     * @param string $surname
     * @param int $room
     * @param string $email
     * @param string $phone
     * @param string $web
     * @param string $otherInfo
     * @return Employee
     */
    public static function create (int $id, string $name, string $surname, int $room,
                                   string $email, string $phone, string $web, string $otherInfo) : Employee
    {
        return new static( $id, $name, $surname, $room, $email, $phone, $web, $otherInfo );
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @param string $function
     * @return Employee
     */
    public function addFunction ( string $function ): Employee
    {
        $this->functions[] = $function;
        return $this;
    }

    /**
     * @param string[] $functions
     * @return Employee
     */
    public function setFunctions ( array $functions ): Employee
    {
        $this->functions = $functions;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getFunctions (): array
    {
        return $this->functions;
    }

    /**
     * @return int
     */
    public function getRoom(): int
    {
        return $this->room;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getWeb(): string
    {
        return $this->web;
    }

    /**
     * @return string
     */
    public function getOtherInfo(): string
    {
        return $this->otherInfo;
    }
}