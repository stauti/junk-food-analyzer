<?php
namespace JfaRest\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;

use Jfa\Model\JunkFood;
use Zend\View\Model\JsonModel;

class JunkFoodRestController extends AbstractRestfulController
{
    protected $junkFoodTable;
    protected $ingredientTable;
    protected $userTable;
    protected $relationTable;

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
        if ($id == 'drogo') {
            $data = $this->getJunkFoodTable()->getDrogoSugestion();
        } else {
            $data = $this->getJunkFoodTable()->getJunkFood($id);
        }

        $result = new JsonModel(array('data' => $data));
        return $result;
    }

    public function create($data)
    {
        $userId = null;

        if ($this->getAuthService()->hasIdentity()){
            $this->userName = $this->getAuthService()->getIdentity();
            $userId = $this->getUserTable()->getUserByName($this->userName);
        } else {
            return new JsonModel(array(
                'status' => 'failure',
                'message' => 'You have to log in first'
            ));
        }

        $data['userID'] = $userId;

        $junk = new JunkFood();
        $junk->exchangeArray($data);
        $id = $this->getJunkFoodTable()->saveJunkFood($junk);

        if (isset($data['ingredients']) && !empty($data['ingredients'])) {
            $relations = array();

            foreach ($data['ingredients'] as $ingredient) {
                $relations = array('ingrID' => $ingredient['ingrID'], 'junkfoodID' => $id, 'gramm' => $ingredient['gramm']);
            }

            $this->getRelationTable()->saveRelation($relations);
        }

        return new JsonModel(array(
            'status' => 'success',
            'message' => 'Junkfood successfully created.'
        ));
    }

    public function update($data)
    {
        if ($this->getAuthService()->hasIdentity()){
            $this->userName = $this->getAuthService()->getIdentity();
            $userId = $this->getUserTable()->getUserByName($this->userName);
        } else {
            return new JsonModel(array(
                'status' => 'failure',
                'message' => 'You have to log in first'
            ));
        }

        $junk = new JunkFood();
        $junk->exchangeArray($data);

        if ($junk->userID == $userId) {
            $this->getJunkFoodTable()->deleteJunkFood($id);

            return new JsonModel(array(
                'status' => 'success',
                'message' => "Junkfood {$junk->name} successfully deleted!"
            ));
        }

        $id = $this->getJunkFoodTable()->saveJunkFood($junk);

        if (isset($data['ingredients']) && !empty($data['ingredients'])) {
            $relations = array();

            foreach ($data['ingredients'] as $ingredient) {
                $relations = array('ingrID' => $ingredient['ingrID'], 'junkfoodID' => $id, 'gramm' => $ingredient['gramm']);
            }

            $this->getRelationTable()->saveRelation($relations);
        }

        return new JsonModel(array(
            'status' => 'success',
            'message' => "Junkfood {$junk->name} successfully updated."
        ));
    }

    public function delete($id)
    {
        if ($this->getAuthService()->hasIdentity()){
            $this->userName = $this->getAuthService()->getIdentity();
            $userId = $this->getUserTable()->getUserByName($this->userName);
        } else {
            return new JsonModel(array(
                'status' => 'failure',
                'message' => 'You have to log in first'
            ));
        }

        $junk = $this->getJunkFoodTable()->getJunkFood($id);

        if ($junk->userID == $userId) {
            $this->getJunkFoodTable()->deleteJunkFood($id);

            return new JsonModel(array(
                'status' => 'success',
                'message' => "Junkfood {$junk->name} successfully deleted!"
            ));
        }

        return new JsonModel(array(
            'status' => 'failure',
            'message' => "You may only delete your own junk!"
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

    public function getRelationTable()
    {
        if (!$this->relationTable) {
            $sm = $this->getServiceLocator();
            $this->relationTable = $sm->get('Jfa\Model\JunkFoodIngredientTable');
        }
        return $this->relationTable;
    }
}