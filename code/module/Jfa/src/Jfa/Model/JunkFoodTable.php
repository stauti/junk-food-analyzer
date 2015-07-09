<?php
namespace Jfa\Model;

use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\TableGateway;

class JunkFoodTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll($id = false)
    {
        $select = $this->tableGateway->getSql()->select()
            ->join(array('type_table' => 'junkfoodArt'), 'type_table.artID = junkfood.art', 'art');

        if ($id && $id !== true) {
            $select->where(array('junkfood.userID' => $id));
        }
        if ($id !== true) {
            $select->where(array('junkfood.userID IS NULL'));
        }

        $resultSet = $this->tableGateway->selectWith($select);

        return $resultSet;
    }

    public function getJunkFood($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveJunkFood(JunkFood $junk)
    {
        $data = array(
            'userID'        => $junk->userID,
            'name'          => $junk->name,
            'art'           => $junk->art,
            'imgPath'       => $junk->imgPath,
            'kcal'          => $junk->kcal,
            'isVeggie'      => $junk->isVeggie ? 1 : 0,
        );

        $id = (int)$junk->junkfoodID;
        if ($id == 0) {
            $this->tableGateway->insert($data);
            $id = $this->tableGateway->getLastInsertValue();
        } else {
            if ($this->getJunkFood($id)) {
                $this->tableGateway->update($data, array('junkfoodID' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }

        return $id;
    }

    public function deleteJunkFood($id)
    {
        $this->tableGateway->delete(array('id' => (int) $id));
    }

    public function getDrogoSugestion()
    {
        $rowset = $this->fetchAll();
        $data = array();

        foreach ($rowset as $row) {
            $data[] = $row;
        }

        return $data[array_rand($data)];
    }

    public function getTypes()
    {
        $data = array();

        $resultSet = $this->tableGateway->getAdapter()->driver->getConnection()
            ->execute('SELECT * FROM junkfoodArt');

        foreach ($resultSet as $result) {
            $data[$result['artID']] = $result['art'];
        }

        return $data;
    }
}