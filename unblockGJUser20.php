<?php
include "connection.php";
include "function.php";

$accountID = $_POST["accountID"];
$gjp = $_POST["gjp"];
$targetAccountID = $_POST["targetAccountID"];

if($accountID != ""){
	if(gjpCheck($accountID,$gjp)){
		$query = $db->prepare("DELETE FROM `blocked` WHERE accountID1 = '".$accountID."' and accountID2 = '".$targetAccountID."' ");
		$query->execute();
		echo 1;
	}
}
echo -1;
?>