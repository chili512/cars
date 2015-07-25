<?php
namespace Cars\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * ServiceController
 *
 * @author
 *
 * @version
 *
 */
class ServiceController extends AbstractActionController
{

    private $serviceTable;
    
    private function setDataAccess()
    {
        $sm = $this->getServiceLocator();
        $this->serviceTable = $sm->get('Cars\Models\ServiceTable');
    }
    
    /**
     * The default action - show the home page
     */
    public function indexAction()
    {
        $this->setDataAccess();
        
        $id = $this->params('id');
        
        $serviceHistory = $this->serviceTable->retrieveHistorySingleCar($id);
        
        // TODO Auto-generated ServiceController::indexAction() default action
        return new ViewModel(array(
            'history' => $serviceHistory
        ));
    }
}