<?php
namespace Jfa\Model;

use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\TableGateway;

class JunkFoodIngredientTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function saveRelation(array $data, $junkfoodId = null)
    {
        if ($junkfoodId) {
            $this->tableGateway->delete("junkfoodID = {$junkfoodId}");
        }

        foreach ($data as $entry) {
            $this->tableGateway->insert($entry);
            $this->tableGateway->getLastInsertValue();
        }

        return;
    }
}