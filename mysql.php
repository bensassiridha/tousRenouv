<?php

ini_set('display_errors', '0');
error_reporting(E_ERROR | E_PARSE);

	class mysql
	{

		function mysql()
		{
			$this->db='tousrenovcfr';
			$this->connexion=mysql_connect("localhost","root","");
			$this->select_db=mysql_select_db($this->db,$this->connexion);

			return $this->connexion;
		}
		function query($query)
		{
		  $rs_tmp = mysql_query($query, $this->link) or die("<HR>Echec : ".mysql_errno()." ".mysql_error()."<HR>$query<HR>");
		  return($rs_tmp);
		}
		function req($req)
		{
			$this->requete = mysql_query($req,$this->connexion);
			return $this->requete;
		}
		
		function obj($req)
		{
			$this->objet = mysql_fetch_object($req);
			return $this->objet;
		}
		
		function arr($req)
		{
			$this->arr = mysql_fetch_array($req);
			return $this->arr;
		}
		
		function req_obj($req)
		{
			$qry = mysql::req($req);
			$this->objet = mysql::obj($qry);
			return $this->objet;
		}
		
		function req_arr($req)
		{
			$qry = mysql::req($req);
			$this->arra = mysql::arr($qry);
			return $this->arra;
		}
		
		
		
		
		
		
		
		
		
		
function net_input($arg)
{
    if(get_magic_quotes_gpc()) {
                if(ini_get('magic_quotes_sybase')) {
                    $radhouano        = str_replace("''", "'", $arg);
                } else {
                    $radhouano        = stripslashes($arg);
                }
            } else {
                $radhouano        = $arg;
            }
    
	$this->arg_net = mysql_real_escape_string(htmlentities($radhouano));
	return $this->arg_net;
}

function net_textarea($arg)
{$bilel=nl2br($arg);
    if(get_magic_quotes_gpc()) {
                if(ini_get('magic_quotes_sybase')) {  $radhouano   = str_replace("''", "'", $bilel); } 
		else { $radhouano   = stripslashes($bilel);   }   }
	else {   $radhouano  = $bilel;     }
    
	$this->arg_net = mysql_real_escape_string($radhouano);
	return $this->arg_net;
}

function net_tinyMCE($arg)
{$bilel=$arg;
    if(get_magic_quotes_gpc()) {
                if(ini_get('magic_quotes_sybase')) {  $radhouano   = str_replace("''", "'", $bilel); } 
		else { $radhouano   = stripslashes($bilel);   }   }
	else {   $radhouano  = $bilel;     }
    
	$this->arg_net = mysql_real_escape_string($radhouano);
	return $this->arg_net;
}		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		function net($arg)
		{
			if(get_magic_quotes_gpc()){
				$arg = stripslashes($arg);
			}
			$this->arg_net = mysql_real_escape_string($arg,$this->connexion);
			return $this->arg_net;
		}
		
		function info()
		{
			$this->info_mysql = mysql_info($this->connexion);
			return $this->info_mysql;
		}
		
		function num($req)
		{
			$this->num_rows = $req?mysql_num_rows($req):0;
			return $this->num_rows;
		}
		function req_num($req)
		{
			$qry = mysql::req($req);
			$this->arra = mysql::num($qry);
			return $this->arra;
		}
		function schemaTable($nom_table)
		{
			$liste_attr = @mysql_list_fields($this->db,$nom_table, $this->connexion);
			for($i = 0; $i < mysql_num_fields($liste_attr); $i++)
			{
				$nom =  mysql_field_name($liste_attr, $i);
				$schema[$nom]['longueur'] = mysql_field_len($liste_attr, $i);
				$schema[$nom]['type'] = mysql_field_type($liste_attr, $i);
				$schema[$nom]['cle_primaire'] =	substr_count(mysql_field_flags($liste_attr, $i), "primary_key");
				$schema[$nom]['not_null'] =	substr_count(mysql_field_flags($liste_attr, $i), "not_null");
			}
			return $schema;
		}
		
		function id()
		{
			$this->last_id = mysql_insert_id($this->connexion);
			return $this->last_id;
		}
		
		function destruct()
		{
			if($this->connexion)
				@mysql_close ($this->connexion);
		}
		
	}
/*		
function net_input($arg)
		{
		    if(get_magic_quotes_gpc()) {
                if(ini_get('magic_quotes_sybase')) {
                    $r        = str_replace("''", "'", $arg);
                } else {
                    $r        = stripslashes($arg);
                }
            } else {
                $r        = $arg;
            }
		    
			$this->arg_net = mysql_real_escape_string(htmlentities($r));
			return $this->arg_net;
		}
		function req_all($req)
		{
		$Ret =$this->requete = mysql_query($req,$this->connexion);
			    		
    		$Rows = array();
    		if ($Ret)
    		while ($Row = mysql_fetch_object($Ret))
    		{
    			$Rows[] = $Row;
    		}
//    		return empty($Rows) ? null : $Rows;
    		return $Rows;

		}*/
?>