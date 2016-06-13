<?php
$songid = htmlspecialchars($_POST["songID"],ENT_QUOTES);


$url = 'http://www.boomlings.com/database/getGJSongInfo.php';
$data = array('songID' => '682074', 'secret' => 'Wmfd2893gb7');
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