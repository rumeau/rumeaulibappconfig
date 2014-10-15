<?php
/**
 * Created by PhpStorm.
 * User: Jean
 * Date: 15/10/2014
 * Time: 12:33
 */

namespace RumeauLibAppConfig\Stdlib\Hydrator\Strategy;


use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use DoctrineModule\Persistence\ProvidesObjectManager;
use RumeauLibAppConfig\Entity\AppConfig as AppConfigEntity;
use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;

class AppConfigStrategy implements StrategyInterface, ObjectManagerAwareInterface
{
    use ProvidesObjectManager;

    /**
     * Converts the given value so that it can be extracted by the hydrator.
     *
     * @param mixed $value The original value.
     * @param object $object (optional) The original object for context.
     * @return mixed Returns the value that should be extracted.
     */
    public function extract($value)
    {
        // TODO: Implement extract() method.
    }

    /**
     * Converts the given value so that it can be hydrated by the hydrator.
     *
     * @param mixed $value The original value.
     * @param array $data (optional) The original data for context.
     * @return mixed Returns the value that should be hydrated.
     */
    public function hydrate($value, $data = [])
    {
        // Search for defined configuration key in DB
        $findKey = $this->objectManager->getRepository(get_class($value))->findOneBy([
            'section' => $value->getSection(),
            'option' => $value->getOption()
        ]);

        // If key exists, update it
        if ($findKey instanceof AppConfigEntity) {
            $findKey->setValue($value->getValue());
            $value = $findKey;
        }

        return $value;
    }

}
