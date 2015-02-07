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
use Doctrine\ORM\EntityManager;
use Zend\Console\Request;
use Cars\Entity\Automobile;

/**
 *
 * @author jon
 *        
 */
class CarsController extends AbstractActionController
{

    /**
     * A class that uses Doctrine ORM to interact with the database
     *
     * @var CarTable
     */
    private $carTable;

    /**
     * Constructor
     */
    function __construct()
    {}

    /**
     * (non-PHPdoc)
     *
     * @see \Zend\Mvc\Controller\AbstractActionController::indexAction()
     */
    public function indexAction()
    {        
        $this->setDataAccess();
        
        $allcars = $this->carTable->retrieveAll();
        $total = count($allcars);
        
        return new ViewModel(array(
            'cars' => $allcars,
            'total' => $total
        ));
    }

    /**
     * Opens a new form to add a car
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function addAction()
    {
        $this->setDataAccess();
        
        // Create the required collections to be used in the form
        $transmissions = $this->carTable->transmissions();
        $bodyTypes = $this->carTable->bodyTypes();
        $makes = $this->carTable->manufacturers();
        
        $form = new NewCarForm($makes, $transmissions, $bodyTypes);
        
        // Declare the view object
        $view = new ViewModel(array(
            'form' => $form
        ));
        
        // Disable the templating to prevent showing in full page
        $view->setTerminal(true);
        return $view;
    }

    /**
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function saveAction()
    {
        $request = $this->getRequest();
        if ($request instanceof Request) {
            $isPost = true;
        }
        if ($request->isPost()) {
            
            $this->setDataAccess();
            $id = $this->carTable->getModelId($_POST['model']);
            
            $auto = new Automobile();
            $auto->BodyType = $_POST['bodytype'];
            $auto->Cost = $_POST['cost'];
            $auto->Cylinders = $_POST['cylinders'];
            $auto->EngineSize = $_POST['enginesize'];
            $auto->Image = $_POST['image'];
            $auto->License = $_POST['license'];
            $auto->Make = $_POST['make'];
            $auto->Model = $id;
            $auto->ModelYear = $_POST['modelyear'];
            $dt = new \DateTime($_POST['purchased']);
            $auto->Purchased = $dt;
            $auto->Transmission = $_POST['transmission'];
            
            $this->carTable->save($auto);
        }
        
        return $this->redirect()->toRoute('cars');
    }

    public function editAction()
    {}

    public function deleteAction()
    {}

    /**
     *
     * @return void
     */
    private function setDataAccess()
    {
        $sm = $this->getServiceLocator();
        $this->carTable = $sm->get('Cars\Models\CarTable');
    }
}
