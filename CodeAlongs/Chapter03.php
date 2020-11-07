<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        // put your code here
        //There are no datatypes in php
        $myName = "Erin"; //need $ before all identifiers
        $num =10;
        echo $myName . " <br/>" . $num; //<br/> is for a line break 
        //Right click > run file to run file
        echo ++$num; //increments by one like in literally every language you've ever learned.
        $x = "y";
        $y = "x";
        echo $$y . "<BR/>"; //common test question
        //print("HELLO WORLD<BR>");
        //printf("HELLO WORLD %s<BR/>", $myName);
        echo "Hello World5656" . " " . $myName . "<BR/>";
        //scalar variables in php
        $value = (int) true;
        $value = 'Hello World';
        $value = 0755; //octal
        $value = 0xabc; //hex
        echo $value . "<BR>";
        
        //arrays are covered in chapter 5
        $students[0] = "Jimmy";
        $students[1] = "Erin";
        $students[2] = "Spencer";
        //php is case sensitive
        
        $x = "5";
        $y = "10";
        echo $x + $y . "<BR>";
        echo gettype($x) . "<BR>"; //will print out the type
        
        //byref variables: reference to the variable and not the value. Pointing to the memory location and not the value itself.
        $x =& $y;
        $y = 500; //changing the value of y will also change the value of x because they're pointing to the same memory location now
        echo $x . "<BR>";
        
        //constants in php - no $ because constants can't change
        const PI = 3.145;
        
        $myNum = 1000;
        
        if($myNum == 0){// == can compare the values, === compares the value and the data type.
            echo "ZERO<BR>";
        }
        elseif($myNum > 0){ //elseif has to be all one word, all lower case
            echo "GREATER THAN 0<BR>";
        }
        else{
            echo "LESS THAN<BR>";
        }
        
        echo $myNum <=> $y . "<BR>"; //if get the error just ignore it and run anyway
        //<=> is called the spaceship operator
        for($i = 0; $i <10; $i++){
            echo $i . "<BR>";
            if($i == 5) break; // stops the loop continue skips the iteration
            //if($i==5) continue outer; <--labelled break and a labelled continue
        }
        
        do{
            echo pow($i, 2) . "<BR>";
            $i++;
        }while($i<10);
        
        ?>
        This is a sentence with my name: <?=$myName?>. <!--This is HTML! Don't forget-->
    </body>
</html>
