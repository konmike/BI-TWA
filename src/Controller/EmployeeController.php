<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Entity\Role;
use App\Entity\Account;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeController extends AbstractController
{
    /**
     * @Route("/list", name="employee_list")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(){
        $employees = $this->getRepository(Employee::class)->findAll();
        $functions = $this->getRepository(Role::class)->findAll();

        return $this->render('employee/list.html.twig', [
            "employees" => $employees,
            "functions" => $functions,
        ]);

    }

    /**
     * @Route("/detail/{id}", name="employee_detail", requirements={"id":"\d+"})
     * @param Employee $employee
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function detailAction(Employee $employee){
        if (empty($employee)){
                return $this->render( '404.html.twig', [], ( new Response() )->setStatusCode( 404 ) );
        }

        foreach ($employee->getFunctionsId() as $functionId){
            $functions [] = $this->getRepository(Role::class)->find($functionId);
        }


        return $this->render("employee/detail.html.twig", [
            "employee" => $employee,
            'functions' => $functions,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="employee_edit", requirements={"id":"\d+"})
     * @param Employee $employee
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Employee $employee){
        if (empty($employee)){
            return $this->render( '404.html.twig', [], ( new Response() )->setStatusCode( 404 ) );
        }

        foreach ($employee->getFunctionsId() as $functionId){
            $functions [] = $this->getRepository(Role::class)->find($functionId);
        }

        return $this->render("employee/edit.html.twig", [
            "employee" => $employee,
            'functions' => $functions,
        ]);
    }

    protected function getRepository($class) {
        return $this->getDoctrine()->getRepository($class);
    }

}

