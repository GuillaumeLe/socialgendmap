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
  var center_y = 39.5; //USA 

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
      zoom: 9,
      doubleClickZoom: false
  });




function traceLayer(nomlayer,donnees,map)
{
var ligne=0;
var points=[];
	for( ligne=0; ligne<donnees.length ;ligne++)
	{
		points.push( L.marker( [ donnees[ligne]["locx"],donnees[ligne]["locy"] ]).bindPopup( donnees[ligne]["contenu"] ));
	}

nomlayer= L.layerGroup(points);

map.addLayer(nomlayer);

}

donnees=[{locx:40.65 , locy: -105.02,contenu:"test"}];
var twitter_layer=L.layerGroup();
traceLayer(twitter_layer,donnees,map);



  var littleton = L.marker([39.61, -105.02]).bindPopup('This is Littleton, CO.'),
    denver    = L.marker([39.74, -104.99]).bindPopup('<b>This is Denver, CO.</b>'),
    aurora    = L.marker([39.73, -104.8]).bindPopup('This is Aurora, CO.'),
    golden    = L.marker([39.77, -105.23]).bindPopup('This is Golden, CO.');

var cities = L.layerGroup([littleton, denver, aurora,golden]);

map.addLayer(cities);

var delay=5000000; //5 seconds

setTimeout(function() {
map.removeLayer(cities);
  
}, delay);



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
</script>
