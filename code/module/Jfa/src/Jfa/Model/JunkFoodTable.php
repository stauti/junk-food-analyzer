<?php
namespace Jfa\Model;

use Zend\Db\TableGateway\TableGateway;

class JunkFoodTable
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
            'JFNAME' => $junk->name,
            'JFArt'  => $junk->type,
            //todo weitere Felder
        );

        $id = (int)$junk->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
            $id = $this->tableGateway->getLastInsertValue();
        } else {
            if ($this->getJunkFood($id)) {
                $this->tableGateway->update($data, array('id' => $id));
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
}