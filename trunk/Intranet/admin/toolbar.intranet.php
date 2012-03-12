<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
require_once( JApplicationHelper::getPath( 'toolbar_html' ) );

switch ( $task ) {

	default:
		TOOLBAR_intranet::_settings();
		break;
		
	case 'calendar':
		TOOLBAR_intranet::_calendar();
		break;
		
	case 'addeventcalendar':
		TOOLBAR_intranet::_addeventcalendar();
		break;
		
	case 'editeventcalendar':
		TOOLBAR_intranet::_addeventcalendar();
		break;
		
	case 'users':
		TOOLBAR_intranet::_users();
		break;
		
	case 'usersinsert':
		TOOLBAR_intranet::_usersinsert();
		break;
		
	case 'usersedit':
		TOOLBAR_intranet::_usersedit();
		break;
		
	case 'dailyattendance':
		TOOLBAR_intranet::_dailyattendance();
		break;
		
	case 'attendanceinsert':
		TOOLBAR_intranet::_attendanceinsert();
		break;
		
	case 'dailyattendanceedit':
		TOOLBAR_intranet::_dailyattendanceedit();
		break;
		
	case 'monthattendance':
		TOOLBAR_intranet::_monthattendance();
		break;
		
	case 'payslip':
		TOOLBAR_intranet::_payslip();
		break;
		
	case 'payslipinsert':
		TOOLBAR_intranet::_payslipinsert();
		break;
		
	case 'payslipedit':
		TOOLBAR_intranet::_payslipinsert();
		break;
		
	case 'leaverequest':
		TOOLBAR_intranet::_leaverequest();
		break;
		
	case 'leaverequestinsert':
		TOOLBAR_intranet::_leaverequestinsert();
		break;
		
	case 'leaverequestedit':
		TOOLBAR_intranet::_leaverequestinsert();
		break;
}
?>