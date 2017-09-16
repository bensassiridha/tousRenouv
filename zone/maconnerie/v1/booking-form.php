 <?php

        if(isset($_POST['submit'])){
                $prenom = (isset($_POST['prenom']) ? $_POST['prenom'] : null);
                $nom = (isset($_POST['nom']) ? $_POST['nom'] : null);
                $civilite = (isset($_POST['civilite']) ? $_POST['civilite'] : null);
                $email = (isset($_POST['email']) ? $_POST['email'] : null);
                $adress = (isset($_POST['adress']) ? $_POST['adress'] : null);
                $phone = (isset($_POST['phone']) ? $_POST['phone'] : null);
                $telephone = (isset($_POST['telephone']) ? $_POST['telephone'] : null);
                $cp = (isset($_POST['ip_cp']) ? $_POST['ip_cp'] : null);
                $ville = (isset($_POST['ville']) ? $_POST['ville'] : null);
                $disponibility = (isset($_POST['disponibility']) ? $_POST['disponibility'] : null);
                $until = (isset($_POST['until']) ? $_POST['until'] : null);
                $num_devis = (isset($_POST['num_devis']) ? $_POST['num_devis'] : null);
                $content = (isset($_POST['content']) ? $_POST['content'] : null);
                $spec = (isset($_POST['spec']) ? $_POST['spec'] : null);
                $batiment = (isset($_POST['batiment']) ? $_POST['batiment'] : null);
                $delay = (isset($_POST['delay']) ? $_POST['delay'] : null);
                $trav = (isset($_POST['trav']) ? $_POST['trav'] : null);


                $prenom = mysqli_real_escape_string($conn, $_POST['prenom']);
                $nom = mysqli_real_escape_string($conn, $_POST['nom']);
                $civilite = mysqli_real_escape_string($conn, $_POST['civilite']);
                $email = mysqli_real_escape_string($conn, $_POST['email']);
                $adress = mysqli_real_escape_string($conn, $_POST['adress']);
                $phone = mysqli_real_escape_string($conn, $_POST['phone']);
                $telephone = mysqli_real_escape_string($conn, $_POST['telephone']);
                $code_postal = mysqli_real_escape_string($conn, $_POST['code_postal']);
                $ville = mysqli_real_escape_string($conn, $_POST['ville']);
                $disponibility = mysqli_real_escape_string($conn, $_POST['disponibility']);
                $until = mysqli_real_escape_string($conn, $_POST['until']);
                $num_devis = mysqli_real_escape_string($conn, $_POST['num_devis']);
                $content = mysqli_real_escape_string($conn, $_POST['content']);
                $spec = mysqli_real_escape_string($conn, $_POST['spec']);
                $batiment = mysqli_real_escape_string($conn, $_POST['batiment']);
                $delay = mysqli_real_escape_string($conn, $_POST['delay']);
                $trav = mysqli_real_escape_string($conn, $_POST['trav']); 
                $cp = mysqli_real_escape_string($conn, $_POST['ip_cp']);

                $sql = "INSERT INTO maconnerie_devis (civilite, nom, prenom, email, adresse, code_postal, ville, content, spec, batiment,
                    travaux, disponibility, until, period, nombre, phone, telephone, categorie) VALUES ('$civilite', '$nom', '$prenom', '$email',
                    '$adress', '$cp', '$ville', '$content', '$spec', '$batiment', '$trav', '$disponibility', '$until', '$delay',
                    '$num_devis', '$phone', '$telephone', '$title')";

                if(mysqli_query($conn, $sql)){
                    echo "";
                } else {
                    echo "Error:" . $sql . "<br/>" .mysqli_error($conn);
                }

                mysqli_close($conn);

                if($_SERVER['REQUEST_METHOD'] == "POST"){
                        $to = "devis@tousrenov.fr";
                        $subject = "Demande de devis - " . $title;

                        $message = "
                        <html>
                        <head>
                        <title>Demande de devis - " .$title."</title>
                        </head>
                        <body>
                        <p>
                            <b>Nom :</b><span>".$nom."</span>
                        </p>
                        <p>
                            <b>Prénom :</b><span>".$prenom."</span>
                        </p>
                        <p>
                            <b>Email :</b><span>".$email."</span>
                        </p>
                        <p>
                            <b>Adresse :</b><span>".$adress."</span>
                        </p>
                        <p>
                            <b>Ville :</b><span>".$ville."</span>
                        </p>
                        <p>
                            <b>Vous êtes :</b><span>".$spec."</span>
                        </p>
                        <p>
                            <b>Téléphone :</b><span>".$phone."</span>
                        </p>
                        <p>
                            <b>Nombre de devis :</b><span>".$num_devis."</span>
                        </p>
                        <p>
                            <b>Type de bâtiment :</b><span>".$batiment."</span>
                        </p>
                        <p>
                            <b>Type de travaux :</b><span>".$trav."</span>
                        </p>
                        <p>
                            <b>Disponibilté :</b><span>".$disponibility."</span>
                        </p>
                        <p>
                            <b>Jusqu'a :</b><span>".$until."</span>
                        </p>
                        <p>
                            <b>Delais de realisation :</b><span>".$delay."</span>
                        </p>
                        <p>
                            <b>Type de travaux :</b><span>".$trav."</span>
                        </p>                        
                        
                        <p>
                            <b>Message</b>
                            <p>".$content."</p>
                        </p>
                        </body>
                        </html>
                        ";

                        // Always set content-type when sending HTML email
                        $headers = "MIME-Version: 1.0" . "\r\n";
                        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                        // More headers
                        $headers .= 'From: <'.$email.'>' . "\r\n";
                        $headers .= 'Cc: youness.themaster@gmail.com';

                        $mail_sent = @mail($to,$subject,$message,$headers);
                    
                    echo $mail_sent ? "Mail sent" : "Mail failed";
                }
            };

