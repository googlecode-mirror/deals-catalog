<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

require_once( JApplicationHelper::getPath( 'admin_html' ) );

JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS. 
'com_dealcatalog'.DS.'tables');

$id 	= JRequest::getVar('id', 0, 'get', 'int');

$task 	= JRequest::getVar('task', '' ,"REQUEST");

$task   = JRequest::getCmd('task'); 

switch ($task) {

	default:
		cpanel();
		break;
		
	case 'merchant':
		merchantlist();
		break;
		
	case 'merchantinsert':
		merchantinsert();
		break;
		
	case 'merchantsave':
		merchantsave();
		break;
		
	case 'merchantedit':
		merchantedit();
		break;
		
	case 'merchanteditsave':
		merchanteditsave();
		break;
		
	case 'merchantremove':
		merchantremove();
		break;
		
	case 'customers':
		customerslist();
		break;
		
	case 'customersinsert':
		customersinsert();
		break;
		
	case 'customerssave':
		customerssave();
		break;
		
	case 'customersedit':
		customersedit();
		break;
		
	case 'customerseditsave':
		customerseditsave();
		break;
		
	case 'customersremove':
		customersremove();
		break;
		
	case 'categories':
		categories();
		break;
		
	case 'categoriesinsert':
		categoriesinsert();
		break;
		
	case 'categoriessave':
		categoriessave();
		break;
		
	case 'categoriesedit':
		categoriesedit();
		break;
		
	case 'categoriesremove':
		categoriesremove();
		break;
		
	case 'manufacturers':
		manufacturers();
		break;
		
	case 'manufacturersinsert':
		manufacturersinsert();
		break;
		
	case 'manufacturerssave':
		manufacturerssave();
		break;
		
	case 'manufacturersedit':
		manufacturersedit();
		break;
	
	case 'manufacturersremove':
		manufacturersremove();
		break;
		
	case 'products':
		products();
		break;
		
	case 'productsinsert':
		productsinsert();
		break;
		
	case 'productssave':
		productssave();
		break;
		
	case 'productsedit':
		productsedit();
		break;
		
	case 'productseditsave':
		productseditsave();
		break;
		
	case 'productsremove':
		productsremove();
		break;
		
	case 'productlistingsanddeals':
		productlistingsanddeals();
		break;
		
	case 'productlistingsanddealsinsert':
		productlistingsanddealsinsert();
		break;
		
	case 'productlistingsanddealssave':
		productlistingsanddealssave();
		break;
		
	case 'productlistingsanddealsedit':
		productlistingsanddealsedit();
		break;
		
	case 'productlistingsanddealsremove':
		productlistingsanddealsremove();
		break;
		
	case 'Coupons':
		coupons();
		break;
		
	case 'couponsinsert':
		couponsinsert();
		break;
		
	case 'couponssave':
		couponssave();
		break;
		
	case 'couponsedit':
		couponsedit();
		break;
		
	case 'couponsremove':
		couponsremove();
		break;		
	
}
	//Default view of Deal Catalog
	function cpanel()
	{
		DealCatalogHTML::cpanel(); //calling the html view of default of Deal Catalog
	}
	
	//View of Merchant Users
	function merchantlist()
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
			$where[] = 'company_name LIKE "%'.$db->getEscaped($search).'%"';
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
		. ' FROM #__deal_merchants'
		. $where
		;
		$db->setQuery( $query );
		$total = $db->loadResult();

		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
		
		$query = "SELECT * FROM #__deal_merchants". $where. $orderby;
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
			
		DealCatalogHTML::merchantlist(&$rows, &$pageNav, &$lists); // Calling the merchant users list in html
	}
	
	//New users added for merchant
	function merchantinsert()
	{
		DealCatalogHTML::merchantinsert(); //New users added for merchant
	}
	
	//New Users save to database
	function merchantsave()
	{
		global $mainframe;
		$row =& JTable::getInstance('deal_merchants', 'Table');
		if(!$row->bind(JRequest::get('post')))
		{
			JError::raiseError(500, $row->getError() );
		}
		//print_r($_POST); 
		$firstname = JRequest::getVar( 'firstname', '','post', 'string', JREQUEST_ALLOWRAW );
		$lastname = JRequest::getVar( 'lastname', '','post', 'string', JREQUEST_ALLOWRAW );
		$username = JRequest::getVar( 'username', '','post', 'string', JREQUEST_ALLOWRAW );
		$password = JRequest::getVar( 'password', '','post', 'string', JREQUEST_ALLOWRAW );
		$email_id = JRequest::getVar( 'email_id', '','post', 'string', JREQUEST_ALLOWRAW );
		$number = JRequest::getVar( 'Contact_number', '','post', 'string', JREQUEST_ALLOWRAW );
		$date = date('Y-m-d H:m:s');
		
		$name = $firstname.$lastname;		
		$password1 = MD5($password);
		
		$db = &JFactory::getDBO();
		$query = "select username,email from #__users where username='$username' or email='$email_id'";
		$db->setQuery($query);
		$result = $db->loadRow();
		$result1 = $result[0];
		$result2 = $result[1];
		if($result1=='' && $result2=='')
		{
			$query = "INSERT INTO jos_users (`name`, `username`, `email`, `password`, `usertype`, `gid`, `registerDate`) VALUES ('$name', '$username', '$email_id', '$password1', 'Merchants', '31', '$date')";
			$db->setQuery($query);
			$result = $db->query();
			
			$query = "SELECT id,name from jos_users where email = '$email_id'";
			$db->setQuery( $query );
			$result = $db->query();
			while($row1=mysql_fetch_array($result))
			{
			 $name1 = $row1["name"];
			 $id1 = $row1["id"];
			}
			
			$query = "INSERT INTO jos_core_acl_aro (`section_value`, `value`, `name`) VALUES ('users', '$id1', '$name1')";
			$db->setQuery($query);
			$result = $db->query();
			
			$query = "SELECT id from jos_core_acl_aro where value='$id1'";
			$db->setQuery($query);
			$result = $db->loadRow();
			$result = $result[0];
			
			$query = "INSERT INTO jos_core_acl_groups_aro_map (`group_id`,`aro_id`) VALUES ('31', '$result')";
			$db->setQuery($query);
			$result = $db->query();
			
			$row->name = $name;
			$row->user_id = $id1;
			$row->username = JRequest::getVar( 'username', '','post', 'string', JREQUEST_ALLOWRAW );;
			$row->password = $password1;
			$row->firstname = JRequest::getVar( 'firstname', '','post', 'string', JREQUEST_ALLOWRAW );
			$row->lastname = JRequest::getVar( 'lastname', '','post', 'string', JREQUEST_ALLOWRAW );
			$row->company_name = JRequest::getVar( 'company_name', '','post', 'string', JREQUEST_ALLOWRAW );
			$row->address1 = JRequest::getVar( 'address1', '','post', 'string', JREQUEST_ALLOWRAW );
			$row->address2 = JRequest::getVar( 'address2', '','post', 'string', JREQUEST_ALLOWRAW );
			$row->email_id = JRequest::getVar( 'email_id', '','post', 'string', JREQUEST_ALLOWRAW );
			$row->Contact_number = $number;
			$row->city = JRequest::getVar( 'city', '','post', 'string', JREQUEST_ALLOWRAW );
			$row->states = JRequest::getVar( 'states', '','post', 'string', JREQUEST_ALLOWRAW );
			$row->location_map = JRequest::getVar( 'location_map', '','post', 'string', JREQUEST_ALLOWRAW );
			$row->approved = JRequest::getVar( 'approved', '','post', 'int', JREQUEST_ALLOWRAW );
			
			$approve = JRequest::getVar( 'approved', '','post', 'int', JREQUEST_ALLOWRAW );
			$company = JRequest::getVar( 'company_name', '','post', 'string', JREQUEST_ALLOWRAW );
			if($approve=='1')
			{
				$query3 = "select email from #__users where gid='25' and usertype='Super Administrator'";
				$db->setQuery($query);
				$result = $db->loadAssocList();
				foreach($result as $row12)
				{
					$toAssres = $row12['email'].",";
				}
				
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'From: Admin Deal Catalog '.$toAddres. "\r\n";
				$to = $email_id;
				$subject = "Merchant Activation for company : ".$company;
				
				$message = '
					<html>
						<head>
							<title> Merchant Activation </title>
						</head>
						<body>
							<p>  <b> <center> Merchant Company name : '.$company.' </center> </b> </p>
							<table>
								<tr>
									<td> Merchant name : '.$name.' </td>
								</tr>
								<p> Your Username and Password as been activated, You may login now using </p>
								<tr>
									<td> User Name : '.$username.' </td>
								</tr>
								<tr>
									<td> Password : '.$password.' </td>
								</tr>
							</table>							
						</body>
					</html>
					';
				mail($to, $subject, $message, $headers);
			}
			
			if(!$row->store()){
				JError::raiseError(500, $row->getError() );
			}
			$mainframe->redirect('index.php?option=com_dealcatalog&task=merchant', 'New Merchant Successfully Registered');
		}
		else
		{	
			//$mainframe->redirect('index.php?option=com_dealcatalog&task=merchantinsert', 'Username or Email-Id already exits');
			echo "<script> alert('Your Username or email already exits'); window.history.go(-1); </script>";
		}
		
	}
	
	//Editing the exting user of merchant
	function merchantedit()
	{
		$id = JRequest::getVar('id', 0, 'get', 'int');
		$db	=& JFactory::getDBO();
		$cid = JRequest::getVar('cid',array(0),'','array');
		JArrayHelper::toInteger($cid, array(0));
		$id = $cid[0];
		$row =& JTable::getInstance('deal_merchants', 'Table');
		$row->load( $id);
		DealCatalogHTML::merchantedit(&$row);
	}
	
	//Editting user merchant save
	function merchanteditsave()
	{
		global $mainframe;
		$row =& JTable::getInstance('deal_merchants', 'Table');
		if(!$row->bind(JRequest::get('post')))
		{
			JError::raiseError(500, $row->getError() );
		}
		//print_r($_POST); 
		$user_id = JRequest::getVar( 'user_id', '','post', 'int', JREQUEST_ALLOWRAW );
		$firstname = JRequest::getVar( 'firstname', '','post', 'string', JREQUEST_ALLOWRAW );
		$lastname = JRequest::getVar( 'lastname', '','post', 'string', JREQUEST_ALLOWRAW );
		$username = JRequest::getVar( 'username', '','post', 'string', JREQUEST_ALLOWRAW );
		$password = JRequest::getVar( 'password', '','post', 'string', JREQUEST_ALLOWRAW );
		$email_id = JRequest::getVar( 'email_id', '','post', 'string', JREQUEST_ALLOWRAW );
		
		$date = date('Y-m-d H:m:s');		
		$name = $firstname.$lastname;		
		$password1 = MD5($password);
		
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
			$query = "update #__users set `name`='$name', `username`='$username', `email`='$email_id', `password`='$password1' where id='$user_id'";
			$db->setQuery($query);
			$result = $db->query();
			
			$row->name = $name;
			$row->user_id = $user_id;
			$row->username = JRequest::getVar( 'username', '','post', 'string', JREQUEST_ALLOWRAW );;
			$row->password = $password1;
			$row->firstname = JRequest::getVar( 'firstname', '','post', 'string', JREQUEST_ALLOWRAW );
			$row->lastname = JRequest::getVar( 'lastname', '','post', 'string', JREQUEST_ALLOWRAW );
			$row->company_name = JRequest::getVar( 'company_name', '','post', 'string', JREQUEST_ALLOWRAW );
			$row->address1 = JRequest::getVar( 'address1', '','post', 'string', JREQUEST_ALLOWRAW );
			$row->address2 = JRequest::getVar( 'address2', '','post', 'string', JREQUEST_ALLOWRAW );
			$row->email_id = JRequest::getVar( 'email_id', '','post', 'string', JREQUEST_ALLOWRAW );
			$row->Contact_number = JRequest::getVar( 'Contact_number', '','post', 'string', JREQUEST_ALLOWRAW );
			$row->city = JRequest::getVar( 'city', '','post', 'string', JREQUEST_ALLOWRAW );
			$row->states = JRequest::getVar( 'states', '','post', 'string', JREQUEST_ALLOWRAW );
			$row->location_map = JRequest::getVar( 'location_map', '','post', 'string', JREQUEST_ALLOWRAW );
			$row->approved = JRequest::getVar( 'approved', '','post', 'int', JREQUEST_ALLOWRAW );
			
			$approve = JRequest::getVar( 'approved', '','post', 'int', JREQUEST_ALLOWRAW );
			$company = JRequest::getVar( 'company_name', '','post', 'string', JREQUEST_ALLOWRAW );
			if($approve=='1')
			{
				$query3 = "select email from #__users where gid='25' and usertype='Super Administrator'";
				$db->setQuery($query);
				$result = $db->loadAssocList();
				foreach($result as $row12)
				{
					$toAssres = $row12['email'].",";
				}
				
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'From: Admin Deal Catalog '.$toAddres. "\r\n";
				$to = $email_id;
				$subject = "Merchant Activation for company :  ".$company;
				
				$message = '
					<html>
						<head>
							<title> Merchant Activation </title>
						</head>
						<body>
							<p>  <b> <center> Merchant Company name :  '.$company.' </center> </b> </p>
							<table>
								<tr>
									<td> Merchant name : '.$name.' </td>
								</tr>
								<p> Your Username and Password as been activated, You may login now using </p>
								<tr>
									<td> User Name : '.$username.' </td>
								</tr>
								<tr>
									<td> Password : '.$password.' </td>
								</tr>
							</table>							
						</body>
					</html>
					';
				mail($to, $subject, $message, $headers);
			}
			if(!$row->store()){
				JError::raiseError(500, $row->getError() );
			}
			$mainframe->redirect('index.php?option=com_dealcatalog&task=merchant', 'Merchant Successfully Editted');
		}
	}
	
	//Delete the merchant user
	function merchantremove()
	{
		global $mainframe;
		$db =& JFactory::getDBO();
		$cid = JRequest::getVar('cid',array(),'','array'); 
		JArrayHelper::toInteger($cid);

		if (count( $cid )) 
		{
			$cids = implode( ',', $cid );
			$query = "select user_id from #__deal_merchants where id IN (".$cids.")";
			$db->setQuery($query);
			$result = $db->loadAssocList(); 
			foreach($result as $rows)
			{ 
				$query = "select id from #__core_acl_aro where value IN (".$rows['user_id'].")";
				$db->setQuery($query);
				$result1 = $db->loadAssocList();
				foreach($result1 as $rows2)
				{
					$query = "delete from #__core_acl_groups_aro_map where aro_id IN (".$rows2['id'].")";
					$db->setQuery($query);
					$db->query();
				}
				$query = "delete from #__core_acl_aro where value IN (".$rows['user_id'].")";
				$db->setQuery($query);
				$db->query();
				$query = "delete from #__users where id IN (".$rows['user_id'].")";
				$db->setQuery($query);
				$db->query();
			}			
			
			$query = 'DELETE FROM #__deal_merchants'
			. ' WHERE id IN ( '. $cids .' )'
			; 
			$db->setQuery( $query );
			if (!$db->query())
			{
				echo "<script> alert('".$db->getErrorMsg(true)."'); 
			   window.history.go(-1); </script>\n";
			}
			
		}
		$mainframe->redirect('index.php?option=com_dealcatalog&task=merchant', 'Merchant Successfully Deleted');
	}
	
	//View of Customers Users
	function customerslist()
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
		. ' FROM #__deal_customers'
		. $where
		;
		$db->setQuery( $query );
		$total = $db->loadResult();

		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
		
		$query = "SELECT * FROM #__deal_customers". $where. $orderby;
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
			
		DealCatalogHTML::customerslist(&$rows, &$pageNav, &$lists); // Calling the merchant users list in html
	}
	
	//New users added for customer
	function customersinsert()
	{
		DealCatalogHTML::customersinsert(); //New users added for customer
	}
	
	//New customer Users save to database
	function customerssave()
	{
		global $mainframe;
		$row =& JTable::getInstance('deal_customers', 'Table');
		if(!$row->bind(JRequest::get('post')))
		{
			JError::raiseError(500, $row->getError() );
		}
		//print_r($_POST); 
		$firstname = JRequest::getVar( 'firstname', '','post', 'string', JREQUEST_ALLOWRAW );
		$lastname = JRequest::getVar( 'lastname', '','post', 'string', JREQUEST_ALLOWRAW );
		$username = JRequest::getVar( 'username', '','post', 'string', JREQUEST_ALLOWRAW );
		$password = JRequest::getVar( 'password', '','post', 'string', JREQUEST_ALLOWRAW );
		$email_id = JRequest::getVar( 'email_id', '','post', 'string', JREQUEST_ALLOWRAW );
		$number = JRequest::getVar( 'Contact_number', '','post', 'string', JREQUEST_ALLOWRAW );
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
			$query = "INSERT INTO jos_users (`name`, `username`, `email`, `password`, `usertype`, `gid`, `registerDate`) VALUES ('$name', '$username', '$email_id', '$password', 'Customers', '32', '$date')";
			$db->setQuery($query);
			$result = $db->query();
			
			$query = "SELECT id,name from jos_users where email = '$email_id'";
			$db->setQuery( $query );
			$result = $db->query();
			while($row1=mysql_fetch_array($result))
			{
			 $name1 = $row1["name"];
			 $id1 = $row1["id"];
			}
			
			$query = "INSERT INTO jos_core_acl_aro (`section_value`, `value`, `name`) VALUES ('users', '$id1', '$name1')";
			$db->setQuery($query);
			$result = $db->query();
			
			$query = "SELECT id from jos_core_acl_aro where value='$id1'";
			$db->setQuery($query);
			$result = $db->loadRow();
			$result = $result[0];
			
			$query = "INSERT INTO jos_core_acl_groups_aro_map (`group_id`,`aro_id`) VALUES ('32', '$result')";
			$db->setQuery($query);
			$result = $db->query();
			
			$row->name = $name;
			$row->users_id = $id1;
			$row->username = JRequest::getVar( 'username', '','post', 'string', JREQUEST_ALLOWRAW );;
			$row->password = $password;
			$row->firstname = JRequest::getVar( 'firstname', '','post', 'string', JREQUEST_ALLOWRAW );
			$row->lastname = JRequest::getVar( 'lastname', '','post', 'string', JREQUEST_ALLOWRAW );
			$row->address1 = JRequest::getVar( 'address1', '','post', 'string', JREQUEST_ALLOWRAW );
			$row->address2 = JRequest::getVar( 'address2', '','post', 'string', JREQUEST_ALLOWRAW );
			$row->email_id = JRequest::getVar( 'email_id', '','post', 'string', JREQUEST_ALLOWRAW );
			$row->Contact_number = $number;
			$row->city = JRequest::getVar( 'city', '','post', 'string', JREQUEST_ALLOWRAW );
			$row->states = JRequest::getVar( 'states', '','post', 'string', JREQUEST_ALLOWRAW );
			$row->approved = JRequest::getVar( 'approved', '','post', 'int', JREQUEST_ALLOWRAW );
			
			if(!$row->store()){
				JError::raiseError(500, $row->getError() );
			}
			$mainframe->redirect('index.php?option=com_dealcatalog&task=customers', 'New Customer Successfully Registered');
		}
		else
		{	
			//$mainframe->redirect('index.php?option=com_dealcatalog&task=merchantinsert', 'Username or Email-Id already exits');
			echo "<script> alert('Your Username or email already exits'); window.history.go(-1); </script>";
		}
		
	}
	
	//Editing the exting user of customer
	function customersedit()
	{
		$id = JRequest::getVar('id', 0, 'get', 'int');
		$db	=& JFactory::getDBO();
		$cid = JRequest::getVar('cid',array(0),'','array');
		JArrayHelper::toInteger($cid, array(0));
		$id = $cid[0];
		$row =& JTable::getInstance('deal_customers', 'Table');
		$row->load( $id);
		DealCatalogHTML::customersedit(&$row);
	}
	
	//Editting user customers save
	function customerseditsave()
	{
		global $mainframe;
		$row =& JTable::getInstance('deal_customers', 'Table');
		if(!$row->bind(JRequest::get('post')))
		{
			JError::raiseError(500, $row->getError() );
		}
		//print_r($_POST); 
		$user_id = JRequest::getVar( 'user_id', '','post', 'int', JREQUEST_ALLOWRAW );
		$firstname = JRequest::getVar( 'firstname', '','post', 'string', JREQUEST_ALLOWRAW );
		$lastname = JRequest::getVar( 'lastname', '','post', 'string', JREQUEST_ALLOWRAW );
		$username = JRequest::getVar( 'username', '','post', 'string', JREQUEST_ALLOWRAW );
		$password = JRequest::getVar( 'password', '','post', 'string', JREQUEST_ALLOWRAW );
		$email_id = JRequest::getVar( 'email_id', '','post', 'string', JREQUEST_ALLOWRAW );
		$u_id = JRequest::getVar( 'id', '','post', 'string', JREQUEST_ALLOWRAW );
		
		$date = date('Y-m-d H:m:s');		
		$name = $firstname.$lastname;		
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
			
			$row->name = $name;
			$row->users_id = $user_id;
			$row->username = JRequest::getVar( 'username', '','post', 'string', JREQUEST_ALLOWRAW );;
			$row->password = $password;
			$row->firstname = JRequest::getVar( 'firstname', '','post', 'string', JREQUEST_ALLOWRAW );
			$row->lastname = JRequest::getVar( 'lastname', '','post', 'string', JREQUEST_ALLOWRAW );
			$row->address1 = JRequest::getVar( 'address1', '','post', 'string', JREQUEST_ALLOWRAW );
			$row->address2 = JRequest::getVar( 'address2', '','post', 'string', JREQUEST_ALLOWRAW );
			$row->email_id = JRequest::getVar( 'email_id', '','post', 'string', JREQUEST_ALLOWRAW );
			$row->Contact_number = JRequest::getVar( 'Contact_number', '','post', 'string', JREQUEST_ALLOWRAW );
			$row->city = JRequest::getVar( 'city', '','post', 'string', JREQUEST_ALLOWRAW );
			$row->states = JRequest::getVar( 'states', '','post', 'string', JREQUEST_ALLOWRAW );
			$row->approved = JRequest::getVar( 'approved', '','post', 'int', JREQUEST_ALLOWRAW );
			
			if(!$row->store()){
				JError::raiseError(500, $row->getError() );
			}
			$mainframe->redirect('index.php?option=com_dealcatalog&task=customers', 'Customer Successfully Editted');
		}
	}
	
	//Delete the customer user
	function customersremove()
	{
		global $mainframe;
		$db =& JFactory::getDBO();
		$cid = JRequest::getVar('cid',array(),'','array'); 
		JArrayHelper::toInteger($cid);

		if (count( $cid )) 
		{
			$cids = implode( ',', $cid );
			$query = "select users_id from #__deal_customers where id IN (".$cids.")";
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
			
			$query = 'DELETE FROM #__deal_customers'
			. ' WHERE id IN ( '. $cids .' )'
			; 
			$db->setQuery( $query );
			if (!$db->query())
			{
				echo "<script> alert('".$db->getErrorMsg(true)."'); 
			   window.history.go(-1); </script>\n";
			}
			
		}
		$mainframe->redirect('index.php?option=com_dealcatalog&task=customers', 'Customers Successfully Deleted');
	}
	
	//View of Product categories
	function categories()
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
			$where[] = 'category_name LIKE "%'.$db->getEscaped($search).'%"';
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
		. ' FROM #__deal_productcategories'
		. $where
		;
		$db->setQuery( $query );
		$total = $db->loadResult();

		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
		
		$query = "SELECT * FROM #__deal_productcategories". $where. $orderby;
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
			
		DealCatalogHTML::categories(&$rows, &$pageNav, &$lists); // Calling the product categories list in html
	}
	
	//New category product
	function categoriesinsert()
	{
		DealCatalogHTML::categoriesinsert(); //New category product
	}
	
	//New product category save
	function categoriessave()
	{
		global $mainframe;
		$row =& JTable::getInstance('deal_productcategories', 'Table');
		if(!$row->bind(JRequest::get('post')))
		{
			JError::raiseError(500, $row->getError() );
		}
		
		$row->category_name = JRequest::getVar( 'category_name', '','post', 'string', JREQUEST_ALLOWRAW );
		$row->category_desc = JRequest::getVar( 'category_desc', '','post', 'string', JREQUEST_ALLOWRAW );
			
		if(!$row->store()){
				JError::raiseError(500, $row->getError() );
		}
		$mainframe->redirect('index.php?option=com_dealcatalog&task=categories', 'Added / Edited product category added');
	}
	
	//Editing the exting product categories
	function categoriesedit()
	{
		$id = JRequest::getVar('id', 0, 'get', 'int');
		$db	=& JFactory::getDBO();
		$cid = JRequest::getVar('cid',array(0),'','array');
		JArrayHelper::toInteger($cid, array(0));
		$id = $cid[0];
		$row =& JTable::getInstance('deal_productcategories', 'Table');
		$row->load( $id);
		DealCatalogHTML::categoriesedit(&$row);
	}
	
	//Remove the product category
	function categoriesremove()
	{
		global $mainframe;
		$db =& JFactory::getDBO();
		$cid = JRequest::getVar('cid',array(),'','array');
		JArrayHelper::toInteger($cid);
		if (count( $cid )) {
			$cids = implode( ',', $cid );
			$query = 'DELETE FROM #__deal_productcategories'
			. ' WHERE id IN ( '. $cids .' )'
			;
			$db->setQuery( $query );
			if (!$db->query()) {
				echo "<script> alert('".$db->getErrorMsg(true)."'); 
			   window.history.go(-1); </script>\n";
			}
		}
		$mainframe->redirect('index.php?option=com_dealcatalog&task=categories', 'Category Successfully Deleted');
	}
	
	//View of Product manufacturer
	function manufacturers()
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
			$where[] = 'manufacturer_name LIKE "%'.$db->getEscaped($search).'%"';
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
		. ' FROM #__deal_manufacturer'
		. $where
		;
		$db->setQuery( $query );
		$total = $db->loadResult();

		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
		
		$query = "SELECT * FROM #__deal_manufacturer". $where. $orderby;
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
			
		DealCatalogHTML::manufacturers(&$rows, &$pageNav, &$lists); // Calling the product manufacturers list in html
	}
	
	//New product manufacturer
	function manufacturersinsert()
	{
		DealCatalogHTML::manufacturersinsert(); //New category product
	}
	
	//New product manufacturer save
	function manufacturerssave()
	{
		global $mainframe;
		$row =& JTable::getInstance('deal_manufacturer', 'Table');
		if(!$row->bind(JRequest::get('post')))
		{
			JError::raiseError(500, $row->getError() );
		}
		
		$row->manufacturer_name = JRequest::getVar( 'manufacturer_name', '','post', 'string', JREQUEST_ALLOWRAW );
		
		if(!$row->store()){
				JError::raiseError(500, $row->getError() );
		}
		$mainframe->redirect('index.php?option=com_dealcatalog&task=manufacturers', 'Added / Edited Product Manufacturer ');
	}
	
	//Editing the exting product manufacturer
	function manufacturersedit()
	{
		$id = JRequest::getVar('id', 0, 'get', 'int');
		$db	=& JFactory::getDBO();
		$cid = JRequest::getVar('cid',array(0),'','array');
		JArrayHelper::toInteger($cid, array(0));
		$id = $cid[0];
		$row =& JTable::getInstance('deal_manufacturer', 'Table');
		$row->load( $id);
		DealCatalogHTML::manufacturersedit(&$row);
	}
	
	//Remove the product manufacturer
	function manufacturersremove()
	{
		global $mainframe;
		$db =& JFactory::getDBO();
		$cid = JRequest::getVar('cid',array(),'','array');
		JArrayHelper::toInteger($cid);
		if (count( $cid )) {
			$cids = implode( ',', $cid );
			$query = 'DELETE FROM #__deal_manufacturer'
			. ' WHERE id IN ( '. $cids .' )'
			;
			$db->setQuery( $query );
			if (!$db->query()) {
				echo "<script> alert('".$db->getErrorMsg(true)."'); 
			   window.history.go(-1); </script>\n";
			}
		}
		$mainframe->redirect('index.php?option=com_dealcatalog&task=manufacturers', 'Manufacturer Successfully Deleted');
	}
	
	//View of Products List
	function products()
	{
		global $mainframe;	
		$db =& JFactory::getDBO();
		
		$filter_order = $mainframe->getUserStateFromRequest( $option.'filter_order','filter_order','id','cmd' );
		$filter_order_Dir = $mainframe->getUserStateFromRequest( $option.'filter_order_Dir','filter_order_Dir','','word' );
		$filter_state = $mainframe->getUserStateFromRequest( $option.'filter_state', 'filter_state', '','word' );
		$search = $mainframe->getUserStateFromRequest( $option.'search','search','','string' );
		$search = JString::strtolower( $search );
		
		$category = $mainframe->getUserStateFromRequest( $option.'category','category','','string' );
		
		$limit= $mainframe->getUserStateFromRequest('global.list.limit','limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart= $mainframe->getUserStateFromRequest($option.'.limitstart', 'limitstart', 0, 'int');
		
		$where = array();
		if ( $search ) {
			$where[] = 'product_name LIKE "%'.$db->getEscaped($search).'%"';
		}
		if($category) {
			$where[] = 'category_id = '.$db->getEscaped($category);
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
		. ' FROM #__deal_products'
		. $where
		;
		$db->setQuery( $query );
		$total = $db->loadResult();

		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
		
		$query = "SELECT * FROM #__deal_products". $where. $orderby;
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
		$lists['category']= $category;
			
		DealCatalogHTML::products(&$rows, &$pageNav, &$lists); // Calling the products list in html
	}
	
	function productsinsert()
	{
		DealCatalogHTML::productsinsert();
	}
	
	function productssave()
	{
		global $mainframe;
		$row =& JTable::getInstance('deal_products', 'Table');
		$db = &JFactory::getDBO();
		if(!$row->bind(JRequest::get('post')))
		{
			JError::raiseError(500, $row->getError() );
		}
		
		//creating a product image directory
		$p_name = JRequest::getVar( 'product_name', '','post', 'string', JREQUEST_ALLOWRAW );
		$p_code = JRequest::getVar( 'product_code', '','post', 'string', JREQUEST_ALLOWRAW );
		$category = JRequest::getVar( 'category_id', '','post', 'string', JREQUEST_ALLOWRAW );
		$query = "select category_name from #__deal_productcategories where id='$category'";
		$db->setQuery($query);
		$cat = $db->loadRow();
		$cat_name = $cat[0];
		$query = "select product_code from #__deal_products where product_code='$p_code'";
		$db->setQuery($query);
		$result = $db->loadRow();
		$product_code = $result[0];
		if($product_code!='')
		{
			echo "<script> alert('Product Code already exits, please give another product code'); window.history.go(-1); </script>";
		}
		else
		{
			$current_location = "../components/com_dealcatalog/images";
			if (!file_exists($current_location))
			{
				mkdir($current_location, 0777);
			}
			else 
			{
				chmod($current_location, 0777);
			}
			$user_folder = $current_location."/".$cat_name;
			if (!file_exists($user_folder))
			{
				mkdir($user_folder, 0777);
			}
			else
			{
				chmod($user_folder, 0777);
			}
			$image_path = $user_folder."/original";
			if (!file_exists($image_path))
			{
				mkdir($image_path, 0777);
			}
			else
			{
				chmod($image_path, 0777);
			}
			$thumb_path = $user_folder."/thumb";
			if (!file_exists($thumb_path))
			{
				mkdir($thumb_path, 0777);
			}
			else
			{
				chmod($thumb_path, 0777);
			}
			$image_path1 = $image_path."/";
			$thumb_path1 = $thumb_path."/";
			$file_name = $_FILES["file"]["name"];
			if($file_name!='')
			{
				$file_name = $_FILES["file"]["name"];
				$file_size = $_FILES["file"]["size"];
				$extension = $_FILES["file"]["type"];
				if(($extension!="image/jpg") && ($extension!="image/jpeg") && ($extension!="image/png") && ($extension!="image/gif"))
				{
					echo "<script> alert('Please Upload image format files only'); window.history.go(-1); </script>"; exit;
				}
				else
				{
					if($file_size < 10000000)
					{
						$file_name = $file_size."_".$file_name;
						$original = $image_path1.$file_name;
						$thumb = $thumb_path1.$file_name;
						if(move_uploaded_file($_FILES["file"]["tmp_name"],$original))
						{
							list($width12, $height12) = getimagesize($original);
							if($width12==$height12)
							{
								if(copy($original, $thumb))
								{
									list($width, $height) = getimagesize($original);
									$width_thumb = 100;
									$ratio = ($width_thumb / $width) * 100;
									$height_thumb = ($ratio * $height) / 100;
									$thumbs = imagecreatetruecolor($width_thumb, $height_thumb);
									if($extension == 'image/jpeg' || $extension == 'image/jpg')
									{
										$source = imagecreatefromjpeg($original);
										if(imagecopyresampled($thumbs, $source, 0, 0, 0, 0, $width_thumb, $height_thumb, $width, $height))
										{
											imagejpeg($thumbs, $thumb, 100);
											//echo 'hi';
										}
										else
										{
											echo 'false'; 
										}
									}
									if($extension == 'image/png')
									{
										$source = imagecreatefrompng($original);
										if(imagecopyresampled($thumbs, $source, 0, 0, 0, 0, $width_thumb, $height_thumb, $width, $height))
										{
											imagepng($thumbs, $thumb, 9);
											//echo 'hi';
										}
										else
										{
											echo 'false';
										}
									}
									if($extension == 'image/gif')
									{
										$source = imagecreatefromgif($original);
										if(imagecopyresampled($thumbs, $source, 0, 0, 0, 0, $width_thumb, $height_thumb, $width, $height))
										{
											imagegif($thumbs, $thumb, 100);
											//echo 'hi';
										}
										else
										{
											echo 'false';
										}
									}
								}
								else
								{
									echo "no resize";
								}
								$orginal_location = $original;
								$thumb_location = $thumb;
							}
							else
							{
								unlink($original);
								echo "<script> alert('Please uploaded image with same height and width'); window.history.go(-1); </script>"; exit;
							}
						}						
					}
					else
					{
						echo "<script> alert('Your uploaded image exceeds the maximam size limit'); window.history.go(-1); </script>"; exit;
					}
				}
			}				
				
			$row->product_name = JRequest::getVar( 'product_name', '','post', 'string', JREQUEST_ALLOWRAW );
			$row->product_code = JRequest::getVar( 'product_code', '','post', 'string', JREQUEST_ALLOWRAW );
			$row->product_desc = JRequest::getVar( 'product_desc', '','post', 'string', JREQUEST_ALLOWRAW );
			$row->manufacturer_id = JRequest::getVar( 'manufacturer_id', '','post', 'string', JREQUEST_ALLOWRAW );
			$row->category_id = JRequest::getVar( 'category_id', '','post', 'string', JREQUEST_ALLOWRAW );
			if($orginal_location=='' && $thumb_location=='')
			{
				$row->product_image1 = "../components/com_dealcatalog/default.png";
				$row->product_thumbimage1 = "../components/com_dealcatalog/default.png";
				//$row->total_images = 0;
			}
			else
			{
				$row->product_image1 = $orginal_location;
				$row->product_thumbimage1 = $thumb_location;
				//$row->total_images = $tot;
			}
			
			if(!$row->store()){
					JError::raiseError(500, $row->getError() );
			}
			$mainframe->redirect('index.php?option=com_dealcatalog&task=products', 'Added New Product');
		}
	}
	
	//Editing the exting product
	function productsedit()
	{
		$id = JRequest::getVar('id', 0, 'get', 'int');
		$db	=& JFactory::getDBO();
		$cid = JRequest::getVar('cid',array(0),'','array');
		JArrayHelper::toInteger($cid, array(0));
		$id = $cid[0];
		$row =& JTable::getInstance('deal_products', 'Table');
		$row->load( $id);
		DealCatalogHTML::productsedit(&$row);
	}
	
	function productseditsave()
	{
		global $mainframe;
		$row =& JTable::getInstance('deal_products', 'Table');
		$db = &JFactory::getDBO();
		if(!$row->bind(JRequest::get('post')))
		{
			JError::raiseError(500, $row->getError() );
		}
			
		//creating a product image directory
		$p_name = JRequest::getVar( 'product_name', '','post', 'string', JREQUEST_ALLOWRAW );
		$p_code = JRequest::getVar( 'product_code', '','post', 'string', JREQUEST_ALLOWRAW );
		$p_id = JRequest::getVar( 'id', '','post', 'string', JREQUEST_ALLOWRAW );
		$category = JRequest::getVar( 'category_id', '','post', 'string', JREQUEST_ALLOWRAW );
		$query = "select category_name from #__deal_productcategories where id='$category'";
		$db->setQuery($query);
		$cat = $db->loadRow();
		$cat_name = $cat[0];
		$query = "select id,product_code from #__deal_products where product_code='$p_code'";
		$db->setQuery($query);
		$result = $db->loadRow();
		$id = $result[0];
		if($id!=$p_id && $id!='')
		{
			echo "<script> alert('Product Code already exits, please give another product code'); window.history.go(-1); </script>";
		}
		else
		{
			$current_location = "../components/com_dealcatalog/images";
			if (!file_exists($current_location))
			{
				mkdir($current_location, 0777);
			}
			else 
			{
				chmod($current_location, 0777);
			}
			$user_folder = $current_location."/".$cat_name;
			if (!file_exists($user_folder))
			{
				mkdir($user_folder, 0777);
			}
			else
			{
				chmod($user_folder, 0777);
			}
			$image_path = $user_folder."/original";
			if (!file_exists($image_path))
			{
				mkdir($image_path, 0777);
			}
			else
			{
				chmod($image_path, 0777);
			}
			$thumb_path = $user_folder."/thumb";
			if (!file_exists($thumb_path))
			{
				mkdir($thumb_path, 0777);
			}
			else
			{
				chmod($thumb_path, 0777);
			}
			$image_path1 = $image_path."/";
			$thumb_path1 = $thumb_path."/";
			$files = JRequest::getVar( 'file11', '','post', 'string', JREQUEST_ALLOWRAW );
			$file_name = $_FILES["file"]["name"];
			if($files=='' && $file_name!='')
			{
				$file_size = $_FILES["file"]["size"];
				$file_name = $_FILES["file"]["name"];
				$extension = $_FILES["file"]["type"];
				if(($extension!= "image/jpg") && ($extension!= "image/jpeg") && ($extension!= "image/png") && ($extension!= "image/gif"))
				{
					echo "<script> alert('Please Upload image format files only'); window.history.go(-1); </script>"; exit;
				}
				else
				{
					if($file_size < 10000000)
					{
						$file_name = $file_size."_".$file_name;
						$original = $image_path1.$file_name;
						$thumb = $thumb_path1.$file_name;
						if(move_uploaded_file($_FILES["file"]["tmp_name"],$original))
						{
							list($width12, $height12) = getimagesize($original);
							if($width12==$height12)
							{
								if(copy($original, $thumb))
								{
									list($width, $height) = getimagesize($original);
									$width_thumb = 100;
									$ratio = ($width_thumb / $width) * 100;
									$height_thumb = ($ratio * $height) / 100;
									$thumbs = imagecreatetruecolor($width_thumb, $height_thumb);
									if($extension == 'image/jpeg' || $extension == 'image/jpg')
									{
										$source = imagecreatefromjpeg($original);
										if(imagecopyresampled($thumbs, $source, 0, 0, 0, 0, $width_thumb, $height_thumb, $width, $height))
										{
											imagejpeg($thumbs, $thumb, 100);
											//echo 'hi';
										}
										else
											{
												echo 'false';
											}
										}
										if($extension == 'png')
										{
											$source = imagecreatefrompng($original);
											if(imagecopyresampled($thumbs, $source, 0, 0, 0, 0, $width_thumb, $height_thumb, $width, $height))
											{
												imagepng($thumbs, $thumb, 9);
												//echo 'hi';
											}
											else
											{
												echo 'false';
											}
										}
										if($extension == 'gif')
										{
											$source = imagecreatefromgif($original);
											if(imagecopyresampled($thumbs, $source, 0, 0, 0, 0, $width_thumb, $height_thumb, $width, $height))
											{
												imagegif($thumbs, $thumb, 100);
												//echo 'hi';
											}
											else
											{
												echo 'false';
											}
										}
								}
								else
								{
									echo "no resize";
								}
								$orginal_location = $original;
								$thumb_location = $thumb;
							}
							else
							{
								unlink($original);
								echo "<script> alert('Please uploaded image with same height and width'); window.history.go(-1); </script>"; exit;
							}
						}						
					}
					else
					{
						echo "<script> alert('Your uploaded image exceeds the maximam size limit'); window.history.go(-1); </script>"; exit;
					}
				}
			}				
				
			$row->product_name = JRequest::getVar( 'product_name', '','post', 'string', JREQUEST_ALLOWRAW );
			$row->product_code = JRequest::getVar( 'product_code', '','post', 'string', JREQUEST_ALLOWRAW );
			$row->product_desc = JRequest::getVar( 'product_desc', '','post', 'string', JREQUEST_ALLOWRAW );
			$row->manufacturer_id = JRequest::getVar( 'manufacturer_id', '','post', 'string', JREQUEST_ALLOWRAW );
			$row->category_id = JRequest::getVar( 'category_id', '','post', 'string', JREQUEST_ALLOWRAW );
			$files = JRequest::getVar( 'file11', '','post', 'string', JREQUEST_ALLOWRAW );
			if($files=='')
			{
				if($orginal_location=='')
				{
					$row->product_image1 = "../components/com_dealcatalog/default.png";
					$row->product_thumbimage1 = "../components/com_dealcatalog/default.png";
					//$row->total_images = 0;
				}
				else
				{
					$row->product_image1 = $orginal_location;
					$row->product_thumbimage1 = $thumb;
				}
				
			}
			else
			{
				$row->product_image1 = JRequest::getVar( 'file11', '','post', 'string', JREQUEST_ALLOWRAW );
				$row->product_thumbimage1 = JRequest::getVar( 'file1', '','post', 'string', JREQUEST_ALLOWRAW );
				//$row->total_images = $tot + $total_img;
			}
			
			if(!$row->store()){
					JError::raiseError(500, $row->getError() );
			}
			$mainframe->redirect('index.php?option=com_dealcatalog&task=products', 'Edited the Product');
		}
	}
	
	//Remove the products
	function productsremove()
	{
		global $mainframe;
		$db =& JFactory::getDBO();
		$cid = JRequest::getVar('cid',array(),'','array');
		JArrayHelper::toInteger($cid);
		if (count( $cid )) {
			$cids = implode( ',', $cid );
			$query = 'DELETE FROM #__deal_products'
			. ' WHERE id IN ( '. $cids .' )'
			;
			$db->setQuery( $query );
			if (!$db->query()) {
				echo "<script> alert('".$db->getErrorMsg(true)."'); 
			   window.history.go(-1); </script>\n";
			}
		}
		$mainframe->redirect('index.php?option=com_dealcatalog&task=products', 'Product Successfully Deleted');
	}
	
	//View of Products Listing and deals
	function productlistingsanddeals()
	{
		global $mainframe;	
		$db =& JFactory::getDBO();
		
		$filter_order = $mainframe->getUserStateFromRequest( $option.'filter_order','filter_order','id','cmd' );
		$filter_order_Dir = $mainframe->getUserStateFromRequest( $option.'filter_order_Dir','filter_order_Dir','','word' );
		$filter_state = $mainframe->getUserStateFromRequest( $option.'filter_state', 'filter_state', '','word' );
		$vendors = $mainframe->getUserStateFromRequest( $option.'vendors','vendors','','string' );
		//$search = JString::strtolower( $search );
		
		$products = $mainframe->getUserStateFromRequest( $option.'products','products','','string' );
		
		$limit= $mainframe->getUserStateFromRequest('global.list.limit','limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart= $mainframe->getUserStateFromRequest($option.'.limitstart', 'limitstart', 0, 'int');
		
		$where = array();
		if ( $vendors ) {
			$where[] = 'vendor_id ='.$db->getEscaped($vendors);
		}
		if($products) {
			$where[] = 'product_id = '.$db->getEscaped($products);
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
		. ' FROM #__deal_productslisting_deals'
		. $where
		;
		$db->setQuery( $query );
		$total = $db->loadResult();

		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
		
		$query = "SELECT * FROM #__deal_productslisting_deals". $where. $orderby;
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
		$lists['vendors']= $vendors;	
		$lists['products']= $products;
			
		DealCatalogHTML::productlistingsanddeals(&$rows, &$pageNav, &$lists); // Calling the products list and deals in html
	}
	
	//insert productlisting and deal
	function productlistingsanddealsinsert()
	{
		DealCatalogHtml::productlistingsanddealsinsert();
	}
	
	//saving the productlisting and deals
	function productlistingsanddealssave()
	{
		global $mainframe;
		$row =& JTable::getInstance('deal_productslisting_deals', 'Table'); 
		if(!$row->bind(JRequest::get('post')))
		{
			JError::raiseError(500, $row->getError() );
		}
		
		$product_desc = JRequest::getVar( 'productdesc', '','post', 'string', JREQUEST_ALLOWRAW );
		$is_deal = JRequest::getVar( 'is_deal', '','post', 'string', JREQUEST_ALLOWRAW );
		$productimg = JRequest::getVar( 'productimg', '','post', 'string', JREQUEST_ALLOWRAW );
		$category = JRequest::getVar( 'category', '','post', 'string', JREQUEST_ALLOWRAW );
		$image = JRequest::getVar( 'image', '','post', 'string', JREQUEST_ALLOWRAW );
		if($productimg==1 && $image=='')
		{
			$current_location = "../components/com_dealcatalog/images";
			if (!file_exists($current_location))
			{
				mkdir($current_location, 0777);
			}
			else 
			{
				chmod($current_location, 0777);
			}
			$user_folder = $current_location."/".$category;
			if (!file_exists($user_folder))
			{
				mkdir($user_folder, 0777);
			}
			else
			{
				chmod($user_folder, 0777);
			}
			$image_path = $user_folder."/original";
			if (!file_exists($image_path))
			{
				mkdir($image_path, 0777);
			}
			else
			{
				chmod($image_path, 0777);
			}
			$thumb_path = $user_folder."/thumb";
			if (!file_exists($thumb_path))
			{
				mkdir($thumb_path, 0777);
			}
			else
			{
				chmod($thumb_path, 0777);
			}
			$image_path1 = $image_path."/";
			$thumb_path1 = $thumb_path."/";
			$file_name = $_FILES["file"]["name"];
			if($file_name!='')
			{
				$file_name = $_FILES["file"]["name"];
				$file_size = $_FILES["file"]["size"];
				$extension = $_FILES["file"]["type"];
				if(($extension!="image/jpg") && ($extension!="image/jpeg") && ($extension!="image/png") && ($extension!="image/gif"))
				{
					echo "<script> alert('Please Upload image format files only'); window.history.go(-1); </script>"; exit;
				}
				else
				{
					if($file_size < 10000000)
					{
						$file_name = $file_size."_".$file_name;
						$original = $image_path1.$file_name;
						$thumb = $thumb_path1.$file_name;
						if(move_uploaded_file($_FILES["file"]["tmp_name"],$original))
						{
							list($width12, $height12) = getimagesize($original);
							if($width12==$height12)
							{
								if(copy($original, $thumb))
								{
									list($width, $height) = getimagesize($original);
									$width_thumb = 100;
									$ratio = ($width_thumb / $width) * 100;
									$height_thumb = ($ratio * $height) / 100;
									$thumbs = imagecreatetruecolor($width_thumb, $height_thumb);
									if($extension == 'image/jpeg' || $extension == 'image/jpg')
									{
										$source = imagecreatefromjpeg($original);
										if(imagecopyresampled($thumbs, $source, 0, 0, 0, 0, $width_thumb, $height_thumb, $width, $height))
										{
											imagejpeg($thumbs, $thumb, 100);
											//echo 'hi';
										}
										else
											{
												echo 'false';
											}
										}
										if($extension == 'png')
										{
											$source = imagecreatefrompng($original);
											if(imagecopyresampled($thumbs, $source, 0, 0, 0, 0, $width_thumb, $height_thumb, $width, $height))
											{
												imagepng($thumbs, $thumb, 9);
												//echo 'hi';
											}
											else
											{
												echo 'false';
											}
										}
										if($extension == 'gif')
										{
											$source = imagecreatefromgif($original);
											if(imagecopyresampled($thumbs, $source, 0, 0, 0, 0, $width_thumb, $height_thumb, $width, $height))
											{
												imagegif($thumbs, $thumb, 100);
												//echo 'hi';
											}
											else
											{
												echo 'false';
											}
										}
								}
								else
								{
									echo "no resize";
								}
								echo $orginal_location = $original;
								echo $thumb_location = $thumb;
							}
							else
							{
								unlink($original);
								echo "<script> alert('Please uploaded image with same height and width'); window.history.go(-1); </script>"; exit;
							}
						}
					}
					else
					{
						echo "<script> alert('Your uploaded image exceeds the maximam size limit'); window.history.go(-1); </script>"; exit;
					}
				}
			}
			else
			{
				echo "<script> alert('Please upload the image for you product'); window.history.go(-1); </script>"; exit;
			}
		}
		
		$row->vendor_id = JRequest::getVar( 'vendor_id', '','post', 'string', JREQUEST_ALLOWRAW );
		$row->product_id = JRequest::getVar( 'product_id', '','post', 'string', JREQUEST_ALLOWRAW );
		$row->stock_in = JRequest::getVar( 'stock_in', '','post', 'string', JREQUEST_ALLOWRAW );
		$row->price = JRequest::getVar( 'price', '','post', 'string', JREQUEST_ALLOWRAW );
		$row->discount_price = JRequest::getVar( 'discount_price', '','post', 'string', JREQUEST_ALLOWRAW );
		$row->listingstart_date = JRequest::getVar( 'listingstart_date', '','post', 'string', JREQUEST_ALLOWRAW );
		$row->listingend_date = JRequest::getVar( 'listingend_date', '','post', 'string', JREQUEST_ALLOWRAW );
		
		if($product_desc==1)
		{
			$row->merchantproduct_desc = JRequest::getVar( 'merchantproduct_desc', '','post', 'string', JREQUEST_ALLOWRAW );
		}
		else
		{
			$row->merchantproduct_desc = '';
		}
		if($productimg==1 && $image=='')
		{
			$row->merchantproduct_image1 = $orginal_location;
			$row->merchantproduct_thumbimage1 = $thumb_location;
		}
		else if($image!='' && $productimg==1)
		{
			$row->merchantproduct_image1 =  JRequest::getVar( 'image', '','post', 'string', JREQUEST_ALLOWRAW );
			$row->merchantproduct_thumbimage1 = JRequest::getVar( 'image1', '','post', 'string', JREQUEST_ALLOWRAW );
		}
		else
		{
			$row->merchantproduct_image1 = ''; 
			$row->merchantproduct_thumbimage1 = '';
		}
		if($is_deal==1)
		{
			$row->is_deal = JRequest::getVar( 'is_deal', '','post', 'string', JREQUEST_ALLOWRAW );
			$row->deal_price = JRequest::getVar( 'deal_price', '','post', 'string', JREQUEST_ALLOWRAW );
			$row->dealstart_date = JRequest::getVar( 'dealstart_date', '','post', 'string', JREQUEST_ALLOWRAW );
			$row->dealend_date = JRequest::getVar( 'dealend_date', '','post', 'string', JREQUEST_ALLOWRAW );
			$row->promotion_type = JRequest::getVar( 'promotion_type', '','post', 'string', JREQUEST_ALLOWRAW );
		}
		else
		{
			$row->is_deal = '0';
			$row->deal_price = '0.00';
			$row->dealstart_date = '0000-00-00';
			$row->dealend_date = '0000-00-00';
			$row->promotion_type = '';
		}

		if(!$row->store()){
			JError::raiseError(500, $row->getError() );
		}
		$mainframe->redirect('index.php?option=com_dealcatalog&task=productlistingsanddeals', 'Added / Edited Product Listing / Deals ');
	}
	
	//Edit the product listings and deals
	function productlistingsanddealsedit()
	{
		$id = JRequest::getVar('id', 0, 'get', 'int');
		$db	=& JFactory::getDBO();
		$cid = JRequest::getVar('cid',array(0),'','array');
		JArrayHelper::toInteger($cid, array(0));
		$id = $cid[0];
		$row =& JTable::getInstance('deal_productslisting_deals', 'Table'); 
		$row->load( $id);
		DealCatalogHTML::productlistingsanddealsedit(&$row);
	}
	
	//View of Products Deals
	function coupons()
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
			$where[] = 'product_name LIKE "%'.$db->getEscaped($search).'%"';
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
		. ' FROM #__deal_coupons'
		. $where
		;
		$db->setQuery( $query );
		$total = $db->loadResult();

		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
		
		$query = "SELECT * FROM #__deal_coupons". $where. $orderby;
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
			
		DealCatalogHTML::coupons(&$rows, &$pageNav, &$lists); // Calling the products listing in html
	}
	
	function couponsinsert()
	{
		DealCatalogHTML::couponsinsert();
	}
	
	function couponssave()
	{
		global $mainframe;
		$row =& JTable::getInstance('deal_coupons', 'Table'); 
		if(!$row->bind(JRequest::get('post')))
		{
			JError::raiseError(500, $row->getError() );
		}
		
		$row->users_userid = JRequest::getVar( 'users_userid', '','post', 'string', JREQUEST_ALLOWRAW );
		$row->product_id = JRequest::getVar( 'product_id', '','post', 'string', JREQUEST_ALLOWRAW );
		$row->vendor_id = JRequest::getVar( 'vendor_id', '','post', 'string', JREQUEST_ALLOWRAW );
		$row->coupon_code = JRequest::getVar( 'coupon_code', '','post', 'string', JREQUEST_ALLOWRAW );
				
		if(!$row->store()){
				JError::raiseError(500, $row->getError() );
		}
		
		$db = &JFactory::getDBO();
		$u_id = JRequest::getVar( 'users_userid', '','post', 'string', JREQUEST_ALLOWRAW );
		$v_id = JRequest::getVar( 'vendor_id', '','post', 'string', JREQUEST_ALLOWRAW );
		$p_id = JRequest::getVar( 'product_id', '','post', 'string', JREQUEST_ALLOWRAW );
		$c_code = JRequest::getVar( 'coupon_code', '','post', 'string', JREQUEST_ALLOWRAW );
		
		$query = "select name,email_id from #__deal_customers where id='$u_id'";
		$db->setQuery($query);
		$result = $db->loadRow();
		$u_name = $result[0];
		$u_email = $result[1];
		
		$query1 = "select product_name,product_code,product_thumbimage1 where id='$p_id'";
		$db->setQuery($query1);
		$result1 = $db->loadRow();
		$p_name = $result[0];
		$p_code = $result[1];
		$p_image = JURI::root().substr($result[2], 3);
		
		$query2 = "select name,address1,address2,email_id,Contact_number,city,states where id='$v_id'";
		$db->setQuery($query2);
		$result2 = $db->loadRow();
		$v_name = $result[0];
		$v_address = $result[1]."<br />".$result[2]."<br />".$result[4]."<br />".$result[5]."<br />".$result[6];
		$v_email = $result[3];
		
		$query3 = "select email from #__users where gid='25' and usertype='Super Administrator'";
		$db->setQuery($query3);
		$result = $db->loadAssocList();
		foreach($result as $row12)
		{
			$toAssres = $row12['email'].",";
		}
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: Admin Deal Catalog '.$toAddres. "\r\n";
		
		$to = $u_email;
		$subject = "Customer Coupon Code for product ".$p_name;
		$message = '
		<html>
			<head>
				<title> Customer Coupon Code for product </title>
			</head>
			<body>
				<p>  <b> <center> Coupon for the Product '.$p_name.' </center> </b> </p>
				<p> <b> <center> Take this print out while you going to Merchant Place </center> </b> </p>
				<table>
					<tr>
						<td> Product name : '.$p_name.' </td>
					</tr>
					<tr>
						<td> Product code : '.$p_code.' </td>
					</tr>
					<tr>
						<td> Merchant Address : '.$v_address.' </td>
					</tr>
					<tr>
						<td> Coupon Code : '.$c_code.' </td>
					</tr>
				</table>
			</body>
		</html>
		';
		mail($to, $subject, $message, $headers);
		
		$to1 = $v_email;
		$subject1 = "Coupon Code for product ".$p_name;
		$message1 = '
		<html>
			<head>
				<title> Customer Coupon Code for product </title>
			</head>
			<body>
				<p>  <b> <center> Coupon for the Product '.$p_name.' </center> </b> </p>
				<p> <b> <center> Take this print out while you going to Merchant Place </center> </b> </p>
				<table>
					<tr>
						<td> Product name : '.$p_name.' </td>
					</tr>
					<tr>
						<td> Product code : '.$p_code.' </td>
					</tr>
					<tr>
						<td> Customer Name : '.$u_name.' </td>
					</tr>
					<tr>
						<td> Coupon Code : '.$c_code.' </td>
					</tr>					
				</table>
			</body>
		</html>
		';
		mail($to1, $subject1, $message1, $headers);
		
		$mainframe->redirect('index.php?option=com_dealcatalog&task=Coupons', 'Added / Edited User Coupon code ');
	}
	
	function couponsedit()
	{
		$id = JRequest::getVar('id', 0, 'get', 'int');
		$db	=& JFactory::getDBO();
		$cid = JRequest::getVar('cid',array(0),'','array');
		JArrayHelper::toInteger($cid, array(0));
		$id = $cid[0];
		$row =& JTable::getInstance('deal_coupons', 'Table'); 
		$row->load( $id);
		DealCatalogHTML::couponsedit(&$row);
	}
	
	function couponsremove()
	{
		global $mainframe;
		$db =& JFactory::getDBO();
		$cid = JRequest::getVar('cid',array(),'','array');
		JArrayHelper::toInteger($cid);
		if (count( $cid )) {
			$cids = implode( ',', $cid );
			$query = 'DELETE FROM #__deal_coupons'
			. ' WHERE id IN ( '. $cids .' )'
			;
			$db->setQuery( $query );
			if (!$db->query()) {
				echo "<script> alert('".$db->getErrorMsg(true)."'); 
			   window.history.go(-1); </script>\n";
			}
		}
		$mainframe->redirect('index.php?option=com_dealcatalog&task=Coupons', 'Product deals coupon Successfully Deleted');
	}
	
?>