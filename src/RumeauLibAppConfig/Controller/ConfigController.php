<?php
/**
 * Created by PhpStorm.
 * User: Jean
 * Date: 09/10/2014
 * Time: 23:22
 */

namespace RumeauLibAppConfig\Controller;

use RumeauLibAppConfig\Entity\AppConfig;
use Zend\Form\Form;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Class ConfigController
 * @package RumeauLibAppConfig\Controller
 */
class ConfigController extends AbstractActionController
{
    public function indexAction()
    {
        $appConfigEvent = $this->getServiceLocator()->get('RumeauLibAppConfig\Event\AppConfigEvent');
        /**
         * @var \Zend\Form\Form $form
         */
        $form           = $appConfigEvent->loadForm();

        $url            = $this->getRequest()->getRequestUri();
        $prg            = $this->getConfigPrg($form, $url);
        if ($prg instanceof Response) {
            return $prg;
        } elseif (is_array($prg)) {
            $modelManager = $this->getServiceLocator()->get('ModelManager');
            $model        = $modelManager->get('RumeauLibAppConfig\Model\AppConfig', [new AppConfig()]);
            $result = $model->saveConfig($form, $prg);
            if ($result instanceof Response) {
                return $result;
            }
        }

        $form->prepare();

        return [
            'form' => $form,
        ];
    }

    /**
     * @param Form $form
     * @param null $url
     * @return array|bool|Response
     */
    protected function getConfigPrg(Form $form, $url = null)
    {
        if ($form->getAttribute('enctype') == 'multipart/form-data') {
            $prg = $this->fileprg($form, $url, $url != null ? true : false);
        } else {
            $prg = $this->prg($url, $url != null ? true : false);
        }

        return $prg;
    }
}
