<?php

namespace CrunchyProfile;

use Zend\ModuleManager\ModuleManager,
    Zend\EventManager\StaticEventManager;

class Module
{

    public function getServiceConfig()
    {
        return array(
        	'invokables' => array(
		        // defining it as invokable here, any factory will do too
		        'crunchy_image_service' => 'Imagine\Gd\Imagine',
		    ),
            'factories' => array(
                'crunchyprofile_module_options' => function ($sm) {
                    $config = $sm->get('Configuration');
                    return new Options\ModuleOptions($config['crunchy-profile']);
                },
                'CrunchyProfile\Service\Profile' => function($sm) {
                    $obj = new Service\Profile($sm->get('crunchyprofile_module_options'));
                    return $obj;
                },
                'crunchyprofile_profile_service' => function($sm) {
                    $obj = new Service\Profile();
                    $obj->setServiceLocator($sm);
                    $obj->setMapper($sm->get('crunchyprofile_profile_mapper'));
                    $obj->setAuthService($sm->get('zfcuser_auth_service'));
                    $obj->setProfileFieldsOptions($sm->get('crunchyprofile_module_options'));
                    return $obj;
                },
                'crunchyprofile_profile_mapper' => function($sm) {
                    $mapperObj = new Mapper\Profile();
                    $mapperObj->setDbAdapter($sm->get('zfcuser_zend_db_adapter'));
                    $mapperObj->setEntityPrototype(new Entity\Profile());
                    return $mapperObj;
                },
                'crunchy_profile_form' => function($sm) {
                    $obj = new Form\Profile($sm->get('crunchyprofile_profile_service'));
                    return $obj;
                },
            )
        );
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig($env = NULL)
    {
        return include __DIR__ . '/config/module.config.php';
    }
}
