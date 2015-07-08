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
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveIngredient(Ingredient $ingr)
    {
        $data = array(
            'name' => $ingr->name,
            'type'  => $ingr->type,
        );

        $id = (int)$ingr->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
            $id = $this->tableGateway->getLastInsertValue();
        } else {
            if ($this->getIngredient($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }

        return $id;
    }

    public function deleteIngredient($id)
    {
        $this->tableGateway->delete(array('id' => (int) $id));
    }

    public function getIngredientsByJunkfood(JunkFood $junk)
    {
        $id = $junk->junkfoodID;

        $resultSet = $this->tableGateway->getAdapter()->driver->getConnection()
            ->execute("
            SELECT * FROM ingredients
            LEFT JOIN junkfoodIngredients ON ingredients.ingrID = junkfoodIngredients.ingrID
            WHERE junkfoodIngredients.junkfoodID =
            " . $id ? $id : 0);

        return $resultSet;
    }
}