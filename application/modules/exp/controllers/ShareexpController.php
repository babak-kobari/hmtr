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
        $this->_parammodel = new Users_Model_Param_Table();
        $this->_identity = Zend_Auth::getInstance()->getIdentity()->id;
        
	    	     
	}

    public function indexAction()
    {
        try {
            $filterArray= array();
            $user_id=$this->_identity;
            $temp_array = array();
            $temp_array= $this->_parammodel->getParamList('Gen','Country')->toArray();
            $countris=$temp_array;
            foreach ($temp_array as $key=>$value)
            {
                $countris_array[$value['param_id']]=$value['param_category_desc'];
            }
            unset($temp_array);
            $temp_array= $this->_parammodel->getParamList('Gen','Travel_Objective')->toArray();
            foreach ($temp_array as $key=>$value)
            {
                $travel_objective[$value['param_id']]=$value['param_category_desc'];
            }
            
            unset($temp_array);
            $temp_array= $this->_parammodel->getParamList('Gen','Travel_With')->toArray();
            foreach ($temp_array as $key=>$value)
            {
                $travel_with[$value['param_id']]=$value['param_category_desc'];
            }
            
            $user_countries=$this->_expmodel->getexpcountriesbyuser($user_id,$countris);
            
            
            
            $this->view->countries = $user_countries;
        	$this->view->travel_with = $travel_with;
        	$this->view->travel_objectives = $travel_objective;
        	$this->view->totalWIP = $this->_expmodel->gettotalWIP($user_id);
        	$this->view->resultSet = $this->_expmodel->getexpdetail($user_id,$filterArray,$countris_array,$travel_with,$travel_objective);
        	//echo "<pre>";print_r($this->view->resultSet);exit;
        	$this->view->headLink()->appendStylesheet('/css/default/jquery-ui-1.9.1.css');
        	$this->view->headScript()->appendFile('/js/gridview.js');
        	 
        }catch (Exception $e) {
        	throw new Exception($e->getMessage());
        }
    	
    }
    public function applyfilterAction () {
    	$this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
    	$request = $this->getRequest();
    	if ($request->isXmlHttpRequest()) {
    	    $user_id=$this->_identity;
    	    $temp_array = array();
    	    $temp_array= $this->_parammodel->getParamList('Gen','Country')->toArray();
    	    foreach ($temp_array as $key=>$value)
    	    {
    	        $countris[$value['param_id']]=$value['param_category_desc'];
    	    }
    	    unset($temp_array);
    	    $temp_array= $this->_parammodel->getParamList('Gen','Travel_Objective')->toArray();
    	    foreach ($temp_array as $key=>$value)
    	    {
    	        $travel_objective[$value['param_id']]=$value['param_category_desc'];
    	    }
    	    
    	    unset($temp_array);
    	    $temp_array= $this->_parammodel->getParamList('Gen','Travel_With')->toArray();
    	    foreach ($temp_array as $key=>$value)
    	    {
    	        $travel_with[$value['param_id']]=$value['param_category_desc'];
    	    }
    	    	
    	    $resultSet = $this->_expmodel->getexpdetail($user_id,$request->getParams(),$countris,$travel_with,$travel_objective);
    		$responseString = "<tr><td colspan='17' align='center'>No Data Found !!!!</td></tr>";
    		if(count($resultSet) > 0 ) {
    			$responseString ="";
    			$slno = 1;
    			foreach ($resultSet as $result) {
	  				$responseString .= "<tr>";
	  				$responseString .= "<td>".($result['exp_title'])."</td>";
	  				$responseString .= "<td>".($result['country_name'])."</td>";
	  				$responseString .= "<td>".($result['exp_mount'])."</td>";
	  				
	  				$responseString .= "<td>".($result['exp_days'])."</td>";
	  				
	  				$responseString .= "<td>".($result['travel_With'])."</td>";
	  				$responseString .= "<td>".($result['travel_Objective'])."</td>";
	  				$responseString .= "<td>".($result['exp_total_cost'])."</td>";
	  				$responseString .= "<td>".($result['exp_status'])."</td>";
	  				$responseString .= "<td>";
	  				if ($result['exp_status'] == 'WIP'){
	  					
	  						$responseString.= "<a href='shareexp/tripsummary/".$result['exp_id']."'><img src=\"/images/edit.png\" alt=\"Delete\" title = 'Edit Record' height=\"20px\"width=\"20px\"  /></a>&nbsp;";
	  							
	  				}	  				$responseString.= "<a  class = 'deleterec' href='shareexp/tripsummary/".$result['exp_id']."'><img src=\"/images/delete.png\" alt=\"Delete\" title = 'Delete Record' height=\"20px\"width=\"20px\"  /></a>";
	  				$responseString .="</td>";
	  				
	  			$responseString .= "</tr>";
	  		
	  			
    			}
	  			
	  			
    		}
    		
    		echo $responseString;
    	}else {
    		
    	}
    	
    }
    function gettitlesAction () {
    	$this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
    	$request = $this->getRequest();
    	if ($request->isXmlHttpRequest()) {
    		echo   json_encode($this->_expmodel->getTitles($request->getParam('term')));
    	}
    }
 
    function getcityAction () {
    	$this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
    	
    	$request = $this->getRequest();
    	if ($request->isXmlHttpRequest()) {
    		$result = json_encode($this->_expmodel->getCityNames($request->getParam('term')));
    		echo $result;
    	}
    	
    }


	public function tripsummaryAction()
    {
        $identity = $this->_identity;
	    $exp_id=$this->_getParam('exp_id');
        $this->view->title='Let Share your Travel';
        $form = new Exp_Form_Exp_Intro(array('exp_user_id'=>$identity));        
        $this->exp_id=$exp_id;		$this->view->exp_id = $exp_id;		$this->view->exp_user_id = $identity;
        if ($exp_id==0)
        {
            $row=$this->_expmodel->getDbTable()->toarray();
            $row['exp_days']=1;
            $row['exp_adults']=2;
            $row['exp_childs']=0;
            $this->view->row=$row;
            $this->view->form = $form;
        }
        else
        {
            $tripsummary = $this->_expmodel->getexpheadbyId($exp_id);
            $this->view->row=$tripsummary;            
            $this->view->form= $form->populate($tripsummary->toArray());
        }        
        
	    if ($this->_request->isPost())
        {
            $info= $this->_getAllParams();			//echo "<pre>";print_r($info);exit;
            $info['exp_user_id']=$identity;
            $this->_expmodel->savetripsummary($info);
            $Stay=$this->_setParam('intro_param', $info);
            $this->_setParam('exp_id',$exp_id);
            $this->_setParam('exp_user_id',$identity);
            
            $this->_forward('shareexp');
            
        }		
    }
   public function shareexpAction()
   {
       $intro_param = $this->_getParam('intro_param');
       $exp_id = $this->_getParam('exp_id');
       $exp_user_id = $this->_getParam('exp_user_id');
        
       $staylist=$this->_poimodel->getPoiListbyType('Stay')->toArray();
       $eatlist=$this->_poimodel->getPoiListbyType('Eat')->toArray();
       $thingslist=$this->_poimodel->getPoiListbyType('Things')->toArray();
       $days=$this->_expmodel->getexpdaysbyhead($exp_id);
       $daysummary=$this->_expmodel->getexpdaysummaryIdandDayNo($exp_id, 1);
       if (is_null($days))
           $days=array();
      
       $this->view->stay_list=$staylist;
       $this->view->eat_list=$eatlist;
       $this->view->things_list=$thingslist;
       $this->view->days_detail=$days;
       $this->view->day_summary=$daysummary;
       $this->view->exp_id=$exp_id;    
       $this->view->exp_user_id=$exp_user_id;
        
       $form = new Exp_Form_Exp_Daysummary();
        
       $this->view->form=$form;
       $this->view->intro_param=$intro_param;   
       $this->view->headLink()->appendStylesheet('/css/default/mb.scrollable.css');
       $this->view->headLink()->appendStylesheet('/css/default/mbExtruder.css');
       $this->view->headLink()->appendStylesheet('/css/default/rateit.css');
       $this->view->headScript()->appendFile('https://maps.googleapis.com/maps/api/js?sensor=false');
       $this->view->headLink()->appendStylesheet('/css/default/jquery-ui-1.9.1.css');
       $this->view->headScript()->appendFile('/js/poimarker.js');
       $this->view->headScript()->appendFile('/js/mbScrollable.js');

       $this->view->headScript()->appendFile('/js/jquery.hoverIntent.min.js');
       $this->view->headScript()->appendFile('/js/jquery.metadata.js');
       $this->view->headScript()->appendFile('/js/jquery.mb.flipText.js');
       $this->view->headScript()->appendFile('/js/mbExtruder.js');
       $this->view->headScript()->appendFile('/js/jquery.rateit.js');
        
   }
