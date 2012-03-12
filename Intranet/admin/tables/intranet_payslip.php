<?php
defined('_JEXEC') or die('Restricted Access');

class Tableintranet_payslip extends JTable
{
	var $id	= null;
	var $users_id	= null;
	var $month	= null;
	var $year	= null;
	var $variable_allowance	= null;
	var $working_days	= null;
	var $worked_days	= null;
	var $leave_days	= null;
	var $holidays	= null;
	var $basicpay_month	= null;
	var $totalsalary_month	= null;
	var $deduction_month	= null;
	var $salary_month	= null;
	
	/**
	* @param database A database 
        connector object */
	function __construct(&$db)
	{
		parent::__construct( '#__intranet_payslip', 'id', $db );
	}
}
?>