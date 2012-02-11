<?php

defined('_JEXEC') or die('Restricted Access');

class Tabledeal_merchants extends JTable
{
	var $id 			= null;
	var $name			= null;
	var $user_id 		= 0;
	var $username 		= null;
    var $password 		= null;
	var $firstname 		= null;
	var $lastname 		= null;
	var $address1 		= null;
	var $address2 		= null;
	var $email_id		= null;
	var $Contact_number	= null;
	var $city 			= null;
	var $states 		= null;
	var $location_map 	= null;
	var $approved 		= 0;	
	
	/**
	* @param database A database 
        connector object */
	function __construct(&$db)
	{
		parent::__construct( '#__deal_merchants', 'id', $db );
	}	
	
}


?>