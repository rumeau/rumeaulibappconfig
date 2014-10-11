<?php
/**
 * Created by PhpStorm.
 * User: Jean
 * Date: 08/10/2014
 * Time: 23:50
 */

namespace RumeauLibAppConfig\Service;

use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use DoctrineModule\Persistence\ProvidesObjectManager;
use Zend\Cache\Storage\StorageInterface;
use Zend\Cache\Exception;
use Zend\Cache\StorageFactory;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Parameters;

/**
 * Class AppConfig
 * @package RumeauLibAppConfig\Service
 */
class AppConfig implements ServiceLocatorAwareInterface,
    ObjectManagerAwareInterface
{
    use ServiceLocatorAwareTrait;
    use ProvidesObjectManager;

    /**
     * @var string
     */
    protected $entityClass = 'RumeauLibAppConfig\Entity\AppConfig';

    /**
     * @var StorageInterface
     */
    protected $cache;

    /**
     * @var
     */
    protected $appConfig;

    /**
     * @var
     */
    protected $config;

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @param array $config
     */
    public function __construct(ServiceLocatorInterface $serviceLocator, $config = [])
    {
        if (isset($config['config_entity_class'])) {
            $this->setEntityClass($config['config_entity_class']);
            unset($config['config_entity_class']);
        }

        if (isset($config['cache'])) {
            $this->setCache($config['cache']);
            unset($config['cache']);
        }

        if (isset($config['object_manager'])) {
            $this->setObjectManager($serviceLocator->get($config['object_manager']));
            unset($config['object_manager']);
        }

        $this->config = $config;

        return $this;
    }

    /**
     * @param $entityClass
     */
    public function setEntityClass($entityClass)
    {
        $this->entityClass = $entityClass;
    }

    /**
     * @return string
     */
    public function getEntityClass()
    {
        return $this->entityClass;
    }

    /**
     * @param $cache
     * @return StorageInterface
     */
    public function setCache($cache)
    {
        if ($cache instanceof StorageInterface) {
            return $cache;
        }

        $this->cache = StorageFactory::factory($cache);
    }

    /**
     * @return mixed
     */
    public function getCache()
    {
        return $this->cache;
    }

    public function getConfig($option, $default = null, $section = 'global')
    {
        /** @var $cache StorageInterface */
        $cache = $this->getCache();

        $success         = false;
        $this->appConfig = $cache->getItem($this->config['cache_key'], $success);

        if (!$this->appConfig instanceof Parameters || !$success) {
            $this->loadAppConfig();
            $cache->setItem($this->config['cache_key'], $this->appConfig);
        }

        $section = $section === null ? '' : $section . '_';
        $keyName = sprintf('%s%s',  $section, $option);

        return $this->appConfig->get($keyName, $default);
    }

    protected function loadAppConfig()
    {
        $objectManager = $this->getObjectManager();
        $configKeys    = $objectManager->getRepository($this->getEntityClass())->findAll();

        $this->appConfig = new Parameters();
        $appConfig       = [];
        /**
         * @var \RumeauLibAppConfig\Entity\AppConfig $option
         */
        foreach ($configKeys as $option) {
            $section = $option->getSection() !== null ? $option->getSection() . '_' : '';
            $keyName = $section . $option->getOption();
            if ($option->getIsSerialized() === 1) {
                $appConfig[$keyName] = unserialize($option->getValue());
            } else {
                $appConfig[$keyName] = $option->getValue();
            }
        }

        $this->appConfig = new Parameters($appConfig);
    }

    /**
     * @return bool
     */
    public function refreshConfig()
    {
        $this->appConfig = false;

        return true;
    }
}
