<?php

/**
 * Poi ProfileController
 * 
 * @author Babak
 * @version  1
 */

class Exp_ShareexpController extends Core_Controller_Action
{
	/**
	 * The default action - show the home page
	 */
	protected $_poimodel;
	protected $_expmodel;
	

	public function init() 
	{
        
	    $this->_expmodel = new Exp_Model_Exp_Manager();
        $this->_poimodel = new Poi_Model_Poi_Manager();
	    	     
	}

    public function indexAction()
    {
        $identity = Zend_Auth::getInstance()->getIdentity();
        $form = new Exp_Form_Exp_Intro(array('exp_user_id'=>$identity));        
        $this->view->title='Let Share your Travel';
        $this->view->form = $form;
        $row=$this->_expmodel->getDbTable()->toarray();
        $row['exp_days']=1;
        $row['exp_adults']=2;
        $row['exp_childs']=0;
        $this->view->row=$row;
        
	    if ($this->_request->isPost())
        {
            $info= $this->_getAllParams();
//            $exp_id=$this->_expmodel->saveExp($info);
          $exp_id=1;          
            $Stay=$this->_setParam('intro_param', $info);
            $this->_setParam('exp_head_id',$exp_id);
            $this->_forward('shareexp');
            
        }
    }
   public function shareexpAction()
   {
       $intro_param = $this->_getParam('intro_param');
       $exp_head_id = $this->_getParam('exp_head_id');
        
       $staylist=$this->_poimodel->getPoiListbyType('Stay')->toArray();
       $eatlist=$this->_poimodel->getPoiListbyType('Eat')->toArray();
       $thingslist=$this->_poimodel->getPoiListbyType('Things')->toArray();
       $days=$this->_expmodel->getexpdaysbyhead($exp_head_id);
       if (is_null($days))
           $days=array();
      
       $this->view->stay_list=$staylist;
       $this->view->eat_list=$eatlist;
       $this->view->things_list=$thingslist;
       $this->view->days_detail=$days;
       $this->view->exp_head_id=$exp_head_id;     
       
       
       $this->view->intro_param=$intro_param;   
       $this->view->headLink()->appendStylesheet('/css/default/mb.scrollable.css');
       $this->view->headLink()->appendStylesheet('/css/default/mbExtruder.css');
       $this->view->headScript()->appendFile('https://maps.googleapis.com/maps/api/js?sensor=false');
       $this->view->headLink()->appendStylesheet('/css/default/jquery-ui-1.9.1.css');
//       $this->view->headScript()->appendFile('/js/poimarker.js');
       $this->view->headScript()->appendFile('/js/mbScrollable.js');

       $this->view->headScript()->appendFile('/js/jquery.hoverIntent.min.js');
       $this->view->headScript()->appendFile('/js/jquery.metadata.js');
       $this->view->headScript()->appendFile('/js/jquery.mb.flipText.js');
       $this->view->headScript()->appendFile('/js/mbExtruder.js');
        
   }

   public function savepoiAction()
   {
        if ($this->_request->isPost())
        {
             
            $request = $this->getRequest ();
            $row=$request->getPost ();
            if ($row['action']=='insert')
            {
                $exp_days_id=$this->_expmodel->saveDays($row);
                $this->_helper->flashMessenger('Profile Updated');
            }
            if ($row['action']=='delete')
            {
                $poi_id=$this->_expmodel->deletePoi($row);
                $this->_helper->flashMessenger('Profile Updated');
            }
        }
               
   }
	
}
