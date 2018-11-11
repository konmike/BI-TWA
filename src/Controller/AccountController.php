<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Entity\Role;
use App\Entity\Account;

use App\Form\AccountType;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AccountController extends AbstractController
{
    /**
     * @Route("/account/{employee_id}", name="account_detail", requirements={"employee_id":"\d+"})
     * @param int $employee_id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function detailAction($employee_id)
    {
        if (!$employee_id){
            return $this->render( '404.html.twig', [], ( new Response() )->setStatusCode( 404 ) );
        }

        $accounts = $this->getRepository(Employee::class)->find($employee_id)->getAccounts();
        $employee = $this->getRepository(Employee::class)->find($employee_id);

        return $this->render("account/detail.html.twig", [
            "employee" => $employee,
            "accounts" => $accounts,
        ]);
    }

    /**
     * @Route("/account_create", name="account_create", defaults={"account_id": null})
     * @Route("/account_edit/{account_id}", name="account_edit", requirements={"account_id":"\d+"})
     * @param int|null $account_id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction($account_id, Request $request)
    {
        $account = $account_id ? $this->getRepository(Account::class)->find($account_id) : new Account();

        if($account_id)
            $employee = $this->getRepository(Employee::class)->find($account->getEmployeeId());


        $form = $this->createForm(AccountType::class, $account, []);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($account);
            $em->flush();

            $this->addFlash('success', 'Údaje byly uloženy.');
            return $this->redirectToRoute('employee_list', [
            ]);
        }

        if($account_id)
        return $this->render("account/edit.html.twig", [
            'form' => $form->createView(),
            "employee" => $employee,
            'account' => $account,
        ]);
        else{
            return $this->render("account/create.html.twig", [
                'form' => $form->createView(),
                ]);
        }
    }

    protected function getRepository($class) {
        return $this->getDoctrine()->getRepository($class);
    }
}