<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
require_once( JApplicationHelper::getPath( 'admin_html' ) );
JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS. 
'com_intranet'.DS.'tables');

$document = & JFactory::getDocument();
$document->addStyleSheet('components/com_intranet/css/intranet.css');

$id 	= JRequest::getVar('id', 0, 'get', 'int');
$task 	= JRequest::getVar('task', '' ,"REQUEST");
$task   = JRequest::getCmd('task'); 

switch ($task) {

	default:
		setting();
		break;
		
	case 'settingsave':
		settingsave();
		break;
		
	case 'settingcalendar':
		settingcalendar();
		break;
		
	case 'calendar':
		calendar();
		break;
		
	case 'addeventcalendar':
		addeventcalendar();
		break;
		
	case 'calendarsave':
		calendarsave();
		break;
		
	case 'editeventcalendar':
		editeventcalendar();
		break;
		
	case 'deleteeventcalendar':
		deleteeventcalendar();
		break;
		
	case 'users':
		users();
		break;
		
	case 'updateuser':
		updateuser();
		break;
		
	case 'usersinsert':
		usersinsert();
		break;
		
	case 'Userssave':
		Userssave();
		break;
		
	case 'usersedit':
		usersedit();
		break;
		
	case 'Userseditsave':
		Userseditsave();
		break;
		
	case 'usersremove':
		usersremove();
		break;
		
	case 'dailyattendance':
		dailyattendance();
		break;
		
	case 'attendanceinsert':
		attendanceinsert();
		break;
		
	case 'attendancesave':
		attendancesave();
		break;
		
	case 'dailyattendanceedit':
		dailyattendanceedit();
		break;
		
	case 'attendanceeditsave':
		attendanceeditsave();
		break;
		
	case 'attendanceremove':
		attendanceremove();
		break;
		
	case 'monthattendance':
		monthattendance();
		break;
		
	case 'payslip':
		payslip();
		break;
		
	case 'payslipinsert':
		payslipinsert();
		break;
		
	case 'payslipsave':
		payslipsave();
		break;
		
	case 'payslipedit':
		payslipedit();
		break;
		
	case 'payslipremove':
		payslipremove();
		break;
		
	case 'leaverequest':
		leaverequest();
		break;
		
	case 'leaverequestinsert':
		leaverequestinsert();
		break;
		
	case 'leaverequestsave':
		leaverequestsave();
		break;
		
	case 'leaverequestedit':
		leaverequestedit();
		break;
		
	case 'leaverequestremove':
		leaverequestremove();
		break;
}

//Setting Start
function setting()
{
	IntranetHTML::setting();
}

function settingsave()
{
	global $mainframe;
	$db = &JFactory::getDBO();
	$calendar = JRequest::getVar( 'display_calendar', '','post', 'string', JREQUEST_ALLOWRAW );
	$days = JRequest::getVar( 'days', '','post', 'string', JREQUEST_ALLOWRAW );	
	$payslip = JRequest::getVar( 'display_payslip', '','post', 'string', JREQUEST_ALLOWRAW );
	
	if($calendar==1)
	{
		$query = "update #__intranet_settings set `enabled`='$calendar' where id='1'";
		$db->setQuery($query);
		$db->query();
	}
	else
	{
		$query = "update #__intranet_settings set `enabled`='0' where id='1'";
		$db->setQuery($query);
		$db->query();
	}
	if($calendar==1)
	{
		$year = date("Y");		
		$query = "TRUNCATE TABLE `#__intranet_calendarsetting`";
		$db->setQuery($query);
		$db->query();
		$n = count($days);
		for($i=0; $i < $n; $i++)
		{
			$day = $days[$i];			
			global $mainframe;
			$row =& JTable::getInstance('intranet_calendarsetting', 'Table'); 
			if(!$row->bind(JRequest::get('post')))
			{
				JError::raiseError(500, $row->getError() );
			}
			$row->weekly_off = $day;
			$row->year = $year;
			if(!$row->store()){
				JError::raiseError(500, $row->getError() );
			}
		}
	}
	if($payslip==1)
	{
		$query = "update #__intranet_settings set `enabled`='$payslip' where id='3'";
		$db->setQuery($query);
		$db->query();
	}
	else
	{
		$query = "update #__intranet_settings set `enabled`='0' where id='3'";
		$db->setQuery($query);
		$db->query();
	}
	if($payslip==1)
	{
		$query = "TRUNCATE TABLE `#__intranet_paymentsetting`";
		$db->setQuery($query);
		$db->query();
		
		$row =& JTable::getInstance('intranet_paymentsetting', 'Table'); 
		if(!$row->bind(JRequest::get('post')))
		{
			JError::raiseError(500, $row->getError() );
		}
		$row->pf = JRequest::getVar( 'pf', '','post', 'double', JREQUEST_ALLOWRAW );
		$row->hr = JRequest::getVar( 'hr', '','post', 'double', JREQUEST_ALLOWRAW );
		$row->convenyance = JRequest::getVar( 'convenyance', '','post', 'double', JREQUEST_ALLOWRAW );
		$row->permitted_leave = JRequest::getVar( 'permitted_leave', '','post', 'int', JREQUEST_ALLOWRAW );
		$row->pf_deduction = JRequest::getVar( 'pf_deduction', '','post', 'double', JREQUEST_ALLOWRAW );
		$row->pt = JRequest::getVar( 'pt', '','post', 'double', JREQUEST_ALLOWRAW );
		$row->other_deduction = JRequest::getVar( 'deduction', '','post', 'double', JREQUEST_ALLOWRAW );
		$row->endtime = JRequest::getVar( 'endtime', '','post', 'double', JREQUEST_ALLOWRAW );
		$row->leavetype = JRequest::getVar( 'leavetype', '','post', 'string', JREQUEST_ALLOWRAW );
		$row->countryname = JRequest::getVar( 'countryname', '','post', 'string', JREQUEST_ALLOWRAW );
		if(!$row->store()){
			JError::raiseError(500, $row->getError() );
		}
	}
	
	$mainframe->redirect('index.php?option=com_intranet&task=settingcalendar');
}

