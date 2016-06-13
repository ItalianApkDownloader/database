<?php


function gjpCheck($accountID,$gjp) {
	include "connection.php";

	$query2 = $db->prepare("SELECT * FROM users WHERE accountID='$accountID' ");
	$query2->execute();
	$result = $query2->fetchAll();
	$user = $result[0];
	if($query2->rowCount() > 0){
		$checkCode = $user["gjp"];
		if($checkCode != ""){
			if($checkCode == $gjp){
				return True;
			}
		}else{
			$query2 = $db->prepare("UPDATE `users` SET gjp = ".$checkCode."  WHERE accountID = '".$accountID."'  ");
			$query2->execute();
			return True;
		}
	}
	return False;
}




?>