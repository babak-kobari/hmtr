<?php
/**
 * Bootstrap Users Module
 *
 * @category   Application
 * @package    Users
 * @subpackage Bootstrap
 * 
 * @version  $Id$
 */
class Users_Bootstrap extends Zend_Application_Module_Bootstrap
{
    protected function _initView ()
    {
    
        $view = new Zend_View();
        $view->headLink()->appendStylesheet('/css/default/skin1.css');
        $view->headScript()->appendFile('http://cdn.jquerytools.org/1.2.7/full/jquery.tools.min.js');
        
        return $view;
    }
    
}
