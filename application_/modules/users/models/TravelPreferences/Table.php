<?php

require_once dirname ( __FILE__ ) . '/Rows/Rows.php';
class Users_Model_TravelPreferences_Table extends Core_Db_Table_Abstract

{
	protected $_name = 'hm_user_travelpreferences';
	protected $_primary = 'trvint_id';
	protected $_rowClass = 'Users_Model_TravelPreferences_Row';
	

}