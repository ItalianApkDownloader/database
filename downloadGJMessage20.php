<?php
include "connection.php";
include "function.php";


$accountID = $_POST["accountID"];
$gjp = $_POST["gjp"];
$messageID = $_POST["messageID"];
$isSender = $_POST["isSender"];



if($accountID != ""){
	if(gjpCheck($accountID,$gjp)){
		
			$query=$db->prepare("UPDATE messages SET isRead = 1 WHERE messageID = '".$messageID."'");
			$query->execute();
			$query=$db->prepare("select * from messages where messageID = '".$messageID."'");
			$query->execute();
			$result2 = $query->fetchAll();
			$result = $result2[0];
		if($isSender!=1){
			echo "6:".$result["userName"].":2:".$result["accountID"].":1:".$result["messageID"].":4:".$result["subject"].":8:1:9:0:5:".$result["body"].":7:".convertTime($result["timestamp"]);
		}else{
			echo "6:".$result["userName"].":2:".$result["accountID"].":1:".$result["messageID"].":4:".$result["subject"].":8:1:9:1:5:".$result["body"].":7:".convertTime($result["timestamp"]);
		}	
	}else {
		echo -1;
	}
}else{
	echo -1;
}





?>