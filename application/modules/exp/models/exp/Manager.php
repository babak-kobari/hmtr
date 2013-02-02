<?php

/**
 * poi
 *  
 * @author Babak
 * @version 
 */
class Exp_Model_Exp_Manager extends Core_Model_Manager

{
    
	public function getExpbyId($exp_id)
	{
	    $table= new Exp_Model_expdays_Table();
	    return $table->getExpbyId ( $exp_id);
	}

	public function saveDaySummary($row)
	{
	    $table = new Exp_Model_Expdaysummry_Table();
	    $this_row=$table->getexpdaysummaryIdandDayNo($row['exp_id'], $row['exp_day_no']);
	    if (isset($this_row['exp_day_summry_id']))
	    {
	        $where['exp_day_summry_id = ?'] = $this_row['exp_day_summry_id'];
	        $row_id=$table->update($row, $where);
	    }
	    else
	        $row_id= $table->saveRow($row);
	    return $row_id;
	}
	
	public function savepoiexp($row,$detail_rows)
	{
	    $table = new Exp_Model_exppoihead_Table();
	    $detail_table = new Exp_Model_exppoidetail_Table();
	    $this_row=$table->getpoiexpbyId($row['exp_id'], $row['exp_poi_id']);
	    if (isset($this_row['exp_poi_head_id']))
	    {
	        $where['exp_poi_head_id = ?'] = $this_row['exp_poi_head_id'];
	        $row_id=$table->update($row, $where);
	        $row_id=$this_row['exp_poi_head_id'];
	    }
	    else
	        $row_id= $table->saveRow($row);
	    
	    foreach ($detail_rows as $detail_row)
	    {
	        $exppoi_detail_row['exp_poi_head_id']=$row_id;
	        $exppoi_detail_row['exp_poi_param_id']=$detail_row[0];
	        $exppoi_detail_row['poifcl_param_category_id']=$detail_row[1];
	        $exppoi_detail_row['exp_poi_param_rate']=$detail_row[2];
	        $exppoi_detail_row['exp_poi_param_comment']=$detail_row[3];
	        $this_row=$detail_table->getpoiexpdetailbyId($exppoi_detail_row['exp_poi_head_id'], $exppoi_detail_row['exp_poi_param_id']);
	        if (isset($this_row) and !is_null($this_row))
	        {
	            $where['exp_poi_detail_id = ?'] = $this_row['exp_poi_detail_id'];
	            $detail_row_id=$detail_table->update($exppoi_detail_row, $where);
	        }
	        else
	            $detail_row_id= $detail_table->saveRow($exppoi_detail_row);
	         
	    }
	    return $row_id;
	     
	}
	public function getExpbyTitle($exp_title) 
	{
	    $table= new Exp_Model_expdays_Table();
	    return $table->getExpbyId ( $exp_title);
	}
	public function getExpbyUserId($exp_user_id) 
	{
	    $table= new Exp_Model_expdays_Table();
	    return $table->getExpbyId ( $exp_user_id);
	}
	
	
	
	public function saveExp($info) 
	{
		
	    $table= new Exp_Model_expdays_Table();
	    $exp_id = $table->saveExphead($info);
		
		return $exp_id;
	}
	
	
	public function getexpdaysbyhead($exp_id)
	{
	    $exp_days_table= new Exp_Model_expdays_Table();
	    $exp_days=$exp_days_table->getexpdaysbyparent($exp_id);
	    return $exp_days;
	}
	
	public function saveDays($info)
	{
	    $table=new Exp_Model_expdays_Table();
	    $row_id=$table->saveRow($info);
	    foreach ($info['order'] as $i=>$poi)
	    {
	        $where='exp_id='.$info['exp_id'].' and exp_day_no='.$info['exp_day_no'].' and exp_poi_id='.$poi;
            $data=array('exp_poi_order'=>$i+1);
	        $table->update($data, $where);
	    }
	    return $row_id;
	     
	}
	public function deletePoi($info)
	{
	    $table=new Exp_Model_expdays_Table();
	    $row=$table->getexpdaysbyprimary($info);
	    $row_id=$table->deleteById($row['exp_days_id']);
	    return $row_id;
	
	}

	public function getpoiexpbyId($exp_id,$poi_id)
	{
	    $table=new Exp_Model_exppoihead_Table();
	    $row=$table->getpoiexpbyId($exp_id, $poi_id);
	    return $row;
	}
	
	public function getexpdaysummaryIdandDayNo($exp_id,$exp_day_no)
	{
	    $table= new Exp_Model_Expdaysummry_Table();
	    return $table->getexpdaysummaryIdandDayNo($exp_id, $exp_day_no);	     
	}

	public function getexpheadbyId($exp_id)
	{
	    $table= new Exp_Model_exphead_Table();
	    return $table->getexpheadbyId($exp_id);
	}
	
	public function getexpcountriesbyuser($user_id,&$countries)
	{
	    $table= new Exp_Model_exphead_Table();
	    $rows=$table->getcountriesbyUser($user_id);
	    foreach ($rows as $key=>$row)
	    {
	        $rows[$key]['country_name']=$countries[$row['exp_country']]['param_category_desc'];
	    }
	    return $rows;
	}

	public function gettotalWIP($user_id)
	{
	    $table= new Exp_Model_exphead_Table();
	    $count=$table->getTotalWIP($user_id);
	    return $count;
	}
	
	public function getexpdetail($user_id,array $filterArray,&$country,&$travel_with,&$travel_objective)
	{
	    $table= new Exp_Model_exphead_Table();
	    $rows = $table->getExpDetails($user_id,$filterArray,$country,$travel_with,$travel_objective);
	    return $rows;
	}
	
	public function getTitles($searchString) 
	{
	    $table= new Exp_Model_exphead_Table();
	    $rows= $table->getTitles($searchString);
	    return $rows;
	}
	
	public function getCityNames($searchString) 
		{
	    $table= new Exp_Model_exphead_Table();
	    $rows= $table->getCityNames($searchString);
	    return $rows;
		}
	
}
