<?php
/**
 * Created by PhpStorm.
 * User: Jean
 * Date: 10/10/2014
 * Time: 1:09
 */

namespace RumeauLibAppConfig\Form;

use Zend\Form\Form;

/**
 * Class ConfigForm
 * @package RumeauLibAppConfig\Form
 */
class ConfigForm extends Form
{
    /**
     *
     */
    public function init()
    {
        $this->add([
            'type' => 'RumeauLibAppConfig\Form\Config\Elements',
            'name' => 'configelements',
            'options' => [
                'use_as_base_fieldset' => true,
            ],
        ]);

        $this->add([
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'formcsrf',
        ]);
    }
}
