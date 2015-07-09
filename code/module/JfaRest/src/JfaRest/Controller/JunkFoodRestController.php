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
    protected $userTable;

    protected $userName = false;
    protected $authservice;

    public function getAuthService()
    {
        if (! $this->authservice) {
            $this->authservice = $this->getServiceLocator()
                ->get('AuthService');
        }

        return $this->authservice;
    }

    public function getList()
    {
        if ($this->getAuthService()->hasIdentity()){
            $this->userName = $this->getAuthService()->getIdentity();
        }

        $results = $this->getJunkFoodTable()->fetchAll($this->userName);
        $data = array();
        foreach($results as $result) {
            $ingredients = $this->getIngredientTable()->getIngredientsByJunkfood($result->junkfoodID);
            $calories = $result->kcal;
            $result->ingredients = array();

            foreach ($ingredients as $ingredient) {
                $calories += $ingredient['kcalPer100g'] * $ingredient['gramm'] / 100;
                $result->ingredients[] = $ingredient;
            }

            $result->kcal = $calories;

            $data[] = $result;
        }

        $result = new JsonModel(array('data' => $data));
        return $result;
    }

    public function get($id)
    {
        $data = $this->getJunkFoodTable()->getJunkFood($id);

        $result = new JsonModel(array('data' => $data));
        return $result;
    }

    public function create($data)
    {
        $userId = null;

        if ($this->getAuthService()->hasIdentity()){
            $this->userName = $this->getAuthService()->getIdentity();
            $userId = $this->getUserTable()->getUserByName($this->userName);
        }

        $data['userID'] = $userId;

        $junk = new JunkFood();
        $junk->exchangeArray($data);
        $id = $this->getJunkFoodTable()->saveJunkFood($junk);

        return new JsonModel(array(
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

    public function getUserTable()
    {
        if (!$this->userTable) {
            $sm = $this->getServiceLocator();
            $this->userTable = $sm->get('Jfa\Model\UserTable');
        }
        return $this->userTable;
    }
}