function settingcalendar()
{
	global $mainframe;	
	$db =& JFactory::getDBO();
	$query = "TRUNCATE TABLE `#__intranet_calendarweeklyoff`";
	$db->setQuery($query);
	$db->query();
	$year = date("Y");
	$monthNames = Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
	$n = count($monthNames);
	for($j=0;$j<$n;$j++)
	{
		$cMonth = $j + 1;
		$timestamp = mktime(0,0,0,$cMonth,1,$year);
		$maxday    = date("t",$timestamp);				
		$thismonth = getdate ($timestamp); 
		$startday  = $thismonth['wday'];
		$curr_date = date('d');
		for ($i=0; $i<($maxday+$startday); $i++)
		{
			if(($i % 7) == 0 ) echo "";
			if($i < $startday) echo "";
			else
			{
				$d = ($i - $startday + 1);
				if(strlen($cMonth)==1)
				{
					$cMonth = "0".$cMonth;
				}
				if(strlen($d)==1)
				{
					$d = "0".$d;	
				}
				$date = $year."-".$cMonth."-".$d;
				$day = date("l",strtotime($date));
				$db = &JFactory::getDBO();
				$query = "select weekly_off from #__intranet_calendarsetting";
				$db->setQuery($query);
				$off = $db->loadAssocList(); 
				foreach($off as $row)
				{
					if($day==$row['weekly_off'] )
					{
						global $mainframe;
						$row =& JTable::getInstance('intranet_calendarweeklyoff', 'Table'); 
						if(!$row->bind(JRequest::get('post')))
						{
							JError::raiseError(500, $row->getError() );
						}
						$row->date = $date;
						$row->title = 'Holiday';
						$row->dt = $d;
						$row->year = $year;
						if(!$row->store()){
							JError::raiseError(500, $row->getError() );
						}
					}
				}
			}
			if(($i % 7) == 6 ) echo "";
		}
	}
	$mainframe->redirect('index.php?option=com_intranet&task=setting', 'Settings Successfully saved');
}
//setting ends
//Calendar Starts
function calendar()
{
	global $mainframe;	
	$db =& JFactory::getDBO();
	if($_REQUEST["month"]=='')
	{
		$month = date("m");
	}
	else
	{
		$month = $_REQUEST["month"];
		$months = strlen($month);
		if($months==2)
		{
			$month = $month;
		}
		else
		{
			$mth = 0;
			$month = $mth.$month;
		}
	}
	if($_REQUEST["year"]=='')
	{
		$year = date("Y");
	}
	else
	{
		$year = $_REQUEST["year"];
	}
	$date = $year."-".$month."-%";
	$query = "select a.* from #__intranet_calendar as a where a.date like '".$date."'";
	$db->setQuery($query);
	$rows = $db->loadObjectList();
	$query = "select b.* from #__intranet_calendarweeklyoff as b where b.date like '".$date."'";
	$db->setQuery($query);
	$rows1 = $db->loadObjectList();
	if($db->getErrorNum()){
		echo $db->stderr();
		return false;
	}
	
	IntranetHTML::calendar(&$rows,&$rows1);
}

function addeventcalendar()
{
	$curr_dt = $_REQUEST['dt'];
	IntranetHTML::addeventcalendar($curr_dt);
}

function calendarsave()
{
	global $mainframe;
	$row =& JTable::getInstance('intranet_calendar', 'Table'); 
	if(!$row->bind(JRequest::get('post')))
	{
		JError::raiseError(500, $row->getError() );
	}
	$event = JRequest::getVar( 'event_display', '','post', 'int', JREQUEST_ALLOWRAW );
	$holiday = JRequest::getVar( 'holiday_display', '','post', 'int', JREQUEST_ALLOWRAW );
	if($event==1)
	{
		$row->date = JRequest::getVar( 'date', '','post', 'string', JREQUEST_ALLOWRAW );
		$row->event = $event;
		$row->event_title = JRequest::getVar( 'event_title', '','post', 'string', JREQUEST_ALLOWRAW );
		$row->eventstart_time = JRequest::getVar( 'event_starttime', '','post', 'string', JREQUEST_ALLOWRAW );
		$row->eventend_time	= JRequest::getVar( 'event_endtime', '','post', 'string', JREQUEST_ALLOWRAW );
		$row->holiday = 0;
		$row->holiday_type = 0;
		$row->holiday_title ='';
		$row->dt = JRequest::getVar( 'dt', '','post', 'string', JREQUEST_ALLOWRAW );
		$row->year = JRequest::getVar( 'year', '','post', 'string', JREQUEST_ALLOWRAW );
	}
	if($holiday==1)
	{
		$row->date = JRequest::getVar( 'date', '','post', 'string', JREQUEST_ALLOWRAW );
		$row->event = 0;
		$row->event_title = '';
		$row->eventstart_time = '00:00:00';
		$row->eventend_time = '00:00:00';
		$row->holiday = $holiday;
		$row->holiday_type = JRequest::getVar( 'holiday_type', '','post', 'string', JREQUEST_ALLOWRAW );
		$row->holiday_title = JRequest::getVar( 'holiday_title', '','post', 'string', JREQUEST_ALLOWRAW );
		$row->dt = JRequest::getVar( 'dt', '','post', 'string', JREQUEST_ALLOWRAW );
		$row->year = JRequest::getVar( 'year', '','post', 'string', JREQUEST_ALLOWRAW );
	}
	if(!$row->store()){
		JError::raiseError(500, $row->getError() );
	}
	$mainframe->redirect('index.php?option=com_intranet&task=calendar', 'Event Successfully Added / Edited');
}

function editeventcalendar()
{
	$id = JRequest::getVar('id', 0, 'get', 'int');
	$db	=& JFactory::getDBO();
	$cid = JRequest::getVar('cid',array(0),'','array');
	JArrayHelper::toInteger($cid, array(0));
	$id = $cid[0];
	$row =& JTable::getInstance('intranet_calendar', 'Table');
	$row->load( $id);
	IntranetHTML::editeventcalendar(&$row);
}

