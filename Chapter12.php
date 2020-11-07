<?php

//check date
$valid = checkdate(2,29,2020);
echo $valid . "<BR>";
setlocale(LC_ALL, "can-EN");
//%A means day of the week
//%d - day of the month
//%F - full date
//%B - month
echo strftime("%A, %B %d, %Y") . "<BR>";
echo date("F d, Y") . "<BR>";

//times!!
//i means minutes
date_default_timezone_set("America/Halifax");
echo date("h:i:sa") . "<BR>";
$dateArray = getDate();
print_r($dateArray);

echo "Page was last modified on " . date("F d, Y h:i:sa", getlastmod()) . "<BR>";
$dateTweeted = "2020-10-13 15:00:00";
$now = new DateTime(); //curent datetime stamp

$tweetTime = new DateTime($dateTweeted); //convert it to a date time
$interval = $now->diff($tweetTime);
//echo $interval->format("%d %h %i %s seconds") . "<BR>";

if($interval->y > 1) echo $interval->format("%y years") . "<BR>";
elseif($interval->y > 0) echo $interval->format("%y year") . "<BR>";
elseif($interval->m > 1) echo $interval->format("%m months") . "<BR>";
elseif($interval->m > 0) echo $interval->format("%m month") . "<BR>";
elseif($interval->d > 1) echo $interval->format("%d days") . "<BR>";
elseif($interval->d > 0) echo $interval->format("%d day") . "<BR>";
elseif($interval->h > 1) echo $interval->format("%h hours") . "<BR>";
elseif($interval->h > 0) echo $interval->format("%h hour") . "<BR>";
elseif($interval->i > 1) echo $interval->format("%i seconds") . "<BR>";
elseif($interval->i > 0) echo $interval->format("%i seconds") . "<BR>";