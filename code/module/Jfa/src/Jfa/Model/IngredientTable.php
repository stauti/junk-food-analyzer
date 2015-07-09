<?php
namespace Jfa\Model;

use Zend\Db\TableGateway\TableGateway;

class IngredientTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getIngredient($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('ingrID' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveIngredient(Ingredient $ingr)
    {
        $data = array(
            'ingrName' => $ingr->ingrName,
            'kcalPer100g'  => $ingr->kcalPer100g,
            'isVeggie' => $ingr->isVeggie
        );

        $id = (int)$ingr->ingrID;
        if ($id == 0) {
            $this->tableGateway->insert($data);
            $id = $this->tableGateway->getLastInsertValue();
        } else {
            if ($this->getIngredient($id)) {
                $this->tableGateway->update($data, array('ingrID' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }

        return $id;
    }

    public function deleteIngredient($id)
    {
        $this->tableGateway->delete(array('ingrID' => (int) $id));
    }

    public function getIngredientsByJunkfood($junk)
    {
        if ($junk instanceof JunkFood) {
            $id = $junk->junkfoodID;
        } else {
            $id = $junk;
        }

        $resultSet = $this->tableGateway->getAdapter()->driver->getConnection()
            ->execute('SELECT ingredients.*, junkfoodIngredients.gramm as gramm FROM ingredients
            LEFT JOIN junkfoodIngredients ON ingredients.ingrID = junkfoodIngredients.ingrID
            WHERE junkfoodIngredients.junkfoodID =
        ' . ($id != null ? $id : 0));

    return $resultSet;
}
}