?>     

<form role="form" action="" method="post" class="registration-form">
                        
<fieldset>
        <div class="form-top">
            <div class="form-top-left">
                <h3>Mon Projet</h3>
                <p>Complétez le formulaire pour obtenir vos devis gratuits</p>
            </div>
        </div>
        <div class="form-bottom">

            <div class="">
                <label class="sr-only" for="form-about-yourself">About yourself</label>
                <textarea name="content" placeholder="Décriver votre projet avec le plus de détails possible afin d'obtenir des devis précis..." 
                            class="form-about-yourself form-control" id="content"></textarea>
            </div>  



            <div class="col-md-4">
	            <div class="types">
	                <label class="label-name title-type" form="form-civilitez">Type de bâtiment</label>
	                    <label class="radio-type" ><input type="radio" value="Maison" name="batiment" id="batiment_0"/><span>Maison</span></label>
	                    <label class="radio-type" ><input type="radio" value="Appartement" name="batiment" id="batiment_1"/><span>Appartement</span></label>
	                    <label class="radio-type" ><input type="radio" value="Locaux Professionnels" name="batiment" id="batiment_2"/><span>Locaux Professionnels</span></label>

	            </div>            	
            </div>

            <div class="col-md-4">
	            <div class="types">
	                    <label class="label-name title-type" form="form-civilitez">Type de travaux</label>
	                    <label class="radio-type" ><input type="radio" value="Rénovation" name="trav" id="trav_0"/><span>Rénovation</span></label>
	                    <label class="radio-type" ><input type="radio" value="Neuf" name="trav" id="trav_1"/><span>Neuf</span></label>
	                    <label class="radio-type" ><input type="radio" value="Extension" name="trav" id="trav_2"/><span>Extension</span></label>
	                    <label class="radio-type" ><input type="radio" value="Autre" name="trav" id="trav_3"/><span>Autre</span></label>                                            
	            </div>             	
            </div>

            <div class="col-md-4">
            		
	           	<div class="types">
	                <label class="label-name title-type" form="form-spec">Vous êtes</label>
	                	

	                    <label class="radio-type" for="spec_0" ><input type="radio" value="Locataire" name="spec" id="spec_0"/><span>Locataire</span></label>
	                    <label class="radio-type" for="spec_1" ><input type="radio" value="Locataire" name="spec" id="spec_1"/><span>Proprietaire</span></label>
	                    <label class="radio-type" for="spec_2"><input type="radio" value="Archtecte" name="spec" id="spec_2"/><span>Archtecte</span></label>
	                    <label class="radio-type" for="spec_3" ><input type="radio" value="Syndicat" name="spec" id="spec_3"/><span>Syndicat</span></label>
	                    <label class="radio-type" for="spec_4"><input type="radio" value="" name="spec" id="spec_4"/><span>Autre (Precisez)</span></label>
	               <div class="sim-micro-desktop content">
            <input type="text" name="spec" id="precisez" placeholder="Percisez..." class="percisez form-control">
                    </div>
                    

	            </div>
            </div>

            <div class="col-md-12">
				<div class="form-group">
	                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
	                <input type="text" class="some_class calndr" value="" id="disponibility" name="disponibility" placeholder="Votre Disponibilte"/>

	                 <div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
	                <input type="text" class="some_class until" value="" id="until" name="until" placeholder="Jusqu'a"/>
	            </div>


	            <div class="form-group">
	                <div class="input-group-addon"><i class="fa fa-hourglass-half"></i></div>
	                <select name="delay" class="delay">
	                <option disabled="" selected="">Delais de realisation</option>
	                    <option value="immediat">Immediat</option>
	                    <option value="Dans deux à trois mois">Dans deux a trois mois</option>
	                    <option value="Dans trois à six mois">Dans trois a six mois</option>
	                    <option value="Dans plus que 06 mois">Dans plus que 06 mois</option>
	                </select>

	                <label class="sr-only" for="num_devis">Nombre de devis</label>
	                <div class="input-group-addon"><i class="fa fa-file-pdf-o"></i></div>
	                <select name="num_devis" class="select-num-devis">
	                    <option selected disabled>Nombre de devis</option>
	                    <option value="1">1</option>
	                    <option value="2">2</option>
	                    <option value="3">3</option>
	                    <option value="4">4</option>
	                    <option value="5">5</option>
	                    <option value="6">6</option>
	                    <option value="7">7</option>
	                    <option value="8">8</option>
	                    <option value="9">9</option>
	                    <option value="10">10</option>
	                </select>
	            </div>
	            
	            <div class="">
	                <a class="btn btn-next">Suivant <i class="fa fa-angle-right"></i></a>
	            </div>            	
            </div>
        </div>
    </fieldset>
    
     
    
    <fieldset>
        <div class="form-top">
            <div class="form-top-left">
                <h3>Mes coordonnées</h3>
                <p>Compléter vos information personnelles</p>
            </div>
        </div>
        <div class="form-bottom">
            <div class="form-group">
                <label class="label-name" form="form-civilitez">Civilitez :</label>
                <label><input type="radio" value="M." name="civilite" id="civilite_0"/><span>M.</span></label>
                <label><input type="radio" value="Mme." name="civilite" id="civilite_1"/><span>Mme.</span></label>
                <label><input type="radio" value="Mlle." name="civilite" id="civilite_1"/><span>Mlle.</span></label>
            </div>
            <div class="form-group">
                <label class="sr-only" for="form-first-name">Prénom</label>
                <div class="input-group-addon"><i class="fa fa-user"></i></div>
                <input type="text" name="prenom" placeholder="Prénom..." class="form-first-name form-control" id="prenom" required>

                <label class="sr-only" for="form-last-name">Nom</label>
                <div class="input-group-addon"><i class="fa fa-user"></i></div>
                <input type="text" name="nom" placeholder="Nom..." class="form-last-name form-control" id="nom" required>
            </div>

            <div class="form-group">
                <label class="sr-only" for="form-email">Email</label>
                <div class="input-group-addon"><i class="fa fa-envelope"></i></div>
                <input type="email" name="email" placeholder="Email..." class="form-email form-control" id="email" required>
            </div>
            <div class="form-group">
                <label class="sr-only" for="form-phone">Portable</label>
                <div class="input-group-addon"><i class="fa fa-mobile"></i></div>
                <input type="tel" name="phone" placeholder="Portable..." class="form-phone form-control" id="phone" required>

                <label class="sr-only" for="form-phone">Téléphone</label>
                <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                <input type="tel" name="telephone" placeholder="Téléphone..." class="form-tel form-control" id="telephone" required>
            </div>                                      
            <div class="form-group">
                <label class="sr-only" for="form-phone">Adresse</label>
                <div class="input-group-addon"><i class="fa fa-home"></i></div>
                <input type="text" name="adress" placeholder="Adresse..." class="form-street form-control" id="adress" required>
            </div>  
            <div class="form-group">
                <label class="sr-only" for="ip_cp">Code Postal</label>
                <div class="input-group-addon"><i class="fa fa-map-marker"></i></div>
                <input type="code_postal" id="ip_cp" name="ip_cp" placeholder="Code postal du chantier..." class="ip_cp form-code-postal form-control" required>

                 <label class="sr-only" form="form-ville">Ville</label>
                <div class="input-group-addon"><i class="fa fa-map-marker"></i></div>                                               
                <select name="ville" >
                </select>
            </div>                                           

            <div class="">
            <button type="button" class="btn btn-previous"><i class="fa fa-angle-left"></i> Retour</button>
            <button name="submit" type="submit" class="btn valide">Faire ma demande <i class="fa fa-paper-plane"></i></button>
            </div>
        </div>
    </fieldset>


</form>
                            
       