// ----------------------------
   public function savesumndfeedAction()
   {

       // read general parameters
       $row = array();
       $exppoi_param_id = array();
       $identity = $this->_identity;
       $row['exp_id'] = $this->_getParam('exp_id');
       $exp_id = $this->_getParam('exp_id');
       // read day summary parameters
       $row['exp_day_no'] = $this->_getParam('exp_day_no');
       $exp_next_day_no=$this->_getParam('exp_next_day_no');
       $row['exp_trans_type']=$this->_getParam('exp_trans_type');
       $row['exp_trans_cost']=$this->_getParam('exp_trans_cost');
       $row['exp_trans_comment']=$this->_getParam('exp_trans_comment');
       $row['exp_day_cost']=$this->_getParam('exp_day_cost');
       // read poi feed back parameters
       $exp_poi_detail=$this->_getParam('exppoi_detail');
       $exp_poi_detail=$this->_getParam('exppoi_detail');
       $exppoi_param_id = $this->_getParam('exppoi_id');
       $exppoi_param_value = $this->_getParam('exppoi_value');
       // save day summary
       if ($row['exp_trans_type']<>'' and $row['exp_trans_cost']<>'')
           $row_id=$this->_expmodel->saveDaySummary($row);
       // save poi feed back
       $i=0;
       if (!is_array($exppoi_param_id))
           $exppoi_param_id = array();
       foreach ($exppoi_param_id as $param_id)
       {
           $exppoi[$param_id]=$exppoi_param_value[$i++];
       }
       $exppoi['exp_id']=$exp_id;
       $exppoi['exp_poi_user_id']=$identity;
       if (isset($exppoi['exp_poi_title']) and isset($exppoi['exp_poi_average_cost']))
       {
           $row_id=$this->_expmodel->savepoiexp($exppoi,$exp_poi_detail);
       
       }
        
       // read day summary
       
       $new_row=$this->_expmodel->getexpdaysummaryIdandDayNo($this->_getParam('exp_id'), $exp_next_day_no);
       unset($form);
       $form = new Exp_Form_Exp_Daysummary();
       if (isset($new_row ))
           $this->view->form= $form->populate($new_row);
       else
       {
           $this->view->form = $form;
       }
//       $this->_helper->flashMessenger('Profile Updated');
       $this->view->exppoi=$exppoi;
       $this->_helper->layout->disableLayout();
        
   }
    
