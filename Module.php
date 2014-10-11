<?php
namespace RumeauLibAppConfig;

use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use RumeauLibAppConfig\Listener\LoadConfigFormListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $event)
    {
        $app = $event->getApplication();
        /**
         * @var \Zend\EventManager\EventManager $em
         */
        $em  = $app->getEventManager();

        $em->attachAggregate(new LoadConfigFormListener());
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getFormElementConfig()
    {
        return [
            'initializers' => [
                'ObjectManager' => function($instance, $formElementManager) {
                    $serviceLocator = $formElementManager->getServiceLocator();
                    if ($instance instanceof ObjectManagerAwareInterface) {
                        $instance->setObjectManager($serviceLocator->get('doctrine.entitymanager.orm_default'));
                    }
                    return $instance;
                },
            ],
        ];
    }
}
