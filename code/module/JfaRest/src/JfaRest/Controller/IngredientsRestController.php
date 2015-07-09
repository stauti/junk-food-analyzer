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

        $result = new JsonModel(array('data' => $data));
        return $result;
    }

    public function get($id)
    {
        try {
            $data = $this->getIngredientsTable()->getIngredient($id);
        } catch (\Exception $e) {
            return new JsonModel(array(
                'status' => 'failure',
                'message' => 'Ingredient with the ID: ' . $id . 'does not exist.',
            ));
        }

        $result = new JsonModel(array('data' => $data));
        return $result;
    }

    public function create($data)
    {
        $ingr = new Ingredient();
        $ingr->exchangeArray($data);

        try {
            $this->getIngredientsTable()->saveIngredient($ingr);
        } catch (\Exception $e) {
            return new JsonModel(array(
                'status' => 'failure',
                'message' => 'Successfully added Ingredient: ' . $ingr->ingrName,
            ));
        }

        return new JsonModel(array(
            'status' => 'success',
            'message' => 'Successfully added Ingredient: ' . $ingr->ingrName,
        ));
    }

    public function update($id, $data)
    {
        $data['id'] = $id;
        $ingr = new Ingredient();
        $ingr->exchangeArray($data);
        $ingr->ingrID = $id;

        try {
            $id = $this->getIngredientsTable()->saveIngredient($ingr);
        } catch (\Exception $e) {
            return new JsonModel(array(
                'status' => 'failure',
                'message' => 'Failed to update Ingredient with ID: ' . $id . 'please check if it exist and that your request is right',
            ));
        }

        return new JsonModel(array(
            'status' => 'success',
            'message' => 'Successfully updated Ingredient with the ID: ' . $id,
        ));
    }

    public function delete($id)
    {
        $this->getIngredientsTable()->deleteIngredient($id);

        return new JsonModel(array(
            'status' => 'success',
            'message' => 'Successfully deleted Ingredient with the ID: ' . $id,
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