<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Cars for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Cars\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Cars\Form\NewCarForm as NewCarForm;
use Cars\Models\CarTable;
use Cars\Entity\Automobile;
use Cars\Models\ServiceTable;

/**
 * Handles requests of the format /cars
 *
 * @author jon
 *
 */
class CarsController extends AbstractActionController
{

    private $_yearsSinceFirstCar;

    private $_currentYear;

    private $_firstYear = 1979;

    /**
     * @var CarTable
     */
    private $carTable;

    /**
     * @var ServiceTable
     */
    private $serviceTable;

    /**
     * CarsController constructor.
     * @param CarTable $carTable
     * @param ServiceTable $serviceTable
     */
    function __construct(CarTable $carTable, ServiceTable $serviceTable)
    {
        $this->_currentYear = date('Y');
        $this->_yearsSinceFirstCar = $this->_currentYear - $this->_firstYear;
        $this->carTable = $carTable;
        $this->serviceTable = $serviceTable;
    }

    /**
     * @return ViewModel
     */
    public function indexAction()
    {
        $allcars = $this->carTable->retrieveAll();
        $total = count($allcars);

        return new ViewModel(array(
            'cars' => $allcars,
            'total' => $total,
            'years' => $this->_yearsSinceFirstCar,
            'currentyear' => $this->_currentYear,
            'firstYear' => $this->_firstYear
        ));
    }

    /**
     * @return ViewModel
     */
    public function addAction()
    {
        $transmissions = $this->carTable->transmissions();
        $bodyTypes = $this->carTable->bodyTypes();
        $makes = $this->carTable->manufacturers();

        $form = new NewCarForm($makes, $transmissions, $bodyTypes);

        $view = new ViewModel(array(
            'form' => $form
        ));

        // Disable the templating to prevent showing in full page
        $view->setTerminal(true);
        return $view;
    }

    /**
     * @return mixed
     */
    public function saveAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {

            $auto = new Automobile();
            $auto->BodyType = $_POST['bodytype'];
            $auto->Cost = $_POST['cost'];
            $auto->Cylinders = $_POST['cylinders'];
            $auto->EngineSize = $_POST['enginesize'];
            $auto->Image = $_POST['image'];
            $auto->License = $_POST['license'];
            $auto->Make = $_POST['make'];
            $auto->Model = $this->generateModelId($_POST['model']);
            $auto->ModelYear = $_POST['modelyear'];
            $dt = new \DateTime($_POST['purchased']);
            $auto->Purchased = $dt;
            $auto->Transmission = $_POST['transmission'];

            $this->addNewCarToDatastore($auto);
        }

        return $this->redirect()->toRoute('cars');
    }

    /**
     *
     */
    public function editAction()
    {
        // This is yet to be worked on
    }

    /**
     *
     */
    public function deleteAction()
    {
        // This is unlikely to ever be done
    }

    /**
     * @return \Zend\Http\Response|ViewModel
     */
    public function retrieveAction()
    {
        $id = $this->params('id');
        if ($id == null) {
            return $this->redirect()->toRoute('cars');
        }

        $car = $this->carTable->getAutomobile($id);
        $history = $this->serviceTable->retrieveHistorySingleCar($id);
        $count = count($history);
        $totalcost = $this->serviceTable->sumServiceCostForCar($id);

        $view = new ViewModel(array(
            'car' => $car,
            'service' => $history,
            'count' => $count,
            'totalcost' => $totalcost
        ));

        return $view;
    }

    /**
     * @param $modelName
     * @return int
     */
    private function generateModelId($modelName)
    {
        echo $modelName;
        $id = $this->carTable->getModelId($_POST['model']);
        return $id;
    }

    /**
     * @param Automobile $auto
     * @return string
     */
    private function addNewCarToDatastore(Automobile $auto)
    {
        $message = 'Successfully saved record';
        try {
            $this->carTable->save($auto);
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }
        return $message;
    }
}
