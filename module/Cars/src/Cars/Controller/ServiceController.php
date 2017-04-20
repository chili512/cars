<?php

namespace Cars\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Cars\Form\ServiceRecordForm;
use Cars\Entity\ServiceHistory;
use Cars\Models\ServiceTable;

/**
 * Class ServiceController
 * @package Cars\Controller
 */
class ServiceController extends AbstractActionController
{

    private $serviceTable;

    /**
     * ServiceController constructor.
     * @param ServiceTable $serviceTable
     */
    public function __construct(ServiceTable $serviceTable)
    {
        $this->serviceTable = $serviceTable;
    }

    /**
     * @return ViewModel
     */
    public function indexAction()
    {
        $serviceHistory = $this->serviceTable->retrieveAll();
        $count = count($serviceHistory);
        $totalCost = $this->serviceTable->sumAllServiceCosts();

        return new ViewModel(array(
            'history' => $serviceHistory,
            'count' => $count,
            'totalcost' => $totalCost
        ));
    }

    /**
     * @return ViewModel
     */
    public function retrieveAction()
    {
        $id = $this->params('id');
        return $this->retrieveServiceForCar($id);
    }

    /**
     * @return ViewModel
     */
    public function addAction()
    {
        $id = $this->params('id');
        if ($id == null) {
            return $this->redirect()->toRoute('cars');
        }

        $suppliers = $this->serviceTable->retrieveSuppliers();

        $form = new ServiceRecordForm($id, $suppliers);

        $view = new ViewModel(array(
            'car' => $id,
            'form' => $form
        ));
        $view->setTerminal(true);

        return $view;
    }

    /**
     *
     */
    public function saveAction()
    {
        $date = new \DateTime($_POST['date']);
        $supplierId = (int)$_POST['supplierid'];
        $carId = (int)$_POST['carId'];
        $comments = $_POST['comments'];
        $odometer = (int)$_POST['odometer'];
        $cost = (float)$_POST['cost'];
        $invoiceNumber = $_POST['invoicenumber'];

        $serviceHistory = new ServiceHistory();
        $serviceHistory->setCarId($carId);
        $serviceHistory->setComments($comments);
        $serviceHistory->setCost($cost);
        $serviceHistory->setDate($date);
        $serviceHistory->setInvoiceNumber($invoiceNumber);
        $serviceHistory->setOdometer($odometer);

        try {
            $this->serviceTable->add($serviceHistory, $supplierId);
        } catch (\Exception $e) {
            echo 'A problem occurred ' . $e->getMessage();
        }

        return $this->retrieveServiceForCar($carId);
    }

    /**
     * @return ViewModel
     */
    private function retrieveServiceForCar($id)
    {
        $serviceHistory = $this->serviceTable->retrieveHistorySingleCar($id);
        $totalCost = (double)$this->serviceTable->sumServiceCostForCar($id);
        $count = count($serviceHistory);

        return new ViewModel(array(
            'history' => $serviceHistory,
            'count' => $count,
            'total' => $totalCost
        ));
    }
}
