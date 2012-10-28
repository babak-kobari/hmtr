<?php

/**
 * poifacl
 *  
 * @author Babak
 * @version 
 */
require_once dirname ( __FILE__ ) . '/Rows/Rows.php';
class Poi_Model_poifacl_Table extends Core_Db_Table_Abstract

{
	protected $_name = 'hm_poi_facl';
	protected $_primary = 'poifcl_id';
	protected $_rowClass = 'Poi_Model_poifacl_Row';
	protected $_referenceMap = array (
			'relatedPoi' => array (
					'columns' => 'poifcl_poi_id',
					'refTableClass' => 'Poi_Model_Poi_Table',
					'refColumns' => 'poi_id'),
			'facldesc' => array (
					'columns' => 'poifcl_param_id',
					'refTableClass' => 'Users_Model_User_Table',
					'refColumns' => 'param_id' ) 
	        );
	
	public function getpoifaclbyId($poifcl_id) {
		return $this->find ( $poifcl_id )->current ();
	}

	
	
	public function savefaclrows($info, $poi_id,$table_data,$cat) 
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
	
	public function saveRow($info, $row = null) {
	    if (null === $row) {
	        $row = $this->createRow ();
	    }
	
	    $columns = $this->info ( 'cols' );
	    foreach ( $columns as $column ) {
	        if (array_key_exists ( $column, $info )) {
	            $row->$column = $info [$column];
	        }
	    }
	
	    return $row->save ();
	}
	
	
}
