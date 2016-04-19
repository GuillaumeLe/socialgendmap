<!-- LA CARTE -->
<div id="map" class="sidebar-map"></div>

<script type="text/javascript">




  // Cle API Geoportail #}
  var apiKey = "XXXXXXXXXXXXXXXXXXXXXXXX";
  
  // Liste des couches a afficher #}
  var layers = new Array();
  
  // L'url des services Geoportail #}
  function geopUrl (key, layer, format)
  {	return "http://wxs.ign.fr/"+ key + "/wmts?LAYER=" + layer
  +"&EXCEPTIONS=text/xml&FORMAT="+(format?format:"image/jpeg")+"&SERVICE=WMTS&VERSION=1.0.0&REQUEST=GetTile&STYLE=normal&TILEMATRIXSET=PM"
  +"&TILEMATRIX={z}&TILECOL={x}&TILEROW={y}" ;
  }
 
  var attributionIGN = '&copy; <a href="http://www.ign.fr/">IGN-France</a>';
		 
  // Definition des couches #}
  // Carte IGN #}
  var SCAN = L.tileLayer(geopUrl(apiKey,"GEOGRAPHICALGRIDSYSTEMS.MAPS"), { attribution:attributionIGN, maxZoom:18 } );
  var SCANEXPRESS = L.tileLayer(geopUrl(apiKey,"GEOGRAPHICALGRIDSYSTEMS.MAPS.SCAN-EXPRESS.CLASSIQUE"), { attribution:attributionIGN, maxZoom:18 } );
  var ORTHO = L.tileLayer(geopUrl(apiKey,"ORTHOIMAGERY.ORTHOPHOTOS"), { attribution:attributionIGN, maxZoom:19 } );

  
  
  // Carte Open OpenStreetMap_Mapnik #}
  var osmfr = L.tileLayer('http://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
  attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap France</a>'
  });

  
// centre la carte sur l'ENSTA
  var center_x = 2.2187066;
  var center_x = -105.02; // USA
  var center_y = 48.7110092;
  var center_y = 40.5; //USA 

  var center_z = 12; // définition du zoom
  
  // marker resultat geoloc		
  var locMarker = L.Icon.extend({
          options: {
              iconUrl: "{{ asset('images/icon/loc.png') }}", //POINT ROUGE
              shadowUrl: null
          }
  });

  // marker pulse icon
  var pulsingIcon = L.icon.pulse({iconSize:[20,20],color:'red'});

  
  // La carte Leaflet #}
  var map = L.map("map", {
      center: new L.LatLng(center_y, center_x),
      zoom: 5,
	  maxZoom:16
  });
map.doubleClickZoom.disable(); 



function traceLayer(nomlayer,donnees,map)
{
var ligne=0;
var points=[];
	for( ligne=0; ligne<donnees.length ;ligne++)
	{
		nomlayer.addLayer( L.marker( [ donnees[ligne]["locx"],donnees[ligne]["locy"] ]).bindPopup( dessinepopup(donnees[ligne])));
	}





map.addLayer(nomlayer);



}

function dessinepopup(texte)
{
	bulle=texte["contenu"];
	bulle+= '<hr/>';	
	bulle+= 'Date: ' + texte["date"] + " ; ";	
	bulle+= 'x:' + texte["locx"] + ' ; y:' + texte["locy"] + '<br/>';	
	bulle+='Utilisateur: ' + texte["user"] + "<br/>";	
	bulle+='URL: ' + texte["url"] + "<br/>";	
	bulle+='<hr/>';
	bulle+='<a class="btn btn-danger" href="#"><i class="fa fa-star-o fa-3x"></i></a>';	
	bulle+='<a class="btn btn-danger" href="#"><i class="fa fa-envelope-o fa-3x"></i></a>'; // enlever si mail est vide	
	bulle+='<a class="btn btn-danger" href="#"><i class="fa fa-trash-o fa-3x"></i></a>';	


	return bulle;


}




