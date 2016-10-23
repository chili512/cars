<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Cars for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Cars;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Cars\Models\CarTable;
use Cars\Models\ServiceTable;
use Cars\Controller\ServiceController;
use Cars\Controller\CarsController;

/**
 *
 * @author jon
 *        
 */
class Module implements AutoloaderProviderInterface, ServiceProviderInterface
{

    /**
     * (non-PHPdoc)
     *
     * @see \Zend\ModuleManager\Feature\AutoloaderProviderInterface::getAutoloaderConfig()
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php'
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    
                    // if we're in a namespace deeper than one level we need to fix the \ in the path
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/', __NAMESPACE__)
                )
            )
        );
    }

    /**
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     *
     * @param MvcEvent $e            
     */
    public function onBootstrap(MvcEvent $e)
    {
        // You may not need to do this if you're doing it elsewhere in your
        // application
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    /**
     * 
     * @return multitype:multitype:NULL  |\Application\Controller\IndexController|\Cars\Controller\ServiceController
     */
    public function getControllerConfig()
    {
        return array(
            'factories' => array(
                'Cars\Controller\Service' => function ($sm) {
                    $locator = $sm->getServiceLocator();
                    $serviceTable = $locator->get('Cars\Models\ServiceTable');
                    $controller = new ServiceController($serviceTable);
                    return $controller;
                },
                'Cars\Controller\Cars'=>function($sm){
                    $locator = $sm->getServiceLocator();
                    $serviceTable = $locator->get('Cars\Models\ServiceTable');
                    $carTable = $locator->get('Cars\Models\CarTable');
                    $controller = new CarsController($carTable, $serviceTable);
                    return $controller;
                }
            )
        );
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Zend\ModuleManager\Feature\ServiceProviderInterface::getServiceConfig()
     */
    public function getServiceConfig()
    {
        return array(
            'abstract_factories' => array(),
            'aliases' => array(),
            'factories' => array(
                'Cars\Models\CarTable' => function ($sm) {
                    $em = $sm->get('CarDoctrine');
                    $table = new CarTable($em);
                    return $table;
                },
                'Cars\Models\ServiceTable' => function ($sm) {
                    $em = $sm->get('CarDoctrine');
                    $table = new ServiceTable($em);
                    return $table;
                },
                'CarDoctrine' => function ($sm) {
                    $em = $sm->get('doctrine.entitymanager.orm_default');
                    return $em;
                }
            ),
            'invokables' => array(),
            'services' => array(),
            'shared' => array()
        );
    }
}
