<?php
$lat=$_GET['lat'];
$long=$_GET['lng'];
$request_url = 'http://gpp3-wxs.ign.fr/tfn3j0pulpy03h00sv16ychs/alti/rest/elevation.json?lon='.$long.'&lat='.$lat.'&zonly=true'; 
$request_params = '';


$ch = curl_init();
curl_setopt( $ch, CURLOPT_URL, $request_url);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type:text/xml', 'Referer: http://pghm-isere.com'));
$response = curl_exec( $ch );
//echo $response;
//$obj= json_decode($response, true);
echo ($response);

?>
	