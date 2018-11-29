<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 26.11.18
 * Time: 10:55
 */

namespace App\Security;

use App\Entity\Account as AppAccount;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;


class AccountChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $account)
    {
        if (!$account instanceof AppAccount) {
            return;
        }
    }

    public function checkPostAuth(UserInterface $account)
    {
        if (!$account instanceof AppAccount) {
            return;
        }

        // user account is expired, the user may be notified
        $currentDate = new \DateTime();

        if ($account->getValidity() === null)
            return;

        if ($account->getValidity() < $currentDate) {
            throw new AccountExpiredException('Platnost vaseho uctu vyprsela!');
        }

    }
}