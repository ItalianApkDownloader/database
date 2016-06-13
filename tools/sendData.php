<?php
//error_reporting(0);



$url = "http://www.newgrounds.com/audio/listen/682074"; 
$ch = curl_init($url); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
$sorgente = curl_exec($ch); 
curl_close($ch); 

//$a = highlight_string($sorgente); 





$use_include_path = false;
$context=null;
$offset = -1;
$maxLen=-1;
$lowercase = true;
$forceTagsClosed=true;
$target_charset = DEFAULT_TARGET_CHARSET;
$stripRN=true;
$defaultBRText=DEFAULT_BR_TEXT;




$url = 'http://www.boomlings.com/database/getGJSongInfo.php';
$data = array('songID' => '682074','secret' => 'Wmfd2893gb7');

$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data),
    ),
);



$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
echo $result;


?>