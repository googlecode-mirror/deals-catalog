<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

class DealCatalogHTML {

	function mydefault() 
	{			
		echo "welcome to Deal Catalog for Merchants and users";		
		$db = &JFactory::getDBO();
		$today_date = date('Y-m-d');
		?>
		<div id="deals">
			<div id="main_promoted">				
				<script type="text/javascript" src="components/com_dealcatalog/js/jquery.js"></script>
				<script type="text/javascript" src="components/com_dealcatalog/js/easySlider1.7.js"></script>
				<script type="text/javascript">
					$(document).ready(function(){	
						$("#slider").easySlider({
						auto: true, 
						continuous: true
						});
					});	
				</script>
				
				<div id="slider">
					<ul>
						<?php
						$today_date = date('Y-m-d');
						$query  = "select a.product_id,a.id,a.merchantproduct_image1,a.price,a.deal_price,c.company_name,b.product_name,b.product_image1 from #__deal_productslisting_deals as a,#__deal_products as b,#__deal_merchants as c where a.promotion_type='1' and a.dealstart_date <= '$today_date' and a.dealend_date >= '$today_date' and a.stock_in='1' and a.product_id=b.id and a.vendor_id=c.id order by a.id asc";
						$db->setQuery($query);
						$main = $db->loadAssocList();
						$no = count($main);
						if($no > 0)
						{
							foreach($main as $row)
							{
								$pname = $row['product_name'];
								$pid = $row['id'];
								$merchant_image = $row['merchantproduct_image1'];
								$orginal_image = $row['product_image1'];
								if($merchant_image!='')
								{
									$org_image = substr($merchant_image, 3);
								}
								else
								{
									$org_image = substr($orginal_image, 3);
								}
								$org_price = $row['price'];
								$deal_price = $row['deal_price'];
								$per = $org_price - $deal_price;
								$per = ($per / $org_price) * 100;
								$per = round($per,2);
								$per = $per."%";
								$company = $row['company_name'];
							?>
								<li>								
									<h3> <?php echo $pname." with ".$per. " off from ".$company; ?> </h3>
									<a href="index.php?option=com_dealcatalog&task=productview&productlisting=<?php echo $pid; ?>&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> 	<img src="<?php echo $org_image; ?>" alt="<?php echo $pname; ?>"> 
									</a>								
								</li>
							<?php
							}
						}
						?>
					</ul>
				</div>
			</div>
			<div id="second_promoted">
				<?php
					$query = "select a.product_id,a.id,a.merchantproduct_thumbimage1,b.product_name,b.product_thumbimage1 from #__deal_productslisting_deals as a,#__deal_products as b where a.promotion_type='2' and a.dealstart_date <= '$today_date' and a.dealend_date >= '$today_date' and a.stock_in='1' and a.product_id=b.id order by a.id asc";
					$db->setQuery($query);
					$total = $db->loadResultArray();
					$total_promotion2 = count($total);
					
					$query = "select a.product_id,a.id,a.merchantproduct_thumbimage1,b.product_name,b.product_thumbimage1 from #__deal_productslisting_deals as a,#__deal_products as b where a.promotion_type='2' and a.dealstart_date <= '$today_date' and a.dealend_date >= '$today_date' and a.stock_in='1' and a.product_id=b.id order by a.id asc limit 3";
					$db->setQuery($query);
					$second = $db->loadAssocList();
					$no1 = count($second);
					if($no1 > 0)
					{
						foreach($second as $row)
						{
							$pname = $row['product_name'];
							$pid = $row['id'];
							$merchant_image = $row['merchantproduct_thumbimage1'];
							$orginal_image = $row['product_thumbimage1'];
							if($merchant_image!='')
							{
								$org_image = substr($merchant_image, 3);
							}
							else
							{
								$org_image = substr($orginal_image, 3);
							}
							?>
							<div class="sec_product">
								<div class="pname"> 
									<span class="view_pname">
										<?php echo $pname; ?>
									</span>
									<span class="view_link"> 
										<a href="index.php?option=com_dealcatalog&task=productview&productlisting=<?php echo $pid; ?>&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> View Details </a>
									</span>
								</div>
								<div class="pimage"> 
									<img src="<?php echo $org_image; ?>"> 
								</div>
							</div>
							<?php
						}
					}
				?>
				<?php
				if($total_promotion2 > 3)
				{
				?>
					<div class="more_deals">
						<a href="index.php?option=com_dealcatalog&task=dealpromotion&promotion=2&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> View More Deals </a>
					</div>
				<?php
				}
				?>
			</div>
			<div id="third_promotion">
				<?php
					$query = "select a.product_id,a.id,a.merchantproduct_thumbimage1,b.product_name,b.product_thumbimage1 from #__deal_productslisting_deals as a,#__deal_products as b where a.promotion_type='3' and a.dealstart_date <= '$today_date' and a.dealend_date >= '$today_date' and a.stock_in='1' and a.product_id=b.id order by a.id asc";
					$db->setQuery($query);
					$total = $db->loadResultArray();
					$total_promotion3 = count($total);
					
					$query = "select a.product_id,a.id,a.merchantproduct_thumbimage1,b.product_name,b.product_thumbimage1 from #__deal_productslisting_deals as a,#__deal_products as b where a.promotion_type='3' and a.dealstart_date <= '$today_date' and a.dealend_date >= '$today_date' and a.stock_in='1' and a.product_id=b.id order by a.id asc limit 5";
					$db->setQuery($query);
					$third = $db->loadAssocList();
					$no2 = count($third);
					if($no2 > 0)
					{
						foreach($third as $row)
						{
							$pname = $row['product_name'];
							$pid = $row['id'];
							$merchant_image = $row['merchantproduct_thumbimage1'];
							$orginal_image = $row['product_thumbimage1'];
							if($merchant_image!='')
							{
								$org_image = substr($merchant_image, 3);
							}
							else
							{
								$org_image = substr($orginal_image, 3);
							}
							?>
							<div class="third_view">
								<div class="third_image">
									<a href="index.php?option=com_dealcatalog&task=productview&productlisting=<?php echo $pid; ?>&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> <img src="<?php echo $org_image; ?>"> </a>
								</div>
								<div class="third_pname">
									<a href="index.php?option=com_dealcatalog&task=productview&productlisting=<?php echo $pid; ?>&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> <?php echo $pname; ?> </a>
								</div>
							</div>
						<?php
						}
					}
				?>
			</div>
			<?php
			if($total_promotion3 > 5)
			{
			?>
				<div class="more_deals">
					<a href="index.php?option=com_dealcatalog&task=dealpromotion&promotion=3&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> View More Deals </a>
				</div>
			<?php
			}
			?>
			<div class="heading"> Product Listing </div>
			<div id="product_listing">
				<?php
					$query = "select a.id,a.product_id,a.merchantproduct_thumbimage1,b.product_name,b.product_thumbimage1 from #__deal_productslisting_deals as a,#__deal_products as b where a.listingstart_date <= '$today_date' and a.listingend_date >= '$today_date' and a.stock_in='1' and a.product_id=b.id order by a.id asc";
					$db->setQuery($query);
					$total = $db->loadResultArray();
					$total_productlisting = count($total);
					
					$query = "select a.id,a.product_id,a.merchantproduct_thumbimage1,b.product_name,b.product_thumbimage1 from #__deal_productslisting_deals as a,#__deal_products as b where a.listingstart_date <= '$today_date' and a.listingend_date >= '$today_date' and a.stock_in='1' and a.product_id=b.id order by a.id asc limit 5";
					$db->setQuery($query);
					$listings = $db->loadAssocList();
					$no3 = count($listings);
					if($no3 > 0)
					{
						foreach($listings as $row)
						{
							$pname = $row['product_name'];
							$pid = $row['id'];
							$merchant_image = $row['merchantproduct_thumbimage1'];
							$orginal_image = $row['product_thumbimage1'];
							if($merchant_image!='')
							{
								$org_image = substr($merchant_image, 3);
							}
							else
							{
								$org_image = substr($orginal_image, 3);
							}
							?>
							<div class="third_view">
								<div class="third_image">
									<a href="index.php?option=com_dealcatalog&task=productview&productlisting=<?php echo $pid; ?>&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> <img src="<?php echo $org_image; ?>"> </a>
								</div>
								<div class="third_pname">
									<a href="index.php?option=com_dealcatalog&task=productview&productlisting=<?php echo $pid; ?>&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> <?php echo $pname; ?> </a>
								</div>
							</div>
						<?php
						}
					}
				?>
			</div>
			<?php
			if($total_productlisting > 5)
			{
			?>
				<div class="more_productlist">
					<a href="index.php?option=com_dealcatalog&task=productslisting&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> View More Products Listings </a>
				</div>
			<?php
			}
			?>
		</div>		
		<?php
	}

	function productview($pid)
	{ 
		function currenturl()
		{
			$_SESSION['curr_url'] = $_SERVER["REQUEST_URI"]; 
		}
		?>
		<script type="text/javascript" src="components/com_dealcatalog/js/jquery1.7.js"></script>
		<script type="text/javascript" src="components/com_dealcatalog/js/jquery.fancybox.js"></script>		
		<link rel="stylesheet" type="text/css" href="components/com_dealcatalog/js/jquery.fancybox.css" media="screen" />
		<script type="text/javascript">
			$(document).ready(function() {
				$(".fancybox").fancybox();
			});
		</script>
		<script language="javascript" type="text/javascript">
			function sent_coupon()
			{
				document.coupon.submit();
			}
			function current_url()
			{
				b = "<?php currenturl(); ?>";
			}
		</script>
		<?php
		$user = &JFactory::getUser();
		$userid = $user->id;
		$username = $user->name;
		$useremail = $user->email;
		$db = &JFactory::getDBO();
		$today_date = date('Y-m-d');
		$query = "select a.*,b.product_name,b.product_code,b.product_image1,b.product_thumbimage1,b.product_desc,c.category_name,d.manufacturer_name,e.company_name,e.address1,e.address2,e.email_id,e.Contact_number,e.city,e.states,e.location_map from #__deal_productslisting_deals as a,#__deal_products as b,#__deal_productcategories as c,#__deal_manufacturer as d,#__deal_merchants as e where a.id='$pid' and a.stock_in='1' and a.product_id=b.id and b.category_id=c.id and b.manufacturer_id=d.id and a.vendor_id=e.id and a.listingstart_date <= '$today_date' and a.listingend_date >= '$today_date'";
		$db->setQuery($query);
		$product = $db->loadAssocList();
		foreach($product as $row)
		{
			//values of product list
			$productlistid = $row['id'];
			$product_id = $row['product_id'];
			$vendor_id = $row['vendor_id'];
			$product_name = $row['product_name'];
			$product_code = $row['product_code'];
			$category = $row['category_name'];
			$manufacturer = $row['manufacturer_name'];
			$company = $row['company_name'];
			$address = $row['address1']." ".$row['address2']." , ".$row['city']." ".$row['states'];
			$contact_number = $row['Contact_number'];
			$email = $row['email_id'];
			$location = $row['location_map'];
			$price = $row['price'];
			$discount_price = $row['discount_price'];
			$product_close = $row['listingend_date'];
			$isdeal = $row['is_deal'];
			$deal_price = $row['deal_price'];
			$dealstart = $row['dealstart_date'];
			$dealclose = $row['dealend_date'];
			$product_desc = $row['product_desc'];
			$merchant_desc = $row['merchantproduct_desc'];
			$pimage = $row['product_image1'];
			$pimage1 = $row['product_thumbimage1'];
			$merchantimage = $row['merchantproduct_image1'];
			$merchantimage1 = $row['merchantproduct_thumbimage1'];
			//Product Image
			if($merchantimage!='')
			{
				$image = substr($merchantimage, 3);
				$thumb_image = substr($merchantimage1, 3);
			}
			else
			{
				$image = substr($pimage, 3);
				$thumb_image = substr($pimage1, 3);
			}
			//Product Description
			if($merchant_desc!='')
			{
				$desc = $merchant_desc;
			}
			else
			{
				$desc = $product_desc;
			}
			//Price difference
			if($deal_price!=0.00)
			{
				$deal = $price - $deal_price;
			}
			else
			{
				$deal = 0.00;
			}
			if($discount_price!=0.00)
			{
				$discount = $price - $discount_price;
			}
			else
			{
				$discount = 0.00;
			}
			//Deal and Discount percentage
			if($deal_price!=0.00)
			{
				$per = $price - $deal_price;
				$per = ($per / $price) * 100;
				$per = round($per,2);
				$per = $per."%";
			}
			else
			{
				$per = "0%";
			}
			if($discount_price!=0.00)
			{
				$per1 = $price - $discount_price;
				$per1 = ($per1 / $price) * 100;
				$per1 = round($per1,2);
				$per1 = $per1."%";
			}
			else
			{
				$per1 = "0%";
			}
			//date comparison
			$today = strtotime($today_date);
			$dealstarts = strtotime($dealstart);
			$dealends = strtotime($dealclose);
			//Facebook Code
			function getPostURL() 
			{
				$postURL = 'http';
				if ($_SERVER["HTTPS"] == "on") {$postURL .= "s";}
				$postURL .= "://";
				if ($_SERVER["SERVER_PORT"] != "80")
				{
					$postURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
				} 
				else 
				{
					$postURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
				}
				return $postURL;
			}
			$postURL=getPostURL();
			//Coupon code
			$query = "select coupon_code from #__deal_coupons where users_userid='$userid' and product_id='$product_id'";
			$db->setQuery($query);
			$copon = $db->loadRow();
			$codes = $copon[0];
			if($codes!='')
			{
				$coupon = $codes;
			}
			else
			{
				$characters = '5';
				$possible = '23456789bcdfghjkmnpqrstvwxyzBCDEFGHIJKLMNPQURSTUVWXYZ';
				$code = '';
				$i = 0;
				while ($i < $characters) {
					$code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
					$i++;
				}
				$coupon = $code;
			}
			//product count
			$query = "select product_viewcount from #__deal_productcounts where product_id='$product_id' and vendor_id='$vendor_id'";
			$db->setQuery($query);
			$ct = $db->loadRow();
			$cts = $ct[0];
			if($cts==0)
			{
				$cts = $cts + 1;
				$query = "insert into #__deal_productcounts (`product_id`, `vendor_id`, `product_viewcount`, `product_couponcount`) values ('$product_id', '$vendor_id', '$cts', '')";
				$db->setQuery($query);
				$db->query();
			}
			else
			{
				$cts = $cts + 1;
				$query = "update #__deal_productcounts set `product_viewcount`='$cts' where product_id='$product_id' and vendor_id='$vendor_id'";
				$db->setQuery($query);
				$db->query();
			}
			?>
			<div id="single_product">
				<div id="product_head">
					<div class="head1">
						<div class="head_text"> Customer Choice </div>
						<div class="choice"> <img src="components/com_dealcatalog/icon_7.png"> </div> 
						<div class="choice_image"> <img src="<?php echo $thumb_image; ?>">  </div> 
					</div>
					<div class="head2">
						<div> <b> <h2> <?php echo $product_name; ?> </h2> </b> </div>
						<div> Checkout this product with  <b> Deal </b> or <b> Discount </b> price and signup to get if Deal Coupon code exits</div>
					</div>
				</div>
				<div class="back1">
					<a href="javascript:history.back()">Go back</a> 
				</div>
				<div class="back">
					<a href='index.php?option=com_dealcatalog&task=productslisting&Itemid=<?php echo $_REQUEST['Itemid']; ?>'> View Product Listings </a>
				</div>
				<div class="phead">
					<?php
					if(($isdeal==1) && ($dealstarts <= $today && $dealends >= $today) && ($deal > $discount))
					{
					?>
						<h2> <?php echo $product_name; ?>  <?php echo $per; ?> Deal off from <?php echo $company; ?> </h2>
					<?php
					}
					else
					{
						if($deal==0 && $discount==0.00)
						{
						?>
							<h2> <?php echo $product_name; ?>  from <?php echo $company; ?> </h2>
						<?php
						}
						else
						{
						?>
							<h2> <?php echo $product_name; ?>  <?php echo $per1; ?> Discount off from <?php echo $company; ?> </h2>
						<?php
						}
					}
					?>
				</div>
				<div id="image_fb">
					<div class="big_image">
						<a class="fancybox" href="<?php echo $image; ?>" title="<?php echo $product_name; ?>">
							<img src="<?php echo $thumb_image; ?>" />
						</a>
					</div>
					<div class="fb_like">
						<?php
							echo '<iframe src="http://www.facebook.com/widgets/like.php?href='.$postURL.'"
								scrolling="no" frameborder="0"
								style="border:none; width:450px; height:40px"></iframe>';
							?>
					</div>
					<?php
					if(($isdeal == 1) && ($dealstarts <= $today && $dealends >= $today))
					{
					?>
						<div id="coupon">
							<?php
								if($userid==0)
								{
									?>
									Coupon Code &nbsp;&nbsp; <a class="fancybox" href="#customerlogin" title="Customer Login"> Login </a>&nbsp; / &nbsp;&nbsp;&nbsp;<a href="index.php?option=com_dealcatalog&task=customerregister&Itemid=<?php echo $_REQUEST['Itemid']; ?>" onClick="current_url();"> Register </a>
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
								}
								else
								{
									?>
									<form name="coupon" action="index.php?option=com_dealcatalog&task=coupon_email&Itemid=<?php echo $_REQUEST['Itemid']; ?>" method="post">
										<?php
										if($codes!='')
										{
											?>
											<span class="coupon_text" onClick="sent_coupon();"> Sent the Coupon code again </span>
											<?php
										}
										else
										{
											?>
											<span class="coupon_text" onClick="sent_coupon();"> Email the Coupon Code </span>
											<?php
										} ?>
										<input type="hidden" name="action" value="<?php echo $_SERVER["REQUEST_URI"]; ?>">
										<input type="hidden" name="customername" value="<?php echo $username; ?>">
										<input type="hidden" name="customeremail" value="<?php echo $useremail; ?>">
										<input type="hidden" name="couponcode" value="<?php echo $coupon; ?>">
										<input type="hidden" name="vendorcompany" value="<?php echo $company; ?>">
										<input type="hidden" name="vendoremail" value="<?php echo $email; ?>">
										<input type="hidden" name="productname" value="<?php echo $product_name; ?>">
										<input type="hidden" name="vendor_id" value="<?php echo $vendor_id; ?>">
										<input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
										<input type="hidden" name="users_userid" value="<?php echo $userid; ?>">
									</form>
									<?php
								}
							?>
						</div>
					<?php
					}
					?>
				</div>
				<div id="product_details">
					<div class="details_view">
						<div class="details_title">
							Merchant Name
						</div>
						<div class="details_names">
							<?php echo $company; ?>
						</div>
						<div class="details_title1">
							Product Name
						</div>
						<div class="details_names1">
							<?php echo $product_name ?>
						</div>
						<div class="details_title">
							Category Name
						</div>
						<div class="details_names">
							<?php echo $category; ?>
						</div>
						<div class="details_title1">
							Manufacturer Name
						</div>
						<div class="details_names1">
							<?php echo $manufacturer; ?>
						</div>
						<div class="details_title">
							Price
						</div>
						<div class="details_names">
							<?php echo $price; ?>
						</div>
						<?php
						if(($deal > $discount) && ($dealstarts <= $today && $dealends >= $today) && ($isdeal==1))
						{
							?>
							<div class="details_title1">
								Deal Price
							</div>
							<div class="details_names12">
								<?php echo $deal_price; ?>
							</div>
							<?php
						}
						else
						{
							if($deal==0 && $discount==0.00)
							{
								?>
								<div class="details_title1">
									Offers
								</div>
								<div class="details_names12">
									<?php echo "---"; ?>
								</div>
								<?php
							}
							else
							{
								?>
								<div class="details_title1">
									Discount Price
								</div>
								<div class="details_names12">
									<?php echo $discount_price; ?>
								</div>
								<?php
							}
						}
						?>
						<div class="details_title">
							Address
						</div>
						<div class="details_names">
							<?php echo $address; ?>
						</div>
						<div class="details_title1">
							Contact Number
						</div>
						<div class="details_names1">
							<?php echo $contact_number; ?>
						</div>
						<div class="details_title">
							Purchase Mode
						</div>
						<div class="details_names">
							Instore Online
						</div>
						<div class="details_title1">
							Product Description
						</div>
						<div class="details_names1">
							<?php echo $desc; ?>
						</div>
					</div>
					<div class="location">
						<?php echo $row['location_map']; ?>
					</div>
				</div>
			</div>
			<?php
		}
	}
	
