<?php
include "connection.php";
include "function.php";




$accountID = $_POST["accountID"];
$gjp = $_POST["gjp"];
$toAccountID = $_POST["toAccountID"];
$subject = $_POST["subject"];
$body = $_POST["body"];
$userName = "";
$admincmd = False;



if($accountID != ""){
	if(gjpCheck($accountID,$gjp)){	
		
		
		
		$query = $db->prepare("SELECT * FROM users WHERE accountID = '".$accountID."'");
		$query->execute();
		$result = $query->fetchAll();
		$temp = $result[0];
		$userName = $temp["userName"];
		$query = $db->prepare("SELECT * FROM users WHERE accountID = '".$toAccountID."'");
		$query->execute();
		$result = $query->fetchAll();
		$temp = $result[0];
		
		if(isAdmin($accountID)){
			
			if($body == "EEFBUEMRVlNb"){  // !user ban
            
            	if(!isAdmin($toAccountID)){
                	$query = $db->prepare("UPDATE `users` SET `stars`= '0' WHERE `accountID` =  '".$toAccountID."'");
                    $query->execute();
                    $query = $db->prepare("INSERT INTO `bannedIP`(`IP`, `accountID`, `reason`) VALUES ('".$temp["IP"]."' , '".$toAccountID."' , 'banned by ".$accountID."')");
                    $query->execute();
                    echo 1;
                    $admincmd = True;
                }
			}
			if($body == "EEFBUEMRQVxXUF8="){  // !user unban
				$query = $db->prepare("DELETE FROM `bannedIP` WHERE IP = '".$temp["IP"]."' ");
				$query->execute();
				echo 1;
				$admincmd = True;
			}
			
			
			
		}
		if(!$admincmd){
			$targetUserName = $temp["userName"];
			$uploadDate = getTime();
			$query = $db->prepare("INSERT INTO messages (userName, targetUserName ,accountID, toAccountID, subject , body ,timestamp)
			VALUES ('$userName' , '$targetUserName','$accountID' , '$toAccountID' , '$subject' , '$body' , '$uploadDate')");
			$query->execute();
			echo 1;
		}
		
		
		
	}else{
		echo -1;
	}
}





?>