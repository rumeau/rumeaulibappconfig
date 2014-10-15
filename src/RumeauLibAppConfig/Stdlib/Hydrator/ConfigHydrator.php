<?php
/**
 * Created by PhpStorm.
 * User: Jean
 * Date: 10/10/2014
 * Time: 1:53
 */

namespace RumeauLibAppConfig\Stdlib\Hydrator;


use Doctrine\Common\Collections\ArrayCollection;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;

class ConfigHydrator extends DoctrineObject
{
    /**
     * Prepare strategies before the hydrator is used
     *
     * @throws \InvalidArgumentException
     * @return void
     */
    protected function prepareStrategies()
    {
        $strategy = new Strategy\AppConfigStrategy();
        $strategy->setObjectManager($this->objectManager);

        $this->addStrategy('AppConfig', $strategy);
    }

    public function extract($object)
    {
        $this->prepare($object);

        $objectManager = $this->objectManager;
        $configKeys    = $objectManager->getRepository(get_class($object))->findAll();
        $data          = [];

        /**
         * @var \RumeauLibAppConfig\Entity\AppConfig $option
         */
        foreach ($configKeys as $option) {
            if ($option->getIsSerialized() === 1) {
                $data[$option->getSection()][$option->getOption()] = unserialize($option->getValue());
            } else {
                $data[$option->getSection()][$option->getOption()] = $option->getValue();
            }
        }

        return $data;
    }

    public function hydrate(array $data, $object)
    {
        $this->prepare($object);

        /**
         * @var \RumeauLibAppConfig\Entity\AppConfig $appConfig
         */
        $appConfigObject = $object;
        $object          = new ArrayCollection();

        foreach ($data as $section => $option) {
            foreach ($option as $key => $value) {
                $appConfig = clone $appConfigObject;
                $appConfig->setSection($section);
                $appConfig->setOption($key);
                if (is_array($value)) {
                    $appConfig->setIsSerialized(true);
                    $appConfig->setValue(serialize($value));
                } else {
                    $appConfig->setIsSerialized(false);
                    $appConfig->setValue($value);
                }

                $object->add($this->hydrateValue('AppConfig', $appConfig, $data));
            }
        }

        return $object;
    }
} 