	function customerregister()
	{
		?>
		<script type="text/javascript">
			function check_all()
			{
				var form = document.customerregister;
				if(form.firstname.value.length==0)
				{
					alert('Enter the first name');
					form.firstname.focus();
					return false;
				}
				var first_check = /^[A-Za-z ]{3,20}$/;
				if(form.firstname.value.search(first_check) == -1)
				{
					alert('Only character are allowed and firstname must be greater than 3 characters');
					form.firstname.focus();
					form.firstname.value="";
					return false;
				}
				if(form.username.value.length==0)
				{
					alert('Please Enter the username');
					form.username.focus();
					return false;
				}
				var last_check = /^[A-Za-z0-9]{3,20}$/;
				if(form.username.value.search(last_check) == -1)
				{
					alert('Only characters are allowed and username must be greater than 3 characters ');
					form.username.focus();
					form.username.value="";
					return false;
				}
				if(form.pass.value.length==0)
				{
					alert('Please Enter the password');
					form.pass.focus();
					return false;
				}
				if(form.address1.value.length==0)
				{
					alert('Please Enter your address');
					form.address1.focus();
					return false;
				}
				if(form.city.value.length==0)
				{
					alert('Please Enter your City');
					form.city.focus();
					return false;
				}
				var city_check = /^[A-Za-z ]{1,50}$/;
				if(form.city.value.search(city_check) == -1)
				{
					alert('Only Characters are allowed and more than 1 characters');
					form.city.focus();
					form.city.value="";
					return false;
				}
				if(form.states.value.length==0)
				{
					alert('Please Enter Your state');
					form.states.focus();
					return false;
				}
				if(form.Contact_number.value.length==0)
				{
					alert('Please Enter the Contact number');
					form.Contact_number.focus();
					return false;
				}
				var contact_check = /^[0-9+ ]{6,20}$/;
				if(form.Contact_number.value.search(contact_check) == -1)
				{
					alert('Only number are allowed');
					form.Contact_number.focus();
					form.Contact_number.value="";
					return false;
				}
				if(form.email_id.value.length==0)
				{
					alert('Please Enter the Email id');
					form.email_id.focus();
					return false;
				}
				var email_check = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
				if(form.email_id.value.search(email_check) == -1)
				{
					alert('Email Id not Valid');
					form.email_id.focus();
					form.email_id.value="";
					return false;
				}
				return true;
			}
		</script>
		<div id="customer_register">
			<div> <h2> New Customer Register this form </h2> </div>
			<form name="customerregister" action="index.php?option=com_dealcatalog&task=customersave" method="post" onSubmit="return check_all();">
				<fieldset>
					<legend> Sign-In </legend>
						<div class="details_title3">
							First Name
						</div>
						<div class="details_names3">
							<input type="text" name="firstname" value="">
						</div>
						<div class="details_title3">
							Last Name
						</div>
						<div class="details_names3">
							<input type="text" name="lastname" value="">
						</div>
						<div class="details_title3">
							User Name
						</div>
						<div class="details_names3">
							<input type="text" name="username" value="">
						</div>
						<div class="details_title3">
							Password
						</div>
						<div class="details_names3">
							<input type="password" name="pass" value="">
						</div>
						
						<div class="details_title3">
							Address 1
						</div>
						<div class="details_names3">
							<input type="text" name="address1" value="">
						</div>
						<div class="details_title3">
							Address 2
						</div>
						<div class="details_names3">
							<input type="text" name="address2" value="">
						</div>
						<div class="details_title3">
							City
						</div>
						<div class="details_names3">
							<input type="text" name="city" value="">
						</div>
						<div class="details_title3">
							State
						</div>
						<div class="details_names3">
							<input type="text" name="states" value="">
						</div>
						<div class="details_title3">
							Contact Number
						</div>
						<div class="details_names3">
							<input type="text" name="Contact_number" value="">
						</div>
						<div class="details_title3">
							Email-Id
						</div>
						<div class="details_names3">
							<input type="text" name="email_id" value="">
						</div>
						<div align="center"> <input type="submit" value="Register" name="customerregister"> </div>
				</fieldset>
			</form>
		</div>
		<?php
	}
	
