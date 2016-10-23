<?php
namespace Cars\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Cars\Form\ServiceRecordForm;
use Cars\Entity\ServiceHistory;
use Cars\Models\ServiceTable;

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

    /**
     * Constructor for this controller
     *
     * @param ServiceTable $serviceTable            
     */
    public function __construct(ServiceTable $serviceTable)
    {
        $this->serviceTable = $serviceTable;
    }

    /**
     * The default action - show the home page
     */
    public function indexAction()
    {
        // $this->setDataAccess();
        $serviceHistory = $this->serviceTable->retrieveAll();
        $count = count($serviceHistory);
        $totalCost = $this->serviceTable->sumAllServiceCosts();
        
        // TODO Auto-generated ServiceController::indexAction() default action
        return new ViewModel(array(
            'history' => $serviceHistory,
            'count' => $count,
            'totalcost' => $totalCost
        ));
    }

    public function retrieveAction()
    {
        $id = $this->params('id');
        
        $serviceHistory = $this->serviceTable->retrieveHistorySingleCar($id);
        $totalCost = (double) $this->serviceTable->sumServiceCostForCar($id);
        $count = count($serviceHistory);
        
        // TODO Auto-generated ServiceController::indexAction() default action
        return new ViewModel(array(
            'history' => $serviceHistory,
            'count' => $count,
            'total' => $totalCost
        ));
    }

    public function addAction()
    {
        $id = $this->params('id');
        if ($id == null) {
            return $this->redirect()->toRoute('cars');
        }
        
        $suppliers = $this->serviceTable->retrieveSuppliers();
        
        $form = new ServiceRecordForm($id, $suppliers);
        
        $view = new \Zend\View\Model\ViewModel(array(
            'car' => $id,
            'form' => $form
        ));
        $view->setTerminal(true);
        
        return $view;
    }

    public function saveAction()
    {
        $date = new \DateTime($_POST['date']);
        $supplierId = (int) $_POST['supplierid'];
        $carId = (int) $_POST['carId'];
        $comments = $_POST['comments'];
        $odometer = (int) $_POST['odometer'];
        $cost = (float) $_POST['cost'];
        $invoiceNumber = $_POST['invoicenumber'];
        
        $serviceHistory = new ServiceHistory();
        $serviceHistory->setCarId($carId);
        $serviceHistory->setComments($comments);
        $serviceHistory->setCost($cost);
        $serviceHistory->setDate($date);
        $serviceHistory->setInvoiceNumber($invoiceNumber);
        $serviceHistory->setOdometer($odometer);
        
        $this->serviceTable->add($serviceHistory, $supplierId);
        
        $url = 'cars/retrieve/' . $carId;
        
        $this->redirect()->toRoute('cars', array(
            'action' => 'retrieve',
            'id' => $carId
        ));
    }
}
