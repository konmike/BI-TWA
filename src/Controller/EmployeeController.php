<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Entity\Role;
use App\Entity\Account;


use App\Form\EmployeeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\DBAL\Types\TextType;

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

        return $this->render("employee/detail.html.twig", [
            "employee" => $employee,
        ]);
    }

    /**
     * @Route("/create", name="employee_create", defaults={"id": null})
     * @Route("/edit/{id}", name="employee_edit", requirements={"id":"\d+"})
     * @param int|null $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction($id, Request $request){

        $employee = $id ? $this->getRepository(Employee::class)->find($id) : new Employee();

        $form = $this->createForm(EmployeeType::class, $employee, [
        ]);

		$form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($employee);
            $em->flush();

            $this->addFlash('success', 'Údaje byly uloženy.');
            return $this->redirectToRoute('employee_detail', [
                'id' => $employee->getId(),
            ]);
        }

        if($id)
            return $this->render("employee/edit.html.twig", [
                'form' => $form->createView(),
                'employee' => $this->getRepository(Employee::class)->find($id),
            ]);
        else {
            return $this->render('employee/create.html.twig', [
                'form' => $form->createView(),
            ]);
        }
    }

    protected function getRepository($class) {
        return $this->getDoctrine()->getRepository($class);
    }

}

