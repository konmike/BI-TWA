<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Entity\Role;
use App\Entity\Account;

use App\Form\AccountType;
use App\Functionality\AccountFunctionality;
use App\Repository\AccountRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AccountController extends AbstractController
{
    /**
     * @var AccountRepository
     */
    protected $accountRepository;

    /** @var AccountFunctionality */
    protected $accountFunctionality;

    /**
     * AccountController constructor.
     * @param AccountFunctionality $accountFunctionality
     */
    public function __construct ( AccountFunctionality $accountFunctionality )
    {
        $this->accountFunctionality = $accountFunctionality;
    }

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
     * @Route("/account_edit/{account_id}", name="account_edit", requirements={"account_id":"\d+"})
     * @param int $account_id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction($account_id, Request $request)
    {
        $this->accountRepository = $this->getDoctrine()->getRepository(Account::class);
        $account = $this->accountRepository->find($account_id);

        if( $account === null){
            throw $this->createNotFoundException();
        }else{
            $employee = $this->getRepository(Employee::class)->find($account->getEmployeeId());
        }

        $form = $this->createForm(AccountType::class, $account, []);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->accountFunctionality->save($account);

            $this->addFlash('success', 'Údaje byly uloženy.');
            return $this->redirectToRoute('employee_list', [
            ]);
        }


        return $this->render("account/edit.html.twig", [
            'form' => $form->createView(),
            "employee" => $employee,
            'account' => $account,
        ]);
    }

    /**
     * @Route("/account_create", name="account_create", defaults={"account_id": null})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request){
        $account = new Account();

        $form = $this->createForm(AccountType::class, $account, []);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->accountFunctionality->save($account);

            $this->addFlash('success', 'Údaje byly uloženy.');
            return $this->redirectToRoute('employee_list', [
            ]);
        }

        return $this->render("account/create.html.twig", [
            'form' => $form->createView(),
        ]);
    }

    protected function getRepository($class) {
        return $this->getDoctrine()->getRepository($class);
    }
}