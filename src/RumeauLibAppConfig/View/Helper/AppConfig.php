<?php
/**
 * Created by PhpStorm.
 * User: Jean
 * Date: 08/10/2014
 * Time: 23:42
 */

namespace RumeauLibAppConfig\View\Helper;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\View\Helper\AbstractHelper;
use Zend\View\HelperPluginManager;

/**
 * Class AppConfig
 * @package RumeauLibAppConfig\View\Helper
 *
 * @method HelperPluginManager getServiceLocator()
 */
class AppConfig extends AbstractHelper implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    /**
     * @param $option
     * @param null $default
     * @param string $section
     * @return mixed
     */
    public function __invoke($option, $default = null, $section = 'global')
    {
        $serviceLocator = $this->getServiceLocator()->getServiceLocator();
        /**
         * @var \RumeauLibAppConfig\Service\AppConfig $appConfig
         */
        $appConfig      = $serviceLocator->get('RumeauLibAppConfig\AppConfig');

        return $appConfig->getConfig($option, $default, $section);
    }
}
