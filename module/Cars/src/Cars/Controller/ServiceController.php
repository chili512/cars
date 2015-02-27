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
}