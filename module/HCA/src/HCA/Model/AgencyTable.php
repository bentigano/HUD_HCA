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
        return $row;
    }

    public function saveAgency(Agency $agency)
    {   
        $data = get_object_vars($agency);
        unset($data['distance']); // this is not a column in the table, so remove it
        $data['last_updated'] = date("Y-m-d H:i:s"); // update the last_updated column with today's date/time
        
        if ($this->getAgency($data['id']) === false) {
            $this->tableGateway->insert($data);
        } else {
            $this->tableGateway->update($data, array('id' => $data['id']));
        }
     }

     public function deleteAllAgencies()
     {
         $this->tableGateway->delete();
     }
     
     private function getAllHousingCounselingAgencies($hudApiUrl)
     {
         $agencies = array();
         $file = file_get_contents($hudApiUrl);
 
         if ($file != false) {
            $jsonObject = json_decode($file);
         }
         return $jsonObject;
     }
     
     public function importHousingCounselingAgencies($hudApiUrl)
     {
         $this->deleteAllAgencies();
         $agencies = $this->getAllHousingCounselingAgencies($hudApiUrl);
        
         foreach ($agencies as $hudAgency) {
            $agency = new Agency();
            $agency->id = trim($hudAgency->agcid);
            $agency->name = trim($hudAgency->nme);
            $agency->address1 = trim($hudAgency->adr1);
            $agency->address2 = trim($hudAgency->adr2);
            $agency->city = trim($hudAgency->city);
            $agency->state = trim($hudAgency->statecd);
            $agency->zip = trim($hudAgency->zipcd);
            $agency->phone1 = trim($hudAgency->phone1);
            $agency->phone2 = trim($hudAgency->phone2);
            $agency->fax = trim($hudAgency->fax);
            $agency->email = trim($hudAgency->email);
            $agency->website = trim($hudAgency->weburl);
            
            $agency->mailing_address1 = trim($hudAgency->mailingadr1);
            $agency->mailing_address2 = trim($hudAgency->mailingadr2);
            $agency->mailing_city = trim($hudAgency->mailingcity);
            
            $agency->mailing_state = trim($hudAgency->mailingstatecd);
            $agency->mailing_zip = trim($hudAgency->mailingzipcd);
            $agency->parent_id = trim($hudAgency->parentid);
            
            $agency->latitude = trim($hudAgency->agc_ADDR_LATITUDE);
            $agency->longitude = trim($hudAgency->agc_ADDR_LONGITUDE);
            $agency->languages = trim($hudAgency->languages);
            
            $agency->services = trim($hudAgency->services);
            $agency->faith_based = trim($hudAgency->faithbased);
            $agency->colonias = trim($hudAgency->colonias_IND);
            $agency->migrant_workers = trim($hudAgency->migrantwkrs_IND);
            
            $agency->status = trim($hudAgency->agc_STATUS);
            $agency->source = trim($hudAgency->agc_SRC_CD);
            $agency->counseling_method = trim($hudAgency->counslg_METHOD);
            $this->saveAgency($agency);
         }
     }
}