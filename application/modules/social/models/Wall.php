<?php
class Social_Model_Wall {
	
	private $_db;
	
	private $_experienceMasterTable;
	
	private $_wallTable;
	
	private $_userTable;
	
	private $_commentsTable;
	
	
	
	public function __construct()
	{
		try {
			$this->_db = Zend_Db_Table::getDefaultAdapter();
			$this->_experienceMasterTable = "hm_exp_head";
			$this->_wallTable = "hm_user_wall";
			$this->_userTable = "hm_users";
			$this->_commentsTable = "hm_ user_comments";
			
		}catch (Exception $e) {
			
		}
	}
	public function publishToWall($expid) {
		try{
			if ($expid > 0) {
				$tbl_comment = new Zend_Db_Table($this->_wallTable);
				$insertArray = array();
				$insertArray['exp_id'] = trim($expid);
				
				$tbl_comment->insert($insertArray);
			}else {
				throw new Exception("Invalid Experience");
			}
		}catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}
	public function getmywall ($logedinuser) {
		$result = array();
		try {
			
			$select = $this->_db->select();
			$select->from(array("exp" => $this->_experienceMasterTable),
					array('exp.exp_title as title','exp.exp_city as city_visted')
			);
			
			
			$select->join(
						array('usr' => $this->_userTable),
						'exp.exp_user_id = usr.id',
						array('usr.login as username')
					);
			
			$select->join(
					array('wall' => $this->_wallTable),
					'exp.exp_id = wall.exp_id',
					array('wall.wall_id as wall_id','wall.wall_created as post_created')
			);
			
			$select->where("exp.exp_user_id = ?",$logedinuser);
			$select->order(array('wall.wall_id desc'));
			//print $select->__toString();exit;
			$stmt = $this->_db->query($select);
			$queryResult = $stmt->fetchAll();
			
			
			//echo "<pre>";print_r($queryResult);exit;
			if (count($queryResult) > 0) {
				foreach ($queryResult as $r) {
					$temp = array();
					$temp['exp_title'] = $r['title'];
					$temp['username'] = $r['username'];
					$temp['city_visted'] = $r['city_visted'];
					$temp['wall_id'] = $r['wall_id'];
					$created =  date($r['post_created']);
					$now =  date('Y-m-d H:i:s');
					$date_diff=strtotime($now) - strtotime($created);
					//$temp['post_created'] = $r['post_created'];
					$temp['post_created'] = (int) ($date_diff/(60 * 60 * 24))." days ago"; 
					
					$commentsArray = array();
					$select =  $this->_db->select ();
					$select->from(array("com" => $this->_commentsTable),
								array('com.comm_message as message','com.comm_created as comm_created')
						);
					
					$select->join(
							array('usr' => $this->_userTable),
							'com.user_id = usr.id',
							array('usr.login as username')
					);
					
					$select->where("com.wall_id = ?",$r['wall_id']);
					$stmt = $this->_db->query($select);
					$commResult = $stmt->fetchAll();
					if(count($commResult) > 0 ){
						foreach ($commResult as $c) {
							$commtemp = array();
							$commtemp['message'] = $c['message'];
							$commtemp['username'] = $c['username'];
							$created =  date($c['comm_created']);
							$now =  date('Y-m-d H:i:s');
							
							$date_diff=strtotime($now) - strtotime($created);
							$comm_created = (int) ($date_diff/(60 * 60 * 24));
							if ($comm_created == 0) {
								$comm_created = (int) ($date_diff/(60 * 60 ))." hour";
							}else {
								$comm_created .=" days";
							}
							$commtemp['comm_created'] = $comm_created."  ago";
							$commtemp['comm_created'] = "";
							array_push($commentsArray, $commtemp);
						}
						$temp['comment_message'] = $commentsArray;
					}
						
					array_push($result, $temp);
				}
			}
			return $result;
		}catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}
	
	public function postComment ($logedinuser,$wallid,$comment) {
		try {
			$tbl_comment = new Zend_Db_Table($this->_commentsTable);
			$insertArray = array();
			$insertArray['comm_message'] = trim($comment);
			$insertArray['wall_id'] = trim($wallid);
			$insertArray['user_id'] = trim($logedinuser);
			$tbl_comment->insert($insertArray);
		}catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
		
	}

	public function getunfollowUsers () {
		
		$select = $this->_db->select();
		
		$select->from(
					array("usr" => $this->_userTable),
					array("usr.id as userid","usr.login as loginName")
					
				);
		$stmt = $this->_db->query($select);
		$queryResult = $stmt->fetchAll();
		return $queryResult;
	}
}