function deleteeventcalendar()
{
	global $mainframe;
	$db =& JFactory::getDBO();
	$cid = JRequest::getVar('cid',array(),'','array');
	JArrayHelper::toInteger($cid);
	if (count( $cid )) {
		$cids = implode( ',', $cid );
		$query = 'DELETE FROM #__intranet_calendar'
		. ' WHERE id IN ( '. $cids .' )'
		;
		$db->setQuery( $query );
		if (!$db->query()) {
			echo "<script> alert('".$db->getErrorMsg(true)."'); 
		   window.history.go(-1); </script>\n";
		}
	}
	$mainframe->redirect('index.php?option=com_intranet&task=calendar', 'Event Successfully Deleted');
}
//calendar ends
//Users starts
function users()
{
	global $mainframe;	
	$db =& JFactory::getDBO();
	$filter_order = $mainframe->getUserStateFromRequest( $option.'filter_order','filter_order','id','cmd' );
	$filter_order_Dir = $mainframe->getUserStateFromRequest( $option.'filter_order_Dir','filter_order_Dir','','word' );
	$filter_state = $mainframe->getUserStateFromRequest( $option.'filter_state', 'filter_state', '','word' );
	$search = $mainframe->getUserStateFromRequest( $option.'search','search','','string' );
	$search = JString::strtolower( $search );
	$limit= $mainframe->getUserStateFromRequest('global.list.limit','limit', $mainframe->getCfg('list_limit'), 'int');
	$limitstart= $mainframe->getUserStateFromRequest($option.'.limitstart', 'limitstart', 0, 'int');
	
	$where = array();
	if ( $search ) {
		$where[] = 'name LIKE "%'.$db->getEscaped($search).'%"';
	}
	$where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
	if ($filter_order == 'id'){
		$orderby 	= ' ORDER BY id';
	} else {
		$orderby 	= ' ORDER BY '. 
		 $filter_order .' '. $filter_order_Dir .', id';
	}
	// get the total number of records
	$query = 'SELECT COUNT(*)'
	. ' FROM #__intranet_users'
	. $where
	;
	$db->setQuery( $query );
	$total = $db->loadResult();
	jimport('joomla.html.pagination');
	$pageNav = new JPagination( $total, $limitstart, $limit );
	$query = "SELECT * FROM #__intranet_users". $where. $orderby;
	$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
	$rows = $db->loadObjectList();
	if($db->getErrorNum()){
		echo $db->stderr();
		return false;
	}
	// table ordering
	$lists['order_Dir']	= $filter_order_Dir;
	$lists['order']		= $filter_order;
	// search filter	
	$lists['search']= $search;	
	
	IntranetHTML::users(&$rows, &$pageNav, &$lists);
}

function updateuser()
{
	global $mainframe;
	$db = &JFactory::getDBO();
	$query = "TRUNCATE TABLE `#__intranet_users`";
	$db->setQuery($query);
	$db->query();
	$query = "insert into #__intranet_users (users_id,name,email,username,password) select id,name,email,username,password from #__users";
	$db->setQuery($query);
	$db->query();
	
	$mainframe->redirect('index.php?option=com_intranet&task=users', 'Users Successfully updated');
}

function usersinsert()
{
	IntranetHTML::usersinsert();
}

function Userssave()
{
	global $mainframe;
	$row =& JTable::getInstance('intranet_users', 'Table');
	if(!$row->bind(JRequest::get('post')))
	{
		JError::raiseError(500, $row->getError() );
	}
	
	$firstname = JRequest::getVar( 'firstname', '','post', 'string', JREQUEST_ALLOWRAW );
	$lastname = JRequest::getVar( 'lastname', '','post', 'string', JREQUEST_ALLOWRAW );
	$username = JRequest::getVar( 'username', '','post', 'string', JREQUEST_ALLOWRAW );
	$password = JRequest::getVar( 'password', '','post', 'string', JREQUEST_ALLOWRAW );
	$email_id = JRequest::getVar( 'email', '','post', 'string', JREQUEST_ALLOWRAW );
	$date = date('Y-m-d H:m:s');
	$name = $firstname.$lastname;		
	$password = MD5($password);
	
	$db = &JFactory::getDBO();
	$query = "select username,email from #__users where username='$username' or email='$email_id'";
	$db->setQuery($query);
	$result = $db->loadRow();
	$result1 = $result[0];
	$result2 = $result[1];
	if($result1=='' && $result2=='')
	{
		$query = "INSERT INTO #__users (`name`, `username`, `email`, `password`, `usertype`, `gid`, `registerDate`) VALUES ('$name', '$username', '$email_id', '$password', 'Registered', '18', '$date')";
		$db->setQuery($query);
		$result = $db->query();
			
		$query = "SELECT id,name,username,password from #__users where email = '$email_id'";
		$db->setQuery( $query );
		$result = $db->query();
		while($row1=mysql_fetch_array($result))
		{
			$name1 = $row1["name"];
			$id1 = $row1["id"];
			$username = $row1["username"];
			$password = $row1["password"];
		}
			
		$query = "INSERT INTO #__core_acl_aro (`section_value`, `value`, `name`) VALUES ('users', '$id1', '$name1')";
		$db->setQuery($query);
		$result = $db->query();
			
		$query = "SELECT id from #__core_acl_aro where value='$id1'";
		$db->setQuery($query);
		$result = $db->loadRow();
		$result = $result[0];
			
		$query = "INSERT INTO #__core_acl_groups_aro_map (`group_id`,`aro_id`) VALUES ('18', '$result')";
		$db->setQuery($query);
		$result = $db->query();	

		$query = "select * from #__intranet_paymentsetting";
		$db->setQuery($query);
		$payment = $db->loadRow();
		
		$pf = $payment[1];
		$hr = $payment[2];
		$convenyance = $payment[3];
		$pf_deduction = $payment[5];
		$pt = $payment[6];
		$other_deduction = $payment[7];
		$basic_pay = JRequest::getVar( 'basic_pay', '','post', 'double', JREQUEST_ALLOWRAW );
		
		$total_salary = $basic_pay + ((($basic_pay * $pf) / 100) + (($basic_pay * $hr) / 100) + (($basic_pay * $convenyance) / 100));
		$total_salary = round($total_salary,2); 
		$deduction = (($basic_pay * $pf_deduction) / 100) + (($basic_pay * $pt) / 100) + (($basic_pay * $other_deduction) / 100);
		$deduction = round($deduction,2);
		$monthly_salary = $total_salary - $deduction;
		
		$row->users_id = $id1;
		$row->name = $name;
		$row->email = $email_id;
		$row->username = $username;
		$row->password = $password;
		$row->dob = JRequest::getVar( 'dob', '','post', 'string', JREQUEST_ALLOWRAW );
		$row->official_address = JRequest::getVar( 'official_address', '','post', 'string', JREQUEST_ALLOWRAW );
		$row->residencial_address = JRequest::getVar( 'residencial_address', '','post', 'string', JREQUEST_ALLOWRAW );
		$row->phone_no = JRequest::getVar( 'phone_no', '','post', 'string', JREQUEST_ALLOWRAW );
		$row->mobile_no = JRequest::getVar( 'mobile_no', '','post', 'string', JREQUEST_ALLOWRAW );
		$row->position = JRequest::getVar( 'position', '','post', 'string', JREQUEST_ALLOWRAW );
		$row->basic_pay = $basic_pay;
		$row->monthly_salary = $monthly_salary;
		$row->total_salary = $total_salary;
		
		if(!$row->store()){
			JError::raiseError(500, $row->getError() );
		}
		$mainframe->redirect('index.php?option=com_intranet&task=users', 'Users Successfully Added ');
	}
	else
	{
		$mainframe->redirect('index.php?option=com_intranet&task=usersinsert', 'This username or Email-Id exits ');
	}
}

