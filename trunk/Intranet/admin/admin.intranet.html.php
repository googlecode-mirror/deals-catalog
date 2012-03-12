<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

class IntranetHTML {
	//Setting Starts
	function setting()
	{
		$db = &JFactory::getDBO();
		$year = date("Y");
		$query = "select id,year from #__intranet_calendarsetting";
		$db->setQuery($query);
		$yr = $db->loadAssocList();
		global $mainframe;
		foreach($yr as $row)
		{
			if($row['year']==$year)
			{
			}
			else
			{
				$id = $row['id'];
				$query = "update #__intranet_calendarsetting set `year`='$year' where id='$id'";
				$db->setQuery($query);
				$db->query();
				$mainframe->redirect('index.php?option=com_intranet&task=settingcalendar');
			}
		}
		$days_all = array('Monday', 'Tuesday', 'Wednesday', 'Thusday', 'Friday', 'Saturday', 'Sunday');
		$query = "select weekly_off from #__intranet_calendarsetting";
		$db->setQuery($query);
		$day = $db->loadAssocList();
		foreach($day as $row)
		{
			$dy .= $row['weekly_off'].",";
		}
		$dy = explode(",", $dy);
		$query = "select id from #__intranet_settings where enabled='1'";
		$db->setQuery($query);
		$enabled = $db->loadResultArray();
		
		if($enabled[2]==3)
		{
			$query = "select * from #__intranet_paymentsetting";
			$db->setQuery($query);
			$payment = $db->loadRow();
		}
		?>
		<link rel="stylesheet" type="text/css" href="components/com_intranet/css/intranet.css" />
		<script language="javascript" type="text/javascript">
		<!--
			function submitbutton(pressbutton)
			{
				var form = document.adminForm;
				if (pressbutton == 'setting')
				{
					submitform( pressbutton );
					return;
				}
				if(form.display_payslip.checked == 1)
				{									
					if(form.leavetype.value=='')	
					{						
						alert('Enter the Leave Type for Employeers');						
						form.leavetype.focus();						
						return false;					
					}										
					var check = /^[A-Za-z, ]{1,900}$/;					
					if(form.leavetype.value.search(check)==-1)				
					{						
						alert('No Numeric and special characters are allowed');						
						form.leavetype.focus();						
						form.leavetype.value="";						
						return false;					
					}
					if(form.countryname.value==0)
					{
						alert('Please Select the Country name');
						form.countryname.focus();
						return false;
					}
					if(form.endtime.value=='')
					{
						alert('Enter the correct Time format as 19:00:00');
						form.endtime.focus();
						return false;
					}
					var time = /^(([0-1]?[0-9])|([2][0-3])):([0-5]?[0-9])(:([0-5]?[0-9]))?$/;
					if(form.endtime.value.search(time)==-1)
					{
						alert('Enter the correct Time format as 19:00:00');
						form.endtime.value='';
						form.endtime.focus();
						return false;
					}
					if(form.pf.value=='')
					{
						alert('Enter the PF Amount');
						form.pf.focus();
						return false;
					}
					if(form.pf.value!='')
					{
						var per = /(^100(\.0{1,2})?$)|(^([1-9]([0-9])?|0)(\.[0-9]{1,2})?$)/i;
						if(form.pf.value.search(per) == -1)
						{
							alert('Enter the Correct value');
							form.pf.focus();
							form.pf.value='';
							return false;
						}
					}
					if(form.hr.value=='')
					{
						alert('Enter the HR Amount');
						form.hr.focus();
						return false;
					}
					if(form.hr.value!='')
					{
						var per = /(^100(\.0{1,2})?$)|(^([1-9]([0-9])?|0)(\.[0-9]{1,2})?$)/i;
						if(form.hr.value.search(per) == -1)
						{
							alert('Enter the Correct value');
							form.hr.focus();
							form.hr.value='';
							return false;
						}
					}
					if(form.convenyance.value=='')
					{
						alert('Enter the Convenyance Amount');
						form.convenyance.focus();
						return false;
					}
					if(form.convenyance.value!='')
					{
						var per = /(^100(\.0{1,2})?$)|(^([1-9]([0-9])?|0)(\.[0-9]{1,2})?$)/i;
						if(form.convenyance.value.search(per) == -1)
						{
							alert('Enter the Correct value');
							form.convenyance.focus();
							form.convenyance.value='';
							return false;
						}
					}
					if(form.permitted_leave.value=='')
					{
						alert('Enter the Leave for Month');
						form.permitted_leave.focus();
						return false;
					}
					if(form.permitted_leave.value!='')
					{
						var per = /^\d{1,2}$/;
						if(form.permitted_leave.value.search(per) == -1)
						{
							alert('Enter the Correct value');
							form.permitted_leave.focus();
							form.permitted_leave.value='';
							return false;
						}
					}
					if(form.pf_deduction.value=='')
					{
						alert('Enter the PF Deduction Amount');
						form.pf_deduction.focus();
						return false;
					}
					if(form.pf_deduction.value!='')
					{
						var per = /(^100(\.0{1,2})?$)|(^([1-9]([0-9])?|0)(\.[0-9]{1,2})?$)/i;
						if(form.pf_deduction.value.search(per) == -1)
						{
							alert('Enter the Correct value');
							form.pf_deduction.focus();
							form.pf_deduction.value='';
							return false;
						}
					}
					if(form.pt.value=='')
					{
						alert('Enter the Professional Tax Amount');
						form.pt.focus();
						return false;
					}
					if(form.pt.value!='')
					{
						var per = /(^100(\.0{1,2})?$)|(^([1-9]([0-9])?|0)(\.[0-9]{1,2})?$)/i;
						if(form.pt.value.search(per) == -1)
						{
							alert('Enter the Correct value');
							form.pt.focus();
							form.pt.value='';
							return false;
						}
					}
					if(form.other_deduction.value=='')
					{
						alert('Enter the Professional Tax Amount');
						form.other_deduction.focus();
						return false;
					}
					if(form.other_deduction.value!='')
					{
						var per = /(^100(\.0{1,2})?$)|(^([1-9]([0-9])?|0)(\.[0-9]{1,2})?$)/i;
						if(form.other_deduction.value.search(per) == -1)
						{
							alert('Enter the Correct value');
							form.other_deduction.focus();
							form.other_deduction.value='';
							return false;
						}
					}
				}
				submitform( pressbutton );
			}
		//-->
		</script>
		<form name="adminForm" method="post" action="index.php?option=com_intranet&task=setting">
			<div class="setting_head">
				Calendar Setting
			</div>
			<table class="admintable">
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Display Calendar' ); ?>:
						</label>
					</td>
					<td>
						<?php
						if($enabled[0]==1)
						{
							?>
							<input type="checkbox" value="1" name="display_calendar" checked="checked" />
							<?php
						}
						else
						{
							?>
							<input type="checkbox" value="1" name="display_calendar" />
							<?php
						}
						?>						
					</td>
					<td>
						Want to Display the Sub Calendar Component to show the Events, Leave and Weekly off to users in both backend and front-end.
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Weekly Off Days' ); ?>:
						</label>
					</td>
					<td>
						<?php
						foreach($days_all as $days)
						{
							if(in_array($days,$dy))
							{
								?>
								<div> <input type="checkbox" value="<?php echo $days; ?>" name="days[]" checked="checked" /> <?php echo $days; ?> </div>
								<?php
							}
							else
							{
								?>
								<div> <input type="checkbox" value="<?php echo $days; ?>" name="days[]" /> <?php echo $days; ?> </div>
								<?php
							}
						}
						?>						
					</td>
					<td>
						By Selecting the days, it will automatically set Weekly off leave for every month automatically in the Calendar for the current Year.
					</td>
				</tr>
			</table>
			<div class="setting_head">
				Pay Slip Setting
			</div>
			<table class="admintable">
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Display Payslip' ); ?>:
						</label>
					</td>
					<td>
						<?php
						if($enabled[2]==3)
						{
							?>
							<input type="checkbox" value="1" name="display_payslip" checked="checked" />
							<?php
						}
						else
						{
							?>
							<input type="checkbox" value="1" name="display_payslip" />
							<?php
						}
						?>							
					</td>
					<td>
						Want to Display the Sub Pay slip Component to show the Payment for users based on the Calendar , by Attendance in  front-end and Payment Setting in the Backend.
					</td>
				</tr>
			</table>
				<div class="setting_head">
					Payment Salary Settings
				</div>
			<table class="admintable">							
			<tr>					
				<td class="key">					
					<label for="name">							
						<?php echo JText::_( 'Leave Type' ); ?>:
					</label>					
				</td>			
				<td>		
					<input type="text" name="leavetype" value="<?php echo $payment[9]; ?>" size="100"/>		
				</td>						
				<td>						
					Enter the leave as  Personal Leave,Sick Leave..					
				</td>				
			</tr>
			<tr>
				<td class="key">
					<label for="name">
						<?php echo JText::_( 'Select Your Country for Time' ); ?>:
					</label>
				</td>
				<td>
					<select name="countryname">
						<option value="0"> Select Country </option>
						<?php
						$timezone_identifiers = DateTimeZone::listIdentifiers();
						$n = count($timezone_identifiers);
						for($m=0;$m<$n;$m++)
						{
							?>
							<option value="<?php echo $timezone_identifiers[$m]; ?>" <?php if($payment[10]==$timezone_identifiers[$m]) {?> selected="selected" <?php } ?> >
								<?php echo $timezone_identifiers[$m]; ?>
							</option>
							<?php
						}
						?>
					</select>
				</td>
				<td>
					Based on the selection of country, Your country current date and time will automated for attendance.
				</td>
			</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Office Close Time' ); ?>:
						</label>
					</td>
					<td>
						<input type="text" name="endtime" value="<?php echo $payment[8]; ?>" size="10"/>
					</td>					
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'PF' ); ?>:
						</label>
					</td>
					<td>
						<input type="text" name="pf" value="<?php echo $payment[1]; ?>" size="10"/> %
					</td>
					<td>
						Enter the value  like 12.5
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'HR' ); ?>:
						</label>
					</td>
					<td>
						<input type="text" name="hr" value="<?php echo $payment[2]; ?>" size="10"/> %
					</td>
					<td>
						Enter the value like 12.5
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Convenyance' ); ?>:
						</label>
					</td>
					<td>
						<input type="text" name="convenyance" value="<?php echo $payment[3]; ?>" size="10"/> %
					</td>
					<td>
						Enter the value like 12.5
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Permitted Leave for Month' ); ?>:
						</label>
					</td>
					<td>
						<input type="text" name="permitted_leave" value="<?php echo $payment[4]; ?>" size="10"/> 
					</td>					
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'PF Deduction' ); ?>:
						</label>
					</td>
					<td>
						<input type="text" name="pf_deduction" value="<?php echo $payment[5]; ?>" size="10"/> %
					</td>
					<td>
						Enter the value like 12.5
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Professional Tax' ); ?>:
						</label>
					</td>
					<td>
						<input type="text" name="pt" value="<?php echo $payment[6]; ?>" size="10"/> %
					</td>
					<td>
						Enter the value like 12.5
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Other Deduction' ); ?>:
						</label>
					</td>
					<td>
						<input type="text" name="other_deduction" value="<?php echo $payment[7]; ?>" size="10"/> %
					</td>
					<td>
						Enter the value like 12.5
					</td>
				</tr>
			</table>			
			<input type="hidden" name="option" value="com_intranet" />
			<input type="hidden" name="task" value="setting" /> 
		</form>
		<?php
	}
	//Setting Ends
	//calendar Starts
	function calendar(&$rows,&$rows1)
	{
		?>
		<link rel="stylesheet" type="text/css" href="components/com_intranet/css/intranet.css" />		
		<?php
		$monthNames = Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
		if (!isset($_REQUEST["month"])) $_REQUEST["month"] = date("m");
		if (!isset($_REQUEST["year"]))  $_REQUEST["year"]  = date("Y");
			
		$cMonth = $_REQUEST["month"];
		$cYear  = $_REQUEST["year"];
						
		$prev_year = $cYear;
		$next_year = $cYear;

		$prev_month = $cMonth-1;
		$next_month = $cMonth+1;
		if ($prev_month == 0 ) {
			$prev_month = 12;
			$prev_year = $cYear - 1;
		}
		if ($next_month == 13 ) {
			$next_month = 1;
			$next_year = $cYear + 1;
		}
		?>
		<div> Add Events by Single Click on the date </div>
		<div id="calendar_div" name="calendar_div">
			<div id="pre_nxt">
				<div class="showpre">
					<a href="<?php echo $_SERVER["PHP_SELF"] . "?option=".$_REQUEST['option']."&task=".$_REQUEST['task']."&month=". $prev_month . "&year=" . $prev_year; ?>" >Previous</a>
				</div>
				<div class="showmonth">
					<?php echo $monthNames[$cMonth-1].' '.$cYear; ?>
				</div>
				<div class="shownxt">
					<a href="<?php echo $_SERVER["PHP_SELF"] . "?option=".$_REQUEST['option']."&task=".$_REQUEST['task']."&month=". $next_month . "&year=" . $next_year; ?>" >Next</a>
				</div>		
			</div>
			<div id="showcalender">
				<div id="cal_head">
					<div class="showdays">Sunday</div>
					<div class="showdays">Monday</div>
					<div class="showdays">Tuesday</div>
					<div class="showdays">Wednesday</div>
					<div class="showdays">Thusday</div>
					<div class="showdays">Friday</div>
					<div class="showdays">Saturday</div>
				</div>
				<div id="cal_content">
				<?php 
					$timestamp = mktime(0,0,0,$cMonth,1,$cYear);
					$maxday    = date("t",$timestamp);				
					$thismonth = getdate ($timestamp); 
					$startday  = $thismonth['wday'];
					$curr_date = date('d');					
					
					for ($i=0; $i<($maxday+$startday); $i++) 
					{
						if(($i % 7) == 0 ) echo "<div class='full_row'>";						 
						if($i < $startday) echo "<div class='no_row'></div>";
						else 
						{
							echo "<div class='dates'>"; 
							$d = ($i - $startday + 1);
							$ds = $d - 1;
							if($d==$curr_date)
							{
								echo "<a href='index.php?option=com_intranet&task=addeventcalendar&dt=".$d.",".$cMonth.",".$cYear."'>";
								echo "<span class='curr_date'>". $d . "</span> </a>";
								for($ds=0; $ds < $d; $ds++)
								{
									$row = &$rows[$ds];
									$dts = $row->dt;
									if($d==$dts)
									{
										$link = JRoute::_( 'index.php?option=com_intranet&task=editeventcalendar&cid[]='.$row->id );
										$link1 = JRoute::_( 'index.php?option=com_intranet&task=deleteeventcalendar&cid[]='.$row->id );
										if($row->event_title!='')
										{
											$desc = $row->event_title;
											$time = "<div>".$row->eventstart_time." - ".$row->eventend_time."</div>";
										}
										if($row->holiday_title!='')
										{
											$desc = $row->holiday_title;
											$holiday = array('Weekly off', 'Religious Holiday', 'Government Holiday');
											$time = "<div>".$holiday[$row->holiday_type-1]."</div>";
										}
										echo "<div class='event'>";
										echo "<div class='event_desc'>".$desc.$time."</div>";
										echo "<div class='edit_cal'><a href='".$link."'>Edit </a> </div>";
										echo "<div class='delete_cal'><a href='".$link1."'>Delete </a> </div> </div>";
									}
									$row1 = &$rows1[$ds];
									$dts1 = $row1->dt;
									if($d==$dts1)
									{
										echo "<div class='event_desc'>".$row1->title."</div>";
									}
								}
								echo "</div>";
							}
							else
							{
								echo "<a href='index.php?option=com_intranet&task=addeventcalendar&dt=".$d.",".$cMonth.",".$cYear."'>";
								echo "<span class='show_date'>". $d . "</span> </a> ";
								for($ds=0; $ds < $d; $ds++)
								{
									$row = &$rows[$ds];
									$dts = $row->dt;
									if($d==$dts)
									{ 
										$link = JRoute::_( 'index.php?option=com_intranet&task=editeventcalendar&cid[]='.$row->id );
										$link1 = JRoute::_( 'index.php?option=com_intranet&task=deleteeventcalendar&cid[]='.$row->id );
										if($row->event_title!='')
										{
											$desc = $row->event_title;
											$time = "<div>".$row->eventstart_time." - ".$row->eventend_time."</div>";
										}
										if($row->holiday_title!='')
										{
											$desc = $row->holiday_title;
											$holiday = array('Weekly off', 'Religious Holiday', 'Government Holiday');
											$time = "<div>".$holiday[$row->holiday_type-1]."</div>";
										}
										echo "<div class='event'>";
										echo "<div class='event_desc'>".$desc.$time."</div>"; 
										echo "<div class='edit_cal'><a href='".$link."'>Edit </a> </div>";
										echo "<div class='delete_cal'><a href='".$link1."'>Delete </a> </div> </div>";
									}
									$row1 = &$rows1[$ds];
									$dts1 = $row1->dt;
									if($d==$dts1)
									{
										echo "<div class='event_desc'>".$row1->title."<div> Weekly Off </div></div>";
									}
								}
								echo "</div>";
							}							
						}							
						if(($i % 7) == 6 ) echo "</div>";
					}					
				?>
				</div>
			</div>
		</div>
		<?php
	}
	
	function addeventcalendar($curr_dt)
	{
		$curr = $curr_dt;
		$curr = explode(",", $curr);
		$dt = $curr['0'];
		$mth = $curr['1'];
		$yr = $curr['2'];
		$date = $yr."-".$mth."-".$dt;
		JRequest::setVar( 'hidemainmenu', 1 );
		?>
		<link rel="stylesheet" type="text/css" href="components/com_intranet/css/intranet.css" />
		<script language="javascript" type="text/javascript">
		<!--
			function display_events()
			{
				if(document.adminForm.event_display.checked == 1)
				{
					document.getElementById('event').style.display="block";
					document.getElementById('holiday_display').checked=false;
					document.getElementById('holiday').style.display="none";
				}
				else
				{
					document.getElementById('event').style.display="none";
				}
				
			}
			function display_holiday()
			{
				if(document.adminForm.holiday_display.checked == 1)
				{
					document.getElementById('holiday').style.display="block";
					document.getElementById('event_display').checked=false;
					document.getElementById('event').style.display="none";
				}
				else
				{
					document.getElementById('holiday').style.display="none";
				}
			}
			function submitbutton(pressbutton)
			{
				var form = document.adminForm;
				if (pressbutton == 'calendar')
				{
					submitform( pressbutton );
					return;
				}
				if(form.event_display.checked == 0 && form.holiday_display.checked == 0)
				{
					alert('Please Check any one to update Event or Holiday');
					return false;
				}
				if(form.event_display.checked == 1)
				{
					if(form.event_title.value=="")
					{
						alert('Enter the Event name');
						form.event_title.focus();
						return false;
					}
					if(form.event_starttime.value=="")
					{
						alert('Enter the Event start Time');
						form.event_starttime.focus();
						return false;
					}
					var time = /^(([0-1]?[0-9])|([2][0-3])):([0-5]?[0-9])(:([0-5]?[0-9]))?$/;
					if(form.event_starttime.value.search(time) == -1)
					{
						alert('Enter the Correct time format');
						form.event_starttime.focus();
						form.event_starttime.value='';
						return false;
					}
					if(form.event_endtime.value=="")
					{
						alert('Enter the Event start Time');
						form.event_endtime.focus();
						return false;
					}
					var time = /^(([0-1]?[0-9])|([2][0-3])):([0-5]?[0-9])(:([0-5]?[0-9]))?$/;
					if(form.event_endtime.value.search(time) == -1)
					{
						alert('Enter the Correct time format');
						form.event_endtime.focus();
						form.event_endtime.value='';
						return false;
					}
				}
				if(form.holiday_display.checked == 1)
				{					
					if(form.holiday_type.value=='0')
					{
						alert('Enter the Holiday Type');
						form.holiday_type.focus();
						return false;
					}
					if(form.holiday_title.value=="")
					{
						alert('Enter the holiday Title');
						form.holiday_title.focus();
						return false;
					}
				}
				submitform( pressbutton );
			}
		//-->
		</script>
		<form action="index.php?option=com_intranet&task=calendar" method="post" name="adminForm">
			<div class="events">
				<div class="check_display">
					<input type="checkbox" name="event_display" id="event_display" onclick="display_events();" value="1" /> Event 
				</div>
				<div id="event" style="display:none;">
					<div class="left"> Date  </div>
					<div class="right"> <input type="text" name="date" value="<?php echo $date; ?>" readonly="readonly" /> </div>
					<div class="left"> Event Title </div>
					<div class="right"> <input type="text" name="event_title" value="" size="40" /> </div>
					<div class="left"> Start Time </div>
					<div class="right"> <input type="text" name="event_starttime" value="" /> Time Format 24 hrs Ex: 20:30:30 </div>
					<div class="left"> End Time </div>
					<div class="right"> <input type="text" name="event_endtime" value="" />  Time Format 24 hrs Ex: 20:30:30</div>					
				</div>
			</div>
			<div class="events">
				<div class="check_display">
					<input type="checkbox" name="holiday_display" id="holiday_display" onclick="display_holiday();" value="1" /> Holiday 
				</div>
				<div id="holiday" style="display:none;">
					<div class="left"> Date  </div>
					<div class="right"> <input type="text" name="date" value="<?php echo $date; ?>" readonly="readonly" /> </div>
					<div class="left"> Holiday Type </div>
					<?php
					$holiday = array('Weekly off Holiday', 'Religious Holiday', 'Government Holiday');
					$n = count($holiday);
					?>
					<div class="right">
						<select name="holiday_type">
							<option value="0"> Select Holiday </option>
							<?php
							for($i=0;$i<$n;$i++)
							{
								?>
								<option value="<?php echo ($i+1); ?>"><?php echo $holiday[$i]; ?></option>
								<?php
							}
							?>
						</select>
					</div>
					<div class="left"> Holiday Title </div>
					<div class="right"> <input type="text" name="holiday_title" value="" size="40" /> </div>
				</div>
			</div>
			<input type="hidden" value="<?php echo $dt; ?>" name="dt" />
			<input type="hidden" value="<?php echo $yr; ?>" name="year" />
			<input type="hidden" name="option" value="com_intranet" />
			<input type="hidden" name="task" value="calendar" /> 
		</form>
		<?php
	}
	
	function editeventcalendar(&$row)
	{
		JRequest::setVar( 'hidemainmenu', 1 );
		?>
		<link rel="stylesheet" type="text/css" href="components/com_intranet/css/intranet.css" />
		<script language="javascript" type="text/javascript">
		<!--
			function display_events()
			{
				if(document.adminForm.event_display.checked == 1)
				{
					document.getElementById('event').style.display="block";
					document.getElementById('holiday_display').checked=false;
					document.getElementById('holiday').style.display="none";
				}
				else
				{
					document.getElementById('event').style.display="none";
				}
				
			}
			function display_holiday()
			{
				if(document.adminForm.holiday_display.checked == 1)
				{
					document.getElementById('holiday').style.display="block";
					document.getElementById('event_display').checked=false;
					document.getElementById('event').style.display="none";
				}
				else
				{
					document.getElementById('holiday').style.display="none";
				}
			}
			function submitbutton(pressbutton)
			{
				var form = document.adminForm;
				if (pressbutton == 'calendar')
				{
					submitform( pressbutton );
					return;
				}
				if(form.event_display.checked == 0 && form.holiday_display.checked == 0)
				{
					alert('Please Check any one to update Event or Holiday');
					return false;
				}
				if(form.event_display.checked == 1)
				{
					if(form.event_title.value=="")
					{
						alert('Enter the Event name');
						form.event_title.focus();
						return false;
					}
					if(form.event_starttime.value=="")
					{
						alert('Enter the Event start Time');
						form.event_starttime.focus();
						return false;
					}
					var time = /^(([0-1]?[0-9])|([2][0-3])):([0-5]?[0-9])(:([0-5]?[0-9]))?$/;
					if(form.event_starttime.value.search(time) == -1)
					{
						alert('Enter the Correct time format');
						form.event_starttime.focus();
						form.event_starttime.value='';
						return false;
					}
					if(form.event_endtime.value=="")
					{
						alert('Enter the Event start Time');
						form.event_endtime.focus();
						return false;
					}
					var time = /^(([0-1]?[0-9])|([2][0-3])):([0-5]?[0-9])(:([0-5]?[0-9]))?$/;
					if(form.event_endtime.value.search(time) == -1)
					{
						alert('Enter the Correct time format');
						form.event_endtime.focus();
						form.event_endtime.value='';
						return false;
					}
				}
				if(form.holiday_display.checked == 1)
				{					
					if(form.holiday_type.value=='0')
					{
						alert('Enter the Holiday Type');
						form.holiday_type.focus();
						return false;
					}
					if(form.holiday_title.value=="")
					{
						alert('Enter the holiday Title');
						form.holiday_title.focus();
						return false;
					}
				}
				submitform( pressbutton );
			}
		//-->
		</script>
		<form action="index.php?option=com_intranet&task=calendar" method="post" name="adminForm">
			<div class="events">
				<div class="check_display">
					<?php
					if($row->event==1)
					{
						?>
						<input type="checkbox" name="event_display" id="event_display" onclick="display_events();" value="1" checked="checked" /> Event
						<?php
					}
					else
					{
						?>
						<input type="checkbox" name="event_display" id="event_display" onclick="display_events();" value="1" /> Event
						<?php
					}
					?>					 
				</div>
				<?php
				if($row->event==1)
				{
					?>
					<div id="event">
						<div class="left"> Date  </div>
						<div class="right"> <input type="text" name="date" value="<?php echo $row->date; ?>" readonly="readonly" /> </div>
						<div class="left"> Event Title </div>
						<div class="right"> <input type="text" name="event_title" value="<?php echo $row->event_title; ?>" size="40" /> </div>
						<div class="left"> Start Time </div>
						<div class="right"> <input type="text" name="event_starttime" value="<?php echo $row->eventstart_time; ?>" /> Time Format 24 hrs Ex: 20:30:30 </div>
						<div class="left"> End Time </div>
						<div class="right"> <input type="text" name="event_endtime" value="<?php echo $row->eventend_time; ?>" />  Time Format 24 hrs Ex: 20:30:30</div>					
					</div>
					<?php
				}
				else
				{
					?>
					<div id="event" style="display:none;">
						<div class="left"> Date  </div>
						<div class="right"> <input type="text" name="date" value="<?php echo $row->date; ?>" readonly="readonly" /> </div>
						<div class="left"> Event Title </div>
						<div class="right"> <input type="text" name="event_title" value="" size="40" /> </div>
						<div class="left"> Start Time </div>
						<div class="right"> <input type="text" name="event_starttime" value="" /> Time Format 24 hrs Ex: 20:30:30 </div>
						<div class="left"> End Time </div>
						<div class="right"> <input type="text" name="event_endtime" value="" />  Time Format 24 hrs Ex: 20:30:30</div>					
					</div>
					<?php
				}
				?>
				
			</div>
			<div class="events">
				<div class="check_display">
					<?php 
					if($row->holiday==1)
					{
						?>
						<input type="checkbox" name="holiday_display" id="holiday_display" onclick="display_holiday();" value="1" checked="checked" /> Holiday
						<?php
					}
					else
					{
						?>
						<input type="checkbox" name="holiday_display" id="holiday_display" onclick="display_holiday();" value="1" /> Holiday
						<?php
					}
					?>					 
				</div>
				<?php
				if($row->holiday==1)
				{
					?>
					<div id="holiday">
						<div class="left"> Date  </div>
						<div class="right"> <input type="text" name="date" value="<?php echo $row->date; ?>" readonly="readonly" /> </div>
						<div class="left"> Holiday Type </div>
						<?php
						$holiday = array('Weekly off Holiday', 'Religious Holiday', 'Government Holiday');
						$n = count($holiday);
						?>
						<div class="right">
							<select name="holiday_type">
								<option value="0"> Select Holiday </option>
								<?php
								for($i=0;$i<$n;$i++)
								{
									?>
									<option value="<?php echo ($i+1); ?>" <?php if($row->holiday_type==($i+1)) { ?> selected <?php } ?> >
										<?php echo $holiday[$i]; ?>
									</option>
									<?php
								}
								?>
							</select>
						</div>
						<div class="left"> Holiday Title </div>
						<div class="right"> <input type="text" name="holiday_title" value="<?php echo $row->holiday_title; ?>" size="40" /> </div>
					</div>
					<?php
				}
				else
				{
					?>
					<div id="holiday" style="display:none;">
						<div class="left"> Date  </div>
						<div class="right"> <input type="text" name="date" value="<?php echo $row->date; ?>" readonly="readonly" /> </div>
						<div class="left"> Holiday Type </div>
						<?php
						$holiday = array('Weekly off Holiday', 'Religious Holiday', 'Government Holiday');
						$n = count($holiday);
						?>
						<div class="right">
							<select name="holiday_type">
								<option value="0"> Select Holiday </option>
								<?php
								for($i=0;$i<$n;$i++)
								{
									?>
									<option value="<?php echo ($i+1); ?>"><?php echo $holiday[$i]; ?></option>
									<?php
								}
								?>
							</select>
						</div>
						<div class="left"> Holiday Title </div>
						<div class="right"> <input type="text" name="holiday_title" value="" size="40" /> </div>
					</div>
					<?php
				}
				?>				
			</div>
			<input type="hidden" value="<?php echo $row->dt; ?>" name="dt" />
			<input type="hidden" value="<?php echo $row->year; ?>" name="year" />
			<input type="hidden" name="option" value="com_intranet" />
			<input type="hidden" name="task" value="calendar" /> 
			<input type="hidden" name="id" value="<?php echo $row->id; ?>" />        
			<input type="hidden" name="cid[]" value="<?php echo $row->id; ?>" />
		</form>
		<?php
	}
	//calendar ends
	//Users Starts
	function users(&$rows, &$pageNav, &$lists)
	{
		JHTML::_('behavior.tooltip');
		?>
		<link rel="stylesheet" type="text/css" href="components/com_intranet/css/intranet.css" />
		<div class="update"> <a href="index.php?option=com_intranet&task=updateuser"> Update user </a> </div>
		<form action="index.php?option=com_intranet&task=users" method="post" name="adminForm">
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
						<th width="50" class="title"><?php echo JHTML::_('grid.sort', 'ID', 'id', @$lists['order_Dir'], @$lists['order'] ); ?></td>
						<th>User Id</th>
						<th><?php echo JHTML::_('grid.sort', 'Name', 'name', @$lists['order_Dir'], @$lists['order'] ); ?></th>
						<th> User Name </th>
						<th>Email Id</th>
						<th>Date of birth</th>
						<th>Position</th>	
						<th>Monthly Salary </th>
						<th>Total Salary </th>
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
					$link = JRoute::_( 'index.php?option=com_intranet&task=usersedit&cid[]='.$row->id );
					?>
					<tr class="<?php echo "row$k"; ?>">
						<td><?php echo $checked; ?></td>
						<td><a href="<?php echo $link; ?>"><?php echo $row->id; ?></a></td>
						<td><?php echo $row->users_id; ?></td> 
						<td><a href="<?php echo $link; ?>"><?php echo $row->name; ?></a></td>
						<td><?php echo $row->username; ?></td> 
						<td><?php echo $row->email; ?></td>
						<td><?php echo $row->dob; ?></td>
						<td><?php echo $row->position; ?></td>
						<td><?php echo $row->monthly_salary; ?> </td>
						<td><?php echo $row->total_salary; ?> </td>
					</tr>
					<?php
					$k = 1 - $k;
				}
				?>
			</table>
			<input type="hidden" name="option" value="com_intranet">
			<input type="hidden" name="task" value="users">    
			<input type="hidden" name="boxchecked" value="0"> 
			<input type="hidden" name="filter_order" value="<?php echo $lists['order']; ?>" />
			<input type="hidden" name="filter_order_Dir" value="" />  
		</form>
		<?php
	}
	
	function usersinsert()
	{
		JRequest::setVar( 'hidemainmenu', 1 );
		?>
		<link rel="stylesheet" type="text/css" href="components/com_intranet/css/intranet.css" />
		<script language="javascript" type="text/javascript">
		<!--
			function submitbutton(pressbutton)
			{
				var form = document.adminForm;
				if (pressbutton == 'users')
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
				if(form.email.value.length==0)
				{
					alert('Please Enter the Email id');
					form.email.focus();
					return false;
				}
				var email_check = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
				if(form.email.value.search(email_check) == -1)
				{
					alert('Email Id not Valid');
					form.email.focus();
					form.email.value="";
					return false;
				}
				if(form.dob.value.length==0)
				{
					alert('Please Enter Your Date of Birth');
					form.dob.focus();
					return false;
				}
				if(form.position.value.length==0)
				{
					alert('Please Enter the User Position');
					form.position.focus();
					return false;
				}
				var pos = /^[A-Za-z ]{2,50}$/
				if(form.position.value.search(pos) == -1)
				{
					alert('No Special and Numeric are allowed');
					form.position.focus();
					form.position.value='';
					return false;
				}
				if(form.basic_pay.value.length==0)
				{
					alert('Enter the Basic Pay');
					form.basic_pay.focus();
					return false;
				}
				var bp = /^\d+\.\d{2}$/;
				if(form.basic_pay.value.search(bp) == -1)
				{
					alert('Enter the correct basic pay');
					form.basic_pay.focus();
					form.basic_pay.value='';
					return false;
				}
				submitform( pressbutton );
			}
		//-->
		</script>
		<form action="index.php?option=com_intranet&task=users" method="post" name="adminForm">
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
							<?php echo JText::_( 'Email Id' ); ?>:
						</label>
					</td>
					<td >
						<input type="text" name="email" value="" class="text_input" size="60"/>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Date of Birth' ); ?>:
						</label>
					</td>
					<td >
						<?php echo JHTML::_('calendar',$mydate,'dob','dob','%Y-%m-%d','size="20",title ="dob", readonly="readonly"');?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Official Address' ); ?>:
						</label>
					</td>
					<td >
						<textarea name="official_address" rows="5" cols="50"></textarea>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Residencial Address' ); ?>:
						</label>
					</td>
					<td >
						<textarea name="residencial_address" rows="5" cols="50"></textarea>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Phone Number' ); ?>:
						</label>
					</td>
					<td >
						<input type="text" name="phone_no" value="" class="text_input" size="60"/>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Mobile Number' ); ?>:
						</label>
					</td>
					<td >
						<input type="text" name="mobile_no" value="" class="text_input" size="60"/>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'User Position' ); ?>:
						</label>
					</td>
					<td >
						<input type="text" name="position" value="" class="text_input" size="60"/>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Basic Pay' ); ?>:
						</label>
					</td>
					<td >
						<input type="text" name="basic_pay" value="" class="text_input" size="60"/> Basic Pay as 10000.00
					</td>
				</tr>
			</table>
			<input type="hidden" name="option" value="com_intranet" />
			<input type="hidden" name="task" value="users" /> 
		</form>
		<?php
	}
	
	function edituser(&$row)
	{
		JRequest::setVar( 'hidemainmenu', 1 );
		?>
		<link rel="stylesheet" type="text/css" href="components/com_intranet/css/intranet.css" />
		<script language="javascript" type="text/javascript">
		<!--
			function submitbutton(pressbutton)
			{
				var form = document.adminForm;
				if (pressbutton == 'users')
				{
					submitform( pressbutton );
					return;
				}
				if(form.name.value.length==0)
				{
					alert('Please Enter the name');
					form.name.focus();
					return false;
				}
				var first_check = /^[A-Za-z ]{3,20}$/;
				if(form.name.value.search(first_check) == -1)
				{
					alert('Only character are allowed and Name must be greater than 3 characters');
					form.name.focus();
					form.name.value="";
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
				if(form.email.value.length==0)
				{
					alert('Please Enter the Email id');
					form.email.focus();
					return false;
				}
				var email_check = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
				if(form.email.value.search(email_check) == -1)
				{
					alert('Email Id not Valid');
					form.email.focus();
					form.email.value="";
					return false;
				}
				if(form.dob.value.length==0)
				{
					alert('Please Enter Your Date of Birth');
					form.dob.focus();
					return false;
				}
				if(form.position.value.length==0)
				{
					alert('Please Enter the User Position');
					form.position.focus();
					return false;
				}
				var pos = /^[A-Za-z ]{2,50}$/
				if(form.position.value.search(pos) == -1)
				{
					alert('No Special and Numeric are allowed');
					form.position.focus();
					form.position.value='';
					return false;
				}
				if(form.basic_pay.value.length==0)
				{
					alert('Enter the Basic Pay');
					form.basic_pay.focus();
					return false;
				}
				var bp = /^\d+\.\d{2}$/;
				if(form.basic_pay.value.search(bp) == -1)
				{
					alert('Enter the correct basic pay');
					form.basic_pay.focus();
					form.basic_pay.value='';
					return false;
				}
				submitform( pressbutton );
			}
		//-->
		</script>
		<form action="index.php?option=com_intranet&task=users" method="post" name="adminForm">
			<table class="admintable">
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Name' ); ?>:
						</label>
					</td>
					<td >
						<input type="text" name="name" value="<?php echo $row->name; ?>" class="text_input" size="60"/>
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
							<?php echo JText::_( 'Email Id' ); ?>:
						</label>
					</td>
					<td >
						<input type="text" name="email" value="<?php echo $row->email; ?>" class="text_input" size="60"/>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Date of Birth' ); ?>:
						</label>
					</td>
					<td >
						<?php echo JHTML::_('calendar',$row->dob,'dob','dob','%Y-%m-%d','size="20",title ="dob", readonly="readonly"');?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Official Address' ); ?>:
						</label>
					</td>
					<td >
						<textarea name="official_address" rows="5" cols="50"><?php echo $row->official_address; ?></textarea>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Residencial Address' ); ?>:
						</label>
					</td>
					<td >
						<textarea name="residencial_address" rows="5" cols="50"><?php echo $row->residencial_address; ?></textarea>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Phone Number' ); ?>:
						</label>
					</td>
					<td >
						<input type="text" name="phone_no" value="<?php echo $row->phone_no; ?>" class="text_input" size="60"/>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Mobile Number' ); ?>:
						</label>
					</td>
					<td >
						<input type="text" name="mobile_no" value="<?php echo $row->mobile_no; ?>" class="text_input" size="60"/>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'User Position' ); ?>:
						</label>
					</td>
					<td >
						<input type="text" name="position" value="<?php echo $row->position; ?>" class="text_input" size="60"/>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Basic Pay' ); ?>:
						</label>
					</td>
					<td >
						<input type="text" name="basic_pay" value="<?php echo $row->basic_pay; ?>" class="text_input" size="60"/> Basic Pay as 10000.00
					</td>
				</tr>
			</table>
			<input type="hidden"  name="users_id" value="<?php echo $row->users_id; ?>" />
			<input type="hidden" name="option" value="com_intranet" />
			<input type="hidden" name="task" value="users" /> 
			<input type="hidden" name="id" value="<?php echo $row->id; ?>" />        
			<input type="hidden" name="cid[]" value="<?php echo $row->id; ?>" />
		</form>
		<?php
	}
	//User ends
	//Daily attendance starts
	function dailyattendance(&$rows, &$pageNav, &$lists)
	{
		JHTML::_('behavior.tooltip');
		$db = &JFactory::getDBO();
		?>
		<link rel="stylesheet" type="text/css" href="components/com_intranet/css/intranet.css" />
		<form action="index.php?option=com_intranet&task=dailyattendance" method="post" name="adminForm">
			<table>
				<tr>
					<td align="left" width="100%">
						<?php echo JText::_( 'Name' ); ?>:
						<select name="users" id="users" onchange="document.adminForm.submit();" >
							<option value=""> </option>
							<?php
							$query = "select users_id,name from #__intranet_users";
							$db->setQuery($query);
							$user = $db->loadAssocList();
							foreach($user as $row)
							{
								?>
								<option value="<?php echo $row['users_id']; ?>" <?php if($lists['users']==$row['users_id']){ ?> selected="selected" <?php } ?>>
									<?php echo $row['name']; ?> 
								</option>
								<?php
							}
							?>
						</select>
						&nbsp;												
						<?php
						$monthNames = Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
						$m = count($monthNames);				
						?>					
						<?php echo  JText::_('Month'); ?>:
						<select name="month" onchange="document.adminForm.submit();" id="month">
							<option value=""> </option>
							<?php
							for($i=0; $i<$m; $i++)
							{
								?>
								<option value="<?php echo ($i+1); ?>" <?php if($lists['month']==($i+1)){ ?> selected="selected" <?php } ?>>
									<?php echo $monthNames[$i]; ?> 
								</option>
								<?php
							}
							?>
						</select> &nbsp;
						<?php echo  JText::_('Year'); ?>:
						<select name="year" onchange="document.adminForm.submit();" id="year">
							<option value=""> </option>
							<?php
							for($i=2000; $i < 3000; $i++)
							{
								?>
								<option value="<?php echo $i; ?>" <?php if($lists['year']==$i){ ?> selected="selected" <?php } ?>><?php echo $i; ?> </option>
								<?php
							}
							?>
						</select> &nbsp;
						<button onclick="document.getElementById('users').value=''; document.getElementById('month').value=''; document.getElementById('year').value=''; this.form.submit();">
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
						<th width="50" class="title"><?php echo JHTML::_('grid.sort', 'ID', 'id', @$lists['order_Dir'], @$lists['order'] ); ?></td>
						<th><?php echo JHTML::_('grid.sort', 'Name', 'name', @$lists['order_Dir'], @$lists['order'] ); ?></th>
						<th> Date </th>
						<th> In Time </th>
						<th>Out Time</th>
						<th> Hours Worked </th>
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
					$link = JRoute::_( 'index.php?option=com_intranet&task=dailyattendanceedit&cid[]='.$row->id );
					?>
					<tr class="<?php echo "row$k"; ?>">
						<td><?php echo $checked; ?></td>
						<td><a href="<?php echo $link; ?>"><?php echo $row->id; ?></a></td>
						<td><a href="<?php echo $link; ?>"><?php echo $row->name; ?></a></td>
						<td><?php echo $row->today_date; ?></td> 
						<td><?php echo $row->in_time; ?></td>
						<td><?php echo $row->out_time; ?></td>
						<td><?php echo $row->total_hours; ?></td>
					</tr>
					<?php
					$k = 1 - $k;
				}
				?>
			</table>
			<input type="hidden" name="option" value="com_intranet">
			<input type="hidden" name="task" value="dailyattendance">    
			<input type="hidden" name="boxchecked" value="0"> 
			<input type="hidden" name="filter_order" value="<?php echo $lists['order']; ?>" />
			<input type="hidden" name="filter_order_Dir" value="" />  
		</form>
		<?php
	}
	
	function attendanceinsert()
	{
		JRequest::setVar( 'hidemainmenu', 1 );
		$db = &JFactory::getDBO();
		$query = "select users_id,name from #__intranet_users";
		$db->setQuery($query);
		$users = $db->loadAssocList();
		?>
		<link rel="stylesheet" type="text/css" href="components/com_intranet/css/intranet.css" />
		<script language="javascript" type="text/javascript">
		<!--	
			function submitbutton(pressbutton)
			{
				var form = document.adminForm;
				if (pressbutton == 'dailyattendance')
				{
					submitform( pressbutton );
					return;
				}
				if(form.users.value==0)
				{
					alert('Please select the user');
					form.users.focus();
					return false;
				}
				if(form.today_date.value.length==0)
				{
					alert('Select the Date for attendance');
					form.today_date.focus();
					return false;
				}
				if(form.in_time.value.length==0)
				{
					alert('Enter the In Time for users');
					form.in_time.focus();
					return false;
				}
				var time = /^(([0-1]?[0-9])|([2][0-3])):([0-5]?[0-9])(:([0-5]?[0-9]))?$/;
				if(form.in_time.value.search(time) == -1)
				{
					alert('Enter the correct time format as 20:30:30');
					form.in_time.focus();
					form.in_time.value='';
					return false;
				}
				if(form.out_time.value.length==0)
				{
					alert('Enter the Out Time for users');
					form.out_time.focus();
					return false;
				}
				var time = /^(([0-1]?[0-9])|([2][0-3])):([0-5]?[0-9])(:([0-5]?[0-9]))?$/;
				if(form.out_time.value.search(time) == -1)
				{
					alert('Enter the correct time format as 20:30:30');
					form.out_time.focus();
					form.out_time.value='';
					return false;
				}
				submitform( pressbutton );
			}
		//-->
		</script>
		<form action="index.php?option=com_intranet&task=dailyattendance" method="post" name="adminForm">
			<table class="admintable">
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Name' ); ?>:
						</label>
					</td>
					<td>
						<select name="users">
							<option value="0">Select Users </option>
							<?php							
							foreach($users as $row)
							{
								?>
								<option value="<?php echo $row['users_id']; ?>"><?php echo $row['name']; ?> </option>
								<?php
							}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Attendance Date ' ); ?>:
						</label>
					</td>
					<td >
						<?php echo JHTML::_('calendar',$mydate,'today_date','today_date','%Y-%m-%d','size="20",title ="today_date", readonly="readonly"');?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'In Time ' ); ?>:
						</label>
					</td>
					<td >
						<input type="text" name="in_time" value="" /> Time Format 24 hrs Ex: 20:30:30
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Out Time ' ); ?>:
						</label>
					</td>
					<td >
						<input type="text" name="out_time" value="" /> Time Format 24 hrs Ex: 20:30:30
					</td>
				</tr>
			</table>
			<input type="hidden" name="option" value="com_intranet" />
			<input type="hidden" name="task" value="dailyattendance" />
		</form>
		<?php
	}
	
	function dailyattendanceedit(&$row)
	{
		JRequest::setVar( 'hidemainmenu', 1 );
		?>
		<script language="javascript" type="text/javascript">
		<!--	
			function submitbutton(pressbutton)
			{
				var form = document.adminForm;
				if (pressbutton == 'dailyattendance')
				{
					submitform( pressbutton );
					return;
				}
				if(form.in_time.value.length==0)
				{
					alert('Enter the In Time for users');
					form.in_time.focus();
					return false;
				}
				var time = /^(([0-1]?[0-9])|([2][0-3])):([0-5]?[0-9])(:([0-5]?[0-9]))?$/;
				if(form.in_time.value.search(time) == -1)
				{
					alert('Enter the correct time format as 20:30:30');
					form.in_time.focus();
					form.in_time.value='';
					return false;
				}
				if(form.out_time.value.length==0)
				{
					alert('Enter the Out Time for users');
					form.out_time.focus();
					return false;
				}
				var time = /^(([0-1]?[0-9])|([2][0-3])):([0-5]?[0-9])(:([0-5]?[0-9]))?$/;
				if(form.out_time.value.search(time) == -1)
				{
					alert('Enter the correct time format as 20:30:30');
					form.out_time.focus();
					form.out_time.value='';
					return false;
				}
				submitform( pressbutton );
			}
		//-->
		</script>
		<form action="index.php?option=com_intranet&task=dailyattendance" method="post" name="adminForm">
			<table class="admintable">
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Name' ); ?>:
						</label>
					</td>
					<td>
						<?php echo $row->name; ?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Attendance Date ' ); ?>:
						</label>
					</td>
					<td >
						<?php echo $row->today_date; ?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'In Time ' ); ?>:
						</label>
					</td>
					<td >
						<input type="text" name="in_time" value="<?php echo $row->in_time; ?>" /> Time Format 24 hrs Ex: 20:30:30
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Out Time ' ); ?>:
						</label>
					</td>
					<td >
						<input type="text" name="out_time" value="<?php echo $row->out_time; ?>" /> Time Format 24 hrs Ex: 20:30:30
					</td>
				</tr>
			</table>
			<input type="hidden" name="users_id" value="<?php echo $row->users_id; ?>" />
			<input type="hidden" name="name" value="<?php echo $row->name; ?>" />
			<input type="hidden" name="today_date" value="<?php echo $row->today_date; ?>" />
			<input type="hidden" name="month" value="<?php echo $row->month; ?>" />
			<input type="hidden" name="year" value="<?php echo $row->year; ?>" />
			<input type="hidden" name="option" value="com_intranet" />
			<input type="hidden" name="task" value="dailyattendance" />
			<input type="hidden" name="id" value="<?php echo $row->id; ?>" />        
			<input type="hidden" name="cid[]" value="<?php echo $row->id; ?>" />
		</form>
		<?php
	}
	//Daily Attendance Ends
	//Month Attendance Starts
	function monthattendance(&$rows, &$pageNav, &$lists)
	{
		JHTML::_('behavior.tooltip');
		$db = &JFactory::getDBO();
		$query = "select users_id,name from #__intranet_users";
		$db->setQuery($query);
		$user = $db->loadAssocList();
		?>
		<form action="index.php?option=com_intranet&task=monthattendance" method="post" name="adminForm">
			<table>
				<tr>
					<td align="left" width="100%">
						<?php echo JText::_( 'Name' ); ?>:
						<select name="users" id="users" onchange="document.adminForm.submit();" >
							<option value=""> </option>
							<?php							
							foreach($user as $row)
							{
								?>
								<option value="<?php echo $row['users_id']; ?>" <?php if($lists['users']==$row['users_id']){ ?> selected="selected" <?php } ?>>
									<?php echo $row['name']; ?> 
								</option>
								<?php
							}
							?>
						</select> &nbsp;												
						<?php
						$monthNames = Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
						$m = count($monthNames);				
						?>					
						<?php echo  JText::_('Month'); ?>:
						<select name="month" onchange="document.adminForm.submit();" id="month">
							<option value=""> </option>
							<?php
							for($i=0; $i<$m; $i++)
							{
								?>
								<option value="<?php echo ($i+1); ?>" <?php if($lists['month']==($i+1)){ ?> selected="selected" <?php } ?>>
									<?php echo $monthNames[$i]; ?> 
								</option>
								<?php
							}
							?>
						</select> &nbsp;
						<?php echo  JText::_('Year'); ?>:
						<select name="year" onchange="document.adminForm.submit();" id="year">
							<option value=""> </option>
							<?php
							for($i=2000; $i < 3000; $i++)
							{
								?>
								<option value="<?php echo $i; ?>" <?php if($lists['year']==$i){ ?> selected="selected" <?php } ?>><?php echo $i; ?> </option>
								<?php
							}
							?>
						</select> &nbsp;
						<button onclick="document.getElementById('users').value=''; document.getElementById('month').value=''; document.getElementById('year').value=''; this.form.submit();">
						<?php echo JText::_( 'Reset' ); ?></button>	
					</td>
				</tr>			
			</table>
			<table class="adminlist">
				<thead>
					<tr>
						<th width="50" class="title"><?php echo JHTML::_('grid.sort', 'ID', 'id', @$lists['order_Dir'], @$lists['order'] ); ?></td>
						<th><?php echo JHTML::_('grid.sort', 'Name', 'name', @$lists['order_Dir'], @$lists['order'] ); ?></th>
						<th> Month </th>
						<th> Year </th>						
						<th> Worked Days </th>
						<th> Leave Days  </th>
						<th> Office Working Days </th>
						<th> Office Holiday Days </th>
						<th> Week off Days </th>
						<th> Total Days </th>
						<th> Total Hours Worked </th>
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
					?>
					<tr class="<?php echo "row$k"; ?>">
						<td><?php echo $row->id; ?></td>
						<td><?php echo $row->name; ?></td>
						<td><?php $mth = $row->month; echo $monthNames[$mth-1]; ?> </td>
						<td><?php echo $row->year; ?></td> 						
						<td><?php echo $row->days_worked; ?></td>
						<td><?php echo $row->leave_days; ?></td>	
						<td><?php echo $row->office_days; ?></td>
						<td><?php echo $row->companyholiday_days; ?></td>
						<td><?php echo $row->weekoff_days; ?></td>
						<td><?php echo $row->total_days; ?></td>
						<td><?php echo $row->total_hours." Hours"; ?> </td>
					</tr>
					<?php
					$k = 1 - $k;
				}
				?>
			</table>
			<input type="hidden" name="option" value="com_intranet">
			<input type="hidden" name="task" value="monthattendance">    
			<input type="hidden" name="boxchecked" value="0"> 
			<input type="hidden" name="filter_order" value="<?php echo $lists['order']; ?>" />
			<input type="hidden" name="filter_order_Dir" value="" />  
		</form>
		<?php
	}
	//Month Attendance Ends
	//Pay slip Starts
	function payslip(&$rows, &$pageNav, &$lists)
	{
		JHTML::_('behavior.tooltip');
		$db = &JFactory::getDBO();
		?>
		<form action="index.php?option=com_intranet&task=payslip" method="post" name="adminForm">
			<table>
				<tr>
					<td align="left" width="100%">
						<?php echo JText::_( 'Name' ); ?>:
						<select name="users" id="users" onchange="document.adminForm.submit();" >
							<option value=""> </option>
							<?php
							$query = "select users_id,name from #__intranet_users";
							$db->setQuery($query);
							$user = $db->loadAssocList();
							foreach($user as $row)
							{
								?>
								<option value="<?php echo $row['users_id']; ?>" <?php if($lists['users']==$row['users_id']){ ?> selected="selected" <?php } ?>>
									<?php echo $row['name']; ?> 
								</option>
								<?php
							}
							?>
						</select> &nbsp;												
						<?php
						$monthNames = Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
						$m = count($monthNames);				
						?>					
						<?php echo  JText::_('Month'); ?>:
						<select name="month" onchange="document.adminForm.submit();" id="month">
							<option value=""> </option>
							<?php
							for($i=0; $i<$m; $i++)
							{
								?>
								<option value="<?php echo ($i+1); ?>" <?php if($lists['month']==($i+1)){ ?> selected="selected" <?php } ?>>
									<?php echo $monthNames[$i]; ?> 
								</option>
								<?php
							}
							?>
						</select> &nbsp;
						<?php echo  JText::_('Year'); ?>:
						<select name="year" onchange="document.adminForm.submit();" id="year">
							<option value=""> </option>
							<?php
							for($i=2000; $i < 3000; $i++)
							{
								?>
								<option value="<?php echo $i; ?>" <?php if($lists['year']==$i){ ?> selected="selected" <?php } ?>><?php echo $i; ?> </option>
								<?php
							}
							?>
						</select> &nbsp;
						<button onclick="document.getElementById('users').value=''; document.getElementById('month').value=''; document.getElementById('year').value=''; this.form.submit();">
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
						<th width="50" class="title"><?php echo JHTML::_('grid.sort', 'ID', 'id', @$lists['order_Dir'], @$lists['order'] ); ?></td>
						<th><?php echo JHTML::_('grid.sort', 'Name', 'users_id', @$lists['order_Dir'], @$lists['order'] ); ?></th>
						<th> Month </th>
						<th> Year </th>
						<th> Office Working Days </th>
						<th> User Leave Days</th>
						<th> Basic Pay </th>
						<th> Gross Salary </th>
						<th> Deduction </th>
						<th> Variable Allowance </th>
						<th>Month Salary </th>						
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="13">
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
					$link = JRoute::_( 'index.php?option=com_intranet&task=payslipedit&cid[]='.$row->id );
					$query = "select name from #__intranet_users where users_id='".$row->users_id."'";
					$db->setQuery($query);
					$uname = $db->loadRow();
					$name = $uname[0];
					$monthNames = Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
					?>
					<tr class="<?php echo "row$k"; ?>">	
						<td><?php echo $checked; ?></td>
						<td><?php echo $row->id; ?></td>
						<td> <a href="<?php echo $link; ?>"> <?php echo $name; ?>	</a> </td>
						<td> <?php echo $monthNames[$row->month-1]; ?>	</td> 
						<td><?php echo $row->year; ?></td>
						<td><?php echo $row->working_days; ?></td>
						<td><?php echo $row->leave_days; ?></td>
						<td><?php echo $row->basicpay_month; ?> </td>
						<td><?php echo $row->totalsalary_month; ?></td>
						<td><?php echo $row->deduction_month; ?></td>
						<td><?php echo $row->variable_allowance; ?> </td>
						<td><?php echo $row->salary_month; ?></td>						
					</tr>
					<?php
					$k = 1 - $k;
				}
				?>
			</table>
			<input type="hidden" name="option" value="com_intranet">
			<input type="hidden" name="task" value="payslip">    
			<input type="hidden" name="boxchecked" value="0"> 
			<input type="hidden" name="filter_order" value="<?php echo $lists['order']; ?>" />
			<input type="hidden" name="filter_order_Dir" value="" />
		</form>
		<?php
	}
	
	function payslipinsert()
	{
		JRequest::setVar( 'hidemainmenu', 1 );
		$db = &JFactory::getDBO();
		?>
		<script language="javascript" type="text/javascript">
		<!--	
			function submitbutton(pressbutton)
			{
				var form = document.adminForm;
				if (pressbutton == 'payslip')
				{
					submitform( pressbutton );
					return;
				}
				if(form.working_days.value.length==0)
				{
					alert('Enter the Office Working Days');
					form.working_days.focus();
					return false;
				}
				var ints = /^\d{1,2}$/;
				if(form.working_days.value.search(ints)==-1)
				{
					alert('No Special Character and characters are allowed ');
					form.working_days.focus();
					form.working_days.value='';
					return false;
				}
				if(form.worked_days.value.length==0)
				{
					alert('Enter the User Worked Days');
					form.worked_days.focus();
					return false;
				}
				var ints = /^\d{1,2}$/;
				if(form.worked_days.value.search(ints)==-1)
				{
					alert('No Special Character and characters are allowed ');
					form.worked_days.focus();
					form.worked_days.value='';
					return false;
				}
				if(form.leave_days.value.length==0)
				{
					alert('Enter the User leave Days');
					form.leave_days.focus();
					return false;
				}
				var ints = /^\d{1,2}$/;
				if(form.leave_days.value.search(ints)==-1)
				{
					alert('No Special Character and characters are allowed ');
					form.leave_days.focus();
					form.leave_days.value='';
					return false;
				}
				if(form.holidays.value.length==0)
				{
					alert('Enter the Office Holiday Days');
					form.holidays.focus();
					return false;
				}
				var ints = /^\d{1,2}$/;
				if(form.holidays.value.search(ints)==-1)
				{
					alert('No Special Character and characters are allowed ');
					form.holidays.focus();
					form.holidays.value='';
					return false;
				}
				var per = /^[0-9%]{1,5}$/;
				if(form.variable_allowance.value!='')
				{
					if(form.variable_allowance.value.search(per)==-1)
					{
						alert('No Special characters and characters are allowed');
						form.variable_allowance.focus();
						form.variable_allowance.value='';
						return false;
					}
				}
				submitform( pressbutton );
			}
		//-->
		</script>
		<?php
		if($_POST['users']!='' && $_POST['month']!='')
		{
			$users_id = $_POST['users'];
			$months = $_POST['month'];
		}
		?>
		<form action="index.php?option=com_intranet&task=payslipinsert" method="post" name="username">
			<table class="admintable">
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Name' ); ?>:
						</label>
					</td>
					<td>
						<select name="users">
							<option value="0">Select Users </option>
							<?php
							$query = "select users_id,name from #__intranet_users";
							$db->setQuery($query);
							$users = $db->loadAssocList();
							foreach($users as $row)
							{
								?>
								<option value="<?php echo $row['users_id']; ?>" <?php if($row['users_id']==$users_id) { ?> selected="selected" <?php } ?> >
									<?php echo $row['name']; ?> 
								</option>
								<?php
							}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Select Month' ); ?>:
						</label>
					</td>
					<td>
						<?php
						$monthNames = Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
						$m = count($monthNames);				
						?>							
						<select name="month" onchange="document.username.submit();" id="month">
							<option value=""> Select Month </option>
							<?php
							for($i=0; $i<$m; $i++)
							{
								?>
								<option value="<?php echo ($i+1); ?>" <?php if($months==($i+1)){ ?> selected="selected" <?php } ?>>
									<?php echo $monthNames[$i]; ?> 
								</option>
								<?php
							}
							?>
						</select> 
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Year' ); ?>:
						</label>
					</td>
					<td>
						<?php echo date("Y"); ?>
					</td>
				</tr>
			</table>
			<input type="hidden" name="option" value="com_intranet">
			<input type="hidden" name="task" value="payslipinsert">
		</form>
		<form action="index.php?option=com_intranet&task=payslip" method="post" name="adminForm">
			<?php
			$year = date("Y");
			$query = "select * from #__intranet_monthattendance where users_id='$users_id' and month='$months' and year='$year'";
			$db->setQuery($query);
			$result = $db->loadRow();
			$n = count($result);
			$query = "select * from #__intranet_payslip where users_id='$users_id' and month='$months' and year='$year'";
			$db->setQuery($query);
			$payslip = $db->loadRow();
			$pay = count($payslip)
			?>
			<table class="admintable">
				<?php
				if($n > 0 && $pay == 0)
				{
					$working_days = $result[7];
					$worked_days = $result[5];
					$leave_days = $result[6];
					$company_holidays = $result[8];
					$weekoff_days = $result[9];
					$query = "select basic_pay from #__intranet_users where users_id='$users_id'";
					$db->setQuery($query);
					$amt = $db->loadRow();						
					$basic_pay = $amt[0];
					?>
					<tr>
						<td class="key">
							<label for="name">
								<?php echo JText::_( 'Office Working Days ' ); ?>:
							</label>
						</td>
						<td>
							<input type="text" name="working_days" value="<?php echo $working_days; ?>" />
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="name">
								<?php echo JText::_( 'User Worked Days ' ); ?>:
							</label>
						</td>
						<td>
							<input type="text" name="worked_days" value="<?php echo $worked_days; ?>" />
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="name">
								<?php echo JText::_( 'User Leave Days ' ); ?>:
							</label>
						</td>
						<td>
							<input type="text" name="leave_days" value="<?php echo $leave_days; ?>" />
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="name">
								<?php echo JText::_( 'Holidays ' ); ?>:
							</label>
						</td>
						<td>
							<input type="text" name="holidays" value="<?php echo ($company_holidays + $weekoff_days); ?>" />
						</td>
					</tr>					
					<tr>
						<td class="key">
							<label for="name">
								<?php echo JText::_( 'Actual Basic Pay ' ); ?>:
							</label>
						</td>
						<td>
							<?php echo $basic_pay; ?>
							<input type="hidden" name="actual_basic_pay" value="<?php echo $basic_pay; ?>" />
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="name">
								<?php echo JText::_( 'Variable Allowance ' ); ?>:
							</label>
						</td>
						<td>
							<input type="text" name="variable_allowance" value="" /> put the Flat value like 3000 or like in percentage 10%
						</td>
					</tr>						
				<?php
				}
				else 
				{
					if($pay > 0)
					{
						echo "This users has already created Payslip for this month. Payslip as follows";
						?>
						<tr>
							<td class="key">
								<label for="name">
									<?php echo JText::_( 'Office Working Days ' ); ?>:
								</label>
							</td>
							<td>
								<?php echo $payslip[5]; ?>
							</td>
						</tr>
						<tr>
							<td class="key">
								<label for="name">
									<?php echo JText::_( 'User Worked Days ' ); ?>:
								</label>
							</td>
							<td>
								<?php echo $payslip[6]; ?>
							</td>
						</tr>
						<tr>
							<td class="key">
								<label for="name">
									<?php echo JText::_( 'User Leave Days ' ); ?>:
								</label>
							</td>
							<td>
								<?php echo $payslip[7]; ?>
							</td>
						</tr>
						<tr>
							<td class="key">
								<label for="name">
									<?php echo JText::_( 'Holidays ' ); ?>:
								</label>
							</td>
							<td>
								<?php echo $payslip[8]; ?>
							</td>
						</tr>
						<tr>
							<td class="key">
								<label for="name">
									<?php echo JText::_( 'Basic Pay for this Month ' ); ?>:
								</label>
							</td>
							<td>
								<?php echo $payslip[9]; ?>
							</td>
						</tr>
						<tr>
							<td class="key">
								<label for="name">
									<?php echo JText::_( 'Deduction for this Month ' ); ?>:
								</label>
							</td>
							<td>
								<?php echo $payslip[11]; ?>
							</td>
						</tr>
						<tr>
							<td class="key">
								<label for="name">
									<?php echo JText::_( 'Variable Allowance ' ); ?>:
								</label>
							</td>
							<td>
								<?php echo $payslip[4]; ?>
							</td>
						</tr>
						<tr>
							<td class="key">
								<label for="name">
									<?php echo JText::_( 'Salary for this Month ' ); ?>:
								</label>
							</td>
							<td>
								<?php echo $payslip[12]; ?>
							</td>
						</tr>
						<?php
					}
				}
				if(isset($users_id))
				{
					echo "No Records found in the attendance for the selected month and year";
				}
				?>
			</table>
			<input type="hidden" name="year" value="<?php echo date('Y'); ?>" />
			<input type="hidden" name="users_id" value="<?php echo $users_id; ?>" />
			<input type="hidden" name="month" value="<?php echo $months; ?>" />
			<input type="hidden" name="option" value="com_intranet">
			<input type="hidden" name="task" value="payslip">
		</form>
		<?php
	}
	
	function payslipedit(&$row)
	{
		JRequest::setVar( 'hidemainmenu', 1 );
		$db = &JFactory::getDBO();
		
		$users_id = $row->users_id;
		$month = $row->month;
		$year = $row->year;
		
		$query = "select * from #__intranet_monthattendance where users_id='$users_id' and month='$month' and year='$year'";
		$db->setQuery($query);
		$result = $db->loadRow();
		$name = $result[2];
		
		$query = "select basic_pay from #__intranet_users where users_id='$users_id'";
		$db->setQuery($query);
		$amt = $db->loadRow();						
		$basic_pay = $amt[0];	
		?>
		<script language="javascript" type="text/javascript">
		<!--	
			function submitbutton(pressbutton)
			{
				var form = document.adminForm;
				if (pressbutton == 'payslip')
				{
					submitform( pressbutton );
					return;
				}
				if(form.working_days.value.length==0)
				{
					alert('Enter the Office Working Days');
					form.working_days.focus();
					return false;
				}
				var ints = /^\d{1,2}$/;
				if(form.working_days.value.search(ints)==-1)
				{
					alert('No Special Character and characters are allowed ');
					form.working_days.focus();
					form.working_days.value='';
					return false;
				}
				if(form.worked_days.value.length==0)
				{
					alert('Enter the User Worked Days');
					form.worked_days.focus();
					return false;
				}
				var ints = /^\d{1,2}$/;
				if(form.worked_days.value.search(ints)==-1)
				{
					alert('No Special Character and characters are allowed ');
					form.worked_days.focus();
					form.worked_days.value='';
					return false;
				}
				if(form.leave_days.value.length==0)
				{
					alert('Enter the User leave Days');
					form.leave_days.focus();
					return false;
				}
				var ints = /^\d{1,2}$/;
				if(form.leave_days.value.search(ints)==-1)
				{
					alert('No Special Character and characters are allowed ');
					form.leave_days.focus();
					form.leave_days.value='';
					return false;
				}
				if(form.holidays.value.length==0)
				{
					alert('Enter the Office Holiday Days');
					form.holidays.focus();
					return false;
				}
				var ints = /^\d{1,2}$/;
				if(form.holidays.value.search(ints)==-1)
				{
					alert('No Special Character and characters are allowed ');
					form.holidays.focus();
					form.holidays.value='';
					return false;
				}
				var per = /^[0-9%]{1,5}$/;
				if(form.variable_allowance.value!='')
				{
					if(form.variable_allowance.value.search(per)==-1)
					{
						alert('No Special characters and characters are allowed');
						form.variable_allowance.focus();
						form.variable_allowance.value='';
						return false;
					}
				}
				submitform( pressbutton );
			}
		//-->
		</script>
		<form action="index.php?option=com_intranet&task=payslip" method="post" name="adminForm">
			<table class="admintable">
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Name ' ); ?>:
						</label>
					</td>
					<td>
						<?php echo $name; ?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Month ' ); ?>:
						</label>
					</td>
					<td>
						<?php 
						$monthNames = Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
						echo $monthNames[$row->month-1]; 
						?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Year ' ); ?>:
						</label>
					</td>
					<td>
						<?php echo $year; ?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Office Working Days ' ); ?>:
						</label>
					</td>
					<td>
						<input type="text" name="working_days" value="<?php echo $row->working_days; ?>" />
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'User Worked Days ' ); ?>:
						</label>
					</td>
					<td>
						<input type="text" name="worked_days" value="<?php echo $row->worked_days; ?>" />
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'User Leave Days ' ); ?>:
						</label>
					</td>
					<td>
						<input type="text" name="leave_days" value="<?php echo $row->leave_days; ?>" />
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Holidays ' ); ?>:
						</label>
					</td>
					<td>
						<input type="text" name="holidays" value="<?php echo $row->holidays; ?>" />
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Actual Basic Pay ' ); ?>:
						</label>
					</td>
					<td>
						<?php echo $basic_pay; ?>
						<input type="hidden" name="actual_basic_pay" value="<?php echo $basic_pay; ?>" />
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Variable Allowance ' ); ?>:
						</label>
					</td>
					<td>
						<input type="text" name="variable_allowance" value="<?php echo $row->variable_allowance; ?>" /> put the Flat value like 3000 or like in percentage 10%
					</td>
				</tr>
			</table>
			<input type="hidden" name="year" value="<?php echo $year; ?>" />
			<input type="hidden" name="users_id" value="<?php echo $users_id; ?>" />
			<input type="hidden" name="month" value="<?php echo $month; ?>" />
			<input type="hidden" name="option" value="com_intranet">
			<input type="hidden" name="task" value="payslip">
			<input type="hidden" name="id" value="<?php echo $row->id; ?>" />        
			<input type="hidden" name="cid[]" value="<?php echo $row->id; ?>" />
		</form>
		<?php
	}
	//Pay Slip Ends
	//Leave Request Starts
	function leaverequest(&$rows, &$pageNav, &$lists)
	{
		JHTML::_('behavior.tooltip');
		$db = &JFactory::getDBO();
		?>
		<form action="index.php?option=com_intranet&task=leaverequest" method="post" name="adminForm">
			<table>
				<tr>
					<td align="left" width="100%">
						<?php echo JText::_( 'Name' ); ?>:
						<select name="users" id="users" onchange="document.adminForm.submit();" >
							<option value=""> </option>
							<?php
							$query = "select users_id,name from #__intranet_users";
							$db->setQuery($query);
							$user = $db->loadAssocList();
							foreach($user as $row)
							{
								?>
								<option value="<?php echo $row['users_id']; ?>" <?php if($lists['users']==$row['users_id']){ ?> selected="selected" <?php } ?>>
									<?php echo $row['name']; ?> 
								</option>
								<?php
							}
							?>
						</select> &nbsp;												
						<?php
						$monthNames = Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
						$m = count($monthNames);				
						?>					
						<?php echo  JText::_('Month'); ?>:
						<select name="month" onchange="document.adminForm.submit();" id="month">
							<option value=""> </option>
							<?php
							for($i=0; $i<$m; $i++)
							{
								?>
								<option value="<?php echo ($i+1); ?>" <?php if($lists['month']==($i+1)){ ?> selected="selected" <?php } ?>>
									<?php echo $monthNames[$i]; ?> 
								</option>
								<?php
							}
							?>
						</select> &nbsp;
						<?php echo  JText::_('Year'); ?>:
						<select name="year" onchange="document.adminForm.submit();" id="year">
							<option value=""> </option>
							<?php
							for($i=2000; $i < 3000; $i++)
							{
								?>
								<option value="<?php echo $i; ?>" <?php if($lists['year']==$i){ ?> selected="selected" <?php } ?>><?php echo $i; ?> </option>
								<?php
							}
							?>
						</select> &nbsp;
						<button onclick="document.getElementById('users').value=''; document.getElementById('month').value=''; document.getElementById('year').value=''; this.form.submit();">
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
						<th width="50" class="title"><?php echo JHTML::_('grid.sort', 'ID', 'id', @$lists['order_Dir'], @$lists['order'] ); ?></td>
						<th><?php echo JHTML::_('grid.sort', 'From Name', 'fromusers_id', @$lists['order_Dir'], @$lists['order'] ); ?></th>
						<th> To Name </th>
						<th> Subject </th>
						<th> From Date </th>
						<th> To Date</th>
						<th> Approved </th>											
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
					$link = JRoute::_( 'index.php?option=com_intranet&task=leaverequestedit&cid[]='.$row->id );
					$query = "select name from #__intranet_users where users_id='".$row->fromusers_id."'";
					$db->setQuery($query);
					$uname = $db->loadRow();
					$from_name = $uname[0];
					$query = "select name from #__intranet_users where users_id='".$row->tousers_id."'";
					$db->setQuery($query);
					$uname1 = $db->loadRow();
					$to_name = $uname1[0];					
					?>
					<tr class="<?php echo "row$k"; ?>">	
						<td><?php echo $checked; ?></td>
						<td><a href="<?php echo $link; ?>"> <?php echo $row->id; ?> </a> </td>
						<td> <?php echo $from_name; ?> </td>
						<td> <?php echo $to_name; ?> </td>						
						<td><?php echo $row->subject; ?></td>
						<td><?php echo $row->fromdate; ?></td>
						<td><?php echo $row->todate; ?></td>
						<td><?php echo $row->approved; ?> </td>											
					</tr>
					<?php
					$k = 1 - $k;
				}
				?>
			</table>
			<input type="hidden" name="option" value="com_intranet">
			<input type="hidden" name="task" value="leaverequest">    
			<input type="hidden" name="boxchecked" value="0"> 
			<input type="hidden" name="filter_order" value="<?php echo $lists['order']; ?>" />
			<input type="hidden" name="filter_order_Dir" value="" />
		</form>
		<?php
	}
	
	function leaverequestinsert()
	{
		JRequest::setVar( 'hidemainmenu', 1 );
		$db = &JFactory::getDBO();
		$query = "select id,name from #__users where gid='25'";
		$db->setQuery($query);
		$nm = $db->loadRow();
		$to_name = $nm[1];
		$tousers_id = $nm[0];
		$query = "select users_id,name from #__intranet_users";
		$db->setQuery($query);
		$user = $db->loadAssocList();
		$query = "select leavetype from #__intranet_paymentsetting";				$db->setQuery($query);				$leave = $db->loadRow(); 				$leavetype = explode(",", $leave[0]);				$n = count($leavetype); 
		$month = date("m");
		$year = date("Y");
		?>
		<script language="javascript" type="text/javascript">
		<!--	
			function submitbutton(pressbutton)
			{
				var form = document.adminForm;
				if (pressbutton == 'leaverequest')
				{
					submitform( pressbutton );
					return;
				}
				if(form.fromusers_id.value==0)
				{
					alert('Please Select the Users name')
					form.fromusers_id.focus();
					return false;
				}
				if(form.subject.value==0)
				{
					alert('Please Select the Subject');
					form.subject.focus();
					return false;
				}
				if(form.fromdate.value=='')
				{
					alert('Please select the from date for leave');
					form.fromdate.focus();
					return false;
				}
				if(form.todate.value=='')
				{
					alert('please select the end date for leave');
					form.todate.focus();
					return false;
				}
				if(form.message.value=='')
				{
					alert('Enter the message for leave');
					form.message.focus();
					return false;
				}
				submitform( pressbutton );
			}
		//-->
		</script>
		<link rel="stylesheet" type="text/css" href="components/com_intranet/css/intranet.css" />
		<form action="index.php?option=com_intranet&task=leaverequest" method="post" name="adminForm">
			<table class="admintable">
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'From Name ' ); ?>:
						</label>
					</td>
					<td>
						<select name="fromusers_id" id="fromusers_id" >
							<option value="0"> Select Name </option>
							<?php							
							foreach($user as $row)
							{
								?>
								<option value="<?php echo $row['users_id']; ?>" >
									<?php echo $row['name']; ?> 
								</option>
								<?php
							}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'To Name ' ); ?>:
						</label>
					</td>
					<td>
						<?php echo $to_name; ?>
						<input type="hidden" name="tousers_id" value="<?php echo $tousers_id; ?>" />
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Subject ' ); ?>:
						</label>
					</td>
					<td>
						<select name="subject">
							<option value="0"> Select Subject </option>
							<?php
							for($i=0;$i<$n;$i++)
							{
								?>
								<option value="<?php echo $leavetype[$i]; ?>"><?php echo $leavetype[$i]; ?> </option>
								<?php
							}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'From Date ' ); ?>:
						</label>
					</td>
					<td>
						<?php echo JHTML::_('calendar',$mydate,'fromdate','fromdate','%Y-%m-%d','size="20",title ="fromdate", readonly="readonly"');?>
					</td>					
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'To Date ' ); ?>:
						</label>
					</td>
					<td>
						<?php echo JHTML::_('calendar',$mydate,'todate','todate','%Y-%m-%d','size="20",title ="todate", readonly="readonly"');?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Message ' ); ?>:
						</label>
					</td>
					<td>
						<textarea name="message" rows="5" cols="50"></textarea>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Approved ' ); ?>:
						</label>
					</td>
					<td>
						<input type="checkbox" name="approved" value="1" />
					</td>
				</tr>
			</table>
			<input type="hidden" name="daterequested" value="<?php echo date('Y-m-d'); ?>" />
			<input type="hidden" name="dateapproved" value="<?php echo date('Y-m-d'); ?>" />
			<input type="hidden" name="month" value="<?php echo $month; ?>">
			<input type="hidden" name="year" value="<?php echo $year; ?>">
			<input type="hidden" name="option" value="com_intranet">
			<input type="hidden" name="task" value="leaverequest">  
		</form>
		<?php
	}
	
	function leaverequestedit(&$row)
	{
		JRequest::setVar( 'hidemainmenu', 1 );
		$db = &JFactory::getDBO();
		$query = "select name from #__intranet_users where users_id=".$row->fromusers_id;
		$db->setQuery($query);
		$name = $db->loadRow();
		$fromname = $name[0];
		$query = "select name from #__intranet_users where users_id=".$row->tousers_id;
		$db->setQuery($query);
		$name1 = $db->loadRow();
		$toname = $name1[0];
		$query = "select leavetype from #__intranet_paymentsetting";				$db->setQuery($query);				$leave = $db->loadRow(); 				$leavetype = explode(",", $leave[0]);				$n = count($leavetype);
		?>
		<script language="javascript" type="text/javascript">
		<!--	
			function submitbutton(pressbutton)
			{
				var form = document.adminForm;
				if (pressbutton == 'leaverequest')
				{
					submitform( pressbutton );
					return;
				}
				if(form.fromusers_id.value==0)
				{
					alert('Please Select the Users name')
					form.fromusers_id.focus();
					return false;
				}
				if(form.subject.value==0)
				{
					alert('Please Select the Subject');
					form.subject.focus();
					return false;
				}
				if(form.fromdate.value=='')
				{
					alert('Please select the from date for leave');
					form.fromdate.focus();
					return false;
				}
				if(form.todate.value=='')
				{
					alert('please select the end date for leave');
					form.todate.focus();
					return false;
				}
				if(form.message.value=='')
				{
					alert('Enter the message for leave');
					form.message.focus();
					return false;
				}
				submitform( pressbutton );
			}
		//-->
		</script>
		<link rel="stylesheet" type="text/css" href="components/com_intranet/css/intranet.css" />
		<form action="index.php?option=com_intranet&task=leaverequest" method="post" name="adminForm">
			<table class="admintable">
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'From Name ' ); ?>:
						</label>
					</td>
					<td>
						<?php echo $fromname; ?>
						<input type="hidden" name="fromusers_id" value="<?php echo $row->fromusers_id; ?>" />
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'To Name ' ); ?>:
						</label>
					</td>
					<td>
						<?php echo $toname; ?>
						<input type="hidden" name="tousers_id" value="<?php echo $row->tousers_id; ?>" />
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Subject ' ); ?>:
						</label>
					</td>
					<td>
						<select name="subject">
							<option value="0"> Select Subject </option>
							<?php
							for($i=0;$i<$n;$i++)
							{
								?>
								<option value="<?php echo $leavetype[$i]; ?>" <?php if($row->subject==$leavetype[$i]) { ?> selected="selected" <?php } ?> >
									<?php echo $leavetype[$i]; ?> 
								</option>
								<?php
							}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'From Date ' ); ?>:
						</label>
					</td>
					<td>
						<?php echo JHTML::_('calendar',$row->fromdate,'fromdate','fromdate','%Y-%m-%d','size="20",title ="fromdate", readonly="readonly"');?>
					</td>					
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'To Date ' ); ?>:
						</label>
					</td>
					<td>
						<?php echo JHTML::_('calendar',$row->todate,'todate','todate','%Y-%m-%d','size="20",title ="todate", readonly="readonly"');?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Message ' ); ?>:
						</label>
					</td>
					<td>
						<textarea name="message" rows="5" cols="50"><?php echo $row->message; ?></textarea>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Approved ' ); ?>:
						</label>
					</td>
					<td>
						<?php
						if($row->approved==1)
						{
							?>
							<input type="checkbox" name="approved" value="1" checked="checked" />
							<?php
						}
						else
						{
							?>
							<input type="checkbox" name="approved" value="1" />
							<?php
						}
						?>						
					</td>
				</tr>
			</table>
			<input type="hidden" name="daterequested" value="<?php echo $row->daterequested; ?>" />
			<input type="hidden" name="dateapproved" value="<?php echo $row->dateapproved; ?>" />
			<input type="hidden" name="month" value="<?php echo $row->month; ?>">
			<input type="hidden" name="year" value="<?php echo $row->year; ?>">
			<input type="hidden" name="option" value="com_intranet">
			<input type="hidden" name="task" value="leaverequest"> 
			<input type="hidden" name="id" value="<?php echo $row->id; ?>" />        
			<input type="hidden" name="cid[]" value="<?php echo $row->id; ?>" />
		</form>
		<?php
	}
	//Leave Request Ends
}
?>