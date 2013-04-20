<?php

/**
 * Poi ProfileController
 * 
 * @author Babak
 * @version  1
 */

class Poi_ProfileController extends Core_Controller_Action
{
	/**
	 * The default action - show the home page
	 */
	protected $_poimodel;
	
	//protected $_poiImageModel;
	private  $_totalPOIRecords = 0;
	
	private $_currentPage = 1;
	
	private $_lastPage ;
	public function init() 
	{
        $this->view->leftbar1title='Points of Interest';
        $this->view->leftbar1menuname='poileftmenu1';
        $this->_poimodel = new Poi_Model_Poi_Manager();
        $this->_parammodel = new Params_Model_Params_Manager();
       // $this->_poiImageModel = new Poi_Model_Poiimages_Table ();
        $this->view->leftbartitle='Points of Interest';
        
      	//$contextSwitch = $this->_helper->getHelper('contextSwitch');
      	//$contextSwitch->addActionContext('listajax','json')->initContext();
        
	}

	public function uploadAction()
	{
	    $table = new Poi_Model_Table32_Table();
	    $poi_table= new Poi_Model_Poi_Table();
	    $ref_table = new Params_Model_reftable_Table();
	    $poi_options= new Params_Model_Poioptions_Table();
	    $poi_facl=new Poi_Model_Poifacl_Table();
	    for ($i=1;$i<210;$i++)
	    {
	    $poi = array();
	    $row = $table->getrowbyId($i);
	    if (is_null($row))
	        continue;
	        //	        $poi['poi_id']=$row['id'];
	    $poi['poi_name']=$row['title'];
	    $poi['poi_group_name']=$row['chain_id'];
	    $poi['poi_ranking']=$row['overall_rating'];
	    $poi['poi_trip_advisor_ranking']=0;
	        $poi['poi_type']='Stay';
	        $poi['poi_sub_type']=$row['property_type_id']+1;
	    	                $poi['poi_stay_calssification']=$row['hotelstar'];
	    	                $country_id= $this->_parammodel->getcountrybyCode($row['country_code'])->toArray();
	    	                $poi['poi_country']=$country_id['country_id'];
	    	                $poi['poi_city']=$row['city_id'];
	    	                $poi['poi_area']=$row['address'];
	    	                $poi['poi_lat']=$row['latitude'];
	    	                        $poi['poi_lon']=$row['longitude'];
	    	                                $poi['poi_location_type']=1;
	        $poi['poi_web_site']='website';
	        $poi['poi_contact detail']='website';
	        $poi['poi_dining option']=null;
	        $poi['poi_halal_yn']=null;
	        $poi['poi_activity_type']=null;
	        $poi['poi_working_Time']=null;
	        $poi['poi_average_cost']=null;
	    
	    	                        $poi_id= $poi_table->insert($poi);
	    	                        $params= array();
	    	                        unset($params);
	    	                        $params= explode("|", $row['facilities']);
	    	                            foreach ($params as $param)
	    	                            {
	    	                            $new_ref = $ref_table->getnewcode($param);
	    	                            if (is_null($new_ref))
	    	                            continue;
	    	                            else $new_ref=$new_ref->toArray();
	    	                            $new_ref_id=$new_ref['new_id'];
	    	                            $param_rec=$poi_options->getparambyoldid($new_ref_id)->toArray();
	    	                            $poi_facl_row = array();
	    	                                    unset($poi_facl_row);
	    	                                            $poi_facl_row= array();
	    	                                            $poi_facl_row['poifcl_poi_id']=$poi_id;
	    	            $poi_facl_row['poifcl_param_id']=$param_rec['param_id'];
	    	            $poi_facl_row['poifcl_param_category_id']=$param_rec['poi_option_type'];
	    	            $poi_facl->insert($poi_facl_row);
	    	        }
	    
	    	    }
	    	  
	}
	
public function listajaxAction() 
	{
		$this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
	    $request = $this->getRequest();
	    
	    //echo "<pre>";print_r($request->getParams());exit;
		$criteria = array ('filterval' => $request->getParam ('filterval'));

		$totalCount = $this->_poimodel->getTotalPois($criteria);
		$totalCount = $totalCount->toArray();

		$this->_totalPOIRecords= $totalCount[0]['totalRecods'];
		$this->_lastPage = ceil($this->_totalPOIRecords/10);

		$this->view->lastPage = $this->_lastPage;
		
		$poi_page = $request->getParam ('page', 0 )+1;
		$this->view->pageno = $this->_currentPage =  $poi_page;
		
		$pois = $this->_poimodel->getPoiList ( $criteria,  $poi_page, false );
		$pois = $pois->toArray();

		$imagePath = '/uploads/';
	    if(count($pois) > 0 ){
	    	for ($count = 0; $count < count($pois);$count++) {
	    		$t =  $this->_poimodel->getDefaultImage($pois[$count]['poi_id']);
	    		if(count($t) > 0) {
	    			$pois[$count]['default_image'] = $t[0]['poiimg_path'];
	    		}else {
	    			$pois[$count]['default_image'] = "";
	    		}
	    		
	    	}
	    }
	    if (count($pois) > 0 ) {
	    	$str = "";
	    	foreach ($pois as $poi) {
	    		$str .= "<div class=\"itemlisting\">";
	    			$str .= "<ul>";
	    				$str .= "<li class=\"hotelimg\">";
	    				if($poi['default_image']){
	    					$str .= "<img src='".$imagePath.$poi['poi_id']."/".$poi['default_image']."' alt=\"no image\" height=\"160px\"width=\"155px\"/>";
	    				}else {
	    					$str .= "<img src='/images/no_image.gif' alt=\"no image\" height=\"160px\"width=\"155px\"/>";
	    				}
	    				$str .= "</li>";
	    				
	    				$str .= "<li class=\"hoteldesc\">";
	    				$str .= "<h3>".$poi['poi_name']."</h3>";
	    				$str .= "<p>".$poi['groupname']."</p>";
	    				$str .= "<p>".$poi['stayname']."</p>";
	    				$str .= "<p>".$poi['poi_area']."</p>";
	    				$str .= "<p>".$poi['poi_web_site']."</p>";
	    				$str .= "<p> <a href='/poi/profile/generalinfo/".$poi['poi_id']."' class ='testaj'>Edit</a></p>";
	    				$str .="</li></ul></div>";
	    	}
	    	if ($this->_currentPage < $this->_lastPage) {
	    		
	    		
	    	}
	    	$data = array();
	    	$data['error'] = 'false';
	    	$data['currentpage'] = $this->_currentPage;
	    	$data['lastpage'] = $this->_lastPage;
	    	$data['data'] = $str;
	    	echo json_encode($data);exit;
	    }else {
	    	$data = array();
	    	$data['error'] = 'true';
	    	$data['currentpage'] = $this->_currentPage;
	    	$data['lastpage'] = $this->_lastPage;
	    	echo json_encode($data);exit;
	    }
	}