function usersedit()
{
	$id = JRequest::getVar('id', 0, 'get', 'int');
	$db	=& JFactory::getDBO();
	$cid = JRequest::getVar('cid',array(0),'','array');
	JArrayHelper::toInteger($cid, array(0));
	$id = $cid[0];
	$row =& JTable::getInstance('intranet_users', 'Table');
	$row->load( $id);
	IntranetHTML::edituser(&$row);
}

function Userseditsave()
{
	global $mainframe;
	$row =& JTable::getInstance('intranet_users', 'Table');
	if(!$row->bind(JRequest::get('post')))
	{
		JError::raiseError(500, $row->getError() );
	}
	$name = JRequest::getVar( 'name', '','post', 'string', JREQUEST_ALLOWRAW );
	$username = JRequest::getVar( 'username', '','post', 'string', JREQUEST_ALLOWRAW );
	$password = JRequest::getVar( 'password', '','post', 'string', JREQUEST_ALLOWRAW );
	$email_id = JRequest::getVar( 'email', '','post', 'string', JREQUEST_ALLOWRAW );
	$user_id = JRequest::getVar( 'users_id', '','post', 'string', JREQUEST_ALLOWRAW );
	$u_id = JRequest::getVar( 'id', '','post', 'string', JREQUEST_ALLOWRAW );
	$date = date('Y-m-d H:m:s');
	$password = MD5($password);
	
	$db = &JFactory::getDBO();
	$query = "select id from #__users where username='$username'";
	$db->setQuery($query);
	$result = $db->loadRow();
	$ids = $result[0]; 
	$query = "select id from #__users where email='$email_id'";
	$db->setQuery($query);
	$result = $db->loadRow();
	$ids1 = $result[0]; 
	if(($ids!=$user_id && $ids!=''))
	{
		echo "<script> alert('User name already exits'); window.history.go(-1); </script>";
	}
	else if (($ids1!=$user_id && $ids1!=''))
	{
		echo "<script> alert('Email id already exits'); window.history.go(-1); </script>";
	}
	else
	{
		$query = "update #__users set `name`='$name', `username`='$username', `email`='$email_id', `password`='$password' where id='$user_id'";
		$db->setQuery($query);
		$result = $db->query();
		
		$query = "select * from #__intranet_paymentsetting";
		$db->setQuery($query);
		$payment = $db->loadRow();
		
		$pf = $payment[1];
		$hr = $payment[2];
		$convenyance = $payment[3];
		$pf_deduction = $payment[5];
		$pt = $payment[6];
		$other_deduction = $payment[7];
		$basic_pay = JRequest::getVar( 'basic_pay', '','post', 'double', JREQUEST_ALLOWRAW );
		
		$total_salary = $basic_pay + ((($basic_pay * $pf) / 100) + (($basic_pay * $hr) / 100) + (($basic_pay * $convenyance) / 100));	
		$total_salary = round($total_salary,2);
		$deduction = (($basic_pay * $pf_deduction) / 100) + (($basic_pay * $pt) / 100) + (($basic_pay * $other_deduction) / 100);	
		$deduction = round($deduction,2);
		$monthly_salary = $total_salary - $deduction; 
		
		$row->users_id = $user_id;
		$row->name = $name;
		$row->email = $email_id;
		$row->username = $username;
		$row->password = $password;
		$row->dob = JRequest::getVar( 'dob', '','post', 'string', JREQUEST_ALLOWRAW );
		$row->official_address = JRequest::getVar( 'official_address', '','post', 'string', JREQUEST_ALLOWRAW );
		$row->residencial_address = JRequest::getVar( 'residencial_address', '','post', 'string', JREQUEST_ALLOWRAW );
		$row->phone_no = JRequest::getVar( 'phone_no', '','post', 'string', JREQUEST_ALLOWRAW );
		$row->mobile_no = JRequest::getVar( 'mobile_no', '','post', 'string', JREQUEST_ALLOWRAW );
		$row->position = JRequest::getVar( 'position', '','post', 'string', JREQUEST_ALLOWRAW );
		$row->basic_pay = $basic_pay;
		$row->monthly_salary = $monthly_salary;
		$row->total_salary = $total_salary;
		
		if(!$row->store()){
			JError::raiseError(500, $row->getError() );
		}
		$mainframe->redirect('index.php?option=com_intranet&task=users', 'Users Successfully Added ');
	}
}

