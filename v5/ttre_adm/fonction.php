<?php
if ( ! function_exists('couper'))
{
    function couper($chaine,$length)
    {
    	if(strlen($chaine)>$length) 
        return substr_replace (substr($chaine,0,$length),' ...',strrpos(substr($chaine,0,$length),' '));
    	return $chaine;
    }
    
}


function couper2($chaine,$length)
{
	if(strlen($chaine)>($length+3)) 
    return substr($chaine,0,$length).' ...';
	return $chaine;
}



function veriflogin($login)
{
	$sql = "SELECT * FROM bre_user WHERE login= '".$my->net($login)."'";
    
	return $my->req_obj($sql);    }

function isEmail($email)
{
	return preg_match('/^[a-z0-9!#$%&\'*+\/=?^`{}|~_-]+[.a-z0-9!#$%&\'*+\/=?^`{}|~_-]*@[a-z0-9]+[._a-z0-9-]*\.[a-z0-9]+$/ui', $email);
}
if ( ! function_exists('suppr_speciaux'))
{


        function suppr_speciaux($nom)
        {
        	$dest = strtr(strtolower($nom),'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ/\'','AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy__');
        	$dest = strtr($dest,' ','_');
        	$dest = strtr($dest,"'","_");
        	return $dest;
        }
}


# Fonctions de gestion des mots de passe
function lire_generation_pass($bdd, $referencePass=null) 
{   
  	$tab_retour = array();
  	$sql = "SELECT * FROM generation_pass";
  	$wa = "WHERE";
  	if(!is_null($referencePass)){$sql .= " $wa reference_pass = '$referencePass' "; $wa = "AND";}			
  	$rs_select = $bdd->req_obj($sql);
  	return($rs_select);        			
}

function ajouter_generation_pass($bdd, $idUser, $passBdd, $referencePass)
{
      $sql = "INSERT INTO generation_pass (id_customer, passwd, reference_pass)
              Values ('$idUser', '$passBdd', '$referencePass')";
      $bdd->req($sql);
      return	$bdd->id();
}

