<?php

include("Student.php"); //need to include your class on top of all the bitter webpages
//create and instance of the object
$s = new Student(123, "Nick", 42); //create the student object
//$s->setAge(100); //set the age of the student object you created
//echo $s->getAge() . "<BR>"; //get the age of the student object you created

Student::PrintSchool(); //call the static method

PrintDetails($s);

//type-hinting, putting Student in front of the variable
function PrintDetails(Student $student){
    echo $student->__get($name). " " . "<BR>";
}
