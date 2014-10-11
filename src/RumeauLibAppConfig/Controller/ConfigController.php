<?php
/**
 * Created by PhpStorm.
 * User: Jean
 * Date: 09/10/2014
 * Time: 23:22
 */

namespace RumeauLibAppConfig\Controller;


use RumeauLibAppConfig\Event\AppConfigEvent;
use Zend\Mvc\Controller\AbstractActionController;

class ConfigController extends AbstractActionController
{
    public function indexAction()
    {
        $appConfigEvent = $this->getServiceLocator()->get('RumeauLibAppConfig\Event\AppConfigEvent');
        $form           = $appConfigEvent->loadForm();

        return [
            'form' => $form,
        ];
    }
}