	public function findplacetypeAction()
	{
	    $this->_helper->layout()->disableLayout();
	    $this->_helper->viewRenderer->setNoRender(true);
	    $request = $this->getRequest();
	    if($request->getParam ('google_place_type') == '') {
	    	echo json_encode("false");
	    }else {
	    	$google_place_types=explode(",", $request->getParam ('google_place_type'));
	    	 
	    	 
	    	$sw = false;
	    	foreach ($google_place_types as $google_place_type)
	    	{
	    		$place = $this->_parammodel->gettypebygooglecode($google_place_type);
	    		if(isset($place)) {
	    			$place = $place->toArray();
	    		}
	    		if (isset($place['place_type']))
	    		{
	    			$sw = true;
	    			break;
	    		}
	    	}
	    	$google_place_type=str_replace("_", " ", $google_place_type);
    	    $place_subtype=$this->_parammodel->getPoiParambydesc($google_place_type);
	    	if (isset($place_subtype))
	    	    $place_subtype=$place_subtype->toArray();
            $data = array();
	    	if ($sw)
	    	{
                $data['error'] = 'false';
	    	    $data['placetype'] = $place['place_type'];
	    	    $data['placesubtype'] = $place_subtype['param_id'];
	    	}
	    	else
	    	    $data['error'] = 'true';
	    	    
	    	echo json_encode($data);exit;
	    	
	    	}
	    }
	
