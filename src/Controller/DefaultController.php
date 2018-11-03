<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Entity\Role;
use App\Entity\Account;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction()
    {
        return $this->render('index.html.twig');
    }
}