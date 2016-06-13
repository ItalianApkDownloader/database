<?php
	include "../connection.php";
	// getting all game data
	$userName = $_POST["userName"];
	$password = md5($_POST["password"]);
	$email = $_POST["email"];
	$secret = $_POST["secret"];
	
	$query2 = $db->prepare("SELECT * FROM accounts WHERE userName = '".$userName."' ");
	$query2->execute();
	
	//checking if the username is used 
	if ($query2->rowCount() > 0) {
		echo "-2";  //game message: user not available
		exit;
	}else{
		//checking if the register request is from the game
		if($secret!=""){
			$query2 = $db->prepare("INSERT INTO accounts (userName, password, email)
				VALUES ('$userName', '$password', '$email')");
			$query2->execute();
			echo 1;
		}else{
			echo -1;  // login failed
		}
	}	
?>