	public function indexAction() 
	{
		
		$request = $this->getRequest();
		$criteria = array ();
		$addnew_staysearch = $request->getParam('addnew_staysearch');
		$totalCount = $this->_poimodel->getTotalPois($criteria);
		$totalCount = $totalCount->toArray();

		$this->_totalPOIRecords= $totalCount[0]['totalRecods'];
		$this->_lastPage = ceil($this->_totalPOIRecords/10);
		$this->view->lastPage = $this->_lastPage;
		
		$this->view->pageno = $this->_currentPage;
		
		$poipage = $request->getParam ('page', 0 )+1;
		
	    $this->view->pageno = $this->_currentPage =  $poipage;

	    $pois = $this->_poimodel->getPoiList ( $criteria,$poipage , false );
	    $pois = $pois->toArray();
	    
	    if(count($pois) > 0 ){
	    	for ($count = 0; $count < count($pois);$count++) {
	    		$t =  $this->_poimodel->getDefaultImage($pois[$count]['poi_id']);
	    		if(count($t) > 0) {
	    			$pois[$count]['default_image'] = $t[0]['poiimg_path'];
	    		}else {
	    			$pois[$count]['default_image'] = "";
	    		}
	    		
	    	}
	    }
	    $this->view->pois = $pois;
	    //echo "<pre>";print_r($pois);exit;
/* to be removed as we dont use paginator any more 
	    
	    $paginator = Zend_Paginator::factory($pois);
	    $paginator->setCurrentPageNumber($this->getRequest ()->getParam ( 'page', 1 ));
	    $paginator->setItemCountPerPage(10);
	    if ($request->isXmlHttpRequest()) {
	    	$this->_helper->layout()->disableLayout();
    		$this->_helper->viewRenderer->setNoRender(true);
	    }else {
	    	//var_dump($paginator);exit;
	    	 $this->view->paginator = $paginator;
	    	 $this->view->assign ( array ('pois' => $pois));
	    }
*/	   
        
	}
	
	
	
	
	
	public function thngsparamAction()
	{
	    $poi_id=$this->_getParam('id');
	    $param_id=$this->_getParam('param_id');
	    $params=array(
	            'Things_Options'=>array(),
	            'Activity_Type'=>array());
	    if (!$poi_id=='undefined')
	    {
	        $params['Things_Options']=$this->_poimodel->getpoifact($poi_id, 'Things_Options');
	        $params['Activity_Type']=$this->_poimodel->getpoifact($poi_id, 'Activity_Type');
	    }
	    $facl_value = array();
	    foreach ($params as $key => $value)
	    {
	        $facl_temp = array();
	        foreach ($value as $key2 => $value2)
	        {
	            $facl_temp=array_merge($facl_temp,explode(' ',$value2['poifcl_param_id']));
	        }
	        $facl_value[$key]=$facl_temp;
	    }
	    
	     
	    $form = new Poi_Form_Poi_Things(array('poi_sub_type' => $param_id));
	    $this->view->form = $form;
	    $form->_setfaclvalue ($facl_value['Things_Options'],'poi_things_options');
        $form->_setfaclvalue ($facl_value['Activity_Type'],'poi_things_activity');
	    $this->_helper->layout->disableLayout();
	    $this->render('poithingsparams');
        	}


