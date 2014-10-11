<?php
/**
 * Created by PhpStorm.
 * User: Jean
 * Date: 08/10/2014
 * Time: 23:39
 */

namespace RumeauLibAppConfig\Listener;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\Event;
use Zend\EventManager\EventManagerInterface;

/**
 * Class UpdateAppConfig
 * @package RumeauLibAppConfig\Listener
 */
class UpdateAppConfig extends AbstractListenerAggregate
{
    /**
     * Attach one or more listeners
     *
     * Implementors may add an optional $priority argument; the EventManager
     * implementation will pass this to the aggregate.
     *
     * @param EventManagerInterface $events
     *
     * @return void
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach('update.appconfig', [$this, 'onUpdateAppConfig'], 1);
    }

    public function onUpdateAppConfig(Event $e)
    {

    }
}
