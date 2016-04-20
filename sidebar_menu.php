<!-- Définition de la sidebar -->

<!-- SIDEBAR -->
	<div id="sidebar" class="sidebar collapsed">
        <!-- Nav tabs -->
        <ul class="sidebar-tabs" role="tablist">
            <li><a href="#social" role="tab"><i class="fa fa-users"></i></a></li>
            <li><a href="#search" role="tab"><i class="fa fa-search"></i></a></li>
			<li><a href="#solution" role="tab"><i class="fa fa-twitter"></i></a></li>
	    </ul>

        <!-- Tab panes -->
        <div class="sidebar-content active">
            <!--tab HOME-->
			<div class="sidebar-pane" id="social">
				<h1>Sélection des couches</h1>
				<h3><input id="cb-twitter" onclick='couchetwitter(map);' type="checkbox" name="twitter" value="twitter"><i class="fa fa-twitter"></i> Twitter<br></h3>
				<h3><input type="checkbox" name="facebook" value="facebook"><i class="fa fa-facebook"></i> Facebook<br></h3>
				<h3><input type="checkbox" name="instagram" value="instagram"><i class="fa fa-instagram"></i> Instagram<br></h3>
				<h3><input type="checkbox" name="gendloc" value="gendloc"><i class="fa fa-globe"></i> Gendloc<br></h3>
				<h3><input type="checkbox" name="gendarmeries" value="gendarmeries"><i class="fa fa-bell"></i> Gendarmeries<br></h3>

                

                <h1>Localisation</h1>
				<p>Latitude :</br><INPUT type="text" name="locx" id="locx" autofocus value="48.821332549646634">
				</p>
				<p>Longitude :</br><INPUT type="text" name="locy" id="locy" autofocus value="2.5323486328125">
				</p>
				<p>Rayon de recherche : (km)</br>
				<INPUT type="number" name="rayon" id="rayon" autofocus value="73696.8450589714">
				</p>
                <p>Date de début :</br>
				<INPUT type="date" name="date_debut" id="date_debut" autofocus value="2016-04-18">
                <p>Date de fin :</br>
				<INPUT type="date" name="date_fin" id="date_fin" autofocus value="2016-04-19">
				</p>
                <p>Filtre texte :</br>
				<INPUT type="TEXT" name="filtre" id="filtre" autofocus>
				</p>
				<INPUT type="submit" value="RECHERCHER" onclick="couchetwitter(map);">


			</div>

			<!--tab RECHERCHE-->
			<div class="sidebar-pane" id="search">
				<h1>Recherche</h1>
				<h3>Attention vue écran</h3>
				<FORM>
				<INPUT type="TEXT" name="c" id="c" autofocus>
				<INPUT type="submit" value="RECHERCHER" >
				</br></br>
				<div id="res_topo"></div>
				<div id="res_nominatim"></div>
				<div id="res_BAN"></div>
				<div id="res_com"></div>
				</FORM>
				Recherche floue IGN, base adresse nationale et nominatim