        public function addnewAction () {
            $request = $this->getRequest();
            $param = $this->checkParamValid($request->getParam('cookie'));
            if (isset($param) and !is_null($param) and $param!="")
                {
                   $request->setParam("cookie", $this->checkParamValid($request->getParam('cookie')));
                   $request->setParam("cookie_path", $this->checkParamValid($request->getParam('cookie_path')));
                }
                unset($param);
            $param = $this->checkParamValid($request->getParam('place_name'));
            if (isset($param) and !is_null($param) and $param!="")
                {
                   $request->setParam("poi_name", $this->checkParamValid($request->getParam('place_name')));
                }
                unset($param);
                $param = $this->checkParamValid($request->getParam('website'));
                if (isset($param) and !is_null($param) and $param!="")
                {
                    $request->setParam("poi_web_site", $this->checkParamValid($request->getParam('website')));
                }
                unset($param);
                $param = $this->checkParamValid($request->getParam('place_phone'));
                if (isset($param) and !is_null($param) and $param!="")
                
                   {
                    $request->setParam("poi_contact_detail", $this->checkParamValid($request->getParam('place_phone')));
                   }                    
                unset($param);
                $param = $this->checkParamValid($request->getParam('country'));
                if (isset($param) and !is_null($param) and $param!="")
                {
                    $poi_country_code = $this->checkParamValid($request->getParam('country'));
                    $poi_country_id = $this->_parammodel->getcountrybyCode($poi_country_code);
                    if (isset($poi_country_id ))
                        $poi_country_id = $poi_country_id->toArray();
                    $request->setParam("poi_country",$poi_country_id['country_id'] );
                }
                unset($param);
                $param = $this->checkParamValid($request->getParam('locality'));
                if (isset($param) and !is_null($param) and $param!="")
                            {
                    $request->setParam("poi_city", $this->checkParamValid($request->getParam('locality')));
                }
                unset($param);
                $param = $this->checkParamValid($request->getParam('poititle'));
                if (isset($param) and !is_null($param) and $param!="")
            
                {
                    $request->setParam("poi_area", $this->checkParamValid($request->getParam('poititle')));
                }
                unset($param);
                $param = $this->checkParamValid($request->getParam('lat'));
                if (isset($param) and !is_null($param) and $param!="")
            
                {
                    $request->setParam("poi_lat", $this->checkParamValid($request->getParam('lat')));
                }
                unset($param);
                $param = $this->checkParamValid($request->getParam('lon'));
                if (isset($param) and !is_null($param) and $param!="")
                
                {
                    $request->setParam("poi_lon", $this->checkParamValid($request->getParam('lon')));
                }
                unset($param);
                $param = $this->checkParamValid($request->getParam('type'));
                if (isset($param) and !is_null($param) and $param!="")
            
                {
                    $request->setParam("poi_type", $this->checkParamValid($request->getParam('type')));
                }
                unset($param);
                $param = $this->checkParamValid($request->getParam('poi_sub_type'));
                if (isset($param) and !is_null($param) and $param!="")
            
                {
                    $request->setParam("poi_sub_type", $this->checkParamValid($request->getParam('poi_sub_type')));
                }
                $this->_forward ( 'generalinfo' );
        }
        	 
        	
	public function generalinfoAction() 
	{
	   	$request = $this->getRequest();
	   	$data=$request->getPost ();
		$poi_id=$this->_getParam('id');
		$params=array('Amenities'=>array(),
		        'Dining_Options'=>array(),
		        'Cuisine'=>array(),
		        'Things_Options'=>array(),
		        'Activity_Type'=>array());
		$images=array();
		$thingsparam = array();
		$thingsparam['param_category_desc']='';
		if (isset($data['cookie']))
		{
		    $cookie = 1;
		    $cookie_path = $data['cookie_path'];
		}
		
		
	   	if (isset($data['locality']) and $poi_id == 0)
	   	{
	   	    $pre_add = true;
	   	    $save_new = false;
	   	    $pre_edit = false;
	   	    $update_rec = false;
	   	}
	   	if (!isset($data['locality']) and $poi_id == 0)
	   	{
	   	    $pre_add = false;
	   	    $save_new = true;
	   	    $pre_edit = false;
	   	    $update_rec = false;
//	   	echo "<pre>";print_r('add new');exit;
	   	}
	   	if (!$this->_request->isPost() and $poi_id != 0)
	   	    {
	   	    $pre_add = false;
	   	    $save_new = false;
	   	    $pre_edit = true;
	   	    $update_rec = false;
	   	    }
	   	if ($this->_request->isPost() and $poi_id != 0)
	   	{
	   	    $pre_add = false;
	   	    $save_new = false;
	   	    $pre_edit = false;
	   	    $update_rec = true;
	   	}
	   	 
	   		  
// ---------------- user clicked on add new in index view	   	 
        if ($pre_add)
        {
         $poi_type=$this->_getParam('poi_type');
         $poi_sub_type =$this->_getParam('poi_sub_type');
        }   
// ---------------- user clicked on update in generalinfo to add the record
        if ($save_new)
        {
            $poi_type=$data['poi_type'];
            $poi_sub_type =$data['poi_sub_type'];
        }
// ---------------- user clicked on update in generalinfo to edit the record
        if ($pre_edit)
        {
	        $row = $this->_poimodel->getPoibyId ( $poi_id );
	        $poi_type=$row['poi_type'];
	        $poi_sub_type =$row['poi_sub_type'];
        }
        // ---------------- user clicked on update in generalinfo to edit the record
        if ($update_rec)
        {
            $row = $this->_poimodel->getPoibyId ( $poi_id );
            $poi_type=$row['poi_type'];
	        $poi_sub_type =$row['poi_sub_type'];
        }
        
        $poi_sub_type = null;
// ----------------- Get Params Filled in	and editing the record
	    
	    
	    if ($pre_edit or $update_rec)
	    {
	        $images=$row->getImages()->toarray();
	        if ($poi_type=='Stay')
	        {
    	        $params['Amenities']=$this->_poimodel->getpoifact($poi_id, 'Amenities');
	        }
	    	if ($poi_type=='Eat')
	        {
    	        $params['Dining_Options']=$this->_poimodel->getpoifact($poi_id, 'Dining_Options');
	            $params['Cuisine']=$this->_poimodel->getpoifact($poi_id, 'Cuisine');
	        }
	    	if ($poi_type=='Things')
	        {
    	        $params['Things_Options']=$this->_poimodel->getpoifact($poi_id, 'Things_Options');
	            $params['Activity_Type']=$this->_poimodel->getpoifact($poi_id, 'Activity_Type');
	        } 
	        $facl_value = array();
	        foreach ($params as $key => $value)
	            {
	            $facl_temp = array();
	            foreach ($value as $key2 => $value2)
	                {
	                $facl_temp=array_merge($facl_temp,explode(' ',$value2['poifcl_param_id']));
	                }
	            $facl_value[$key]=$facl_temp;
	        }
	    }
	    
	    
	    $form = new Poi_Form_Poi_Generalinfo(
	            array('poi_id'=>$poi_id,
	                  'poi_type'=>$poi_type,    
	                  'poi_sub_type' => $poi_sub_type));
	     
	    if (isset($row )){
	        $this->view->form= $form->populate($row->toarray());
	    }
	    else
	    {
	    	$this->view->form =  $form->populate($request->getParams());
	    }
	    
	    
	    if ($pre_edit or $update_rec)
	    {
	    if ($poi_type=='Stay' and isset($facl_value['Amenities']))
    	    $form->_setfaclvalue ($facl_value['Amenities'],'poi_amenities');
	    if ($poi_type=='Eat' and isset($facl_value['Dining_Options']))
	        $form->_setfaclvalue ($facl_value['Dining_Options'],'poi_dining_options');
	    if ($poi_type=='Eat' and isset($facl_value['Cuisine']))
    	    $form->_setfaclvalue ($facl_value['Cuisine'],'Cuisine');
	    if ($poi_type=='Things' and isset($facl_value['Things_Options']))
	        $form->_setfaclvalue ($facl_value['Things_Options'],'poi_things_options');
	    if ($poi_type=='Things' and isset($facl_value['Activity_Type']))
	        $form->_setfaclvalue ($facl_value['Activity_Type'],'poi_things_activity');
	    }
	    
	    
	    $this->view->headScript()->appendFile('https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places');
	    $this->view->headScript()->appendFile('/js/googlemap.js');
//	    $this->view->headScript()->appendFile('/js/tabs.js');
	     
        $this->view->headLink()->appendStylesheet('/css/default/jquery-ui-1.9.1.css');
        
	    $this->view->title = 'Point Of Interest';
	    $this->view->poi_id = $poi_id;
	    $this->view->poi_type=$poi_type;
	    $this->view->images=$images;
	    $this->view->cookie = $cookie;
	    $this->view->cookie_path = $cookie_path;
	     
	    
	    
	    
	    if ($update_rec or $save_new)
	    {
	        $info= $this->_getAllParams();
		    $request = $this->getRequest ();
	        $row=$request->getPost (); 
	        $poi_id=$this->_poimodel->savePoi($form, $row,$poi_id,$poi_type,$params,$images);

	        $this->_helper->flashMessenger('Profile Updated');
	        $row = $this->_poimodel->getPoibyId ( $poi_id );
	        $this->view->form= $form->populate($row->toarray());
	         
	    	if ($poi_type=='Stay')
    	        $form->_setfaclvalue ($info ['poi_amenities'],'poi_amenities');
	        if ($poi_type=='Eat')
	        {
	            $form->_setfaclvalue ($info ['poi_dining_options'],'poi_dining_options');
	            $form->_setfaclvalue ($info ['Cuisine'],'Cuisine');
	        }
	        if ($poi_type=='Things')
	        {
	            $form->_setfaclvalue ($facl_value['Things_Options'],'poi_things_options');
	            $form->_setfaclvalue ($facl_value['Activity_Type'],'poi_things_activity');
	        }
	        $a=$row->getImages()->toarray();
	        $this->view->images=$a;
//            if ($save_new)
//	            $this->render('addnew');
//            else 
               if (isset($cookie) and $cookie == 1) {
                   $this->_redirect($cookie_path);
               }     
               else {
                   $this->render('generalinfo');
               }
	    }
	     
	}

	
	public function relatedAction() 
	{
	    $poi_id=$this->_getParam('id');
	    if (!$this->_request->isPost())
	    {
	    $poi_type=$this->_getParam('poi_type');
	    $poicriteri['poi_type']='Stay';
	    $staylist=$this->_poimodel->getPoiList($poicriteri,null,true)->toArray();
	    $poicriteri['poi_type']='Eat';
	    $eatlist=$this->_poimodel->getPoiList($poicriteri,null,true)->toArray();
	    $poicriteri['poi_type']='Things';
	    $thingslist=$this->_poimodel->getPoiList($poicriteri,null,true)->toArray();
	    $relatedlist=$this->_poimodel->getrelatedPoibyType($poi_id);
	    $thispoi = $this->_poimodel->getPoibyId($poi_id)->toArray();

	    $staylist=$this->removelist($staylist,$relatedlist);
	    $eatlist=$this->removelist($eatlist,$relatedlist);
	    $thingslist=$this->removelist($thingslist,$relatedlist);

        $mykey='AIzaSyBTdIhb3x2S7P-62U2q-5EYDU1v29IyJF0';
        $this->view->headScript()->appendFile('https://maps.googleapis.com/maps/api/js?sensor=false');
        $this->view->headLink()->appendStylesheet('/css/default/jquery-ui-1.9.1.css');
        $this->view->headScript()->appendFile('/js/poimarker.js');
        
        $this->view->title = 'Related Point Of Interest';
        $this->view->poi_id = $poi_id;
        $this->view->poi_type=$poi_type;
        $this->view->related_list=$relatedlist;
        $this->view->stay_list=$staylist;
        $this->view->eat_list=$eatlist;
        $this->view->things_list=$thingslist;
        $this->view->thispoi=$thispoi;
	    }
        if ($this->_request->isPost())
        {
             
            $request = $this->getRequest ();
            $row=$request->getPost ();
            if ($row['action']=='insert')
            {
                $poi_id=$this->_poimodel->saveRelatedPoiRow($row,$poi_id);
                $this->_helper->flashMessenger('Profile Updated');
            }
            if ($row['action']=='delete')
            {
                $poi_id=$this->_poimodel->deleteRelatedPoiRow($row,$poi_id);
                $this->_helper->flashMessenger('Profile Updated');
            }
        }
	    
	    
	}
	
