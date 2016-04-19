<?php  require "vendor/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;


function getConnectionWithAccessToken($oauth_token, $oauth_token_secret) {
  $connection = new TwitterOAuth( "1CrsIZMrUwTxKiLCVJ4l1e3C7", "KMXjQjvGmAiPOBYUCjRwEGIEQRiOmdERUob95aKJ1jvLVyBhTY", $oauth_token, $oauth_token_secret);
  return $connection;
}


function get_tweets($pos_lat, $pos_long, $time_begin, $time_end, $radius, $filtre){
  $connection = getConnectionWithAccessToken("3728801115-yJCRSR6GrWSWFS2aH9ijJMZbTbqqN0HsorX9Ffq", "vw3bG5cXvo2k7fInSvV4ISgioT1cQuMI4zc1X8XYaWAmF");
  $content = $connection->
  get("search/tweets",["q" => $filtre,"since" => $time_begin,"until" => $time_end, "geocode" => $pos_lat.",".$pos_long.",".$radius."km"]);

  $data = json_encode((array)$content);
  return $data;
}

$pos_lat = $_GET["pos_lat"];
$pos_long = $_GET["pos_long"];
$time_begin = $_GET["time_begin"];
$time_end = $_GET["time_end"];
$radius = $_GET["radius"];
$filtre = $_GET["filtre"];

print_r(get_tweets($pos_lat,$pos_long,$time_begin,$time_end,$radius, $filtre));
?>