	function categorysearch()
	{
		$db = &JFactory::getDBO();
		?>
		<script type="text/javascript" src="components/com_dealcatalog/js/jquery1.7.js"></script>
		<script type="text/javascript" src="components/com_dealcatalog/js/jquery.fancybox.js"></script>
		<link rel="stylesheet" type="text/css" href="components/com_dealcatalog/js/jquery.fancybox.css" media="screen" />
		<script type="text/javascript">
			$(document).ready(function() {
				$(".fancybox").fancybox();
			});
			function compare_product()
			{	
				count = 0;
				str = '';
				for(x=0; x<document.dealform.elements["compare[]"].length; x++)
				{
					if(document.dealform.elements["compare[]"][x].checked==true)
					{
						str += document.dealform.elements["compare[]"][x].value + ',';
						count++;
					}
				}
				if(count==0)
				{
					alert("You must choose at least 2 products to compare");
					return false;
				}
				else if(count>2)
				{
					alert("You can choose a maximum of 2 products to compare");
					return false;
				}
				else if(count==1)
				{
					alert("You can choose another 1 product for compare");
					return false;
				}
				else 
				{
					
				}
				if(count==2)
				{
					var product_vendor = str.substring(0,str.length-1);
					document.getElementById('product_vendor').value=product_vendor;
					document.compare_products.submit();
				}
			}			
		</script>
		<?php	
		global $mainframe;
		$limit= $mainframe->getUserStateFromRequest('global.list.limit','limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart= $mainframe->getUserStateFromRequest($option.'.limitstart', 'limitstart', 0, 'int');
		if($_REQUEST['limitstart']=='') {$limitstart=0;}
		$today_date = date('Y-m-d');
		$category 	= JRequest::getVar('category', '' ,"REQUEST");
		//Pagination 
		$query = "select a.product_name,a.product_image1,a.product_thumbimage1,b.id,b.product_id,b.vendor_id,b.stock_in,b.price,b.discount_price,b.listingstart_date,b.listingend_date,b.merchantproduct_image1,b.merchantproduct_thumbimage1,b.is_deal,b.deal_price,b.dealstart_date,b.dealend_date,c.company_name from #__deal_products as a,#__deal_productslisting_deals as b,#__deal_merchants as c where a.category_id='$category' and a.id=b.product_id and b.listingstart_date <= '$today_date' and b.listingend_date >= '$today_date' and b.stock_in='1' and b.vendor_id=c.id order by b.id asc";
		$db->setQuery($query);
		$total = $db->loadResultArray();
		$total = count($total);
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
		//Products display
		$query = "select a.product_name,a.product_image1,a.product_thumbimage1,b.id,b.product_id,b.vendor_id,b.stock_in,b.price,b.discount_price,b.listingstart_date,b.listingend_date,b.merchantproduct_image1,b.merchantproduct_thumbimage1,b.is_deal,b.deal_price,b.dealstart_date,b.dealend_date,c.company_name from #__deal_products as a,#__deal_productslisting_deals as b,#__deal_merchants as c where a.category_id='$category' and a.id=b.product_id and b.listingstart_date <= '$today_date' and b.listingend_date >= '$today_date' and b.stock_in='1' and b.vendor_id=c.id order by b.id asc";
		$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
		$products = $db->loadObjectList();
		//Category name
		$query = "select category_name from #__deal_productcategories where id='$category'";
		$db->setQuery($query);
		$categories = $db->loadRow();
		$categoryname = $categories[0];
		//Featured product
		$query = "select a.product_name,a.product_image1,a.product_thumbimage1,b.id,b.deal_price,b.merchantproduct_image1,b.merchantproduct_thumbimage1 from #__deal_products as a,#__deal_productslisting_deals as b where a.category_id='$category' and b.is_deal='1' and a.id=b.product_id and b.dealstart_date <= '$today_date' and b.dealend_date >= '$today_date' and b.stock_in='1' order by RAND() limit 2";
		$db->setQuery($query);
		$featured = $db->loadAssocList();
		//Featured all
		$query = "select a.product_name,a.product_image1,a.product_thumbimage1,b.id,b.deal_price,b.merchantproduct_image1,b.merchantproduct_thumbimage1 from #__deal_products as a,#__deal_productslisting_deals as b where b.is_deal='1' and a.id=b.product_id and b.dealstart_date <= '$today_date' and b.dealend_date >= '$today_date' and b.stock_in='1' order by RAND() limit 2";
		$db->setQuery($query);
		$featuredall = $db->loadAssocList();
		?>
		<div id="products_display">
			<div id="search_product">
				<div class="cat_head"> Showing the Results for "<b> <?php echo $categoryname; ?> </b>" </div>
				<div class="cat_title">
					<div class="product_count">Showing the <?php echo $pageNav->getResultsCounter(); ?> </div>
					<div class="cat_title_head" onClick="compare_product();"> Compare </div>
				</div>
				<form method="post" name="dealform" id="dealform" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
					<?php
					$k = $limitstart;
					for($i=0, $n=count($products); $i < $n ; $i++)
					{
						$row = &$products[$i];
						$productlist = $row->id;
						$product_id = $row->product_id;
						$vendor_id = $row->vendor_id;
						$product_name = $row->product_name;
						$price = $row->price;
						$company_name = $row->company_name;
						$discount_price = $row->discount_price;
						$listenddate = $row->listingend_date;
						$pimage = $row->product_image1;
						$pimage1 = $row->product_thumbimage1;
						$mimage = $row->merchantproduct_image1;
						$mimage1 = $row->merchantproduct_thumbimage1;
						$is_deal = $row->is_deal;
						$deal_price = $row->deal_price;
						$dealstartdate = $row->dealstart_date;
						$dealenddate = $row->dealend_date;
						//Product Image
						if($mimage!='')
						{
							$image = substr($mimage, 3);
							$thumb_image = substr($mimage1, 3);
						}
						else
						{
							$image = substr($pimage, 3);
							$thumb_image = substr($pimage1, 3);
						}
						//Price difference
						if($deal_price!=0.00)
						{
							$deal = $price - $deal_price;
						}
						else
						{
							$deal = 0.00;
						}
						if($discount_price!=0.00)
						{
							$discount = $price - $discount_price;
						}
						else
						{
							$discount = 0.00;
						}
						//Deal and Discount percentage
						if($deal_price!=0.00)
						{
							$per = $price - $deal_price;
							$per = ($per / $price) * 100;
							$per = round($per,2);
							$per = $per."%";
						}
						else
						{
							$per = "0%";
						}
						if($discount_price!=0.00)
						{
							$per1 = $price - $discount_price;
							$per1 = ($per1 / $price) * 100;
							$per1 = round($per1,2);
							$per1 = $per1."%";
						}
						else
						{
							$per1 = "0%";
						}
						//date comparison
						$today = strtotime($today_date);
						$dealstarts = strtotime($dealstartdate);
						$dealends = strtotime($dealenddate);
						if($i%2==0)
						{
						?>
							<div class="product_odd">
								<div class="ids"> <?php echo ($k+1); ?> </div>
								<div class="checks_boxs">
									<input type="checkbox"  value="<?php echo $product_id.",".$vendor_id; ?>" name="compare[]" /> 
								</div>
								<div class="img_views">
									<a class="fancybox" href="<?php echo $image; ?>" title="<?php echo $product_name;?>">
										<img src="<?php echo $thumb_image; ?>" />
									</a>
								</div>
								<?php
								if(($deal > $discount) && ($dealstarts <= $today && $dealends >= $today) && ($is_deal==1))
								{
									?>
									<div class="offer">
										<?php echo $product_name." from ".$company_name." ".$per." Deal off"; ?>
									</div>									
									<?php
								}
								else
								{
									if($deal==0 && $discount==0.00)
									{
										?>
										<div class="offer">
											<?php echo $product_name." from ".$company_name; ?>
										</div>
										<?php
									}
									else
									{
										?>
										<div class="offer">
											<?php echo $product_name." from ".$company_name." ".$per1." Discount off"; ?>
										</div>
										<?php
									}
								}
								?>
								<?php
								if(($dealstarts <= $today && $dealends >= $today) && ($is_deal==1))
								{
								?>
									<div class="offer_highlight">
										<img src="components/com_dealcatalog/deal.png">
									</div>
								<?php
								}
								?>
								<?php
								if(($deal > $discount) && ($dealstarts <= $today && $dealends >= $today) && ($is_deal==1))
								{
									?>
									<div class="offer_price"> 
										Deal Price : <span class="deals"><?php echo $deal_price; ?> </span>
										(original Price :<span class="orginals"> <?php echo $price; ?> </span> )
									</div>
									<div class="offer">
										Deal Expires on <?php echo $dealenddate; ?>
									</div>
									<?php
								}
								else
								{
									if($deal==0 && $is_deal==1)
									{
										?>
										<div class="offer_price"> 
											Original Price : <span class="deals"><?php echo $price; ?> </span>
										</div>
										<div class="offer">
											Deal Expires on <?php echo $dealenddate; ?>
										</div>
										<?php
									}
									if($discount==0.00 && $is_deal==0)
									{
										?>
										<div class="offer_price"> 
											Original Price : <span class="deals"><?php echo $price; ?> </span>
										</div>
										<div class="offer">
											Product Expires on <?php echo $listenddate; ?>
										</div>
										<?php
									}
									if($discount!=0.00)
									{
										?>
										<div class="offer_price"> 
											Discount Price : <span class="deals"><?php echo $discount_price; ?> </span>
											(original Price :<span class="orginals"> <?php echo $price; ?> </span> )
										</div>
										<div class="offer">
											Discount Expires on <?php echo $listenddate; ?>
										</div>
										<?php
									}
								}
								?>
								<div class="details_more">
									<a href="index.php?option=com_dealcatalog&task=productview&productlisting=<?php echo $productlist; ?>&Itemid=<?php echo $_REQUEST['Itemid']; ?>">  Learn more </a>
								</div>
							</div>
						<?php
						}
						else
						{
						?>
							<div class="product_even">
								<div class="ids"> <?php echo ($k+1); ?> </div>
								<div class="checks_boxs">
									<input type="checkbox"  value="<?php echo $product_id.",".$vendor_id; ?>" name="compare[]" /> 
								</div>
								<div class="img_views">
									<a class="fancybox" href="<?php echo $image; ?>" title="<?php echo $product_name;?>">
										<img src="<?php echo $thumb_image; ?>" />
									</a>
								</div>
								<?php
								if(($deal > $discount) && ($dealstarts <= $today && $dealends >= $today) && ($is_deal==1))
								{
									?>
									<div class="offer">
										<?php echo $product_name." from ".$company_name." ".$per." Deal off"; ?>
									</div>									
									<?php
								}
								else
								{
									if($deal==0 && $discount==0.00)
									{
										?>
										<div class="offer">
											<?php echo $product_name." from ".$company_name; ?>
										</div>
										<?php
									}
									else
									{
										?>
										<div class="offer">
											<?php echo $product_name." from ".$company_name." ".$per1." Discount off"; ?>
										</div>
										<?php
									}
								}
								?>
								<?php
								if(($dealstarts <= $today && $dealends >= $today) && ($is_deal==1))
								{
								?>
									<div class="offer_highlight">
										<img src="components/com_dealcatalog/deal.png">
									</div>
								<?php
								}
								?>
								<?php
								if(($deal > $discount) && ($dealstarts <= $today && $dealends >= $today) && ($is_deal==1))
								{
									?>
									<div class="offer_price"> 
										Deal Price : <span class="deals"><?php echo $deal_price; ?> </span>
										(original Price :<span class="orginals"> <?php echo $price; ?> </span> )
									</div>
									<div class="offer">
										Deal Expires on <?php echo $dealenddate; ?>
									</div>
									<?php
								}
								else
								{
									if($deal==0 && $is_deal==1)
									{
										?>
										<div class="offer_price"> 
											Original Price : <span class="deals"><?php echo $price; ?> </span>
										</div>
										<div class="offer">
											Deal Expires on <?php echo $dealenddate; ?>
										</div>
										<?php
									}
									if($discount==0.00 && $is_deal==0)
									{
										?>
										<div class="offer_price"> 
											Original Price : <span class="deals"><?php echo $price; ?> </span>
										</div>
										<div class="offer">
											Product Expires on <?php echo $listenddate; ?>
										</div>
										<?php
									}
									if($discount!=0.00)
									{
										?>
										<div class="offer_price"> 
											Discount Price : <span class="deals"><?php echo $discount_price; ?> </span>
											(original Price :<span class="orginals"> <?php echo $price; ?> </span> )
										</div>
										<div class="offer">
											Discount Expires on <?php echo $listenddate; ?>
										</div>
										<?php
									}
								}
								?>
								<div class="details_more">
									<a href="index.php?option=com_dealcatalog&task=productview&productlisting=<?php echo $productlist; ?>&Itemid=<?php echo $_REQUEST['Itemid']; ?>">  Learn more </a>
								</div>
							</div>
						<?php
						}
						$k++;
					}
					?>
					<div class="pagi">
						<?php echo $pageNav->getPagesLinks(); ?>
					</div>
					<input type="hidden" value="categorysearchlist" name="task">
					<input type="hidden" value="com_dealcatalog" name="option">
					<input type="hidden" value="<?php echo $category; ?>" name="category">
				</form>
				<form name="compare_products" method="post" action="index.php?option=com_dealcatalog&task=compareproducts&Itemid=<?php echo $_REQUEST['Itemid']; ?>">
					<input type="hidden" value="" name="product_vendor" id="product_vendor">
				</form>
			</div>
			<div id="featured_offer">
				<div class="featured_head"> Featured Offers </div>
				<?php
				$no = count($featured);
				if($no > 0)
				{
					foreach($featured as $row)
					{
						$product_name = $row['product_name'];
						$productlist = $row['id'];
						$deal_price = $row['deal_price'];
						$pimage = $row['product_image1'];
						$pimage1 = $row['product_thumbimage1'];
						$mimage = $row['merchantproduct_image1'];
						$mimage1 = $row['merchantproduct_thumbimage1'];
						//Product Image
						if($mimage!='')
						{
							$image = substr($mimage, 3);
							$thumb_image = substr($mimage1, 3);
						}
						else
						{
							$image = substr($pimage, 3);
							$thumb_image = substr($pimage1, 3);
						}
						?>
						<div class="featured_body">
							<div class="featurerimg_views">
								<a class="fancybox" href="<?php echo $image; ?>" title="<?php echo $product_name;?>">
									<img src="<?php echo $thumb_image; ?>" />
								</a>
							</div>
							<div class="featurer_desc">
								<?php echo $product_name; ?> for Just <?php echo $deal_price; ?>. Offer only till stock exits. Hurry!
							</div>
							<div class="details_more">
								<a href="index.php?option=com_dealcatalog&task=productview&productlisting=<?php echo $productlist; ?>&Itemid=<?php echo $_REQUEST['Itemid']; ?>">  Learn more </a>
							</div>
						</div>
						<?php
					}
				}
				else
				{
					foreach($featuredall as $row)
					{
						$product_name = $row['product_name'];
						$productlist = $row['id'];
						$deal_price = $row['deal_price'];
						$pimage = $row['product_image1'];
						$pimage1 = $row['product_thumbimage1'];
						$mimage = $row['merchantproduct_image1'];
						$mimage1 = $row['merchantproduct_thumbimage1'];
						//Product Image
						if($mimage!='')
						{
							$image = substr($mimage, 3);
							$thumb_image = substr($mimage1, 3);
						}
						else
						{
							$image = substr($pimage, 3);
							$thumb_image = substr($pimage1, 3);
						}
						?>
						<div class="featured_body">
							<div class="featurerimg_views">
								<a class="fancybox" href="<?php echo $image; ?>" title="<?php echo $product_name;?>">
									<img src="<?php echo $thumb_image; ?>" />
								</a>
							</div>
							<div class="featurer_desc">
								<?php echo $product_name; ?> for Just <?php echo $deal_price; ?>. Offer only till stock exits. Hurry!
							</div>
							<div class="details_more">
								<a href="index.php?option=com_dealcatalog&task=productview&productlisting=<?php echo $productlist; ?>&Itemid=<?php echo $_REQUEST['Itemid']; ?>">  Learn more </a>
							</div>
						</div>
						<?php
					}
				}
				?>
			</div>
		</div>
		<?php		
	}
	
	function dealpromotion($promotion)
	{
		$db = &JFactory::getDBO();
		?>
		<script type="text/javascript" src="components/com_dealcatalog/js/jquery1.7.js"></script>
		<script type="text/javascript" src="components/com_dealcatalog/js/jquery.fancybox.js"></script>
		<link rel="stylesheet" type="text/css" href="components/com_dealcatalog/js/jquery.fancybox.css" media="screen" />
		<script type="text/javascript">
			$(document).ready(function() {
				$(".fancybox").fancybox();
			});
			function compare_product()
			{
				count = 0;
				str = '';
				for(x=0; x<document.dealform.elements["compare[]"].length; x++)
				{
					if(document.dealform.elements["compare[]"][x].checked==true)
					{
						str += document.dealform.elements["compare[]"][x].value + ',';
						count++;
					}
				}
				if(count==0)
				{
					alert("You must choose at least 2 products to compare");
					return false;
				}
				else if(count>2)
				{
					alert("You can choose a maximum of 2 products to compare");
					return false;
				}
				else if(count==1)
				{
					alert("You can choose another 1 product for compare");
					return false;
				}
				else 
				{
					
				}
				if(count==2)
				{
					var product_vendor = str.substring(0,str.length-1);
					document.getElementById('product_vendor').value=product_vendor;
					document.compare_products.submit();
				}
			}
		</script>		
		<?php
		global $mainframe;
		$limit= $mainframe->getUserStateFromRequest('global.list.limit','limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart= $mainframe->getUserStateFromRequest($option.'.limitstart', 'limitstart', 0, 'int');
		if($_REQUEST['limitstart']=='') {$limitstart=0;}
		$today_date = date('Y-m-d');
		//pagination
		$query = "select a.*,b.product_name,b.product_image1,b.product_thumbimage1,c.company_name from #__deal_productslisting_deals as a,#__deal_products as b,#__deal_merchants as c where a.promotion_type='$promotion' and a.dealstart_date <= '$today_date' and a.dealend_date >= '$today_date' and a.product_id=b.id and a.stock_in='1' and a.vendor_id=c.id order by b.category_id asc";
		$db->setQuery($query);
		$total = $db->loadResultArray();
		$total = count($total);						
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
		//Product Display
		$query = "select a.*,b.product_name,b.product_image1,b.product_thumbimage1,c.company_name from #__deal_productslisting_deals as a,#__deal_products as b,#__deal_merchants as c where a.promotion_type='$promotion' and a.dealstart_date <= '$today_date' and a.dealend_date >= '$today_date' and a.product_id=b.id and a.stock_in='1' and a.vendor_id=c.id order by b.category_id asc";
		$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
		$promotions = $db->loadObjectList();
		//Featured all
		$query = "select a.product_name,a.product_image1,a.product_thumbimage1,b.id,b.deal_price,b.merchantproduct_image1,b.merchantproduct_thumbimage1 from #__deal_products as a,#__deal_productslisting_deals as b where b.is_deal='1' and a.id=b.product_id and b.dealstart_date <= '$today_date' and b.dealend_date >= '$today_date' and b.stock_in='1' order by RAND() limit 2";
		$db->setQuery($query);
		$featuredall = $db->loadAssocList();
		?>
		<div id="products_display">
			<div id="search_product">
				<div class="cat_head"> Showing the Results for "<b> Promoted Products Deals </b>" </div>
				<div class="cat_title">
					<div class="product_count">Showing the <?php echo $pageNav->getResultsCounter(); ?> </div>
					<div class="cat_title_head" onClick="compare_product();"> Compare </div>
				</div>
				<form method="post" name="dealform" id="dealform" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
					<?php
					$k = $limitstart;
					for($i=0, $n=count($promotions); $i < $n ; $i++)
					{
						$row = &$promotions[$i];
						$productlist = $row->id;
						$product_id = $row->product_id;
						$vendor_id = $row->vendor_id;
						$product_name = $row->product_name;
						$price = $row->price;
						$company_name = $row->company_name;
						$discount_price = $row->discount_price;
						$listenddate = $row->listingend_date;
						$pimage = $row->product_image1;
						$pimage1 = $row->product_thumbimage1;
						$mimage = $row->merchantproduct_image1;
						$mimage1 = $row->merchantproduct_thumbimage1;
						$is_deal = $row->is_deal;
						$deal_price = $row->deal_price;
						$dealstartdate = $row->dealstart_date;
						$dealenddate = $row->dealend_date;
						//Product Image
						if($mimage!='')
						{
							$image = substr($mimage, 3);
							$thumb_image = substr($mimage1, 3);
						}
						else
						{
							$image = substr($pimage, 3);
							$thumb_image = substr($pimage1, 3);
						}
						//Deal percentage
						if($deal_price!=0.00)
						{
							$per = $price - $deal_price;
							$per = ($per / $price) * 100;
							$per = round($per,2);
							$per = $per."%";
						}
						if($i%2==0)
						{
							?>
							<div class="product_odd">
								<div class="ids"> <?php echo ($k+1); ?> </div>
								<div class="checks_boxs">
									<input type="checkbox"  value="<?php echo $product_id.",".$vendor_id; ?>" name="compare[]" /> 
								</div>
								<div class="img_views">
									<a class="fancybox" href="<?php echo $image; ?>" title="<?php echo $product_name;?>">
										<img src="<?php echo $thumb_image; ?>" />
									</a>
								</div>
								<?php
								if($per!='0%')
								{
									?>
									<div class="offer">
										<?php echo $product_name." from ".$company_name." ".$per." Deal off"; ?>
									</div>
									<?php
								}
								else
								{
									?>
									<div class="offer">
										<?php echo $product_name." from ".$company_name; ?>
									</div>
									<?php
								}
								?>
								<div class="offer_highlight">
									<img src="components/com_dealcatalog/deal.png">
								</div>
								<?php
								if($per!='0%')
								{
									?>
									<div class="offer_price"> 
										Deal Price : <span class="deals"><?php echo $deal_price; ?> </span>
										(original Price :<span class="orginals"> <?php echo $price; ?> </span> )
									</div>
									<div class="offer">
										Deal Expires on <?php echo $dealenddate; ?>
									</div>
									<?php
								}
								else
								{
									?>
									<div class="offer_price"> 
										original Price : <span class="deals"><?php echo $price; ?> </span>										
									</div>
									<div class="offer">
										Deal Expires on <?php echo $dealenddate; ?>
									</div>
									<?php
								}
								?>
								<div class="details_more">
									<a href="index.php?option=com_dealcatalog&task=productview&productlisting=<?php echo $productlist; ?>&Itemid=<?php echo $_REQUEST['Itemid']; ?>">  Learn more </a>
								</div>
							</div>
							<?php
						}
						else
						{
							?>
							<div class="product_even">
								<div class="ids"> <?php echo ($k+1); ?> </div>
								<div class="checks_boxs">
									<input type="checkbox"  value="<?php echo $product_id.",".$vendor_id; ?>" name="compare[]" /> 
								</div>
								<div class="img_views">
									<a class="fancybox" href="<?php echo $image; ?>" title="<?php echo $product_name;?>">
										<img src="<?php echo $thumb_image; ?>" />
									</a>
								</div>
								<?php
								if($per!='0%')
								{
									?>
									<div class="offer">
										<?php echo $product_name." from ".$company_name." ".$per." Deal off"; ?>
									</div>
									<?php
								}
								else
								{
									?>
									<div class="offer">
										<?php echo $product_name." from ".$company_name; ?>
									</div>
									<?php
								}
								?>
								<div class="offer_highlight">
									<img src="components/com_dealcatalog/deal.png">
								</div>
								<?php
								if($per!='0%')
								{
									?>
									<div class="offer_price"> 
										Deal Price : <span class="deals"><?php echo $deal_price; ?> </span>
										(original Price :<span class="orginals"> <?php echo $price; ?> </span> )
									</div>
									<div class="offer">
										Deal Expires on <?php echo $dealenddate; ?>
									</div>
									<?php
								}
								else
								{
									?>
									<div class="offer_price"> 
										original Price : <span class="deals"><?php echo $price; ?> </span>										
									</div>
									<div class="offer">
										Deal Expires on <?php echo $dealenddate; ?>
									</div>
									<?php
								}
								?>
								<div class="details_more">
									<a href="index.php?option=com_dealcatalog&task=productview&productlisting=<?php echo $productlist; ?>&Itemid=<?php echo $_REQUEST['Itemid']; ?>">  Learn more </a>
								</div>
							</div>
							<?php
						}
						$k++;
					}
					?>
					<div class="pagi">
						<?php echo $pageNav->getPagesLinks(); ?>
					</div>
					<input type="hidden" name="task" value="dealpromotion" />
					<input type="hidden" name="option" value="com_dealcatalog" />
					<input type="hidden" name="promotion" value="<?php echo $promotion; ?>" />	
				</form>
				<form name="compare_products" method="post" action="index.php?option=com_dealcatalog&task=compareproducts&Itemid=<?php echo $_REQUEST['Itemid']; ?>">
					<input type="hidden" value="" name="product_vendor" id="product_vendor">
				</form>
			</div>
			<div id="featured_offer">
				<div class="featured_head"> Featured Offers </div>
				<?php
					foreach($featuredall as $row)
					{
						$product_name = $row['product_name'];
						$productlist = $row['id'];
						$deal_price = $row['deal_price'];
						$pimage = $row['product_image1'];
						$pimage1 = $row['product_thumbimage1'];
						$mimage = $row['merchantproduct_image1'];
						$mimage1 = $row['merchantproduct_thumbimage1'];
						//Product Image
						if($mimage!='')
						{
							$image = substr($mimage, 3);
							$thumb_image = substr($mimage1, 3);
						}
						else
						{
							$image = substr($pimage, 3);
							$thumb_image = substr($pimage1, 3);
						}
						?>
						<div class="featured_body">
							<div class="featurerimg_views">
								<a class="fancybox" href="<?php echo $image; ?>" title="<?php echo $product_name;?>">
									<img src="<?php echo $thumb_image; ?>" />
								</a>
							</div>
							<div class="featurer_desc">
								<?php echo $product_name; ?> for Just <?php echo $deal_price; ?>. Offer only till stock exits. Hurry!
							</div>
							<div class="details_more">
								<a href="index.php?option=com_dealcatalog&task=productview&productlisting=<?php echo $productlist; ?>&Itemid=<?php echo $_REQUEST['Itemid']; ?>">  Learn more </a>
							</div>
						</div>
						<?php
					}
				?>
			</div>
		</div>
		<?php
	}
	
	function productslisting()
	{
		$db = &JFactory::getDBO();
		?>
		<script type="text/javascript" src="components/com_dealcatalog/js/jquery1.7.js"></script>
		<script type="text/javascript" src="components/com_dealcatalog/js/jquery.fancybox.js"></script>
		<link rel="stylesheet" type="text/css" href="components/com_dealcatalog/js/jquery.fancybox.css" media="screen" />
		<script type="text/javascript">
			$(document).ready(function() {
				$(".fancybox").fancybox();
			});
			function compare_product()
			{
				count = 0;
				str = '';
				for(x=0; x<document.dealform.elements["compare[]"].length; x++)
				{
					if(document.dealform.elements["compare[]"][x].checked==true)
					{
						str += document.dealform.elements["compare[]"][x].value + ',';
						count++;
					}
				}
				if(count==0)
				{
					alert("You must choose at least 2 products to compare");
					return false;
				}
				else if(count>2)
				{
					alert("You can choose a maximum of 2 products to compare");
					return false;
				}
				else if(count==1)
				{
					alert("You can choose another 1 product for compare");
					return false;
				}
				else 
				{
					
				}
				if(count==2)
				{
					var product_vendor = str.substring(0,str.length-1);
					document.getElementById('product_vendor').value=product_vendor;
					document.compare_products.submit();
				}
			}
		</script>	
		<?php
		global $mainframe;
		$limit= $mainframe->getUserStateFromRequest('global.list.limit','limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart= $mainframe->getUserStateFromRequest($option.'.limitstart', 'limitstart', 0, 'int');
		if($_REQUEST['limitstart']=='') {$limitstart=0;}
		$today_date = date('Y-m-d');		
		//Pagination 
		$query = "select a.product_name,a.product_image1,a.product_thumbimage1,b.id,b.product_id,b.vendor_id,b.stock_in,b.price,b.discount_price,b.listingstart_date,b.listingend_date,b.merchantproduct_image1,b.merchantproduct_thumbimage1,b.is_deal,b.deal_price,b.dealstart_date,b.dealend_date,c.company_name from #__deal_products as a,#__deal_productslisting_deals as b,#__deal_merchants as c where a.id=b.product_id and b.listingstart_date <= '$today_date' and b.listingend_date >= '$today_date' and b.stock_in='1' and b.vendor_id=c.id order by a.category_id asc";
		$db->setQuery($query);
		$total = $db->loadResultArray();
		$total = count($total);
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
		//Products display
		$query = "select a.product_name,a.product_image1,a.product_thumbimage1,b.id,b.product_id,b.vendor_id,b.stock_in,b.price,b.discount_price,b.listingstart_date,b.listingend_date,b.merchantproduct_image1,b.merchantproduct_thumbimage1,b.is_deal,b.deal_price,b.dealstart_date,b.dealend_date,c.company_name from #__deal_products as a,#__deal_productslisting_deals as b,#__deal_merchants as c where a.id=b.product_id and b.listingstart_date <= '$today_date' and b.listingend_date >= '$today_date' and b.stock_in='1' and b.vendor_id=c.id order by a.category_id asc";
		$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
		$products = $db->loadObjectList();
		//Featured all
		$query = "select a.product_name,a.product_image1,a.product_thumbimage1,b.id,b.deal_price,b.merchantproduct_image1,b.merchantproduct_thumbimage1 from #__deal_products as a,#__deal_productslisting_deals as b where b.is_deal='1' and a.id=b.product_id and b.dealstart_date <= '$today_date' and b.dealend_date >= '$today_date' and b.stock_in='1' order by RAND() limit 2";
		$db->setQuery($query);
		$featuredall = $db->loadAssocList();
		?>
		<div id="product_display">
			<div id="search_product">
				<div class="cat_head"> Showing the Results for "<b> Products Listings </b> and <b> Deals </b>" </div>
				<div class="cat_title">
					<div class="product_count">Showing the <?php echo $pageNav->getResultsCounter(); ?> </div>
					<div class="cat_title_head" onClick="compare_product();"> Compare </div>
				</div>
				<form method="post" name="dealform" id="dealform" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
					<?php
					$k = $limitstart;
					for($i=0, $n=count($products); $i < $n ; $i++)
					{
						$row = &$products[$i];
						$productlist = $row->id;
						$product_id = $row->product_id;
						$vendor_id = $row->vendor_id;
						$product_name = $row->product_name;
						$price = $row->price;
						$company_name = $row->company_name;
						$discount_price = $row->discount_price;
						$listenddate = $row->listingend_date;
						$pimage = $row->product_image1;
						$pimage1 = $row->product_thumbimage1;
						$mimage = $row->merchantproduct_image1;
						$mimage1 = $row->merchantproduct_thumbimage1;
						$is_deal = $row->is_deal;
						$deal_price = $row->deal_price;
						$dealstartdate = $row->dealstart_date;
						$dealenddate = $row->dealend_date;
						//Product Image
						if($mimage!='')
						{
							$image = substr($mimage, 3);
							$thumb_image = substr($mimage1, 3);
						}
						else
						{
							$image = substr($pimage, 3);
							$thumb_image = substr($pimage1, 3);
						}
						//Price difference
						if($deal_price!=0.00)
						{
							$deal = $price - $deal_price;
						}
						else
						{
							$deal = 0.00;
						}
						if($discount_price!=0.00)
						{
							$discount = $price - $discount_price;
						}
						else
						{
							$discount = 0.00;
						}
						//Deal and Discount percentage
						if($deal_price!=0.00)
						{
							$per = $price - $deal_price;
							$per = ($per / $price) * 100;
							$per = round($per,2);
							$per = $per."%";
						}
						else
						{
							$per = "0%";
						}
						if($discount_price!=0.00)
						{
							$per1 = $price - $discount_price;
							$per1 = ($per1 / $price) * 100;
							$per1 = round($per1,2);
							$per1 = $per1."%";
						}
						else
						{
							$per1 = "0%";
						}
						//date comparison
						$today = strtotime($today_date);
						$dealstarts = strtotime($dealstartdate);
						$dealends = strtotime($dealenddate);
						if($i%2==0)
						{
						?>
							<div class="product_odd">
								<div class="ids"> <?php echo ($k+1); ?> </div>
								<div class="checks_boxs">
									<input type="checkbox"  value="<?php echo $product_id.",".$vendor_id; ?>" name="compare[]" /> 
								</div>
								<div class="img_views">
									<a class="fancybox" href="<?php echo $image; ?>" title="<?php echo $product_name;?>">
										<img src="<?php echo $thumb_image; ?>" />
									</a>
								</div>
								<?php
								if(($deal > $discount) && ($dealstarts <= $today && $dealends >= $today) && ($is_deal==1))
								{
									?>
									<div class="offer">
										<?php echo $product_name." from ".$company_name." ".$per." Deal off"; ?>
									</div>									
									<?php
								}
								else
								{
									if($deal==0 && $discount==0.00)
									{
										?>
										<div class="offer">
											<?php echo $product_name." from ".$company_name; ?>
										</div>
										<?php
									}
									else
									{
										?>
										<div class="offer">
											<?php echo $product_name." from ".$company_name." ".$per1." Discount off"; ?>
										</div>
										<?php
									}
								}
								?>
								<?php
								if(($dealstarts <= $today && $dealends >= $today) && ($is_deal==1))
								{
								?>
									<div class="offer_highlight">
										<img src="components/com_dealcatalog/deal.png">
									</div>
								<?php
								}
								?>
								<?php
								if(($deal > $discount) && ($dealstarts <= $today && $dealends >= $today) && ($is_deal==1))
								{
									?>
									<div class="offer_price"> 
										Deal Price : <span class="deals"><?php echo $deal_price; ?> </span>
										(original Price :<span class="orginals"> <?php echo $price; ?> </span> )
									</div>
									<div class="offer">
										Deal Expires on <?php echo $dealenddate; ?>
									</div>
									<?php
								}
								else
								{
									if($deal==0 && $is_deal==1)
									{
										?>
										<div class="offer_price"> 
											Original Price : <span class="deals"><?php echo $price; ?> </span>
										</div>
										<div class="offer">
											Deal Expires on <?php echo $dealenddate; ?>
										</div>
										<?php
									}
									if($discount==0.00 && $is_deal==0)
									{
										?>
										<div class="offer_price"> 
											Original Price : <span class="deals"><?php echo $price; ?> </span>
										</div>
										<div class="offer">
											Product Expires on <?php echo $listenddate; ?>
										</div>
										<?php
									}
									if($discount!=0.00)
									{
										?>
										<div class="offer_price"> 
											Discount Price : <span class="deals"><?php echo $discount_price; ?> </span>
											(original Price :<span class="orginals"> <?php echo $price; ?> </span> )
										</div>
										<div class="offer">
											Discount Expires on <?php echo $listenddate; ?>
										</div>
										<?php
									}
								}
								?>
								<div class="details_more">
									<a href="index.php?option=com_dealcatalog&task=productview&productlisting=<?php echo $productlist; ?>&Itemid=<?php echo $_REQUEST['Itemid']; ?>">  Learn more </a>
								</div>
							</div>
						<?php
						}
						else
						{
						?>
							<div class="product_even">
								<div class="ids"> <?php echo ($k+1); ?> </div>
								<div class="checks_boxs">
									<input type="checkbox"  value="<?php echo $product_id.",".$vendor_id; ?>" name="compare[]" /> 
								</div>
								<div class="img_views">
									<a class="fancybox" href="<?php echo $image; ?>" title="<?php echo $product_name;?>">
										<img src="<?php echo $thumb_image; ?>" />
									</a>
								</div>
								<?php
								if(($deal > $discount) && ($dealstarts <= $today && $dealends >= $today) && ($is_deal==1))
								{
									?>
									<div class="offer">
										<?php echo $product_name." from ".$company_name." ".$per." Deal off"; ?>
									</div>									
									<?php
								}
								else
								{
									if($deal==0 && $discount==0.00)
									{
										?>
										<div class="offer">
											<?php echo $product_name." from ".$company_name; ?>
										</div>
										<?php
									}
									else
									{
										?>
										<div class="offer">
											<?php echo $product_name." from ".$company_name." ".$per1." Discount off"; ?>
										</div>
										<?php
									}
								}
								?>
								<?php
								if(($dealstarts <= $today && $dealends >= $today) && ($is_deal==1))
								{
								?>
									<div class="offer_highlight">
										<img src="components/com_dealcatalog/deal.png">
									</div>
								<?php
								}
								?>
								<?php
								if(($deal > $discount) && ($dealstarts <= $today && $dealends >= $today) && ($is_deal==1))
								{
									?>
									<div class="offer_price"> 
										Deal Price : <span class="deals"><?php echo $deal_price; ?> </span>
										(original Price :<span class="orginals"> <?php echo $price; ?> </span> )
									</div>
									<div class="offer">
										Deal Expires on <?php echo $dealenddate; ?>
									</div>
									<?php
								}
								else
								{
									if($deal==0 && $is_deal==1)
									{
										?>
										<div class="offer_price"> 
											Original Price : <span class="deals"><?php echo $price; ?> </span>
										</div>
										<div class="offer">
											Deal Expires on <?php echo $dealenddate; ?>
										</div>
										<?php
									}
									if($discount==0.00 && $is_deal==0)
									{
										?>
										<div class="offer_price"> 
											Original Price : <span class="deals"><?php echo $price; ?> </span>
										</div>
										<div class="offer">
											Product Expires on <?php echo $listenddate; ?>
										</div>
										<?php
									}
									if($discount!=0.00)
									{
										?>
										<div class="offer_price"> 
											Discount Price : <span class="deals"><?php echo $discount_price; ?> </span>
											(original Price :<span class="orginals"> <?php echo $price; ?> </span> )
										</div>
										<div class="offer">
											Discount Expires on <?php echo $listenddate; ?>
										</div>
										<?php
									}
								}
								?>
								<div class="details_more">
									<a href="index.php?option=com_dealcatalog&task=productview&productlisting=<?php echo $productlist; ?>&Itemid=<?php echo $_REQUEST['Itemid']; ?>">  Learn more </a>
								</div>
							</div>
						<?php
						}
						$k++;
					}
					?>
					<div class="pagi">
						<?php echo $pageNav->getPagesLinks(); ?>
					</div>
					<input type="hidden" value="productslisting" name="task">
					<input type="hidden" value="com_dealcatalog" name="option">					
				</form>
				<form name="compare_products" method="post" action="index.php?option=com_dealcatalog&task=compareproducts&Itemid=<?php echo $_REQUEST['Itemid']; ?>">
					<input type="hidden" value="" name="product_vendor" id="product_vendor">
				</form>
			</div>
			<div id="featured_offer">
				<div class="featured_head"> Featured Offers </div>
				<?php
					foreach($featuredall as $row)
					{
						$product_name = $row['product_name'];
						$productlist = $row['id'];
						$deal_price = $row['deal_price'];
						$pimage = $row['product_image1'];
						$pimage1 = $row['product_thumbimage1'];
						$mimage = $row['merchantproduct_image1'];
						$mimage1 = $row['merchantproduct_thumbimage1'];
						//Product Image
						if($mimage!='')
						{
							$image = substr($mimage, 3);
							$thumb_image = substr($mimage1, 3);
						}
						else
						{
							$image = substr($pimage, 3);
							$thumb_image = substr($pimage1, 3);
						}
						?>
						<div class="featured_body">
							<div class="featurerimg_views">
								<a class="fancybox" href="<?php echo $image; ?>" title="<?php echo $product_name;?>">
									<img src="<?php echo $thumb_image; ?>" />
								</a>
							</div>
							<div class="featurer_desc">
								<?php echo $product_name; ?> for Just <?php echo $deal_price; ?>. Offer only till stock exits. Hurry!
							</div>
							<div class="details_more">
								<a href="index.php?option=com_dealcatalog&task=productview&productlisting=<?php echo $productlist; ?>&Itemid=<?php echo $_REQUEST['Itemid']; ?>">  Learn more </a>
							</div>
						</div>
						<?php
					}
				?>
			</div>
		</div>
		<?php
	}
	
	function categoryproduct($category_id,$product_name)
	{
		$_SESSION['cat_id'] = $cat_id = $category_id;
		$_SESSION['p_name'] = $p_name = $product_name;
		$db = &JFactory::getDBO();
	?>
		<script type="text/javascript" src="components/com_dealcatalog/js/jquery1.7.js"></script>
		<script type="text/javascript" src="components/com_dealcatalog/js/jquery.fancybox.js"></script>
		<link rel="stylesheet" type="text/css" href="components/com_dealcatalog/js/jquery.fancybox.css" media="screen" />
		<script type="text/javascript">
			$(document).ready(function() {
				$(".fancybox").fancybox();
			});
			function compare_product()
			{	
				count = 0;
				str = '';
				for(x=0; x<document.dealform.elements["compare[]"].length; x++)
				{
					if(document.dealform.elements["compare[]"][x].checked==true)
					{
						str += document.dealform.elements["compare[]"][x].value + ',';
						count++;
					}
				}
				if(count==0)
				{
					alert("You must choose at least 2 products to compare");
					return false;
				}
				else if(count>2)
				{
					alert("You can choose a maximum of 2 products to compare");
					return false;
				}
				else if(count==1)
				{
					alert("You can choose another 1 product for compare");
					return false;
				}
				else 
				{
					
				}
				if(count==2)
				{
					var product_vendor = str.substring(0,str.length-1);
					document.getElementById('product_vendor').value=product_vendor;
					document.compare_products.submit();
				}
			}
		</script>
		<?php
		global $mainframe;
		$limit= $mainframe->getUserStateFromRequest('global.list.limit','limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart= $mainframe->getUserStateFromRequest($option.'.limitstart', 'limitstart', 0, 'int');
		if($_REQUEST['limitstart']=='') {$limitstart=0;}
		$today_date = date('Y-m-d');		
		//Pagination
		$query = "select a.product_name,a.product_image1,a.product_thumbimage1,b.*,c.company_name from #__deal_products as a,#__deal_productslisting_deals as b,#__deal_merchants as c where a.category_id='$cat_id' and a.product_name like '%".$p_name."%' and a.id=b.product_id and b.stock_in='1' and b.listingstart_date <= '$today_date' and b.listingend_date >= '$today_date' and b.vendor_id=c.id";
		$db->setQuery($query);
		$total = $db->loadResultArray();
		$total = count($total);
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );
		//Products display
		$query = "select a.product_name,a.product_image1,a.product_thumbimage1,b.*,c.company_name from #__deal_products as a,#__deal_productslisting_deals as b,#__deal_merchants as c where a.category_id='$cat_id' and a.product_name like '%".$p_name."%' and a.id=b.product_id and b.stock_in='1' and b.listingstart_date <= '$today_date' and b.listingend_date >= '$today_date' and b.vendor_id=c.id";
		$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
		$products = $db->loadObjectList();
		//Category name
		$query = "select category_name from #__deal_productcategories where id='$cat_id'";
		$db->setQuery($query);
		$categories = $db->loadRow();
		$categoryname = $categories[0];
		//Featured product
		$query = "select a.product_name,a.product_image1,a.product_thumbimage1,b.id,b.deal_price,b.merchantproduct_image1,b.merchantproduct_thumbimage1 from #__deal_products as a,#__deal_productslisting_deals as b where a.category_id='$cat_id' and b.is_deal='1' and a.id=b.product_id and b.dealstart_date <= '$today_date' and b.dealend_date >= '$today_date' and b.stock_in='1' order by RAND() limit 2";
		$db->setQuery($query);
		$featured = $db->loadAssocList();
		//Featured all
		$query = "select a.product_name,a.product_image1,a.product_thumbimage1,b.id,b.deal_price,b.merchantproduct_image1,b.merchantproduct_thumbimage1 from #__deal_products as a,#__deal_productslisting_deals as b where b.is_deal='1' and a.id=b.product_id and b.dealstart_date <= '$today_date' and b.dealend_date >= '$today_date' and b.stock_in='1' order by RAND() limit 2";
		$db->setQuery($query);
		$featuredall = $db->loadAssocList();
		?>
		<div id="products_display">
			<div id="search_product">
				<div class="cat_head"> Showing the Results for "<b> <?php echo $categoryname; ?> </b>" </div>
				<div class="cat_title">
					<div class="product_count">Showing the <?php echo $pageNav->getResultsCounter(); ?> </div>
					<div class="cat_title_head" onClick="compare_product();"> Compare </div>
				</div>
				<form method="post" name="dealform" id="dealform" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
					<?php
					$k = $limitstart;
					for($i=0, $n=count($products); $i < $n ; $i++)
					{
						$row = &$products[$i];
						$productlist = $row->id;
						$product_id = $row->product_id;
						$vendor_id = $row->vendor_id;
						$product_name = $row->product_name;
						$price = $row->price;
						$company_name = $row->company_name;
						$discount_price = $row->discount_price;
						$listenddate = $row->listingend_date;
						$pimage = $row->product_image1;
						$pimage1 = $row->product_thumbimage1;
						$mimage = $row->merchantproduct_image1;
						$mimage1 = $row->merchantproduct_thumbimage1;
						$is_deal = $row->is_deal;
						$deal_price = $row->deal_price;
						$dealstartdate = $row->dealstart_date;
						$dealenddate = $row->dealend_date;
						//Product Image
						if($mimage!='')
						{
							$image = substr($mimage, 3);
							$thumb_image = substr($mimage1, 3);
						}
						else
						{
							$image = substr($pimage, 3);
							$thumb_image = substr($pimage1, 3);
						}
						//Price difference
						if($deal_price!=0.00)
						{
							$deal = $price - $deal_price;
						}
						else
						{
							$deal = 0.00;
						}
						if($discount_price!=0.00)
						{
							$discount = $price - $discount_price;
						}
						else
						{
							$discount = 0.00;
						}
						//Deal and Discount percentage
						if($deal_price!=0.00)
						{
							$per = $price - $deal_price;
							$per = ($per / $price) * 100;
							$per = round($per,2);
							$per = $per."%";
						}
						else
						{
							$per = "0%";
						}
						if($discount_price!=0.00)
						{
							$per1 = $price - $discount_price;
							$per1 = ($per1 / $price) * 100;
							$per1 = round($per1,2);
							$per1 = $per1."%";
						}
						else
						{
							$per1 = "0%";
						}
						//date comparison
						$today = strtotime($today_date);
						$dealstarts = strtotime($dealstartdate);
						$dealends = strtotime($dealenddate);
						if($i%2==0)
						{
						?>
							<div class="product_odd">
								<div class="ids"> <?php echo ($k+1); ?> </div>
								<div class="checks_boxs">
									<input type="checkbox"  value="<?php echo $product_id.",".$vendor_id; ?>" name="compare[]" /> 
								</div>
								<div class="img_views">
									<a class="fancybox" href="<?php echo $image; ?>" title="<?php echo $product_name;?>">
										<img src="<?php echo $thumb_image; ?>" />
									</a>
								</div>
								<?php
								if(($deal > $discount) && ($dealstarts <= $today && $dealends >= $today) && ($is_deal==1))
								{
									?>
									<div class="offer">
										<?php echo $product_name." from ".$company_name." ".$per." Deal off"; ?>
									</div>									
									<?php
								}
								else
								{
									if($deal==0 && $discount==0.00)
									{
										?>
										<div class="offer">
											<?php echo $product_name." from ".$company_name; ?>
										</div>
										<?php
									}
									else
									{
										?>
										<div class="offer">
											<?php echo $product_name." from ".$company_name." ".$per1." Discount off"; ?>
										</div>
										<?php
									}
								}
								?>
								<?php
								if(($dealstarts <= $today && $dealends >= $today) && ($is_deal==1))
								{
								?>
									<div class="offer_highlight">
										<img src="components/com_dealcatalog/deal.png">
									</div>
								<?php
								}
								?>
								<?php
								if(($deal > $discount) && ($dealstarts <= $today && $dealends >= $today) && ($is_deal==1))
								{
									?>
									<div class="offer_price"> 
										Deal Price : <span class="deals"><?php echo $deal_price; ?> </span>
										(original Price :<span class="orginals"> <?php echo $price; ?> </span> )
									</div>
									<div class="offer">
										Deal Expires on <?php echo $dealenddate; ?>
									</div>
									<?php
								}
								else
								{
									if($deal==0 && $is_deal==1)
									{
										?>
										<div class="offer_price"> 
											Original Price : <span class="deals"><?php echo $price; ?> </span>
										</div>
										<div class="offer">
											Deal Expires on <?php echo $dealenddate; ?>
										</div>
										<?php
									}
									if($discount==0.00 && $is_deal==0)
									{
										?>
										<div class="offer_price"> 
											Original Price : <span class="deals"><?php echo $price; ?> </span>
										</div>
										<div class="offer">
											Product Expires on <?php echo $listenddate; ?>
										</div>
										<?php
									}
									if($discount!=0.00)
									{
										?>
										<div class="offer_price"> 
											Discount Price : <span class="deals"><?php echo $discount_price; ?> </span>
											(original Price :<span class="orginals"> <?php echo $price; ?> </span> )
										</div>
										<div class="offer">
											Discount Expires on <?php echo $listenddate; ?>
										</div>
										<?php
									}
								}
								?>
								<div class="details_more">
									<a href="index.php?option=com_dealcatalog&task=productview&productlisting=<?php echo $productlist; ?>&Itemid=<?php echo $_REQUEST['Itemid']; ?>">  Learn more </a>
								</div>
							</div>
						<?php
						}
						else
						{
						?>
							<div class="product_even">
								<div class="ids"> <?php echo ($k+1); ?> </div>
								<div class="checks_boxs">
									<input type="checkbox"  value="<?php echo $product_id.",".$vendor_id; ?>" name="compare[]" /> 
								</div>
								<div class="img_views">
									<a class="fancybox" href="<?php echo $image; ?>" title="<?php echo $product_name;?>">
										<img src="<?php echo $thumb_image; ?>" />
									</a>
								</div>
								<?php
								if(($deal > $discount) && ($dealstarts <= $today && $dealends >= $today) && ($is_deal==1))
								{
									?>
									<div class="offer">
										<?php echo $product_name." from ".$company_name." ".$per." Deal off"; ?>
									</div>									
									<?php
								}
								else
								{
									if($deal==0 && $discount==0.00)
									{
										?>
										<div class="offer">
											<?php echo $product_name." from ".$company_name; ?>
										</div>
										<?php
									}
									else
									{
										?>
										<div class="offer">
											<?php echo $product_name." from ".$company_name." ".$per1." Discount off"; ?>
										</div>
										<?php
									}
								}
								?>
								<?php
								if(($dealstarts <= $today && $dealends >= $today) && ($is_deal==1))
								{
								?>
									<div class="offer_highlight">
										<img src="components/com_dealcatalog/deal.png">
									</div>
								<?php
								}
								?>
								<?php
								if(($deal > $discount) && ($dealstarts <= $today && $dealends >= $today) && ($is_deal==1))
								{
									?>
									<div class="offer_price"> 
										Deal Price : <span class="deals"><?php echo $deal_price; ?> </span>
										(original Price :<span class="orginals"> <?php echo $price; ?> </span> )
									</div>
									<div class="offer">
										Deal Expires on <?php echo $dealenddate; ?>
									</div>
									<?php
								}
								else
								{
									if($deal==0 && $is_deal==1)
									{
										?>
										<div class="offer_price"> 
											Original Price : <span class="deals"><?php echo $price; ?> </span>
										</div>
										<div class="offer">
											Deal Expires on <?php echo $dealenddate; ?>
										</div>
										<?php
									}
									if($discount==0.00 && $is_deal==0)
									{
										?>
										<div class="offer_price"> 
											Original Price : <span class="deals"><?php echo $price; ?> </span>
										</div>
										<div class="offer">
											Product Expires on <?php echo $listenddate; ?>
										</div>
										<?php
									}
									if($discount!=0.00)
									{
										?>
										<div class="offer_price"> 
											Discount Price : <span class="deals"><?php echo $discount_price; ?> </span>
											(original Price :<span class="orginals"> <?php echo $price; ?> </span> )
										</div>
										<div class="offer">
											Discount Expires on <?php echo $listenddate; ?>
										</div>
										<?php
									}
								}
								?>
								<div class="details_more">
									<a href="index.php?option=com_dealcatalog&task=productview&productlisting=<?php echo $productlist; ?>&Itemid=<?php echo $_REQUEST['Itemid']; ?>">  Learn more </a>
								</div>
							</div>
						<?php
						}
						$k++;
					}
					?>
					<div class="pagi">
						<?php echo $pageNav->getPagesLinks(); ?>
					</div>
					<input type="hidden" value="categoryproduct" name="task">
					<input type="hidden" value="com_dealcatalog" name="option">
					<input type="hidden" value="<?php echo $cat_id; ?>" name="category">
					<input type="hidden" value="<?php echo $p_name; ?>" name="product_name">
				</form>
				<form name="compare_products" method="post" action="index.php?option=com_dealcatalog&task=compareproducts&Itemid=<?php echo $_REQUEST['Itemid']; ?>">
					<input type="hidden" value="" name="product_vendor" id="product_vendor">
				</form>
			</div>
			<div id="featured_offer">
				<div class="featured_head"> Featured Offers </div>
				<?php
				$no = count($featured);
				if($no > 0)
				{
					foreach($featured as $row)
					{
						$product_name = $row['product_name'];
						$productlist = $row['id'];
						$deal_price = $row['deal_price'];
						$pimage = $row['product_image1'];
						$pimage1 = $row['product_thumbimage1'];
						$mimage = $row['merchantproduct_image1'];
						$mimage1 = $row['merchantproduct_thumbimage1'];
						//Product Image
						if($mimage!='')
						{
							$image = substr($mimage, 3);
							$thumb_image = substr($mimage1, 3);
						}
						else
						{
							$image = substr($pimage, 3);
							$thumb_image = substr($pimage1, 3);
						}
						?>
						<div class="featured_body">
							<div class="featurerimg_views">
								<a class="fancybox" href="<?php echo $image; ?>" title="<?php echo $product_name;?>">
									<img src="<?php echo $thumb_image; ?>" />
								</a>
							</div>
							<div class="featurer_desc">
								<?php echo $product_name; ?> for Just <?php echo $deal_price; ?>. Offer only till stock exits. Hurry!
							</div>
							<div class="details_more">
								<a href="index.php?option=com_dealcatalog&task=productview&productlisting=<?php echo $productlist; ?>&Itemid=<?php echo $_REQUEST['Itemid']; ?>">  Learn more </a>
							</div>
						</div>
						<?php
					}
				}
				else
				{
					foreach($featuredall as $row)
					{
						$product_name = $row['product_name'];
						$productlist = $row['id'];
						$deal_price = $row['deal_price'];
						$pimage = $row['product_image1'];
						$pimage1 = $row['product_thumbimage1'];
						$mimage = $row['merchantproduct_image1'];
						$mimage1 = $row['merchantproduct_thumbimage1'];
						//Product Image
						if($mimage!='')
						{
							$image = substr($mimage, 3);
							$thumb_image = substr($mimage1, 3);
						}
						else
						{
							$image = substr($pimage, 3);
							$thumb_image = substr($pimage1, 3);
						}
						?>
						<div class="featured_body">
							<div class="featurerimg_views">
								<a class="fancybox" href="<?php echo $image; ?>" title="<?php echo $product_name;?>">
									<img src="<?php echo $thumb_image; ?>" />
								</a>
							</div>
							<div class="featurer_desc">
								<?php echo $product_name; ?> for Just <?php echo $deal_price; ?>. Offer only till stock exits. Hurry!
							</div>
							<div class="details_more">
								<a href="index.php?option=com_dealcatalog&task=productview&productlisting=<?php echo $productlist; ?>&Itemid=<?php echo $_REQUEST['Itemid']; ?>">  Learn more </a>
							</div>
						</div>
						<?php
					}
				}
				?>
			</div>
		</div>
		<?php
	}
	
	function compareproducts($p1,$v1,$p2,$v2)
	{
		$db = &JFactory::getDBO();
		$p_id1 = $p1;
		$v_id1 = $v1;
		$p_id2 = $p2;
		$v_id2 = $v2;
		$today_date = date('Y-m-d');		
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
		//Getting two products details
		$query = "select a.*,b.product_name,b.product_image1,b.product_thumbimage1,b.product_desc,c.category_name,d.manufacturer_name,e.company_name,e.address1,e.address2,e.email_id,e.Contact_number,e.city,e.states,e.location_map from #__deal_productslisting_deals as a,#__deal_products as b,#__deal_productcategories as c,#__deal_manufacturer as d,#__deal_merchants as e where a.product_id in ($p_id1, $p_id2) and a.vendor_id in ($v_id1, $v_id2) and a.listingstart_date <= '$today_date' and a.listingend_date >= '$today_date' and a.stock_in='1' and a.product_id=b.id and b.category_id=c.id and b.manufacturer_id=d.id and a.vendor_id=e.id";
		$db->setQuery($query);
		$compare = $db->loadAssocList();
		?>
		<div id="compare_product">
			<div class="cat_head1">
				<div class="back1">
					<a href="javascript:history.back()">Go back</a> 
				</div>
				<div class="back">
					<a href='index.php?option=com_dealcatalog&task=productslisting&Itemid=<?php echo $_REQUEST['Itemid']; ?>'> View Product Listings </a>
				</div>
			</div>
			<div class="compare_title">
				<div class="compare_image">
					Compare Products images
				</div>
				<div class="compare_title2">
					Merchant Name
				</div>
				<div class="compare_title1">
					Product Title
				</div>
				<div class="compare_title2">
					Category
				</div>
				<div class="compare_title1">
					Manufacturer
				</div>
				<div class="compare_title2">
					Price
				</div>
				<div class="compare_title1">
					Discount Price
				</div>
				<div class="compare_title2">
					Product Expries
				</div>
				<div class="compare_title1">
					Deal Price
				</div>
				<div class="compare_title2">
					Deal Expries
				</div>
				<div class="compare_title12">
					Address
				</div>
				<div class="compare_title2">
					Email-Id
				</div>
				<div class="compare_title1">
					Contact number
				</div>
				<div class="compare_title21">
					Product Description
				</div>				
			</div>
			<?php
			foreach($compare as $row)
			{
				$productlistid = $row['id'];
				$product_id = $row['product_id'];
				$vendor_id = $row['vendor_id'];
				$product_name = $row['product_name'];
				$product_code = $row['product_code'];
				$category = $row['category_name'];
				$manufacturer = $row['manufacturer_name'];
				$company = $row['company_name'];
				$address = $row['address1']." ".$row['address2']." , ".$row['city']." ".$row['states'];
				$contact_number = $row['Contact_number'];
				$email = $row['email_id'];
				$location = $row['location_map'];
				$price = $row['price'];
				$discount_price = $row['discount_price'];
				$product_close = $row['listingend_date'];
				$isdeal = $row['is_deal'];
				$deal_price = $row['deal_price'];
				$dealstart = $row['dealstart_date'];
				$dealclose = $row['dealend_date'];
				$product_desc = $row['product_desc'];
				$merchant_desc = $row['merchantproduct_desc'];
				$pimage = $row['product_image1'];
				$pimage1 = $row['product_thumbimage1'];
				$merchantimage = $row['merchantproduct_image1'];
				$merchantimage1 = $row['merchantproduct_thumbimage1'];
				//Product Image
				if($merchantimage!='')
				{
					$image = substr($merchantimage, 3);
					$thumb_image = substr($merchantimage1, 3);
				}
				else
				{
					$image = substr($pimage, 3);
					$thumb_image = substr($pimage1, 3);
				}
				//Product Description
				if($merchant_desc!='')
				{
					$desc = $merchant_desc;
				}
				else
				{
					$desc = $product_desc;
				}
				?>
				<div class="compare">
					<div class="compare_image">
						<a class="fancybox" href="<?php echo $image; ?>" title="<?php echo $product_name;?>">
							<img src="<?php echo $thumb_image; ?>" />
						</a>						
					</div>
					<?php
						if($isdeal==1)
						{
							?>
							<div class="offer_highlight1">
								<img src="/deal/components/com_dealcatalog/deal.png">
							</div>
							<?php
						}
					?>
					<div class="compare2">
						<a href="index.php?option=com_dealcatalog&task=productview&productlisting=<?php echo $productlistid; ?>&Itemid=<?php echo $_REQUEST['Itemid']; ?>">
							<?php echo $product_name; ?>
						</a>
					</div>
					<div class="compare1">
						<?php echo $company; ?>
					</div>
					<div class="compare2">
						<?php echo $category; ?>
					</div>
					<div class="compare1">
						<?php echo $manufacturer; ?>
					</div>
					<div class="compare2">
						<?php echo $price; ?>
					</div>
					<div class="compare1">
						<?php 
						if($discount_price!=0.00)
						{
							echo $discount_price;
						}
						else
						{
							echo "---";
						}
						?>
					</div>
					<div class="compare2">
						<?php echo $product_close; ?>
					</div>
					<div class="compare1">
						<?php 
						if($isdeal==1)
						{
							echo $deal_price;
						}
						else
						{
							echo "---";
						}
						?>
					</div>
					<div class="compare2">
						<?php
						if($isdeal==1)
						{
							echo $dealclose;
						}
						else
						{
							echo "---";
						}
						?>
					</div>
					<div class="compare12">
						<?php echo $address; ?>
					</div>
					<div class="compare2">
						<?php echo $email; ?>
					</div>
					<div class="compare1">
						<?php echo $contact_number; ?>
					</div>
					<div class="compare21">
						<?php echo substr($desc, 0,30)."....."; ?>
						<a href="index.php?option=com_dealcatalog&task=productview&productlisting=<?php echo $productlistid; ?>&Itemid=<?php echo $_REQUEST['Itemid']; ?>">
							more
						</a>
					</div>
				</div>
				<?php
			}
			?>
		</div>
		<?php
	}
	
	function merchantdefault()
	{
		$user = &JFactory::getUser();
		$userid = $user->id;
		$usertype = $user->usertype;
		$db = &JFactory::getDBO();
		if($userid==0)
		{
			?>
				<script type="text/javascript" src="components/com_dealcatalog/js/jquery1.7.js"></script>
				<script type="text/javascript" src="components/com_dealcatalog/js/jquery.fancybox.js"></script>		
				<script type="text/javascript" src="components/com_dealcatalog/css/dealcatalog.css"></script>
				<link rel="stylesheet" type="text/css" href="components/com_dealcatalog/js/jquery.fancybox.css" media="screen" />
				<script type="text/javascript">
					$(document).ready(function() {
						$(".fancybox").fancybox();
					});
				</script>
				<p> Welcome Merchant to deal catalog for dealing the product price or listing the products </p>
				<p> You can add products, add promotion type for products, view customer lists for coupon code for your product </p>
				<p>
					<a class="fancybox" href="#merchantlogin" title="Merchant Login"> Login </a>&nbsp; / &nbsp;&nbsp;&nbsp;<a href="index.php?option=com_dealcatalog&task=merchantregister&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> New Merchant Register </a>
				</p>
				<div id="merchantlogin" style="display:none;">
					<?php
						$document	= &JFactory::getDocument();
						$renderer	= $document->loadRenderer('modules');
						$options	= array('style' => 'xhtml');
						$position	= 'customerlogin';
						echo $renderer->render($position, $options, null);
					?>
				</div>
			<?php
		}
		else
		{
			if($usertype=='Merchants')
			{
				?>
				<style type="text/css">
					 /* Graph 1 */
					 #testgraph .graph {
					 height: 310px; /* Needs to be divisible by Number of Graph lines, IE & Chrome will round down decimals in CSS. FF will use the decimals. */
					 width: 600px; /* Needs to be divisible by number of Bars, if you want them to be centered nicely */
					 }				 
					 .graphtable td { vertical-align: top; font-family: Arial, Helvetica, sans-serif; }
					 .graphtable label { display: block; width: 145px; height: 25px; font-size: 13px; padding-left: 35px; }
					 .graphtable label span { display: block; width: 55px; float: right; height: 15px; width: 15px;  border: 1px solid #ccc; text-indent: -20px;  }
					 .line { font-size: 10px; }
					 .graph { margin-left: 35px; border: 1px solid #666; }
					 .graph .line { border-bottom: 1px solid #ccc; margin-top: -1px; }
					 .graph .fix  { border-bottom: none;}				 
					 .graph .line span { position: absolute; display: block; margin-left: -40px; width: 35px; text-align: right; margin-top: -5px; }
					 .bar { position: absolute; margin-bottom: 0; }				 
				</style>
				<script src="components/com_dealcatalog/js/jquery1.4.js"></script>
				<script type="text/javascript">				 
					 /**
					 * Initiates Graph Functions
					 **/
					 function graphit($graph_id,$lines,$bar_margins,$bar_speed,$animate){				 
					 $v = new Object(); // create graph object
					 $v.graphid = $graph_id; // id of graph container, example "graph1" or "myGraph"
					 $v.values = new Array(); // array of values
					 $v.heights = new Array(); // array of bar heights
					 $v.colors = new Array(); // colors for bars
					 $v.lines = $lines; // number of lines - keep this 10 unless you want to write a bunch more code
					 $v.bm = $bar_margins; // margins between the bars
					 $v.mx = 0; // highest number, or rounded up number
					 $v.gw = $('#'+$v.graphid+' .graph').width(); // graph width
					 $v.gh = $('#'+$v.graphid+' .graph').height(); // graph height
					 $v.speed = $bar_speed; // speed for bar animation in milliseconds
					 $v.animate = $animate; // determines if animation on bars are run, set to FALSE if multiple charts				 
					 getValues(); // load the values & colors for bars into $v object
					 graphLines(); // makes the lines for the chart
					 graphBars(); // make the bars
					 if($v.animate)
					 animateBars(0); // animate and show the bars
					 }				 
					 /**
					 * Makes the HTML for the lines on the chart, and places them into the page.
					 **/
					 function graphLines(){
					 $r = ($v.mx < 100)?10:100; // determine to round up to 10 or 100
					 $v.mx = roundUp($v.mx,$r); // round up to get the max number for lines on chart
					 $d = $v.mx / $v.lines; // determines the increment for the chart line numbers				 
					 // Loop through and create the html for the divs that will make up the lines & numbers
					 $html = ""; $i = $v.mx;
					 if($i>0 && $d>0){
					 while($i >= 0){
					 $html += graphLinesHelper($i, $v.mx);
					 $i = $i - $d;
					 }
					 }
					 $('#'+$v.graphid+' .graph').html($html); // Put the lines into the html
					 $margin = $v.gh / $v.lines; // Determine the margin size for line spacing
					 $('#'+$v.graphid+' .line').css("margin-bottom",$margin + "px");    // Add the margins to the lines
					 }				 
					 /**
					 * Creates the html for the graph lines and numbers
					 **/
					 function graphLinesHelper($num, $maxNum){
					 $fix = ($i == $maxNum || $i == 0)? "fix ":""; // adds class .fix, which removes the "border" for top and bottom lines
					 return "<div class='"+$fix+"line'><span>" + $num + "</span></div>";
					 }				 
					 /**
					 * A Simple Round Up Function
					 **/
					 function roundUp($n,$r){
					 return (($n%$r) > 0)?$n-($n%$r) + $r:$n;
					 }				 
					 /**
					 * Gets the values & colors from the HTML <labels> and saves them into $v ohject
					 **/
					 function getValues(){
					 $lbls = $('#'+$v.graphid+' .values span'); // assigns the span DOM object to be looped through
					 // loop through
					 for($i=0;$i <= $lbls.length-1; $i++){
					 $vals = parseFloat($lbls.eq($i).text());
					 $v.colors.push($lbls.eq($i).css('background-color'));
					 $v.mx = ($vals > $v.mx)?$vals:$v.mx;
					 $v.values.push($vals);
					 }
					 }				 
					 /**
					 * Creates the HTML for the Bars, adds colors, widths, and margins for proper spacing.
					 * Then Puts it on the page.
					 **/
					 function graphBars(){
					 $xbars  = $v.values.length; // number of bars
					 $barW    = ($v.gw-($xbars * ($v.bm))) / $xbars;
					 $mL     = ($('#'+$v.graphid+' .line span').width()) + ($v.bm/2);
					 $html="";
					 for($i=1;$i<=$xbars;$i++){
					 $v.heights.push(($v.gh / $v.mx) * $v.values[$i-1]);
					 $ht = ($v.animate == true)?0:$v.heights[$i-1];
					 $html += "<div class='bar' id='"+$v.graphid+"_bar_"+($i-1)+"' style='height: "+$ht+"px; margin-top: -"+($ht+1)+"px; ";
					 $html += "background-color: "+$v.colors[$i-1]+"; margin-left: "+$mL+"px'>&nbsp;</div>";
					 $mL = $mL + $barW + $v.bm;
					 }
					 $($html).insertAfter('#'+$v.graphid+' .graph');
					 $('#'+$v.graphid+' .bar').css("width", $barW + "px");
					 }				 
					 /**
					 * Animates the Bars to the correct heights.
					 **/
					 function animateBars($i){
					 if($i == $v.values.length){ return; }
					 $('#'+$v.graphid+'_bar_'+$i).animate({
					 marginTop: "-" + ($v.heights[$i] + 1) + "px",
					 height: ($v.heights[$i]) + "px"
					 },$v.speed,"swing", function(){animateBars($i+1); });
					 }				 
				</script>
				<script type="text/javascript">
					 $(document).ready(function(){
					 $graph_id    = 'testgraph'; // id of graph container
					 $lines          = 10; // number of lines - keep this 10 unless you want to write a bunch more code
					 $bar_margins = 30; // margins between the bars
					 $bar_speed      = 500; // speed for bar animation in milliseconds
					 $animate      = true; // set to false if multiple charts on one page
					 graphit($graph_id,$lines,$bar_margins,$bar_speed, $animate);
					 });
				</script>
				<?php
				$today_date = date('Y-m-d');
				//product view and Coupon used count
				$query="select a.id,b.product_id,b.product_viewcount,b.product_couponcount from #__deal_merchants as a,#__deal_productcounts as b where a.user_id='$userid' and a.id=b.vendor_id ";
				$db->setQuery($query);
				$viewcount = $db->loadAssocList();
				foreach($viewcount as $row)
				{
					$productview += $row['product_viewcount'];
					$couponused += $row['product_couponcount'];
				}
				//Total Products for merchnats
				$query = "select a.id,b.product_id from #__deal_merchants as a,#__deal_productslisting_deals as b where a.user_id='$userid' and a.id=b.vendor_id";
				$db->setQuery($query);
				$productcount = $db->loadResultArray();
				$totalproducts = count($productcount);
				//Product listing count
				$query = "select a.id,b.product_id from #__deal_merchants as a,#__deal_productslisting_deals as b where a.user_id='$userid' and a.id=b.vendor_id and b.stock_in='1' and b.listingstart_date <= '$today_date' and b.listingend_date >= '$today_date'";
				$db->setQuery($query);
				$productlisting = $db->loadResultArray();
				$totallisting = count($productlisting);
				//Deal Listing count
				$query = "select a.id,b.product_id from #__deal_merchants as a,#__deal_productslisting_deals as b where a.user_id='$userid' and a.id=b.vendor_id and b.stock_in='1' and b.is_deal='1' and b.dealstart_date <= '$today_date' and b.dealend_date >= '$today_date'";
				$db->setQuery($query);
				$deallisting = $db->loadResultArray();
				$totaldeal = count($deallisting);
				//Company name
				$query = "select company_name from #__deal_merchants where user_id='$userid'";
				$db->setQuery($query);
				$company = $db->loadRow();
				$company_name = $company[0];
				?>
				<div id="merchant_layout">
					<div id="merchant_menu">
						<ul>
							<li> <a href="index.php?option=com_dealcatalog&task=merchantdefault&Itemid=<?php echo $_REQUEST['Itemid']; ?>" > DashBoard </a> </li>
							<li> <a href="index.php?option=com_dealcatalog&task=products&Itemid=<?php echo $_REQUEST['Itemid']; ?>" > Products </a> </li>
							<li> <a href="index.php?option=com_dealcatalog&task=addproductslistingdeals&Itemid=<?php echo $_REQUEST['Itemid']; ?>" > Add Products Listing and Deals </a> </li>
							<li> <a href="index.php?option=com_dealcatalog&task=myproductslisting&Itemid=<?php echo $_REQUEST['Itemid']; ?>" > My Products Usage</a> </li>
							<li> <a href="index.php?option=com_dealcatalog&task=coupons&Itemid=<?php echo $_REQUEST['Itemid']; ?>" > My Customers Coupons </a> </li>
						</ul>
					</div>				
					<div id="dashboard">
						<div class="welcome">
							<?php								
								echo "Welcome back ".$company_name;;
							?>
						</div>
						<div class="merchant_title">
							<h2> Products DashBoard </h2>
						</div>
						<table id="testgraph" class="graphtable">
							 <tr>
								 <td>
								 <div class="gCont">   <div class="graph"></div>   </div>
								 </td>
							</tr>
							<tr>
								 <td class="values">							 
								 <span style="background-color: #ccc; display:none"><?php echo $totalproducts; ?></span>
								 <span style="background-color: #06F; display:none"><?php echo $totallisting; ?></span>
								 <span style="background-color: red; display:none"><?php echo $totaldeal; ?></span>
								 <span style="background-color: #C60; display:none"><?php echo $productview; ?></span>
								 <span style="background-color: #936; display:none"><?php echo $couponused; ?></span>
								 </td>
							</tr>
						</table>
						<div class="graphlist"> Total Products </div>
						<div class="graphlist1"> Product Listing </div>
						<div class="graphlist1"> Deal Products </div>
						<div class="graphlist1"> Products views </div>
						<div class="graphlist1"> Coupons </div>
					</div>
				</div>
			<?php
			}
			else
			{
				echo "<h1> You don't have the permission to access this page </h1>";
				echo "<p> Please <a href='index.php?option=com_dealcatalog&task=merchantregister&Itemid=".$_REQUEST['Itemid']."'> Register </a> as a Merchant  </p>";
			}
		}
	}
	
	function products()
	{
		$user = &JFactory::getUser();
		$userid = $user->id;
		$usertype = $user->usertype;
		$db = &JFactory::getDBO();
		if($usertype=='Merchants' && $userid!=0)
		{			
			?>
			<script type="text/javascript" src="components/com_dealcatalog/js/jquery1.7.js"></script>
			<script type="text/javascript" src="components/com_dealcatalog/js/jquery.fancybox.js"></script>		
			<script type="text/javascript" src="components/com_dealcatalog/css/dealcatalog.css"></script>
			<link rel="stylesheet" type="text/css" href="components/com_dealcatalog/js/jquery.fancybox.css" media="screen" />
			<script type="text/javascript">
				$(document).ready(function() {
					$(".fancybox").fancybox();
				});
				function productchange()
				{
					document.viewproducts.submit();
				}
			</script>
			<?php
			$pid = $_POST['productview'];
			if($_SESSION['newproduct']!='')
			{
				$pid = $_SESSION['newproduct'];
			}
			//Products Display
			$query = "select id,product_name from #__deal_products";
			$db->setQuery($query);
			$products  = $db->loadAssocList();
			//Company name
			$query = "select company_name from #__deal_merchants where user_id='$userid'";
			$db->setQuery($query);
			$company = $db->loadRow();
			$company_name = $company[0];
			//Single Product
			$query = "select a.product_name,a.product_code,a.product_desc,a.product_image1,a.product_thumbimage1,b.category_name,c.manufacturer_name from #__deal_products as a,#__deal_productcategories as b,#__deal_manufacturer as c where a.id='$pid' and a.manufacturer_id=c.id and a.category_id=b.id";
			$db->setQuery($query);
			$single_product = $db->loadAssocList();
			foreach($single_product as $row)
			{
				$product_name = $row['product_name'];
				$product_code = $row['product_code'];
				$category = $row['category_name'];
				$manufacturer = $row['manufacturer_name'];
				$desc = $row['product_desc'];
				$image = substr($row['product_image1'], 3);
				$thumb_image = substr($row['product_thumbimage1'], 3);
			}
			?>
			<div id="merchant_layout">
				<div id="merchant_menu">
						<ul>
							<li> <a href="index.php?option=com_dealcatalog&task=merchantdefault&Itemid=<?php echo $_REQUEST['Itemid']; ?>" > DashBoard </a> </li>
							<li> <a href="index.php?option=com_dealcatalog&task=products&Itemid=<?php echo $_REQUEST['Itemid']; ?>" > Products </a> </li>
							<li> <a href="index.php?option=com_dealcatalog&task=addproductslistingdeals&Itemid=<?php echo $_REQUEST['Itemid']; ?>" > Add Products Listing and Deals </a> </li>
							<li> <a href="index.php?option=com_dealcatalog&task=myproductslisting&Itemid=<?php echo $_REQUEST['Itemid']; ?>" > My Products Usage</a> </li>
							<li> <a href="index.php?option=com_dealcatalog&task=coupons&Itemid=<?php echo $_REQUEST['Itemid']; ?>" > My Customers Coupons </a> </li>
						</ul>
				</div>
				<div id="addproduct">
					<div class="welcome">
							<?php							
								echo "Welcome back ".$company_name;
							?>
					</div>
					<div class="merchant_title">
						<h2> Products </h2>
						<div class="pro_head"> View the Existing Products </div>
						<div class="viewproducts">
							<form name="viewproducts" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
								<select name="productview" onChange="productchange();">
									<option value="0"> Select a Product </option>
									<?php								
									foreach($products as $row)
									{
										$pids = $row['id'];
										$pname = $row['product_name']
										?>
											<option value="<?php echo $pids; ?>" <?php if($pid==$pids) { ?>selected="selected" <?php } ?>>
												<?php echo $pname; ?> 
											</option>
										<?php
									}
									?>
								</select>
							</form>
						</div>
						<div class="or"> OR </div>
						<div class="add" >
							 <a href="index.php?option=com_dealcatalog&task=addproducts&Itemid=<?php echo $_REQUEST['Itemid']; ?>" >Add a New Product </a>
						</div>
						<?php
							if($pid!='')
							{							
								?>
								<div id="single_product1">
									<div class="img_views">
										<a class="fancybox" href="<?php echo $image; ?>" title="<?php echo $product_name;?>">
											<img src="<?php echo $thumb_image; ?>" />
										</a>
									</div>
									<div class="offers">
										<span class='side_title'> Product Name  </span><span class='side_desc'> : <?php echo $product_name; ?></span>
									</div>
									<div class="offers">
										<span class='side_title'> Product Code  </span><span class='side_desc'> : <?php echo $product_code; ?></span>
									</div>
									<div class="offers">
										<span class='side_title'> Category  </span> <span class='side_desc'>: <?php echo $category; ?></span>
									</div>
									<div class="offers">
										<span class='side_title'> Manufacturer  </span><span class='side_desc'> : <?php echo $manufacturer; ?></span>
									</div>
									<div class="offers">
										<span class='side_title'> Description  </span><span class='side_desc'> : <?php echo $desc; ?></span>
									</div>								
								</div>
								<?php
							}
						?>
					</div>
				</div>
			</div>
			<?php
			unset($_SESSION['newproduct']);
		}
		else
		{
			echo "<h1> You don't have the permission to access this page </h1>";
			echo "<p> Please <a href='index.php?option=com_dealcatalog&task=merchantregister&Itemid=".$_REQUEST['Itemid']."'> Register </a> as a Merchant  </p>";
		}		
	}
	
	function addproducts()
	{
		$user = &JFactory::getUser();
		$userid = $user->id;
		$usertype = $user->usertype;
		$db = &JFactory::getDBO();
		if($usertype=='Merchants' && $userid!=0)
		{
			?>
			<script type="text/javascript">
				function newcat()
				{
					if(document.addproduct.addcategory.checked==true)
					{
						document.getElementById('categories').style.display='none';
						document.getElementById('newcategories').style.display='block';
						document.addproduct.oldcategory.checked=false;
					}
				}
				function oldcat()
				{
					if(document.addproduct.oldcategory.checked==true)
					{
						document.getElementById('categories').style.display='block';
						document.getElementById('newcategories').style.display='none';
						document.addproduct.addcategory.checked=false;
					}
				}
				function newmanu()
				{
					if(document.addproduct.addmanufacturer.checked==true)
					{
						document.getElementById('manufacturer').style.display='none';
						document.getElementById('newmanufacturer').style.display='block';
						document.addproduct.oldmanufacturer.checked=false;
					}
				}
				function oldmanu()
				{
					if(document.addproduct.oldmanufacturer.checked==true)
					{
						document.getElementById('manufacturer').style.display='block';
						document.getElementById('newmanufacturer').style.display='none';
						document.addproduct.addmanufacturer.checked=false;
					}
				}
				function check_product()
				{
					var form = document.addproduct;
					if(form.product_name.value.length==0)
					{
						alert('Please Enter the Product name');
						form.product_name.focus();
						return false;
					}
					if(form.product_code.value.length==0)
					{
						alert('please Enter the Product code');
						form.product_code.focus();
						return false;
					}
					var p_check = /^[A-Za-z0-9]{3,20}$/
					if(form.product_code.value.search(p_check) == -1)
					{
						alert('Special characters are not allowed or Your product code must be minimum of 3 characters ');
						form.product_code.focus();
						form.product_code.value="";
						return false;
					}
					if(form.product_desc.value=="")
					{
						alert('Enter the product Description ');
						form.product_desc.focus();
						return false;
					}
					if(form.category_id.value==0 && form.category_name.value.length==0)
					{
						alert('Please select or enter the product category');
						form.category_id.focus();
						return false;
					}
					if(form.manufacturer_id.value==0 && form.manufacturer_name.value.length==0)
					{
						alert('Please select or enter the manufacturer of the product');
						form.manufacturer_id.focus();
						return false;
					}
					return true;
				}
			</script>
			<?php
			//Company name
			$query = "select company_name from #__deal_merchants where user_id='$userid'";
			$db->setQuery($query);
			$company = $db->loadRow();
			$company_name = $company[0];
			//Category
			$query = "select id,category_name from #__deal_productcategories";
			$db->setQuery($query);
			$category = $db->loadAssocList();
			//Manufactuer
			$query = "select id,manufacturer_name from #__deal_manufacturer";
			$db->setQuery($query);
			$manufacturer = $db->loadAssocList();
			?>
			<div id="merchant_layout">
				<div id="merchant_menu">
					<ul>
						<li> <a href="index.php?option=com_dealcatalog&task=merchantdefault&Itemid=<?php echo $_REQUEST['Itemid']; ?>" > DashBoard </a> </li>
						<li> <a href="index.php?option=com_dealcatalog&task=products&Itemid=<?php echo $_REQUEST['Itemid']; ?>" > Products </a> </li>
						<li> <a href="index.php?option=com_dealcatalog&task=addproductslistingdeals&Itemid=<?php echo $_REQUEST['Itemid']; ?>" > Add Products Listing and Deals </a> </li>
						<li> <a href="index.php?option=com_dealcatalog&task=myproductslisting&Itemid=<?php echo $_REQUEST['Itemid']; ?>" > My Products Usage</a> </li>
						<li> <a href="index.php?option=com_dealcatalog&task=coupons&Itemid=<?php echo $_REQUEST['Itemid']; ?>" > My Customers Coupons </a> </li>
					</ul>
				</div>
				<div id="newproducts">
					<div class="welcome">
						<?php							
							echo "Welcome back ".$company_name;
						?>
					</div>
					<div class="merchant_title">
						<h2> Add a new Product </h2>
						<form name="addproduct" method="post" action="index.php?option=com_dealcatalog&task=saveproduct" enctype="multipart/form-data" onSubmit="return check_product();">
							<div class="productadd">
								<fieldset>
									<legend> New Product </legend>
									<div class="details_title4"> Product title </div>
									<div class="details_names5"> <input type="text" name="product_name" value="" class="text_input"/> </div>
									<div class="details_title4"> Product Code </div>
									<div class="details_names5"> <input type="text" name="product_code" value="" class="text_input"/> </div>
									<div class="details_title4"> Product Description </div>
									<div class="details_desc"> <textarea name="product_desc" rows="8" cols="60"></textarea> </div>
									<div class="details_title4"> Product Category </div>
									<div id="categories">
										<div class="details_names5">
											<select name="category_id">
												<option value="0"> Select Category </option>
												<?php												
												foreach($category as $row)
												{
												?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['category_name']; ?> </option>
												<?php
												}
												?>
											</select>
										</div>
										<div class="or"> OR </div>									
										<div class="checkcategory">
											<input type="checkbox" id="addcategory" name="addcategory" value="1" onClick="newcat();"> Add a new category
										</div>
									</div>
									<div id="newcategories" style="display:none;">
										<div class="details_names5">
											<input type="text" name="category_name" value="" />
										</div>
										<div class="or"> OR </div>									
										<div class="checkcategory">
											<input type="checkbox" id="oldcategory" name="oldcategory" value="1" onClick="oldcat();"> exiting category
										</div>
									</div>
									<div class="details_title4"> Product Manufacturer </div>
									<div id="manufacturer">
										<div class="details_names5">
											<select name="manufacturer_id">
												<option value="0"> Select manufacturer </option>
												<?php												
												foreach($manufacturer as $row)
												{
												?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['manufacturer_name']; ?> </option>
												<?php
												}
												?>
											</select>
										</div>
										<div class="or"> OR </div>									
										<div class="checkcategory">
											<input type="checkbox" id="addmanufacturer" name="addmanufacturer" value="1" onClick="newmanu();"> Add a new manufacturer
										</div>
									</div>
									<div id="newmanufacturer" style="display:none;">
										<div class="details_names5">
											<input type="text" name="manufacturer_name" value="" />
										</div>
										<div class="or"> OR </div>									
										<div class="checkcategory">
											<input type="checkbox" id="oldmanufacturer" name="oldmanufacturer" value="1" onClick="oldmanu();"> exiting manufacturer
										</div>
									</div>
									<div class="details_title4"> Product Image </div>
									<div class="details_names5"> <input type="file" name="file" id="file"  /> </div>
									<input type="hidden" value="<?php echo $_REQUEST['Itemid']; ?>" name="Itemid" />
									<div class="submit"> <input type="submit" name="addproduct" value="Add" class="adds" /> <input type="button" name="cancelproduct" value="Cancel" class="adds" /></div>
								</fieldset>
							</div>
						</form>
					</div>
				</div>
			</div>
			<?php
		}
		else
		{
			echo "<h1> You don't have the permission to access this page </h1>";
			echo "<p> Please <a href='index.php?option=com_dealcatalog&task=merchantregister&Itemid=".$_REQUEST['Itemid']."'> Register </a> as a Merchant  </p>";
		}
	}
	
	function addproductslistingdeals()
	{
		$user = &JFactory::getUser();
		$userid = $user->id;
		$usertype = $user->usertype;
		$db = &JFactory::getDBO();
		if($usertype=='Merchants' && $userid!=0)
		{
			?>
			<style type="text/css">
				.calendar
				{
					margin-left:5px; position:relative; top:5px;
				}
			</style>
			<script type="text/javascript" src="components/com_dealcatalog/js/jquery1.7.js"></script>
			<script type="text/javascript" src="components/com_dealcatalog/js/jquery.fancybox.js"></script>		
			<script type="text/javascript" src="components/com_dealcatalog/css/dealcatalog.css"></script>
			<link rel="stylesheet" type="text/css" href="components/com_dealcatalog/js/jquery.fancybox.css" media="screen" />
			<script type="text/javascript">
				$(document).ready(function() {
						$(".fancybox").fancybox();
					});
				function productview()
				{
					document.productlists.submit();
				}
				function newdesc()
				{					
					if(document.listdealform.productdesc.checked==true)
					{
						document.getElementById('product_desc1').style.display="block";
						document.getElementById('product_desc').style.display="none";
					}
					else
					{
						document.getElementById('product_desc1').style.display="none";
						document.getElementById('product_desc').style.display="block";
					}
				}
				function newimg()
				{
					if(document.listdealform.productimg.checked==true)
					{
						document.getElementById('product_image1').style.display="block";
						document.getElementById('product_image').style.display="none";
					}
					else
					{
						document.getElementById('product_image1').style.display="none";
						document.getElementById('product_image').style.display="block";
					}
				}
				function showdeal()
				{
					if(document.listdealform.isdeal.checked==true)
					{
						document.getElementById('showdeal').style.display="block";
					}
					else
					{
						document.getElementById('showdeal').style.display="none";
					}
				}
				function dealforms()
				{
					var form  = document.listdealform;
					if(form.stock_in.value=="")
					{
						alert('Please the select the product stock');
						form.stock_in.focus();
						return false;
					}
					if(form.price.value.length==0)
					{
						alert('Enter the Price for the product');
						form.price.focus();
						return false;
					}
					var pri = /^\d+\.\d{2}$/;; 
					if(form.price.value.search(pri)== -1)
					{
						alert('Enter the correct Price Format');
						form.price.focus();
						form.price.value="";
						return false;
					}
					if(form.discount_price.value.length > 0)
					{
						if(form.discount_price.value.search(pri)== -1)
						{
							alert('Enter the correct price format');
							form.discount_price.focus();
							form.discount_price.value="";
							return false;
						}
					}					
					if(form.listingstart_date.value.length==0)
					{
						alert('Enter the Start date');
						form.listingstart_date.focus();
						return false;
					}
					if(form.listingend_date.value.length==0)
					{
						alert('Enter the End date');
						form.listingend_date.focus();
						return false;
					}
					var s = form.listingstart_date.value;
					var e = form.listingend_date.value;
					var one_day=1000*60*60*24; 
					var x=s.split("-");
					var y=e.split("-");
					var date1=new Date(x[0],(x[1]-1),x[2]);
					var date2=new Date(y[0],(y[1]-1),y[2]);
					var month1=x[1]-1;
					var month2=y[1]-1;
					Diff=Math.ceil((date2.getTime()-date1.getTime())/(one_day));
					if(Diff < 0)
					{
						alert('Select the correct start and end date for product');
						form.listingstart_date.focus();
						return false;
					}
					if(document.listdealform.isdeal.checked==true)
					{
						if(form.deal_price.value.length==0)
						{
							alert('Enter the Deal Price for the product');
							form.deal_price.focus();
							return false;
						}
						var pri = /^\d+\.\d{2}$/; 
						if(form.deal_price.value.search(pri)== -1)
						{
							alert('Enter the correct Price Format');
							form.deal_price.focus();
							form.deal_price.value="";
							return false;
						}
						if(form.dealstart_date.value.length==0)
						{
							alert('Enter the Start date');
							form.dealstart_date.focus();
							return false;
						}
						if(form.dealend_date.value.length==0)
						{
							alert('Enter the End date');
							form.dealend_date.focus();
							return false;
						}
						var s = form.dealstart_date.value;
						var e = form.dealend_date.value;
						var one_day=1000*60*60*24; 
						var x=s.split("-");
						var y=e.split("-");
						var date1=new Date(x[0],(x[1]-1),x[2]);
						var date2=new Date(y[0],(y[1]-1),y[2]);
						var month1=x[1]-1;
						var month2=y[1]-1;
						Diff=Math.ceil((date2.getTime()-date1.getTime())/(one_day));
						if(Diff < 0)
						{
							alert('Select the correct start and end date for product');
							form.dealstart_date.focus();
							return false;
						}
						if(form.promotion_type.value==0)
						{
							alert('Please select the promotion for displaying the product');
							form.promotion_type.focus();
							return false;
						}	
					}
					return true;
				}
			</script>
			<?php
			//Company name
			$query = "select id,company_name from #__deal_merchants where user_id='$userid'";
			$db->setQuery($query);
			$company = $db->loadRow();
			$company_name = $company[1];
			$vendor_id = $company[0];
			//Products Display
			$query = "select id,product_name from #__deal_products";
			$db->setQuery($query);
			$products  = $db->loadAssocList();
			$pid = $_POST['productviews'];
			//Single Product
			$query = "select a.product_name,a.product_code,a.product_desc,a.product_image1,a.product_thumbimage1,b.category_name,c.manufacturer_name from #__deal_products as a,#__deal_productcategories as b,#__deal_manufacturer as c where a.id='$pid' and a.manufacturer_id=c.id and a.category_id=b.id";
			$db->setQuery($query);
			$single_product = $db->loadAssocList();
			foreach($single_product as $row)
			{
				$product_name = $row['product_name'];
				$product_code = $row['product_code'];
				$category = $row['category_name'];
				$manufacturer = $row['manufacturer_name'];
				$desc = $row['product_desc'];
				$image = substr($row['product_image1'], 3);
				$thumb_image = substr($row['product_thumbimage1'], 3);
			}	
			//promotion
			$query = "select * from #__deal_promotiontype";
			$db->setQuery($query);
			$promotion = $db->loadAssocList();
			?>
			<div id="merchant_layout">
				<div id="merchant_menu">
						<ul>
							<li> <a href="index.php?option=com_dealcatalog&task=merchantdefault&Itemid=<?php echo $_REQUEST['Itemid']; ?>" > DashBoard </a> </li>
							<li> <a href="index.php?option=com_dealcatalog&task=products&Itemid=<?php echo $_REQUEST['Itemid']; ?>" > Products </a> </li>
							<li> <a href="index.php?option=com_dealcatalog&task=addproductslistingdeals&Itemid=<?php echo $_REQUEST['Itemid']; ?>" > Add Products Listing and Deals </a> </li>
							<li> <a href="index.php?option=com_dealcatalog&task=myproductslisting&Itemid=<?php echo $_REQUEST['Itemid']; ?>" > My Products Usage</a> </li>
							<li> <a href="index.php?option=com_dealcatalog&task=coupons&Itemid=<?php echo $_REQUEST['Itemid']; ?>" > My Customers Coupons </a> </li>
						</ul>
				</div>
				<div id="productlisting">
					<div class="welcome">
							<?php
								
								echo "Welcome back ".$company_name; 
							?>
					</div>
					<div class="listdeal">
						<h2> Add Product Listing and Deals </h2>
						<form name="productlists" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
							Select Your products for Product Listing and Deals
							<select name="productviews" onChange="productview();">
								<option value="0"> Select a Product </option>
								<?php
								foreach($products as $row)
								{
									$pids = $row['id'];
									$pname = $row['product_name']
									?>
										<option value="<?php echo $pids; ?>" <?php if($pid==$pids) { ?>selected="selected" <?php } ?>>
											<?php echo $pname; ?> 
										</option>
									<?php
								}
								?>
							</select>
						</form>
						<?php						
							if($pid!='')
							{
								?>
								<div class="deal_listing">									
									<div class="dealform">
										<form name="listdealform" method="post" action="index.php?option=com_dealcatalog&task=listdealsave" enctype="multipart/form-data" onSubmit="return dealforms();">
											<fieldset>
												<legend> New Product Listing and Deals </legend>
												<div class="offers1">
													<span class='side_title'> Product Name  </span> 
													<span class='side_desc'> : <?php echo $product_name; ?> </span>
												</div>
												<div class="offers1">
													<span class='side_title'> Product Code  </span> 
													<span class='side_desc'>:  <?php echo $product_code; ?> </span>
												</div>
												<div class="offers1">
													<span class='side_title'> Category  </span> 
													<span class='side_desc'> : <?php echo $category; ?> </span>												
												</div>
												<div class="offers1">
													<span class='side_title'> Manufacturer  </span> 
													<span class='side_desc'>:  <?php echo $manufacturer; ?> </span>
												</div>
												<div class="offers1">
													<span class='side_title'> Description  </span> 
													<div id='product_desc'> : <?php echo $desc; ?> </div>
													<div id="product_desc1" style="display:none;">
														<textarea name="merchantproduct_desc" rows="5" cols="25"></textarea>
													</div>
													<span class="add_newone">
														<input type="checkbox" id="productdesc" name="productdesc" value="1" onClick="newdesc();"> Want to add a new Description ?
													</span>
												</div>
												<div class="offers1">
													<span class='side_title'> Image  </span> 
													<div id='product_image'>  
														<a class="fancybox" href="<?php echo $image; ?>" title="<?php echo $product_name;?>">
															<img src="<?php echo $thumb_image; ?>" />
														</a>
													</div>
													<div id="product_image1" style="display:none;"> : <input type="file" name="file" id="file"  /> </div>
													<span class="add_newone">
														<input type="checkbox" id="productimg" name="productimg" value="1" onClick="newimg();"> Want to add a new Image ?
													</span>
												</div>
												<div class="offers1">
													<span class='side_title'> Stock  </span> 
													<span class='side_desc'> : 
														<select name="stock_in">
															<option value=""> Select Stock </option>
															<option value="1"> Stock in </option>
															<option value="0"> No Stock </option>
														</select>
													</span>
												</div>
												<div class="offers1">
													<span class='side_title'> Price  </span> 
													<span class='side_desc'> : <input type="text" name="price" value=""> price as 0.00 </span>
												</div>
												<div class="offers1">
													<span class='side_title'> Discount Price  </span> 
													<span class='side_desc'> : <input type="text" name="discount_price" value=""> price as 0.00 </span>
												</div>
												<div class="offers1">
													<span class='side_title'> Start Date  </span> 
													<span class='side_desc'> : 
														<?php echo JHTML::_('calendar',$mydate,'listingstart_date','listingstart_date','%Y-%m-%d','size="20",title ="listingstart_date", readonly="readonly"');?>
													</span>
												</div>
												<div class="offers1">
													<span class='side_title'> End Date  </span> 
													<span class='side_desc'> : 
														<?php echo JHTML::_('calendar',$mydate,'listingend_date','listingend_date','%Y-%m-%d','size="20",title ="listingend_date", readonly="readonly"');?>
													</span>
												</div>
												<div class="offers1">
													<input type="checkbox" name="isdeal" value="1" onClick="showdeal();" /> Is Deal
												</div>
												<div id="showdeal" style="display:none;">
													<div class="offers1">
														<span class='side_title'> Deal Price  </span> 
														<span class='side_desc'> : <input type="text" name="deal_price" value=""> price as 0.00 </span>
													</div>													
													<div class="offers1">
														<span class='side_title'> Deal start Date  </span> 
														<span class='side_desc'> : 
															<?php echo JHTML::_('calendar',$mydate,'dealstart_date','dealstart_date','%Y-%m-%d','size="20",title ="dealstart_date", readonly="readonly"');?>
														</span>
													</div>
													<div class="offers1">
														<span class='side_title'> Deal end Date  </span> 
														<span class='side_desc'> : 
															<?php echo JHTML::_('calendar',$mydate,'dealend_date','dealend_date','%Y-%m-%d','size="20",title ="dealend_date", readonly="readonly"');?>
														</span>
													</div>
													<div class="offers1">
														<span class='side_title'> Promotion  </span> 
														<span class='side_desc'> : 
															<select name="promotion_type">
																<option value="0"> Select the Promotion Type </option>
																<?php
																foreach($promotion as $row)
																{
																	?>
																	<option value="<?php echo $row['id']; ?>"><?php echo $row['promotion_type']; ?></option>
																	<?php
																}
																?>
															</select>
														</span>
													</div>
												</div>
												<input type="hidden" name="vendor_id" value="<?php echo $vendor_id; ?>">
												<input type="hidden" name="product_id" value="<?php echo $pid; ?>">
												<input type="hidden" value="<?php echo $_REQUEST['Itemid']; ?>" name="Itemid" />
												<input type="hidden" name="category" value="<?php echo $category; ?>">
												<div class="submits">
													<input type="submit" name="addlistdeal" value="Add" class="adds" />
													<a href="index.php?option=com_dealcatalog&task=addproductslistingdeals&Itemid=<?php echo $_REQUEST['Itemid']; ?>">
														<input type="button" name="cancellistdeal" value="Cancel" class="adds" />
													</a>
												</div>
											</fieldset>
										</form>
									</div>								
								</div>
							<?php
							}
						?>
					</div>
				</div>
			</div>
			<?php
		}
		else
		{
			echo "<h1> You don't have the permission to access this page </h1>";
			echo "<p> Please <a href='index.php?option=com_dealcatalog&task=merchantregister&Itemid=".$_REQUEST['Itemid']."'> Register </a> as a Merchant  </p>";
		}
	}
	
	function myproductslisting()
	{
		$user = &JFactory::getUser();
		$userid = $user->id;
		$usertype = $user->usertype;
		$db = &JFactory::getDBO();
		if($usertype=='Merchants' && $userid!=0)
		{
			?>
			<script type="text/javascript" src="components/com_dealcatalog/js/jquery1.7.js"></script>
			<script type="text/javascript" src="components/com_dealcatalog/js/jquery.fancybox.js"></script>		
			<script type="text/javascript" src="components/com_dealcatalog/css/dealcatalog.css"></script>
			<link rel="stylesheet" type="text/css" href="components/com_dealcatalog/js/jquery.fancybox.css" media="screen" />
			<script type="text/javascript">
				$(document).ready(function() {
						$(".fancybox").fancybox();
					});
			</script>
			<?php
			//Company name
			$query = "select company_name from #__deal_merchants where user_id='$userid'";
			$db->setQuery($query);
			$company = $db->loadRow();
			$company_name = $company[0];
			//Pagination
			global $mainframe;
			$limit= $mainframe->getUserStateFromRequest('global.list.limit','limit', $mainframe->getCfg('list_limit'), 'int');
			$limitstart= $mainframe->getUserStateFromRequest($option.'.limitstart', 'limitstart', 0, 'int');
			if($_REQUEST['limitstart']=='') {$limitstart=0;}
			$query = "select a.product_name,a.product_image1,a.product_thumbimage1,b.id,b.product_id,b.vendor_id,b.stock_in,b.price,b.discount_price,b.listingstart_date,b.listingend_date,b.merchantproduct_image1,b.merchantproduct_thumbimage1,b.is_deal,b.deal_price,b.dealstart_date,b.dealend_date,c.company_name from #__deal_products as a,#__deal_productslisting_deals as b,#__deal_merchants as c where c.user_id='$userid' and a.id=b.product_id and b.vendor_id=c.id order by b.id desc";
			$db->setQuery($query);
			$total = $db->loadResultArray();
			$total = count($total);
			//Products
			jimport('joomla.html.pagination');
			$pageNav = new JPagination( $total, $limitstart, $limit );
			$query = "select a.product_name,a.product_image1,a.product_thumbimage1,b.id,b.product_id,b.vendor_id,b.stock_in,b.price,b.discount_price,b.listingstart_date,b.listingend_date,b.merchantproduct_image1,b.merchantproduct_thumbimage1,b.is_deal,b.deal_price,b.dealstart_date,b.dealend_date,c.company_name from #__deal_products as a,#__deal_productslisting_deals as b,#__deal_merchants as c where c.user_id='$userid' and a.id=b.product_id and b.vendor_id=c.id order by b.id desc";
			$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
			$product_all = $db->loadObjectList();
			?>
			<div id="merchant_layout">
				<div id="merchant_menu">
						<ul>
							<li> <a href="index.php?option=com_dealcatalog&task=merchantdefault&Itemid=<?php echo $_REQUEST['Itemid']; ?>" > DashBoard </a> </li>
							<li> <a href="index.php?option=com_dealcatalog&task=products&Itemid=<?php echo $_REQUEST['Itemid']; ?>" > Products </a> </li>
							<li> <a href="index.php?option=com_dealcatalog&task=addproductslistingdeals&Itemid=<?php echo $_REQUEST['Itemid']; ?>" > Add Products Listing and Deals </a> </li>
							<li> <a href="index.php?option=com_dealcatalog&task=myproductslisting&Itemid=<?php echo $_REQUEST['Itemid']; ?>" > My Products Usage</a> </li>
							<li> <a href="index.php?option=com_dealcatalog&task=coupons&Itemid=<?php echo $_REQUEST['Itemid']; ?>" > My Customers Coupons </a> </li>
						</ul>
				</div>
				<div id="myusage">
					<div class="welcome">
							<?php
								echo "Welcome back ".$company_name;
							?>
					</div>
					<div class="lists">
						<h2> My Products Listing </h2>
						<div id="products_display">
							<div id="search_product">								
								<div class="cat_head"> Showing the Results for "<b> Products Listing and Deals </b>" </div>
								<div class="cat_title">
									<div class="product_count">Showing the <?php echo $pageNav->getResultsCounter(); ?> </div>								
								</div>
								<form method="post" name="myproductslisting" id="myproductslisting" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
									<?php
									$k = $limitstart;
									for($i=0, $n=count($product_all); $i < $n ; $i++)
									{
										$row = &$product_all[$i];
										$productlist = $row->id;
										$product_id = $row->product_id;
										$vendor_id = $row->vendor_id;
										$product_name = $row->product_name;
										$price = $row->price;
										$company_name = $row->company_name;
										$discount_price = $row->discount_price;
										$listenddate = $row->listingend_date;
										$pimage = $row->product_image1;
										$pimage1 = $row->product_thumbimage1;
										$mimage = $row->merchantproduct_image1;
										$mimage1 = $row->merchantproduct_thumbimage1;
										$is_deal = $row->is_deal;
										$deal_price = $row->deal_price;
										$dealstartdate = $row->dealstart_date;
										$dealenddate = $row->dealend_date;
										//Product Image
										if($mimage!='')
										{
											$image = substr($mimage, 3);
											$thumb_image = substr($mimage1, 3);
										}
										else
										{
											$image = substr($pimage, 3);
											$thumb_image = substr($pimage1, 3);
										}
										if($i%2==0)
										{
										?>
											<div class="product_odd">
												<div class="img_views">
													<a class="fancybox" href="<?php echo $image; ?>" title="<?php echo $product_name;?>">
														<img src="<?php echo $thumb_image; ?>" />
													</a>
												</div>
												<div class="offer">
													<?php echo $product_name; ?>
												</div>									
												<div class="offer_price"> 
													Price : <span class="deals"><?php echo $price; ?> </span>
												</div>													
												<div class="offer_price"> 
													Discount Price : <span class="deals"><?php echo $discount_price; ?> </span>
												</div>
												<div class="offer">
													Product Expires on <?php echo $listenddate; ?>
												</div>	
												<?php
												if($is_deal==1)
												{
													?>
													<div class="offer_price"> 
														Deal Price : <span class="deals"><?php echo $deal_price; ?> </span>
													</div>
													<div class="offer">
														Deal Expires on <?php echo $dealenddate; ?>
													</div>
													<?php
												}
												?>												
												<div class="details_more">
													<a href="index.php?option=com_dealcatalog&task=editproductlisting&productlist=<?php echo $productlist; ?>&Itemid=<?php echo $_REQUEST['Itemid']; ?>">  Edit </a>
												</div>
											</div>
										<?php
										}
										else
										{
										?>
											<div class="product_even">												
												<div class="img_views">
													<a class="fancybox" href="<?php echo $image; ?>" title="<?php echo $product_name;?>">
														<img src="<?php echo $thumb_image; ?>" />
													</a>
												</div>
												<div class="offer">
													<?php echo $product_name; ?>
												</div>									
												<div class="offer_price"> 
													Price : <span class="deals"><?php echo $price; ?> </span>
												</div>													
												<div class="offer_price"> 
													Discount Price : <span class="deals"><?php echo $discount_price; ?> </span>
												</div>
												<div class="offer">
													Product Expires on <?php echo $listenddate; ?>
												</div>	
												<?php
												if($is_deal==1)
												{
													?>
													<div class="offer_price"> 
														Deal Price : <span class="deals"><?php echo $deal_price; ?> </span>
													</div>
													<div class="offer">
														Deal Expires on <?php echo $dealenddate; ?>
													</div>
													<?php
												}
												?>												
												<div class="details_more">
													<a href="index.php?option=com_dealcatalog&task=editproductlisting&productlist=<?php echo $productlist; ?>&Itemid=<?php echo $_REQUEST['Itemid']; ?>">  Edit </a>
												</div>
											</div>
										<?php
										}
										$k++;
									}
									?>
									<div class="pagi">
										<?php echo $pageNav->getPagesLinks(); ?>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
		else
		{
			echo "<h1> You don't have the permission to access this page </h1>";
			echo "<p> Please <a href='index.php?option=com_dealcatalog&task=merchantregister&Itemid=".$_REQUEST['Itemid']."'> Register </a> as a Merchant  </p>";
		}
	}
	
	function editproductlisting()
	{
		$user = &JFactory::getUser();
		$userid = $user->id;
		$usertype = $user->usertype;
		$db = &JFactory::getDBO();
		if($usertype=='Merchants' && $userid!=0)
		{
			?>
			<script type="text/javascript" src="components/com_dealcatalog/js/jquery1.7.js"></script>
			<script type="text/javascript" src="components/com_dealcatalog/js/jquery.fancybox.js"></script>		
			<script type="text/javascript" src="components/com_dealcatalog/css/dealcatalog.css"></script>
			<link rel="stylesheet" type="text/css" href="components/com_dealcatalog/js/jquery.fancybox.css" media="screen" />
			<script type="text/javascript">
				$(document).ready(function() {
						$(".fancybox").fancybox();
					});
					function productview()
				{
					document.productlists.submit();
				}
				function newdesc()
				{					
					if(document.listdealform.productdesc.checked==true)
					{
						document.getElementById('product_desc1').style.display="block";
						document.getElementById('product_desc').style.display="none";
					}
					else
					{
						document.getElementById('product_desc1').style.display="none";
						document.getElementById('product_desc').style.display="block";
					}
				}
				function newimg()
				{
					if(document.listdealform.productimg.checked==true)
					{
						document.getElementById('product_image1').style.display="block";
						document.getElementById('product_image').style.display="none";
					}
					else
					{
						document.getElementById('product_image1').style.display="none";
						document.getElementById('product_image').style.display="block";
					}
				}
				function showdeal()
				{
					if(document.listdealform.isdeal.checked==true)
					{
						document.getElementById('showdeal').style.display="block";
					}
					else
					{
						document.getElementById('showdeal').style.display="none";
					}
				}
				function dealforms()
				{
					var form  = document.listdealform;
					if(form.stock_in.value=="")
					{
						alert('Please the select the product stock');
						form.stock_in.focus();
						return false;
					}
					if(form.price.value.length==0)
					{
						alert('Enter the Price for the product');
						form.price.focus();
						return false;
					}
					var pri = /^\d+\.\d{2}$/;; 
					if(form.price.value.search(pri)== -1)
					{
						alert('Enter the correct Price Format');
						form.price.focus();
						form.price.value="";
						return false;
					}
					if(form.discount_price.value.length > 0)
					{
						if(form.discount_price.value.search(pri)== -1)
						{
							alert('Enter the correct price format');
							form.discount_price.focus();
							form.discount_price.value="";
							return false;
						}
					}					
					if(form.listingstart_date.value.length==0)
					{
						alert('Enter the Start date');
						form.listingstart_date.focus();
						return false;
					}
					if(form.listingend_date.value.length==0)
					{
						alert('Enter the End date');
						form.listingend_date.focus();
						return false;
					}
					var s = form.listingstart_date.value;
					var e = form.listingend_date.value;
					var one_day=1000*60*60*24; 
					var x=s.split("-");
					var y=e.split("-");
					var date1=new Date(x[0],(x[1]-1),x[2]);
					var date2=new Date(y[0],(y[1]-1),y[2]);
					var month1=x[1]-1;
					var month2=y[1]-1;
					Diff=Math.ceil((date2.getTime()-date1.getTime())/(one_day));
					if(Diff < 0)
					{
						alert('Select the correct start and end date for product');
						form.listingstart_date.focus();
						return false;
					}
					if(document.listdealform.isdeal.checked==true)
					{
						if(form.deal_price.value.length==0)
						{
							alert('Enter the Deal Price for the product');
							form.deal_price.focus();
							return false;
						}
						var pri = /^\d+\.\d{2}$/; 
						if(form.deal_price.value.search(pri)== -1)
						{
							alert('Enter the correct Price Format');
							form.deal_price.focus();
							form.deal_price.value="";
							return false;
						}
						if(form.dealstart_date.value.length==0)
						{
							alert('Enter the Start date');
							form.dealstart_date.focus();
							return false;
						}
						if(form.dealend_date.value.length==0)
						{
							alert('Enter the End date');
							form.dealend_date.focus();
							return false;
						}
						var s = form.dealstart_date.value;
						var e = form.dealend_date.value;
						var one_day=1000*60*60*24; 
						var x=s.split("-");
						var y=e.split("-");
						var date1=new Date(x[0],(x[1]-1),x[2]);
						var date2=new Date(y[0],(y[1]-1),y[2]);
						var month1=x[1]-1;
						var month2=y[1]-1;
						Diff=Math.ceil((date2.getTime()-date1.getTime())/(one_day));
						if(Diff < 0)
						{
							alert('Select the correct start and end date for product');
							form.dealstart_date.focus();
							return false;
						}
						if(form.promotion_type.value==0)
						{
							alert('Please select the promotion for displaying the product');
							form.promotion_type.focus();
							return false;
						}	
					}
					return true;
					}
			</script> 
			<?php
			$pid1 	= JRequest::getVar('productlist', '' ,"REQUEST");
			//Company name
			$query = "select company_name from #__deal_merchants where user_id='$userid'";
			$db->setQuery($query);
			$company = $db->loadRow();
			$company_name = $company[0];
			//promotion
			$query = "select * from #__deal_promotiontype";
			$db->setQuery($query);
			$promotions = $db->loadAssocList();
			//Get product
			$query = "select a.product_name,a.product_code,a.product_image1,a.product_thumbimage1,a.product_desc,b.id,b.product_id,b.vendor_id,b.stock_in,b.price,b.discount_price,b.listingstart_date,b.listingend_date,b.merchantproduct_desc,b.merchantproduct_image1,b.merchantproduct_thumbimage1,b.is_deal,b.deal_price,b.dealstart_date,b.dealend_date,b.promotion_type,c.category_name,d.manufacturer_name from #__deal_products as a,#__deal_productslisting_deals as b,#__deal_productcategories as c,#__deal_manufacturer as d where b.id='$pid1' and a.id=b.product_id and a.category_id=c.id and a.manufacturer_id=d.id";
			$db->setQuery($query);
			$product = $db->loadAssocList();
			foreach($product as $row)
			{
				$product_name = $row['product_name'];
				$product_code = $row['product_code'];
				$category = $row['category_name'];
				$manufacturer = $row['manufacturer_name'];
				$stock = $row['stock_in'];
				$pdesc = $row['product_desc'];
				$mdesc = $row['merchantproduct_desc'];
				$pimage = substr($row['product_image1'], 3);
				$pimage1 = substr($row['product_thumbimage1'], 3);
				$mimage = substr($row['merchantproduct_image1'], 3);
				$mimage1 = substr($row['merchantproduct_thumbimage1'], 3);
				$price = $row['price'];
				$discount = $row['discount_price'];
				$lstart = $row['listingstart_date'];
				$lend = $row['listingend_date'];
				$isdeal = $row['is_deal'];
				$deal = $row['deal_price'];
				$dstart = $row['dealstart_date'];
				$dend = $row['dealend_date'];
				$promotion = $row['promotion_type'];
			}
			?>
			<div id="merchant_layout">
				<div id="merchant_menu">
					<ul>
						<li> <a href="index.php?option=com_dealcatalog&task=merchantdefault&Itemid=<?php echo $_REQUEST['Itemid']; ?>" > DashBoard </a> </li>
						<li> <a href="index.php?option=com_dealcatalog&task=products&Itemid=<?php echo $_REQUEST['Itemid']; ?>" > Products </a> </li>
						<li> <a href="index.php?option=com_dealcatalog&task=addproductslistingdeals&Itemid=<?php echo $_REQUEST['Itemid']; ?>" > Add Products Listing and Deals </a> </li>
						<li> <a href="index.php?option=com_dealcatalog&task=myproductslisting&Itemid=<?php echo $_REQUEST['Itemid']; ?>" > My Products Usage</a> </li>
						<li> <a href="index.php?option=com_dealcatalog&task=coupons&Itemid=<?php echo $_REQUEST['Itemid']; ?>" > My Customers Coupons </a> </li>
					</ul>
				</div>
				<div id="productlisting">
					<div class="welcome">
							<?php
								echo "Welcome back ".$company_name;
							?>
					</div>
					<div class="deal_listing">									
						<div class="dealform">
							<form name="listdealform" method="post" action="index.php?option=com_dealcatalog&task=listingsave" enctype="multipart/form-data" onSubmit="return dealforms();">
								<fieldset>
									<legend> New Product Listing and Deals </legend>
									<div class="offers1">
										<span class='side_title'> Product Name  </span> 
										<span class='side_desc'> : <?php echo $product_name; ?> </span>
									</div>
									<div class="offers1">
										<span class='side_title'> Product Code  </span> 
										<span class='side_desc'>:  <?php echo $product_code; ?> </span>
									</div>
									<div class="offers1">
										<span class='side_title'> Category  </span> 
										<span class='side_desc'> : <?php echo $category; ?> </span>	
										<input type="hidden" name="category" value="<?php echo $category; ?>" >
									</div>
									<div class="offers1">
										<span class='side_title'> Manufacturer  </span> 
										<span class='side_desc'>:  <?php echo $manufacturer; ?> </span>
									</div>
									<div class="offers1">
										<span class='side_title'> Description  </span> 
										<?php
										if($mdesc!='')
										{
											?>
											<div id='product_desc' style="display:none;"> : <?php echo $pdesc; ?> </div>
											<div id="product_desc1">
												<textarea name="merchantproduct_desc" rows="5" cols="25"><?php echo $mdesc; ?></textarea>
											</div>
											<span class="add_newone">
												<input type="checkbox" id="productdesc" name="productdesc" value="1" onClick="newdesc();" checked="checked"> Want to add a new Description ?
											</span>
											<?php
										}
										else
										{
											?>
											<div id='product_desc'> : <?php echo $pdesc; ?> </div>
											<div id="product_desc1" style="display:none;">
												<textarea name="merchantproduct_desc" rows="5" cols="25"></textarea>
											</div>
											<span class="add_newone">
												<input type="checkbox" id="productdesc" name="productdesc" value="1" onClick="newdesc();"> Want to add a new Description ?
											</span>
											<?php
										}
										?>
									</div>
									<div class="offers1">
										<span class='side_title'> Image  </span> 
											<?php
											if($mimage!='')
											{
												?>
												<div id='product_image' style="display:none;">  
													<a class="fancybox" href="<?php echo $pimage; ?>" title="<?php echo $product_name;?>">
														<img src="<?php echo $pimage1; ?>" />
													</a>
												</div>
												<div id="product_image1" > 
													<a class="fancybox" href="<?php echo $mimage; ?>" title="<?php echo $product_name;?>">
														<img src="<?php echo $mimage1; ?>" />
													</a>
												</div>
												<span class="add_newone">
													<input type="checkbox" id="productimg" name="productimg" value="1" onClick="newimg();" checked="checked"> Want to add a new Image ?
												</span>
												<input type="hidden" name="mimage" value="<?php echo $mimage; ?>">
												<input type="hidden" name="mimage1" value="<?php echo $mimage1; ?>">
												<?php
											}
											else
											{
												?>
												<div id='product_image'>  
													<a class="fancybox" href="<?php echo $pimage; ?>" title="<?php echo $product_name;?>">
														<img src="<?php echo $pimage1; ?>" />
													</a>
												</div>
												<div id="product_image1" style="display:none;"> : <input type="file" name="file" id="file"  /> </div>
												<span class="add_newone">
													<input type="checkbox" id="productimg" name="productimg" value="1" onClick="newimg();"> Want to add a new Image ?
												</span>
												<input type="hidden" name="mimage" value="<?php echo $mimage; ?>">
												<input type="hidden" name="mimage1" value="<?php echo $mimage1; ?>">
												<?php
											}
											?>
									</div>
									<div class="offers1">
										<span class='side_title'> Stock  </span> 
										<span class='side_desc'> : 
											<select name="stock_in">
												<option value=""> Select Stock </option>
												<option value="1" <?php if($stock=="1") { ?> selected="selected" <?php } ?>> Stock in </option>
												<option value="0" <?php if($stock=="0") { ?> selected="selected" <?php } ?>> No Stock </option>
											</select>
										</span>
									</div>
									<div class="offers1">
										<span class='side_title'> Price  </span> 
										<span class='side_desc'> : <input type="text" name="price" value="<?php echo $price; ?>"> price as 0.00 </span>
									</div>
									<div class="offers1">
										<span class='side_title'> Discount Price  </span> 
										<span class='side_desc'> : <input type="text" name="discount_price" value="<?php echo $discount; ?>"> price as 0.00 </span>
									</div>
									<div class="offers1">
										<span class='side_title'> Start Date  </span> 
										<span class='side_desc'> : 
										<?php echo JHTML::_('calendar',$lstart,'listingstart_date','listingstart_date','%Y-%m-%d','size="20",title ="listingstart_date", readonly="readonly"');?>
										</span>
									</div>
									<div class="offers1">
										<span class='side_title'> End Date  </span> 
										<span class='side_desc'> : 
											<?php echo JHTML::_('calendar',$lend,'listingend_date','listingend_date','%Y-%m-%d','size="20",title ="listingend_date", readonly="readonly"');?>
										</span>
									</div>
									<?php
									if($isdeal==1)
									{
										?>
										<div class="offers1">
											<input type="checkbox" name="isdeal" value="1" onClick="showdeal();" checked="checked" /> Is Deal
										</div>
										<div id="showdeal">
											<div class="offers1">
												<span class='side_title'> Deal Price  </span> 
												<span class='side_desc'> : <input type="text" name="deal_price" value="<?php echo $deal; ?>"> price as 0.00 </span>
											</div>													
											<div class="offers1">
												<span class='side_title'> Deal start Date  </span> 
												<span class='side_desc'> : 
													<?php echo JHTML::_('calendar',$dstart,'dealstart_date','dealstart_date','%Y-%m-%d','size="20",title ="dealstart_date", readonly="readonly"');?>
												</span>
											</div>
											<div class="offers1">
												<span class='side_title'> Deal end Date  </span> 
												<span class='side_desc'> : 
													<?php echo JHTML::_('calendar',$dend,'dealend_date','dealend_date','%Y-%m-%d','size="20",title ="dealend_date", readonly="readonly"');?>
												</span>
											</div>
											<div class="offers1">
												<span class='side_title'> Promotion  </span> 
												<span class='side_desc'> : 
													<select name="promotion_type">
														<option value="0"> Select the Promotion Type </option>
														<?php
															foreach($promotions as $row)
															{
															?>
																<option value="<?php echo $row['id']; ?>" <?php if($promotion==$row['id']) { ?> selected="selected" <?php } ?>>
																	<?php echo $row['promotion_type']; ?>
																</option>
																<?php
															}
															?>
													</select>
												</span>
											</div>
										</div>
										<?php
									}
									else
									{
										?>
										<div class="offers1">
											<input type="checkbox" name="isdeal" value="1" onClick="showdeal();" /> Is Deal
										</div>
										<div id="showdeal" style="display:none;">
											<div class="offers1">
												<span class='side_title'> Deal Price  </span> 
												<span class='side_desc'> : <input type="text" name="deal_price" value=""> price as 0.00 </span>
											</div>													
											<div class="offers1">
												<span class='side_title'> Deal start Date  </span> 
												<span class='side_desc'> : 
													<?php echo JHTML::_('calendar',$mydate,'dealstart_date','dealstart_date','%Y-%m-%d','size="20",title ="dealstart_date", readonly="readonly"');?>
												</span>
											</div>
											<div class="offers1">
												<span class='side_title'> Deal end Date  </span> 
												<span class='side_desc'> : 
													<?php echo JHTML::_('calendar',$mydate,'dealend_date','dealend_date','%Y-%m-%d','size="20",title ="dealend_date", readonly="readonly"');?>
												</span>
											</div>
											<div class="offers1">
												<span class='side_title'> Promotion  </span> 
												<span class='side_desc'> : 
													<select name="promotion_type">
														<option value="0"> Select the Promotion Type </option>
														<?php
															foreach($promotions as $row)
															{
															?>
																<option value="<?php echo $row['id']; ?>"><?php echo $row['promotion_type']; ?></option>
																<?php
															}
															?>
													</select>
												</span>
											</div>
										</div>
										<?php
									}
									?>
									<input type="hidden" name="productlist" value="<?php echo $pid1; ?>">									
									<input type="hidden" value="<?php echo $_REQUEST['Itemid']; ?>" name="Itemid" />								
									<div class="submits">
										<input type="submit" name="addlistdeal" value="Add" class="adds" />
										<a href="index.php?option=com_dealcatalog&task=myproductslisting&Itemid=<?php echo $_REQUEST['Itemid']; ?>">
											<input type="button" name="cancellistdeal" value="Cancel" class="adds" />
										</a>
									</div>
								</fieldset>
							</form>
						</div>								
					</div>
				</div>
			</div>
		<?php
		}
		else
		{
			echo "<h1> You don't have the permission to access this page </h1>";
			echo "<p> Please <a href='index.php?option=com_dealcatalog&task=merchantregister&Itemid=".$_REQUEST['Itemid']."'> Register </a> as a Merchant  </p>";
		}
	}
	
	function coupons()
	{
		$user = &JFactory::getUser();
		$userid = $user->id;
		$usertype = $user->usertype;
		$db = &JFactory::getDBO();
		if($usertype=='Merchants' && $userid!=0)
		{
			?>
			<script type="text/javascript" src="components/com_dealcatalog/js/jquery1.7.js"></script>
				<script type="text/javascript" src="components/com_dealcatalog/js/jquery.fancybox.js"></script>		
				<script type="text/javascript" src="components/com_dealcatalog/css/dealcatalog.css"></script>
				<link rel="stylesheet" type="text/css" href="components/com_dealcatalog/js/jquery.fancybox.css" media="screen" />
			<script type="text/javascript">
				$(document).ready(function() {
						$(".fancybox").fancybox();
					});
			</script>
			<div id="merchant_menu">
					<ul>
						<li> <a href="index.php?option=com_dealcatalog&task=merchantdefault&Itemid=<?php echo $_REQUEST['Itemid']; ?>" > DashBoard </a> </li>
						<li> <a href="index.php?option=com_dealcatalog&task=products&Itemid=<?php echo $_REQUEST['Itemid']; ?>" > Products </a> </li>
						<li> <a href="index.php?option=com_dealcatalog&task=addproductslistingdeals&Itemid=<?php echo $_REQUEST['Itemid']; ?>" > Add Products Listing and Deals </a> </li>
						<li> <a href="index.php?option=com_dealcatalog&task=myproductslisting&Itemid=<?php echo $_REQUEST['Itemid']; ?>" > My Products Usage</a> </li>
						<li> <a href="index.php?option=com_dealcatalog&task=coupons&Itemid=<?php echo $_REQUEST['Itemid']; ?>" > My Customers Coupons </a> </li>
					</ul>
			</div>
			<div id="coupons">
				<div class="welcome">
						<?php
							$query = "select company_name from #__deal_merchants where user_id='$userid'";
							$db->setQuery($query);
							$company = $db->loadRow();
							echo "Welcome back ".$company[0];
						?>
				</div>
				<div class="coupons_view">
					<h2> My Customers Coupons </h2>
					<?php
					$query = "select a.id,b.product_id,b.users_userid,b.coupon_code,c.product_name,c.product_image1,c.product_thumbimage1,d.name from jos_deal_merchants as a,jos_deal_coupons as b,jos_deal_products as c,jos_deal_customers as d where a.user_id='$userid' and a.id=b.vendor_id and b.product_id=c.id and b.users_userid=d.users_id";
					$db->setQuery($query);
					$coupons = $db->loadAssocList();
					foreach($coupons as $rows)
					{
						$thumb = substr($rows['product_thumbimage1'], 3);
						$org = substr($rows['product_image1'], 3);
						?>
						<div class="coupons_list">
							<div class="img_views">
								<a class="fancybox" href="<?php echo $org; ?>" title="<?php echo $rows['product_name'];?>">
									<img src="<?php echo $thumb; ?>" />
								</a>
							</div>
							<div class="offer">
										<span class='side_title'> Product Name  </span>
										<span class='side_desc'> :&nbsp;&nbsp;&nbsp;<?php echo $rows['product_name']; ?></span>
							</div>
							<div class="offer">
										<span class='side_title'> Customer Name  </span>
										<span class='side_desc'> :&nbsp;&nbsp;&nbsp;<?php echo $rows['name']; ?></span>
							</div>
							<div class="offer">
										<span class='side_title'> Coupon Code  </span>
										<span class='side_desc'> :&nbsp;&nbsp;&nbsp;<?php echo $rows['coupon_code']; ?></span>
							</div>
						</div>
						<?php
					}
					?>
				</div>
			</div>
		<?php
		}
		else
		{
			echo "<h1> You don't have the permission to access this page </h1>";
			echo "<p> Please <a href='index.php?option=com_dealcatalog&task=merchantregister&Itemid=".$_REQUEST['Itemid']."'> Register </a> as a Merchant  </p>";
		}
	}
	
	function merchantregister()
	{
		?>
		<script type="text/javascript">
			function check_all()
			{
				var form = document.merchantregister;
				if(form.firstname.value.length==0)
				{
					alert('Enter the first name');
					form.firstname.focus();
					return false;
				}
				var first_check = /^[A-Za-z ]{3,20}$/;
				if(form.firstname.value.search(first_check) == -1)
				{
					alert('Only character are allowed and firstname must be greater than 3 characters');
					form.firstname.focus();
					form.firstname.value="";
					return false;
				}
				if(form.username.value.length==0)
				{
					alert('Please Enter the username');
					form.username.focus();
					return false;
				}
				var last_check = /^[A-Za-z0-9]{3,20}$/;
				if(form.username.value.search(last_check) == -1)
				{
					alert('Only characters are allowed and username must be greater than 3 characters ');
					form.username.focus();
					form.username.value="";
					return false;
				}
				if(form.pass.value.length==0)
				{
					alert('Please Enter the password');
					form.pass.focus();
					return false;
				}
				if(form.company_name.value.length==0)
				{
					alert('Please Enter your Company name');
					form.company_name.focus();
					return false;
				}
				var com_check = /^[A-Za-z ]{1,50}$/;
				if(form.company_name.value.search(com_check) == -1)
				{
					alert('Only Characters are allowed and more than 1 characters');
					form.company_name.focus();
					form.company_name.value="";
					return false;
				}
				if(form.address1.value.length==0)
				{
					alert('Please Enter your address');
					form.address1.focus();
					return false;
				}
				if(form.city.value.length==0)
				{
					alert('Please Enter your City');
					form.city.focus();
					return false;
				}
				var city_check = /^[A-Za-z ]{1,50}$/;
				if(form.city.value.search(city_check) == -1)
				{
					alert('Only Characters are allowed and more than 1 characters');
					form.city.focus();
					form.city.value="";
					return false;
				}
				if(form.states.value.length==0)
				{
					alert('Please Enter Your state');
					form.states.focus();
					return false;
				}
				if(form.Contact_number.value.length==0)
				{
					alert('Please Enter the Contact number');
					form.Contact_number.focus();
					return false;
				}
				var contact_check = /^[0-9+ ]{6,20}$/;
				if(form.Contact_number.value.search(contact_check) == -1)
				{
					alert('Only number are allowed');
					form.Contact_number.focus();
					form.Contact_number.value="";
					return false;
				}
				if(form.email_id.value.length==0)
				{
					alert('Please Enter the Email id');
					form.email_id.focus();
					return false;
				}
				var email_check = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
				if(form.email_id.value.search(email_check) == -1)
				{
					alert('Email Id not Valid');
					form.email_id.focus();
					form.email_id.value="";
					return false;
				}
				return true;
			}
		</script>
		<div id="customer_register">
			<div> <h2> New Merchant Register this form </h2> </div>
			<form name="merchantregister" action="index.php?option=com_dealcatalog&task=merchantsave" method="post" onSubmit="return check_all();">
				<fieldset>
					<legend> Sign-In </legend>
						<div class="details_title3">
							First Name
						</div>
						<div class="details_names3">
							<input type="text" name="firstname" value="">
						</div>
						<div class="details_title3">
							Last Name
						</div>
						<div class="details_names3">
							<input type="text" name="lastname" value="">
						</div>
						<div class="details_title3">
							User Name
						</div>
						<div class="details_names3">
							<input type="text" name="username" value="">
						</div>
						<div class="details_title3">
							Password
						</div>
						<div class="details_names3">
							<input type="password" name="pass" value="">
						</div>
						<div class="details_title3">
							Company name
						</div>
						<div class="details_names3">
							<input type="text" name="company_name" value="" class="text_input" size=""/>
						</div>						
						<div class="details_title3">
							Address 1
						</div>
						<div class="details_names3">
							<input type="text" name="address1" value="">
						</div>
						<div class="details_title3">
							Address 2
						</div>
						<div class="details_names3">
							<input type="text" name="address2" value="">
						</div>
						<div class="details_title3">
							City
						</div>
						<div class="details_names3">
							<input type="text" name="city" value="">
						</div>
						<div class="details_title3">
							State
						</div>
						<div class="details_names3">
							<input type="text" name="states" value="">
						</div>
						<div class="details_title3">
							Contact Number
						</div>
						<div class="details_names3">
							<input type="text" name="Contact_number" value="">
						</div>
						<div class="details_title3">
							Email-Id
						</div>
						<div class="details_names3">
							<input type="text" name="email_id" value="">
						</div>
						<div class="location1">
							<div class="details_title31">
								Location Map
							</div>
							<div class="details_names32">
								<textarea name="location_map" rows="7" cols="50"></textarea>
							</div>
						</div>
						<input type="hidden" name="Itemid" value="<?php echo $_REQUEST['Itemid']; ?>">
						<div class="submits"> <input type="submit" value="Register" name="customerregister" class="adds"> </div>
				</fieldset>
			</form>
		</div>
		<?php
	}
	
}
?>