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

    /**
     * The default action - show the home page
     */
    public function indexAction()
    {
        // TODO Auto-generated ServiceController::indexAction() default action
        return new ViewModel();
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