<?php

defined('_JEXEC') or die('Restricted Access');

class Tabledeal_productcategories extends JTable
{
	var $id 			= null;
	var $category_name	= null;
	var $category_desc	= null;
	
	/**
	* @param database A database 
        connector object */
	function __construct(&$db)
	{
		parent::__construct( '#__deal_productcategories', 'id', $db );
	}
}
?>