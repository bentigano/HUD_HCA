<?php

return array(
    'HCA' => array(
        'HUD_API' => 'http://data.hud.gov/Housing_Counselor/searchByLocation?Lat=40&Long=-70&Distance=3000&RowLimit=&Services=&Languages=',
    ),
     'controllers' => array(
         'invokables' => array(
             'HCA\Controller\Index' => 'HCA\Controller\IndexController',
             'HCA\Controller\API' => 'HCA\Controller\ApiController',
         ),
     ),
     
     'router' => array(
         'routes' => array(
             'HCA' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/HCA[/][:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'HCA\Controller\Index',
                         'action'     => 'index',
                     ),
                 ),
             ),
             'HCA-API-searchZip' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/API/searchZip[/:zip][/:limit]',
                     'constraints' => array(
                         'zip'     => '[0-9]+',
                         'limit'   => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'HCA\Controller\API',
                         'action'     => 'searchZip',
                     ),
                 ),
             ),
             'HCA-API-updateAgencies' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/API/updateAgencies',
                     'constraints' => array(
                     ),
                     'defaults' => array(
                         'controller' => 'HCA\Controller\API',
                         'action'     => 'updateAgencies',
                     ),
                 ),
             ),
             'HCA-API-getAgency' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/API/getAgency[/:id]',
                     'constraints' => array(
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'HCA\Controller\API',
                         'action'     => 'getAgency',
                     ),
                 ),
             ),
         ),
     ),
     
     'view_manager' => array(
         'template_path_stack' => array(
             'HCA' => __DIR__ . '/../view',
         ),
         'strategies' => array(
           'ViewJsonStrategy',
        ),
     ),
 );