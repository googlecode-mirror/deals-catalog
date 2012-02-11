<?php

defined('_JEXEC') or die('Restricted Access');

class Tabledeal_productslisting_deals extends JTable
{

	var $id 				= null;
	var $vendor_id			= null;
	var $product_id			= null;
	var $stock_in			= null;
	var $price				= null;
	var $discount_price		= null;
	var $listingstart_date	= null;
	var $listingend_date	= null;
	var $merchantproduct_desc	= null;
	var $merchantproduct_image1	= null;
	var $merchantproduct_thumbimage1 = null;
	var $is_deal			= null;
	var $deal_price			= null;
	var $dealstart_date		= null;
	var $dealend_date		= null;
	var $promotion_type		= null;

	/**
	* @param database A database 
        connector object */
	function __construct(&$db)
	{
		parent::__construct( '#__deal_productslisting_deals', 'id', $db );
	}

}