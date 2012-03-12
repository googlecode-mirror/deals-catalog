<?php
defined('_JEXEC') or die('Restricted Access');

class Tableintranet_leaverequest extends JTable
{
	var $id	=	 null;
	var $daterequested	= null;
	var $fromusers_id	= null;
	var $tousers_id	= null;
	var $subject	= null;
	var $message	= null;
	var $fromdate	= null;
	var $todate	= null;
	var $month	= null;
	var $year	= null;
	var $approved	= null;
	var $dateapproved	= null;
	
	/**
	* @param database A database 
        connector object */
	function __construct(&$db)
	{
		parent::__construct( '#__intranet_leaverequest', 'id', $db );
	}
}
?>