<?php
//Récupération des valeurs passées
//$entree = texte de recherche
$entree = $_GET["c"];
$center_x = $_GET["pt_x"];
$center_y = $_GET["pt_y"];
//url de requete BAN adresse.gouv.fr
$request_url = htmlentities('http://api-adresse.data.gouv.fr/search/?q='.$entree.'&limit=10&lat='.$center_y.'&lon='.$center_x);
//requete curl
$ch = curl_init();
curl_setopt( $ch, CURLOPT_URL, $request_url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Referer: http://pghm-isere.com'));
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
$response = curl_exec( $ch );
//response au format json
$res = json_decode($response);
//Renvoi du résultat au navigateur

if (count($res->features)<>0){
//entête tableau résultat

echo '<table id="ban-table"><caption>BASE ADRESSE NATIONALE</caption>
   
  <thead> <!-- En-tête du tableau -->
       <tr>
	       <th style="display:none;">lat</th>
		   <th>nom</th>
		   <th>ville</th>
		   <th>code postal</th>
      	   <th style="display:none;">lon</th>
	</tr>
   </thead><tbody style="text-align:left">';
//corps du tableau 
foreach($res->features as $key => $feature) {
	$nom = $feature->properties->name;
	$ville = $feature->properties->village.$feature->properties->town.$feature->properties->city;
	$cp = $feature->properties->postcode;
	$lat = $feature->geometry->coordinates[0];
	$lon = $feature->geometry->coordinates[1];
	
   	echo '<tr class=""><td style="display:none;">', $lat, '</td><td class="nom">', $nom, '</td><td>',$ville, '</td><td>',$cp, '</td><td style="display:none;">' , $lon, '</td></tr>';
        }
echo '</tbody></table>';
}
?>
	