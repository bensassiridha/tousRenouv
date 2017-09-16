function changer_photo(lienPhoto)
{
	$('.image').empty();
	$('.image').append('<img src="admin/'+lienPhoto+'" alt="" />');	
}

function verifier_compte(formName)
{		
	var zoneAffichage = document.getElementById('text_erreur');	
	
	if(formName.nom.value=='')
	{
		zoneAffichage.innerHTML = 'Vous devez obligatoirement renseigner votre nom.';
		formName.nom.focus();
		return false;
	}
	
	if(formName.prenom.value=='')
	{
		zoneAffichage.innerHTML = 'Vous devez obligatoirement renseigner votre prenom.';
		formName.prenom.focus();
		return false;
	}
	
	if(formName.email.value=='')
	{
		zoneAffichage.innerHTML = 'Vous devez obligatoirement renseigner votre adresse mail.';
		formName.email.focus();
		return false;	
	}
	else
	{
		var valeurEmail = formName.email.value;
		var verifMail = /^[a-zA-Z0-9_-]+.+[a-zA-Z0-9_-]+@[a-zA-Z0-9-]{2,}[.][a-zA-Z]{2,3}$/
		if (verifMail.exec(valeurEmail) == null)
		{
			zoneAffichage.innerHTML = 'Vous devez obligatoirement renseigner une adresse mail valide.';
			formName.email.focus();
			return false;
		}
	}
	
	if(formName.adresse.value=='')
	{
		zoneAffichage.innerHTML = 'Vous devez obligatoirement renseigner votre adresse.';
		formName.adresse.focus();
		return false;
	}
	
	if(formName.codePostal.value=='')
	{

		zoneAffichage.innerHTML = 'Vous devez obligatoirement renseigner votre code postal.';
		formName.codePostal.focus();
		return false;
	}
	else
	{
		var valeurPostal = formName.codePostal.value;
		if(isNaN(valeurPostal))
		{
			zoneAffichage.innerHTML = 'Un code postal doit etre composé de chiffres uniquement.';
			formName.codePostal.value='';
			formName.codePostal.focus();
			return false;	
		}
	}
	
	if(formName.ville.value=='')
	{
		zoneAffichage.innerHTML = 'Vous devez obligatoirement renseigner votre ville.';
		formName.ville.focus();
		return false;
	}
	
	if(formName.password.value=='')
	{
		zoneAffichage.innerHTML = 'Vous devez obligatoirement renseigner votre mots de passe.';
		formName.password.focus();
		return false;
	}
	
	if(formName.checkPassword.value=='')
	{
		zoneAffichage.innerHTML = 'Vous devez obligatoirement valider votre mots de passe.';
		formName.checkPassword.focus();
		return false;
	}
	
	if(formName.password.value!=formName.checkPassword.value)
	{
		zoneAffichage.innerHTML = 'Erreur lors de la confirmation du mots de passe.';		
		formName.checkPassword.value = '';
		formName.checkPassword.focus();
		return false;
	}
}

function verifier_adresse(formName)
{		
	var zoneAffichage = document.getElementById('text_erreur');	
	
	if(formName.nom.value=='')
	{
		zoneAffichage.innerHTML = 'Vous devez obligatoirement renseigner votre nom.';
		formName.nom.focus();
		return false;
	}
	
	if(formName.prenom.value=='')
	{
		zoneAffichage.innerHTML = 'Vous devez obligatoirement renseigner votre prenom.';
		formName.prenom.focus();
		return false;
	}	
	
	if(formName.adresse.value=='')
	{
		zoneAffichage.innerHTML = 'Vous devez obligatoirement renseigner votre adresse.';
		formName.adresse.focus();
		return false;
	}
	
	if(formName.codePostal.value=='')
	{

		zoneAffichage.innerHTML = 'Vous devez obligatoirement renseigner votre code postal.';
		formName.codePostal.focus();
		return false;
	}
	else
	{
		var valeurPostal = formName.codePostal.value;
		if(isNaN(valeurPostal))
		{
			zoneAffichage.innerHTML = 'Un code postal doit etre composé de chiffres uniquement.';
			formName.codePostal.value='';
			formName.codePostal.focus();
			return false;	
		}
	}
	
	if(formName.ville.value=='')
	{
		zoneAffichage.innerHTML = 'Vous devez obligatoirement renseigner votre ville.';
		formName.ville.focus();
		return false;
	}
}

function verifier_new_mdp(formName)
{		
	var zoneAffichage = document.getElementById('text_erreur');	
	
	if(formName.oldPassword.value=='')
	{
		zoneAffichage.innerHTML = 'Vous devez obligatoirement renseigner votre ancien mot de passe.';
		formName.oldPassword.focus();
		return false;
	}
	
	if(formName.pwd.value=='')
	{
		zoneAffichage.innerHTML = 'Vous devez obligatoirement renseigner votre nouveau mot de passe.';
		formName.pwd.focus();
		return false;
	}
	
	if(formName.pwd.value!=formName.checkPwd.value)
	{
		zoneAffichage.innerHTML = 'Vous devez obligatoirement saisir votre mot de passe et le confirmer.';
		formName.pwd.value='';
		formName.checkPwd.value='';
		formName.pwd.focus();
		return false;
	}
}

function envoyer_mail(formName)
{		
	var zoneAffichage = document.getElementById('text_erreur');
	
	if(formName.emailEmetteur.value=='')
	{
		zoneAffichage.innerHTML = 'Vous devez obligatoirement renseigner votre adresse mail.';
		formName.emailEmetteur.focus();
		return false;	
	}
	else
	{
		var valeurEmail = formName.emailEmetteur.value;
		var verifMail = /^[a-zA-Z0-9_-]+.+[a-zA-Z0-9_-]+@[a-zA-Z0-9-]{2,}[.][a-zA-Z]{2,3}$/
		if (verifMail.exec(valeurEmail) == null)
		{
			zoneAffichage.innerHTML = 'Vous devez obligatoirement renseigner une adresse mail valide.';
			formName.emailEmetteur.focus();
			return false;
		}
	}
	
	if(formName.emailDestinataire.value=='')
	{
		zoneAffichage.innerHTML = 'Vous devez obligatoirement renseigner l\'adresse mail de votre ami.';
		formName.emailDestinataire.focus();
		return false;	
	}
	else
	{
		var valeurEmail = formName.emailDestinataire.value;
		var verifMail = /^[a-zA-Z0-9_-]+.+[a-zA-Z0-9_-]+@[a-zA-Z0-9-]{2,}[.][a-zA-Z]{2,3}$/
		if (verifMail.exec(valeurEmail) == null)
		{
			zoneAffichage.innerHTML = 'Vous devez obligatoirement renseigner une adresse mail valide.';
			formName.emailDestinataire.focus();
			return false;
		}
	}
}