	public function viewAction()
	{
	    $poi_id=$this->_getParam('id');
	    $params=array('Amenities'=>array(),
	            'Dining_Options'=>array(),
	            'Cuisine'=>array());
	    $images=array();
	    $row = $this->_poimodel->getPoibyId ( $poi_id );
	    $poi_type=$row['poi_type'];
	    $images=$row->getImages()->toarray();
	        if ($poi_type=='Stay')
	        {
	            $params['Amenities']=$this->_poimodel->getpoifact($poi_id, 'Amenities')->toArray();
	        }
	        if ($poi_type=='Eat')
	        {
	            $params['Dining_Options']=$this->_poimodel->getpoifact($poi_id, 'Dining_Options')->toArray();
	            $params['Cuisine']=$this->_poimodel->getpoifact($poi_id, 'Cuisine')->toArray();
	        }
	    $facl_value = array();
	    foreach ($params as $key => $value)
	    {
	        $facl_temp = array();
	        foreach ($value as $key2 => $value2)
	        {
	            $facl_temp=array_merge($facl_temp,explode(' ',$value2['poifcl_param_id']));
	        }
	        $facl_value[$key]=$facl_temp;
	    }
	    
	     
	    $form = new Poi_Form_Poi_Generalinfo(array('poi_id'=>$poi_id,'poi_type'=>$poi_type));
	    
	    if (isset($row ))
	        $this->view->form= $form->populate($row->toarray());

	    if ($poi_type=='Stay' and isset($facl_value['Amenities']))
	        $form->_setfaclvalue ($facl_value['Amenities'],'poi_amenities');
	    if ($poi_type=='Eat' and isset($facl_value['Dining_Options']))
	        $form->_setfaclvalue ($facl_value['Dining_Options'],'poi_dining_options');
	    if ($poi_type=='Eat' and isset($facl_value['Cuisine']))
	        $form->_setfaclvalue ($facl_value['Cuisine'],'Cuisine');
	    $this->view->poi_id = $poi_id;
	    $this->view->poi_type=$poi_type;
	    $this->view->images=$images;
	    $row = $row->toArray();
	    $this->view->row=$row;
        $this->_helper->layout->disableLayout();	
	}
	
