<?php
namespace Cars\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Cars\Form\ServiceRecordForm;
use Cars\Entity\ServiceHistory;

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
            'history' => $serviceHistory,
            'count' => $count
        ));
    }

    public function addAction()
    {
        $id = $this->params('id');
        if ($id == null) {
            return $this->redirect()->toRoute('cars');
        }
        
        $form = new ServiceRecordForm($id, array(
            '1' => 'Supplier1',
            '2' => 'Supplier2'
        ));
        
        $view = new \Zend\View\Model\ViewModel(array(
            'car' => $id,
            'form' => $form
        ));
        $view->setTerminal(true);
        
        return $view;
    }

    public function saveAction()
    {
        $this->setDataAccess();
        
        $serviceHistory = new ServiceHistory();
        $serviceHistory->populate(array(
            'supplierid' => $_POST['supplierid'],
            'date' => $_POST['date'],
            'cost' => $_POST['cost'],
            'invoicenumber' => $_POST['invoicenumber'],
            'odometer' => $_POST['odometer'],
            'comments' => $_POST['comments'],
            'carid' => $_POST['carId'],
            'data' => 0
        ));
        
        $this->serviceTable->add($serviceHistory);
        
        $this->redirect()->toRoute('retrieve', array(
            'action' => 'retrieve',
            'controller' => 'cars',
            'id' => $_POST['carId']
        ));
    }
}
