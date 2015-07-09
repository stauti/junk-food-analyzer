<?php
namespace Jfa\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Jfa\Model\JunkFood;
use Jfa\Form\JunkFoodForm;

class JunkFoodController extends AbstractActionController
{
    protected $junkFoodTable;
    protected $ingredientTable;
    protected $relationTable;

    public function indexAction()
    {
        return new ViewModel(array(
            'junkfoods' => $this->getJunkFoodTable()->fetchAll(),
        ));
    }

    public function addAction()
    {
        $types = $this->getJunkFoodTable()->getTypes();

        $form = new JunkFoodForm($types, $this->getIngredientTable()->fetchAll());
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $junk = new JunkFood();
            $form->setInputFilter($junk->getInputFilter());
            $form->setData($request->getPost());

            $junk->exchangeArray($request->getPost());

            $id = $this->getJunkFoodTable()->saveJunkFood($junk);

            $post = $request->getPost();
            $data = array();

            foreach ($post['ingredients'] as $key => $value) {
                if (isset($value['selected'])) {
                    $data[] = array('ingrID' => $key, 'junkfoodID' => $id, 'gramm' => $value['gramm']);
                }
            }

            $this->getRelationTable()->saveRelation($data);

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
        $types = $this->getJunkFoodTable()->getTypes();

        $form  = new JunkFoodForm($types, $this->getIngredientTable()->fetchAll());
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

    public function getIngredientTable()
    {
        if (!$this->ingredientTable) {
            $sm = $this->getServiceLocator();
            $this->ingredientTable = $sm->get('Jfa\Model\IngredientTable');
        }
        return $this->ingredientTable;
    }

    public function getRelationTable()
    {
        if (!$this->relationTable) {
            $sm = $this->getServiceLocator();
            $this->relationTable = $sm->get('Jfa\Model\JunkFoodIngredientTable');
        }
        return $this->relationTable;
    }
}