<?php

namespace HCA;

use HCA\Model\Agency;
use HCA\Model\AgencyTable;
use HCA\Model\ZipCode;
use HCA\Model\ZipCodeTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;


class Module
{
 
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'HCA\Model\AgencyTable' =>  function($sm) {
                    $tableGateway = $sm->get('AgencyTableGateway');
                    $table = new AgencyTable($tableGateway);
                    return $table;
                },
                'AgencyTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Agency());
                    return new TableGateway('agencies', $dbAdapter, null, $resultSetPrototype);
                },
                'HCA\Model\ZipCodeTable' =>  function($sm) {
                    $tableGateway = $sm->get('ZipCodeTableGateway');
                    $table = new ZipCodeTable($tableGateway);
                    return $table;
                },
                'ZipCodeTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new ZipCode());
                    return new TableGateway('zip_codes', $dbAdapter, null, $resultSetPrototype);
                },
            ),
       );
     }
}