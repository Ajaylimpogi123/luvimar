<?php
require_once 'global-library/config.php';
require_once 'global-library/functions.php';

checkUser();
$script = 1;

	# Get setting details
	$sett = "SELECT * FROM bs_setting";
	$rs_sett = dbQuery($sett);
	$rw_sett = dbFetchAssoc($rs_sett);
	extract($rw_sett);
	if($theme == "slate")
	{ $caltheme = "dark"; }
	else{ $caltheme = "light"; }

	
?>
<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Calendar Receivables</title>	
	<link rel="stylesheet" type="text/css" href="calendar/css/receivables.css" />	
	
	<?php include ($_SERVER["DOCUMENT_ROOT"] . '/' . $directory . '/global-library/misc-js.php'); ?>	
</head>

<?php

/* draws a calendar */
function draw_receivables2($month,$year)
{
	date_default_timezone_set("Asia/Manila");
	$today_date1 = date("Y-m-d H:i:s");
	$today_date2 = date("Y-m-d");
	$today_date3 = date("d");
	
	/* draw table */
	$receivables = '<table cellpadding="0" cellspacing="0" class="receivables">';

	/* table headings */
	$headings = array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
	$receivables.= '<tr class="receivables-row"><td class="receivables-day-head">'.implode('</td><td class="receivables-day-head">',$headings).'</td></tr>';

	/* days and weeks vars now ... */
	$running_day = date('w',mktime(0,0,0,$month,1,$year));
	$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
	$days_in_this_week = 1;
	$day_counter = 0;
	$dates_array = array();

	/* row for week one */
	$receivables.= '<tr class="receivables-row">';

	/* print "blank" days until the first of the current week */
	for($x = 0; $x < $running_day; $x++):
		$receivables.= '<td class="receivables-day-np">&nbsp;</td>';
		$days_in_this_week++;
	endfor;

	/* keep going with days.... */
	for($list_day = 1; $list_day <= $days_in_month; $list_day++):
		$receivables.= '<td class="receivables-day">';
			/* add in the day number */
			if($list_day == $today_date3)
			{ $receivables.= '<div class="day-today">'.$list_day.'</div>'; }else{ $receivables.= '<div class="day-number">'.$list_day.'</div>'; }

			/** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/		

			/* Check for holidays */
			$exp = "SELECT * FROM tbl_order WHERE DAY(date_due) = $list_day AND MONTH(date_due) = $month AND YEAR(date_due) = $year AND is_deleted != '1' AND is_paid != '1'";
			$rsexp = dbQuery($exp);
			$numexp = dbNumRows($rsexp);
			
			/* Check if the date has entries */
			if($numexp > 0) /* If user did not login, check if holiday */
			{
				$rw = dbFetchAssoc($rsexp);				
				$schedId = $rw['od_id'];
				$receivables .= '<a class="nyroModal" href=calendar/datar.php?id=' . $schedId . '><img src="calendar/bookmark.png" width="20" height="20" /></a>';
			}else{}
			/* End Check Entries */
		
		$receivables.= '</td>';
		if($running_day == 6):
			$receivables.= '</tr>';
			if(($day_counter+1) != $days_in_month):
				$receivables.= '<tr class="receivables-row">';
			endif;
			$running_day = -1;
			$days_in_this_week = 0;
		endif;
		$days_in_this_week++; $running_day++; $day_counter++;
	endfor;

	/* finish the rest of the days in the week */
	if($days_in_this_week < 8):
		for($x = 1; $x <= (8 - $days_in_this_week); $x++):
			$receivables.= '<td class="receivables-day-np">&nbsp;</td>';
		endfor;
	endif;

	/* final row */
	$receivables.= '</tr>';

	/* end the table */
	$receivables.= '</table>';
	if($month == 12)
	{ $newm1 = 0; $newy1 = $year + 1; }else{ $newm1 = $month; $newy1 = $year; }
	
	if($month == 1)
	{ $newm2 = 13; $newy2 = $year - 1; }else{ $newm2 = $month; $newy2 = $year; }
	
	$prev = $newm2 - 1;
	$next = $newm1 + 1;	
	//$receivables.= "<center><table><tr><td><a href='receivables/index.php?id=1&m=$prev&y=$newy2'>Prev</a></td><td> | </td><td><a href='receivables/index.php?id=1&m=$next&y=$newy1'>Next</a></td></tr></table></center>";	
	
	/* all done, return result */
	return $receivables;
	
}


if(isset($_GET['id']))
{
	date_default_timezone_set("Asia/Manila");
	$today_date1 = date("Y-m-d H:i:s");
	$today_date2 = date("Y-m-d");
	$dy = date("y");
	$dm = date("m");
	
	$dateObj   = DateTime::createFromFormat('!m', $dm);
	$monthName = $dateObj->format('F'); // March		
	
	echo '<table border=0 width=500 align=center><tr><td valign=top style=float:left><h3>' . $monthName . ' ' . $dy . '</h3></td></tr></table>';	
	echo draw_receivables2($dm,$dy);
}else{

	date_default_timezone_set("Asia/Manila");
	$today_date1 = date("Y-m-d H:i:s");
	$today_date2 = date("Y-m-d");
	
	$mth = date("n",strtotime($today_date2));
	$yr = date("Y",strtotime($today_date2));	
	$month = date("F",strtotime($today_date2));
		
	echo '<table border=0 width=500 align=center><tr><td valign=top style=float:left><h3>' . $month . ' ' . $yr . '</h3></td></tr></table>';	
	echo draw_receivables2($mth,$yr);
}
?>
