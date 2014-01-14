<?php

namespace HCA\Model;

use Zend\Db\TableGateway\TableGateway;

class ZipCodeTable
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

    public function getZipCode($zip)
    {
        $zip  = $zip;
        $rowset = $this->tableGateway->select(array('zip_code' => $zip));
        $row = $rowset->current();
        return $row;
    }

    public function saveZipCode(ZipCode $zipCode)
    {
        $data = array(
         'key' => $zipCode->value,
        );

        $zip = $zipCode->zip_code;
        if ($zip == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getAgency($zip)) {
                $this->tableGateway->update($data, array('zip_code' => $zip));
            } else {
                throw new \Exception('Zip Code id does not exist');
            }
        }
     }

     public function deleteZipCode($zip)
     {
         $this->tableGateway->delete(array('zip_code' => (int) $zip));
     }
}