<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Entity\Role;
use App\Entity\Account;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AccountController extends AbstractController
{
    /**
     * @Route("/account/{id}", name="account_detail", requirements={"id":"\d+"})
     * @param Employee $employee
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function detailAction(Employee $employee)
    {
        if (empty($employee)){
            return $this->render( '404.html.twig', [], ( new Response() )->setStatusCode( 404 ) );
        }

        foreach ($employee->getFunctionsId() as $functionId){
            $accounts [] = $this->getRepository(Account::class)->find($functionId);
        }

        return $this->render("account/detail.html.twig", [
            "employee" => $employee,
            "accounts" => $accounts,
        ]);
    }

    /**
     * @Route("/account_edit/{id}", name="account_edit", requirements={"id":"\d+"})
     * @param Employee $employee
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Employee $employee)
    {
        if (empty($employee)){
            return $this->render( '404.html.twig', [], ( new Response() )->setStatusCode( 404 ) );
        }

        foreach ($employee->getFunctionsId() as $functionId){
            $accounts [] = $this->getRepository(Account::class)->find($functionId);
        }

        return $this->render("account/edit.html.twig", [
            "employee" => $employee,
            "accounts" => $accounts,
        ]);
    }

    protected function getRepository($class) {
        return $this->getDoctrine()->getRepository($class);
    }
}