<?php
namespace JfaRest\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;

use Jfa\Model\User;
use Jfa\Model\UserTable;
use Zend\View\Model\JsonModel;

class UserRestController extends AbstractRestfulController
{
    protected $storage;
    protected $authservice;

    public function getAuthService()
    {
        if (! $this->authservice) {
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

    public function getList()
    {
        return new JsonModel(array('message' => 'You wish!'));
    }

    public function create($cred)
    {
        if ($this->getAuthService()->hasIdentity()){
            $result = new JsonModel(array('data' => array('message' => 'Already logged in')));
            return $result;
        }

        $password = $cred['password'];
        $name = $cred['name'];

        $data = array(
            'messages' => array(),
            'status'   => 'failure'
        );

        try {
            $request = $this->getRequest();
            if ($request->isPost()) {
                //check authentication...
                $this->getAuthService()->getAdapter()
                    ->setIdentity($name)
                    ->setCredential($password);

                $result = $this->getAuthService()->authenticate();
                foreach($result->getMessages() as $message)
                {
                    //save message temporary into flashmessenger
                    $data['messages'][] = $message;
                }

                if ($result->isValid()) {
                    $data['status'] = 'success';

                    //check if it has rememberMe :
                    $this->getSessionStorage()
                        ->setRememberMe(1);
                    //set storage again
                    $this->getAuthService()->setStorage($this->getSessionStorage());

                    $this->getAuthService()->getStorage()->write($name);
                }
            }
        } catch (\Exception $e) {
            $data['messages'][] = $e->getMessage();
        }

        $result = new JsonModel(array('data' => $data));
        return $result;
    }

    public function delete($id)
    {
        $this->getSessionStorage()->forgetMe();
        $this->getAuthService()->clearIdentity();

        $result = new JsonModel(array('data' => array('message' => 'You are now logged out')));
        return $result;
    }
}