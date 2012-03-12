<?php
defined('_JEXEC') or die('Restricted Access');

class Tableintranet_calendar extends JTable
{
	var $id = null;
	var $date	= null;
	var $event	= null;
	var $event_title = null;
	var $eventstart_time	 = null;
	var $eventend_time	= null;
	var $holiday	= null;
	var $holiday_type = null;
	var $holiday_title	= null;
	var $dt = null;
	var $year = null;
	
	/**
	* @param database A database 
        connector object */
	function __construct(&$db)
	{
		parent::__construct( '#__intranet_calendar', 'id', $db );
	}
	
}
?>