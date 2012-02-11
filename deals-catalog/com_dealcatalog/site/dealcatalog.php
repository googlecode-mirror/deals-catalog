<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

$document = & JFactory::getDocument();
$document->addStyleSheet('components/com_dealcatalog/css/dealcatalog.css');

require_once( JApplicationHelper::getPath( 'html' ) );

$task 	= JRequest::getVar('task', '' ,"REQUEST");
$pid1 	= JRequest::getVar('productlisting', '' ,"REQUEST");
$category 	= JRequest::getVar('category', '' ,"REQUEST");
$promotion 	= JRequest::getVar('promotion', '' ,"REQUEST");

switch ($task) {

	default:
		DealCatalogHTML::mydefault();
		break;
		
	case 'productview':
		DealCatalogHTML::productview($pid1);
		break;
		
	case 'coupon_email':
		coupon_email();
		break;
		
	case 'customerregister':
		DealCatalogHTML::customerregister();
		break;
		
	case 'customersave':
		customersave();
		break;
		
	case 'registersuccess':
		customersuccess();
		break;
		
	case 'categorysearch':
		DealCatalogHTML::categorysearch();
		break;
		
	case 'dealpromotion':
		DealCatalogHTML::dealpromotion($promotion);
		break;
		
	case 'productslisting':
		DealCatalogHTML::productslisting();
		break;		
	
	case 'categoryproduct':				
		categoryproduct();				
		break;			
		
	case 'compareproducts':
		compareproducts();
		break;
		
	case 'merchantdefault':
		DealCatalogHTML::merchantdefault();
		break;
		
	case 'products':
		DealCatalogHTML::products();
		break;
		
	case 'addproducts':
		DealCatalogHTML::addproducts();
		break;
		
	case 'saveproduct':
		saveproduct();
		break;
		
	case 'addproductslistingdeals':
		DealCatalogHTML::addproductslistingdeals();
		break;
		
	case 'listdealsave':
		listdealsave();
		break;
		
	case 'myproductslisting':
		DealCatalogHTML::myproductslisting();
		break;
		
	case 'editproductlisting':
		DealCatalogHTML::editproductlisting();
		break;
		
	case 'listingsave':
		listingsave();
		break;
		
	case 'coupons':
		DealCatalogHTML::coupons();
		break;
		
	case 'merchantregister':
		DealCatalogHTML::merchantregister();
		break;
		
	case 'merchantsave':
		merchantsave();
		break;
		
	case 'merchantsuccess';
		merchantsuccess();
		break;
}

function coupon_email()
{
	$action = $_POST['action'];	
	$customername = $_POST['customername'];
	$u_email = $_POST['customeremail'];
	$p_name = $_POST['productname'];
	$c_code = $_POST['couponcode'];
	$v_email = $_POST['vendoremail'];
	$v_company = $_POST['vendorcompany'];
	$vendor_id = $_POST['vendor_id'];
	$product_id = $_POST['product_id'];
	$users_userid = $_POST['users_userid'];		
		$db = &JFactory::getDBO();
		$query = "insert into #__deal_coupons (`users_userid`, `product_id`, `vendor_id`, `coupon_code`) values ('$users_userid', '$product_id', '$vendor_id', '$c_code')";
		$db->setQuery($query);
		$db->query();
		//Coupon count
			$query = "select product_viewcount,product_couponcount from #__deal_productcounts where product_id='$product_id' and vendor_id='$vendor_id'";
			$db->setQuery($query);
			$ct = $db->loadRow();
			$cts = $ct[0];
			$cps = $ct[1];
			if($cts==0)
			{
				$cts = $cts + 1;
				$cps = $cps + 1;
				$query = "insert into #__deal_productcounts (`product_id`, `vendor_id`, `product_viewcount`, `product_couponcount`) values ('$product_id', '$vendor_id', '$cts', '$cps')";
				$db->setQuery($query);
				$db->query();
			}
			else
			{
				$cps = $cps + 1;
				$query = "update #__deal_productcounts set `product_couponcount`='$cps' where product_id='$product_id' and vendor_id='$vendor_id'";
				$db->setQuery($query);
				$db->query();
			}
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
				<title> Customer Coupon Code for product '.$p_name.'</title>
			</head>
			<body>
				<p> Hello '.$customername.',</p>
				<p>  <b> <center> Coupon for the Product '.$p_name.' </center> </b> </p>
				<p> <b> <center> Take this print out while you going to Merchant Place </center> </b> </p>
				<table>
					<tr>
						<td> Merchant Name : '.$v_company.' </td>
					</tr>
					<tr>
						<td> Product name : '.$p_name.' </td>
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
				<title> Coupon Code for product '.$p_name.'</title>
			</head>
			<body>
				<p>  <b> <center> Coupon for the Product '.$p_name.' </center> </b> </p>
				<table>
					<tr>
						<td> Product name : '.$p_name.' </td>
					</tr>
					<tr>
						<td> Customer Name : '.$customername.' </td>
					</tr>
					<tr>
						<td> Coupon Code : '.$c_code.' </td>
					</tr>
				</table>
			</body>
		</html>
		';
		mail($to1, $subject1, $message1, $headers);
		
		header("Location: ".$action);
}

