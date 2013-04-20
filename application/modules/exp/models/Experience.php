<?php
class Exp_Model_Experience {
	
	private $_db;
	
	private $_expMasterTable;
	
	private $_expDaysTable;
	
	private $_poiTable;
	
	private $_expPoiTable;
	
	public function __construct()
	{
		try {
			$this->_db = Zend_Db_Table::getDefaultAdapter();
			$this->_expMasterTable = "hm_exp_head";
			$this->_expDaysTable = "hm_exp_days";
			$this->_poiTable = "hm_poi";
			$this->_expPoiTable = "hm_exp_poi_head";
		}catch (Exception $e) {
				
		}
	}
	
	public function getExpDetailHead($expid) {
		$select = $this->_db->select();
		$select->from(array("exp" => $this->_expMasterTable),
				array('exp.exp_title as title','exp.exp_city as city_visted',
						'exp.exp_overall_rate as exp_overall_rate','exp.exp_mount as visited_month',
						'exp.exp_total_cost as total_cost','exp.exp_days as totaldays','exp.exp_adults as adults','exp.exp_childs as childs',
						'exp.exp_status')
		);
		$select->joinLeft(
				array('tw' => "hm_param_travel_with"),
				'exp.exp_travel_with = tw.param_id',
				array('tw.param_desc as travelwith')
		);
		
		$select->joinLeft(
				array('tobj' => "hm_param_travel_objective"),
				'exp.exp_travel_objective = tobj.param_id',
				array('tobj.param_desc as travelobjective')
		);
		
		$select->joinLeft(
				array('cn' => "hm_param_country"),
				'exp.exp_country = cn.country_id',
				array('cn.country_name')
		);
		/* $select->joinLeft(
				array('tw' => "hm_param"),
				'exp.exp_travel_with = tw.param_id',
				array('tw.param_category_desc as travelwith')
		); */
		$select->where("exp.exp_id = ? ",$expid);
		//echo $select->__toString();exit;
		$stmt = $this->_db->query($select);
		$queryResult = $stmt->fetchAll();
		return $queryResult;
	}
	
	public function getExpDays ($expid) {
		$select = $this->_db->select();
		$select->from(array("days" => $this->_expDaysTable),
				array('days.exp_day_no as dayno','days.exp_poi_id',
						
				)
		);
		$select->where("days.exp_id = ? ",$expid);
		$select->order(array("days.exp_day_no","days.exp_poi_order"));
		//$select->group('days.exp_day_no');
		$stmt = $this->_db->query($select);
		$queryResult = $stmt->fetchAll();
		return $queryResult;
	}
	
	public function getTotalExpDays($expid) {
		$select = $this->_db->select();
		$select->distinct();
		$select->from(array("days" => $this->_expDaysTable),
				array('days.exp_day_no as dayno')
		
				
		);
		$select->where("days.exp_id = ? ",$expid);
		//echo $select->__toString();exit;
		$stmt = $this->_db->query($select);
		$queryResult = $stmt->fetchAll();
		return $queryResult;
	}
	public function getPOITranportationDetails ($expid,$day) {
		$select = $this->_db->select();
		$select->from(array("days" => "hm_exp_day_smmry"),
				array("days.exp_trans_type as transportationtype","days.exp_trans_cost as tranportationcost",
						"days.exp_trans_comment as comment","days.exp_day_cost as daycost"
						)
		);
		
		
		
		$select->where("days.exp_id = ?",$expid);
		$select->where("days.exp_day_no = ?",$day);
		//echo $select->__toString();exit;
		$stmt = $this->_db->query($select);
		$queryResult = $stmt->fetchAll();
		return $queryResult;
	}
	public function getPOIDaydeatails ($expid,$day) {
		$select = $this->_db->select();
		$select->from(array("days" => $this->_expDaysTable),
				array("days.exp_poi_id as daypoi")
				);
		
		$select->join(
				array('poi' => $this->_poiTable),
				'poi.poi_id = days.exp_poi_id',
				array('poi.poi_name','poi_type')
		);
		
		$select->where("days.exp_id = ?",$expid);
		$select->where("days.exp_day_no = ?",$day);
		//echo $select->__toString();exit;
		$stmt = $this->_db->query($select);
		$queryResult = $stmt->fetchAll();
		return $queryResult;
	}
	
	public function getPOIDetails($expid) {
		
		$select = $this->_db->select ();
		
		$select->from(array("exppoi" => $this->_expPoiTable),
				array("exp_poi_head_id as headid","exppoi.exp_poi_title","exppoi.exp_poi_overal_rating")
		);
		$select->join(
				array('poi' => $this->_poiTable),
				'poi.poi_id = exppoi.exp_poi_id',
				array('poi.poi_name','poi.poi_type')
		);
		
		$select->where("exppoi.exp_id = ?",$expid);
		//echo $select->__toString();exit;
		$stmt = $this->_db->query($select);
		$queryResult = $stmt->fetchAll();
		$result = array ();
		if(count($queryResult) > 0) {
			foreach ($queryResult as $q) {
				$q['feedback'] = $this->getpoifeedback($q['headid']);
				array_push($result, $q);
			}
		}
		//echo "<pre>";print_r($result);exit;
		return $result;
	}
	public function getpoifeedback($expheadid) {
		$select = $this->_db->select ();
		
		$select->from(array("exppoi" => $this->_expPoiTable),
				array("exppoi.exp_poi_title")
		);
		
		$select->join(
				array('poidt' => "hm_exp_poi_detail"),
				'poidt.exp_poi_head_id = exppoi.exp_poi_head_id',
				array('poidt.poifcl_param_category_id','poidt.exp_poi_param_rate as facilityrating','poidt.exp_poi_param_comment as facilitycomment')
		);
		$select->join(
				array('par' => "hm_param_poi_options"),
				'poidt.exp_poi_param_id = par.param_id',
				array('param_desc as facility')
		);
		$select->where("exppoi.exp_poi_head_id = ?",$expheadid);
		$select->where("poidt.exp_poi_param_rate > 0");
		
		//echo $select->__toString();exit;
		$stmt = $this->_db->query($select);
		$queryResult = $stmt->fetchAll();
		//echo "<pre>";print_r($queryResult);exit;
		return $queryResult;
		
	}
	
	public function getOptions($type,$poiid) {
		$subSelect = $this->_db->select ();
		$subSelect->from(array("poifcl" => "hm_poi_facl"),
				array('poifcl.poifcl_param_id')
		);
		$subSelect->where("poifcl.poifcl_poi_id=?",$poiid);
		$select = $this->_db->select ();
		$select->from(array("op" => "hm_param_poi_options"),
				array("op.param_id","op.param_desc")
		);
		$select->where("op.param_id NOT IN ? ",$subSelect);
		$select->where("op.poi_option_type = ?",$type);
		//echo $select->__toString();exit;
		$stmt = $this->_db->query($select);
		$queryResult = $stmt->fetchAll();
		//echo "<pre>";print_r($queryResult);exit;
		return $queryResult;
	}
	public function  addOptions($type,$poiid,$options) {
		try {
			$tbl_comment = new Zend_Db_Table("hm_poi_facl");
			for($i =0 ;$i<count($options); $i++) {
				$insertArray = array();
				$insertArray['poifcl_poi_id'] = trim($poiid);
				$insertArray['poifcl_param_id'] = trim($options[$i]);
				$insertArray['poifcl_poi_option_type'] = trim($type);
				$tbl_comment->insert($insertArray);
			}
			
		}catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
		
	}
}

 