<?php
$entree = $_GET["c"];
$nw_x = $_GET["pt1_x"];
$nw_y = $_GET["pt1_y"];
$se_x = $_GET["pt2_x"];
$se_y = $_GET["pt2_y"];
$p1 = $se_y." ".$nw_x;
$p2 = $nw_y." ".$se_x;
$request_url = 'http://gpp3-wxs.ign.fr/tfn3j0pulpy03h00sv16ychs/geoportail/ols?';
$request_params = '<?xml version="1.0" encoding="UTF-8"?>
<XLS
  xmlns:xls="http://www.opengis.net/xls"
  xmlns:gml="http://www.opengis.net/gml"
  xmlns="http://www.opengis.net/xls"
  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
  version="1.2"
  xsi:schemaLocation="http://www.opengis.net/xls http://schemas.opengis.net/ols/1.2/olsAll.xsd">
          <RequestHeader/>
            <Request maximumResponses="10" methodName="LocationUtilityService" requestID="uid42" version="1.2">
                   <GeocodeRequest returnFreeForm="false">
                     <Address countryCode="PositionOfInterest">
                        <freeFormAddress>'.$entree.'</freeFormAddress>
						
						
						<gml:envelope>
                             <gml:pos>'.$p1.'</gml:pos>
                             <gml:pos>'.$p2.'</gml:pos>
                        </gml:envelope>
                     </Address>
                   </GeocodeRequest>
          </Request>
</XLS>';
//<Request requestID="1" version="1.2" methodName="LocationUtilityService"><Place type="Departement">38</Place><Place type="Departement">73</Place><Place type="Departement">05</Place>	<Place type="Departement">26</Place><Place type="nature"></Place><Place type="nature"></Place>GeocodeRequest

$ch = curl_init();
curl_setopt( $ch, CURLOPT_URL, $request_url);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml', 'Referer: http://pghm-isere.com'));
curl_setopt( $ch, CURLOPT_POST, 1 );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $request_params );
$response = curl_exec( $ch );

//echo $response;

$res = new SimpleXMLElement($response);

//echo $res->Response->GeocodeResponse->GeocodeResponseList->GeocodedAddress[1]->Address->Place[3];
if (!empty($res->Response->GeocodeResponse->GeocodeResponseList->GeocodedAddress)){
echo '<table id="my-table"><caption>TOPONYME IGN</caption>
   
  <thead> <!-- En-tête du tableau -->
       <tr>
	       <th style="display:none;">lng</th>
           <th>Nom</th>
           <th>Commune</th>
		   <th style="display:none;">lat</th>
		</tr>
   </thead><tbody style="text-align:left">';
foreach ($res->Response->GeocodeResponse->GeocodeResponseList->GeocodedAddress as $place) {
	$coord = explode(";", $place->Address->Place[2]);
	$lat = $coord[1];
	$lng = $coord[0];
	echo '<tr class="">', '<td style="display:none;">',$lng,'</td><td class="nom">',$place->Address->Place[0], '</td>', '<td class="com">',$place->Address->Place[3], '</td><td style="display:none;">',$lat,'</td></tr>';
	}

echo '</tbody></table>';
}
?>
	