function customersave()
{
	//print_r($_POST);
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$username = $_POST['username'];
	$password = $_POST['pass'];
	$address1 = $_POST['address1'];
	$address2 = $_POST['address2'];
	$city = $_POST['city'];
	$states = $_POST['states'];
	$Contact_number = $_POST['Contact_number'];
	$email_id = $_POST['email_id'];
	
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
			
		$query = "insert into #__deal_customers (`name`, `users_id`, `username`, `password`, `firstname`, `lastname`, `address1`, `address2`, `email_id`, `Contact_number`, `city`, `states`, `approved`) values ('$name', '$id1', '$username', '$password', '$firstname', '$lastname', '$address1', '$address2', '$email_id', '$Contact_number', '$city', '$states', '1')";
		$db->setQuery($query);
		$result = $db->query();
		
		header("Location: index.php?option=com_dealcatalog&task=registersuccess");
	}
}	
	function customersuccess()
	{
		?>
		<script type="text/javascript" src="components/com_dealcatalog/js/jquery1.7.js"></script>
		<script type="text/javascript" src="components/com_dealcatalog/js/jquery.fancybox.js"></script>
		<link rel="stylesheet" type="text/css" href="components/com_dealcatalog/js/jquery.fancybox.css" media="screen" />
		<script type="text/javascript">
			$(document).ready(function() {
				$(".fancybox").fancybox();
			});
		</script>
		<?php
		echo "<h3> You has been successfully registered, You may login now the username and password you given </h3>";
		?>
		<a class="fancybox" href="#customerlogin" title="Customer Login"> Click here to Login </a>
		<div id="customerlogin" style="display:none;">
		<?php
			$document	= &JFactory::getDocument();
			$renderer	= $document->loadRenderer('modules');
			$options	= array('style' => 'xhtml');
			$position	= 'customerlogin';
			echo $renderer->render($position, $options, null);
		?>
		</div>
		<?php
		$user = &JFactory::getUser();
		$user_id = $user->id;
		if($user_id != 0)
		{
			header("Location: ".$_SESSION['curr_url']);
		}
	}		
	
	function categoryproduct()	
	{		
		if($_POST['category']!='' && $_POST['product_name']!='')		
		{			
			$category_id = $_POST['category'];			
			$product_name = $_POST['product_name'];		
		}
		else
		{
			$category_id = $_SESSION['cat_id'];
			$product_name = $_SESSION['p_name'];
		}
		DealCatalogHTML::categoryproduct($category_id,$product_name);	
	}
	
	function compareproducts()
	{
		$product_vendor = $_POST['product_vendor'];
		$pv = explode(",", $product_vendor);
		$p1 = $pv[0];
		$v1 = $pv[1];
		$p2 = $pv[2];
		$v2 = $pv[3];
		DealCatalogHTML::compareproducts($p1,$v1,$p2,$v2);
	}
	
	function saveproduct()
	{
		//print_r($_POST);
		$db = &JFactory::getDBO();
		$product_name = $_POST['product_name'];
		$product_code = $_POST['product_code'];
		$product_desc = $_POST['product_desc'];
		$category_id = $_POST['category_id'];
		$addcategory = $_POST['addcategory'];
		$category_name = $_POST['category_name'];
		$manufacturer_id = $_POST['manufacturer_id'];
		$addmanufacturer = $_POST['addmanufacturer'];
		$manufacturer_name = $_POST['manufacturer_name'];
		$Itemid = $_POST['Itemid'];
		$query = "select category_name from #__deal_productcategories where id='$category_id'";
		$db->setQuery($query);
		$cat = $db->loadRow();
		$cat_name = $cat[0];		
		$query = "select product_code from #__deal_products where product_code='$product_code'";
		$db->setQuery($query);
		$result = $db->loadRow();
		$p_code = $result[0];
		if($p_code!='')
		{
			echo "<script> alert('Product Code already exits, please give another product code'); window.history.go(-1); </script>";
		}
		else
		{
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
						$current_location = "components/com_dealcatalog/images";
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
								$orginal_location = "../".$original;
								$thumb_location = "../".$thumb;
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
			if($addcategory=='1' && $category_name!='')
			{
					$query = "insert into #__deal_productcategories (`category_name`, `category_desc`) values ('$category_name', '')";
					$db->setQuery($query);
					$db->query();
					
					$query = "select id from #__deal_productcategories order by id desc limit 1";
					$db->setquery($query);
					$category = $db->loadRow();
					$category_id = $category[0];
			}				
			if($addmanufacturer=='1' && $manufacturer_name!='')
			{
					$query = "insert into #__deal_manufacturer (`manufacturer_name`) values ('$manufacturer_name')";
					$db->setQuery($query);
					$db->query();
					
					$query = "select id from #__deal_manufacturer order by id desc limit 1";
					$db->setQuery($query);
					$manufacturer = $db->loadRow();
					$manufacturer_id = $manufacturer[0];
			}
			if($orginal_location=='' && $thumb_location=='')
			{
				$orginal_location = "../components/com_dealcatalog/default.png";
				$thumb_location = "../components/com_dealcatalog/default.png";
			}
			$query = "insert into #__deal_products (`product_name`, `product_code`, `product_desc`, `manufacturer_id`, `category_id`, `product_image1`, `product_thumbimage1`) values ('$product_name', '$product_code', '$product_desc', '$manufacturer_id', '$category_id', '$orginal_location', '$thumb_location')";
			$db->setQuery($query);
			$db->query();
			
			$query = "select id from #__deal_products order by id desc limit 1";
			$db->setQuery($query);
			$productid = $db->loadRow();
			$_SESSION['newproduct'] = $productid[0];
			$url = "index.php?option=com_dealcatalog&task=products&Itemid=".$Itemid;
			header("Location: ".$url);
		}
	}
	
	function listdealsave()
	{
		//print_r($_POST);
		$vendor_id = $_POST['vendor_id'];
		$product_id = $_POST['product_id'];
		$stock_in = $_POST['stock_in'];
		$price = $_POST['price'];
		$discount_price = $_POST['discount_price'];
		$listingstart_date = $_POST['listingstart_date'];
		$listingend_date = $_POST['listingend_date'];
		$is_deal = $_POST['isdeal'];
		$deal_price = $_POST['deal_price'];
		$dealstart_date = $_POST['dealstart_date'];
		$dealend_date = $_POST['dealend_date'];
		$promotion_type = $_POST['promotion_type'];
		$Itemid = $_POST['Itemid'];
		$desc = $_POST['productdesc'];
		if($desc==1)
		{
			$merchantproduct_desc = $_POST['merchantproduct_desc'];
		}
		$img = $_POST['productimg'];
		$category = $_POST['category'];
		if($img==1)
		{
			$current_location = "components/com_dealcatalog/images";
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
		if($img==1)
		{
			$merchantproduct_image1 = "../".$orginal_location;
			$merchantproduct_thumbimage1 = "../".$thumb_location;
		}
		$db = &JFactory::getDBO();
		$query = "insert into #__deal_productslisting_deals (`vendor_id`, `product_id`, `stock_in`, `price`, `discount_price`, `listingstart_date`, `listingend_date`, `merchantproduct_desc`, `merchantproduct_image1`, `merchantproduct_thumbimage1`, `is_deal`, `deal_price`, `dealstart_date`, `dealend_date`, `promotion_type`) values ('$vendor_id', '$product_id', '$stock_in', '$price', '$discount_price', '$listingstart_date', '$listingend_date', '$merchantproduct_desc', '$merchanrproduct_image1', '$merchantproduct_thumbimahe1', '$is_deal', '$deal_price', '$dealstart_date', '$dealend_date', '$promotion_type')";
		$db->setQuery($query);
		$db->query();
		
		$url = "index.php?option=com_dealcatalog&task=myproductslisting&Itemid=".$Itemid;
		header("Location: ".$url);
	}
	
	function listingsave()
	{
		$vendor_id = $_POST['vendor_id'];
		$product_id = $_POST['product_id'];
		$stock_in = $_POST['stock_in'];
		$price = $_POST['price'];
		$discount_price = $_POST['discount_price'];
		$listingstart_date = $_POST['listingstart_date'];
		$listingend_date = $_POST['listingend_date'];
		$is_deal = $_POST['isdeal'];
		$deal_price = $_POST['deal_price'];
		$dealstart_date = $_POST['dealstart_date'];
		$dealend_date = $_POST['dealend_date'];
		$promotion_type = $_POST['promotion_type'];
		$Itemid = $_POST['Itemid'];
		$desc = $_POST['productdesc'];
		$plist = $_POST['productlist'];
		$imgs = $_POST['mimage'];
		$imgs1 = $_POST['mimage1'];
		$img = $_POST['productimg'];
		$category = $_POST['category'];
		if($desc==1)
		{
			$merchantproduct_desc = $_POST['merchantproduct_desc'];
		}
		else
		{
			$merchantproduct_desc = '';
		}
		if($img==1 && $imgs=='')
		{
			$current_location = "components/com_dealcatalog/images";
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
			echo $file_name = $_FILES["file"]["name"]; 
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
		if($img==1 && $imgs=='')
		{
			$merchantproduct_image1 = "../".$orginal_location;
			$merchantproduct_thumbimage1 = "../".$thumb_location;
		}
		if($is_deal==0)
		{
			$deal_price = '0.00';
			$dealstart_date = '0000-00-00';
			$dealend_date = '0000-00-00';
			$promotion_type = '';
		}
		$db = &JFactory::getDBO();
		$query = "update #__deal_productslisting_deals set `stock_in`='$stock_in', `price`='$price', `discount_price`='$discount_price', `listingstart_date`='$listingstart_date', `listingend_date`='$listingend_date', `merchantproduct_desc`='$merchantproduct_desc', `merchantproduct_image1`='$merchantproduct_image1', `merchantproduct_thumbimage1`='$merchantproduct_thumbimage1', `is_deal`='$is_deal', `deal_price`='$deal_price', `dealstart_date`='$dealstart_date', `dealend_date`='$dealend_date', `promotion_type`='$promotion_type' where id='$plist'";
		$db->setQuery($query);
		$db->query();
		
		$url = "index.php?option=com_dealcatalog&task=myproductslisting&Itemid=".$Itemid;
		header("Location: ".$url);
	}
	
	function merchantsave()
	{
		//print_r($_POST);
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$username = $_POST['username'];
		$password = $_POST['pass'];
		$company_name = $_POST['company_name'];
		$address1 = $_POST['address1'];
		$address2 = $_POST['address2'];
		$city = $_POST['city'];
		$states = $_POST['states'];
		$Contact_number = $_POST['Contact_number'];
		$email_id = $_POST['email_id'];
		$location_map = $_POST['location_map'];
		$Itemid = $_POST['Itemid'];
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
			$query = "INSERT INTO jos_users (`name`, `username`, `email`, `password`, `usertype`, `gid`, `registerDate`) VALUES ('$name', '$username', '$email_id', '$password', 'Merchants', '32', '$date')";
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
				
			echo $query = "insert into #__deal_merchants (`name`, `user_id`, `username`, `password`, `firstname`, `lastname`, `company_name`, `address1`, `address2`, `email_id`, `Contact_number`, `city`, `states`, `location_map`, `approved`) values ('$name', '$id1', '$username', '$password', '$firstname', '$lastname', '$company_name', '$address1', '$address2', '$email_id', '$Contact_number', '$city', '$states', '$location_map', '0')";
			$db->setQuery($query);
			$result = $db->query();
			
			$query3 = "select email from #__users where gid='25' and usertype='Super Administrator'";		
			$db->setQuery($query3);		
			$result = $db->loadAssocList();		
			foreach($result as $row12)		
			{			
				$toAssres = $row12['email'].",";		
			}
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";	
			$headers .= 'From: New Merchant Regsitration '.$toAddres. "\r\n";		
			$to = $toAssres;		
			$subject = "New Merchant Registration ";	
			$message = 
			'<html>
				<head>
					<title> New Merchant Registration </title>
				</head>
				<body>
					A New Merchant has been Registered and waiting for Approval for adding the products and deal for customers <br />
					Merchant Name : '.$name.' <br />
					Company Name : '.$company_name.' <br />
					Address : '.$address1.','.$address2.' , '.$city.','.$states.' <br />
					Contact Number : '.$Contact_number.' <br />
					Email -id : '.$email_id.' <br />
				</body>
			 </html>';		
			mail($to, $subject, $message, $headers);
			
			header("Location: index.php?option=com_dealcatalog&task=merchantsuccess&Itemid=".$Itemid);
		}
	}
	
	function merchantsuccess()
	{
		echo "Hello Merchants, <br /> Your Registration is on process, after the approval from the administration you recieve the mail to your mail id <br />";
		echo "Regards , <br /> Adminstrator. <br />";
	}
	
	
?>