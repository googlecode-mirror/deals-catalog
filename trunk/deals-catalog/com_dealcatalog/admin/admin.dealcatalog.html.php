<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

class DealCatalogHTML {

	//Default View
	function cpanel()
	{
		echo "Welcome to Deal catalog";
	}
	
	//Merchant Users list
	function merchantlist(&$rows, &$pageNav, &$lists)
	{
		JHTML::_('behavior.tooltip');
		echo "Merchants Users List View "; 
		?>
		<form action="index.php?option=com_dealcatalog&task=merchant" method="post" name="adminForm"> 
    
			<table>
				<tr>
					<td align="left" width="100%">
						<?php echo JText::_( 'Filter' ); ?>:
						<input type="text" name="search" id="search" value="<?php echo $lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
						<button onclick="this.form.submit();">
						<?php echo JText::_( 'Go' ); ?></button>
						<button onclick="document.getElementById('search').value='';this.form.submit();">
						<?php echo JText::_( 'Reset' ); ?></button>
					</td>
				</tr>
			</table>       
       
			<table class="adminlist">
				<thead>
					<tr>
						<th width="20">
						<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows)?>)">
						</th>
						<th width="50" class="title"><?php echo JHTML::_('grid.sort',   'ID', 'id', @$lists['order_Dir'], @$lists['order'] ); ?></td>
						<th>Company Name</th>
						<th>User Name</th>
						<th>Address</th>
						<th>Contact number</th>
						<th>Email-Id</th>
						<th>Approved</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="11">
						 <?php echo $pageNav->getListFooter(); ?>
						</td>
					</tr>
				</tfoot>
				<?php
				$k = 0;
				for($i=0, $n=count($rows); $i < $n ; $i++)
				{
					$row = &$rows[$i];
					$checked 	= JHTML::_('grid.id', $i, $row->id);
					$link = JRoute::_( 'index.php?option=com_dealcatalog&task=merchantedit&cid[]='.$row->id );

					//$published 	= JHTML::_('grid.published', $row, $i); 
					?>
					<tr class="<?php echo "row$k"; ?>">
						<td><?php echo $checked; ?></td>
						<td><a href="<?php echo $link; ?>"><?php echo $row->id; ?></a></td>
						<td><a href="<?php echo $link; ?>"><?php echo $row->company_name; ?></a></td>
						<td><?php echo $row->username; ?></td>     
						<?php 	$address = $row->address1.",".$row->address2.",".$row->city.",".$row->states; ?>
						<td><?php echo $address; ?></td>
						<td><?php echo $row->Contact_number; ?></td>
						<td><?php echo $row->email_id; ?></td>
						<td><?php echo $row->approved; ?></td>
					</tr>
					<?php
					$k = 1 - $k;
				}
				?>
			</table>
			<input type="hidden" name="option" value="com_dealcatalog">
			<input type="hidden" name="task" value="merchant">    
			<input type="hidden" name="boxchecked" value="0"> 
			<input type="hidden" name="filter_order" value="<?php echo $lists['order']; ?>" />
			<input type="hidden" name="filter_order_Dir" value="" />    
		</form>
		<?php 
	}
	
	function merchantinsert()
	{
		echo "merchant insert";
		JRequest::setVar( 'hidemainmenu', 1 );
		?>
		<script language="javascript" type="text/javascript">
		<!--
			function approve()
			{
				if (document.adminForm.approval.checked==true)
				{
					document.getElementById('approved').value=1;
				}
				else
				{
					document.getElementById('approved').value=0;
				}
			}
			
			function submitbutton(pressbutton) 
			{
				var form = document.adminForm;
				if (pressbutton == 'merchant')
				{
					submitform( pressbutton );
					return;
				}
				if(form.firstname.value.length==0)
				{
					alert('Please Enter the first name');
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
				if(form.password.value.length==0)
				{
					alert('Please Enter the password');
					form.password.focus();
					return false;
				}
				if(form.repassword.value.length==0)
				{
					alert('Please Enter the Re-Password');
					form.repassword.focus();
					return false;
				}
				var pass1 = form.password.value;
				var pass2 = form.repassword.value;
				if(pass1!=pass2)
				{
					alert('Please Enter the correct password');
					form.repassword.focus();
					form.repassword.value="";
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
				
				submitform( pressbutton );
			}
		//-->
		</script>
		<form action="index.php?option=com_dealcatalog&task=merchant" method="post" name="adminForm">
			<table class="admintable">
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'First Name' ); ?>:
						</label>
					</td>
					<td >
						<input type="text" name="firstname" value="" class="text_input" size="60"/>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Last Name' ); ?>:
						</label>
					</td>
					<td >
						<input type="text" name="lastname" value="" class="text_input" size="60"/>
					</td>
				</tr>
                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'User Name' ); ?>:
						</label>
					</td>
					<td >
						<input type="text" name="username" value="" class="text_input" size="60" />
					</td>
				</tr>
                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Password' ); ?>:
						</label>
					</td>
					<td >
						<input type="password" name="password" value="" class="text_input" size="60"/>
					</td>
				</tr>
                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Re-Enter Password' ); ?>:
						</label>
					</td>
					<td >
						<input type="password" name="repassword" value="" class="text_input" size="60"/>
					</td>
				</tr>				
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Company Name' ); ?>:
						</label>
					</td>
					<td >
						<input type="text" name="company_name" value="" class="text_input" size=""/>
					</td>
				</tr>
                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Address 1' ); ?>:
						</label>
					</td>
					<td >
						<input type="text" name="address1" value="" class="text_input" size="60"/>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Address 2' ); ?>:
						</label>
					</td>
					<td >
						<input type="text" name="address2" value="" class="text_input" size="60"/>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'City' ); ?>:
						</label>
					</td>
					<td >
						<input type="text" name="city" value="" class="text_input" size="60"/>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'State' ); ?>:
						</label>
					</td>
					<td >
						<input type="text" name="states" value="" class="text_input" size="60"/>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Contact number' ); ?>:
						</label>
					</td>
					<td >
						<input type="text" name="Contact_number" value="" class="text_input" size="40" maxlength="14"/>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Email Id' ); ?>:
						</label>
					</td>
					<td >
						<input type="text" name="email_id" value="" class="text_input" size="60"/>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Location Map' ); ?>:
						</label>
					</td>
					<td >
						<textarea name="location_map" rows="8" cols="60"></textarea>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Approved' ); ?>:
						</label>
					</td>
					<td >
						<input type="checkbox" name="approval" id="check" onclick="approve();" />
						<input type="hidden" name="approved" id="approved" value="0">
					</td>
				</tr>
            </table>        
			<input type="hidden" name="option" value="com_dealcatalog" />
			<input type="hidden" name="task" value="merchant" />        
        </form>
		<?php
	}
	
	//Editing the user of merchant
	function merchantedit(&$row)
	{
		JRequest::setVar( 'hidemainmenu', 1 );
		?>
		<script language="javascript" type="text/javascript">
		<!--
			function approve()
			{
				if (document.adminForm.approval.checked==true)
				{
					document.getElementById('approved').value=1;
				}
				else
				{
					document.getElementById('approved').value=0;
				}
			}
			
			function submitbutton(pressbutton) 
			{
				var form = document.adminForm;
				if (pressbutton == 'merchant')
				{
					submitform( pressbutton );
					return;
				}
				if(form.firstname.value.length==0)
				{
					alert('Please Enter the first name');
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
				if(form.password.value.length==0)
				{
					alert('Please Enter the password');
					form.password.focus();
					return false;
				}
				if(form.repassword.value.length==0)
				{
					alert('Please Enter the Re-Password');
					form.repassword.focus();
					return false;
				}
				var pass1 = form.password.value;
				var pass2 = form.repassword.value;
				if(pass1!=pass2)
				{
					alert('Please Enter the correct password');
					form.repassword.focus();
					form.repassword.value="";
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
				
				submitform( pressbutton );
			}
		//-->
		</script>
			<form action="index.php?option=com_dealcatalog&task=merchant" method="post" name="adminForm">
				<table class="admintable">
					<tr>
						<td class="key">
							<label for="name">
								<?php echo JText::_( 'First Name' ); ?>:
							</label>
						</td>
						<td >
							<input type="text" name="firstname" value="<?php echo $row->firstname; ?>" class="text_input" size="60"/>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="name">
								<?php echo JText::_( 'Last Name' ); ?>:
							</label>
						</td>
						<td >
							<input type="text" name="lastname" value="<?php echo $row->lastname; ?>" class="text_input" size="60"/>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="name">
								<?php echo JText::_( 'User Name' ); ?>:
							</label>
						</td>
						<td >
							<input type="text" name="username" value="<?php echo $row->username; ?>" class="text_input" size="60" />
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="name">
								<?php echo JText::_( 'Password' ); ?>:
							</label>
						</td>
						<td >
							<input type="password" name="password" value="" class="text_input" size="60"/>
						</td>
						<td>
							 <b> <span style="color:red;">Please Type the same password or another new password </b>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="name">
								<?php echo JText::_( 'Re-Enter Password' ); ?>:
							</label>
						</td>
						<td >
							<input type="password" name="repassword" value="" class="text_input" size="60"/>
						</td>
					</tr>
					<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Company Name' ); ?>:
						</label>
					</td>
					<td >
						<input type="text" name="company_name" value="<?php echo $row->company_name; ?>" class="text_input" size="60"/>
					</td>
				</tr>
					<tr>
						<td class="key">
							<label for="name">
								<?php echo JText::_( 'Address 1' ); ?>:
							</label>
						</td>
						<td >
							<input type="text" name="address1" value="<?php echo $row->address1; ?>" class="text_input" size="60"/>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="name">
								<?php echo JText::_( 'Address 2' ); ?>:
							</label>
						</td>
						<td >
							<input type="text" name="address2" value="<?php echo $row->address2; ?>" class="text_input" size="60"/>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="name">
								<?php echo JText::_( 'City' ); ?>:
							</label>
						</td>
						<td >
							<input type="text" name="city" value="<?php echo $row->city; ?>" class="text_input" size="60"/>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="name">
								<?php echo JText::_( 'State' ); ?>:
							</label>
						</td>
						<td >
							<input type="text" name="states" value="<?php echo $row->states; ?>" class="text_input" size="60"/>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="name">
								<?php echo JText::_( 'Contact number' ); ?>:
							</label>
						</td>
						<td >
							<input type="text" name="Contact_number" value="<?php echo $row->Contact_number; ?>" class="text_input" size="40" maxlength="14"/>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="name">
								<?php echo JText::_( 'Email Id' ); ?>:
							</label>
						</td>
						<td >
							<input type="text" name="email_id" value="<?php echo $row->email_id; ?>" class="text_input" size="60"/>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="name">
								<?php echo JText::_( 'Location Map' ); ?>:
							</label>
						</td>
						<td >
							<textarea name="location_map" rows="8" cols="60"><?php echo $row->location_map; ?></textarea>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="name">
								<?php echo JText::_( 'Approved' ); ?>:
							</label>
						</td>
						<td >
							<?php 
								$approve = $row->approved; 
								if($approve==1)
								{
								?>
									<input type="checkbox" checked="checked" name="approval" id="check" onclick="approve();" />
								<?php
								}
								else
								{
								?>
									<input type="checkbox" name="approval" id="check" onclick="approve();" />
								<?php
								}
							?>
							<input type="hidden" name="approved" id="approved" value="<?php echo $approve; ?>">
						</td>	
					</tr>
				</table>     
				<input type="hidden" name="user_id" value="<?php echo $row->user_id; ?>" />
				<input type="hidden" name="option" value="com_dealcatalog" />
				<input type="hidden" name="task" value="merchant" /> 
				<input type="hidden" name="id" value="<?php echo $row->id?>" />        
				<input type="hidden" name="cid[]" value="<?php echo $row->id; ?>" /> 				
			</form>
		<?php
	}

	//Customer Users list
	function customerslist(&$rows, &$pageNav, &$lists)
	{
		JHTML::_('behavior.tooltip');
		echo "Customers Users List View "; 
		?>
		<form action="index.php?option=com_dealcatalog&task=customers" method="post" name="adminForm"> 
    
			<table>
				<tr>
					<td align="left" width="100%">
						<?php echo JText::_( 'Filter' ); ?>:
						<input type="text" name="search" id="search" value="<?php echo $lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
						<button onclick="this.form.submit();">
						<?php echo JText::_( 'Go' ); ?></button>
						<button onclick="document.getElementById('search').value='';this.form.submit();">
						<?php echo JText::_( 'Reset' ); ?></button>
					</td>
				</tr>
			</table>       
       
			<table class="adminlist">
				<thead>
					<tr>
						<th width="20">
						<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows)?>)">
						</th>
						<th width="50" class="title"><?php echo JHTML::_('grid.sort',   'ID', 'id', @$lists['order_Dir'], @$lists['order'] ); ?></td>
						<th>User Id</th>
						<th>Name</th>
						<th>User Name</th>
						<th>Address</th>
						<th>Contact number</th>
						<th>Email-Id</th>
						<th>Approved</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="11">
						 <?php echo $pageNav->getListFooter(); ?>
						</td>
					</tr>
				</tfoot>
				<?php
				$k = 0;
				for($i=0, $n=count($rows); $i < $n ; $i++)
				{
					$row = &$rows[$i];
					$checked 	= JHTML::_('grid.id', $i, $row->id);
					$link = JRoute::_( 'index.php?option=com_dealcatalog&task=customersedit&cid[]='.$row->id );

					//$published 	= JHTML::_('grid.published', $row, $i); 
					?>
					<tr class="<?php echo "row$k"; ?>">
						<td><?php echo $checked; ?></td>
						<td><a href="<?php echo $link; ?>"><?php echo $row->id; ?></a></td>
						<td><a href="<?php echo $link; ?>"><?php echo $row->users_id; ?></a></td>
						<td><a href="<?php echo $link; ?>"><?php echo $row->firstname.$row->lastname; ?></a></td>
						<td><?php echo $row->username; ?></td>     
						<?php 	$address = $row->address1.",".$row->address2.",".$row->city.",".$row->state; ?>
						<td><?php echo $address; ?></td>
						<td><?php echo $row->Contact_number; ?></td>
						<td><?php echo $row->email_id; ?></td>
						<td><?php echo $row->approved; ?></td>
					</tr>
					<?php
					$k = 1 - $k;
				}
				?>
			</table>
			<input type="hidden" name="option" value="com_dealcatalog">
			<input type="hidden" name="task" value="customers">    
			<input type="hidden" name="boxchecked" value="0"> 
			<input type="hidden" name="filter_order" value="<?php echo $lists['order']; ?>" />
			<input type="hidden" name="filter_order_Dir" value="" />    
		</form>
		<?php 
	}
	
	//New user for customers
	function customersinsert()
	{
		echo "customer insert";
		JRequest::setVar( 'hidemainmenu', 1 );
		?>
		<script language="javascript" type="text/javascript">
		<!--
			function approve()
			{
				if (document.adminForm.approval.checked==true)
				{
					document.getElementById('approved').value=1;
				}
				else
				{
					document.getElementById('approved').value=0;
				}
			}
			
			function submitbutton(pressbutton) 
			{
				var form = document.adminForm;
				if (pressbutton == 'customers')
				{
					submitform( pressbutton );
					return;
				}
				if(form.firstname.value.length==0)
				{
					alert('Please Enter the first name');
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
				if(form.password.value.length==0)
				{
					alert('Please Enter the password');
					form.password.focus();
					return false;
				}
				if(form.repassword.value.length==0)
				{
					alert('Please Enter the Re-Password');
					form.repassword.focus();
					return false;
				}
				var pass1 = form.password.value;
				var pass2 = form.repassword.value;
				if(pass1!=pass2)
				{
					alert('Please Enter the correct password');
					form.repassword.focus();
					form.repassword.value="";
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
				
				submitform( pressbutton );
			}
		//-->
		</script>
		<form action="index.php?option=com_dealcatalog&task=customers" method="post" name="adminForm">
			<table class="admintable">
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'First Name' ); ?>:
						</label>
					</td>
					<td >
						<input type="text" name="firstname" value="" class="text_input" size="60"/>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Last Name' ); ?>:
						</label>
					</td>
					<td >
						<input type="text" name="lastname" value="" class="text_input" size="60"/>
					</td>
				</tr>
                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'User Name' ); ?>:
						</label>
					</td>
					<td >
						<input type="text" name="username" value="" class="text_input" size="60" />
					</td>
				</tr>
                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Password' ); ?>:
						</label>
					</td>
					<td >
						<input type="password" name="password" value="" class="text_input" size="60"/>
					</td>
				</tr>
                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Re-Enter Password' ); ?>:
						</label>
					</td>
					<td >
						<input type="password" name="repassword" value="" class="text_input" size="60"/>
					</td>
				</tr>
                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Address 1' ); ?>:
						</label>
					</td>
					<td >
						<input type="text" name="address1" value="" class="text_input" size="60"/>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Address 2' ); ?>:
						</label>
					</td>
					<td >
						<input type="text" name="address2" value="" class="text_input" size="60"/>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'City' ); ?>:
						</label>
					</td>
					<td >
						<input type="text" name="city" value="" class="text_input" size="60"/>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'State' ); ?>:
						</label>
					</td>
					<td >
						<input type="text" name="states" value="" class="text_input" size="60"/>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Contact number' ); ?>:
						</label>
					</td>
					<td >
						<input type="text" name="Contact_number" value="" class="text_input" size="40" maxlength="14"/>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Email Id' ); ?>:
						</label>
					</td>
					<td >
						<input type="text" name="email_id" value="" class="text_input" size="60"/>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Approved' ); ?>:
						</label>
					</td>
					<td >
						<input type="checkbox" name="approval" id="check" onclick="approve();" />
						<input type="hidden" name="approved" id="approved" value="0">
					</td>
				</tr>
            </table>        
			<input type="hidden" name="option" value="com_dealcatalog" />
			<input type="hidden" name="task" value="customers" />        
        </form>
		<?php
	}
	
	//Editing the user of customers
	function customersedit(&$row)
	{
		JRequest::setVar( 'hidemainmenu', 1 );
		?>
		<script language="javascript" type="text/javascript">
		<!--
			function approve()
			{
				if (document.adminForm.approval.checked==true)
				{
					document.getElementById('approved').value=1;
				}
				else
				{
					document.getElementById('approved').value=0;
				}
			}
			
			function submitbutton(pressbutton) 
			{
				var form = document.adminForm;
				if (pressbutton == 'customers')
				{
					submitform( pressbutton );
					return;
				}
				if(form.firstname.value.length==0)
				{
					alert('Please Enter the first name');
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
				if(form.password.value.length==0)
				{
					alert('Please Enter the password');
					form.password.focus();
					return false;
				}
				if(form.repassword.value.length==0)
				{
					alert('Please Enter the Re-Password');
					form.repassword.focus();
					return false;
				}
				var pass1 = form.password.value;
				var pass2 = form.repassword.value;
				if(pass1!=pass2)
				{
					alert('Please Enter the correct password');
					form.repassword.focus();
					form.repassword.value="";
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
				
				submitform( pressbutton );
			}
		//-->
		</script>
			<form action="index.php?option=com_dealcatalog&task=customers" method="post" name="adminForm">
				<table class="admintable">
					<tr>
						<td class="key">
							<label for="name">
								<?php echo JText::_( 'First Name' ); ?>:
							</label>
						</td>
						<td >
							<input type="text" name="firstname" value="<?php echo $row->firstname; ?>" class="text_input" size="60"/>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="name">
								<?php echo JText::_( 'Last Name' ); ?>:
							</label>
						</td>
						<td >
							<input type="text" name="lastname" value="<?php echo $row->lastname; ?>" class="text_input" size="60"/>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="name">
								<?php echo JText::_( 'User Name' ); ?>:
							</label>
						</td>
						<td >
							<input type="text" name="username" value="<?php echo $row->username; ?>" class="text_input" size="60" />
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="name">
								<?php echo JText::_( 'Password' ); ?>:
							</label>
						</td>
						<td >
							<input type="password" name="password" value="" class="text_input" size="60"/>
						</td>
						<td>
							 <b> <span style="color:red;">Please Type the same password or another new password </b>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="name">
								<?php echo JText::_( 'Re-Enter Password' ); ?>:
							</label>
						</td>
						<td >
							<input type="password" name="repassword" value="" class="text_input" size="60"/>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="name">
								<?php echo JText::_( 'Address 1' ); ?>:
							</label>
						</td>
						<td >
							<input type="text" name="address1" value="<?php echo $row->address1; ?>" class="text_input" size="60"/>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="name">
								<?php echo JText::_( 'Address 2' ); ?>:
							</label>
						</td>
						<td >
							<input type="text" name="address2" value="<?php echo $row->address2; ?>" class="text_input" size="60"/>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="name">
								<?php echo JText::_( 'City' ); ?>:
							</label>
						</td>
						<td >
							<input type="text" name="city" value="<?php echo $row->city; ?>" class="text_input" size="60"/>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="name">
								<?php echo JText::_( 'State' ); ?>:
							</label>
						</td>
						<td >
							<input type="text" name="states" value="<?php echo $row->state; ?>" class="text_input" size="60"/>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="name">
								<?php echo JText::_( 'Contact number' ); ?>:
							</label>
						</td>
						<td >
							<input type="text" name="Contact_number" value="<?php echo $row->Contact_number; ?>" class="text_input" size="40" maxlength="14"/>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="name">
								<?php echo JText::_( 'Email Id' ); ?>:
							</label>
						</td>
						<td >
							<input type="text" name="email_id" value="<?php echo $row->email_id; ?>" class="text_input" size="60"/>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="name">
								<?php echo JText::_( 'Approved' ); ?>:
							</label>
						</td>
						<td >
							<?php 
								$approve = $row->approved; 
								if($approve==1)
								{
								?>
									<input type="checkbox" checked="checked" name="approval" id="check" onclick="approve();" />
								<?php
								}
								else
								{
								?>
									<input type="checkbox" name="approval" id="check" onclick="approve();" />
								<?php
								}
							?>
							<input type="hidden" name="approved" id="approved" value="<?php echo $approve; ?>">
						</td>	
					</tr>
				</table>     
				<input type="hidden" name="user_id" value="<?php echo $row->users_id; ?>" />
				<input type="hidden" name="option" value="com_dealcatalog" />
				<input type="hidden" name="task" value="customers" /> 
				<input type="hidden" name="id" value="<?php echo $row->id?>" />        
				<input type="hidden" name="cid[]" value="<?php echo $row->id; ?>" /> 				
			</form>
		<?php
	}
	
	//Product categories Users list
	function categories(&$rows, &$pageNav, &$lists)
	{
		JHTML::_('behavior.tooltip');
		echo "product categories View "; 
		?>
		<form action="index.php?option=com_dealcatalog&task=categories" method="post" name="adminForm"> 
    
			<table>
				<tr>
					<td align="left" width="100%">
						<?php echo JText::_( 'Filter' ); ?>:
						<input type="text" name="search" id="search" value="<?php echo $lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
						<button onclick="this.form.submit();">
						<?php echo JText::_( 'Go' ); ?></button>
						<button onclick="document.getElementById('search').value='';this.form.submit();">
						<?php echo JText::_( 'Reset' ); ?></button>
					</td>
				</tr>
			</table>       
       
			<table class="adminlist">
				<thead>
					<tr>
						<th width="20">
						<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows)?>)">
						</th>
						<th width="50" class="title"><?php echo JHTML::_('grid.sort',   'ID', 'id', @$lists['order_Dir'], @$lists['order'] ); ?></td>
						<th>Category Name</th>
						<th>Category Description</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="11">
						 <?php echo $pageNav->getListFooter(); ?>
						</td>
					</tr>
				</tfoot>
				<?php
				$k = 0;
				for($i=0, $n=count($rows); $i < $n ; $i++)
				{
					$row = &$rows[$i];
					$checked 	= JHTML::_('grid.id', $i, $row->id);
					$link = JRoute::_( 'index.php?option=com_dealcatalog&task=categoriesedit&cid[]='.$row->id );

					//$published 	= JHTML::_('grid.published', $row, $i); 
					?>
					<tr class="<?php echo "row$k"; ?>">
						<td><?php echo $checked; ?></td>
						<td><a href="<?php echo $link; ?>"><?php echo $row->id; ?></a></td>
						<td><a href="<?php echo $link; ?>"><?php echo $row->category_name; ?></a></td>
						<td><?php echo $row->category_desc; ?></td>
					</tr>
					<?php
					$k = 1 - $k;
				}
				?>
			</table>
			<input type="hidden" name="option" value="com_dealcatalog">
			<input type="hidden" name="task" value="categories">    
			<input type="hidden" name="boxchecked" value="0"> 
			<input type="hidden" name="filter_order" value="<?php echo $lists['order']; ?>" />
			<input type="hidden" name="filter_order_Dir" value="" />    
		</form>
		<?php 
	}
	
	function categoriesinsert()
	{
		JRequest::setVar( 'hidemainmenu', 1 );
		?>
			<script language="javascript" type="text/javascript">
			<!--
				function submitbutton(pressbutton) {
					var form = document.adminForm;
					if (pressbutton == 'categories') {
						submitform( pressbutton );
						return;
					}
					if(form.category_name.value.length==0)
					{
						alert('Please Enter the product Category name');
						form.category_name.focus();
						return false;
					}
					var category_name1 = /^[A-Za-z ]{1,50}$/;
					if(form.category_name.value.search(category_name1) == -1)
					{
						alert('Only Characters are allowed');
						form.category_name.focus();
						form.category_name.value="";
						return false;
					}
					submitform( pressbutton );
				}				
			//-->
			</script>  
			<form action="index.php?option=com_dealcatalog&task=categories" method="post" name="adminForm">
				<table class="admintable">
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Category name' ); ?>:
							</label>
						</td>
						<td >
							<input type="text" name="category_name" value="" class="text_input"/>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Category description' ); ?>:
							</label>
						</td>
						<td >
							<textarea name="category_desc" rows="8" cols="60"></textarea>
						</td>
					</tr>
				</table>
				<input type="hidden" name="option" value="com_dealcatalog" />
				<input type="hidden" name="task" value="categories" />    
			</form>
		<?php
	}
	
	//Edit product categories
	function categoriesedit(&$row)
	{
		JRequest::setVar( 'hidemainmenu', 1 );
		?>
			<script language="javascript" type="text/javascript">
			<!--
				function submitbutton(pressbutton) {
					var form = document.adminForm;
					if (pressbutton == 'categories') {
						submitform( pressbutton );
						return;
					}
					if(form.category_name.value.length==0)
					{
						alert('Please Enter the product Category name');
						form.category_name.focus();
						return false;
					}
					var category_name1 = /^[A-Za-z ]{1,50}$/;
					if(form.category_name.value.search(category_name1) == -1)
					{
						alert('Only Characters are allowed');
						form.category_name.focus();
						form.category_name.value="";
						return false;
					}
					submitform( pressbutton );
				}				
			//-->
			</script>
			<form action="index.php?option=com_dealcatalog&task=categories" method="post" name="adminForm">
				<table class="admintable">
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Category name' ); ?>:
							</label>
						</td>
						<td >
							<input type="text" name="category_name" value="<?php echo $row->category_name; ?>" class="text_input"/>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Category description' ); ?>:
							</label>
						</td>
						<td >
							<textarea name="category_desc" rows="8" cols="60"><?php echo $row->category_desc; ?></textarea>
						</td>
					</tr>
				</table>
				<input type="hidden" name="option" value="com_dealcatalog" />
				<input type="hidden" name="task" value="categories" /> 
				<input type="hidden" name="id" value="<?php echo $row->id?>" />        
				<input type="hidden" name="cid[]" value="<?php echo $row->id; ?>" />
			</form>
		<?php
	}
	
	//Product Manufacturers list
	function manufacturers(&$rows, &$pageNav, &$lists)
	{
		JHTML::_('behavior.tooltip');
		echo "product manufacturers View "; 
		?>
		<form action="index.php?option=com_dealcatalog&task=manufacturers" method="post" name="adminForm"> 
    
			<table>
				<tr>
					<td align="left" width="100%">
						<?php echo JText::_( 'Filter' ); ?>:
						<input type="text" name="search" id="search" value="<?php echo $lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
						<button onclick="this.form.submit();">
						<?php echo JText::_( 'Go' ); ?></button>
						<button onclick="document.getElementById('search').value='';this.form.submit();">
						<?php echo JText::_( 'Reset' ); ?></button>
					</td>
				</tr>
			</table>       
       
			<table class="adminlist">
				<thead>
					<tr>
						<th width="20">
						<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows)?>)">
						</th>
						<th width="50" class="title"><?php echo JHTML::_('grid.sort',   'ID', 'id', @$lists['order_Dir'], @$lists['order'] ); ?></td>
						<th>Manufacturers name</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="11">
						 <?php echo $pageNav->getListFooter(); ?>
						</td>
					</tr>
				</tfoot>
				<?php
				$k = 0;
				for($i=0, $n=count($rows); $i < $n ; $i++)
				{
					$row = &$rows[$i];
					$checked 	= JHTML::_('grid.id', $i, $row->id);
					$link = JRoute::_( 'index.php?option=com_dealcatalog&task=manufacturersedit&cid[]='.$row->id );

					//$published 	= JHTML::_('grid.published', $row, $i); 
					?>
					<tr class="<?php echo "row$k"; ?>">
						<td><?php echo $checked; ?></td>
						<td><a href="<?php echo $link; ?>"><?php echo $row->id; ?></a></td>
						<td><a href="<?php echo $link; ?>"><?php echo $row->manufacturer_name; ?></a></td>
					</tr>
					<?php
					$k = 1 - $k;
				}
				?>
			</table>
			<input type="hidden" name="option" value="com_dealcatalog">
			<input type="hidden" name="task" value="manufacturers">    
			<input type="hidden" name="boxchecked" value="0"> 
			<input type="hidden" name="filter_order" value="<?php echo $lists['order']; ?>" />
			<input type="hidden" name="filter_order_Dir" value="" />    
		</form>
		<?php 
	}
	
	function manufacturersinsert()
	{
		JRequest::setVar( 'hidemainmenu', 1 );
		?>
			<script language="javascript" type="text/javascript">
			<!--
				function submitbutton(pressbutton) {
					var form = document.adminForm;
					if (pressbutton == 'manufacturers') {
						submitform( pressbutton );
						return;
					}
					if(form.manufacturer_name.value.length==0)
					{
						alert('Please Enter the product manufacturer name');
						form.manufacturer_name.focus();
						return false;
					}
					var manufacturer_name1 = /^[A-Za-z ]{1,50}$/;
					if(form.manufacturer_name.value.search(manufacturer_name1) == -1)
					{
						alert('Only Characters are allowed');
						form.manufacturer_name.focus();
						form.manufacturer_name.value="";
						return false;
					}
					submitform( pressbutton );
				}				
			//-->
			</script>  
			<form action="index.php?option=com_dealcatalog&task=manufacturers" method="post" name="adminForm">
				<table class="admintable">
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Manufacturer name' ); ?>:
							</label>
						</td>
						<td >
							<input type="text" name="manufacturer_name" value="" class="text_input"/>
						</td>
					</tr>
				</table>
				<input type="hidden" name="option" value="com_dealcatalog" />
				<input type="hidden" name="task" value="manufacturers" />    
			</form>
		<?php
	}
	
	function manufacturersedit(&$row)
	{
		JRequest::setVar( 'hidemainmenu', 1 );
		?>
			<script language="javascript" type="text/javascript">
			<!--
				function submitbutton(pressbutton) {
					var form = document.adminForm;
					if (pressbutton == 'manufacturers') {
						submitform( pressbutton );
						return;
					}
					if(form.manufacturer_name.value.length==0)
					{
						alert('Please Enter the product manufacturer name');
						form.manufacturer_name.focus();
						return false;
					}
					var manufacturer_name1 = /^[A-Za-z ]{1,50}$/;
					if(form.manufacturer_name.value.search(manufacturer_name1) == -1)
					{
						alert('Only Characters are allowed');
						form.manufacturer_name.focus();
						form.manufacturer_name.value="";
						return false;
					}
					submitform( pressbutton );
				}				
			//-->
			</script>  
			<form action="index.php?option=com_dealcatalog&task=manufacturers" method="post" name="adminForm">
				<table class="admintable">
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Manufacturer name' ); ?>:
							</label>
						</td>
						<td >
							<input type="text" name="manufacturer_name" value="<?php echo $row->manufacturer_name; ?>" class="text_input"/>
						</td>
					</tr>
				</table>
				<input type="hidden" name="option" value="com_dealcatalog" />
				<input type="hidden" name="task" value="manufacturers" /> 
				<input type="hidden" name="id" value="<?php echo $row->id?>" />        
				<input type="hidden" name="cid[]" value="<?php echo $row->id; ?>" />
			</form>
		<?php
	}
	
	//Products list
	function products(&$rows, &$pageNav, &$lists)
	{
		JHTML::_('behavior.tooltip');
		echo "products List View "; 
		?>
		<form action="index.php?option=com_dealcatalog&task=products" method="post" name="adminForm" >     
			<table>
				<tr>
					<td align="left" width="100%">
						<?php echo JText::_( 'Filter' ); ?>:
						<input type="text" name="search" id="search" value="<?php echo $lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
						<button onclick="this.form.submit();">
						<?php echo JText::_( 'Go' ); ?></button>
						<button onclick="document.getElementById('search').value='';this.form.submit();">
						<?php echo JText::_( 'Reset' ); ?></button> 
						<?php echo JText::_( 'Category' ); ?>:
						<select name="category" id="category" onChange="document.adminForm.submit();">
							<option selected="selected" value=""> Select Category </option>
							<?php
								$db = &JFactory::getDBO();
								$query = "select id,category_name from #__deal_productcategories";
								$db->setQuery($query);
								$result = $db->loadAssocList();
								foreach($result as $row1)
								{
									?>
									<option value="<?php echo $row1['id']; ?>" <?php if($lists['category']==$row1['id']) { ?> selected="selected" <?php } ?> >
										<?php echo $row1['category_name']; ?>
									</option>										
									<?php
								}
							?>
						</select>
						<button onclick="document.getElementById('category').value='';this.form.submit();">
						<?php echo JText::_( 'Reset' ); ?></button> 
					</td>
				</tr>
			</table>       
       
			<table class="adminlist">
				<thead>
					<tr>
						<th width="20">
						<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows)?>)">
						</th>
						<th width="50" class="title"><?php echo JHTML::_('grid.sort',   'ID', 'id', @$lists['order_Dir'], @$lists['order'] ); ?></td>
						<th>Product Name</th>
						<th>Product Code</th>
						<th>Product Category</th>
						<th>Product Manufacturer</th>
						<th>Product Thumbnail Image</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="11">
						 <?php echo $pageNav->getListFooter(); ?>
						</td>
					</tr>
				</tfoot>
				<?php
				$k = 0;
				for($i=0, $n=count($rows); $i < $n ; $i++)
				{
					$row = &$rows[$i];
					$checked 	= JHTML::_('grid.id', $i, $row->id);
					$link = JRoute::_( 'index.php?option=com_dealcatalog&task=productsedit&cid[]='.$row->id );

					//$published 	= JHTML::_('grid.published', $row, $i); 
					?>
					<tr class="<?php echo "row$k"; ?>">
						<td><?php echo $checked; ?></td>
						<td><a href="<?php echo $link; ?>"><?php echo $row->id; ?></a></td>
						<?php
							$db = &JFactory::getDBO();
						?>
						<td><a href="<?php echo $link; ?>"><?php echo $row->product_name; ?></a> </td>
						<td><a href="<?php echo $link; ?>"><?php echo $row->product_code; ?> </a> </td>
						<?php
							$category_id = $row->category_id;
							$query = "select category_name from #__deal_productcategories where id=$category_id";
							$db->setQuery($query);
							$result1 = $db->loadRow();
							$category_name = $result1[0];
						?>
						<td><?php echo $category_name; ?></td>
						<?php
							$manufacturer_id = $row->manufacturer_id;
							$query = "select manufacturer_name from #__deal_manufacturer where id=$manufacturer_id";
							$db->setQuery($query);
							$result2 = $db->loadRow();
							$manufacturer_name = $result2[0];
						?>
						<td><?php echo $manufacturer_name; ?></td>
						<td>
							<?php $image = $row->product_thumbimage1; ?>
							<img src="<?php echo $image; ?>">
						</td>
					</tr>
					<?php
					$k = 1 - $k;
				}
				?>
			</table>
			<input type="hidden" name="option" value="com_dealcatalog">
			<input type="hidden" name="task" value="products">    
			<input type="hidden" name="boxchecked" value="0"> 
			<input type="hidden" name="filter_order" value="<?php echo $lists['order']; ?>" />
			<input type="hidden" name="filter_order_Dir" value="" />    
		</form>
		<?php 
	}
	
	function productsinsert()
	{
		JRequest::setVar( 'hidemainmenu', 1 );
		?>
			<script language="javascript" type="text/javascript">
			<!--
				function submitbutton(pressbutton) {
					var form = document.adminForm;
					if (pressbutton == 'products') {
						submitform( pressbutton );
						return;
					}
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
					if(form.category_id.value==0)
					{
						alert('Please select the product category');
						form.category_id.focus();
						return false;
					}
					if(form.manufacturer_id.value==0)
					{
						alert('Please select the manufacturer of the product');
						form.manufacturer_id.focus();
						return false;
					}
					
					submitform( pressbutton );
				}
				
			//-->
			</script>  
			<form action="index.php?option=com_dealcatalog&task=products" method="post" name="adminForm" enctype="multipart/form-data">
				<table class="admintable">
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Product name' ); ?>:
							</label>
						</td>
						<td>
							<input type="text" name="product_name" value="" class="text_input"/>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Product code' ); ?>:
							</label>
						</td>
						<td>
							<input type="text" name="product_code" value="" class="text_input"/>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Product description' ); ?>:
							</label>
						</td>
						<td>
							<textarea name="product_desc" rows="8" cols="60"></textarea>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Category name' ); ?>:
							</label>
						</td>
						<td >
							<select name="category_id">
								<option value="0">Select Category name </option>
							<?php
								$db = &JFactory::getDBO();
								$query = "select id,category_name from #__deal_productcategories";
								$db->setQuery($query);
								$result = $db->loadAssocList();
								foreach($result as $row)
								{
									?>
										<option value="<?php echo $row['id']; ?>"><?php echo $row['category_name']; ?></option>										
									<?php
								}
							?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Manufacturers name' ); ?>:
							</label>
						</td>
						<td >
							<select name="manufacturer_id">
								<option value="0">Select Manufacturer name </option>
							<?php
								$db = &JFactory::getDBO();
								$query = "select id,manufacturer_name from #__deal_manufacturer";
								$db->setQuery($query);
								$result = $db->loadAssocList();
								foreach($result as $row)
								{
									?>
										<option value="<?php echo $row['id']; ?>"><?php echo $row['manufacturer_name']; ?></option>										
									<?php
								}
							?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Image Upload1' ); ?>:
							</label>
						</td>
						<td>
							<input type="file" name="file" id="file"  />
						</td>
					</tr>
					
				</table>
				<input type="hidden" name="option" value="com_dealcatalog" />
				<input type="hidden" name="task" value="products" />    
			</form>
		<?php
	}
	
	function productsedit(&$row)
	{
		JRequest::setVar( 'hidemainmenu', 1 );
		?>
			<script language="javascript" type="text/javascript">
			<!--
				function submitbutton(pressbutton) {
					var form = document.adminForm;
					if (pressbutton == 'products') {
						submitform( pressbutton );
						return;
					}
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
					if(form.category_id.value==0)
					{
						alert('Please select the product category');
						form.category_id.focus();
						return false;
					}
					if(form.manufacturer_id.value==0)
					{
						alert('Please select the manufacturer of the product');
						form.manufacturer_id.focus();
						return false;
					}
					
					submitform( pressbutton );
				}
				
			//-->
			</script>  
			<form action="index.php?option=com_dealcatalog&task=products" method="post" name="adminForm" enctype="multipart/form-data">
				<table class="admintable">
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Product name' ); ?>:
							</label>
						</td>
						<td>
							<input type="text" name="product_name" value="<?php echo $row->product_name; ?>" class="text_input"/>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Product code' ); ?>:
							</label>
						</td>
						<td>
							<input type="text" name="product_code" value="<?php echo $row->product_code; ?>" class="text_input"/>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Product description' ); ?>:
							</label>
						</td>
						<td>
							<textarea name="product_desc" rows="8" cols="60"><?php echo $row->product_desc; ?></textarea>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Category name' ); ?>:
							</label>
						</td>
						<td >
							<select name="category_id">
								<option value="0">Select Category name </option>
							<?php
								$db = &JFactory::getDBO();
								$query = "select id,category_name from #__deal_productcategories";
								$db->setQuery($query);
								$result = $db->loadAssocList();
								foreach($result as $row1)
								{
									?>
										<option value="<?php echo $row1['id']; ?>" <?php if($row->category_id==$row1['id']) { ?> selected="selected" <?php } ?> >
											<?php echo $row1['category_name']; ?>
										</option>										
									<?php
								}
							?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Manufacturers name' ); ?>:
							</label>
						</td>
						<td >
							<select name="manufacturer_id">
								<option value="0">Select Manufacturer name </option>
							<?php
								$db = &JFactory::getDBO();
								$query = "select id,manufacturer_name from #__deal_manufacturer";
								$db->setQuery($query);
								$result = $db->loadAssocList();
								foreach($result as $row1)
								{
									?>
										<option value="<?php echo $row1['id']; ?>" <?php if($row->manufacturer_id==$row1['id']) { ?> selected="selected" <?php } ?> >
											<?php echo $row1['manufacturer_name']; ?>
										</option>										
									<?php
								}
							?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Image Upload1' ); ?>:
							</label>
						</td>
						<td>
							<?php
								if($row->product_thumbimage1!='' && $row->product_thumbimage1!='../components/com_dealcatalog/default.png')
								{
							?>
									<input type="hidden" name="file1" value="<?php echo $row->product_thumbimage1; ?>">
									<input type="hidden" name="file11" value="<?php echo $row->product_image1; ?>">
									<img src="<?php echo $row->product_thumbimage1; ?>" >
							<?php
								}
								else
								{
							?>
									<input type="file" name="file" id="file"  />
							<?php
								}
							?>
						</td>
					</tr>
					
				</table>
				<input type="hidden" name="total_images" value="<?php echo $row->total_images; ?>" />
				<input type="hidden" name="option" value="com_dealcatalog" />
				<input type="hidden" name="task" value="products" />    
				<input type="hidden" name="id" value="<?php echo $row->id?>" />        
				<input type="hidden" name="cid[]" value="<?php echo $row->id; ?>" />
			</form>
		<?php
	}
	
	function productlistingsanddeals(&$rows, &$pageNav, &$lists)
	{
		JHTML::_('behavior.tooltip');
		echo "products Listing and Deals View "; 
		?>
		<form action="index.php?option=com_dealcatalog&task=productlistingsanddeals" method="post" name="adminForm" >     
			<table>
				<tr>
					<td align="left" width="100%">
						<?php echo JText::_( 'Vendor name' ); ?>:
						<select name="vendors" id="vendors" onChange="document.adminForm.submit();">
							<option selected="selected" value=""> Select vendor </option>
							<?php
								$db = &JFactory::getDBO();
								$query = "select id,company_name from #__deal_merchants";
								$db->setQuery($query);
								$result = $db->loadAssocList();
								foreach($result as $row1)
								{
									?>
									<option value="<?php echo $row1['id']; ?>" <?php if($lists['vendors']==$row1['id']) { ?> selected="selected" <?php } ?> >
										<?php echo $row1['company_name']; ?>
									</option>										
									<?php
								}
							?>
						</select>
						<button onclick="document.getElementById('vendors').value='';this.form.submit();">
						<?php echo JText::_( 'Reset' ); ?></button> 
						<?php echo JText::_( 'product Name' ); ?>:
						<select name="products" id="products" onChange="document.adminForm.submit();">
							<option selected="selected" value=""> Select product </option>
							<?php
								$db = &JFactory::getDBO();
								$query = "select id,product_name from #__deal_products";
								$db->setQuery($query);
								$result = $db->loadAssocList();
								foreach($result as $row1)
								{
									?>
									<option value="<?php echo $row1['id']; ?>" <?php if($lists['products']==$row1['id']) { ?> selected="selected" <?php } ?> >
										<?php echo $row1['product_name']; ?>
									</option>										
									<?php
								}
							?>
						</select>
						<button onclick="document.getElementById('products').value='';this.form.submit();">
						<?php echo JText::_( 'Reset' ); ?></button> 
					</td>
				</tr>
			</table>       
       
			<table class="adminlist">
				<thead>
					<tr>
						<th width="20">
						<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows)?>)">
						</th>
						<th width="50" class="title"><?php echo JHTML::_('grid.sort',   'ID', 'id', @$lists['order_Dir'], @$lists['order'] ); ?></td>
						<th>Vendor Name</th>
						<th>Product Name</th>
						<th>Price</th>
						<th>Discount Price</th>
						<th>Is Deal</th>
						<th>Deal Price</th>
						<th>Deal End Date</th>
						<th>Deal Promotion Type</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="11">
						 <?php echo $pageNav->getListFooter(); ?>
						</td>
					</tr>
				</tfoot>
				<?php
				$k = 0;
				for($i=0, $n=count($rows); $i < $n ; $i++)
				{
					$row = &$rows[$i];
					$checked 	= JHTML::_('grid.id', $i, $row->id);
					$link = JRoute::_( 'index.php?option=com_dealcatalog&task=productlistingsanddealsedit&cid[]='.$row->id );

					//$published 	= JHTML::_('grid.published', $row, $i); 
					?>
					<tr class="<?php echo "row$k"; ?>">
						<td><?php echo $checked; ?></td>
						<td><a href="<?php echo $link; ?>"><?php echo $row->id; ?></a></td>
						<?php
							$db = &JFactory::getDBO();
							$vendor_id = $row->vendor_id;
							$product_id = $row->product_id;
							$promotion = $row->promotion_type;
							$query = "select company_name from #__deal_merchants where id='$vendor_id'";
							$db->setQuery($query);
							$vendor = $db->loadRow();
							$query = "select product_name from #__deal_products where id='$product_id'";
							$db->setQuery($query);
							$product = $db->loadRow();
							$query = "select promotion_type from #__deal_promotiontype where id='$promotion'";
							$db->setQuery($query);
							$promotion = $db->loadRow();
						?>
						<td><?php echo $vendor[0]; ?> </td>
						<td><?php echo $product[0]; ?> </td>
						<td><?php echo $price =  $row->price; ?> </td>
						<td><?php echo $row->discount_price; ?> </td>
						<td><?php echo $row->is_deal; ?> </td>
						<td><?php echo $row->deal_price; ?> </td>
						<td><?php echo $row->dealend_date; ?> </td>
						<td><?php echo $promotion[0]; ?> </td>
					</tr>
					<?php
					$k = 1 - $k;
				}
				?>
			</table>
			<input type="hidden" name="option" value="com_dealcatalog">
			<input type="hidden" name="task" value="productlistingsanddeals">    
			<input type="hidden" name="boxchecked" value="0"> 
			<input type="hidden" name="filter_order" value="<?php echo $lists['order']; ?>" />
			<input type="hidden" name="filter_order_Dir" value="" />    
		</form>
		<?php 
	}
	
	//Inserting the product listings and deals
	function productlistingsanddealsinsert()
	{
		JRequest::setVar( 'hidemainmenu', 1 );
		?>
		<script language="javascript" type="text/javascript">
			<!--
				function newdesc()
				{
					if(document.adminForm.productdesc.checked==true)
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
					if(document.adminForm.productimg.checked==true)
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
					if(document.adminForm.is_deal.checked==true)
					{
						document.getElementById('product_deals').style.display="block";
						document.getElementById('product_deals1').style.display="block";
						document.getElementById('product_deals2').style.display="block";
						document.getElementById('product_deals3').style.display="block";
					}
					else
					{
						document.getElementById('product_deals').style.display="none";
						document.getElementById('product_deals1').style.display="none";
						document.getElementById('product_deals2').style.display="none";
						document.getElementById('product_deals3').style.display="none";
					}
				}
				function submitbutton(pressbutton) {
					var form = document.adminForm;
					if (pressbutton == 'productlistingsanddeals') {
						submitform( pressbutton );
						return;
					}
					if(form.vendor_id.value==0)
					{
						alert('Select the Vendor Name');
						form.vendor_id.focus();
						return false;
					}
					if(form.productdesc.checked==true)
					{
						if(form.merchantproduct_desc.value=='')
						{
							alert('Enter the product Description for your product');
							form.merchantproduct_desc.focus();
							return false;
						}
					}
					if(form.stock_in.value==0)
					{
						alert('Select the stock of product');
						form.stock_in.focus();
						return false;
					}
					if(form.price.value.length==0)
					{
						alert('Enter the Price for the product');
						form.price.focus();
						return false;
					}
					var prices = /^\d+\.\d{2}$/;
					if(form.price.value.search(prices)==-1)
					{
						alert('Enter the correct price format as 0.00');
						form.price.focus();
						form.price.value="";
						return false;
					}
					if(form.discount_price.value!='')
					{
						if(form.discount_price.value.search(prices)==-1)
						{
							alert('Enter the correct price format as 0.00');
							form.discount_price.focus();
							form.discount_price.value="";
							return false;
						}
					}
					if(form.listingstart_date.value.length==0)
					{
						alert('Select the Starting date for this product');
						form.listingstart_date.focus();
						return false;
					}
					if(form.listingend_date.value.length==0)
					{
						alert('Select the Ending date for this product');
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
					if(form.is_deal.checked==true)
					{
						if(form.deal_price.value.length==0)
						{
							alert('Enter the Deal Price for the product');
							form.deal_price.focus();
							return false;
						}
						var prices = /^\d+\.\d{2}$/;
						if(form.deal_price.value.search(prices)==-1)
						{
							alert('Enter the correct price format as 0.00');
							form.deal_price.focus();
							form.deal_price.value="";
							return false;
						}
						if(form.dealstart_date.value.length==0)
						{
							alert('Select the Starting deal date for this product');
							form.dealstart_date.focus();
							return false;
						}
						if(form.dealend_date.value.length==0)
						{
							alert('Select the Ending deal date for this product');
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
							alert('Select the Promotion for the product to be displayed for customers');
							form.promotion_type.focus();
							return false;
						}
					}
					submitform( pressbutton );
				}				
			//-->
		</script> 
		<style type="text/css">
			.calendar
			{
				margin-left:5px; position:relative; top:5px;
			}
		</style>
		<form name="products" method="post" action="index.php?option=com_dealcatalog&task=productlistingsanddealsinsert">
			<table class="admintable">
				<tr>
					<td class="key">
							<label for="message">
								<?php echo JText::_( 'Select your Product for Listing and Deal' ); ?>:
							</label>
					</td>
					<td>
						<select name="products" id="products" onChange="document.products.submit();">
							<option selected="selected" value=""> Select product </option>
							<?php
								$db = &JFactory::getDBO();
								$query = "select id,product_name from #__deal_products";
								$db->setQuery($query);
								$result = $db->loadAssocList();
								foreach($result as $row1)
								{
									?>
									<option value="<?php echo $row1['id']; ?>" <?php if($_POST['products']==$row1['id']) { ?> selected="selected" <?php } ?> >
										<?php echo $row1['product_name']; ?>
									</option>										
									<?php
								}
							?>
						</select>
					</td>
				</tr>
			</table>
			<input type="hidden" name="option" value="com_dealcatalog">
			<input type="hidden" name="task" value="productlistingsanddealsinsert">
		</form>
		<?php
			$product_id = $_POST['products'];
			$query = "select * from #__deal_products where id='$product_id'";
			$db->setQuery($query);
			$product = $db->loadRow();
			$query = "select category_name from #__deal_productcategories where id='".$product[5]."'";
			$db->setQuery($query);
			$category = $db->loadRow();
			$query = "select manufacturer_name from #__deal_manufacturer where id='".$product[4]."'";
			$db->setQuery($query);
			$manufacturer = $db->loadRow();
			$query = "select * from #__deal_promotiontype";
			$db->setQuery($query);
			$promotions = $db->loadAssocList();
			$query = "select id,company_name from #__deal_merchants";
			$db->setQuery($query);
			$merchant = $db->loadAssocList();
		?>
		<form action="index.php?option=com_dealcatalog&task=productlistingsanddeals" method="post" name="adminForm" enctype="multipart/form-data">
			<?php if($_POST['products']!='')
			{ ?>
				<table class="admintable">
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Vendor Name' ); ?>:
							</label>
						</td>
						<td>
							<select name="vendor_id">
								<option value="0"> Select the Vendor Name </option>
								<?php
								foreach($merchant as $row)
								{
									?>
									<option value="<?php echo $row['id']; ?>"><?php echo $row['company_name']; ?></option>
									<?php
								}
								?>
							</select> 
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Product Name' ); ?>:
							</label>
						</td>
						<td>
							<?php echo $product[1]; ?> 
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Product Code' ); ?>:
							</label>
						</td>
						<td>
							<?php echo $product[2]; ?>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Category' ); ?>:
							</label>
						</td>
						<td>
							<?php echo $category[0]; ?> <input type="hidden" name="category" value="<?php echo $category[0]; ?>" />
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Manufacturer' ); ?>:
							</label>
						</td>
						<td>
							<?php echo $manufacturer[0]; ?>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Product Description' ); ?>:
							</label>
						</td>
						<td>
							<div id="product_desc"><?php echo $product[3]; ?></div>
							<div id="product_desc1" style="display:none;"><textarea name="merchantproduct_desc" rows="8" cols="60"></textarea></div>
						</td>
						<td>
							<input type="checkbox" id="productdesc" name="productdesc" value="1" onClick="newdesc();"> Want to add a new Product Description ?
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Product Image' ); ?>:
							</label>
						</td>
						<td>
							<div id="product_image"><img src="<?php echo $product[7]; ?>" /></div>
							<div id="product_image1" style="display:none;"><input type="file" name="file" id="file"  /></div>
						</td>
						<td>
							<input type="checkbox" id="productimg" name="productimg" value="1" onClick="newimg();"> Want to add a new image for this product ?
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Stock' ); ?>:
							</label>
						</td>
						<td>
							<select name="stock_in">
								<option value=""> Select Stock </option>
								<option value="1"> In Stock </option>
								<option value="0"> Out Stock </option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Product Price' ); ?>:
							</label>
						</td>
						<td>
							<input type="text" name="price" value="" /> Price as 0.00
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Product Discount Price' ); ?>:
							</label>
						</td>
						<td>
							<input type="text" name="discount_price" value="" /> Price as 0.00
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Start Date' ); ?>:
							</label>
						</td>
						<td>
							<?php echo JHTML::_('calendar',$mydate,'listingstart_date','listingstart_date','%Y-%m-%d','size="20",title ="listingstart_date", readonly="readonly"');?>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'End Date' ); ?>:
							</label>
						</td>
						<td>
							<?php echo JHTML::_('calendar',$mydate,'listingend_date','listingend_date','%Y-%m-%d','size="20",title ="listingend_date", readonly="readonly"');?>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Want the product to be in Deal' ); ?>:
							</label>
						</td>
						<td>
							<input type="checkbox" name="is_deal" value="1" onClick="showdeal();" /> Is Deal
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Deal Price' ); ?>:
							</label>
						</td>
						<td>
							<div id="product_deals" style="display:none;">
								<input type="text" name="deal_price" value="" /> Price as 0.00
							</div>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Deal Start Date' ); ?>:
							</label>
						</td>
						<td>
							<div id="product_deals1" style="display:none;">
								<?php echo JHTML::_('calendar',$mydate,'dealstart_date','dealstart_date','%Y-%m-%d','size="20",title ="dealstart_date", readonly="readonly"');?>
							</div>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Deal End Date' ); ?>:
							</label>
						</td>
						<td>
							<div id="product_deals2" style="display:none;">
								<?php echo JHTML::_('calendar',$mydate,'dealend_date','dealend_date','%Y-%m-%d','size="20",title ="dealend_date", readonly="readonly"');?>
							</div>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Promotion Type' ); ?>:
							</label>
						</td>
						<td>
							<div id="product_deals3" style="display:none;">
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
							</div>
						</td>
					</tr>
				</table>
			<?php } ?>
			<input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
			<input type="hidden" name="image" value="">
			<input type="hidden" name="option" value="com_dealcatalog" />
			<input type="hidden" name="task" value="productlistingsanddeals" /> 
		</form>
		<?php
		
	}
	
	//Edit the product listings and deals
	function productlistingsanddealsedit(&$row)
	{
		JRequest::setVar( 'hidemainmenu', 1 );
		$db = &JFactory::getDBO();
		?>
		<script language="javascript" type="text/javascript">
			<!--
				function newdesc()
				{
					if(document.adminForm.productdesc.checked==true)
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
					if(document.adminForm.productimg.checked==true)
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
					if(document.adminForm.is_deal.checked==true)
					{
						document.getElementById('product_deals').style.display="block";
						document.getElementById('product_deals1').style.display="block";
						document.getElementById('product_deals2').style.display="block";
						document.getElementById('product_deals3').style.display="block";
					}
					else
					{
						document.getElementById('product_deals').style.display="none";
						document.getElementById('product_deals1').style.display="none";
						document.getElementById('product_deals2').style.display="none";
						document.getElementById('product_deals3').style.display="none";
					}
				}
				function submitbutton(pressbutton) {
					var form = document.adminForm;
					if (pressbutton == 'productlistingsanddeals') {
						submitform( pressbutton );
						return;
					}
					if(form.vendor_id.value==0)
					{
						alert('Select the Vendor Name');
						form.vendor_id.focus();
						return false;
					}
					if(form.productdesc.checked==true)
					{
						if(form.merchantproduct_desc.value=='')
						{
							alert('Enter the product Description for your product');
							form.merchantproduct_desc.focus();
							return false;
						}
					}
					if(form.stock_in.value==0)
					{
						alert('Select the stock of product');
						form.stock_in.focus();
						return false;
					}
					if(form.price.value.length==0)
					{
						alert('Enter the Price for the product');
						form.price.focus();
						return false;
					}
					var prices = /^\d+\.\d{2}$/;
					if(form.price.value.search(prices)==-1)
					{
						alert('Enter the correct price format as 0.00');
						form.price.focus();
						form.price.value="";
						return false;
					}
					if(form.discount_price.value!='')
					{
						if(form.discount_price.value.search(prices)==-1)
						{
							alert('Enter the correct price format as 0.00');
							form.discount_price.focus();
							form.discount_price.value="";
							return false;
						}
					}
					if(form.listingstart_date.value.length==0)
					{
						alert('Select the Starting date for this product');
						form.listingstart_date.focus();
						return false;
					}
					if(form.listingend_date.value.length==0)
					{
						alert('Select the Ending date for this product');
						form.listingend_date.focus();
						return false;
					}
					if(form.is_deal.checked==true)
					{
						if(form.deal_price.value.length==0)
						{
							alert('Enter the Deal Price for the product');
							form.deal_price.focus();
							return false;
						}
						var prices = /^\d+\.\d{2}$/;
						if(form.deal_price.value.search(prices)==-1)
						{
							alert('Enter the correct price format as 0.00');
							form.deal_price.focus();
							form.deal_price.value="";
							return false;
						}
						if(form.dealstart_date.value.length==0)
						{
							alert('Select the Starting deal date for this product');
							form.dealstart_date.focus();
							return false;
						}
						if(form.dealend_date.value.length==0)
						{
							alert('Select the Ending deal date for this product');
							form.dealend_date.focus();
							return false;
						}
						if(form.promotion_type.value==0)
						{
							alert('Select the Promotion for the product to be displayed for customers');
							form.promotion_type.focus();
							return false;
						}
					}
					submitform( pressbutton );
				}				
			//-->
		</script> 
		<style type="text/css">
			.calendar
			{
				margin-left:5px; position:relative; top:5px;
			}
		</style>
		<?php
			$product_id = $row->product_id;
			$query = "select * from #__deal_products where id='$product_id'";
			$db->setQuery($query);
			$product = $db->loadRow();
			$query = "select category_name from #__deal_productcategories where id='".$product[5]."'";
			$db->setQuery($query);
			$category = $db->loadRow();
			$query = "select manufacturer_name from #__deal_manufacturer where id='".$product[4]."'";
			$db->setQuery($query);
			$manufacturer = $db->loadRow();
			$query = "select * from #__deal_promotiontype";
			$db->setQuery($query);
			$promotions = $db->loadAssocList();
			$query = "select id,company_name from #__deal_merchants";
			$db->setQuery($query);
			$merchant = $db->loadAssocList();
		?>
		<form action="index.php?option=com_dealcatalog&task=productlistingsanddeals" method="post" name="adminForm" enctype="multipart/form-data">
				<table class="admintable">
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Vendor Name' ); ?>:
							</label>
						</td>
						<td>
							<select name="vendor_id">
								<option value="0"> Select the Vendor Name </option>
								<?php
								foreach($merchant as $rows)
								{
									?>
									<option value="<?php echo $rows['id']; ?>" <?php if($row->vendor_id==$rows['id']) { ?> selected="selected" <?php } ?> >		<?php echo $rows['company_name']; ?>
									</option>
									<?php
								}
								?>
							</select> 
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Product Name' ); ?>:
							</label>
						</td>
						<td>
							<?php echo $product[1]; ?> 
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Product Code' ); ?>:
							</label>
						</td>
						<td>
							<?php echo $product[2]; ?>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Category' ); ?>:
							</label>
						</td>
						<td>
							<?php echo $category[0]; ?> <input type="hidden" name="category" value="<?php echo $category[0]; ?>" />
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Manufacturer' ); ?>:
							</label>
						</td>
						<td>
							<?php echo $manufacturer[0]; ?>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Product Description' ); ?>:
							</label>
						</td>
						<?php 
						if($row->merchantproduct_desc!='') 
						{ ?>
							<td>
								<div id="product_desc" style="display:none;"><?php echo $product[3]; ?></div>
								<div id="product_desc1">
									<textarea name="merchantproduct_desc" rows="8" cols="60"><?php echo $row->merchantproduct_desc;?></textarea>
								</div>
							</td>
							<td>
								<input type="checkbox" id="productdesc" name="productdesc" value="1" onClick="newdesc();" checked="checked"> Want to add a new Product Description ?
							</td>
						<?php 
						}
						else
						{
						?>
							<td>
								<div id="product_desc"><?php echo $product[3]; ?></div>
								<div id="product_desc1" style="display:none;"><textarea name="merchantproduct_desc" rows="8" cols="60"></textarea></div>
							</td>
							<td>
								<input type="checkbox" id="productdesc" name="productdesc" value="1" onClick="newdesc();"> Want to add a new Product Description ?
							</td>
						<?php
						}
						?>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Product Image' ); ?>:
							</label>
						</td>
						<?php
						if($row->merchantproduct_thumbimage1!='')
						{
							?>
							<td>
								<div id="product_image" style="display:none;"><img src="<?php echo $product[7]; ?>" /></div>
								<div id="product_image1"> <img src="<?php echo $row->merchantproduct_thumbimage1; ?>" /> </div>
							</td>
							<td>
								<input type="checkbox" id="productimg" name="productimg" value="1" onClick="newimg();" checked="checked"> Want to add a new image for this product ?
							</td>
							<input type="hidden" name="image1" id="image1" value="<?php echo $row->merchantproduct_thumbimage1;?>" />
							<input type="hidden" name="image" id="image" value="<?php echo $row->merchantproduct_image1;?>" />
							<?php
						}
						else
						{
						?>
							<td>
								<div id="product_image"><img src="<?php echo $product[7]; ?>" /></div>
								<div id="product_image1" style="display:none;"><input type="file" name="file" id="file"  /></div>
							</td>
							<td>
								<input type="checkbox" id="productimg" name="productimg" value="1" onClick="newimg();"> Want to add a new image for this product ?
							</td>
							<input type="hidden" name="image" id="image" value="" />
						<?php
						}
						?>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Stock' ); ?>:
							</label>
						</td>
						<td>
							<select name="stock_in">
								<option value=""> Select Stock </option>
								<option value="1"<?php if($row->stock_in=="1") { ?> selected="selected" <?php } ?>> In Stock </option>
								<option value="0" <?php if($row->stock_in=="0") { ?> selected="selected" <?php } ?>> Out Stock </option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Product Price' ); ?>:
							</label>
						</td>
						<td>
							<input type="text" name="price" value="<?php echo $row->price; ?>" /> Price as 0.00
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Product Discount Price' ); ?>:
							</label>
						</td>
						<td>
							<input type="text" name="discount_price" value="<?php echo $row->discount_price; ?>" /> Price as 0.00
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Start Date' ); ?>:
							</label>
						</td>
						<td>
							<?php echo JHTML::_('calendar',$row->listingstart_date,'listingstart_date','listingstart_date','%Y-%m-%d','size="20",title ="listingstart_date", readonly="readonly"');?>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'End Date' ); ?>:
							</label>
						</td>
						<td>
							<?php echo JHTML::_('calendar',$row->listingend_date,'listingend_date','listingend_date','%Y-%m-%d','size="20",title ="listingend_date", readonly="readonly"');?>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Want the product to be in Deal' ); ?>:
							</label>
						</td>
						<td>
							<?php 
							if($row->is_deal==1)
							{
								?>
								<input type="checkbox" name="is_deal" value="1" onClick="showdeal();" checked="checked" /> Is Deal
								<?php
							}
							else
							{
								?>
								<input type="checkbox" name="is_deal" value="1" onClick="showdeal();" /> Is Deal
								<?php
							}
							?>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Deal Price' ); ?>:
							</label>
						</td>
						<td>
							<?php
							if($row->deal_price!='0.00')
							{
								?>
								<div id="product_deals">
									<input type="text" name="deal_price" value="<?php echo $row->deal_price;?>" /> Price as 0.00
								</div>
								<?php
							}
							else
							{
							?>
								<div id="product_deals" style="display:none;">
									<input type="text" name="deal_price" value="" /> Price as 0.00
								</div>
							<?php
							}
							?>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Deal Start Date' ); ?>:
							</label>
						</td>
						<td>
							<?php 
							if($row->dealstart_date!='0000-00-00')
							{
								?>
								<div id="product_deals1">
									<?php echo JHTML::_('calendar',$row->dealstart_date,'dealstart_date','dealstart_date','%Y-%m-%d','size="20",title ="dealstart_date", readonly="readonly"');?>
								</div>
								<?php
							}
							else
							{
								?>
								<div id="product_deals1" style="display:none;">
									<?php echo JHTML::_('calendar',$mydate,'dealstart_date','dealstart_date','%Y-%m-%d','size="20",title ="dealstart_date", readonly="readonly"');?>
								</div>
								<?php
							} ?>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Deal End Date' ); ?>:
							</label>
						</td>
						<td>
							<?php
							if($row->dealend_date!='0000-00-00')
							{
								?>
								<div id="product_deals2">
									<?php echo JHTML::_('calendar',$row->dealend_date,'dealend_date','dealend_date','%Y-%m-%d','size="20",title ="dealend_date", readonly="readonly"');?>
								</div>
								<?php
							}
							else
							{
							?>
								<div id="product_deals2" style="display:none;">
									<?php echo JHTML::_('calendar',$mydate,'dealend_date','dealend_date','%Y-%m-%d','size="20",title ="dealend_date", readonly="readonly"');?>
								</div>
							<?php
							} ?>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Promotion Type' ); ?>:
							</label>
						</td>
						<td>
							<?php
							if($row->promotion_type!='0')
							{
								?>
								<div id="product_deals3">
									<select name="promotion_type">
										<option value="0"> Select the Promotion Type </option>
										<?php
										foreach($promotions as $rows)
										{
											?>
											<option value="<?php echo $rows['id']; ?>" <?php if($row->promotion_type==$rows['id']) { ?> selected="selected" <?php } ?> >
												<?php echo $rows['promotion_type']; ?>
											</option>
											<?php
										}
										?>
									</select>
								</div>
								<?php
							}
							else
							{
							?>
								<div id="product_deals3" style="display:none;">
									<select name="promotion_type">
										<option value="0"> Select the Promotion Type </option>
										<?php
										foreach($promotions as $rows)
										{
											?>
											<option value="<?php echo $rows['id']; ?>"><?php echo $rows['promotion_type']; ?></option>
											<?php
										}
										?>
									</select>
								</div>
							<?php
							}
							?>
						</td>
					</tr>
				</table>
			<input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
			<input type="hidden" name="option" value="com_dealcatalog" />
			<input type="hidden" name="task" value="productlistingsanddeals" /> 
			<input type="hidden" name="id" value="<?php echo $row->id; ?>" />        
			<input type="hidden" name="cid[]" value="<?php echo $row->id; ?>" />
		</form>
		<?php
	}
	
	//product deals coupons of users list
	function coupons(&$rows, &$pageNav, &$lists)
	{
		JHTML::_('behavior.tooltip');
		echo "product Deals coupons users list View "; 
		?>
		<form action="index.php?option=com_dealcatalog&task=coupons" method="post" name="adminForm"> 
    
			<table>
				<tr>
					<td align="left" width="100%">
						<?php echo JText::_( 'Filter' ); ?>:
						<input type="text" name="search" id="search" value="<?php echo $lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
						<button onclick="this.form.submit();">
						<?php echo JText::_( 'Go' ); ?></button>
						<button onclick="document.getElementById('search').value='';this.form.submit();">
						<?php echo JText::_( 'Reset' ); ?></button>
					</td>
				</tr>
			</table>       
       
			<table class="adminlist">
				<thead>
					<tr>
						<th width="20">
						<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows)?>)">
						</th>
						<th width="50" class="title"><?php echo JHTML::_('grid.sort',   'ID', 'id', @$lists['order_Dir'], @$lists['order'] ); ?></td>
						<th>Merchant Name</th>						
						<th>Product Name</th>
						<th>Customer Name</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="11">
						 <?php echo $pageNav->getListFooter(); ?>
						</td>
					</tr>
				</tfoot>
				<?php
				$k = 0;
				for($i=0, $n=count($rows); $i < $n ; $i++)
				{
					$row = &$rows[$i];
					$checked 	= JHTML::_('grid.id', $i, $row->id);
					$link = JRoute::_( 'index.php?option=com_dealcatalog&task=couponsedit&cid[]='.$row->id );

					//$published 	= JHTML::_('grid.published', $row, $i); 
					?>
					<tr class="<?php echo "row$k"; ?>">
						<td><?php echo $checked; ?></td>
						<td><a href="<?php echo $link; ?>"><?php echo $row->id; ?></a></td>
						<?php
							$db = &JFactory::getDBO();
							$v_id = $row->vendor_id;
							$query = "select name from #__deal_merchants where id='$v_id'";
							$db->setQuery($query);
							$result = $db->loadRow();
						?>
						<td><?php echo $result[0]; ?> </td>						
						<?php
							$p_id = $row->product_id;
							$query = "select product_name from #__deal_products where id='$p_id'";
							$db->setQuery($query);
							$result1 = $db->loadRow();
						?>
						<td> <?php echo $result1[0]; ?> </td>
						<?php
							$db = &JFactory::getDBO();
							$u_id = $row->users_userid;
							$query = "select name from #__deal_customers where users_id='$u_id'";
							$db->setQuery($query);
							$result = $db->loadRow();
						?>
						<td><?php echo $result[0]; ?> </td>						
					</tr>
					<?php
					$k = 1 - $k;
				}
				?>
			</table>
			<input type="hidden" name="option" value="com_dealcatalog">
			<input type="hidden" name="task" value="coupons">    
			<input type="hidden" name="boxchecked" value="0"> 
			<input type="hidden" name="filter_order" value="<?php echo $lists['order']; ?>" />
			<input type="hidden" name="filter_order_Dir" value="" />    
		</form>
		<?php 
	}
	
	function couponsinsert()
	{
		JRequest::setVar( 'hidemainmenu', 1 );
		?>
			<script language="javascript" type="text/javascript">
			<!--
				function submitbutton(pressbutton) {
					var form = document.adminForm;
					if (pressbutton == 'Coupons') {
						submitform( pressbutton );
						return;
					}
					
					if(form.users_userid.value==0)
					{
						alert('Please select the Customer name');
						form.users_userid.focus();
						return false;
					}
					if(form.vendor_id.value==0)
					{
						alert('Please select the Merchant name');
						form.vendor_id.focus();
						return false;
					}
					if(form.product_id.value==0)
					{
						alert('Please select the Product name');
						form.product_id.focus();
						return false;
					}
					if(form.coupon_code.value.length==0)
					{
						alert('Please Enter the coupon code ');
						form.coupon_code.focus();
						return false;
					}
					var c_code = /^[A-Za-z0-9]{3,20}$/;
					if(form.coupon_code.value.search(c_code)== -1)
					{
						alert('No Special characters are allowed');
						form.coupon_code.focus();
						form.coupon_code.value="";
						return false;
					}
					
					submitform( pressbutton );
				}				
			//-->
			</script>  
			<form action="index.php?option=com_dealcatalog&task=coupons" method="post" name="adminForm">
				<table class="admintable">
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Customer name' ); ?>:
							</label>
						</td>
						<td >
							<select name="users_userid">
								<option value="0"> Select the Customer name </option>
								<?php
									$db = &JFactory::getDBO();
									$query = "select id,name from #__deal_customers where approved = '1'";
									$db->setQuery($query);
									$result = $db->loadAssocList();
									foreach($result as $row)
									{
								?>
										<option value="<?php echo $row['id']; ?>"> <?php echo $row['name']; ?> </option>
								<?php
									}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Merchant name' ); ?>:
							</label>
						</td>
						<td >
							<select name="vendor_id">
								<option value="0"> Select the Merchant name </option>
								<?php
									$db = &JFactory::getDBO();
									$query = "select id,name from #__deal_merchants where approved = '1'";
									$db->setQuery($query);
									$result = $db->loadAssocList();
									foreach($result as $row)
									{
								?>
										<option value="<?php echo $row['id']; ?>"> <?php echo $row['name']; ?> </option>
								<?php
									}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'product name' ); ?>:
							</label>
						</td>
						<td >
							<select name="product_id">
								<option value="0"> Select the product name </option>
								<?php
									$db = &JFactory::getDBO();
									$query = "select id,product_name from #__deal_products";
									$db->setQuery($query);
									$result = $db->loadAssocList();
									foreach($result as $row)
									{
								?>
										<option value="<?php echo $row['id']; ?>"> <?php echo $row['product_name']; ?> </option>
								<?php
									}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Coupon Code' ); ?>:
							</label>
						</td>
						<td >
							<input type="text" name="coupon_code" value="" /> 
						</td>
					</tr>
				</table>
				<input type="hidden" name="option" value="com_dealcatalog" />
				<input type="hidden" name="task" value="coupons" /> 
			</form>
		<?php
	}
	
	function couponsedit(&$row)
	{
		JRequest::setVar( 'hidemainmenu', 1 );
		?>
			<script language="javascript" type="text/javascript">
			<!--
				function submitbutton(pressbutton) {
					var form = document.adminForm;
					if (pressbutton == 'Coupons') {
						submitform( pressbutton );
						return;
					}
					
					if(form.users_userid.value==0)
					{
						alert('Please select the Customer name');
						form.users_userid.focus();
						return false;
					}
					if(form.vendor_id.value==0)
					{
						alert('Please select the Merchant name');
						form.vendor_id.focus();
						return false;
					}
					if(form.product_id.value==0)
					{
						alert('Please select the Product name');
						form.product_id.focus();
						return false;
					}
					if(form.coupon_code.value.length==0)
					{
						alert('Please Enter the coupon code ');
						form.coupon_code.focus();
						return false;
					}
					var c_code = /^[A-Za-z0-9]{3,20}$/;
					if(form.coupon_code.value.search(c_code)== -1)
					{
						alert('No Special characters are allowed');
						form.coupon_code.focus();
						form.coupon_code.value="";
						return false;
					}
					
					submitform( pressbutton );
				}				
			//-->
			</script>  
			<form action="index.php?option=com_dealcatalog&task=coupons" method="post" name="adminForm">
				<table class="admintable">
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Customer name' ); ?>:
							</label>
						</td>
						<td >
							<select name="users_userid">
								<option value="0"> Select the Customer name </option>
								<?php
									$db = &JFactory::getDBO();
									$query = "select id,name from #__deal_customers where approved = '1'";
									$db->setQuery($query);
									$result = $db->loadAssocList();
									foreach($result as $rows)
									{
								?>
										<option value="<?php echo $rows['id']; ?>" <?php if($row->users_userid==$rows['id']) { ?> selected="selected" <?php } ?>> 
											<?php echo $rows['name']; ?> 
										</option>
								<?php
									}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Merchant name' ); ?>:
							</label>
						</td>
						<td >
							<select name="vendor_id">
								<option value="0"> Select the Merchant name </option>
								<?php
									$db = &JFactory::getDBO();
									$query = "select id,name from #__deal_merchants where approved = '1'";
									$db->setQuery($query);
									$result = $db->loadAssocList();
									foreach($result as $rows)
									{
								?>
										<option value="<?php echo $rows['id']; ?>" <?php if($row->vendor_id==$rows['id']) { ?> selected="selected" <?php } ?>> 
											<?php echo $rows['name']; ?> 
										</option>
								<?php
									}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'product name' ); ?>:
							</label>
						</td>
						<td >
							<select name="product_id">
								<option value="0"> Select the product name </option>
								<?php
									$db = &JFactory::getDBO();
									$query = "select id,product_name from #__deal_products";
									$db->setQuery($query);
									$result = $db->loadAssocList();
									foreach($result as $rows)
									{
								?>
										<option value="<?php echo $rows['id']; ?>" <?php if($row->product_id==$rows['id']) { ?> selected="selected" <?php } ?>>
											<?php echo $rows['product_name']; ?> 
										</option>
								<?php
									}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="message">
								<?php echo JText::_( 'Coupon Code' ); ?>:
							</label>
						</td>
						<td >
							<input type="text" name="coupon_code" value="<?php echo $row->coupon_code; ?>" /> 
						</td>
					</tr>
				</table>
				<input type="hidden" name="option" value="com_dealcatalog" />
				<input type="hidden" name="task" value="coupons" /> 
				<input type="hidden" name="id" value="<?php echo $row->id?>" />        
				<input type="hidden" name="cid[]" value="<?php echo $row->id; ?>" />
			</form>
		<?php
	}
	
}
?>