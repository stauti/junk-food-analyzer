<?php
namespace Jfa\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class AbstractController extends AbstractActionController
{
    protected $storage;
    protected $authservice;
    protected $userTable;

    public function getAuthService()
    {
        if (!$this->authservice) {
            $this->authservice = $this->getServiceLocator()
                ->get('AuthService');
        }

        return $this->authservice;
    }

    public function getSessionStorage()
    {
        if (! $this->storage) {
            $this->storage = $this->getServiceLocator()
                ->get('Jfa\Model\AuthStorage');
        }

        return $this->storage;
    }

    public function onDispatch(\Zend\Mvc\MvcEvent $e)
    {
        $response = parent::onDispatch($e);

        if (!$this->getAuthService()->hasIdentity()){
            return $this->redirect()->toRoute('login');
        } else {
            $username = $this->getAuthService()->getIdentity();
            $user = $this->getUserTable()->getUserByName($username);

            if (!$user->isAdmin) {
                return $this->redirect()->toRoute('jail');
            }
        }

        return $response;
    }

    public function getUserTable()
    {
        if (!$this->userTable) {
            $sm = $this->getServiceLocator();
            $this->userTable = $sm->get('Jfa\Model\UserTable');
        }
        return $this->userTable;
    }
}