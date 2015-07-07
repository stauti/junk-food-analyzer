<?php
namespace Jfa\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Jfa\Model\JunkFood;
use Jfa\Form\JunkFoodForm;

class JunkFoodController extends AbstractActionController
{
    protected $junkFoodTable;

    public function indexAction()
    {
        return new ViewModel(array(
            'junkfoods' => $this->getJunkFoodTable()->fetchAll(),
            'types'     => $this->getJunkFoodTable()->getTypes(),
        ));
    }

    public function addAction()
    {
        $types = $this->getJunkFoodTable()->getTypes();

        $form = new JunkFoodForm($types);
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $junk = new JunkFood();
            $form->setInputFilter($junk->getInputFilter());
            $form->setData($request->getPost());

            $junk->exchangeArray($request->getPost());
            $this->getJunkFoodTable()->saveJunkFood($junk);

            // Redirect to list of albums
            return $this->redirect()->toRoute('junkfood');
        }

        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('junkfood', array(
                'action' => 'add'
            ));
        }

        // Get the JunkFood with the specified id.  An exception is thrown
        // if it cannot be found, in which case go to the index page.
        try {
            $junk = $this->getJunkFoodTable()->getJunkFood($id);
        }
        catch (\Exception $ex) {
            return $this->redirect()->toRoute('junkfood', array(
                'action' => 'index'
            ));
        }

        $form  = new JunkFoodForm();
        $form->bind($junk);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($junk->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getJunkFoodTable()->saveJunkFood($junk);

                // Redirect to list of albums
                return $this->redirect()->toRoute('junkfood');
            }
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
            return $this->redirect()->toRoute('junkfood');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getJunkFoodTable()->deleteJunkFood($id);
            }

            // Redirect to list of junkfoods
            return $this->redirect()->toRoute('junkfood');
        }

        return array(
            'id'    => $id,
            'junkfood' => $this->getJunkFoodTable()->getJunkFood($id)
        );
    }

    public function drogoAction()
    {
        $table = $this->getJunkFoodTable();

        $drogo = $table->getDrogoSugestion();

        return new ViewModel(array(
            'food' => $drogo
        ));
    }

    public function getJunkFoodTable()
    {
        if (!$this->junkFoodTable) {
            $sm = $this->getServiceLocator();
            $this->junkFoodTable = $sm->get('Jfa\Model\JunkFoodTable');
        }
        return $this->junkFoodTable;
    }
}