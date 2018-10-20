<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 17.10.18
 * Time: 13:48
 */

namespace App\Model;

class Database
{

    /**
     * @var Employee[]
     */
    protected $employees = [];

    /**
     * Database constructor.
     * @param Employee[]
     */
    public function __construct()
    {
        $this->employees[] = Employee::create(1,'Jan', 'Novák', 200,
            'jannovak@firma.cz', '+420 123 456 789', 'jannovak.cz',
            'Jan pracuje ve firmě dlouho.')
            ->addFunction('Ředitel')
            ->addFunction('Programátor');

        $this->employees[] = Employee::create(2,'Petr', 'Novák', 202,
            'petrnovak@firma.cz', '+420 123 456 789', 'petrnovak.cz',
            'Petr Novák pracuje ve firmě deset let.')
            ->addFunction('Uklízeč')
            ->addFunction('Účetní');

        $this->employees[] = Employee::create(3,'Monika', 'Nováková', 200,
            'monikanovakova@firma.cz', '+420 123 456 789', '',
            'Monika Nováková taky pracuje v naší rodinné firmě.')
            ->addFunction('Sekretářka');

    }


    /**
     * @return Employee[]
     */
    public function getEmployees (): array
    {
        return $this->employees;
    }

    /**
     * @param $id
     * @return Employee|null
     */
    public function getEmployee ( $id ): ?Employee
    {
        foreach ( $this->employees as $employee)
            if ( $employee->getId() == $id )
                return $employee;
        return null;
    }

    public function printEmployee()
    {
        foreach ($this->employees as $employee){
            echo $employee->getId();
            echo " ";
            echo $employee->getName();
            echo " ";
            echo $employee->getSurname();
            echo "<br>";
        }
    }
}
