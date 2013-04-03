<?php

namespace CrunchyProfile\Service;

use ZfcBase\EventManager\EventProvider;
use Zend\ServiceManager\ServiceLocatorInterface;

abstract class ServiceAbstract extends EventProvider
{
    protected $_mapper;
    protected $_serviceLocator;
    protected $_authService;

    public function setMapper($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }

    public function getMapper()
    {
        return $this->_mapper;
    }


    public function setServiceLocator(ServiceLocatorInterface $sl)
    {
        $this->_serviceLocator = $sl;
        return $this;
    }

    public function getServiceLocator()
    {
        return $this->_serviceLocator;
    }
    /**
     * Getter for authService
     *
     * @return mixed
     */
    public function getAuthService()
    {
        return $this->_authService;
    }

    /**
     * Setter for authService
     *
     * @param mixed $authService Value to set
     * @return self
     */
    public function setAuthService($authService)
    {
        $this->_authService = $authService;
        return $this;
    }

    public function getIdentity()
    {
        if(!$this->_authService) {
            throw new Exception("Please define authService", 1);
        }

        return $this->getAuthService()->getIdentity();
    }
}