<?php
defined('_JEXEC') or die('Restricted Access');

class Tableintranet_users extends JTable
{
	var $id	= null;
	var $users_id	= null;
	var $name	= null;
	var $email	= null;
	var $username = null;
	var $password = null;
	var $dob	= null;
	var $official_address	= null;
	var $residencial_address	= null;
	var $phone_no	= null;
	var $mobile_no	= null;
	var $position	= null;
	var $basic_pay	= null;
	var $monthly_salary	= null;
	var $total_salary = null;
	
	/**
	* @param database A database 
        connector object */
	function __construct(&$db)
	{
		parent::__construct( '#__intranet_users', 'id', $db );
	}
}
?>