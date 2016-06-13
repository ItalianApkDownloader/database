<?php
include "connection.php";
include "function.php";

$accountID = $_POST["accountID"];
$gjp = $_POST["gjp"];
$mS = $_POST["mS"];
$frS = $_POST["frS"];
$yt = $_POST["yt"];

		



if($accountID != ""){
	if(gjpCheck($accountID,$gjp)){
		$query2 = $db->prepare("SELECT * FROM `accSetting` WHERE accountID='".$accountID."' ");
		$query2->execute();	
		
		if($query2->rowCount() > 0){
			$query3 = $db->prepare("UPDATE `accSetting` SET mS = '".$mS."' , frS = '".$frS."' , yt = '".$yt."' WHERE accountID = '$accountID'  ");
			$query3->execute();	
			echo 1;
		}else{
			$query2 = $db->prepare("INSERT INTO `accSetting`(`accountID`, `mS`, `frS`, `yt`) VALUES ('$accountID','$mS', '$frS' , '$yt' )");
			$query2->execute();	
			echo 1;
		}		
	}
}
echo -1;
?>