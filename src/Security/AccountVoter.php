<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 25.11.18
 * Time: 19:45
 */

namespace App\Security;

use App\Entity\Account;
use App\Entity\Employee;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AccountVoter extends Voter
{

    const VIEW = 'view';
    const EDIT = 'edit';
    const CREATE = 'create';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, array(self::VIEW, self::EDIT, self::CREATE))) {
            return false;
        }

        if($subject == null){
            $subject = new Account();
        }

        if (!$subject instanceof Account) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof Account) {
            // the user must be logged in; if not, deny access
            return false;
        }

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($user);
            case self::EDIT:
                return $this->canEdit($user);
            case self::CREATE:
                return $this->canCreate($user);
        }

        throw new \LogicException('This code should not be reached!');
    }


    private function canView(Account $account)
    {

        if ($account->getValidity() === null) {
            return true;
        }
        return false;
    }

    private function canEdit(Account $account)
    {
        if ($this->security->isGranted('ROLE_ADMIN') && $account->getValidity() === null) {
            return true;
        }

        return false;
    }

    private function canCreate(Account $account)
    {
        if ($this->security->isGranted('ROLE_ADMIN') && $account->getValidity() === null) {
            return true;
        }

        return false;
    }

}