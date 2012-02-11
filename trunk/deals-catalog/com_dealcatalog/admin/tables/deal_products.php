<?php

defined('_JEXEC') or die('Restricted Access');

class Tabledeal_products extends JTable
{
	var $id 				= null;
	var $product_name		= null;
	var $product_code		= null;
	var $product_desc		= null;
	var $manufacturer_id	= null;
	var $category_id		= null;
	var $product_image1		= null;
	var $product_thumbimage1= null;
	
	
	
	/**
	* @param database A database 
        connector object */
	function __construct(&$db)
	{
		parent::__construct( '#__deal_products', 'id', $db );
	}
}

?>