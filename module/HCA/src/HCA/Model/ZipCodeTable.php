<?php

namespace HCA\Model;

use Zend\Db\TableGateway\TableGateway;

/**
 * Provides database access for retrieving zip code data.
 */
class ZipCodeTable
{
    protected $tableGateway;

    /**
     * ZipCodeTable constructor.
     * 
     * @access public
     * @param TableGateway $tableGateway
     * @return void
     */
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * Returns all zip code records.
     * 
     * @access public
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    /**
     * Returns the data for a given zip code.
     * 
     * @access public
     * @param mixed $zip
     * @return \ArrayObject
     */
    public function getZipCode($zip)
    {
        $zip  = $zip;
        $rowset = $this->tableGateway->select(array('zip_code' => $zip));
        $row = $rowset->current();
        return $row;
    }
}