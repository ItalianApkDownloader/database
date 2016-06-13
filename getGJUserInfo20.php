<?php
include "function.php";
include "connection.php";


	$accountID = $_POST["accountID"];
	$gjp = $_POST["gjp"];
	$targetAccountID = $_POST["targetAccountID"];



if($accountID != ""){
	if(gjpCheck($accountID,$gjp)){
		$query1 = $db->prepare("SELECT * FROM users WHERE accountID = '".$targetAccountID."'");
		$query1->execute();
		$result1 = $query1->fetchAll();
		$temp = $result1[0];
		$views = $temp["views"];
		$views = $views + 1;
		$query1 = $db->prepare("UPDATE `users` SET `views`= '".$views."' WHERE `accountID` =  '".$targetAccountID."'");
		$query1->execute();
		
		
		
		$totNewMessage = 0;
		$totNewFriends = 0;
		$totNewFriendRequest = 0;
		$isFriend = 0;
		
		$blockMessage = 0;
		$blockFriendRequest = 0;
		$yt = "";
		
		
		
		$query = $db->prepare("SELECT * FROM accSetting WHERE accountID = '".$targetAccountID."'");
		$query->execute();
		$result = $query->fetchAll();
		$user = $result[0];
		
		$blockMessage = $user["mS"];
		$blockFriendRequest = $user["frS"];
		$yt = $user["yt"];
		
		
		
		
		if(isBlocked($accountID,$targetAccountID)){
			exit;
		}
		
		
		
		
		$position = getGlobalPosition($targetAccountID);

		$query = $db->prepare("SELECT * FROM users WHERE accountID = '".$targetAccountID."'");
		$query->execute();
		$result = $query->fetchAll();
		$user = $result[0];
		
		
		
		
		if(isFriend($accountID , $targetAccountID )){
			$isFriend = 1;
			if($blockMessage == 2)
				$blockMessage = 0;
		}
		
		if(haveRequest($accountID , $targetAccountID)){
			$isFriend = 4;
		}
		
		
		if($accountID == $targetAccountID){
			$query2 = $db->prepare("SELECT * FROM messages WHERE toAccountID = '".$accountID."' and isRead = 0 ");
			$query2->execute();
			$result2 = $query2->fetchAll();
			$totNewMessage = count($result2);
			$query2 = $db->prepare("SELECT * FROM friendRequests WHERE toAccountID = '".$accountID."' and isNew = 1 ");
			$query2->execute();
			$result2 = $query2->fetchAll();
			$totNewFriendRequest = count($result2);
			$query2 = $db->prepare("SELECT * FROM friends WHERE accountID1 = '".$accountID."' and isNew = 1 ");
			$query2->execute();
			$result2 = $query2->fetchAll();
			$totNewFriends = count($result2);
		}
		
		
		

		if($accountID != ""){
			if(gjpCheck($accountID,$gjp)){		
                                if(isAdmin($accountID)){
                                      $blockMessage = 0;
		                      $blockFriendRequest = 0;
                                }
				echo "1:".$user["userName"].":2:".$user["userID"].":13:".$user["coins"].":17:".$user["userCoins"].":10:".$user["color1"].":11:".$user["color2"].":3:".$user["stars"].":4:".$user["demons"].":8:".$user["creatorPoints"].":18:".$blockMessage.":19:".$blockFriendRequest.":20:".$yt.":21:".$user["accIcon"].":22:".$user["accShip"].":23:".$user["accBall"].":24:".$user["accBird"].":25:".$user["accDart"].":26:".$user["accRobot"].":28:".$user["accGlow"].":30:".$position.":16:".$user["accountID"].":38:".$totNewMessage.":39:".$totNewFriendRequest.":40:".$totNewFriends.":31:".$isFriend.":29:1";
			}else{
				echo -1;
			}
		}else{
			echo "1:".$user["userName"].":2:".$user["userID"].":13:".$user["coins"].":17:".$user["userCoins"].":10:".$user["color1"].":11:".$user["color2"].":3:".$user["stars"].":4:".$user["demons"].":8:".$user["creatorPoints"].":18:".$blockMessage.":19:".$blockFriendRequest.":20:".$yt.":21:".$user["accIcon"].":22:".$user["accShip"].":23:".$user["accBall"].":24:".$user["accBird"].":25:".$user["accDart"].":26:".$user["accRobot"].":28:".$user["accGlow"].":30:".$position.":16:".$user["accountID"].":38:666:39:777:40:888:29:1";
		}

	}
}

	





?>	