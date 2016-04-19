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
<!--bibliothèque intl-tel-input pour affichage menu envoi sms-->
<script src="./js/intl-tel-input/build/js/intlTelInput.js"></script>
<link rel="stylesheet" href="./js/intl-tel-input/build/css/intlTelInput.css">
<!--bibliothèque styledLayerControl pour affichage menu couches geo-->


<script src="./js/Leaflet.StyledLayerControl/src/styledLayerControl.js"></script>
 <link rel="stylesheet" href="./js/Leaflet.StyledLayerControl/css/styledLayerControl.css" />
<!--bibliothèque leaflet-ajax-->
<script src="./js/leaflet-ajax/dist/leaflet.ajax.min.js"></script>
<!--bibliothèque restpostgis pour affichage couche résultats géoloc-->
<script src="./js/restpostgis/lvector.js"></script>
<!--biblioteque leaflet pulse pour marker geoloc selectionné-->
<script src="http://pghm-isere.com/gendloc/js/leaflet-pulse/L.Icon.Pulse.js"></script>
<link rel="stylesheet" href="http://pghm-isere.com/gendloc/js/leaflet-pulse/L.Icon.Pulse.css" />


<!-- Draw circle -->


	<script src="./js/leaflet-draw/dist/leaflet.draw.js"></script>
	<link rel="stylesheet" href="./js/leaflet-draw/dist/leaflet.draw.css" />

	<script src="./js/leaflet-draw/src/Toolbar.js"></script>
	<script src="./js/leaflet-draw/src/Tooltip.js"></script>

	<script src="./js/leaflet-draw/src/ext/GeometryUtil.js"></script>
	<script src="./js/leaflet-draw/src/ext/LatLngUtil.js"></script>
	<script src="./js/leaflet-draw/src/ext/LineUtil.Intersect.js"></script>
	<script src="./js/leaflet-draw/src/ext/Polygon.Intersect.js"></script>
	<script src="./js/leaflet-draw/src/ext/Polyline.Intersect.js"></script>
	<script src="./js/leaflet-draw/src/ext/TouchEvents.js"></script>

	<script src="./js/leaflet-draw/src/draw/DrawToolbar.js"></script>
	<script src="./js/leaflet-draw/src/draw/handler/Draw.Feature.js"></script>
	<script src="./js/leaflet-draw/src/draw/handler/Draw.SimpleShape.js"></script>
	<script src="./js/leaflet-draw/src/draw/handler/Draw.Polyline.js"></script>
	<script src="./js/leaflet-draw/src/draw/handler/Draw.Circle.js"></script>
	<script src="./js/leaflet-draw/src/draw/handler/Draw.Marker.js"></script>
	<script src="./js/leaflet-draw/src/draw/handler/Draw.Polygon.js"></script>
	<script src="./js/leaflet-draw/src/draw/handler/Draw.Rectangle.js"></script>


	<script src="./js/leaflet-draw/src/edit/EditToolbar.js"></script>
	<script src="./js/leaflet-draw/src/edit/handler/EditToolbar.Edit.js"></script>
	<script src="./js/leaflet-draw/src/edit/handler/EditToolbar.Delete.js"></script>

	<script src="./js/leaflet-draw/src/Control.Draw.js"></script>

	<script src="./js/leaflet-draw/src/edit/handler/Edit.Poly.js"></script>
	<script src="./js/leaflet-draw/src/edit/handler/Edit.SimpleShape.js"></script>
	<script src="./js/leaflet-draw/src/edit/handler/Edit.Rectangle.js"></script>
	<script src="./js/leaflet-draw/src/edit/handler/Edit.Marker.js"></script>


	<script src="./js/leaflet-draw/src/edit/handler/Edit.Circle.js"></script>
	<script src="./js/leaflet-draw/src/Control.Draw.js"></script>

<!-- maker cluster-->


		<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="./js/leaflet.markercluster/dist/MarkerCluster.css" />
	<link rel="stylesheet" href="./js/leaflet.markercluster/dist/MarkerCluster.Default.css" />
	<script src="./js/leaflet.markercluster/dist/leaflet.markercluster-src.js"></script>


<!-- twitter -->

	

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
 L.drawLocal.draw.toolbar.buttons.polygon = 'Draw a circle!';

        var drawControl = new L.Control.Draw({
            position: 'topright',
            draw: {
                polyline: false,
                polygon: false,
                circle: true,
                marker: false
            },
            edit: {
                featureGroup: drawnItems,
                remove: true
            }
        });
        map.addControl(drawControl);

        map.on('draw:created', function (e) {
            var type = e.layerType,
                layer = e.layer;
			console.log(e);
            if (type === 'marker') {
                layer.bindPopup('A popup!');
            }

            drawnItems.addLayer(layer);
        });

        map.on('draw:edited', function (e) {
            var layers = e.layers;
            var countOfEditedLayers = 0;
            layers.eachLayer(function(layer) {
                countOfEditedLayers++;
            });
            console.log("Edited " + countOfEditedLayers + " layers");
        });

        // L.DomUtil.get('changeColor').onclick = function () {
        //     drawControl.setDrawingOptions({ rectangle: { shapeOptions: { color: '#004a80' } } });
        // };

  </script>



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
