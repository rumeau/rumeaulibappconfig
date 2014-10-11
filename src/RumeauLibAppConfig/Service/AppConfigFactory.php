<?php
/**
 * Created by PhpStorm.
 * User: Jean
 * Date: 08/10/2014
 * Time: 23:50
 */
namespace RumeauLibAppConfig\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class AppConfigFactory
 * @package RumeauLibAppConfig\Service
 */
class AppConfigFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed|AppConfig
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        $appConfigConfiguration = isset($config['rumeaulib_appconfig']) ? $config['rumeaulib_appconfig'] : [];

        $service = new AppConfig($serviceLocator, $appConfigConfiguration);

        return $service;
    }

} 