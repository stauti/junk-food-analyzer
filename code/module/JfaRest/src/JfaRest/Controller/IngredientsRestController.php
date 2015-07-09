<?php
namespace JfaRest\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;

use Jfa\Model\Ingredient;
use Jfa\Form\IngredientForm;
use Jfa\Model\IngredientTable;
use Zend\View\Model\JsonModel;

class IngredientsRestController extends AbstractRestfulController{

    protected $ingredientsTable;

    public function getList()
    {
        $results = $this->getIngredientsTable()->fetchAll();
        $data = array();
        foreach($results as $result) {
            $data[] = $result;
        }

        $result = new \Zend\View\Model\JsonModel(array('data' => $data));
        return $result;
    }

    public function get($id)
    {
        $data = $this->getIngredientsTable()->getIngredient($id);

        $result = new \Zend\View\Model\JsonModel(array('data' => $data));
        return $result;
    }

    public function create($data)
    {
        $result = new \Zend\View\Model\JsonModel(array('data' => $data));
        return $result;
        $ingr = new Ingredient();
        $ingr->exchangeArray($data);
        $id = $this->getIngredientsTable()->saveIngredient($ingr);

        return new \Zend\View\Model\JsonModel(array(
            'data' => 'Successfully saved with ID: ' . $id,
        ));
    }

    public function update($id, $data)
    {
        $data['id'] = $id;
        $ingr = $this->getIngredientsTable()->getIngredient($id);
        $id = $this->getIngredientsTable()->saveIngredient($ingr);

        return new JsonModel(array(
            'data' => 'Successfully updated ' . $ingr->type . ' with ID: ' . $id,
        ));
    }

    public function delete($id)
    {
        $this->getIngredientsTable()->deleteIngredient($id);

        return new JsonModel(array(
            'data' => 'deleted',
        ));
    }

    public function getIngredientsTable()
    {
        if (!$this->ingredientsTable) {
            $sm = $this->getServiceLocator();
            $this->ingredientsTable = $sm->get('Jfa\Model\IngredientTable');
        }
        return $this->ingredientsTable;
    }
}