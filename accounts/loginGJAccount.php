<?php
	include "../connection.php";
	
	//getting game data
	$udid = $_POST["udid"];
	$userName = htmlspecialchars($_POST["userName"],ENT_QUOTES);
	$password = md5($_POST["password"]);
	
	
	
	
	
	$query = $db->prepare("SELECT * FROM accounts WHERE userName = '".$userName."' AND password = '".$password."' ");
	$query->execute();
	$res = $query->fetchAll();
	$account = $res[0];
	
	
	
	$id = "0";
	$accId = "0";
	
	//checking if username and password exists
	if ($query->rowCount() > 0) {
		//checking if account is in user table
		$query2 = $db->prepare("SELECT * FROM users WHERE accountID = '".$account["accountID"]."'");
		$query2->execute();
		$result = $query2->fetchAll();
		$user = $result[0];
		if ($query2->rowCount() > 0) {
			$id = $user["userID"];
			$accId = $user["accountID"];
		}else{
			//checking if any user have the same udid of the account
			$query2 = $db->prepare("SELECT * FROM users WHERE udid = '".$udid."' AND isRegistered = '0' ");
			$query2->execute();
			$result = $query2->fetchAll();
			$user = $result[0];
			if ($query2->rowCount() > 0) {
				$accId = $account["accountID"];
				$id = $user["userID"];
				$query2 = $db->prepare("UPDATE `users` SET accountID = ".$accId." , isRegistered = '1' , userName = '".$userName."' WHERE userID = '".$id."'  ");
				$query2->execute();
			}else{
				$accId = $account["accountID"];
				$query2 = $db->prepare("INSERT INTO `users` (`isRegistered`, `accountID`, `userName`, `udid`) VALUES ( '1' , '".$accId."' , '".$account["userName"]."' , '".$udid."' ) ");
				$query2->execute();
				$id = $db->lastInsertId();
			}
		}		
		echo $accId.",".$id;     // accountID,userID
	}else{
		echo -1; // login failed
	}
?>