<?php

/**
 * poi
 *  
 * @author Babak
 * @version 
 */
class Exp_Model_Exp_Manager extends Core_Model_Manager

{
    protected $exp_table_head;

    public function init()
    {
	    $this->exp_table_head=new Exp_Model_Exp_Table();
    }
    
	public function getExpbyId($exp_id)
	{
	    return $this->exp_table_head->getExpbyId ( $exp_id);
	}

	public function getExpbyTitle($exp_title) 
	{
	    return $this->exp_table_head->getExpbyId ( $exp_title);
	}
	public function getExpbyUserId($exp_user_id) 
	{
	    return $this->exp_table_head->getExpbyId ( $exp_user_id);
	}
	
	
	
	public function saveExp($info) 
	{
		
	        $exp_id = $this->exp_table_head->saveExphead($info);
		
		return $exp_id;
	}
	
	
	public function getexpdaysbyhead($exp_head_id)
	{
	    $exp_days_table= new Exp_Model_expdays_Table();
	    $exp_days=$exp_days_table->getexpdaysbyparent($exp_head_id);
	    return $exp_days;
	}
	
	public function saveDays($info)
	{
	    $table=new Exp_Model_expdays_Table();
	    $row_id=$table->saveRow($info);
	    return $row_id;
	     
	}
	public function deletePoi($info)
	{
	    $table=new Exp_Model_expdays_Table();
	    $row=$table->getexpdaysbyprimary($info);
	    $row_id=$table->deleteById($row['exp_days_id']);
	    return $row_id;
	
	}
	
}
