<?php
defined('_JEXEC') or die('Restricted Access');

class Tableintranet_dailyattendance extends JTable
{
	var $id	= null;
	var $users_id	= null;
	var $name	= null;
	var $today_date	= null;
	var $in_time	= null;
	var $out_time	= null;
	var $month	= null;
	var $year	= null;
	var $total_hours	= null;
	
	/**
	* @param database A database 
        connector object */
	function __construct(&$db)
	{
		parent::__construct( '#__intranet_dailyattendance', 'id', $db );
	}
}
?>