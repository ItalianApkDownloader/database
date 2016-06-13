<?php
include "connection.php";
include "function.php";

$accountID = $_POST["accountID"];
$gjp = $_POST["gjp"];
$levelID = $_POST["levelID"];

$query = $db->prepare("SELECT*FROM `levels` WHERE levelID = '".$levelID."' ");
$query->execute();

if($query->rowCount() > 0 ){
	if($accountID != ""){
	if(gjpCheck($accountID,$gjp)){
		$query = $db->prepare("DELETE FROM `levels` WHERE levelID = '".$levelID."' ");
		$query->execute();
		echo 1;
	}
}
}


echo -1;

?>