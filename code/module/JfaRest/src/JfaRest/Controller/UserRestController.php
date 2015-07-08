<?php
namespace JfaRest\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;

use Jfa\Model\User;
use Jfa\Form\UserForm;
use Jfa\Model\UserTable;
use Zend\View\Model\JsonModel;

class UserRestController extends AbstractRestfulController
{
    protected $userTable;

    public function get(){
        
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