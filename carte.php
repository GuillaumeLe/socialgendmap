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
  var center_y = 48.7110092;

  var center_z = 12; // d�finition du zoom

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
// place chaque marker
var ligne=0;
var points=[];
	for( ligne=0; ligne<donnees.length ;ligne++)
	{
		nomlayer.addLayer( L.marker( [ donnees[ligne]["locx"],donnees[ligne]["locy"] ]).bindPopup( dessinepopup(donnees[ligne])));
	}


// écrit l'ensemble des markers dans le side_panel
afficheTexteLayer(donnees);

map.addLayer(nomlayer);

// handler pour afficher le texte quand on clique sur les clusters
nomlayer.on('clusterclick', function (e) {ecritSidePanel(e);});




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

function afficheTexteLayer(donnees)
{
	var contenu="";
	for(ligne=0;ligne<donnees.length;ligne++)
				{
					contenu+=dessinepopup(donnees[ligne]);
				}

			document.getElementById("results").innerHTML =contenu;

}




donnees=[{locx:40.65 , locy: 2,contenu:"test",date:"aujourd'hui"},
			{locx:40.65 , locy: 2.5,contenu:"test",date:"aujourd'hui"},
			{locx:41.65 , locy: 2,contenu:"test",date:"aujourd'hui"},
			{locx:41.65 , locy: 2.5,contenu:"test",date:"aujourd'hui"},


];
var cartebidon=L.markerClusterGroup({
   spiderfyOnMaxZoom: false,
    showCoverageOnHover: false,
    zoomToBoundsOnClick: false});


traceLayer(cartebidon,donnees,map);

L.circle([40.65, -104.02], 300000).addTo(map);


function contenuCluster(e)
{
	contenu="";
	var ligne;

	console.log(e);



	for (ligne=0;ligne<e._childClusters.length;ligne++)
	{

		contenu+=contenuCluster(e._childClusters[ligne]);

	}

	for(ligne=0;ligne<e._markers.length;ligne++)
	{
		contenu+=e._markers[ligne]._popup._content+"<br/><br/>";
	}



		return contenu;

}

function ecritSidePanel(carte)
{
  //twitter_layer.bindPopup("<b>Hello world!</b><br>I am a popup.").openPopup();
  //alert('cluster ' + a.layer.getAllChildMarkers().length);


    // ATTENTION AU ZERO, c'est un tavbleau a balayer

    var contenu="<b>Nombre elements: "+ carte.layer._childCount+"</b><br/><br/>";
    contenu+=contenuCluster(carte.layer);


  document.getElementById("results").innerHTML =contenu;

  /*L.popup()
    .setLatLng(e.latlng)
    .setContent(contenu)
    .openOn(map);*/

}




//map.removeLayer(cities);




// ajout de la couche IGN SCAN #}
//map.addLayer(SCAN);
 map.addLayer(osmfr);



  // récupération de la boundingbox #}
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
          "Séries SCAN" : SCAN,
          "Séries EXPRESS": SCANEXPRESS,
          "Série Orthophoto": ORTHO
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


  // affichage �chelle en bas � gauche #}
  L.control.scale({'position':'bottomleft','metric':true,'imperial':false }).addTo(map);

  // affichage coordonnées curseur DD en bas � droite #}
  L.control.coordinates(
  {
      useLatLngOrder:true,
      centerUserCoordinates:true,
      labelTemplateLat:"D.D Lat {y}",
      labelTemplateLng:"Lng {x}"
  }).addTo(map);

  // affichage coordonnées curseur DMS en bas � droite #}
  L.control.coordinates({
      position:"bottomright",
      useDMS:true,
      centerUserCoordinates:true,
      labelTemplateLat:"D°MM'SS'' Lat {y}",
      labelTemplateLng:"Lng {x}",
      useLatLngOrder:true
  }).addTo(map);

  // Récupération boundingbox après mouvement carte #}
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


/*
// fonction permettant, au moment o� l'on clique sur une ligne du tableau contenant les r�sultats de recherche pour NOMINATIM, de faire apparaitre le marker en y incluant un popup qui apparait lorsqu'on clique sur le marker
	$(document).on('click', '#nominatim-table tr', function() {
      $(this).closest("tr").siblings().removeClass("highlighted");
      $(this).toggleClass("highlighted");
      // r�cup�ration des donn�es pr�sentes dans les class de searchResult.html.twig
	    var y = $(this).find('.lat').text();
	    var x = $(this).find('.lng').text();
	    var nom = $(this).find('.nom').text();
      map.setView([y, x],16);
	    L.marker([y, x]).addTo(map).bindPopup("<STRONG>"+nom+"</STRONG></BR>D°D LAT : "+y+" - LONG : "+x+"</BR>D°M.M' LAT : "+ConvertDDToDMM(y)+" - LONG : "+ConvertDDToDMM(x)+"</BR>D°M'S'' LAT : "+ConvertDDToDMS(y)+" - LONG : "+ConvertDDToDMS(x));
	});



// fonction permettant, au moment o� l'on clique sur une ligne du tableau contenant les r�sultats de g�oloc, de faire apparaitre le marker de g�oloc en y incluant un popup qui apparait lorsqu'on clique sur le marker
$(document).on('click', '#res_loc tr', function() {
    $(this).closest("tr").siblings().removeClass("highlighted");
    $(this).toggleClass("highlighted");
    // r�cup�ration des donn�es pr�sentes dans les class de smsloc.html.twig
    var x = $(this).find('.lng').text();
	var y = $(this).find('.lat').text();
	var tel = $(this).find('.tel').text();
	var alt = $(this).find('.alt').text();
	var heure = $(this).find('.heure').text();
	var com = $(this).find('.com').text();
    var bp = $(this).find('.bp').text();
	if (x) {
    	map.setView([y, x],13);
    	L.marker([y, x],{icon: pulsingIcon}).addTo(map).bindPopup("<STRONG> G&eacuteolocalisation de "+heure+"</STRONG></BR>D°D LAT : "+y+" - LONG : "+x+"</BR>D°M.M' LAT : "+ConvertDDToDMM(y)+" - LONG : "+ConvertDDToDMM(x)+"</BR>D°M'S'' LAT : "+ConvertDDToDMS(y)+" - LONG : "+ConvertDDToDMS(x)+"</br> T&eacutel&eacutephone : "+tel+"</br> Altitude : "+alt+" m</br> Commune : "+com+"</br> Unit&eacute comp&eacutetente : "+bp);
	}
});

*/



// le double clique affiche les coordonn�es
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
        L.drawLocal.draw.toolbar.buttons.polygon = 'Dessine un cercle!';

        var drawControl = new L.Control.Draw({
            position: 'topright',
            draw: {
              rectangle: false,
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
			document.getElementById("rayon").value=e.layer.getRadius();




        });

        map.on('draw:edited', function (e) {

			console.log(e);
			document.getElementById("locx").value=e.layers._layers[80].getLatLng()["lat"];
			document.getElementById("locy").value=e.layers._layers[80].getLatLng()["lng"];
			document.getElementById("rayon").value=e.layers._layers[80].getRadius();


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
        //

        var carteTwitter;
			// couchetwitter(carteTwitter,map);


</script>
