function valid(formuser)
{	
	if(formuser.nom.value=="")
	{
		alert("Veuillez renseigner le champs Nom");
		formuser.nom.focus();
		return false;
	}
	
	if(formuser.login.value=="")
	{
		alert("Veuillez renseigner le champs Identifiant");
		formuser.login.focus();
		return false;
	}
	
	if(formuser.mdp1.value != formuser.mdp2.value)
	{
		alert("Les deux mots de passe ne correspondent pas.");
		formuser.mdp1.focus();
		return false;
	}
}

function veriflogin(login)
{
	new Ajax.Request("verifLogin.php",
	{
		asynchronous : true,
		method:"get",
		parameters:"l="+login,
		onSuccess: function(request)
		{ 
			traitementInfos(request.responseText);
		},
		onFailure: function(request)
		{
			Erreur(request.responseText);
		}
	}
	);
	
	function traitementInfos(data)
	{
		if (data != "")
		{
			alert(data);
		}
	}
	
	function Erreur(error)
	{
		$('erreur').innerHTML="Erreur : "+error;
	}
}