<?php
namespace JfaRest\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;

use Jfa\Model\JunkFood;
use Jfa\Form\JunkFoodForm;
use Jfa\Model\JunkFoodTable;
use Zend\View\Model\JsonModel;

class JunkFoodRestController extends AbstractRestfulController
{
    protected $junkFoodTable;
    protected $ingredientTable;
    protected $relationTable;

    public function getList()
    {
        $results = $this->getJunkFoodTable()->fetchAll();
        $data = array();
        foreach($results as $result) {
            $data[] = $result;
        }

        $result = new \Zend\View\Model\JsonModel(array('data' => $data));
        return $result;
    }

    public function get($id)
    {
        $data = $this->getJunkFoodTable()->getJunkFood($id);

        $result = new \Zend\View\Model\JsonModel(array('data' => $data));
        return $result;
    }

    public function create($data)
    {
        $junk = new JunkFood();
        $junk->exchangeArray($data);
        $id = $this->getJunkFoodTable()->saveJunkFood($junk);

        return new \Zend\View\Model\JsonModel(array(
            'data' => 'Successfully saved with ID: ' . $id,
        ));
    }

    public function update($id, $data)
    {
        $data['id'] = $id;
        $junk = $this->getJunkFoodTable()->getJunkFood($id);
        $id = $this->getJunkFoodTable()->saveJunkFood($junk);

        return new JsonModel(array(
            'data' => 'Successfully updated ' . $junk->type . ' with ID: ' . $id,
        ));
    }

    public function delete($id)
    {
        $this->getJunkFoodTable()->deleteJunkFood($id);

        return new JsonModel(array(
            'data' => 'deleted',
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