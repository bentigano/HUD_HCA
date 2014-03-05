<?php

namespace HCA\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class ApiController extends AbstractActionController
{
    protected $agencyTable;
    protected $zipCodeTable;
    
    public function searchZipAction()
    {
        $zip = $this->params()->fromRoute('zip', 0);
        $limit = (int)$this->params()->fromRoute('limit', 10); // default to 10
        
        $zipCodeData = $this->getZipCodeTable()->getZipCode($zip);
        if ($zipCodeData === false) {
            $this->getResponse()->setStatusCode(500);
            $result = new JsonModel(array(
            'success'=>false,
            'message' => 'Zip code not found in database.',
            ));
            return $result;
        }
        
        $result = new JsonModel(array(
        'success'=>true,
        'agencies' => $this->getClosestAgencies($zipCodeData->latitude, $zipCodeData->longitude, $limit),
        ));
        
        return $result;
    }
    
    public function updateAgenciesAction()
    {
        $config = $this->getServiceLocator()->get('Config');
        $hudApiUrl = $config['HCA']['HUD_API'];
        $this->getAgencyTable()->importHousingCounselingAgencies($hudApiUrl);
        $result = new JsonModel(array(
        'success'=>true,
        'message' => 'HUD housing counseling agencies have been updated.',
        ));
        
        return $result;
    }
    
    /**
     * Returns the TableGateway for the agencies table.
     * 
     * @access private
     * @return Zend\Db\TableGateway\TableGateway TableGateway for the agencies table
     */
    private function getAgencyTable()
    {
        if (!$this->agencyTable) {
            $sm = $this->getServiceLocator();
            $this->agencyTable = $sm->get('HCA\Model\AgencyTable');
        }
        return $this->agencyTable;
    }
    
    
    /**
     * Returns the TableGateway for the zip_codes table.
     * 
     * @access private
     * @return Zend\Db\TableGateway\TableGateway TableGateway for the zip_codes table
     */
    private function getZipCodeTable()
    {
        if (!$this->zipCodeTable) {
            $sm = $this->getServiceLocator();
            $this->zipCodeTable = $sm->get('HCA\Model\ZipCodeTable');
        }
        return $this->zipCodeTable;
    }
    
    /**
     * Retrieves the housing counseling agencies closest to the given latitude
     * and longitude coordinates, limited to 10 or the specified number of agencies.
     * 
     * @access private
     * @param float $latitude
     * @param float $longitude
     * @param int $limit (default: 10)
     * @return array Array of housing counseling agencies.
     */
    private function getClosestAgencies($latitude, $longitude, $limit = 10)
    {
        $agencies = $this->getAgencyTable()->fetchAll();
        $closestAgencies = array();
        foreach ($agencies as $agency) {
            $agency->calculateDistance($latitude, $longitude); 
            $closestAgencies[] = $agency;
        }
        
        usort($closestAgencies, function($a, $b) {
            return $a->distance > $b->distance;
        });
        return array_slice($closestAgencies, 0, $limit);
    }
}