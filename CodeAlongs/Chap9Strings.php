<?php

function p($myString) {
    echo $myString . "<BR>";
}

$students = array("Erin", "QJX", "ITDerp", "Johnny");
$foundStudents = preg_grep("/J/i", $students); //what you're searching for goes in first, where you're looking is second. Returns an array of matching elements
print_r($foundStudents);

$myString = "How much wood could a woodchuck chuck";
//print_r(preg_match("/chuck/". $myString)); //only gets the first match
print_r(preg_match_all("/chuck/", $myString));
echo "<BR>";

$myString = "tuition is $3200";
p(preg_quote($myString));

$myString = "How much wood could a woodchuck chuck";
$newString = preg_replace("/chuck/", "Hello", $myString); //the replacement, what's being replaced, the string
p($newString);

$newString =  preg_filter("/Hello/", "Chuck", $myString); //doesn't return anything
p($myString);

$myString = "How|much|wood|could";
$myArray = preg_split("/\|/", $myString);
print_r($myArray);
echo "<BR>";

p(strlen($myString)); //gets the length of a string
$string1 = "Hello";
$string2 = "hello";
p(strcmp($string1, $string2)); //case sensitive
p(strcasecmp($string1, $string2)); //case insensitive

p(strtolower($string1)); //to lower case
p(strtoupper($string1));
p(ucfirst($string2));

$myString = "café français + & ^ % $ @";
p(htmlentities($myString));

$myString = "Billy O'Donnell";
echo addslashes($myString) . "<BR>";
//For sprint 3 - mysqli_real_escape_string($con, $myString);

$myString = "Java <BR> is <i>cool</i>";
p(strip_tags($myString));
p($myString);