<?php
/**
 * Created by PhpStorm.
 * User: Jean
 * Date: 10/10/2014
 * Time: 1:18
 */

namespace RumeauLibAppConfig\Form\Config;

use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use DoctrineModule\Persistence\ProvidesObjectManager;
use RumeauLibAppConfig\Entity\AppConfig;
use RumeauLibAppConfig\Stdlib\Hydrator\ConfigHydrator;
use Zend\Form\Fieldset;

/**
 * Class Elements
 * @package RumeauLibAppConfig\Form\Config
 */
class Elements extends Fieldset implements ObjectManagerAwareInterface
{
    use ProvidesObjectManager;

    public function init()
    {
        $this->setHydrator(new ConfigHydrator($this->getObjectManager()));
        $this->setObject(new AppConfig());
    }
}
