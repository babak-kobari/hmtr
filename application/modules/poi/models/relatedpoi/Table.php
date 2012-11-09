<?php

/**
 * poifacl
 *  
 * @author Babak
 * @version 
 */
require_once dirname ( __FILE__ ) . '/Rows/Rows.php';
class Poi_Model_relatedpoi_Table extends Core_Db_Table_Abstract

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
	        $related_rows[$i++] = $row->findParentRow ( 'Poi_Model_Poi_Table', 'relatedPoi' );
	    }
	        
	    return $related_rows;
	}
	
	
	public function saveRelatedPoiRows($info, $poi_id,$table_data,$cat) 
	{
	    $rowdata=array();
	    foreach ( $info as $key => $value ) 
	    {
	        $insert=true;
	        foreach ($table_data as $table_key=>$table_value)
	        {
	            if ($table_value['poifcl_poi_id']==$poi_id & 
	                $table_value['poifcl_param_id']==$value)
	            {
	                $poifacl_id=$table_value['poifcl_id'];
	                $insert=false;
	                break;
	            }
	        }
	        if ($insert)
	        {
                    unset($rowdata['poifcl_id']);
	            	$rowdata=array (
                    'poifcl_poi_id' => $poi_id,
	                'poifcl_param_id' => $value,
            	    'poifcl_param_category_id'=>$cat);
    	            $row_id=$this->insert($rowdata);
	        }
	        else
	        {
                $rowdata=array (
	                'poifcl_id'=>$poifacl_id,
                    'poifcl_poi_id' => $poi_id,
	                'poifcl_param_id' => $value,
            	    'poifcl_param_category_id'=>$cat);
                $where['poifcl_id= ?'] = $rowdata['poifcl_id'];
	            $this->update($rowdata, $where);
	        }
	         
	    }
	}
	
}
