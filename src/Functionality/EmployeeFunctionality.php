<?php

namespace App\Functionality;

use App\Entity\Employee;
use Doctrine\ORM\EntityManagerInterface;

class EmployeeFunctionality
{
    /** @var EntityManagerInterface */
    protected $em;

    /**
     * EmployeeFunctionality constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct ( EntityManagerInterface $em )
    {
        $this->em = $em;
    }

    public function save(Employee $employee)
    {
        $this->em->persist($employee);
        $this->em->flush();
    }

}