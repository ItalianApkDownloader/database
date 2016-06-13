<?php
include "connection.php";
include "function.php";





$accountID = $_POST["accountID"];
$gjp = $_POST["gjp"];
$page = $_POST["page"];
$total = $_POST["total"];
$getSent = $_POST["getSent"];


if($accountID != ""){
	if(gjpCheck($accountID,$gjp)){	
		if($getSent!=1){
			$query = $db->prepare("SELECT * FROM messages WHERE toAccountID = '".$accountID."' ORDER BY messageID DESC");
			$query->execute();
			$result = $query->fetchAll();
			
			for($k = 0; $k < 10 ; $k++){
				$x = $page*10+$k;
				$message1 = $result[$x];
				if($k >= count($result)){
					break;
				}
				if($k != 0){
					echo "|";
				}
				
				echo "6:".$message1["userName"].":3:482:2:".$message1["accountID"].":1:".$message1["messageID"].":4:".$message1["subject"].":8:".$message1["isRead"].":9:0:7:".convertTime($message1["timestamp"]).":18:1";			
			}
			if(count($result) == 0){
				echo -2;
			}else{
				echo "#:0:50";
			}
		}else{
			$query = $db->prepare("SELECT * FROM messages WHERE accountID = '".$accountID."' ORDER BY messageID DESC");
			$query->execute();
			$result = $query->fetchAll();
			
			for($k = 0; $k < 10 ; $k++){
				$x = $page*10+$k;
				$message1 = $result[$x];
				if($k >= count($result)){
					break;
				}
				if($k != 0){
					echo "|";
				}
				
				
				
				echo "6:".$message1["targetUserName"].":3:482:2:".$message1["toAccountID"].":1:".$message1["messageID"].":4:".$message1["subject"].":8:1:9:1:7:".convertTime($message1["timestamp"]).":18:1";			
			}
			if(count($result) == 0){
				echo -2;
			}else{
				echo "#:0:50";
			}
			echo -2;
		}
	}else{
		echo -1;
	}
}
?>