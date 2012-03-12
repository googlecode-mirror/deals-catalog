-- Table structure for table `#__intranet_settings`
CREATE TABLE IF NOT EXISTS 	`#__intranet_settings` (
`id` INT(11) NOT NULL AUTO_INCREMENT, 
`model` VARCHAR( 50 ) NOT NULL ,
`enabled` TINYINT( 1 ) NOT NULL DEFAULT '0',  
PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 CHARSET=utf8;

INSERT INTO `#__intranet_settings` (`id`, `model`, `enabled`) VALUES (NULL, 'Calendar', '0'), (NULL, 'Attendance', '1'), (NULL, 'Pay Slip', '0'), (NULL, 'Leave Request', '1');

-- Table structure for table `#__intranet_calendarsetting`
CREATE TABLE IF NOT EXISTS 	`#__intranet_calendarsetting` (
`id` INT(11) NOT NULL AUTO_INCREMENT, 
`weekly_off` VARCHAR( 50 ) NOT NULL ,
`year` INT( 5 ) NOT NULL ,  
PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 CHARSET=utf8;

-- Table structure for table `#__intranet_paymentsetting`
CREATE TABLE IF NOT EXISTS 	`#__intranet_paymentsetting` (
`id` INT(11) NOT NULL AUTO_INCREMENT, 
`pf` DOUBLE( 10,2 ) NOT NULL ,
`hr` DOUBLE( 10,2 ) NOT NULL ,
`convenyance` DOUBLE( 10,2 ) NOT NULL ,
`permitted_leave` INT( 5 ) NOT NULL , 
`pf_deduction` DOUBLE( 10,2 ) NOT NULL , 
`pt` DOUBLE( 10,2 ) NOT NULL ,
`other_deduction` DOUBLE( 10,2 ) NOT NULL ,
`endtime` TIME NOT NULL DEFAULT '00:00:00',
`leavetype` TEXT NOT NULL ,
`countryname` TEXT NOT NULL ,
PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 CHARSET=utf8;

-- Table structure for table `#__intranet_calendarweeklyoff`
CREATE TABLE IF NOT EXISTS 	`#__intranet_calendarweeklyoff` (
`cal_id` INT(11) NOT NULL AUTO_INCREMENT, 
`date` DATE NOT NULL ,
`title` VARCHAR( 50 ) NOT NULL ,
`dt` INT(11) NOT NULL ,
`year` INT( 5 ) NOT NULL , 
PRIMARY KEY (`cal_id`)
) TYPE=MyISAM AUTO_INCREMENT=1 CHARSET=utf8;

-- Table structure for table `#__intranet_calendar`
CREATE TABLE IF NOT EXISTS 	`#__intranet_calendar` (
`id` INT(11) NOT NULL AUTO_INCREMENT, 
`date` DATE NOT NULL ,
`event` TINYINT( 1 ) NOT NULL DEFAULT '0', 
`event_title` VARCHAR( 50 ) NOT NULL ,
`eventstart_time` TIME NOT NULL DEFAULT '00:00:00',
`eventend_time` TIME NOT NULL DEFAULT '00:00:00',
`holiday` TINYINT( 1 ) NOT NULL DEFAULT '0',
`holiday_type` VARCHAR( 30 ) NOT NULL ,
`holiday_title` TEXT NOT NULL ,
`dt` INT(11) NOT NULL ,
`year` INT( 5 ) NOT NULL , 
PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 CHARSET=utf8;

-- Table structure for table `#__intranet_users`
CREATE TABLE IF NOT EXISTS 	`#__intranet_users` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
`users_id` INT( 11 ) NOT NULL ,
`name` VARCHAR( 200 ) NOT NULL ,
`email` VARCHAR( 250 ) NOT NULL ,
`username` VARCHAR( 200 ) NOT NULL ,
`password` VARCHAR( 200 ) NOT NULL ,
`dob` DATE NOT NULL ,
`official_address` TEXT NOT NULL ,
`residencial_address` TEXT NOT NULL ,
`Phone_no` VARCHAR( 100 ) NOT NULL ,
`mobile_no` VARCHAR( 100 ) NOT NULL ,
`position` VARCHAR( 200 ) NOT NULL ,
`basic_pay` DOUBLE( 10,2 ) NOT NULL ,
`monthly_salary` DOUBLE( 10,2 ) NOT NULL ,
`total_salary` DOUBLE( 10,2 ) NOT NULL ,
PRIMARY KEY ( `id` ) ,
UNIQUE (
`users_id` ,
`email`
)
) TYPE=MyISAM AUTO_INCREMENT=1 CHARSET=utf8;

-- Table structure for table `#__intranet_dailyattendance`
CREATE TABLE IF NOT EXISTS 	`#__intranet_dailyattendance` (
`id` INT(11) NOT NULL AUTO_INCREMENT, 
`users_id` INT( 11 ) NOT NULL ,
`name` VARCHAR( 200 ) NOT NULL ,
`today_date` DATE NOT NULL ,
`in_time` TIME NOT NULL DEFAULT '00:00:00',
`out_time` TIME NOT NULL DEFAULT '00:00:00',
`month` INT(11) NOT NULL ,
`year` INT( 5 ) NOT NULL , 
`total_hours` TIME NOT NULL DEFAULT '00:00:00',
PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 CHARSET=utf8;

-- Table structure for table `#__intranet_monthattendance`
CREATE TABLE IF NOT EXISTS 	`#__intranet_monthattendance` (
`id` INT(11) NOT NULL AUTO_INCREMENT, 
`users_id` INT( 11 ) NOT NULL ,
`name` VARCHAR( 200 ) NOT NULL ,
`month` INT(11) NOT NULL ,
`year` INT( 5 ) NOT NULL ,
`days_worked` INT( 11 ) NOT NULL ,
`leave_days` INT( 11 ) NOT NULL ,
`office_days` INT( 5 ) NOT NULL ,
`companyholiday_days` INT( 5 ) NOT NULL ,
`weekoff_days` INT( 5 ) NOT NULL ,
`total_days` INT( 11 ) NOT NULL ,
`total_hours` INT( 11 ) NOT NULL ,
PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 CHARSET=utf8;

-- Table structure for table `#__intranet_leaverequest`
CREATE TABLE IF NOT EXISTS 	`#__intranet_leaverequest` (
`id` INT(11) NOT NULL AUTO_INCREMENT, 
`daterequested` DATE NOT NULL ,
`fromusers_id` INT( 11 ) NOT NULL ,
`tousers_id` INT( 11 ) NOT NULL ,
`subject` INT( 5 ) NOT NULL ,
`message` TEXT NOT NULL ,
`fromdate` DATE NOT NULL ,
`todate` DATE NOT NULL ,
`month` INT(11) NOT NULL ,
`year` INT( 5 ) NOT NULL ,
`approved` TINYINT( 1 ) NOT NULL ,
`dateapproved` DATE NOT NULL ,
PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 CHARSET=utf8;

-- Table structure for table `#__intranet_payslip`
CREATE TABLE IF NOT EXISTS 	`#__intranet_payslip` (
`id` INT(11) NOT NULL AUTO_INCREMENT, 
`users_id` INT( 11 ) NOT NULL ,
`month` INT(11) NOT NULL ,
`year` INT( 5 ) NOT NULL ,
`variable_allowance` VARCHAR( 200 ) NOT NULL ,
`working_days` INT( 5 ) NOT NULL ,
`worked_days` INT( 5 ) NOT NULL ,
`leave_days` INT( 5 ) NOT NULL ,
`holidays` INT( 5 ) NOT NULL ,
`basicpay_month` DOUBLE( 10,2 ) NOT NULL ,
`totalsalary_month` DOUBLE( 10,2 ) NOT NULL ,
`deduction_month` DOUBLE( 10,2 ) NOT NULL ,
`salary_month` DOUBLE( 10,2 ) NOT NULL ,
PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 CHARSET=utf8;