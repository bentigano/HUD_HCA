<?php

namespace HCA\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    protected $agencyTable;
    
    public function indexAction()
    {
        return new ViewModel();
    }
    
    public function usageAction()
    {
        return new ViewModel();
    }
    
    public function getAgencyTable()
    {
        if (!$this->agencyTable) {
            $sm = $this->getServiceLocator();
            $this->agencyTable = $sm->get('HCA\Model\AgencyTable');
        }
        return $this->agencyTable;
    }
}