	public function makedefaultAction () {
		$this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
    	$request = $this->getRequest();
    	if ($request->isXmlHttpRequest()) {
    		$poiid = $request->getParam('poi_id');
    		$poi_image_id = $request->getParam('img_id');
    		$this->_poimodel->makeDefaultImage($poiid, $poi_image_id);
    		$images = $this->_poimodel->getimagesbyPoiId($poiid);
    		if(count($images) > 0 ) {
    			$str = "";
    			$imagePath = '/uploads/'.$poiid.'/';
    			foreach ($images as $image) {
    				$str  .= "<div style='float:left;padding:5px;'>";
    					$str  .= "<a href='".$imagePath.$image['poiimg_path']."' id='img_".$image['poiimg_id']."' alt='".$image['poiimg_title']."' width='70px' height='100px' rel='lightbox[hotel]'>";
    						$str  .= "<img src='".$imagePath.$image['poiimg_path']."' alt='".$image['poiimg_title']."' width='70px' height='100px'/>";
    					$str  .=  "</a>";
    					$str  .= "<p><img src=\"/images/delete.png\" alt=\"Delete\" title = 'Delete Image' height=\"20px\"width=\"20px\"/><span class='spandefault'>";
    						if ($image['poiimg_default'] ==  0) {
								$str  .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
								$str  .= "<a href='javascript:void(0)' name='".$image['poiimg_id']."' class='imgdefault' title = 'Make this image as default'><img src=\"/images/makedefault.png\" alt=\"Make Default\" title = 'Make this image as default' height=\"20px\"width=\"20px\"/></a>";
							}
						$str  .= "</span></p>";
    				$str  .= "</div>";
    			}
    			print $str;
    		}
    	}
		
	}
	