// ----------------------------
   public function savefeedbackAction()
   {
       $exppoi_param_id = array();
       $identity = $this->_identity;
       $exp_id = $this->_getParam('exp_id');
       $exp_poi_detail=$this->_getParam('exppoi_detail');
       $exppoi_param_id = $this->_getParam('exppoi_id');
       $exppoi_param_value = $this->_getParam('exppoi_value');
       $i=0;
       if (!is_array($exppoi_param_id))
           $exppoi_param_id = array();
       foreach ($exppoi_param_id as $param_id)
       {
           $exppoi[$param_id]=$exppoi_param_value[$i++];
       }
       $exppoi['exp_id']=$exp_id;
       $exppoi['exp_poi_user_id']=$identity;
       if (isset($exppoi['exp_poi_title']) and isset($exppoi['exp_poi_average_cost']))
       {
           $row_id=$this->_expmodel->savepoiexp($exppoi,$exp_poi_detail);
            
       }
       $this->_helper->viewRenderer->setNoRender(true);
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
   
   public function sharepoiexpAction()
   {
       $poi_id=$this->_getParam('poi_id');
       $exp_id=$this->_getParam('exp_id');
       $params=array(
               'Amenities'=>array(),
               'Dining_Options'=>array(),
               'Cuisine'=>array(),
               'Things_options'=>array(),
               'Things_activity'=>array(),
               'General_1'=>array(),
               'General_2'=>array());
       $poi_params=array(
               'Amenities'=>array(),
               'Dining_Options'=>array(),
               'Cuisine'=>array(),
               'Things_options'=>array(),
               'Things_activity'=>array(),
               'General_1'=>array(),
               'General_2'=>array());
        
       $final_params=array(
               'Amenities'=>array(),
               'Dining_Options'=>array(),
               'Cuisine'=>array(),
               'Things_options'=>array(),
               'Things_activity'=>array(),
               'General_1'=>array(),
               'General_2'=>array());
        
       $images=array();
       $thingsparam = array();
       $thingsparam['param_category_desc']='';
   
       // ----------------- Get Params Filled in
        
           $poi_row = $this->_poimodel->getPoibyId ( $poi_id );
           $row = $this->_expmodel->getpoiexpbyId($exp_id, $poi_id);
           $poi_type=$poi_row['poi_type'];
           if (isset($row))
           {
               if ($poi_type=='Stay')
               {
                   $params['Amenities']=$row->getexppoiFacl('Amenities')->toarray();
               }
               if ($poi_type=='Eat')
               {
                   $params['Dining_Options']=$row->getexppoiFacl('Dining_Options')->toarray();
                   $params['Cuisine']=$row->getexppoiFacl('Cuisine')->toarray();
               }
               if ($poi_type=='Things')
               {
                   $params['Things_options']=$row->getexppoiFacl('Things_options')->toarray();
                   $params['Things_activity']=$row->getexppoiFacl('Things_activity')->toarray();
               }
           }

           if ($poi_type=='Stay')
           {
               $poi_params['Amenities']=$poi_row->getFacl('Amenities');
           }
           if ($poi_type=='Eat')
           {
               $poi_params['Dining_Options']=$poi_row->getFacl('Dining_Options');
               $poi_params['Cuisine']=$poi_row->getFacl('Cuisine');
           }
           if ($poi_type=='Things')
           {
               $poi_params['Things_options']=$poi_row->getFacl('Things_options');
               $poi_params['Things_activity']=$poi_row->getFacl('Things_activity');
           }
                    
           foreach ($poi_params as $key=>$value)
           {
               $i=0;
               foreach ($value as $key2 => $value2)
               {
                  $final_params[$key][$key2]['exp_poi_param_id']=$value2['poifcl_param_id'];
                  $final_params[$key][$key2]['poifcl_param_category_id']=$value2['poifcl_param_category_id'];
                  $final_params[$key][$key2]['poifcl_param_category_desc']=$value2['param_category_desc'];
                  $final_params[$key][$key2]['exp_poi_param_rate']=0;
                  $final_params[$key][$key2]['exp_poi_param_comment']=null;
                  foreach ($params[$key] as $key3=>$value3)
                  {
                      if ($final_params[$key][$key2]['exp_poi_param_id']==$value3['exp_poi_param_id'])
                      {
                          $final_params[$key][$key2]['exp_poi_param_rate']=$value3['exp_poi_param_rate'];
                          $final_params[$key][$key2]['exp_poi_param_comment']=$value3['exp_poi_param_comment'];
                          
                      }
                  }
               }
           }               
           
       $form = new Exp_Form_Exp_Exppoi();
   
       if (isset($row ))
           $this->view->form= $form->populate($row->toarray());
       else
       {
           $this->view->form = $form;
       }
        
        
        
       $this->view->title = 'Your Feedback';
       $this->view->poi_id = $poi_id;
       $this->view->exp_id=$exp_id;
       $this->view->poi_type=$poi_type;
       $this->view->params=$final_params;
       $this->_helper->layout->disableLayout();
        
        
        
        
       if ($this->_request->isPost())
       {
            
           $info= $this->_getAllParams();
           $request = $this->getRequest ();
           $row=$request->getPost ();
           $poi_id=$this->_poimodel->savePoi($form, $row,$poi_id,$poi_type,$params,$images);
   
            
            
           $this->_helper->flashMessenger('Profile Updated');
           $row = $this->_poimodel->getPoibyId ( $poi_id );
           if ($poi_type=='Stay')
               $form->_setfaclvalue ($info ['poi_amenities'],'poi_amenities');
           if ($poi_type=='Eat')
           {
               $form->_setfaclvalue ($info ['poi_dining_options'],'poi_dining_options');
               $form->_setfaclvalue ($info ['Cuisine'],'Cuisine');
           }
           $a=$row->getImages()->toarray();
           $this->view->images=$a;
           $this->_helper->redirector('index');
           $this->render('generalinfo');
   
            
       }
   
   }      /*    * @author Subash    * @function deleteexp    * @use   Delete record from  share experience grid    * @date 19 March 2013    */      public function deleteexpAction () {   		$this->_helper->viewRenderer->setNoRender(true);   		$request = $this->getRequest();   		if ($request->isXmlHttpRequest()) {   			$user_id=$this->_identity;
   			
   			$temp_array = array();
   			
   			$temp_array= $this->_parammodel->getParamList('Gen','Country')->toArray();
   			
   			foreach ($temp_array as $key=>$value)
   			
   			{
   			
   				$countris[$value['param_id']]=$value['param_category_desc'];
   			
   			}
   			
   			unset($temp_array);
   			
   			$temp_array= $this->_parammodel->getParamList('Gen','Travel_Objective')->toArray();
   			
   			foreach ($temp_array as $key=>$value)
   			
   			{
   			
   				$travel_objective[$value['param_id']]=$value['param_category_desc'];
   			
   			}
   			
   			
   			unset($temp_array);
   			
   			$temp_array= $this->_parammodel->getParamList('Gen','Travel_With')->toArray();
   			
   			foreach ($temp_array as $key=>$value)
   			
   			{
   			
   				$travel_with[$value['param_id']]=$value['param_category_desc'];
   			
   			}
   			
   			
   			
   			$resultSet = $this->_expmodel->getexpdetail($user_id,$request->getParams(),$countris,$travel_with,$travel_objective);
   			
   			$responseString = "<tr><td colspan='17' align='center'>No Data Found !!!!</td></tr>";
   			
   			if(count($resultSet) > 0 ) {
   			
   				$responseString ="";
   			
   				$slno = 1;
   			
   				foreach ($resultSet as $result) {
   			
   					$responseString .= "<tr>";
   			
   					$responseString .= "<td>".($result['exp_title'])."</td>";
   			
   					$responseString .= "<td>".($result['country_name'])."</td>";
   			
   					$responseString .= "<td>".($result['exp_mount'])."</td>";
   			
   					$responseString .= "<td>".($result['exp_days'])."</td>";
   			
   					$responseString .= "<td>".($result['travel_With'])."</td>";
   			
   					$responseString .= "<td>".($result['travel_Objective'])."</td>";
   			
   					$responseString .= "<td>".($result['exp_total_cost'])."</td>";
   			
   					$responseString .= "<td>".($result['exp_status'])."</td>";
   			
   					$responseString .= "<td>";
   			
   					if ($result['exp_status'] == 'WIP'){
   			
   						$responseString.= "<a href='shareexp/tripsummary/".$result['exp_id']."'><img src=\"/images/edit.png\" alt=\"Delete\" title = 'Edit Record' height=\"20px\"width=\"20px\"  /></a>&nbsp;";
   			
   					}
   					$responseString.= "<a  class = 'deleterec' href='shareexp/tripsummary/".$result['exp_id']."'><img src=\"/images/delete.png\" alt=\"Delete\" title = 'Delete Record' height=\"20px\"width=\"20px\"  /></a>";
   			
   					$responseString .="</td>";
   			
   					$responseString .= "</tr>";
   			
   				}
   			}
   			echo $responseString;   		}else {   			
   			   		}   		   	   }   
   
}
