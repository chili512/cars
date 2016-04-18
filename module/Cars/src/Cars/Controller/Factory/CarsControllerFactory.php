<?php
namespace Cars\Controller\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Cars\Controller\CarsController;

class CarsControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceManager = $serviceLocator->getServiceLocator();
        $carTable = $serviceManager->get('Cars\Models\CarTable');
        $controller = new CarsController($carTable);
        return $controller;
    }
}

?>