function usersremove()
{
	global $mainframe;
	$db =& JFactory::getDBO();
	$cid = JRequest::getVar('cid',array(),'','array'); 
	JArrayHelper::toInteger($cid);
	
	if (count( $cid )) 
	{
		$cids = implode( ',', $cid );
		$query = "select users_id from #__intranet_users where id IN (".$cids.")";
		$db->setQuery($query);
		$result = $db->loadAssocList(); 
		foreach($result as $rows)
		{ 
			$query = "select id from #__core_acl_aro where value IN (".$rows['users_id'].")";
			$db->setQuery($query);
			$result1 = $db->loadAssocList();
			foreach($result1 as $rows2)
			{
				$query = "delete from #__core_acl_groups_aro_map where aro_id IN (".$rows2['id'].")";
				$db->setQuery($query);
				$db->query();
			}
			$query = "delete from #__core_acl_aro where value IN (".$rows['users_id'].")";
			$db->setQuery($query);
			$db->query();
			$query = "delete from #__users where id IN (".$rows['users_id'].")";
			$db->setQuery($query);
			$db->query();
		}			
		$query = 'DELETE FROM #__intranet_users'
		. ' WHERE id IN ( '. $cids .' )'
		; 
		$db->setQuery( $query );
		if (!$db->query())
		{
			echo "<script> alert('".$db->getErrorMsg(true)."'); 
		   window.history.go(-1); </script>\n";
		}
		
	}
	$mainframe->redirect('index.php?option=com_intranet&task=users', 'Users Successfully Deleted');	
}
//User ends
//Daily attendance starts
function dailyattendance()
{
	global $mainframe;	
	$db =& JFactory::getDBO();
	$filter_order = $mainframe->getUserStateFromRequest( $option.'filter_order','filter_order','id','cmd' );
	$filter_order_Dir = $mainframe->getUserStateFromRequest( $option.'filter_order_Dir','filter_order_Dir','','word' );
	$filter_state = $mainframe->getUserStateFromRequest( $option.'filter_state', 'filter_state', '','word' );
	$users = $mainframe->getUserStateFromRequest( $option.'users','users','','int' );
	$month = $mainframe->getUserStateFromRequest( $option.'month','month','','int' );
	$year = $mainframe->getUserStateFromRequest( $option.'year','year','','int' );
	$limit= $mainframe->getUserStateFromRequest('global.list.limit','limit', $mainframe->getCfg('list_limit'), 'int');
	$limitstart= $mainframe->getUserStateFromRequest($option.'.limitstart', 'limitstart', 0, 'int');
	
	$where = array();
	if ( $users ) {
		$where[] = 'users_id="'.$users.'"';
	}
	if( $month )
	{
		$where[] = 'month="'.$month.'"';
	}
	if($year)
	{
		$where[] = 'year="'.$year.'"';
	}
	$where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
	if ($filter_order == 'id'){
		$orderby 	= ' ORDER BY id';
	} else {
		$orderby 	= ' ORDER BY '. 
		 $filter_order .' '. $filter_order_Dir .', id';
	}
	// get the total number of records
	$query = 'SELECT COUNT(*)'
	. ' FROM #__intranet_dailyattendance'
	. $where
	;
	$db->setQuery( $query );
	$total = $db->loadResult();
	jimport('joomla.html.pagination');
	$pageNav = new JPagination( $total, $limitstart, $limit );
	$query = "SELECT * FROM #__intranet_dailyattendance". $where. $orderby;
	$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
	$rows = $db->loadObjectList();
	if($db->getErrorNum()){
		echo $db->stderr();
		return false;
	}
	// table ordering
	$lists['order_Dir']	= $filter_order_Dir;
	$lists['order']		= $filter_order;
	// search filter	
	$lists['users']= $users;
	$lists['month']= $month;
	$lists['year']= $year;
	
	IntranetHTML::dailyattendance(&$rows, &$pageNav, &$lists);	
}

function attendanceinsert()
{
	IntranetHTML::attendanceinsert();
}

function attendancesave()
{
	global $mainframe;
	$row =& JTable::getInstance('intranet_dailyattendance', 'Table');
	if(!$row->bind(JRequest::get('post')))
	{
		JError::raiseError(500, $row->getError() );
	}
	
	$db = &JFactory::getDBO();
	$users = JRequest::getVar( 'users', '','post', 'string', JREQUEST_ALLOWRAW );
	$date = JRequest::getVar( 'today_date', '','post', 'string', JREQUEST_ALLOWRAW );
	$query = "select name from #__intranet_users where users_id='$users'";
	$db->setQuery($query);
	$name = $db->loadRow();
	$user_name = $name[0];
	$td = explode("-", $date);
	$year = $td[0];
	$month = $td[1];
	$in_time = JRequest::getVar( 'in_time', '','post', 'string', JREQUEST_ALLOWRAW );
	$out_time = JRequest::getVar( 'out_time', '','post', 'string', JREQUEST_ALLOWRAW );
	$a1 = explode(":",$in_time);
	$a2 = explode(":",$out_time);
	$time1 = (($a1[0]*60*60)+($a1[1]*60)+($a1[2]));
	$time2 = (($a2[0]*60*60)+($a2[1]*60)+($a2[2]));
	$diff = abs($time1-$time2);
	$hours = floor($diff/(60*60));
	$mins = floor(($diff-($hours*60*60))/(60));
	$secs = floor(($diff-(($hours*60*60)+($mins*60))));
	$total_hours = $hours.":".$mins.":".$secs;
	$row->users_id = $users;
	$row->name = $user_name;
	$row->today_date = $date;
	$row->in_time = JRequest::getVar( 'in_time', '','post', 'string', JREQUEST_ALLOWRAW );
	$row->out_time = JRequest::getVar( 'out_time', '','post', 'string', JREQUEST_ALLOWRAW );
	$row->month = $month;
	$row->year = $year;
	$row->total_hours = $total_hours;
	if(!$row->store()){
		JError::raiseError(500, $row->getError() );
	}
	$mainframe->redirect('index.php?option=com_intranet&task=dailyattendance', 'Users Attendace Successfully Added ');	
}

function dailyattendanceedit()
{
	$id = JRequest::getVar('id', 0, 'get', 'int');
	$db	=& JFactory::getDBO();
	$cid = JRequest::getVar('cid',array(0),'','array');
	JArrayHelper::toInteger($cid, array(0));
	$id = $cid[0];
	$row =& JTable::getInstance('intranet_dailyattendance', 'Table');
	$row->load( $id);
	IntranetHTML::dailyattendanceedit(&$row);
}

function attendanceeditsave()
{
	global $mainframe;
	$row =& JTable::getInstance('intranet_dailyattendance', 'Table');
	if(!$row->bind(JRequest::get('post')))
	{
		JError::raiseError(500, $row->getError() );
	}
	$in_time = JRequest::getVar( 'in_time', '','post', 'string', JREQUEST_ALLOWRAW );
	$out_time = JRequest::getVar( 'out_time', '','post', 'string', JREQUEST_ALLOWRAW );
	$a1 = explode(":",$in_time);
	$a2 = explode(":",$out_time);
	$time1 = (($a1[0]*60*60)+($a1[1]*60)+($a1[2]));
	$time2 = (($a2[0]*60*60)+($a2[1]*60)+($a2[2]));
	$diff = abs($time1-$time2);
	$hours = floor($diff/(60*60));
	$mins = floor(($diff-($hours*60*60))/(60));
	$secs = floor(($diff-(($hours*60*60)+($mins*60))));
	$total_hours = $hours.":".$mins.":".$secs;
	
	$row->users_id = JRequest::getVar( 'users_id', '','post', 'string', JREQUEST_ALLOWRAW );
	$row->name = JRequest::getVar( 'name', '','post', 'string', JREQUEST_ALLOWRAW );
	$row->today_date = JRequest::getVar( 'today_date', '','post', 'string', JREQUEST_ALLOWRAW );
	$row->in_time = JRequest::getVar( 'in_time', '','post', 'string', JREQUEST_ALLOWRAW );
	$row->out_time = JRequest::getVar( 'out_time', '','post', 'string', JREQUEST_ALLOWRAW );
	$row->month = JRequest::getVar( 'month', '','post', 'string', JREQUEST_ALLOWRAW );
	$row->year = JRequest::getVar( 'year', '','post', 'string', JREQUEST_ALLOWRAW );
	$row->total_hours = $total_hours;
	if(!$row->store()){
		JError::raiseError(500, $row->getError() );
	}
	$mainframe->redirect('index.php?option=com_intranet&task=dailyattendance', 'Users Attendace Successfully Edited ');
}

