<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {

	
	public function index()
	{

	}

	public function adherent()
	{
		//DATAMAPPER CONSTRUCTING
		$this->load->model('MJC/adherent','adherents');
			
		
		function strongMe($matches) {return '<strong>'.$matches[0].'</strong>';}

		function sign($sign)
		{
			if (in_array($sign,array('<','<=','=','>=','>','<>','!='))) return $sign;
			else return '=';
		}

		//initialize answer array TODO(should be an array design to be JSON encoded)
		$answer = array(
					'size' 	=> 0,
					'msg'	=> ''
				); 

		//initialize recieved vars from POST
		$vars = array(
			'name_search' 	=> 	'VER DEAU'
		);
		
		//retrieve search argument from POST and sanitize (may be use CI methods to santize ?)
		foreach($vars as $k=>$v) if ($this->input->post($k)) $vars[$k] = utf8_encode(trim(mysql_real_escape_string($this->input->post($k))));


		//SELECT		
		$this->adherents->select('id, nom, prenom');

		//mysql_query('set names utf8'); 
		
		//$req = "SELECT id, nom, prenom FROM adherent";
		/*
		$req = "SELECT Contact.idContact, Nom, Prenom, NomStructure, Adresse4_CP, Adresse4_Commune, Adresse5_Pays, idStand, idAbonnement, idDepositaire, NPAI, Siberlettre,
				Contact.DateCreation, Contact.DateModification, Contact.idOrigineContact, 
				Abonnement.idAbonnement, Abonnement.DateCreation, Abonnement.NoDebut, Abonnement.NoFin, Abonnement.idOrigineAbo, Abonnement.idCentraleAchat, Abonnement.idContactDestinataire, Abonnement.Montant, 
				Depositaire.idDepositaire, Depositaire.idOrigineDepot, Depositaire.NoDebut, Depositaire.NoFin, Depositaire.idTypeDepot,
				Stand.idStand,
				Decouverte.Numero, 
				Achat.idAchat,
				Don.idDon, Don.Annee,
				Versement.Montant, Versement.DateCompta
		
					FROM Contact LEFT OUTER JOIN Abonnement ON Contact.idContact=Abonnement.idContact 
						LEFT OUTER JOIN Depositaire ON Contact.idContact=Depositaire.idContact
						LEFT OUTER JOIN Stand ON Contact.idContact=Stand.idContact
						LEFT OUTER JOIN Decouverte ON Contact.idContact=Decouverte.idContact
						LEFT OUTER JOIN Achat ON Contact.idContact=Achat.idContact
						LEFT OUTER JOIN Versement ON Contact.idContact=Versement.idContact
						LEFT OUTER JOIN Don ON Versement.idVersement=Don.idVersement
						";
		*/

		//strart 1st WHERE
		$where = "("; 	
		
		//SPLIT SPACE NAME SEARCH :
		if ($vars['name_search'] == '') $src = array(0 => '.'); 
		else $src = explode(' ',$vars['name_search']);

		foreach($src as $i=>$sr)
		{
			if ($i >0) $where  .= " AND";
			$sr = str_replace("\'","[\'’]",$sr);
			$sr = str_replace("’","[\'’]",$sr);
			$where.=" (nom REGEXP '".$sr."' OR prenom REGEXP '".$sr."') ";
		}
		///////////////////////////
		
		//MERGED SPACE NAME SEARCH
		$src2 = str_replace(' ','',$vars['name_search']);
		$src2 = str_replace("\'","[\'’]",$src2);
		$src2 = str_replace("’","[\'’]",$src2);
		if ($src2 != '') $where.=" OR (nom REGEXP '".$src2."' OR prenom REGEXP '".$src2."') ";
		///////////////////////////
		
		$where .= " )";	//end 1st WHERE

		/*
		//EXEMPLE USING AND & REGEXP
		if ($vars['CP'] != '') 
		{
			if (strlen($vars['CP']) == 1) $req .= " AND Adresse4_CP REGEXP '^(0?)".$vars['CP']."'";
			else $req .= " AND Adresse4_CP REGEXP '^".$vars['CP']."'";
		}

		//EXEMPLE USING AND & =
		if (isset($vars['idOrigineContact']))
			$req .= " AND (Contact.idOrigineContact = '".$vars['idOrigineContact']."')";
	
		//EXEMPLE USING SIGN
		if ((isset($vars['ListDebutAbo']))&&(isset($vars['ListDebutAboSign'])))
			$req .= " AND (Abonnement.NoDebut ".sign($vars['ListDebutAboSign'])." '".$vars['ListDebutAbo']."')";
		*/
		
		//APPLY WHERE
		$this->adherents->where($where);
		
		//PRE ORDER
		$this->adherents->order_by('nom','asc');

		//LOAD !
		$this->adherents->get();

		//ORDER RESULTS
		$ansT = null;
		foreach($this->adherents->all as $a) 
		{
			//BUILD RANK BASED ON nom/prenom OR prenom/nom
			if ($vars['name_search'] != '')
			{
				$src = str_replace(' ','',$vars['name_search']);
				$p1 = min(stripos(str_replace(' ','',$a->nom.$a->prenom),$src),stripos(str_replace(' ','',$a->nom.$a->prenom),$src)); 
				if ($p1 === false) $p1 = 100;
			}
			else $p1 = 0;
			
			//STORE INTO sorted array
			$ansT[$p1][$a->nom.$a->prenom.$a->id] = $a;
			
		} 
		
		//PROCESS SORTED ARRAY
		if (is_array($ansT)) 
		{
			ksort($ansT); //sort by Rank			
			foreach($ansT as $rank=>$list) //foreach rank value
			{
				ksort($list); //sort by nom.prenom.id
				foreach($list as $a) 
				{
					$adh = null;
					
					$adh['prenom'] = $a->prenom;
					$adh['nom'] = $a->nom;
					$adh['id'] = $a->id;
					
					//strong up identified piece of string
					if ($vars['name_search'] != '')
					{
						$adh['prenom'] = preg_replace_callback("/".$vars['name_search']."/i",'strongMe',$adh['prenom']);
						$adh['nom'] = preg_replace_callback("/".$vars['name_search']."/i",'strongMe',$adh['nom']);
					}
					
					//return ARRAY
					$answer['adherent'][] =  $adh;
				}
			}
			
			$answer['size'] = count($answer['adherent']);
		}
		else 
		{
			//JSON ERROR
			$answer['size'] = 0;
			$answer['msg'] = 'aucun resultat...';
		}
		
		//RETURN JSON !
		echo json_encode($answer);
	}
}
