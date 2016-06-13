<?php
error_reporting(0);
include "connection.php";
include "function.php";

$accountID = $_POST["accountID"];
$page = $_POST["page"];

$pnow = $page;


$query = "SELECT * FROM accComments WHERE accountID = '".$accountID."' ORDER BY timeStamp DESC";
$query = $db->prepare($query);
$query->execute();
$result = $query->fetchAll();



if($page == 0){
	$query1 = $db->prepare("SELECT * FROM users WHERE accountID = '".$accountID."'");
	$query1->execute();
	$result1 = $query1->fetchAll();
	$views = $result1[0];
	
	$temp = base64_encode ( "Users visit this profile ".$views["views"]." times!" );
	
	//$temp = base64_encode ( "The server will close in 1-2 days thanks for all!" );

	echo "2~".$temp."~3~~4~0~5~0~7~0~9~BAD news~6~0";
	echo "|";
}


for($k=0 ; $k < 9 ; $k ++){
	$x = $pnow*10 + $k;
	$temp = $result[$x];
	if($x >=count($result)){
		break;
	}
	if($k != 0){
		echo "|";
	}
	
	echo "2~".$temp["comment"]."~3~".$temp["accountID"]."~4~".$temp["likes"]."~5~0~7~0~9~".convertTime($temp["timestamp"])."~6~".$temp["commentID"];
}

echo "#".count($result).":".$page.":10";

?>	