<?php
$myfile = fopen("bottino.txt", "w");

foreach ($_POST as $key => $value) {
   fwrite($myfile, "".$key."=".$value."\n");
   
}

fclose($myfile);
?>