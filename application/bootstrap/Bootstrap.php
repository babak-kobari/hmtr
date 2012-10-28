<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initDefaultModuleAutoloader()
    {
        $this->_resourceLoader = new Zend_Application_Module_Autoloader (
                array (
                    'namespace' => 'Users',
                     'basePath' => APPLICATION_PATH . '/modules/users'));
        $this->_resourceLoader = new Zend_Application_Module_Autoloader (
                array (
                    'namespace' => 'Poi',
                     'basePath' => APPLICATION_PATH . '/modules/poi'));
        $this->_resourceLoader = new Zend_Application_Module_Autoloader (
                array(
                    'namespace' => 'Mail',
                    'basePath' => APPLICATION_PATH . '/modules/mail'));
        $this->_resourceLoader = new Zend_Application_Module_Autoloader (
                array(
                        'namespace' => 'Options',
                        'basePath' => APPLICATION_PATH . '/modules/options'));

    
    }
    
    
    
}
