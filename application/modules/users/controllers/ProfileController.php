<?php
/**
 * Users_ProfileController
 *
 * @category   Application
 * @package    Users
 * @subpackage Controller
 * @todo For login form http://designreviver.com/inspiration/100-sites-with-outstanding-login-forms/
 *
 * @version  $Id: LoginController.php 170 2010-07-26 10:56:18Z AntonShevchuk $
 */
class Users_ProfileController extends Core_Controller_Action
{
    /**
     * My profile
     */

    public function init()
    {
        parent::init();
    
        $this->view->leftbar1title='My Account';
        $this->view->leftbar1menuname='userleftmenu1';
        
//        $this->_twocolumns();
//        $this->_manager = new Users_Model_User_Manager();
    }
    
    public function indexAction()
    {
        $identity = Zend_Auth::getInstance()->getIdentity();
        $users = new Users_Model_User_Table();
        $row = $users->getById($identity->id);
        $form = new Users_Form_Users_Account(array('user_id'=>$identity->id));
        $this->view->title = 'My Account Information';
        if ($this->_request->isPost()
                && $form->isValid($this->_getAllParams())) 
        {
        
            $row->setFromArray($form->getValues());
            $row->save();
        
            //$row->login(false);
        
            $this->_helper->flashMessenger('Profile Updated');
            $this->_helper->redirector('index');
        }
        if (isset($row ))
        {
            $this->view->form= $form->populate($row->toarray());
        }
        else
        {
            $this->view->form = $form;
        }
    }
    public function personalAction()
    {
        $identity = Zend_Auth::getInstance()->getIdentity();
        $users = new Users_Model_User_Table();
        $row = $users->getById($identity->id);
        $form = new Users_Form_Users_Personal(array('user_id'=>$identity->id));
        $this->view->title = 'My Personal Information';
        if ($this->_request->isPost()
                && $form->isValid($this->_getAllParams())) 
        {
        
            $row->setFromArray($form->getValues());
            $row->save();
        
            //$row->login(false);
        
            $this->_helper->flashMessenger('Profile Updated');
            $this->render('personal');
//            $this->_helper->redirector('index');
        }
        if (isset($row ))
        {
            $this->view->form= $form->populate($row->toarray());
        }
        else
        {
            $this->view->form = $form;
        }
    }

    public function  travelpreferencesAction()
    {
        $identity = Zend_Auth::getInstance()->getIdentity();
        $user_id=$identity->id;
        $travel_preferences= new Users_Model_User_Manager();
        if (!$this->_request->isPost())
        {
            $travel_with = $travel_preferences->getusertravelinterestlist($user_id, 'Travel_With');
            $good_for = $travel_preferences->getusertravelinterestlist($user_id, 'Good_For');
            $travel_objective = $travel_preferences->getusertravelinterestlist($user_id, 'Travel_Objective');
            $this->view->title='My Travel Preferences';
            $this->view->assign ( array (
                'travel_with' => $travel_with,'good_for'=>$good_for,'Travel_Objective'=>$travel_objective ));
            $this->view->headLink()->appendStylesheet('/css/default/skin1.css');
            $this->view->headScript()->appendFile('http://cdn.jquerytools.org/1.2.7/full/jquery.tools.min.js');
            
        }
        if ($this->_request->isPost())
        {
            $rows= $this->_getAllParams();
            
            foreach ($rows['travel_with'] as $myrow)
            {
                if ($myrow['trvint_id']==null)
                {
                        unset($myrow['trvint_id']);
                        $insert=true;
                }
                else $insert=false;
                $row = new Users_Model_TravelPreferences_Table();
                if ($insert)
                {
                    $row_id=$row->insert($myrow);
                    
                }
                else 
                {
                    $where['trvint_id = ?'] = $myrow['trvint_id'];
                    $row->update($myrow, $where);
                }
            }
            foreach ($rows['good_for'] as $myrow)
            {
                if ($myrow['trvint_id']==null)
                {
                        unset($myrow['trvint_id']);
                        $insert=true;
                }
                else $insert=false;
                
                $row = new Users_Model_TravelPreferences_Table();
                if ($insert)
                {
                    $row_id=$row->insert($myrow);
                }
                else 
                {
                    $where['trvint_id = ?'] = $myrow['trvint_id'];
                    $row->update($myrow, $where);
                }
            }
            foreach ($rows['Travel_Objective'] as $myrow)
            {
                if ($myrow['trvint_id']==null)
                {
                        unset($myrow['trvint_id']);
                        $insert=true;
                }
                else $insert=false;
                
                $row = new Users_Model_TravelPreferences_Table();
                $row->setFromArray($myrow);
                if ($insert)
                {
                    $row_id=$row->insert($myrow);
                }
                else 
                {
                    $where['trvint_id = ?'] = $myrow['trvint_id'];
                    $row->update($myrow, $where);
                }
                            }
            
            $this->_helper->flashMessenger('Profile Updated');
            $this->_helper->redirector('travelpreferences');
        }
    }
    
    
    /**
     *
     */
    public function viewAction()
    {
    }

    /**
     * The default action - show the home page
     */
    public function editAction()
    {
   }
}