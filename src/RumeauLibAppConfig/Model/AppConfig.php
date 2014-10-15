<?php
/**
 * Created by PhpStorm.
 * User: Jean
 * Date: 14/10/2014
 * Time: 14:07
 */

namespace RumeauLibAppConfig\Model;

use Doctrine\Common\Collections\ArrayCollection;
use RumeauLib\Model\AbstractModel;
use Zend\Form\Form;
use Zend\Http\Response;
use Zend\Mvc\Controller\Plugin\FlashMessenger;
use RumeauLib\Model\ModelManager;

/**
 * Class AppConfig
 * @package RumeauLibAppConfig\Model
 *
 * @method ModelManager getServiceLocator()
 */
class AppConfig extends AbstractModel
{
    public function saveConfig(Form $form, $data = [])
    {
        if ($form->getAttribute('enctype') !== 'multipart/form-data') {
            $form->setData($data);
        }

        if ($form->isValid()) {
            /**
             * @var ArrayCollection $object
             */
            $object = $form->getObject();
            $batchSize = 20;
            $lastCommit = true;
            for ($i = 1; $i <= count($object); ++$i) {
                $lastCommit = false;
                $appConfig = $object->current();
                $this->getObjectManager()->persist($appConfig);
                if (($i % $batchSize) == 0) {
                    $this->getObjectManager()->flush();
                    $this->getObjectManager()->clear();
                    $lastCommit = true;
                }
                $object->next();
            }
            if (!$lastCommit) {
                $this->getObjectManager()->flush();
                $this->getObjectManager()->clear();
            }

            $flashMessenger = $this->getFlashMessenger();
            $flashMessenger->addSuccessMessage('The configuration has been saved');

            return $this->redirectResponse();
        }

        return null;
    }

    /**
     * @return FlashMessenger
     */
    protected function getFlashMessenger()
    {
        $serviceLocator = $this->getServiceLocator()->getServiceLocator();
        $pluginManager  = $serviceLocator->get('ControllerPluginManager');

        return $pluginManager->get('FlashMessenger');
    }

    protected function redirectResponse()
    {
        $serviceLocator = $this->getServiceLocator()->getServiceLocator();
        /**
         * @var \Zend\Mvc\Application $application
         */
        $application    = $serviceLocator->get('Application');
        $request        = $application->getRequest();
        $response       = $application->getResponse();

        $response->getHeaders()->addHeaderLine('Location', $request->getRequestUri());
        $response->setStatusCode(302);

        return $response;
    }
} 