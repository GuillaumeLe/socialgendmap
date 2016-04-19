<script>

function twitter2format(raw)
{
	raw=raw["statuses"];
	format=[];
	var ligne=0;

	for( i=0; i<raw.length ;i++)
	{

		if(raw[i]["coordinates"] !== undefined && raw[i]["coordinates"] !== null )
		{
		format.push({});

		format[ligne]['contenu']= raw[i]["text"];
		format[ligne]['locx']= raw[i]["coordinates"]["coordinates"][1]; // A CHANGER
		format[ligne]['locy']= raw[i]["coordinates"]["coordinates"][0]; // IDEM

		format[ligne]['url']="https://twitter.com/iagdotme/status/"+raw[i]["id"];

		//format['contenu']= "https://twitter.com/intent/user?user_id="+raw[ligne]["user"]["id"];
		format[ligne]['user']= raw[i]["user"]["name"];
		format[ligne]['date']= raw[i]["created_at"];
		format[ligne]['mail']= "";
		format[ligne]['source']= "Twitter";

		ligne++;
	}



	}

		raw=[];
	return format;

}



</script>
