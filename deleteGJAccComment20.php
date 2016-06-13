<?php
include "connection.php";
include "function.php";

$accountID = $_POST["accountID"];
$gjp = $_POST["gjp"];
$commentID = $_POST["commentID"];
$cType=1;

if($accountID != ""){
	if(gjpCheck($accountID,$gjp)){
		$query = $db->prepare("DELETE FROM `accComments` WHERE commentID = '".$commentID."' ");
		$query->execute();
		echo 1;
	}
}
echo -1;
?>