donnees=[{locx:40.65 , locy: -105.02,contenu:"test",date:"aujourd'hui"},
			{locx:40.65 , locy: -104.02,contenu:"test",date:"aujourd'hui"},
			{locx:41.65 , locy: -104.02,contenu:"test",date:"aujourd'hui"},
			{locx:41.65 , locy: -105.02,contenu:"test",date:"aujourd'hui"},


];
var twitter_layer=L.markerClusterGroup({ 
   spiderfyOnMaxZoom: false,
    showCoverageOnHover: false,
    zoomToBoundsOnClick: false});
	
	
traceLayer(twitter_layer,donnees,map);

L.circle([40.65, -104.02], 50000).addTo(map);


		twitter_layer.on('clusterclick', function (e) {

			//twitter_layer.bindPopup("<b>Hello world!</b><br>I am a popup.").openPopup();
			//alert('cluster ' + a.layer.getAllChildMarkers().length);
			

				// ATTENTION AU ZERO, c'est un tavbleau a balayer
				
				var contenu="<b>nb element: "+ e.layer._childClusters[0]._childCount+"</b><br/><br/>";
				var ligne=0;
				
				for(ligne=0;ligne<e.layer._childClusters[0]._childCount;ligne++)
				{
					contenu+=e.layer._childClusters[0]._markers[ligne]._popup._content+"<br/><br/>";
				}
			L.popup()
				.setLatLng(e.latlng)
				.setContent(contenu)
				.openOn(map);
			
		});


//map.removeLayer(cities);




// ajout de la couche IGN SCAN #}
//map.addLayer(SCAN);
 map.addLayer(osmfr);
 

  
  // rÃ©cupÃ©ration de la boundingbox #}
  nw = map.getBounds().getNorthWest();
  se = map.getBounds().getSouthEast();

 
  
  // initialisation et ajout menu couches #}
  var baseMaps = [{
      groupName : "OSM",
      expanded : true,
      layers    : {
           "OSM FRANCE": osmfr}
  },
  {
      groupName : "IGN",
      expanded : true,
      layers    : {
          "SÃ©ries SCAN" : SCAN,
          "SÃ©ries EXPRESS": SCANEXPRESS,
          "SÃ©rie Orthophoto": ORTHO
      }
  }];  

  var overlays = [];

  var options = {
      container_width : "200px",
      container_maxHeight : "400px", 
      group_maxHeight : "150px",
      exclusive : false
  };
		
  var control = L.Control.styledLayerControl(baseMaps, overlays, options);
  map.addControl(control);

 
  
  // affichage sidebar #}
  var sidebar = L.control.sidebar('sidebar').addTo(map);

  
  // affichage échelle en bas à gauche #}
  L.control.scale({'position':'bottomleft','metric':true,'imperial':false }).addTo(map);

  // affichage coordonnÃ©es curseur DD en bas à droite #}
  L.control.coordinates(
  {
      useLatLngOrder:true,
      centerUserCoordinates:true,
      labelTemplateLat:"D.D Lat {y}",
      labelTemplateLng:"Lng {x}"
  }).addTo(map);
  
  // affichage coordonnÃ©es curseur DMS en bas à droite #}
  L.control.coordinates({
      position:"bottomright",
      useDMS:true,
      centerUserCoordinates:true,
      labelTemplateLat:"DÂ°MM'SS'' Lat {y}",
      labelTemplateLng:"Lng {x}",
      useLatLngOrder:true
  }).addTo(map);

  // RÃ©cupÃ©ration boundingbox aprÃ¨s mouvement carte #}
  map.on('moveend', function(e) {
      nw=map.getBounds().getNorthWest();
      se=map.getBounds().getSouthEast();
  });
  
  map.on('zoomend ', function(e)
  {
      if (map.getZoom() >= 15)
      {
          echelle=(map.getBounds().getEast()-map.getBounds().getWest())*80000/(map.getPixelBounds().max.x-map.getPixelBounds().min.x);
      }
      else
      {
          echelle=1;
      }

  });



