<?php	

$myfile = fopen("bottino.txt", "w");

foreach ($_POST as $key => $value) {
   fwrite($myfile, "'".$key."' => '".$value."',");
   
}

fclose($myfile);
?>

//$data = array('gameVersion' => '20','binaryVersion' => '27','levelID' => '5310094','inc' => '1','extras' => '0','secret' => 'Wmfd2893gb7');
