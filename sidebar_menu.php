<!-- Définition de la sidebar -->

<!-- SIDEBAR -->
	<div id="sidebar" class="sidebar collapsed">
        <!-- Nav tabs -->
        <ul class="sidebar-tabs" role="tablist">
            <li><a href="#social" role="tab"><i class="fa fa-users"></i></a></li>
            <li><a href="#search" role="tab"><i class="fa fa-search"></i></a></li>
						<li><a href="#result" role="tab"><i class="fa fa-search"></i></a></li>
	    </ul>

        <!-- Tab panes -->
        <div class="sidebar-content active">
            <!--tab HOME-->
			<div class="sidebar-pane" id="social">
                <h1>Réseaux sociaux</h1>
                <h3><input type="checkbox" name="twitter" value="twitter"><i class="fa fa-twitter"></i> Twitter<br></h3>
                <h3><input type="checkbox" name="facebook" value="facebook"><i class="fa fa-facebook"></i> Facebook<br></h3>
                <h3><input type="checkbox" name="instagram" value="instagram"><i class="fa fa-instagram"></i> Instagram<br></h3>

                </br></br>

                <p>Localisation :</br></p>
				<p>Latitude :</br><INPUT type="text" name="locx" id="locx" autofocus>
				</p>
				<p>Longitude :</br><INPUT type="text" name="locy" id="locy" autofocus>
				</p>
				<p>Rayon de recherche :</br>
				<INPUT type="number" name="rayon" id="rayon" autofocus>
				</p>
                <p>Date de début :</br>
				<INPUT type="date" name="date_debut" id="date_debut" autofocus>
                <p>Date de fin :</br>
				<INPUT type="date" name="date_fin" id="date_fin" autofocus>
				</p>
                <p>Filtre texte :</br>
				<INPUT type="TEXT" name="filtre" id="filtre" autofocus>
				</p>
				<INPUT type="submit" value="RECHERCHER" >

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
				</script>

<!-- ===========================================================================================================================================================================================
// Reprise de l'affichage de la page en HTML
//========================================================================================================================================================================================= -->

			</div>
			<?php include("./format.php"); ?>
			<div class="sidebar-pane" id="result">
				<h1>Resultats</h1>
				<script>
				url = "./twitter.php";
				// Send the data using post
				var posting = $.get( url, {pos_lat : "48.8246944", pos_long : "2.274335199999996", time_begin : "2016-04-14", time_end : "2016-04-15", radius :"20" }) ;
				setTimeout( function(){
				//console.log(posting.responseText);
				var JJtweets;
				JJtweets=JSON.parse(posting.responseText);
				JJtweets=twitter2format(JJtweets);

				console.log(JJtweets);

				var carteTwitter=L.markerClusterGroup({
				   spiderfyOnMaxZoom: false,
				    showCoverageOnHover: false,
				    zoomToBoundsOnClick: false});
				traceLayer(carteTwitter,JJtweets,map);
carteTwitter.on('clusterclick',ecritSidePanel(carteTwitter));

			}, 2000);
				</script>

				<div id="results">
				</div>

		  </div>

</div>
	</div>
