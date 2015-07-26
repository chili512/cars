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
        $count = count($serviceHistory);
        
        // TODO Auto-generated ServiceController::indexAction() default action
        return new ViewModel(array(
            'history' => $serviceHistory, 'count'=>$count
        ));
    }

    public function addAction()
    {
        $id = $this->params('id');
        if ($id == null) {
            return $this->redirect()->toRoute('cars');
        }

        $view = new \Zend\View\Model\ViewModel(array(
            'car' => $id
        ));
        $view->setTerminal(true);
        return $view;
    }
}