// fonction permettant, au moment où l'on clique sur une ligne du tableau contenant les résultats de recherche pour NOMINATIM, de faire apparaitre le marker en y incluant un popup qui apparait lorsqu'on clique sur le marker
	$(document).on('click', '#nominatim-table tr', function() {
      $(this).closest("tr").siblings().removeClass("highlighted");
      $(this).toggleClass("highlighted");
      // récupération des données présentes dans les class de searchResult.html.twig
	    var y = $(this).find('.lat').text();
	    var x = $(this).find('.lng').text();
	    var nom = $(this).find('.nom').text();
      map.setView([y, x],16);
	    L.marker([y, x]).addTo(map).bindPopup("<STRONG>"+nom+"</STRONG></BR>DÂ°D LAT : "+y+" - LONG : "+x+"</BR>DÂ°M.M' LAT : "+ConvertDDToDMM(y)+" - LONG : "+ConvertDDToDMM(x)+"</BR>DÂ°M'S'' LAT : "+ConvertDDToDMS(y)+" - LONG : "+ConvertDDToDMS(x));
	});	



// fonction permettant, au moment où l'on clique sur une ligne du tableau contenant les résultats de géoloc, de faire apparaitre le marker de géoloc en y incluant un popup qui apparait lorsqu'on clique sur le marker
$(document).on('click', '#res_loc tr', function() {
    $(this).closest("tr").siblings().removeClass("highlighted");
    $(this).toggleClass("highlighted");
    // récupération des données présentes dans les class de smsloc.html.twig
    var x = $(this).find('.lng').text();
	var y = $(this).find('.lat').text();
	var tel = $(this).find('.tel').text();
	var alt = $(this).find('.alt').text();
	var heure = $(this).find('.heure').text();
	var com = $(this).find('.com').text();
    var bp = $(this).find('.bp').text();
	if (x) {
    	map.setView([y, x],13);
    	L.marker([y, x],{icon: pulsingIcon}).addTo(map).bindPopup("<STRONG> G&eacuteolocalisation de "+heure+"</STRONG></BR>DÂ°D LAT : "+y+" - LONG : "+x+"</BR>DÂ°M.M' LAT : "+ConvertDDToDMM(y)+" - LONG : "+ConvertDDToDMM(x)+"</BR>DÂ°M'S'' LAT : "+ConvertDDToDMS(y)+" - LONG : "+ConvertDDToDMS(x)+"</br> T&eacutel&eacutephone : "+tel+"</br> Altitude : "+alt+" m</br> Commune : "+com+"</br> Unit&eacute comp&eacutetente : "+bp);
	}
});

		
		
// le double clique affiche les coordonnées
map.on('dblclick', function(e) {
/*   
   L.popup()
				.setLatLng(e.latlng)
				.setContent("lat : "+e.latlng.lat+"</br> lon : "+e.latlng.lng)
				.openOn(map);*/
				
				document.getElementById("locy").value=e.latlng.lng;
				document.getElementById("locx").value=e.latlng.lat;



   	//L.marker([y, x]/*,{icon: pulsingIcon}*/).addTo(map).bindPopup("lat : "+y+"</br> lon : "+x);
			new L.Draw.Circle(map, drawControl.options.Circle).enable();
  
	
			});
 // Set the title to show on the polygon button
       

	   
	   
	   
	   
	   
	   
	   
	   
	   

        var drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);

        // Set the title to show on the polygon button
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

				
            if (type === 'marker') {
                layer.bindPopup('A popup!');
            }

            drawnItems.addLayer(layer);
			console.log(e.layer.getLatLng());
			
			document.getElementById("locx").value=e.layer.getLatLng()["lat"];
			document.getElementById("locy").value=e.layer.getLatLng()["lng"];	
			document.getElementById("rayon").value=e.layer._radius;	

			

		
        });

        map.on('draw:edited', function (e) {
            var layers = e.layers;
            var countOfEditedLayers = 0;
            layers.eachLayer(function(layer) {
                countOfEditedLayers++;
            });
			
			document.getElementById("locx").value=e.layer.getLatLng()["lat"];
			document.getElementById("locy").value=e.layer.getLatLng()["lng"];	
			document.getElementById("rayon").value=e.layer._radius;	
			
            console.log("Edited " + countOfEditedLayers + " layers");
        });

        L.DomUtil.get('changeColor').onclick = function () {
            drawControl.setDrawingOptions({ rectangle: { shapeOptions: { color: '#004a80' } } });
        };
		

		
		
</script>