	public function deleteAction () {
		$this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
    	$request = $this->getRequest();
    	if ($request->isXmlHttpRequest()) {
    		$poiid = $request->getParam('poi_id');
    		$poi_image_id = $request->getParam('img_id');
    		$imagename = $this->_poimodel->getImageName($poi_image_id);
    		$imagename = $imagename[0]['poiimg_path'];
    		//print IMAGE_PATH."/$poiid/$imagename";exit;
    		if($this->_poimodel->deleteImage($poi_image_id)) {
    			//print IMAGE_PATH."/$poiid/$imagename";
    			unlink(IMAGE_PATH."/$poiid/$imagename");
    		}
    		
    	}
	} 
	
	public function quickviewAction() {
		$this->_helper->layout->disableLayout ();
		$request = $this->getRequest ();
		$criteria = array ();
		$criteria ['poi_id'] = $request->getParam ( 'id' );
		$pois = $this->_poimodel->getPoiList ( $criteria, $request->getParam ( 'page', 1 ), false );
		$pois = $pois->toArray ();
		//echo "<pre>";print_r($pois);exit;
		if (count ( $pois ) > 0) {
			$t = $this->_poimodel->getDefaultImage ( $pois [0] ['poi_id'] );
			if (count ( $t ) > 0) {
				$pois [0] ['default_image'] = $t [0] ['poiimg_path'];
			} else {
				$pois [0] ['default_image'] = "";
			}
			$pois = $pois [0];
			$this->view->poi = $pois;
		}else {
			 $this->view->poi = "";
		}
	}
	private function checkParamValid ($str) {
		$str = trim($str);
		if($str == "" || $str == 'undefined' || $str == 'none' ) {
			return "";
		}else {
			return $str;
		}
	}
	private function removelist($fiestarray,$secondarray)
	{
	    $result=array();
	    $i=0;
	    foreach ($fiestarray as $row) 
	    {
	        if (!$this->in_array_r($row['poi_id'], $secondarray))
	        {
	            $result[$i++]=$row;
	        }
	                
	    }
	    return $result;
	    
	}
	
	private function in_array_r($needle, $haystack) {
	    foreach ($haystack as $item) {
	        if ($needle==$item['related_poi_id'])
	        {
	            return true;
	        }
	    }
	
	    return false;
	}

}
