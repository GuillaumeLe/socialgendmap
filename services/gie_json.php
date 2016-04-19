<?php

$unite = $_GET["unite"];

function escapeJsonString($value) { # list from www.json.org: (\b backspace, \f formfeed)
  $escapers = array("\\", "/", "\"", "\n", "\r", "\t", "\x08", "\x0c");
  $replacements = array("\\\\", "\\/", "\\\"", "\\n", "\\r", "\\t", "\\f", "\\b");
  $result = str_replace($escapers, $replacements, $value);
  return $result;
}
 
# Connect to pgsql database
try
{
	$conn = pg_connect("host=xxxxxxxxxxxx dbname=xxxxxxxxxxxx user=xxxxx password=xxxxxxx") or die("Connexion impossible : " . pg_last_error());
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}
 
# Build SQL SELECT statement and return the geometry as a GeoJSON element in EPSG: 4326
//$sql = "SELECT ST_AsGeoJSON(geom) from geotrack WHERE geotrack.datetime::text::date = 'now'::text::date;";
$sql = "SELECT ST_AsGeoJSON(geom3d),id, service, adresse, telephone FROM accueil";
//echo $sql;
 
# Try query or error
$rs = pg_query($conn, $sql);
if (!$rs) {
    echo "An SQL error occured.\n";
    exit;
}
$sortie='['; 
while ($row = pg_fetch_row($rs)) {
$sortie.='{"geometry": '.$row[0].', "type": "Feature", "properties": {"id":"'.$row[1].'","service":"'.$row[2].'","adresse":"'.$row[3].'","telephone":"'.$row[4].'"}},';
}
$sortie=substr($sortie,0,-1);
$sortie.=']';
echo $sortie; 
  ?>