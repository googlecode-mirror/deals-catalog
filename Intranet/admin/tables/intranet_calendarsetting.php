<?php
defined('_JEXEC') or die('Restricted Access');

class Tableintranet_calendarsetting extends JTable
{
	var $id	= null;
	var $weekly_off	= null;
	var $year	= null;
	
	/**
	* @param database A database 
        connector object */
	function __construct(&$db)
	{
		parent::__construct( '#__intranet_calendarsetting', 'id', $db );
	}
}