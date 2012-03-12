<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

class TOOLBAR_intranet {

	function _settings()
	{
		JToolBarHelper::title( JText::_( 'Settings for Intranet' ), 'cpanel.png' );
		JToolBarHelper::save('settingsave');
	}
	
	function _calendar()
	{
		JToolBarHelper::title( JText::_( 'Intranet Calendar Views' ), 'cpanel.png' );
	}
	
	function _addeventcalendar()
	{
		JToolBarHelper::title( JText::_( 'Add New Event for Date' ), 'cpanel.png' );
		JToolBarHelper::save('calendarsave');
		JToolBarHelper::cancel('calendar');	
	}
	
	function _users()
	{
		JToolBarHelper::title( JText::_( 'Intranet Users List' ), 'cpanel.png' );
		JToolBarHelper::trash('usersremove');
		JToolBarHelper::editListX('usersedit');
		JToolBarHelper::addNewX('usersinsert');
	}
	
	function _usersinsert()
	{
		JToolBarHelper::title( JText::_( 'Add New User' ), 'cpanel.png' );
		JToolBarHelper::save('Userssave');
		JToolBarHelper::cancel('users');	
	}
	
	function _usersedit()
	{
		JToolBarHelper::title( JText::_( 'Edit User' ), 'cpanel.png' );
		JToolBarHelper::save('Userseditsave');
		JToolBarHelper::cancel('users');
	}
	
	function _dailyattendance()
	{
		JToolBarHelper::title( JText::_( 'Intranet Attendance' ), 'cpanel.png' );
		JToolBarHelper::trash('attendanceremove');
		JToolBarHelper::editListX('attendanceedit');
		JToolBarHelper::addNewX('attendanceinsert');
	}
	
	function _attendanceinsert()
	{
		JToolBarHelper::title( JText::_( 'Add Attendance' ), 'cpanel.png' );
		JToolBarHelper::save('attendancesave');
		JToolBarHelper::cancel('dailyattendance');
	}
	
	function _dailyattendanceedit()
	{
		JToolBarHelper::title( JText::_( 'Edit Attendance' ), 'cpanel.png' );
		JToolBarHelper::save('attendanceeditsave');
		JToolBarHelper::cancel('dailyattendance');
	}
	
	function _monthattendance()
	{
		JToolBarHelper::title( JText::_( 'Intranet Attendance' ), 'cpanel.png' );
	}
	
	function _payslip()
	{
		JToolBarHelper::title( JText::_( 'Intranet Pay Slip' ), 'cpanel.png' );
		JToolBarHelper::trash('payslipremove');
		JToolBarHelper::editListX('payslipedit');		
		JToolBarHelper::addNewX('payslipinsert');
	}
	
	function _payslipinsert()
	{
		JToolBarHelper::title( JText::_( 'Pay Slip for users' ), 'cpanel.png' );
		JToolBarHelper::save('payslipsave');
		JToolBarHelper::cancel('payslip');
	}
	
	function _leaverequest()
	{
		JToolBarHelper::title( JText::_( 'Intranet Leave Request' ), 'cpanel.png' );
		JToolBarHelper::trash('leaverequestremove');
		JToolBarHelper::editListX('leaverequestedit');		
		JToolBarHelper::addNewX('leaverequestinsert');
	}
	
	function _leaverequestinsert()
	{
		JToolBarHelper::title( JText::_( 'Leave Request' ), 'cpanel.png' );
		JToolBarHelper::save('leaverequestsave');
		JToolBarHelper::cancel('leaverequest');
	}
}
?>