function attendanceremove()
{
	global $mainframe;
	$db =& JFactory::getDBO();
	$cid = JRequest::getVar('cid',array(),'','array');
	JArrayHelper::toInteger($cid);
	if (count( $cid )) {
		$cids = implode( ',', $cid );
		$query = 'DELETE FROM #__intranet_dailyattendance'
		. ' WHERE id IN ( '. $cids .' )'
		;
		$db->setQuery( $query );
		if (!$db->query()) {
			echo "<script> alert('".$db->getErrorMsg(true)."'); 
		   window.history.go(-1); </script>\n";
		}
	}
	$mainframe->redirect('index.php?option=com_intranet&task=daliyattendance', 'Attendance Successfully Deleted');
}
//Daliy Attendance Ends
//Month Attendance Starts
function monthattendance()
{
	global $mainframe;	
	$db =& JFactory::getDBO();
	
	$query = "select users_id,name,today_date,month,year from #__intranet_dailyattendance group by today_date,name having count(*) >= 1 order by users_id asc limit 0,300 ";
	$db->setQuery($query);
	$mon = $db->loadAssocList();	
	foreach($mon as $row)
	{
		$users_id = $row['users_id'];
		$name = $row['name'];
		$month = $row['month'];
		if(strlen($month)==1)
		{
			$month = "0".$month;
		}
		$year = $row['year'];
		$total_hours = 0;
		$query = "select today_date from #__intranet_dailyattendance where users_id='$users_id' and month='$month' and year='$year' group by today_date having count(*) >= 1";
		$db->setQuery($query);
		$days = $db->loadAssocList();
		
		$query = "select total_hours from #__intranet_dailyattendance where users_id='$users_id' and month='$month' and year='$year' order by users_id asc limit 0,300";
		$db->setQuery($query);
		$thrs = $db->loadResultArray();		
		$seconds = 0;
		foreach ($thrs as $time)
		{
			list($hour,$minute,$second) = explode(':', $time);
			$seconds += $hour*3600;
			$seconds += $minute*60;
			$seconds += $second;
		}
		$hours = floor($seconds/3600);
		$seconds -= $hours*3600;
		$minutes  = floor($seconds/60);
		$seconds -= $minutes*60;
		$total_hours = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
		
		$query = "select * from #__intranet_calendarweeklyoff where date like '%".$year."-".$month."-%' and year='$year'";
		$db->setQuery($query);
		$week_off = $db->loadResultArray(); 

		$query = "select * from #__intranet_calendar where holiday='1' and date like '%".$year."-".$month."-%'";
		$db->setQuery($query);
		$company_holiday = $db->loadResultArray();
		
		$total_days = cal_days_in_month(CAL_GREGORIAN, $month, $year) ;
		$days_worked = count($days);
		$weekoff = count($week_off);
		$companyholiday = count($company_holiday);
		$office_days = $total_days - ($weekoff + $companyholiday);
		$leave_days = $office_days - $days_worked;
		
		$query = "select name from #__intranet_monthattendance where users_id='$users_id' and month='$month'";
		$db->setQuery($query);
		$result = $db->loadRow();
		$nm = $result[0];
		if($nm=='')
		{
			$query = "insert into #__intranet_monthattendance (`users_id`, `name`, `month`, `year`, `days_worked`, `leave_days`, `office_days`, `companyholiday_days`, `weekoff_days`, `total_days`, `total_hours`) values ('$users_id', '$name', '$month', '$year', '$days_worked', '$leave_days', '$office_days', '$companyholiday', '$weekoff', '$total_days', '$total_hours')";
			$db->setQuery($query);
			$db->query();
		}
		else
		{
			$query = "update #__intranet_monthattendance set `name`='$name', `days_worked`='$days_worked', `leave_days`='$leave_days', `office_days`='$office_days', `companyholiday_days`='$companyholiday', `weekoff_days`='$weekoff', `total_days`='$total_days', `total_hours`='$total_hours' where users_id='$users_id' and month='$month'";
			$db->setQuery($query);
			$db->query();
		}		
	}
	
	$filter_order = $mainframe->getUserStateFromRequest( $option.'filter_order','filter_order','id','cmd' );
	$filter_order_Dir = $mainframe->getUserStateFromRequest( $option.'filter_order_Dir','filter_order_Dir','','word' );
	$filter_state = $mainframe->getUserStateFromRequest( $option.'filter_state', 'filter_state', '','word' );
	$users = $mainframe->getUserStateFromRequest( $option.'users','users','','int' );
	$month = $mainframe->getUserStateFromRequest( $option.'month','month','','int' );
	$year = $mainframe->getUserStateFromRequest( $option.'year','year','','int' );
	$limit= $mainframe->getUserStateFromRequest('global.list.limit','limit', $mainframe->getCfg('list_limit'), 'int');
	$limitstart= $mainframe->getUserStateFromRequest($option.'.limitstart', 'limitstart', 0, 'int');
	
	$where = array();
	if ( $users ) {
		$where[] = 'users_id="'.$users.'"';
	}
	if( $month )
	{
		$where[] = 'month="'.$month.'"';
	}
	if($year)
	{
		$where[] = 'year="'.$year.'"';
	}
	$where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
	if ($filter_order == 'id'){
		$orderby 	= ' ORDER BY id';
	} else {
		$orderby 	= ' ORDER BY '. 
		 $filter_order .' '. $filter_order_Dir .', id';
	}
	// get the total number of records
	$query = 'SELECT COUNT(*)'
	. ' FROM #__intranet_monthattendance'
	. $where
	;
	$db->setQuery( $query );
	$total = $db->loadResult();
	jimport('joomla.html.pagination');
	$pageNav = new JPagination( $total, $limitstart, $limit );
	$query = "SELECT * FROM #__intranet_monthattendance". $where. $orderby;
	$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
	$rows = $db->loadObjectList();
	if($db->getErrorNum()){
		echo $db->stderr();
		return false;
	}
	// table ordering
	$lists['order_Dir']	= $filter_order_Dir;
	$lists['order']		= $filter_order;
	// search filter	
	$lists['users']= $users;
	$lists['month']= $month;
	$lists['year']= $year;
	
	IntranetHTML::monthattendance(&$rows, &$pageNav, &$lists);	
}
//Month Attendance Ends
//Pay slip Starts
function payslip()
{
	global $mainframe;	
	$db =& JFactory::getDBO();
	$filter_order = $mainframe->getUserStateFromRequest( $option.'filter_order','filter_order','id','cmd' );
	$filter_order_Dir = $mainframe->getUserStateFromRequest( $option.'filter_order_Dir','filter_order_Dir','','word' );
	$filter_state = $mainframe->getUserStateFromRequest( $option.'filter_state', 'filter_state', '','word' );
	$users = $mainframe->getUserStateFromRequest( $option.'users','users','','int' );
	$month = $mainframe->getUserStateFromRequest( $option.'month','month','','int' );
	$year = $mainframe->getUserStateFromRequest( $option.'year','year','','int' );
	$limit= $mainframe->getUserStateFromRequest('global.list.limit','limit', $mainframe->getCfg('list_limit'), 'int');
	$limitstart= $mainframe->getUserStateFromRequest($option.'.limitstart', 'limitstart', 0, 'int');
	
	$where = array();
	if ( $users ) {
		$where[] = 'users_id="'.$users.'"';
	}
	if( $month )
	{
		$where[] = 'month="'.$month.'"';
	}
	if($year)
	{
		$where[] = 'year="'.$year.'"';
	}
	$where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
	if ($filter_order == 'id'){
		$orderby 	= ' ORDER BY id';
	} else {
		$orderby 	= ' ORDER BY '. 
		 $filter_order .' '. $filter_order_Dir .', id';
	}
	// get the total number of records
	$query = 'SELECT COUNT(*)'
	. ' FROM #__intranet_payslip'
	. $where
	;
	$db->setQuery( $query );
	$total = $db->loadResult();
	jimport('joomla.html.pagination');
	$pageNav = new JPagination( $total, $limitstart, $limit );
	$query = "SELECT * FROM #__intranet_payslip". $where. $orderby;
	$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
	$rows = $db->loadObjectList();
	if($db->getErrorNum()){
		echo $db->stderr();
		return false;
	}
	// table ordering
	$lists['order_Dir']	= $filter_order_Dir;
	$lists['order']		= $filter_order;
	// search filter	
	$lists['users']= $users;
	$lists['month']= $month;
	$lists['year']= $year;
	
	IntranetHTML::payslip(&$rows, &$pageNav, &$lists);
}

