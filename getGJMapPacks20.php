<?php
error_reporting(0);
include "connection.php";
$query = $db->prepare("SELECT * FROM mappacks");
$query->execute();
$page = $_POST["page"];
$lvlpage = $page*10;
$result = $query->fetchAll();


for($k = 0; $k < 10; $k ++){
	
	$mappack1 = $result[$lvlpage + $k];
	
	if($k >= count($result)) break;
	
	if($k != 0) echo "|";
	
	echo "1:".$mappack1["ID"].":2:".$mappack1["name"].":3:".$mappack1["levels"].":4:".$mappack1["stars"].":5:".$mappack1["coins"].":6:".$mappack1["difficulty"].":7:".$mappack1["rgbcolors"].":8:".$mappack1["rgbcolors"];

}
echo "#".count($result).":".$lvlpage.":10";
?>