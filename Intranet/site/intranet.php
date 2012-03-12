<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

$document = & JFactory::getDocument();
$document->addStyleSheet('components/com_intranet/css/intranet.css');

require_once( JApplicationHelper::getPath( 'html' ) );

$task 	= JRequest::getVar('task', '' ,"REQUEST");

switch ($task) {
	default:
		IntranetHTML::calendar();
		break;
		
	case 'calendar':
		IntranetHTML::calendar();
		break;
		
	case 'newattendance':
		newattendance();
		break;
		
	case 'oldattendance':
		oldattendance();
		break;
		
	case 'attendance':
		IntranetHTML::attendance();
		break;
		
	case 'weeklyattendance':
		IntranetHTML::weeklyattendance();
		break;
		
	case 'dailyattendance':
		IntranetHTML::dailyattendance();
		break;
		
	case 'leaverequest':
		IntranetHTML::leaverequest();
		break;
		
	case 'leaves':
		IntranetHTML::leaves();
		break;
		
	case 'newrequest':
		IntranetHTML::newrequest();
		break;
		
	case 'requestsave':
		requestsave();
		break;
		
	case 'payslip':
		IntranetHTML::payslip();
		break;
}

function newattendance()
{
	$db = &JFactory::getDBO();
	$users_id = $_POST['users_id'];
	$name = $_POST['name'];
	$today_date = $_POST['today_date'];
	$in_time =$_POST['in_time'];
	$month = $_POST['month'];
	$year = $_POST['year'];
	$url = $_POST['url'];
	$query = "insert into #__intranet_dailyattendance (`users_id`, `name`, `today_date`, `in_time`, `out_time`, `month`, `year`, `total_hours`) values ('$users_id', '$name', '$today_date', '$in_time', '', '$month', '$year', '')";
	$db->setQuery($query);
	$db->query();
	header("Location: ".$url);
}

function oldattendance()
{
	$db = &JFactory::getDBO();
	$users_id = $_POST['users_id'];
	$id = $_POST['id'];
	$today_date = $_POST['today_date'];
	$in_time =$_POST['in_time'];
	$out_time = $_POST['out_time'];	
	$url = $_POST['url'];
	$a1 = explode(":",$in_time);
	$a2 = explode(":",$out_time);
	$time1 = (($a1[0]*60*60)+($a1[1]*60)+($a1[2]));
	$time2 = (($a2[0]*60*60)+($a2[1]*60)+($a2[2]));
	$diff = abs($time1-$time2);
	$hours = floor($diff/(60*60));
	$mins = floor(($diff-($hours*60*60))/(60));
	$secs = floor(($diff-(($hours*60*60)+($mins*60))));
	$total_hours = $hours.":".$mins.":".$secs;
	echo $query = "update #__intranet_dailyattendance set `out_time`='$out_time', `total_hours`='$total_hours' where id='$id' and users_id='$users_id'";
	$db->setQuery($query);
	$db->query(); 
	header("Location: ".$url);
}

function requestsave()
{
	$db = &JFactory::getDBO();
	$daterequested = $_POST['daterequested'];
	$fromusers_id = $_POST['fromusers_id'];
	$tousers_id = $_POST['tousers_id'];
	$subject = $_POST['subject'];
	$message = $_POST['message'];
	$fromdate = $_POST['fromdate'];
	$todate = $_POST['todate'];
	$month = $_POST['month'];
	$year = $_POST['year'];
	$Itemid = $_POST['Itemid'];
	
	echo $query = "insert into #__intranet_leaverequest (`daterequested`, `fromusers_id`, `tousers_id`, `subject`, `message`, `fromdate`, `todate`, `month`, `year`) values ('$daterequested', '$fromusers_id', '$tousers_id', '$subject', '$message', '$fromdate', '$todate', '$month', '$year')";
	$db->setQuery($query);
	$db->query();
	
	$url = "index.php?option=com_intranet&task=leaverequest&Itemid=".$Itemid;
	header("Location: ".$url);
}

?>