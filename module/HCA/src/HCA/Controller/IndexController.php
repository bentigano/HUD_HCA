<?php

namespace HCA\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    protected $agencyTable;
	protected $zipCodeTable;
    
    public function indexAction()
    {
        return new ViewModel();
    }
    
    public function usageAction()
    {
        return new ViewModel();
    }
	
	public function checkSystemAction()
    {
		$results = array();
		
		// check database connection
		try {
			$this->getAgencyTable()->fetchAll()->count();
			$results['DB'] = array('result' => true, 'message' => 'Successfully connected to database!');
		} catch (\Exception $e) {
			$results['DB'] = array('result' => false, 'message' => 'Unable to access the database. Please check your configuration.');
		}
		
		// ensure all required tables exist
		try {
			$count = $this->getAgencyTable()->fetchAll()->count();
			$results['TBL_AGENCIES'] = array('result' => true, 'message' => 'Successfully queried agencies table in database!');
			if ($count > 0) {
				$results['TBL_AGENCIES_COUNT'] = array('result' => true, 'message' => 'Data successfully found in agencies table!');
			} else {
				$results['TBL_AGENCIES_COUNT'] = array('result' => false, 'message' => 'There is no data in the agencies table. Please import agency data from HUD.');
			}
		} catch (\Exception $e) {
			$results['TBL_AGENCIES'] = array('result' => false, 'message' => 'Unable to access the agencies table. Please check your database schema.');
		}
		
		try {
			$count = $this->getZipCodeTable()->fetchAll()->count();
			$results['TBL_ZIPS'] = array('result' => true, 'message' => 'Successfully queried zip_codes table in database!');
			if ($count > 0) {
				$results['TBL_ZIPS_COUNT'] = array('result' => true, 'message' => 'Data successfully found in zip_codes table!');
			} else {
				$results['TBL_ZIPS_COUNT'] = array('result' => false, 'message' => 'There is no data in the zip_codes table. Please import all zip code data.');
			}
		} catch (\Exception $e) {
			$results['TBL_ZIPS'] = array('result' => false, 'message' => 'Unable to access the zip_codes table. Please check your database schema.');
		}
		
        $view = new ViewModel($results);
        return $view;
    }
    
    /**
     * Returns the TableGateway for the agencies table.
     * 
     * @access private
     * @return Zend\Db\TableGateway\TableGateway TableGateway for the agencies table
     */
    public function getAgencyTable()
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
}