function payslipinsert()
{
	IntranetHTML::payslipinsert();
}

function payslipsave()
{
	global $mainframe;
	$db = &JFactory::getDBO();
	$row =& JTable::getInstance('intranet_payslip', 'Table');
	if(!$row->bind(JRequest::get('post')))
	{
		JError::raiseError(500, $row->getError() );
	}
	
	$query = "select * from #__intranet_paymentsetting";
	$db->setQuery($query);
	$payment = $db->loadRow();
	$pf = $payment[1];
	$hr = $payment[2];
	$convenyance = $payment[3];
	$permitted_leave = $payment[4];
	$pf_deduction = $payment[5];
	$pt = $payment[6];
	$other_deduction = $payment[7];
	
	$basic_pay = JRequest::getVar( 'actual_basic_pay', '','post', 'double', JREQUEST_ALLOWRAW );
	$leave_days = JRequest::getVar( 'leave_days', '','post', 'int', JREQUEST_ALLOWRAW );
	$working_days = JRequest::getVar( 'working_days', '','post', 'int', JREQUEST_ALLOWRAW );
	$varaible_allowance = JRequest::getVar( 'variable_allowance', '','post', 'string', JREQUEST_ALLOWRAW );
	$var = strpos($varaible_allowance,"%");
	
	if($leave_days!=0)
	{
		$basicpay_month = $basic_pay - (($leave_days - $permitted_leave) * ($basic_pay / $working_days));
		$basicpay_month = round($basicpay_month,2); 
	}
	else
	{
		$basicpay_month = $basic_pay;
	}
	$Gross_salary = $basicpay_month + ((($basicpay_month * $pf) / 100) + (($basicpay_month * $hr) / 100) + (($basicpay_month * $convenyance) / 100));
	$Gross_salary = round($Gross_salary,2); 
	$deduction = (($basicpay_month * $pf_deduction) / 100) + (($basicpay_month * $pt) / 100) + (($basicpay_month * $other_deduction) / 100);
	$deduction = round($deduction,2); 
	$salary_month = $Gross_salary - $deduction; 
	
	if($var > 0)
	{
		$varaible_allowance = $varaible_allowance;
		$varaible_allowance1 = substr($varaible_allowance, 0, -1);
		$tot = ($basicpay_month * $varaible_allowance1) /100;
		$tot = round($tot,2);
		$salary_month = $salary_month + $tot; 
	}
	else
	{
		$varaible_allowance = $varaible_allowance;
		$salary_month = $salary_month + $varaible_allowance;
	}
	
	$row->users_id = JRequest::getVar( 'users_id', '','post', 'int', JREQUEST_ALLOWRAW );
	$row->month = JRequest::getVar( 'month', '','post', 'int', JREQUEST_ALLOWRAW );
	$row->year = JRequest::getVar( 'year', '','post', 'int', JREQUEST_ALLOWRAW );
	$row->variable_allowance = $varaible_allowance;
	$row->working_days = $working_days;
	$row->worked_days = JRequest::getVar( 'worked_days', '','post', 'int', JREQUEST_ALLOWRAW );
	$row->leave_days = $leave_days;
	$row->holidays = JRequest::getVar( 'holidays', '','post', 'int', JREQUEST_ALLOWRAW );
	$row->basicpay_month = $basicpay_month;
	$row->totalsalary_month = $Gross_salary;
	$row->deduction_month = $deduction;
	$row->salary_month = $salary_month;
	
	if(!$row->store()){
		JError::raiseError(500, $row->getError() );
	}
	$mainframe->redirect('index.php?option=com_intranet&task=payslip', 'New Pay Slip added / edited successfully  ');
}

function payslipedit()
{
	$id = JRequest::getVar('id', 0, 'get', 'int');
	$db	=& JFactory::getDBO();
	$cid = JRequest::getVar('cid',array(0),'','array');
	JArrayHelper::toInteger($cid, array(0));
	$id = $cid[0];
	$row =& JTable::getInstance('intranet_payslip', 'Table');
	$row->load( $id);
	IntranetHTML::payslipedit(&$row);
}

