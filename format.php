<script>

function twitter2format(raw)
{
	format=[];
	var ligne=0;

	for( ligne=0; ligne<raw.length ;ligne++)
	{

		format['contenu']= raw[ligne]["text"];
		format[ligne]['locx']= raw[ligne]["geo"]; // A CHANGER
		format[ligne]['locy']= raw[ligne]["geo"]; // IDEM

		format[ligne]['url']="https://twitter.com/iagdotme/status/"+raw[ligne]["id"];

		//format['contenu']= "https://twitter.com/intent/user?user_id="+raw[ligne]["user"]["id"];
		format[ligne]['user']= raw[ligne]["user"]["name"];
		format[ligne]['date']= raw[ligne]["created_at"];
		format[ligne]['mail']= "";
		format[ligne]['source']= "Twitter";




	}

		raw=[];
	return format;
	
}



</script>