function modifier_mdp($bdd, $idUser, $mdp) 
{   
    $ok=false;
	$sql = $bdd->req("Update client Set pass='$mdp'
		  	where id='$idUser'");            
	/*if ($sql)
	{
    	$ok=true;
    	'$bdd->req(DELETE FROM generation_pass WHERE id_customer="'.$idUser.'"');	        			
	}*/
	return $ok;
}

function modifier_user_boutique($my, $idUser, $civilite, $email, $prenom, $newsletter, $nom, $adresse, $cp, $ville,$pays,$telephone) 
{   
	$sql= 	'UPDATE client SET 
				`civility` = "'.$civilite.'", 
				`email` = "'.$email.'", 
				`lastname` = "'.$nom.'", 
				`newsletter` = "'.$newsletter.'", 
				`firstname` = "'.$prenom.'", 
				`address` = "'.$adresse.'", 
				`postcode` = "'.$cp.'", 
				`city` = "'.$ville.'", 
				`phone` = "'.$telephone.'" 
			WHERE id_customer="'.$idUser.'" ';
        									
	return $my->req($sql);
}

function lire_carnet_adresse($bdd, $idAdresse=null) 
{   
  	$tab_retour = array();
  	$sql = "SELECT * FROM address ";
  	$wa = "WHERE";
  	if(!is_null($idAdresse)){$sql .= " $wa id_address = '$idAdresse' ";$wa = "AND";}			
    if(!is_null($idAdresse)) return $bdd->req_obj($sql);
  	return $bdd->req_obj($sql);        			
}

function lire_carnet_adresse2($bdd, $idUser=null) 
{   
  	$tab_retour = array();
  	$sql = "SELECT * FROM address ";
  	$wa = "WHERE";
  	if(!is_null($idUser)){$sql .= " $wa id_customer = $idUser ";$wa = "AND";}			
  	
  	$sql .= "$wa deleted='0'";
    
  	return $bdd->req_obj($sql);        			
}





function verifier_identification($my, $email, $password)
{
	$sql = "SELECT * FROM client WHERE mail= '".$my->net($email)."' AND pass= '".$my->net($password)."'";
    
	return $my->req_obj($sql);       
}

function lire_produit($my,$id){
    
    $sql='SELECT * FROM produit WHERE id_produit='.$id;
    
    return $my->req_obj($sql);
}

function lire_user($my, $email=null) 
{   
        
  	$sql = "SELECT * FROM client WHERE mail = '". $my->net($email)."' ";
  	return $my->req_obj($sql);     			
}

function lire_user_obj($my, $id=null) 
{   
    
    if (! is_null($id))
    {    
  	    $sql = "SELECT * FROM client WHERE id = '". $my->net($id)."' ";
  	    return $my->req_obj($sql);     			
    }else {
        
        $sql = "SELECT * FROM client ORDER BY nom";
        return $my->req_obj($sql);
    }
}

function ajouter_commande($bdd, $idUser, $date, $totalTTC, $port, $status, $adresseFacturation, $adresseLivraison)
{
  $sql = "INSERT INTO commandes (id_client, date_c,livraison,frais,facturation, total,  status)
                 VALUE ('$idUser', '$date', '$adresseLivraison','$port'  ,'$adresseFacturation','$totalTTC', '$status')";
  if ( $bdd->req($sql))
  return  mysql_insert_id();
  return false;  
}

function ajouter_contenu_commande($bdd, $idCommande, $idProduit,$titre_produit, $pu, $quantite)
{
  $sql = "INSERT INTO commandes_contenu (id_cmd, id_pdt,titre_produit, pu, qtt)
                 VALUES ('$idCommande', '$idProduit', '$titre_produit', '$pu', '$quantite')";
  if ($bdd->req($sql))
  return mysql_insert_id();
  return false;
     
}

function lire_commande_reference($bdd, $id) 
{   
  	$sql = "SELECT * FROM commandes where id='$id'";  			
  	return $bdd->req_obj($sql);        			
}

function lire_commande_contenu($bdd, $id) 
{   
  	 			
  	  	$tab_retour = array();
  	$sql = "SELECT * FROM commandes_contenu where id_cmd='$id'";
  	$rs_select = $bdd->req($sql);
  	$i = 0;
  	while ($o_select = mysql_fetch_object($rs_select))
  	{
  		$tab_retour[$i]["id"] = $o_select->id;
  		$tab_retour[$i]["id_cmd"] = $o_select->id_cmd;
  		$tab_retour[$i]["id_pdt"] = $o_select->id_pdt;
  		$tab_retour[$i]["titre_produits"] = $o_select->titre_produits;
  		$tab_retour[$i]["pu"] = $o_select->pu;
  		$tab_retour[$i]["qtt"] = $o_select->qtt;
  						
  		$i++;
  	}
  	mysql_free_result($rs_select);
  	return($tab_retour); 
  	        			
}

function nb_produits()
{
    $nb=0;
    if(isset($_SESSION['panier']['qte']))
    {
        $size= count($_SESSION['panier']['qte']);
        for ($i=0;$i<$size;$i++)
            $nb += $_SESSION['panier']['qte'][$i];  
    }
    return $nb;
}

function fiche_news($result)
 {
        $words= array();
        $words['fr']=array('Prix','Ajouter au panier','Demande sur mesure','Produits dérivés','Lire la suite','Actualité');
        $words['en']=array('Price','Add to cart','Request on measure','Derived Products','read more','actuality');    
         
        $description='';
        $length=125;
	    $desc=$result->description;
    	if(strlen($result->description)>$length) 
    	    $desc= substr_replace (substr($result->description,0,$length),' ...',strrpos(substr($result->description,0,$length),' '));
     
        $str = "<li>\n";
         $str.= '<h3>'.$words[$_SESSION['lang']][5].'</h3>
                    <dl>
                      <dt class="titre">'.ucfirst($result->titre).'</dt>
                      <dd class="desc">'.$desc.'</dd>';
        if(strlen($result->description)>$length){  
            $str.= '<dd class="suite"><a id="various1" href="#inline1">'.$words[$_SESSION['lang']][4].'</a></dd>'; 
            $description='<div style="display: none;">
        		<div id="inline1" style="width:500px;height:200px;overflow:auto;">
        			'.$result->description.'
        		</div>
        	</div>
                    ';    
        }
                      
         $str.=	  '</dl>';
         $str.= "</li>\n";
        
        return $str.$description;
 }
 
function fiche_produit($result,$link)
 {
         $words= array();
         $words['fr']=array('Prix','Ajouter au panier','Demande sur mesure','Produits dérivés');
         $words['en']=array('Price','Add to cart','Request on measure','Derived Products');
         
         $str = "<li>\n";
        
         $str .='<dl>
                   <dt>'.couper2(ucfirst(html_entity_decode( $result->{'titre_'.$_SESSION['lang']})),30).'</dt>';
         
          $taille=getimagesize('../admin/miniature/'.$result->photo);
  
         $str .='  <dd class="border_img"><a href="../admin/photos/'.$result->photo.'"><img style="margin:'.(floor(120-$taille[1])/2).'px 0px" src="../admin/miniature/'.$result->photo.'" alt="'.$result->{'titre_'.$_SESSION['lang']}.'" /></a></dd>';
         $str .='  <dd class="plus_details_produit">
         			<a href="'.$link.'-'.suppr_speciaux($result->{'titre_'.$_SESSION['lang']}).'-'.$result->id_produit.'.html"><span class="invis">Plus details</span></a>
         		   </dd>
                </dl>';
         
         $str.= "</li>\n";
        return $str;
 }
 
function fiche_produit_detail($result)
 {
         $words= array();
         $words['fr']=array('Prix','Ajouter au panier','Demande sur mesure','Produits dérivés');
         $words['en']=array('Price','Add to cart','Request on measure','Derived Products');
         
         $str = "<div id=\"fiche_produit\">\n";
        
         $str .='<dl id="descpription_fiche">
    			   <dt>'.ucfirst($result->{'titre_'.$_SESSION['lang']}).'</dt>';

         $str .='  <dd class="prix">'.$words[$_SESSION['lang']][0].' : <span>';
         if (! empty($result->prix_promo))
             $str.= number_format($result->prix_promo,2);
         else $str.= number_format($result->prix,2);
         $str .=' &euro;</span></dd>';
         
         $str .='  <dd>'.ucfirst(couper(nl2br($result->{'description_'.$_SESSION['lang']}),650)).'</dd>';
         if ($result->id_rubrique != 3) $class='ajout_panier';
         else $class ='ajout_panier2';
         $str .='  <dd><span class="'.$class.'"><a href="panier.php?mode=add&id='.$result->id_produit.'">'.$words[$_SESSION['lang']][1].'</a></span>';
         if ($result->id_rubrique != 3)
         	   $str .='<span class="produits_derives"><a href="derives-'.suppr_speciaux($result->{'titre_'.$_SESSION['lang']}).'-'.$result->id_produit.'.html">'.$words[$_SESSION['lang']][3].'</a></span>';
         	   $str .='<span class="demande_mesure"><a href="#">'.$words[$_SESSION['lang']][2].'</a></span></dd>';
         $str .='</dl>
   					<p class="img_fiche"><a href="../admin/photos/'.$result->photo.'"><img src="../admin/miniature/'.$result->photo.'" alt="'.$result->{'titre_'.$_SESSION['lang']}.'" /></a></p>';
         $str.= "</div>\n";
        return $str;
 }

function fiche_nouvaute($result,$link){
    
       $words= array();
         $words['fr']=array('Prix','Ajouter au panier','Demande sur mesure','Produits dérivés','plus de détails');
         $words['en']=array('Price','Add to cart','Request on measure','Derived Products','details');

    $str ="<div class=\"panel\">\n";
    $str.='<dl>
                <dt class="img_left"><a href="../admin/photos/'.$result->photo.'" ><img src="../admin/miniature/'.$result->photo.'"  alt="'.$result->{'titre_'.$_SESSION['lang']}.'"/></a></dt>
                <dd>'.couper2(ucfirst($result->{'titre_'.$_SESSION['lang']}),19).'</dd>
                <dd class="prix">'.$words[$_SESSION['lang']][0].' <span>';
            
                if (! empty($result->prix_promo))
                     $str.= number_format($result->prix_promo,2);
                 else $str.= number_format($result->prix,2);
             
                 $str .=' &euro;</span></dd>';
                 $str .='<dd class="plus_details"><a href="'.$link.'-'.suppr_speciaux($result->{'titre_'.$_SESSION['lang']}).'-'.$result->id_produit.'.html"><span class="invis">'.$words[$_SESSION['lang']][4].'</span></a></dd>
              </dl>';
    $str.="</div>\n";
    
    return $str;
}

function lire_commande($bdd, $idCommande=null) 
{   
  	$tab_retour = array();
  	$sql = "SELECT * FROM commandes ";
  	$wa = "WHERE";
  	if(!is_null($idCommande)){$sql .= " $wa id = $idCommande ";$wa = "AND";}			
  	return $bdd->req_obj($sql);
}

function lire_commandes_en_cours($bdd, $idUser) 
{   
  	$sql = "SELECT * FROM `commandes` WHERE id_client= '$idUser' ";
  			
  	
  	return $bdd->req_obj($sql);        			
}

function lire_historique_commandes($bdd, $idUser=null) 
{   
  	$sql = "SELECT * FROM commandes ";
  	$wa = "WHERE";
  	if(!is_null($idUser)){$sql .= " $wa id_client = '$idUser' ";$wa = "AND";}			
  	
  	return $bdd->req_obj($sql);        			
}

function lire_commande_tri2($bdd) 
{   
    //***** status 1 => command en cour de préparation
	$sql = "SELECT * FROM commandes where status =1 order by id DESC";  				
	return $bdd->req_obj($sql);        			
}

function lire_commande_tri($bdd) 
{   
    //****** Status 2 => commande expédiée  
	$sql = "SELECT * FROM commandes where status=2 order by id DESC";  				
	
	return $bdd->req_obj($sql);        			
}

function lire_contenu_commande($bdd, $idCommande=null) 
{   
  	$sql = "SELECT * FROM commandes_contenu ";
  	$wa = "WHERE";
  	if(!is_null($idCommande)){$sql .= " $wa id_cmd = $idCommande ";$wa = "AND";}			
    return $bdd->req_obj($sql);
}

function sqlversfr($date)
{
	$split = explode("-",$date);
	if(count($split)==3)
	{
		$annee = $split[0];
		$mois = $split[1];
		$jour = $split[2];
		return "$jour/$mois/$annee";
	}
	else
	{
		return $date;
	}
}  

function sqlversen($date)
{
	$split = explode("-",$date);
	if(count($split)==3)
	{
		$annee = $split[0];
		$mois = $split[1];
		$jour = $split[2];
		return "$mois/$jour/$annee";
	}
	else
	{
		return $date;
	}
}  


function supprimer_commande($bdd,$idCommande)
{
	$sql = "Delete from commandes where id=$idCommande";
	return $bdd->req($sql);	  
}

function modifier_etat_commande($bdd, $idCommande, $status) 
{   
	$sql = "Update commandes Set status='$status'
		  where id='$idCommande'";            
	$rs_select = $bdd->req($sql);	        			
}

?>