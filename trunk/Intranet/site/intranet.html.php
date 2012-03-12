<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

class IntranetHTML {
	
	function calendar()
	{
		$db = &JFactory::getDBO();
		$user = &JFactory::getUser();
		$user_id = $user->id;
		$user_name = $user->name;	
		$query = "select countryname from #__intranet_paymentsetting";
		$db->setQuery($query);
		$countryname = $db->loadRow();
		$country = $countryname[0];
		date_default_timezone_set($country);
		$times = date('H:i:s');
		$dates = date('Y-m-d');
		$months = date("m");
		$year = date("Y");
		//checking whether the yesterday out time has been put by the user
		$query = "select endtime from #__intranet_paymentsetting";
		$db->setQuery($query);
		$ends_times = $db->loadRow();
		$query = "select out_time,today_date,id,in_time from #__intranet_dailyattendance where users_id='$user_id' and today_date!='$dates' order by id desc limit 1";
		$db->setQuery($query);
		$out = $db->loadRow();
		$outtime = $out[0];
		$id = $out[2];
		$intime = $out[3];
		if($outtime=='00:00:00')
		{
			$in = strtotime($intime);
			$ot = strtotime($ends_times[0]);
			if($in > $ot)
			{
				$time = $intime;
				$total_hours = '00:00:00';
			}
			else
			{
				$time = $ends_times[0];
				$a1 = explode(":",$intime);
				$a2 = explode(":",$time);
				$time1 = (($a1[0]*60*60)+($a1[1]*60)+($a1[2]));
				$time2 = (($a2[0]*60*60)+($a2[1]*60)+($a2[2]));
				$diff = abs($time1-$time2);
				$hours = floor($diff/(60*60));
				$mins = floor(($diff-($hours*60*60))/(60));
				$secs = floor(($diff-(($hours*60*60)+($mins*60))));
				$total_hours = $hours.":".$mins.":".$secs;				
			}
			$query = "update #__intranet_dailyattendance set `out_time`='$time', `total_hours`='$total_hours' where id='$id' and users_id='$user_id'";
			$db->setQuery($query);
			$db->query();
		}
		//setting for today time
		$query = "select id,users_id,in_time,out_time,today_date from #__intranet_dailyattendance where users_id='$user_id' and today_date='$dates' order by id desc limit 1";
		$db->setQuery($query);
		$details = $db->loadRow();
		$ids = $details[0];
		$users_id = $details[1];
		$in_time = $details[2];
		$out_time = $details[3];
		$today_date = $details[4];
		//calendar starts
		$monthNames = Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
		if (!isset($_REQUEST["month"])) $_REQUEST["month"] = date("m");
		if (!isset($_REQUEST["year"]))  $_REQUEST["year"]  = date("Y");
		//Getting the year and month
		$cMonth = $_REQUEST["month"];
		$cYear  = $_REQUEST["year"];
		$month = strlen($cMonth);
		if($month==2)
		{
			$cMonth = $cMonth;
		}
		else
		{
			$mth = 0;
			$cMonth = $mth.$cMonth;
		}
		//Getting the values from the table
		$date = $cYear."-".$cMonth."-%";		
		$query = "select a.* from #__intranet_calendar as a where a.date like '".$date."'";
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		$query = "select b.* from #__intranet_calendarweeklyoff as b where b.date like '".$date."'";
		$db->setQuery($query);
		$rows1 = $db->loadObjectList();
		//Getting the next year and month
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
		<div id="intranet">
			<div id="menu">
				<ul>
					<li class="active"> <a href="index.php?option=com_intranet&task=calendar&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> Calendar </a> </li>
					<li> <a href="index.php?option=com_intranet&task=attendance&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> Attendance </a> </li>
					<li> <a href="index.php?option=com_intranet&task=leaverequest&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> Leave Request </a> </li>
					<li> <a href="index.php?option=com_intranet&task=payslip&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> Pay Slip </a> </li>
				</ul>
				<div id="in_out">
					<?php
					if($in_time!='00:00:00' && $out_time!='00:00:00')
					{
						?>
						<form name="newone" method="post" action="index.php?option=com_intranet&task=newattendance">
							<input type="hidden" name="users_id" value="<?php echo $user_id; ?>" />
							<input type="hidden" name="name" value="<?php echo $user_name; ?>" />
							<input type="hidden" name="today_date" value="<?php echo $dates; ?>" />
							<input type="hidden" name="in_time" value="<?php echo $times; ?>" />
							<input type="hidden" name="month" value="<?php echo $months; ?>" />
							<input type="hidden" name="year" value="<?php echo $year; ?>" />
							<input type="hidden" name="url" value="<?php echo $_SERVER["REQUEST_URI"]; ?>" />
							<input type="Submit" name="intime" value="Check In" />
						</form>
						<?php
					}
					if($in_time!='' && $out_time=='00:00:00')
					{
						?>
						<form name="newone" method="post" action="index.php?option=com_intranet&task=oldattendance">						
							<input type="hidden" name="users_id" value="<?php echo $users_id; ?>" />	
							<input type="hidden" name="id" value="<?php echo $ids; ?>" />								
							<input type="hidden" name="today_date" value="<?php echo $today_date; ?>" />
							<input type="hidden" name="in_time" value="<?php echo $in_time; ?>" />
							<input type="hidden" name="out_time" value="<?php echo $times; ?>" />
							<input type="hidden" name="url" value="<?php echo $_SERVER["REQUEST_URI"]; ?>" />
							<input type="Submit" name="outtime" value="Check Out" />
						</form>
						<?php
					}
					?>
				</div>
				<div id="calendar_div" name="calendar_div">
					<div id="pre_nxt">
						<div class="showpre">
							<a href="<?php echo $_SERVER["PHP_SELF"] . "?option=".$_REQUEST['option']."&task=calendar&month=". $prev_month . "&year=" . $prev_year."&Itemid=".$_REQUEST['Itemid']; ?>" >Previous</a>
						</div>
						<div class="showmonth">
							<?php echo $monthNames[$cMonth-1].' '.$cYear; ?>
						</div>
						<div class="shownxt">
							<a href="<?php echo $_SERVER["PHP_SELF"] . "?option=".$_REQUEST['option']."&task=calendar&month=". $next_month . "&year=" . $next_year."&Itemid=".$_REQUEST['Itemid']; ?>" >Next</a>
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
								if(($i % 7) == 0 )
								?>
								<div class='full_row'>
									<?php
									if($i < $startday)
									{
										?>
										<div class='no_row'></div>
										<?php
									}
									else
									{
										?>
										<div class='dates'>
											<?php
											$d = ($i - $startday + 1);
											$ds = $d - 1;
											if($d==$curr_date)
											{
												?>
												<span class='curr_date'> <?php echo $d; ?> </span>
												<?php
												for($ds=0; $ds < $d; $ds++)
												{
													$row = &$rows[$ds];
													$dts = $row->dt;
													if($d==$dts)
													{
														if($row->event_title!='')
														{
															$desc = $row->event_title;
															$time = $row->eventstart_time." - ".$row->eventend_time;
														}
														if($row->holiday_title!='')
														{
															$desc = $row->holiday_title;
															$holiday = array('Weekly off', 'Religious Holiday', 'Government Holiday');
															$time = $holiday[$row->holiday_type-1];
														}
														?>
														<div class='event'>
															<div class='event_desc'> <?php echo $desc; ?> <div> <?php echo $time; ?> </div> </div>
														</div>
														<?php
													}
													$row1 = &$rows1[$ds];
													$dts1 = $row1->dt;
													if($d==$dts1)
													{
														?>
														<div class='event_desc'><img src="components/com_intranet/holiday.gif"> <div> Weekly Off </div> </div>
														<?php
													}
												}
											}
											else
											{
												?>
												<span class='show_date'> <?php echo $d; ?> </span>
												<?php
												for($ds=0; $ds < $d; $ds++)
												{
													$row = &$rows[$ds];
													$dts = $row->dt;
													if($d==$dts)
													{
														if($row->event_title!='')
														{
															$desc = $row->event_title;
															$time = $row->eventstart_time." - ".$row->eventend_time;
														}
														if($row->holiday_title!='')
														{
															$desc = $row->holiday_title;
															$holiday = array('Weekly off', 'Religious Holiday', 'Government Holiday');
															$time = $holiday[$row->holiday_type-1];
														}
														?>
														<div class='event'>
															<div class='event_desc'> <?php echo $desc; ?> <div> <?php echo $time; ?> </div> </div>
														</div>
														<?php
													}
													$row1 = &$rows1[$ds];
													$dts1 = $row1->dt;
													if($d==$dts1)
													{
														?>
														<div class='event_desc'><img src="components/com_intranet/holiday.gif"> <div> Weekly Off </div> </div>
														<?php
													}
												}
											}
											?>
										</div>
										<?php
									}
									if(($i % 7) == 6 )
									?>
								</div>
								<?php
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
	
	function attendance()
	{
		$db = &JFactory::getDBO();
		$user = &JFactory::getUser();
		$user_id = $user->id;
		$user_name = $user->name;
		$query = "select countryname from #__intranet_paymentsetting";
		$db->setQuery($query);
		$countryname = $db->loadRow();
		$country = $countryname[0];
		date_default_timezone_set($country);
		$times = date('H:i:s');
		$dates = date('Y-m-d');
		$months = date("m");
		$year = date("Y");
		//checking whether the yesterday out time has been put by the user
		$query = "select endtime from #__intranet_paymentsetting";
		$db->setQuery($query);
		$ends_times = $db->loadRow();
		$query = "select out_time,today_date,id,in_time from #__intranet_dailyattendance where users_id='$user_id' and today_date!='$dates' order by id desc limit 1";
		$db->setQuery($query);
		$out = $db->loadRow();
		$outtime = $out[0];
		$id = $out[2];
		$intime = $out[3];
		if($outtime=='00:00:00')
		{
			$in = strtotime($intime);
			$ot = strtotime($ends_times[0]);
			if($in > $ot)
			{
				$time = $intime;
				$total_hours = '00:00:00';
			}
			else
			{
				$time = $ends_times[0];
				$a1 = explode(":",$intime);
				$a2 = explode(":",$time);
				$time1 = (($a1[0]*60*60)+($a1[1]*60)+($a1[2]));
				$time2 = (($a2[0]*60*60)+($a2[1]*60)+($a2[2]));
				$diff = abs($time1-$time2);
				$hours = floor($diff/(60*60));
				$mins = floor(($diff-($hours*60*60))/(60));
				$secs = floor(($diff-(($hours*60*60)+($mins*60))));
				$total_hours = $hours.":".$mins.":".$secs;				
			}
			$query = "update #__intranet_dailyattendance set `out_time`='$time', `total_hours`='$total_hours' where id='$id' and users_id='$user_id'";
			$db->setQuery($query);
			$db->query();
		}
		//setting for today time
		$query = "select id,users_id,in_time,out_time,today_date from #__intranet_dailyattendance where users_id='$user_id' and today_date='$dates' order by id desc limit 1";
		$db->setQuery($query);
		$details = $db->loadRow();
		$ids = $details[0];
		$users_id = $details[1];
		$in_time = $details[2];
		$out_time = $details[3];
		$today_date = $details[4];
		//Getting the months name
		$monthNames = Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
		$n = count($monthNames);
		//Getting the post values
			if($_POST['monthly']=='')
			{
				$monthly = date("m");
			}
			else
			{
				$monthly = $_POST['monthly'];
			}
			if($_POST['yearly']=='')
			{
				$yearly = date("Y");
			}
			else
			{
				$yearly = $_POST['yearly'];
			}
			$m = strlen($monthly);
			if($m==2)
			{
				$monthly = $monthly;
			}
			else
			{
				$mth = 0;
				$monthly = $mth.$monthly;
			}
			//Get the Attendance Details
			$query = "select a.users_id,a.today_date,a.month,a.year from #__intranet_dailyattendance as a where a.month='$monthly' and a.year='$yearly' and a.users_id='$user_id' group by a.today_date,name having count(*) >= 1 order by a.today_date asc ";			
			$db->setQuery($query);
			$rows2 = $db->loadObjectList();
			//Getting the calendar details
			$dt = $yearly."-".$monthly."-%";
			$query = "select a.* from #__intranet_calendar as a where a.holiday='1' and a.date like '".$dt."'";
			$db->setQuery($query);
			$rows = $db->loadObjectList();
			$query = "select b.* from #__intranet_calendarweeklyoff as b where b.date like '".$dt."'";
			$db->setQuery($query);
			$rows1 = $db->loadObjectList();
			//Get the leave details
			$query = "select fromdate,todate from #__intranet_leaverequest where fromusers_id='$user_id' and month='$monthly' and year='$yearly' and approved='1'";
			$db->setQuery($query);
			$rows3 = $db->loadObjectList();
		
		?>		
		<div id="intranet">
			<div id="menu">
				<ul>
					<li> <a href="index.php?option=com_intranet&task=calendar&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> Calendar </a> </li>
					<li  class="active"> <a href="index.php?option=com_intranet&task=attendance&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> Attendance </a> </li>
					<li> <a href="index.php?option=com_intranet&task=leaverequest&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> Leave Request </a> </li>
					<li> <a href="index.php?option=com_intranet&task=payslip&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> Pay Slip </a> </li>
				</ul>
				<div id="in_out">
					<?php
					if($in_time!='00:00:00' && $out_time!='00:00:00')
					{
						?>
						<form name="newone" method="post" action="index.php?option=com_intranet&task=newattendance">
							<input type="hidden" name="users_id" value="<?php echo $user_id; ?>" />
							<input type="hidden" name="name" value="<?php echo $user_name; ?>" />
							<input type="hidden" name="today_date" value="<?php echo $dates; ?>" />
							<input type="hidden" name="in_time" value="<?php echo $times; ?>" />
							<input type="hidden" name="month" value="<?php echo $months; ?>" />
							<input type="hidden" name="year" value="<?php echo $year; ?>" />
							<input type="hidden" name="url" value="<?php echo $_SERVER["REQUEST_URI"]; ?>" />
							<input type="Submit" name="intime" value="Check In" />
						</form>
						<?php
					}
					if($in_time!='' && $out_time=='00:00:00')
					{
						?>
						<form name="newone" method="post" action="index.php?option=com_intranet&task=oldattendance">						
							<input type="hidden" name="users_id" value="<?php echo $users_id; ?>" />	
							<input type="hidden" name="id" value="<?php echo $ids; ?>" />								
							<input type="hidden" name="today_date" value="<?php echo $today_date; ?>" />
							<input type="hidden" name="in_time" value="<?php echo $in_time; ?>" />
							<input type="hidden" name="out_time" value="<?php echo $times; ?>" />
							<input type="hidden" name="url" value="<?php echo $_SERVER["REQUEST_URI"]; ?>" />
							<input type="Submit" name="outtime" value="Check Out" />
						</form>
						<?php
					}
					?>
				</div>
				<div id="view_attendance">
					<div id="attendance_menu">
						<div class="menus"> <a href="index.php?option=com_intranet&task=attendance&Itemid=<?php echo $_REQUEST['Itemid']; ?>" class="active"> View Monthly Attendance  </a> </div>
						<div class="menus"> <a href="index.php?option=com_intranet&task=weeklyattendance&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> View Weekly Attendance  </a>  </div>
						<div class="menus"> <a href="index.php?option=com_intranet&task=dailyattendance&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> View Daily Attendance   </a> </div>
					</div>
					<div id="attendance_content">
						<div id="monthly">
							<h2 class="heads"> View Monthly Attendance </h2>
							<form name="month" method="post" action="index.php?option=com_intranet&task=attendance&Itemid=<?php echo $_REQUEST['Itemid']; ?>">
								<div class="options"> Select a year :
									<select name="yearly">
										<option value="0"> Select Year </option>
										<?php
										for($i=2000;$i<3000;$i++)
										{
											?>
											<option value="<?php echo $i; ?>" <?php if($yearly==$i) { ?> selected="seleccted" <?php } ?> > 
												<?php echo $i; ?> 
											</option>
											<?php
										}
										?>
									</select>
								</div>
								<div class="options"> Select a Month : 
									<select name="monthly">
										<option value="0"> Select Month </option>
										<?php
										for($i=0;$i<$n;$i++)
										{
											?>
											<option value="<?php echo ($i+1); ?>" <?php if($monthly==($i+1)) { ?> selected="selected" <?php } ?> >
												<?php echo $monthNames[$i]; ?> 
											</option>
											<?php
										}
										?>
									</select>
								</div>								
								<div class="submits"> <input type="submit" name="monthly_submit" value="Get Attendance" /> </div>								
							</form>
							
								<div id="calendar_div1" name="calendar_div1">
									<div id="showcalender1">
										<div id="cal_head1">
											<div class="showdays1">Sunday</div>
											<div class="showdays1">Monday</div>
											<div class="showdays1">Tuesday</div>
											<div class="showdays1">Wednesday</div>
											<div class="showdays1">Thusday</div>
											<div class="showdays1">Friday</div>
											<div class="showdays1">Saturday</div>
										</div>
										<div id="cal_content1">
											<?php
											$timestamp = mktime(0,0,0,$monthly,1,$yearly);
											$maxday    = date("t",$timestamp);				
											$thismonth = getdate ($timestamp); 
											$startday  = $thismonth['wday'];
											$curr_date = date('d');
											for ($i=0; $i<($maxday+$startday); $i++)
											{
												if(($i % 7) == 0 )
												?>
												<div class='full_row1'>
													<?php
													if($i < $startday)
													{
														?>
														<div class='no_row1'></div>
														<?php
													}
													else
													{
														?>
														<div class='dates1'>
															<?php
															$d = ($i - $startday + 1);
															$ds = $d - 1;
															if($d==$curr_date)
															{
																?>
																<span class='curr_date1'> <?php echo $d; ?> </span>
																<?php
																for($ds=0; $ds < $d; $ds++)
																{
																	$row = &$rows[$ds];
																	$dts = $row->dt;
																	if($d==$dts)
																	{
																		if($row->holiday_title!='')
																		{
																			$holiday = array('Weekly off', 'Religious Holiday', 'Government Holiday');
																			$time = $holiday[$row->holiday_type-1];
																		}
																		?>
																		<div class='event1'>
																			<div class='event_desc1'> 
																				<?php echo $time; ?> 
																			</div>
																		</div>
																		<?php
																	}
																	$row1 = &$rows1[$ds];
																	$dts1 = $row1->dt;
																	if($d==$dts1)
																	{
																		?>
																		<div class='event_desc2'><img src="components/com_intranet/holiday.gif"> <div> Weekly Off </div> </div>
																		<?php
																	}
																	$row2 = &$rows2[$ds];
																	$dd = $row2->today_date;
																	$dt2 = substr($dd, -2);
																	$dts2 = $dt2;
																	if($d==$dts2)
																	{
																		?>
																		<div class='event_desc3'> <img src="components/com_intranet/correct.gif"> </div>
																		<?php
																	}
																	$row3 = &$rows3[$ds];
																	$fromdate = $row3->fromdate;
																	$todate = $row3->todate;
																	$dateMonthYearArr = array();
																	$fromDateTS = strtotime($fromdate);
																	$toDateTS = strtotime($todate);
																	for ($currentDateTS = $fromDateTS; $currentDateTS <= $toDateTS; $currentDateTS += (60 * 60 * 24))
																	{
																		$currentDateStr = date("Y-m-d",$currentDateTS);
																		$dateMonthYearArr[] = $currentDateStr;
																	}
																	$n = count($dateMonthYearArr);
																	for($nm=0;$nm<$n;$nm++)
																	{
																		$dd1 = $dateMonthYearArr[$nm];
																		$dt3 = substr($dd1, -2);
																		$dts3 = $dt3;
																		$y3 = substr($dd1, 0, 4);
																		$yr = date("Y");
																		if($d==$dts3 && $y3==$yr)
																		{
																			?>
																			<div class='event_desc3'> <img src="components/com_intranet/holiday.gif"> </div>
																			<?php
																		}
																	}
																}
															}
															else
															{
																?>
																<span class='show_date1'> <?php echo $d; ?> </span>
																<?php
																for($ds=0; $ds < $d; $ds++)
																{
																	$row = &$rows[$ds];
																	$dts = $row->dt;
																	if($d==$dts)
																	{
																		if($row->holiday_title!='')
																		{
																			$desc = $row->holiday_title;
																			$holiday = array('Weekly off', 'Religious Holiday', 'Government Holiday');
																			$time = $holiday[$row->holiday_type-1];
																		}
																		?>
																		<div class='event1'>
																			<div class='event_desc1'> 
																				<?php echo $time; ?>  
																			</div>
																		</div>
																		<?php
																	}
																	$row1 = &$rows1[$ds];
																	$dts1 = $row1->dt;
																	if($d==$dts1)
																	{
																		?>
																		<div class='event_desc2'><img src="components/com_intranet/holiday.gif"> <div> Weekly Off </div> </div>
																		<?php
																	}
																	$row2 = &$rows2[$ds];
																	$dd = $row2->today_date;
																	$dt2 = substr($dd, -2);
																	$dts2 = $dt2;
																	if($d==$dts2)
																	{
																		?>
																		<div class='event_desc3'> <img src="components/com_intranet/correct.gif"> </div>
																		<?php
																	}
																	$row3 = &$rows3[$ds];
																	$fromdate = $row3->fromdate;
																	$todate = $row3->todate;
																	$dateMonthYearArr = array();
																	$fromDateTS = strtotime($fromdate);
																	$toDateTS = strtotime($todate);
																	for ($currentDateTS = $fromDateTS; $currentDateTS <= $toDateTS; $currentDateTS += (60 * 60 * 24))
																	{
																		$currentDateStr = date("Y-m-d",$currentDateTS);
																		$dateMonthYearArr[] = $currentDateStr;
																	}
																	$n = count($dateMonthYearArr);
																	for($nm=0;$nm<$n;$nm++)
																	{
																		$dd1 = $dateMonthYearArr[$nm];
																		$dt3 = substr($dd1, -2);
																		$dts3 = $dt3;
																		$y3 = substr($dd1, 0, 4);
																		$yr = date("Y");
																		if($d==$dts3 && $y3==$yr)
																		{
																			?>
																			<div class='event_desc3'> <img src="components/com_intranet/holiday.gif"> </div>
																			<?php
																		}
																	}																	
																}
															}
															?>
														</div>
														<?php
													}
													if(($i % 7) == 6 )
													?>
												</div>
												<?php
											}
											?>
										</div>
									</div>
								</div>
								
						</div>						
					</div>
				</div>
			</div>
		</div>
		<?php
	}
	
	function weeklyattendance()
	{
		$db = &JFactory::getDBO();
		$user = &JFactory::getUser();
		$user_id = $user->id;
		$user_name = $user->name;
		$query = "select countryname from #__intranet_paymentsetting";
		$db->setQuery($query);
		$countryname = $db->loadRow();
		$country = $countryname[0];
		date_default_timezone_set($country);
		$times = date('H:i:s');
		$dates = date('Y-m-d');
		$months = date("m");
		$year = date("Y");
		//setting for today time
		$query = "select id,users_id,in_time,out_time,today_date from #__intranet_dailyattendance where users_id='$user_id' and today_date='$dates' order by id desc limit 1";
		$db->setQuery($query);
		$details = $db->loadRow();
		$ids = $details[0];
		$users_id = $details[1];
		$in_time = $details[2];
		$out_time = $details[3];
		$today_date = $details[4];
		//Get the post values
		if(isset($_POST['weekly_submit']))
		{
			$fromdate = $_POST['dates'];
			$from = strtotime($fromdate);
			$todate = date('Y-m-d', strtotime('+7 day', $from));
			$query = "select * from #__intranet_dailyattendance where users_id='$user_id' and today_date between '$fromdate' and '$todate' order by today_date asc";
			$db->setQuery($query);
			$week = $db->loadAssocList();
			$n = count($week);
			$mydate = $fromdate;
		}
		?>
		<div id="intranet">
			<div id="menu">
				<ul>
					<li> <a href="index.php?option=com_intranet&task=calendar&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> Calendar </a> </li>
					<li  class="active"> <a href="index.php?option=com_intranet&task=attendance&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> Attendance </a> </li>
					<li> <a href="index.php?option=com_intranet&task=leaverequest&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> Leave Request </a> </li>
					<li> <a href="index.php?option=com_intranet&task=payslip&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> Pay Slip </a> </li>
				</ul>
				<div id="in_out">
					<?php
					if($in_time!='00:00:00' && $out_time!='00:00:00')
					{
						?>
						<form name="newone" method="post" action="index.php?option=com_intranet&task=newattendance">
							<input type="hidden" name="users_id" value="<?php echo $user_id; ?>" />
							<input type="hidden" name="name" value="<?php echo $user_name; ?>" />
							<input type="hidden" name="today_date" value="<?php echo $dates; ?>" />
							<input type="hidden" name="in_time" value="<?php echo $times; ?>" />
							<input type="hidden" name="month" value="<?php echo $months; ?>" />
							<input type="hidden" name="year" value="<?php echo $year; ?>" />
							<input type="hidden" name="url" value="<?php echo $_SERVER["REQUEST_URI"]; ?>" />
							<input type="Submit" name="intime" value="Check In" />
						</form>
						<?php
					}
					if($in_time!='' && $out_time=='00:00:00')
					{
						?>
						<form name="newone" method="post" action="index.php?option=com_intranet&task=oldattendance">						
							<input type="hidden" name="users_id" value="<?php echo $users_id; ?>" />	
							<input type="hidden" name="id" value="<?php echo $ids; ?>" />								
							<input type="hidden" name="today_date" value="<?php echo $today_date; ?>" />
							<input type="hidden" name="in_time" value="<?php echo $in_time; ?>" />
							<input type="hidden" name="out_time" value="<?php echo $times; ?>" />
							<input type="hidden" name="url" value="<?php echo $_SERVER["REQUEST_URI"]; ?>" />
							<input type="Submit" name="outtime" value="Check Out" />
						</form>
						<?php
					}
					?>
				</div>
				<div id="view_attendance">
					<div id="attendance_menu">
						<div class="menus"> <a href="index.php?option=com_intranet&task=attendance&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> View Monthly Attendance  </a> </div>
						<div class="menus"> <a href="index.php?option=com_intranet&task=weeklyattendance&Itemid=<?php echo $_REQUEST['Itemid']; ?>" class="active"> View Weekly Attendance  </a>  </div>
						<div class="menus"> <a href="index.php?option=com_intranet&task=dailyattendance&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> View Daily Attendance   </a> </div>
					</div>
					<div id="attendance_content">
						<div id="weekly">
							<h2 class="heads"> View Weekly Attendance </h2>
							<form name="weekly" method="post" action="index.php?option=com_intranet&task=weeklyattendance&Itemid=<?php echo $_REQUEST['Itemid']; ?>">
								<div class="options1">
									Show attendance for the week starting from : 
									<?php echo JHTML::_('calendar',$mydate,'dates','dates','%Y-%m-%d','size="20",title ="dates", readonly="readonly"');?>
								</div>
								<div class="submits">
									<input type="submit" name="weekly_submit" value="Get Attendance" />
								</div>
							</form>
							<?php
							if(isset($_POST['weekly_submit']))
							{
								if($n > 0)
								{
								?>
									<div class="views">
										<div class="viewheads"> Date </div>
										<div class="viewheads"> Day </div>
										<div class="viewheads"> In Time </div>
										<div class="viewheads"> Out Time </div>
										<div class="viewheads"> Total Hours </div>
										<div class="viewheads"> Hours </div>
										<?php
										$dt = '';
										$tot = '';
										foreach($week as $row)
										{
											$today_date = $row['today_date'];
											$day = date("l",strtotime($today_date));
											$in_time = $row['in_time'];
											$out_time = $row['out_time'];
											$tot_hrs = $row['total_hours'];
											
											if($dt==$today_date)
											{
												$times = array($hr, $tot_hrs);
												$seconds = 0;
												foreach ($times as $time)
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
												$tot = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
												?>
												<div class="viewtails1"> </div>	
												<div class="viewtails1"> </div>													
												<div class="viewtails"> <?php echo $in_time; ?> </div>
												<div class="viewtails"> <?php echo $out_time; ?> </div>
												<div class="viewtails"> <?php echo $tot_hrs; ?> </div>
												<div class="viewtails3">  <?php echo $tot; ?> </div>
												
												<?php
											}	
											else
											{
												?>
												<div class="viewtails"> <?php echo $today_date; ?> </div>
												<div class="viewtails"> <?php echo $day; ?> </div>
												<div class="viewtails"> <?php echo $in_time; ?> </div>
												<div class="viewtails"> <?php echo $out_time; ?> </div>
												<div class="viewtails"> <?php echo $tot_hrs; ?> </div>
												<div class="viewtails2">  </div>
												<?php
											}
											$dt = $today_date;
											if($tot=='')
											{
												$hr = $tot_hrs;
											}
											else
											{
												$hr = $tot;
											}
										}
										?>
									</div>
								<?php
								}
								else
								{
									echo "No Records Found for this above Date selected";
								}
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
	
	function dailyattendance()
	{
		$db = &JFactory::getDBO();
		$user = &JFactory::getUser();
		$user_id = $user->id;
		$user_name = $user->name;
		$query = "select countryname from #__intranet_paymentsetting";
		$db->setQuery($query);
		$countryname = $db->loadRow();
		$country = $countryname[0];
		date_default_timezone_set($country);
		$times = date('H:i:s');
		$dates = date('Y-m-d');
		$months = date("m");
		$year = date("Y");
		//setting for today time
		$query = "select id,users_id,in_time,out_time,today_date from #__intranet_dailyattendance where users_id='$user_id' and today_date='$dates' order by id desc limit 1";
		$db->setQuery($query);
		$details = $db->loadRow();
		$ids = $details[0];
		$users_id = $details[1];
		$in_time = $details[2];
		$out_time = $details[3];
		$today_date = $details[4];
		//Get the post values
		if(isset($_POST['daily_submit']))
		{
			$fromdate = $_POST['dates'];
			$query = "select * from #__intranet_dailyattendance where users_id='$user_id' and today_date='$fromdate'";
			$db->setQuery($query);
			$week = $db->loadAssocList();
			$n = count($week);
			$mydate = $fromdate;
		}
		?>
		<div id="intranet">
			<div id="menu">
				<ul>
					<li> <a href="index.php?option=com_intranet&task=calendar&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> Calendar </a> </li>
					<li  class="active"> <a href="index.php?option=com_intranet&task=attendance&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> Attendance </a> </li>
					<li> <a href="index.php?option=com_intranet&task=leaverequest&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> Leave Request </a> </li>
					<li> <a href="index.php?option=com_intranet&task=payslip&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> Pay Slip </a> </li>
				</ul>
				<div id="in_out">
					<?php
					if($in_time!='00:00:00' && $out_time!='00:00:00')
					{
						?>
						<form name="newone" method="post" action="index.php?option=com_intranet&task=newattendance">
							<input type="hidden" name="users_id" value="<?php echo $user_id; ?>" />
							<input type="hidden" name="name" value="<?php echo $user_name; ?>" />
							<input type="hidden" name="today_date" value="<?php echo $dates; ?>" />
							<input type="hidden" name="in_time" value="<?php echo $times; ?>" />
							<input type="hidden" name="month" value="<?php echo $months; ?>" />
							<input type="hidden" name="year" value="<?php echo $year; ?>" />
							<input type="hidden" name="url" value="<?php echo $_SERVER["REQUEST_URI"]; ?>" />
							<input type="Submit" name="intime" value="Check In" />
						</form>
						<?php
					}
					if($in_time!='' && $out_time=='00:00:00')
					{
						?>
						<form name="newone" method="post" action="index.php?option=com_intranet&task=oldattendance">						
							<input type="hidden" name="users_id" value="<?php echo $users_id; ?>" />	
							<input type="hidden" name="id" value="<?php echo $ids; ?>" />								
							<input type="hidden" name="today_date" value="<?php echo $today_date; ?>" />
							<input type="hidden" name="in_time" value="<?php echo $in_time; ?>" />
							<input type="hidden" name="out_time" value="<?php echo $times; ?>" />
							<input type="hidden" name="url" value="<?php echo $_SERVER["REQUEST_URI"]; ?>" />
							<input type="Submit" name="outtime" value="Check Out" />
						</form>
						<?php
					}
					?>
				</div>
				<div id="view_attendance">
					<div id="attendance_menu">
						<div class="menus"> <a href="index.php?option=com_intranet&task=attendance&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> View Monthly Attendance  </a> </div>
						<div class="menus"> <a href="index.php?option=com_intranet&task=weeklyattendance&Itemid=<?php echo $_REQUEST['Itemid']; ?>" > View Weekly Attendance  </a>  </div>
						<div class="menus"> <a href="index.php?option=com_intranet&task=dailyattendance&Itemid=<?php echo $_REQUEST['Itemid']; ?>" class="active"> View Daily Attendance   </a> </div>
					</div>
					<div id="attendance_content">
						<div id="weekly">
							<h2 class="heads"> View Daily Attendance </h2>
							<form name="weekly" method="post" action="index.php?option=com_intranet&task=dailyattendance&Itemid=<?php echo $_REQUEST['Itemid']; ?>">
								<div class="options1">
									Select the Date : 
									<?php echo JHTML::_('calendar',$mydate,'dates','dates','%Y-%m-%d','size="20",title ="dates", readonly="readonly"');?>
								</div>
								<div class="submits">
									<input type="submit" name="daily_submit" value="Submits" />
								</div>
							</form>
							<?php
							if(isset($_POST['daily_submit']))
							{
								if($n > 0)
								{
								?>
									<div class="views">
										<div class="viewheads"> Date </div>
										<div class="viewheads"> Day </div>
										<div class="viewheads"> In Time </div>
										<div class="viewheads"> Out Time </div>
										<div class="viewheads"> Total Hours </div>
										<div class="viewheads"> Hours </div>
										<?php
										$dt = '';
										$tot = '';
										foreach($week as $row)
										{
											$today_date = $row['today_date'];
											$day = date("l",strtotime($today_date));
											$in_time = $row['in_time'];
											$out_time = $row['out_time'];
											$tot_hrs = $row['total_hours'];
											
											if($dt==$today_date)
											{
												$times = array($hr, $tot_hrs);
												$seconds = 0;
												foreach ($times as $time)
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
												$tot = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);												
												?>
												<div class="viewtails1"> </div>	
												<div class="viewtails1"> </div>													
												<div class="viewtails"> <?php echo $in_time; ?> </div>
												<div class="viewtails"> <?php echo $out_time; ?> </div>
												<div class="viewtails"> <?php echo $tot_hrs; ?> </div>
												<div class="viewtails3">  <?php echo $tot; ?> </div>												
												<?php												
											}	
											else
											{
												?>
												<div class="viewtails"> <?php echo $today_date; ?> </div>
												<div class="viewtails"> <?php echo $day; ?> </div>
												<div class="viewtails"> <?php echo $in_time; ?> </div>
												<div class="viewtails"> <?php echo $out_time; ?> </div>
												<div class="viewtails"> <?php echo $tot_hrs; ?> </div>
												<div class="viewtails2"> <div id="hrs"> </div> </div>
												<?php
											}
											$dt = $today_date;
											if($tot=='')
											{
												$hr = $tot_hrs;
											}
											else
											{
												$hr = $tot;
											}
										}
										?>
									</div>
								<?php
								}
								else
								{
									echo "No Records Found for this above Date selected";
								}
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	function leaverequest()
	{
		$db = &JFactory::getDBO();
		$user = &JFactory::getUser();
		$user_id = $user->id;
		$user_name = $user->name;
		$query = "select countryname from #__intranet_paymentsetting";
		$db->setQuery($query);
		$countryname = $db->loadRow();
		$country = $countryname[0];
		date_default_timezone_set($country);
		$times = date('H:i:s');
		$dates = date('Y-m-d');
		$months = date("m");
		$year = date("Y");
		//checking whether the yesterday out time has been put by the user
		$query = "select endtime from #__intranet_paymentsetting";
		$db->setQuery($query);
		$ends_times = $db->loadRow();
		$query = "select out_time,today_date,id,in_time from #__intranet_dailyattendance where users_id='$user_id' and today_date!='$dates' order by id desc limit 1";
		$db->setQuery($query);
		$out = $db->loadRow();
		$outtime = $out[0];
		$id = $out[2];
		$intime = $out[3];
		if($outtime=='00:00:00')
		{
			$in = strtotime($intime);
			$ot = strtotime($ends_times[0]);
			if($in > $ot)
			{
				$time = $intime;
				$total_hours = '00:00:00';
			}
			else
			{
				$time = $ends_times[0];
				$a1 = explode(":",$intime);
				$a2 = explode(":",$time);
				$time1 = (($a1[0]*60*60)+($a1[1]*60)+($a1[2]));
				$time2 = (($a2[0]*60*60)+($a2[1]*60)+($a2[2]));
				$diff = abs($time1-$time2);
				$hours = floor($diff/(60*60));
				$mins = floor(($diff-($hours*60*60))/(60));
				$secs = floor(($diff-(($hours*60*60)+($mins*60))));
				$total_hours = $hours.":".$mins.":".$secs;				
			}
			$query = "update #__intranet_dailyattendance set `out_time`='$time', `total_hours`='$total_hours' where id='$id' and users_id='$user_id'";
			$db->setQuery($query);
			$db->query();
		}
		//setting for today time
		$query = "select id,users_id,in_time,out_time,today_date from #__intranet_dailyattendance where users_id='$user_id' and today_date='$dates' order by id desc limit 1";
		$db->setQuery($query);
		$details = $db->loadRow();
		$ids = $details[0];
		$users_id = $details[1];
		$in_time = $details[2];
		$out_time = $details[3];
		$today_date = $details[4];
		//Getting all Leaves
		$query = "select * from #__intranet_leaverequest where fromusers_id='$user_id' order by id desc";
		$db->setQuery($query);
		$leaves = $db->loadAssocList();	
		
		?>
		<div id="intranet">
			<div id="menu">
				<ul>
					<li> <a href="index.php?option=com_intranet&task=calendar&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> Calendar </a> </li>
					<li > <a href="index.php?option=com_intranet&task=attendance&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> Attendance </a> </li>
					<li class="active"> <a href="index.php?option=com_intranet&task=leaverequest&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> Leave Request </a> </li>
					<li> <a href="index.php?option=com_intranet&task=payslip&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> Pay Slip </a> </li>
				</ul>
				<div id="in_out">
					<?php
					if($in_time!='00:00:00' && $out_time!='00:00:00')
					{
						?>
						<form name="newone" method="post" action="index.php?option=com_intranet&task=newattendance">
							<input type="hidden" name="users_id" value="<?php echo $user_id; ?>" />
							<input type="hidden" name="name" value="<?php echo $user_name; ?>" />
							<input type="hidden" name="today_date" value="<?php echo $dates; ?>" />
							<input type="hidden" name="in_time" value="<?php echo $times; ?>" />
							<input type="hidden" name="month" value="<?php echo $months; ?>" />
							<input type="hidden" name="year" value="<?php echo $year; ?>" />
							<input type="hidden" name="url" value="<?php echo $_SERVER["REQUEST_URI"]; ?>" />
							<input type="Submit" name="intime" value="Check In" />
						</form>
						<?php
					}
					if($in_time!='' && $out_time=='00:00:00')
					{
						?>
						<form name="newone" method="post" action="index.php?option=com_intranet&task=oldattendance">						
							<input type="hidden" name="users_id" value="<?php echo $users_id; ?>" />	
							<input type="hidden" name="id" value="<?php echo $ids; ?>" />								
							<input type="hidden" name="today_date" value="<?php echo $today_date; ?>" />
							<input type="hidden" name="in_time" value="<?php echo $in_time; ?>" />
							<input type="hidden" name="out_time" value="<?php echo $times; ?>" />
							<input type="hidden" name="url" value="<?php echo $_SERVER["REQUEST_URI"]; ?>" />
							<input type="Submit" name="outtime" value="Check Out" />
						</form>
						<?php
					}
					?>
				</div>
				<div id="view_attendance">
					<div id="attendance_menu">
						<div class="menus"> <a href="index.php?option=com_intranet&task=leaverequest&Itemid=<?php echo $_REQUEST['Itemid']; ?>"  class="active"> My Requests </a> </div>
						<div class="menus"> <a href="index.php?option=com_intranet&task=leaves&Itemid=<?php echo $_REQUEST['Itemid']; ?>" > Leaves</a>  </div>
						<div class="menus"> <a href="index.php?option=com_intranet&task=newrequest&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> New Request </a> </div>
					</div>
					<div id="attendance_content">
						<div id="myrequest">
							<h2 class="heads"> My Requests </h2>
							<div class="views">
								<div class="viewheads2"> Requested </div>
								<div class="viewheads2"> Subject </div>
								<div class="viewheads1"> Message </div>
								<div class="viewheads2"> From Date </div>
								<div class="viewheads2"> To Date </div>
								<div class="viewheads2"> Status </div>
								<div class="viewheads2"> Approved </div>
								<?php
								foreach($leaves as $row)
								{
									?>
									<div class="viewtails4"><?php echo $row['daterequested']; ?> </div>
									<div class="viewtails4"><?php echo $row['subject']; ?> </div>
									<div class="viewtails5"><?php echo $row['message']; ?> </div>
									<div class="viewtails4"><?php echo $row['fromdate']; ?> </div>
									<div class="viewtails4"><?php echo $row['todate']; ?> </div>
									<div class="viewtails4"><?php if($row['approved']==1) echo '<span style="color:green">Approved</span>'; else echo '<span style="color:red">Pending</span>'; ?> </div>
									<div class="viewtails4"><?php echo $row['dateapproved']; ?> </div>
									<?php
								}
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
	
	function leaves()
	{
		$db = &JFactory::getDBO();
		$user = &JFactory::getUser();
		$user_id = $user->id;
		$user_name = $user->name;
		$query = "select countryname from #__intranet_paymentsetting";
		$db->setQuery($query);
		$countryname = $db->loadRow();
		$country = $countryname[0];
		date_default_timezone_set($country);
		$times = date('H:i:s');
		$dates = date('Y-m-d');
		$months = date("m");
		$year = date("Y");
		//setting for today time
		$query = "select id,users_id,in_time,out_time,today_date from #__intranet_dailyattendance where users_id='$user_id' and today_date='$dates' order by id desc limit 1";
		$db->setQuery($query);
		$details = $db->loadRow();
		$ids = $details[0];
		$users_id = $details[1];
		$in_time = $details[2];
		$out_time = $details[3];
		$today_date = $details[4];
		//Getting all Leaves
		$query = "select * from #__intranet_leaverequest where fromusers_id='$user_id' and approved='1' order by id desc";
		$db->setQuery($query);
		$leaves = $db->loadAssocList();	
		
		?>
		<div id="intranet">
			<div id="menu">
				<ul>
					<li> <a href="index.php?option=com_intranet&task=calendar&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> Calendar </a> </li>
					<li > <a href="index.php?option=com_intranet&task=attendance&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> Attendance </a> </li>
					<li class="active"> <a href="index.php?option=com_intranet&task=leaverequest&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> Leave Request </a> </li>
					<li> <a href="index.php?option=com_intranet&task=payslip&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> Pay Slip </a> </li>
				</ul>
				<div id="in_out">
					<?php
					if($in_time!='00:00:00' && $out_time!='00:00:00')
					{
						?>
						<form name="newone" method="post" action="index.php?option=com_intranet&task=newattendance">
							<input type="hidden" name="users_id" value="<?php echo $user_id; ?>" />
							<input type="hidden" name="name" value="<?php echo $user_name; ?>" />
							<input type="hidden" name="today_date" value="<?php echo $dates; ?>" />
							<input type="hidden" name="in_time" value="<?php echo $times; ?>" />
							<input type="hidden" name="month" value="<?php echo $months; ?>" />
							<input type="hidden" name="year" value="<?php echo $year; ?>" />
							<input type="hidden" name="url" value="<?php echo $_SERVER["REQUEST_URI"]; ?>" />
							<input type="Submit" name="intime" value="Check In" />
						</form>
						<?php
					}
					if($in_time!='' && $out_time=='00:00:00')
					{
						?>
						<form name="newone" method="post" action="index.php?option=com_intranet&task=oldattendance">						
							<input type="hidden" name="users_id" value="<?php echo $users_id; ?>" />	
							<input type="hidden" name="id" value="<?php echo $ids; ?>" />								
							<input type="hidden" name="today_date" value="<?php echo $today_date; ?>" />
							<input type="hidden" name="in_time" value="<?php echo $in_time; ?>" />
							<input type="hidden" name="out_time" value="<?php echo $times; ?>" />
							<input type="hidden" name="url" value="<?php echo $_SERVER["REQUEST_URI"]; ?>" />
							<input type="Submit" name="outtime" value="Check Out" />
						</form>
						<?php
					}
					?>
				</div>
				<div id="view_attendance">
					<div id="attendance_menu">
						<div class="menus"> <a href="index.php?option=com_intranet&task=leaverequest&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> My Requests </a> </div>
						<div class="menus"> <a href="index.php?option=com_intranet&task=leaves&Itemid=<?php echo $_REQUEST['Itemid']; ?>"   class="active" > Leaves</a>  </div>
						<div class="menus"> <a href="index.php?option=com_intranet&task=newrequest&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> New Request </a> </div>
					</div>
					<div id="attendance_content">
						<div id="myrequest">
							<h2 class="heads"> Leaves </h2>
							<div class="views">
								<div class="viewheads2"> Requested </div>
								<div class="viewheads2"> Subject </div>
								<div class="viewheads1"> Message </div>
								<div class="viewheads2"> From Date </div>
								<div class="viewheads2"> To Date </div>
								<div class="viewheads2"> Status </div>
								<div class="viewheads2"> Approved </div>
								<?php
								foreach($leaves as $row)
								{
									?>
									<div class="viewtails4"><?php echo $row['daterequested']; ?> </div>
									<div class="viewtails4"><?php echo $row['subject']; ?> </div>
									<div class="viewtails5"><?php echo $row['message']; ?> </div>
									<div class="viewtails4"><?php echo $row['fromdate']; ?> </div>
									<div class="viewtails4"><?php echo $row['todate']; ?> </div>
									<div class="viewtails4"><?php if($row['approved']==1) echo '<span style="color:green">Approved</span>'; ?></div>
									<div class="viewtails4"><?php echo $row['dateapproved']; ?> </div>
									<?php
								}
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
	
	function newrequest()
	{
		$db = &JFactory::getDBO();
		$user = &JFactory::getUser();
		$user_id = $user->id;
		$user_name = $user->name;
		$query = "select countryname from #__intranet_paymentsetting";
		$db->setQuery($query);
		$countryname = $db->loadRow();
		$country = $countryname[0];
		date_default_timezone_set($country);
		$times = date('H:i:s');
		$dates = date('Y-m-d');
		$months = date("m");
		$year = date("Y");
		//setting for today time
		$query = "select id,users_id,in_time,out_time,today_date from #__intranet_dailyattendance where users_id='$user_id' and today_date='$dates' order by id desc limit 1";
		$db->setQuery($query);
		$details = $db->loadRow();
		$ids = $details[0];
		$users_id = $details[1];
		$in_time = $details[2];
		$out_time = $details[3];
		$today_date = $details[4];
		$query = "select leavetype from #__intranet_paymentsetting";		
		$db->setQuery($query);		
		$leave = $db->loadRow(); 		
		$leavetype = explode(",", $leave[0]);		
		$n = count($leavetype);
		$query = "select id,name from #__users where gid='25'";
		$db->setQuery($query);
		$nm = $db->loadRow();
		$to_id = $nm[0];
		$to_name = $nm[1];
		?>
		<script type="text/javascript">
		function check_all()
		{
			var form = document.newrequest;
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
			return true;
		}
		</script>
		<div id="intranet">
			<div id="menu">
				<ul>
					<li> <a href="index.php?option=com_intranet&task=calendar&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> Calendar </a> </li>
					<li > <a href="index.php?option=com_intranet&task=attendance&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> Attendance </a> </li>
					<li class="active"> <a href="index.php?option=com_intranet&task=leaverequest&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> Leave Request </a> </li>
					<li> <a href="index.php?option=com_intranet&task=payslip&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> Pay Slip </a> </li>
				</ul>
				<div id="in_out">
					<?php
					if($in_time!='00:00:00' && $out_time!='00:00:00')
					{
						?>
						<form name="newone" method="post" action="index.php?option=com_intranet&task=newattendance">
							<input type="hidden" name="users_id" value="<?php echo $user_id; ?>" />
							<input type="hidden" name="name" value="<?php echo $user_name; ?>" />
							<input type="hidden" name="today_date" value="<?php echo $dates; ?>" />
							<input type="hidden" name="in_time" value="<?php echo $times; ?>" />
							<input type="hidden" name="month" value="<?php echo $months; ?>" />
							<input type="hidden" name="year" value="<?php echo $year; ?>" />
							<input type="hidden" name="url" value="<?php echo $_SERVER["REQUEST_URI"]; ?>" />
							<input type="Submit" name="intime" value="Check In" />
						</form>
						<?php
					}
					if($in_time!='' && $out_time=='00:00:00')
					{
						?>
						<form name="newone" method="post" action="index.php?option=com_intranet&task=oldattendance">						
							<input type="hidden" name="users_id" value="<?php echo $users_id; ?>" />	
							<input type="hidden" name="id" value="<?php echo $ids; ?>" />								
							<input type="hidden" name="today_date" value="<?php echo $today_date; ?>" />
							<input type="hidden" name="in_time" value="<?php echo $in_time; ?>" />
							<input type="hidden" name="out_time" value="<?php echo $times; ?>" />
							<input type="hidden" name="url" value="<?php echo $_SERVER["REQUEST_URI"]; ?>" />
							<input type="Submit" name="outtime" value="Check Out" />
						</form>
						<?php
					}
					?>
				</div>
				<div id="view_attendance">
					<div id="attendance_menu">
						<div class="menus"> <a href="index.php?option=com_intranet&task=leaverequest&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> My Requests </a> </div>
						<div class="menus"> <a href="index.php?option=com_intranet&task=leaves&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> Leaves</a>  </div>
						<div class="menus"> <a href="index.php?option=com_intranet&task=newrequest&Itemid=<?php echo $_REQUEST['Itemid']; ?>" class="active" > New Request </a> </div>
					</div>
					<div id="attendance_content">
						<div id="myrequest">
							<h2 class="heads"> New Request </h2>
							<div id="newrequest">
								<form name="newrequest" method="post" action="index.php?option=com_intranet&task=requestsave" onsubmit="return check_all();">
									<div class="leftside"> From   </div> <div class="center"> : </div> <div class="rightside"> <?php echo $user_name; ?> </div>
									<div class="leftside"> To   </div> <div class="center"> : </div> <div class="rightside"> <?php echo $to_name; ?> </div>
									<div class="leftside"> Subject   </div>  <div class="center"> : </div>
									<div class="rightside"> 
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
									</div>
									<div class="leftside"> From Date  </div> <div class="center"> : </div>
									<div class="rightside">
										<?php echo JHTML::_('calendar',$mydate,'fromdate','fromdate','%Y-%m-%d','size="20",title ="fromdate", readonly="readonly"');?>
									</div>
									<div class="leftside"> To Date  </div> <div class="center"> : </div>
									<div class="rightside">
										<?php echo JHTML::_('calendar',$mydate,'todate','todate','%Y-%m-%d','size="20",title ="todate", readonly="readonly"');?>
									</div>
									<div class="leftside"> Message </div> <div class="center"> : </div>
									<div class="rightside">
										<textarea name="message" rows="5" cols="50"></textarea>
									</div>
									<input type="hidden" name="daterequested" value="<?php echo date("Y-m-d"); ?>" />
									<input type="hidden" name="fromusers_id" value="<?php echo $user_id; ?>" />
									<input type="hidden" name="tousers_id" value="<?php echo $to_id; ?>" />
									<input type="hidden" name="month" value="<?php echo $months; ?>" />
									<input type="hidden" name="year" value="<?php echo $year; ?>" />
									<input type="hidden" name="Itemid" value="<?php echo $_REQUEST['Itemid']; ?>" />
									<input type="submit" name="newrequest" value="Submit" />
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
	
	function payslip()
	{
		$db = &JFactory::getDBO();
		$user = &JFactory::getUser();
		$user_id = $user->id;
		$user_name = $user->name;
		$query = "select countryname from #__intranet_paymentsetting";
		$db->setQuery($query);
		$countryname = $db->loadRow();
		$country = $countryname[0];
		date_default_timezone_set($country);
		$times = date('H:i:s');
		$dates = date('Y-m-d');
		$months = date("m");
		$year = date("Y");
		//checking whether the yesterday out time has been put by the user
		$query = "select endtime from #__intranet_paymentsetting";
		$db->setQuery($query);
		$ends_times = $db->loadRow();
		$query = "select out_time,today_date,id,in_time from #__intranet_dailyattendance where users_id='$user_id' and today_date!='$dates' order by id desc limit 1";
		$db->setQuery($query);
		$out = $db->loadRow();
		$outtime = $out[0];
		$id = $out[2];
		$intime = $out[3];
		if($outtime=='00:00:00')
		{
			$in = strtotime($intime);
			$ot = strtotime($ends_times[0]);
			if($in > $ot)
			{
				$time = $intime;
				$total_hours = '00:00:00';
			}
			else
			{
				$time = $ends_times[0];
				$a1 = explode(":",$intime);
				$a2 = explode(":",$time);
				$time1 = (($a1[0]*60*60)+($a1[1]*60)+($a1[2]));
				$time2 = (($a2[0]*60*60)+($a2[1]*60)+($a2[2]));
				$diff = abs($time1-$time2);
				$hours = floor($diff/(60*60));
				$mins = floor(($diff-($hours*60*60))/(60));
				$secs = floor(($diff-(($hours*60*60)+($mins*60))));
				$total_hours = $hours.":".$mins.":".$secs;				
			}
			$query = "update #__intranet_dailyattendance set `out_time`='$time', `total_hours`='$total_hours' where id='$id' and users_id='$user_id'";
			$db->setQuery($query);
			$db->query();
		}
		//setting for today time
		$query = "select id,users_id,in_time,out_time,today_date from #__intranet_dailyattendance where users_id='$user_id' and today_date='$dates' order by id desc limit 1";
		$db->setQuery($query);
		$details = $db->loadRow();
		$ids = $details[0];
		$users_id = $details[1];
		$in_time = $details[2];
		$out_time = $details[3];
		$today_date = $details[4];
		//Getting the months name
		$monthNames = Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
		$n = count($monthNames);
		//Get the Pay slip
		if(isset($_POST['payslip_submit']))
		{
			$monthly = $_POST['monthly'];
			$yearly = $_POST['yearly'];
			$query = "select a.name,a.basic_pay,a.position,a.total_salary,a.monthly_salary,b.variable_allowance,b.leave_days,b.basicpay_month,b.totalsalary_month,b.deduction_month,b.salary_month from #__intranet_users as a,#__intranet_payslip as b where a.users_id='$user_id' and b.users_id='$user_id' and b.month='$monthly' and year='$yearly'";
			$db->setQuery($query);
			$payslip = $db->loadRow();
			$py = count($payslip);
			$query = "select * from #__intranet_paymentsetting";
			$db->setQuery($query);
			$payment = $db->loadRow();			
			$pfs = $payment[1];
			$hrs = $payment[2];			
			$convenyances = $payment[3];
			$permitted_leave = $payment[4];
			$pf_deduction = $payment[5];
			$pt = $payment[6];
			$other_deduction = $payment[7];
			
			$pf = ($payslip[1] * $pfs) / 100; 
			$pf = round($pf,2);
			$hr = ($payslip[1] * $hrs) / 100; 
			$hr = round($hr,2);
			$convenyance = ($payslip[1] * $convenyances) / 100;
			$convenyance = round($convenyance,2);
			$deduction = (($payslip[1] * $pf_deduction) / 100) + (($payslip[1] * $pt) / 100) + (($payslip[1] * $other_deduction) / 100);
			$deduction = round($deduction,2);
			
			$pf1 = ($payslip[7] * $pfs) / 100; 
			$pf1 = round($pf1,2);
			$hr1 = ($payslip[7] * $hrs) / 100; 
			$hr1 = round($hr1,2);
			$convenyance1 = ($payslip[7] * $convenyances) / 100;
			$convenyance1 = round($convenyance1,2);			
		}
		?>
		<div id="intranet">
			<div id="menu">
				<ul>
					<li> <a href="index.php?option=com_intranet&task=calendar&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> Calendar </a> </li>
					<li > <a href="index.php?option=com_intranet&task=attendance&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> Attendance </a> </li>
					<li> <a href="index.php?option=com_intranet&task=leaverequest&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> Leave Request </a> </li>
					<li class="active"> <a href="index.php?option=com_intranet&task=payslip&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> Pay Slip </a> </li>
				</ul>
				<div id="in_out">
					<?php
					if($in_time!='00:00:00' && $out_time!='00:00:00')
					{
						?>
						<form name="newone" method="post" action="index.php?option=com_intranet&task=newattendance">
							<input type="hidden" name="users_id" value="<?php echo $user_id; ?>" />
							<input type="hidden" name="name" value="<?php echo $user_name; ?>" />
							<input type="hidden" name="today_date" value="<?php echo $dates; ?>" />
							<input type="hidden" name="in_time" value="<?php echo $times; ?>" />
							<input type="hidden" name="month" value="<?php echo $months; ?>" />
							<input type="hidden" name="year" value="<?php echo $year; ?>" />
							<input type="hidden" name="url" value="<?php echo $_SERVER["REQUEST_URI"]; ?>" />
							<input type="Submit" name="intime" value="Check In" />
						</form>
						<?php
					}
					if($in_time!='' && $out_time=='00:00:00')
					{
						?>
						<form name="newone" method="post" action="index.php?option=com_intranet&task=oldattendance">						
							<input type="hidden" name="users_id" value="<?php echo $users_id; ?>" />	
							<input type="hidden" name="id" value="<?php echo $ids; ?>" />								
							<input type="hidden" name="today_date" value="<?php echo $today_date; ?>" />
							<input type="hidden" name="in_time" value="<?php echo $in_time; ?>" />
							<input type="hidden" name="out_time" value="<?php echo $times; ?>" />
							<input type="hidden" name="url" value="<?php echo $_SERVER["REQUEST_URI"]; ?>" />
							<input type="Submit" name="outtime" value="Check Out" />
						</form>
						<?php
					}
					?>
				</div>
				<div id="payslip">
					<h2 class="heads"> Payslip </h2>
					<form name="payslip" method="post" action="index.php?option=com_intranet&task=payslip&Itemid=<?php echo $_REQUEST['Itemid']; ?>">
						<div class="options"> Select a year :
							<select name="yearly">
								<option value="0"> Select Year </option>
								<?php
								for($i=2000;$i<3000;$i++)
								{
									?>
									<option value="<?php echo $i; ?>" <?php if($yearly==$i) { ?> selected="seleccted" <?php } ?> > 
										<?php echo $i; ?> 
									</option>
									<?php
								}
								?>
							</select>
						</div>
						<div class="options"> Select a Month : 
							<select name="monthly">
								<option value="0"> Select Month </option>
								<?php
								for($i=0;$i<$n;$i++)
								{
									?>
									<option value="<?php echo ($i+1); ?>" <?php if($monthly==($i+1)) { ?> selected="selected" <?php } ?> >
										<?php echo $monthNames[$i]; ?> 
									</option>
									<?php
								}
								?>
							</select>
						</div>
						<div class="submits"> <input type="submit" name="payslip_submit" value="Submit" /> </div>
					</form>
					<?php
					if(isset($_POST['payslip_submit']))
					{
						if($py > 0)
						{
							?>
							<div id="payslip_view">
								<div class="main"> Name </div> <div class="center"> : </div> <div class="main_view"> <?php echo $payslip[0]; ?> </div>
								<div class="main"> Position  </div> <div class="center"> : </div> <div class="main_view"> <?php echo $payslip[2]; ?> </div>
								<div id="original">
									<div class="main1"> Leave Permitted days  </div> <div class="main_view1"> <?php echo $permitted_leave; ?> </div>
									<div class="main1"> Actual Basic Pay  </div> <div class="main_view1"> <?php echo $payslip[1]; ?> </div>
									<div class="main1"> PF  </div> <div class="main_view1"> <?php echo $pf; ?> </div>
									<div class="main1"> HR  </div> <div class="main_view1"> <?php echo $hr; ?> </div>
									<div class="main1"> Convenyance   </div> <div class="main_view1"> <?php echo $convenyance; ?> </div>
									<div class="main1"> Gross Salary  </div> <div class="main_view1"> <?php echo $payslip[3]; ?> </div>
									<div class="main1"> Deduction  </div> <div class="main_view1"> <?php echo $deduction; ?> </div>
									<div class="main1"> Home Salary  </div> <div class="main_view1"> <?php echo $payslip[4]; ?> </div>
								</div>
								<div id="monthly1">
									<div class="main2"> No Leave days  </div> <div class="main_view1"> <?php echo $payslip[6]; ?> </div>
									<div class="main2"> Basic Pay for this Month  </div> <div class="main_view1"> <?php echo $payslip[7]; ?> </div>
									<div class="main2"> PF for this Month  </div> <div class="main_view1"> <?php echo $pf1; ?> </div>
									<div class="main2"> HR for this Month  </div> <div class="main_view1"> <?php echo $hr1; ?> </div>
									<div class="main2"> Convenyance for this Month   </div> <div class="main_view1"> <?php echo $convenyance1; ?> </div>
									<div class="main2"> Gross Salary for this Month  </div> <div class="main_view1"> <?php echo $payslip[8]; ?> </div>
									<div class="main2"> Deduction for this Month  </div> <div class="main_view1"> <?php echo $payslip[9]; ?> </div>
									<div class="main2"> Bonus  </div> <div class="main_view1"> <?php echo $payslip[5]; ?> </div>
									<div class="main2"> Take Home Salary this Month </div> <div class="main_view1"> <?php echo $payslip[10]; ?> </div>
								</div>
							</div>
							<?php
						}
						else
						{
							echo "No Record found for this Month or Year";
						}
					}
					?>
				</div>
			</div>
		</div>
		<?php
	}
}

?>