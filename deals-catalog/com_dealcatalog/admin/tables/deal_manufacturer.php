<?php

defined('_JEXEC') or die('Restricted Access');

class Tabledeal_manufacturer extends JTable
{
	var $id 			= null;
	var $manufacturer_name	= null;
	
	/**
	* @param database A database 
        connector object */
	function __construct(&$db)
	{
		parent::__construct( '#__deal_manufacturer', 'id', $db );
	}
}
?>