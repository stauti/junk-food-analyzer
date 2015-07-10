<?php
namespace Jfa\Controller;

use Jfa\Controller\AbstractController;
use Zend\View\Model\ViewModel;
use Jfa\Model\User;
use Jfa\Form\UserForm;

class UserController extends AbstractController
{
    public function indexAction()
    {
        return new ViewModel(array(
            'users' => $this->getUserTable()->fetchAll(),
        ));
    }

    public function addAction()
    {
        $form = new UserForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $user = new User();
            $form->setInputFilter($user->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $user->exchangeArray($form->getData());

                // User already exists?
                $exists = $this->getUserTable()->getUserByName($user->name);


                if($exists != null)
                {
                   return $this->redirect()->toRoute('users');
                }
                else{
                    $user->exchangeArray($form->getData());
                    $this->getUserTable()->saveUser($user);
                }

                // Redirect to list of albums
                return $this->redirect()->toRoute('users');
            }
        }
        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('user', array(
                'action' => 'add'
            ));
        }

        // Get the User with the specified id.  An exception is thrown
        // if it cannot be found, in which case go to the index page.
        try {
            $user = $this->getUserTable()->getUser($id);
        }
        catch (\Exception $ex) {
            return $this->redirect()->toRoute('user', array(
                'action' => 'index'
            ));
        }

        $form  = new UserForm();

        $password = $user->password;

        $form->bind($user);
        $form->get('submit')->setAttribute('value', 'Edit');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $request->getPost();

            if (!isset($post['password']) || !$post['password']) {
                $post['password'] = $password;
            }

            $user->exchangeArray($post);

            $this->getUserTable()->saveUser($user);

            // Redirect to list of albums
            return $this->redirect()->toRoute('users');
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('users');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getUserTable()->deleteUser($id);
            }

            // Redirect to list of users
            return $this->redirect()->toRoute('users');
        }

        return array(
            'id'    => $id,
            'user' => $this->getUserTable()->getUser($id)
        );
    }
}