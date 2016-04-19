<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-type" content="text/html ; charset=UTF-8" />
    <meta  charset="UTF-8" >
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<!--bibliothèque jquery -->
<script src="http://code.jquery.com/jquery-2.1.3.min.js"></script>
<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.css" />
<script src="http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.js"></script>
<!--bibliothèque leaflet pour affichage map-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<!--bibliothèque sidebar pour affichage menu-->
<script src="./js/sidebar/leaflet-sidebar.min.js"></script>
<link rel="stylesheet" href="./js/sidebar/leaflet-sidebar.css" />
<!--bibliothèque dynatable pour affichage résultats recherches et sms-->
<script src="./js/jquery-dynatable/jquery.dynatable.js"></script>
<link rel="stylesheet" href="./js/jquery-dynatable/jquery.dynatable.css" />
<!--bibliothèque coordinates pour affichage coordonnées sous la souris-->
<script src="./js/Leaflet.Coordinates/dist/Leaflet.Coordinates-0.1.4.src.js"></script>
<link rel="stylesheet" href="./js/Leaflet.Coordinates/dist/Leaflet.Coordinates-0.1.4.css" />
<!--[if lte IE 8]><link rel="stylesheet" href="./js/Leaflet.Coordinates/dist/Leaflet.Coordinates-0.1.4.ie.css" /><![endif]-->
<!--feuille de style table-->
<link rel="stylesheet" href="./css/table.css" />
<!--bibliothèque intl-tel-input pour affichage menu envoi sms
<script src="./js/intl-tel-input/build/js/intlTelInput.js"></script>
<link rel="stylesheet" href="./js/intl-tel-input/build/css/intlTelInput.css">-->
<!--bibliothèque styledLayerControl pour affichage menu couches geo-->
<script src="./js/Leaflet.markercluster/build.js"></script>
<script src="./js/Leaflet.markercluster/deps.js"></script>
<script src="./js/Leaflet.markercluster/hintrc.js"></script>
<script src="./js/Leaflet.StyledLayerControl/src/styledLayerControl.js"></script>
 <link rel="stylesheet" href="./js/Leaflet.StyledLayerControl/css/styledLayerControl.css" />
<!--bibliothèque leaflet-ajax-->
<script src="./js/leaflet-ajax/dist/leaflet.ajax.min.js"></script>
<!--bibliothèque restpostgis pour affichage couche résultats géoloc-->
<script src="./js/restpostgis/lvector.js"></script>
<!--biblioteque leaflet pulse pour marker geoloc selectionné-->
<script src="http://pghm-isere.com/gendloc/js/leaflet-pulse/L.Icon.Pulse.js"></script>
<link rel="stylesheet" href="http://pghm-isere.com/gendloc/js/leaflet-pulse/L.Icon.Pulse.css" />

    <style>
      body {
      padding: 0;
      margin: 0;
      }
      html, body, #map {
      height: 100%;
      font-family: Verdana, Arial, sans-serif;
      font-size: 12px;
      }
    </style>
     
  </head>
  <body>
      <script>
    //{# Définitions des fonctions utilisées par la carte #}
    function ConvertDDToDMS(D){
        var sign;
    	D<0?sign="-":"";
    	return [sign,Math.abs(0|D), '° ', 0|(D<0?D=-D:D)%1*60, "' ", 0|D*60%1*60, '"'].join('');
    }
    function ConvertDDToDMM(D){
    	var sign;
    	D<0?sign="-":"";
    	return [sign,Math.abs(0|D), '° ', ((D<0?D=-D:D)%1*60).toFixed(3), "' "].join('');
    }
    </script>
  
   
    <!-- {% block body %} {# Définitions du bloc body qui contient la sidebar et la carte #}-->


    <!-- {% block sidebar%}-->
        <?php include('sidebar_menu.php'); ?>
    <!-- {% endblock %}-->

     <!-- {% block carte %}-->
        <?php include('carte.php') ?>
    <!--  {% endblock %}-->

   
    <!-- {% endblock %} -->
  </body>
</html>
