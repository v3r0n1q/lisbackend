<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace LisAuth;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use LisAuth\Service\LisRegisterService;
use LisAuth\Service\LisAuthService;

/**
 * @author Sander Mets <sandermets0@gmail.com>
 */
class Module
{

    /**
     * 
     * @return string
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * 
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ],
            ],
        ];
    }

    /**
     * 
     * @param MvcEvent $e
     */
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $eventManager->attach('render', [$this, 'registerJsonStrategy'], 100);
    }

    /**
     * http://stackoverflow.com/questions/18880988/zend-framework-2-restful-web-service-template-error
     * 
     * @param MvcEvent $e The MvcEvent instance
     * @return void
     */
    public function registerJsonStrategy(MvcEvent $e)
    {
//        $matches = $e->getRouteMatch();
//        $controller = $matches->getParam('controller');
//        if (false === strpos($controller, __NAMESPACE__)) {
//            // not a controller from this module
//            return;
//        }
//
//        // Potentially, you could be even more selective at this point, and test
//        // for specific controller classes, and even specific actions or request
//        // methods.
//        // Set the JSON model when controllers from this module are selected
//        $model = $e->getResult();
//
//        if ($model instanceof ViewModel) {
//            $newModel = new JsonModel($model->getVariables());
//            //$e->setResult($newModel);
//            $e->setViewModel($newModel);
//        }
    }

    /**
     * 
     * @return array
     */
    public function getServiceConfig()
    {
        return [
            'factories' => [
                'lisregister_service' => function ($sm) {
                    return (new LisRegisterService)->setEntityManager(
                        $sm->get('doctrine.entitymanager.orm_default')
                    );
                },
                'lisauth_service' => function ($sm) {
                    return (new LisAuthService)->setEntityManager(
                        $sm->get('doctrine.entitymanager.orm_default')
                    );
                },
            ],
        ];
    }

}
