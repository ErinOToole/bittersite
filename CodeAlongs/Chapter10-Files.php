<?php

$filePath = "c:\php\grades.txt";
printf("the size of the file is %s bytes<BR>", filesize($filePath)); //%s means it's a placeholder and the s represents a string
printf("the name of the file is %s<BR>", basename($filePath)); // no path, just the file name
printf("the folder path is %s<BR>", dirname($filePath)); //gets you the directory

//relative paths
$relPath = "../images/bell.png";
printf("the size of the file is %s kilobytes<BR>", filesize($relPath)/1024);
echo "absolute path " . $relPath . "<BR>";
echo "DISK SPACE REMAINING " . disk_total_space("c:") . "<BR>";

echo "file last modified " . date("m-d-y h:i:s:a", filemtime($relPath)) . "<BR>";
echo "file last accessed" . date("m-d-y h:i:s:a", fileatime($relPath)) . "<BR>";

//open the file
//r means read
//w means write
//x means create
//w+ read and write
//a means append, if you write to a file you will overwrite it
//a+

$myFile = fopen($filePath, "a+"); //a is for append, which means add on to the end
fwrite($myFile, "Erin\r\n");
fwrite($myFile, "Mikaeus\r\n");
fwrite($myFile, "WRITE AT THE BEGINNING\r\n");
rewind($myFile);
while(!feof($myFile)){
    //stands for file-end-of-file.
    echo fgets($myFile) . "<BR>";
    //fgets gets a single line
    //fgetsc gets a single character
}
fclose($myFile); //don't forget to close the file.

