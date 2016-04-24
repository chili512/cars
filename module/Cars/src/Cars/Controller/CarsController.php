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
use Cars\Form\NewCarForm;
use Cars\Models\CarTable;
use Cars\Entity\Automobile;

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
     * A class that uses Doctrine ORM to interact with the database
     *
     * @var CarTable
     */
    private $carTable;

    private $serviceTable;

    /**
     * Constructor for the CarsController class.
     * A PHP magic method
     */
    function __construct(CarTable $carTable)
    {
        $this->_currentYear = date('Y');
        $this->_yearsSinceFirstCar = $this->_currentYear - $this->_firstYear;
        $this->carTable = $carTable;
    }

    /**
     * (non-PHPdoc) Index method displays a listing of cars
     *
     * @see \Zend\Mvc\Controller\AbstractActionController::indexAction()
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
     * Opens a modal form to add a new car
     *
     * @return \Zend\View\Model\ViewModel
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
     * Processes the POST for saving a new car.
     * Returns an updated list of cars
     *
     * @return \Zend\View\Model\ViewModel
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
     * Will handle the editing of a car
     */
    public function editAction()
    {
        // This is yet to be worked on
    }

    /**
     * Will likely not be used
     */
    public function deleteAction()
    {
        // This is unlikely to ever be done
    }

    /**
     * Retrieves information about the selected car.
     * In ZF 2 use params collection to extract the querystring parameters
     *
     * @param int $id            
     */
    public function retrieveAction()
    {
        $id = $this->params('id');
        if ($id == null) {
            return $this->redirect()->toRoute('cars');
        }
        
        $car = $this->carTable->getAutomobile($id);
        $sm = $this->getServiceLocator();
        $service = $sm->get('Cars\Models\ServiceTable');
        
        $history = $service->retrieveHistorySingleCar($id);
        $count = count($history);
        $totalcost = $service->sumServiceCostForCar($id);
        
        $view = new ViewModel(array(
            'car' => $car,
            'service' => $history,
            'count' => $count,
            'totalcost' => $totalcost
        ));
        
        return $view;
    }

    /**
     * Checks the datastore to determine what id the supplied model name represents.
     * Returns the ID
     *
     * @param string $modelName            
     * @return integer
     */
    private function generateModelId($modelName)
    {
        $id = $this->carTable->getModelId($_POST['model']);
        return $id;
    }

    /**
     * Persists to the database
     *
     * @param Automobile $auto            
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
