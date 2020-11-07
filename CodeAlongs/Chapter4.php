<?php

//function AddNumber(int $x, $y) is called type-hinting. Will cause an exception if type doesn't match. Will probably still cause red squiggles but will compile.
//type hinting is for readability.
function AddNumbers($x, $y){
    return $x + $y;
}//end function

echo AddNumbers(5, 50) . "<BR>";
echo rand(1,6) . "<BR>"; //random number between 1 and 6

//pass by value is default
//to pass by ref: &$x <--if that variable changes inside the function it will also change wherever it's being called from
function PrintMessage ($x){
    $x = "Bonjour monde";
    echo $x . "<BR>";
}//end function PrintMessage

$message = "Hello World";
PrintMessage($message); //will print "Bonjour Monde" because it's passing by value
echo $message . "<BR>";

function Factorial ($n){
    ($n == 1) ? 1: $n * Factorial($n-1);
    //if ($n == 1){
    //    return 1;
    //}
    //else{
    //    return $n * Factorial ($n-1);
    //}
}

echo Factorial(10) . "<BR>";
?>

