<?php

namespace HCA\Model;

use Zend\Db\TableGateway\TableGateway;

class AgencyTable
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

    public function getAgency($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveAgency(Agency $agency)
    {
        $data = array(
         'key' => $agency->value,
        );

        $id = (int) $agency->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getAgency($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Agency id does not exist');
            }
        }
     }

     public function deleteAgency($id)
     {
         $this->tableGateway->delete(array('id' => (int) $id));
     }
}