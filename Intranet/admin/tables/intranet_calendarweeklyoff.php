<?php
defined('_JEXEC') or die('Restricted Access');

class Tableintranet_calendarweeklyoff extends JTable
{
	var $cal_id	= null;
	var $date	= null;
	var $title	= null;
	var $dt	= null;
	var $year	= null;
	
	/**
	* @param database A database 
        connector object */
	function __construct(&$db)
	{
		parent::__construct( '#__intranet_calendarweeklyoff', 'cal_id', $db );
	}
}