function payslipremove()
{
	global $mainframe;
	$db =& JFactory::getDBO();
	$cid = JRequest::getVar('cid',array(),'','array');
	JArrayHelper::toInteger($cid);
	if (count( $cid )) {
		$cids = implode( ',', $cid );
		$query = 'DELETE FROM #__intranet_payslip'
		. ' WHERE id IN ( '. $cids .' )'
		;
		$db->setQuery( $query );
		if (!$db->query()) {
			echo "<script> alert('".$db->getErrorMsg(true)."'); 
		   window.history.go(-1); </script>\n";
		}
	}
	$mainframe->redirect('index.php?option=com_intranet&task=payslip', 'Pay slip Successfully deleted');
}
//payslip ends
//Leave Request starts
function leaverequest()
{
	global $mainframe;	
	$db =& JFactory::getDBO();
	$filter_order = $mainframe->getUserStateFromRequest( $option.'filter_order','filter_order','id','cmd' );
	$filter_order_Dir = $mainframe->getUserStateFromRequest( $option.'filter_order_Dir','filter_order_Dir','','word' );
	$filter_state = $mainframe->getUserStateFromRequest( $option.'filter_state', 'filter_state', '','word' );
	$users = $mainframe->getUserStateFromRequest( $option.'users','users','','int' );
	$month = $mainframe->getUserStateFromRequest( $option.'month','month','','int' );
	$year = $mainframe->getUserStateFromRequest( $option.'year','year','','int' );
	$limit= $mainframe->getUserStateFromRequest('global.list.limit','limit', $mainframe->getCfg('list_limit'), 'int');
	$limitstart= $mainframe->getUserStateFromRequest($option.'.limitstart', 'limitstart', 0, 'int');
	
	$where = array();
	if ( $users ) {
		$where[] = 'fromusers_id="'.$users.'"';
	}
	if( $month )
	{
		$where[] = 'month="'.$month.'"';
	}
	if($year)
	{
		$where[] = 'year="'.$year.'"';
	}
	$where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
	if ($filter_order == 'id'){
		$orderby 	= ' ORDER BY id';
	} else {
		$orderby 	= ' ORDER BY '. 
		 $filter_order .' '. $filter_order_Dir .', id';
	}
	// get the total number of records
	$query = 'SELECT COUNT(*)'
	. ' FROM #__intranet_leaverequest'
	. $where
	;
	$db->setQuery( $query );
	$total = $db->loadResult();
	jimport('joomla.html.pagination');
	$pageNav = new JPagination( $total, $limitstart, $limit );
	$query = "SELECT * FROM #__intranet_leaverequest". $where. $orderby;
	$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
	$rows = $db->loadObjectList();
	if($db->getErrorNum()){
		echo $db->stderr();
		return false;
	}
	// table ordering
	$lists['order_Dir']	= $filter_order_Dir;
	$lists['order']		= $filter_order;
	// search filter	
	$lists['users']= $users;
	$lists['month']= $month;
	$lists['year']= $year;
	
	IntranetHTML::leaverequest(&$rows, &$pageNav, &$lists);
}

function leaverequestinsert()
{
	IntranetHTML::leaverequestinsert();
}

function leaverequestsave()
{
	global $mainframe;
	$db = &JFactory::getDBO();
	$row =& JTable::getInstance('intranet_leaverequest', 'Table');
	if(!$row->bind(JRequest::get('post')))
	{
		JError::raiseError(500, $row->getError() );
	}
	
	$approved = JRequest::getVar( 'approved', '','post', 'int', JREQUEST_ALLOWRAW );
	if($approved==1)
	{
		$approved = $approved;
		echo $dateapproved = JRequest::getVar( 'dateapproved', '','post', 'int', JREQUEST_ALLOWRAW );
		if($dateapproved=='0000-00-00')
		{
			echo $dateapproved = date('Y-m-d');
		}
	}
	else
	{
		$approved = 0;
		$dateapproved = '0000-00-00';
	}
	$row->daterequested = JRequest::getVar( 'daterequested', '','post', 'int', JREQUEST_ALLOWRAW );
	$row->fromusers_id = JRequest::getVar( 'fromusers_id', '','post', 'int', JREQUEST_ALLOWRAW );
	$row->tousers_id = JRequest::getVar( 'tousers_id', '','post', 'int', JREQUEST_ALLOWRAW );
	$row->subject = JRequest::getVar( 'subject', '','post', 'string', JREQUEST_ALLOWRAW );
	$row->message = JRequest::getVar( 'message', '','post', 'string', JREQUEST_ALLOWRAW );
	$row->fromdate = JRequest::getVar( 'fromdate', '','post', 'string', JREQUEST_ALLOWRAW );
	$row->todate = JRequest::getVar( 'todate', '','post', 'string', JREQUEST_ALLOWRAW );
	$row->month = JRequest::getVar( 'month', '','post', 'int', JREQUEST_ALLOWRAW );
	$row->year = JRequest::getVar( 'year', '','post', 'int', JREQUEST_ALLOWRAW );
	$row->approved = $approved;
	$row->dateapproved = $dateapproved;
	
	if(!$row->store()){
		JError::raiseError(500, $row->getError() );
	}
	$mainframe->redirect('index.php?option=com_intranet&task=leaverequest', 'New Leave Request added / edited successfully  ');
}

function leaverequestedit()
{
	$id = JRequest::getVar('id', 0, 'get', 'int');
	$db	=& JFactory::getDBO();
	$cid = JRequest::getVar('cid',array(0),'','array');
	JArrayHelper::toInteger($cid, array(0));
	$id = $cid[0];
	$row =& JTable::getInstance('intranet_leaverequest', 'Table');
	$row->load( $id);
	IntranetHTML::leaverequestedit(&$row);
}

function leaverequestremove()
{
	global $mainframe;
	$db =& JFactory::getDBO();
	$cid = JRequest::getVar('cid',array(),'','array');
	JArrayHelper::toInteger($cid);
	if (count( $cid )) {
		$cids = implode( ',', $cid );
		$query = 'DELETE FROM #__intranet_leaverequest'
		. ' WHERE id IN ( '. $cids .' )'
		;
		$db->setQuery( $query );
		if (!$db->query()) {
			echo "<script> alert('".$db->getErrorMsg(true)."'); 
		   window.history.go(-1); </script>\n";
		}
	}
	$mainframe->redirect('index.php?option=com_intranet&task=leaverequest', 'Leave Request Successfully deleted');
}
//Leave Request Ends
?>