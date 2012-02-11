<?php

defined('_JEXEC') or die('Restricted Access');

class Tabledeal_coupons extends JTable
{
	var $id 				= null;
	var $users_userid		= null;
	var $product_id			= null;
	var $vendor_id			= null;
	var $coupon_code		= null;
			
	/**
	* @param database A database 
        connector object */
	function __construct(&$db)
	{
		parent::__construct( '#__deal_coupons', 'id', $db );
	}
}

?>