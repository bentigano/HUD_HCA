<?php

return array(
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