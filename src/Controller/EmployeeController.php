<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Entity\Role;
use App\Entity\Account;


use App\Form\EmployeeType;
use App\Functionality\EmployeeFunctionality;
use App\Repository\EmployeeRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\DBAL\Types\TextType;

class EmployeeController extends AbstractController
{
    /**
     * @var EmployeeRepository
     */
    protected $employeeRepository;

    /** @var EmployeeFunctionality */
    protected $employeeFunctionality;

    /**
     * EmployeeController constructor.
     * @param EmployeeFunctionality $employeeFunctionality
     */
    public function __construct(EmployeeFunctionality $employeeFunctionality)
    {
        $this->employeeFunctionality = $employeeFunctionality;
    }

    /**
     * @Route("/list", name="employee_list")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(){
        $this->employeeRepository = $this->getDoctrine()->getRepository(Employee::class);

        return $this->render('employee/list.html.twig', [
            "employees" => $this->employeeRepository->findAll(),
        ]);

    }

    /**
     * @Route("/detail/{id}", name="employee_detail", requirements={"id":"\d+"})
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function detailAction(int $id){
        $this->employeeRepository = $this->getDoctrine()->getRepository(Employee::class);
        $employee = $this->employeeRepository->find($id);

        if( $employee === null){
            throw $this->createNotFoundException();
        }

        return $this->render("employee/detail.html.twig", [
            "employee" => $employee,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="employee_edit", requirements={"id":"\d+"})
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(int $id, Request $request){
        $this->employeeRepository = $this->getDoctrine()->getRepository(Employee::class);

        $employee = $this->employeeRepository->find($id);

        if( $employee === null){
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(EmployeeType::class, $employee, [
        ]);

		$form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->employeeFunctionality->save($employee);

            $this->addFlash('success', 'Údaje byly uloženy.');
            return $this->redirectToRoute('employee_detail', [
                'id' => $employee->getId(),
            ]);
        }

        return $this->render("employee/edit.html.twig", [
            'form' => $form->createView(),
            'employee' => $employee,
        ]);

    }

    /**
     * @Route("/create", name="employee_create", defaults={"id": null})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     **/
    public function createAction(Request $request){
        $employee = new Employee();

        if( $employee === null){
            throw $this->createNotFoundException();
        }
        $form = $this->createForm(EmployeeType::class, $employee, [
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->employeeFunctionality->save($employee);

            $this->addFlash('success', 'Údaje byly uloženy.');
            return $this->redirectToRoute('employee_detail', [
                'id' => $employee->getId(),
            ]);
        }

        return $this->render("employee/create.html.twig", [
            'form' => $form->createView(),
            'employee' => $employee,
        ]);

    }

}

