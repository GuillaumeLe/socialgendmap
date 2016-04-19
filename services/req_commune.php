<?php
$lat=$_GET['lat'];
$long=$_GET['lng'];

//connection bdd
include ('./conn/conn.inc.php');

$loc ="POINT(".$long." ".$lat.")";
$quer ="SELECT commune.commune, service FROM commune INNER JOIN competence ON commune.ref_insee = competence.insee WHERE ST_Contains(geom,ST_GeometryFromText('$loc',4326))";
$result = pg_query($dbconn, $quer);
$row = pg_fetch_row($result,0);
$com= pg_escape_string($row[0]);
$bp = pg_escape_string($row[1]);
$arr= array('commune' => $com, 'bp' => $bp);
echo json_encode($arr);
?>
	