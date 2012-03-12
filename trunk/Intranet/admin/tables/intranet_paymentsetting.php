<?php
defined('_JEXEC') or die('Restricted Access');

class Tableintranet_paymentsetting extends JTable
{
	var $id	= null;
	var $pf	= null;
	var $hr	= null;
	var $convenyance	= null;
	var $permitted_leave	= null;
	var $pf_deduction	= null;
	var $pt	= null;
	var $other_deduction	= null;
	var $endtime	= null;
	var $leavetype	= null;
	var $countryname = null;
	
	/**
	* @param database A database 
        connector object */
	function __construct(&$db)
	{
		parent::__construct( '#__intranet_paymentsetting', 'id', $db );
	}
}
?>