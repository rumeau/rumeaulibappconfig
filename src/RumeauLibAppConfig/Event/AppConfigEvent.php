<?php
/**
 * Created by PhpStorm.
 * User: Jean
 * Date: 10/10/2014
 * Time: 2:35
 */

namespace RumeauLibAppConfig\Event;


use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class AppConfigEvent implements EventManagerAwareInterface, ServiceLocatorAwareInterface
{
    use EventManagerAwareTrait;
    use ServiceLocatorAwareTrait;

    public function loadForm()
    {
        $serviceLocator = $this->getServiceLocator();

        $form = $serviceLocator->get('FormElementManager')->get('RumeauLibAppConfig\Form\ConfigForm');
        $elements = $form->get('configelements');

        $this->getEventManager()->trigger('load.configform', $elements, ['serviceLocator' => $serviceLocator]);

        return $form;
    }

    public function saveConfig($form, $data)
    {
        $this->getEventManager()->trigger('save.appconfig', null, ['form' => $form, 'data' => $data]);
    }

    public function updateConfig()
    {
        $serviceLocator = $this->getServiceLocator();

        $this->getEventManager()->trigger('update.appconfig', null, ['serviceLocator' => $serviceLocator]);
    }
} 