<!-- ===========================================================================================================================================================================================
// SCRIPT dans l'onglet RECHERCHE qui affiche les résultats d'une recherche par catégorie (nominatim, BAN, bdnyme, IGN)
//========================================================================================================================================================================================= -->

				<script>

				//fonction requête rech
				$( "#search" ).submit(function( event ) {
					  // Stop form from submitting normally
				event.preventDefault();
				term = encodeURIComponent($("#search").find( "input[name='c']" ).val()),
				term2 = $("#search").find( "input[name='c']" ).val(),
				url = "./services/nominatim.php";
				var posting = $.get( url, { c: term , pt1_x: nw.lng, pt1_y: nw.lat, pt2_x: se.lng, pt2_y: se.lat}) ;
				posting.done(function( data ) {
					var content = $( data );
					$( "#res_nominatim" ).empty().append( content );
					});
				url = "./services/BAN.php";
				var posting = $.get( url, { c: term , pt_x: center_x, pt_y: center_y}) ;
				posting.done(function( data ) {
					var content = $( data );
					$( "#res_BAN" ).empty().append( content );
					});
				url = "./services/bdnyme.php";
				// Send the data using post
				var posting = $.get( url, { c: term2 , pt1_x: nw.lng, pt1_y: nw.lat, pt2_x: se.lng, pt2_y: se.lat}) ;
				posting.done(function( data ) {
					var content = $( data );
					$( "#res_topo" ).empty().append( content );
					});
				url = "./services/igncom.php";
				// Send the data using post
				var posting = $.get( url, { d: term2 , pt1_x: nw.lng, pt1_y: nw.lat, pt2_x: se.lng, pt2_y: se.lat}) ;
				posting.done(function( data ) {
					var content = $( data );
					$( "#res_com" ).empty().append( content );
					});

				});

	//handler click sur résultat BAN
	$(document).on('click', '#ban-table tr', function() {
    $(this).closest("tr").siblings().removeClass("highlighted");
    $(this).toggleClass("highlighted");
	var x = $(this).find('td').first().text();
	var y = $(this).find('td').last().text();
	var nom = $(this).find('.nom').text();
    map.setView([y, x],16);
	L.marker([y, x]).addTo(map).bindPopup("<STRONG>"+nom+"</STRONG></BR>DÂ°D LAT : "+y+" - LONG : "+x+"</BR>DÂ°M.M' LAT : "+ConvertDDToDMM(y)+" - LONG : "+ConvertDDToDMM(x)+"</BR>DÂ°M'S'' LAT : "+ConvertDDToDMS(y)+" - LONG : "+ConvertDDToDMS(x));
	document.getElementById("locy").value=y;
	document.getElementById("locx").value=x;
	//document.location.replace("./gendloc.php#social");
	});

    //handler click sur résultat nominatim
	$(document).on('click', '#nominatim-table tr', function() {
    $(this).closest("tr").siblings().removeClass("highlighted");
    $(this).toggleClass("highlighted");
	var y = $(this).find('td').first().text();
	var x = $(this).find('td').last().text();
	var nom = $(this).find('.nom').text();
    map.setView([y, x],16);
	L.marker([y, x]).addTo(map).bindPopup("<STRONG>"+nom+"</STRONG></BR>D°D LAT : "+y+" - LONG : "+x+"</BR>D°M.M' LAT : "+ConvertDDToDMM(y)+" - LONG : "+ConvertDDToDMM(x)+"</BR>D°M'S'' LAT : "+ConvertDDToDMS(y)+" - LONG : "+ConvertDDToDMS(x));
	document.getElementById("locy").value=y;
	document.getElementById("locx").value=x;
	});

	//handler click sur résultat topo
	$(document).on('click', '#res_topo tr', function() {
    $(this).closest("tr").siblings().removeClass("highlighted");
    $(this).toggleClass("highlighted");
	var x = $(this).find('td').first().text();
	var y = $(this).find('td').last().text();
	var nom = $(this).find('.nom').text();
    map.setView([y, x],16);
	L.marker([y, x]).addTo(map).bindPopup("<STRONG>"+nom+"</STRONG></BR>D°D LAT : "+y+" - LONG : "+x+"</BR>D°M.M' LAT : "+ConvertDDToDMM(y)+" - LONG : "+ConvertDDToDMM(x)+"</BR>D°M'S'' LAT : "+ConvertDDToDMS(y)+" - LONG : "+ConvertDDToDMS(x));
	document.getElementById("locy").value=y;
	document.getElementById("locx").value=x;
	});

				</script>

<!-- ===========================================================================================================================================================================================
// Reprise de l'affichage de la page en HTML
//========================================================================================================================================================================================= -->

			</div>

			<?php include("./format.php"); ?>
			<div class="sidebar-pane" id="solution">
				<h1>Resultats</h1>
				<script>

				function couchetwitter(map)
				{
					console.log(document.getElementById("cb-twitter").checked)
					
					if(carteTwitter !== null)
					{
							map.removeLayer(carteTwitter);
					}

				if(document.getElementById("cb-twitter").checked)
				{

					var locx =document.getElementById("locx").value;
					var locy =document.getElementById("locy").value;
					var rayon =document.getElementById("rayon").value;
					var date_debut =document.getElementById("date_debut").value;
					var date_fin = document.getElementById("date_fin").value;
					var filtre = document.getElementById("filtre").value;



					url = "./twitter.php";
					// Send the data using post
					var posting = $.get( url, {pos_lat : locx, pos_long : locy, time_begin : date_debut, time_end : date_fin, radius : rayon, filtre: filtre }) ;

					console.log(posting);

					//console.log(posting.responseText);
					setTimeout( function(){var JJtweets;
					JJtweets=JSON.parse(posting.responseText);

					JJtweets=twitter2format(JJtweets);



					carteTwitter=L.markerClusterGroup({
					   spiderfyOnMaxZoom: false,
					    showCoverageOnHover: false,
					    zoomToBoundsOnClick: false});

					traceLayer(carteTwitter,JJtweets,map);

				},2000);


				}
			}

				</script>

				<div id="results">
				</div>


		  </div>

</div>
	</div>
