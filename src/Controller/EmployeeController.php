<?php

namespace App\Controller;

use App\Model\Database;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmployeeController extends AbstractController
{

    /**
     * @var Database
     */
    protected $database;

    /**
     * EmployeeController constructor.
     */
    public function __construct()
    {
        $this->database = new Database();
    }

    /**
     * @Route("/", name="index")
     */
    public function indexAction(){
        return $this->render('index.html.twig');
    }

    /**
     * @Route("/list")
     */
    public function listAction(){
        return $this->render('list.html.twig', ["employees" => $this->database->getEmployees()]);
    }

    /**
     * @Route("/detail/{id}", name="employee_detail", requirements={"id":"\d+"})
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function detailAction(int $id){
        $employee = $this->database->getEmployee($id);
        if( $employee === null){
            return $this->render("404.html.twig");
        }

        return $this->render("detail.html.twig", ["employee"=>$employee]);
    }

    /**
     * @Route("/edit/{id}", name="employee_edit", requirements={"id":"\d+"})
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(int $id){
        $employee = $this->database->getEmployee($id);
        if( $employee === null){
            return $this->render("404.html.twig");
        }

        return $this->render("edit.html.twig", ["employee"=>$employee]);
    }

}

