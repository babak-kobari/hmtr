<?php

/**
 * poifacl
 *  
 * @author Babak
 * @version 
 */
require_once dirname ( __FILE__ ) . '/Rows/Rows.php';
class Poi_Model_Relatedpoi_Table extends Core_Db_Table_Abstract

{
	protected $_name = 'hm_related_poi';
	protected $_primary = 'id';
	protected $_rowClass = 'Poi_Model_relatedpoi_Row';
	protected $_referenceMap = array (
			'parentPoi' => array (
					'columns' => 'parent_poi_id',
					'refTableClass' => 'Poi_Model_Poi_Table',
					'refColumns' => 'poi_id'),
			'relatedPoi' => array (
					'columns' => 'related_poi_id',
					'refTableClass' => 'Poi_Model_Poi_Table',
					'refColumns' => 'poi_id')
			        	   );
	
	public function getRelatedPoibyId($poi_id) 
	{
	    $row = $this->find ( $poi_id )->current ();
	    return $row;
	}
	
	public function getPoibyType($poi_id,$poi_type = null) 
	{
	    if ($poi_type==null)
    	    $select=$this->select ()->where ( 'parent_poi_id = ?', $poi_id);
	    else
	        $select=$this->select ()->where ( 'parent_poi_id = ?', $poi_id)
	        ->where ( 'poi_type = ?',$poi_type);
	         
	    
	    $rowset=$this->fetchAll ( $select);
	    $i=0;
	    $related_rows=array();
	    foreach ($rowset as $row)
	    {
	        $related_rows[$i]['id']=$row['id'];
	        $related_rows[$i]['parent_poi_id']=$row['parent_poi_id'];
	        $related_rows[$i]['related_poi_id']=$row['related_poi_id'];
	        $related_rows[$i]['poi_distance']=$row['poi_distance'];
	        $related_rows[$i]['poi_distance_uom']=$row['poi_distance_uom'];
	        $parentRow= $row->findParentRow ( 'Poi_Model_Poi_Table', 'relatedPoi' );
	        $parentRow=$parentRow->toArray();
	        $result= array_merge($related_rows[$i], $parentRow);
	        $related_rows[$i++]=$result;
	    }
        
	    return $related_rows;
	}
	
	public function getPoibyRelated($poi_id,$related_poi_id)
	{
	        $select=$this->select ()->where ( 'parent_poi_id = ?', $poi_id)
	        ->where ( 'related_poi_id = ?',$related_poi_id);
	
	     
	    $rows=$this->fetchRow ( $select);
	     
	    return $rows;
	}
	
	public function saveRelatedPoiRows($info, $poi_id) 
	{
	    $rowdata=array();
	    $exrow=$this->getPoibyRelated($poi_id, $info['related_poi_id']);
	    if (isset($exrow))
	         $insert=false;
	    else
	        $insert=true;
        if ($insert)
	        {
                unset($rowdata['id']);
	            $rowdata=array (
                    'parent_poi_id' => $poi_id,
	                'related_poi_id' => $info['related_poi_id'],
            	    'poi_type'=>$info['poi_type'],
	            	'poi_distance'=>$info['poi_distance']);
    	            $row_id=$this->insert($rowdata);
    	            return $row_id;
	        }
	        else
	        {
                $rowdata=array (
                      'id'=>$exrow['id'],
                      'parent_poi_id' => $poi_id,
                      'related_poi_id' => $info['related_poi_id'],
                      'poi_type'=>$info['poi_type'],
                      'poi_distance'=>$info['poi_distance']);
                $where['id= ?'] = $rowdata['id'];
	            $this->update($rowdata, $where);
	        }
	         
	}
	public function deleteRelatedPoiRows($info, $poi_id)
	{
	    $exrow=$this->getPoibyRelated($poi_id, $info['related_poi_id']);
        $this->deleteById($exrow['id']);	
	}
	
}
