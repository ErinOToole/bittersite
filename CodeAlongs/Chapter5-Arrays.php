<?php
session_start();
echo $_SESSION["name"];

//define array
$cities[0] = "Fredericton";
$cities[1] = "Saint John";
$cities[2] = "Bathurst";

//easier way
//override the position with 5=>
//5=> means 'goes to'
$cities = [5=>"Fredericton", "Saint John", "Bathurst", "boston"];

//associative array
//$populations =["Fredericton" => 60000, "Saint John" => 75000, "Bathurst" =>25000];
//call the php method to tell it that it's an array
$populations = array("Fredericton" => 60000, "Saint John" => 75000, "Bathurst" =>25000);
//easy way to print out arrays, useful for debugging
//print_r($populations);

//2d array is an array of arrays
$twoDArray = array("Jimmy"=>array(98,88,77), "Johnny"=>array(66,55,88), "Suzie"=>array(100,99,98));
//print_r($twoDArray);
echo "<BR>";

foreach($twoDArray as $student){
    echo $student[0] . " " . $student[1] . " " . $student[2] . "<BR>";
}

echo count($twoDArray) . "<BR>"; //how many elements are in your array
echo sizeof($twoDArray) . "<BR>"; //same thing, just different syntax

$myNums = range(0,100);
//print_r($myNums);
//print_r(array_reverse($myNums)); //prints them backwards
//print_r(array_flip($myNums));

echo "<BR>";
//read from a file
$students = file("students.txt");
foreach($students as $student){
    //echo $student . "<BR>";
    //list is similar to array but it assigns multiple variables to one operation
    list($name, $city, $grade) = explode("|", $student);
    echo $name . " " . $city . " " . $grade . "<BR>";
}        
array_unshift($myNums, 200); //add to the beginning of the array
array_shift($myNums); //remove from the beginning of the array
array_push($myNums, 500); //adds 500 to the end
array_pop($myNums); //will remove from the end of the array

if(in_array("Fredericton", $cities)){
    //in_array will return a true or false
    echo "Found<BR>";
}
else{
    echo "Not found<BR>";
}
//print_r($myNums);
//echo "<BR>";

//sort($cities); //sorts cities in alphabetical ascending order


natcasesort($cities); //case-insensitivenatural sorting
$newArray = array("test 1", "test 2", "test 10", "test 22");
sort($newArray, SORT_NATURAL);
//print_r($cities);
//print_r($newArray);

$mergedArray = array_merge($cities, $newArray); //they need to be the same dimensions
print_r($mergedArray);

