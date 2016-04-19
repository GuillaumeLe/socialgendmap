<?php
//Récupération des valeurs passées
//$entree = texte de recherche
$entree = $_GET["c"];
$nw_x = $_GET["pt1_x"];
$nw_y = $_GET["pt1_y"];
$se_x = $_GET["pt2_x"];
$se_y = $_GET["pt2_y"];
$p1 = $se_y." ".$nw_x;
$p2 = $nw_y." ".$se_x;
//url de requete nominatim
$request_url = 'http://nominatim.openstreetmap.org/search?q='.$entree.'&format=xml&countrycodes=fr&polygon_geojson=1&addressdetails=1&bounded=1&viewbox='.$nw_x.','.$nw_y.','.$se_x.','.$se_y;
$request_params = '<?xml version="1.0" encoding="UTF-8"?>';
//requete curl
$ch = curl_init();
curl_setopt( $ch, CURLOPT_URL, $request_url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml', 'Referer: localhost'));
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
$response = curl_exec( $ch );
//parser la réponse XML
$res = new SimpleXMLElement($response);
//Renvoi du résultat au navigateur
if (!empty($res->place)){
//entête tableau résultat
echo '<table id="nominatim-table"><caption>BASE NOMINATIM</caption>
   
  <thead> <!-- En-tête du tableau -->
       <tr>
	       <th style="display:none;">lat</th>
		   <th>nom</th>
		   <th>type</th>
		   <th style="display:none;">lon</th>
		</tr>
   </thead><tbody style="text-align:left">';
//corps du tableau
foreach($res->place as $place)
  {
  echo '<tr class=""><td style="display:none;">', $place[lat], '</td><td class="nom">', $place["display_name"], '</td><td>', $place["type"], '</td><td style="display:none;">' , $place[lon], '</td><tr>';
  }
  
echo '</tbody></table>';
}
?>
	