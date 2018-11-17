<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 17.11.18
 * Time: 8:22
 */

namespace App\Functionality;

use App\Entity\Account;
use App\Repository\AccountRepository;
use Doctrine\ORM\EntityManagerInterface;

class AccountFunctionality
{
    /** @var EntityManagerInterface */
    protected $em;

    /**
     * AccountFunctionality constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct ( EntityManagerInterface $em )
    {
        $this->em = $em;
    }

    public function save(Account $account)
    {
        $this->em->persist($account);
        $this->em->flush();
    }

}