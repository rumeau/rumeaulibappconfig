<?php
/**
 * Created by PhpStorm.
 * User: Jean
 * Date: 10/10/2014
 * Time: 2:13
 */

namespace RumeauLibAppConfig\Listener;

use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;

class LoadConfigFormListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->getSharedManager()->attach(
            'RumeauLibAppConfig\Event\AppConfigEvent',
            'load.configform',
            array($this, 'load'),
            100
        );
    }

    public function load(EventInterface $event)
    {
        $elements = $event->getTarget();
        $serviceLocator = $event->getParam('serviceLocator');

        $config = $serviceLocator->get('Config');
        $appConfigForms = $config['rumeaulib_appconfig']['forms'];

        foreach ($appConfigForms as $key => $fieldset) {
            $elements->add([
                'type' => $fieldset,
                'name' => $key
            ]);
        }
    }
} 