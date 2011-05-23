<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Famille extends CI_Controller {

	
	public function index()
	{
		echo 'ok';
	}
	
	public function display($idAdherent)
	{
		$data['win']=$this->input->post('win');
		//trouver id famille correspondante et envoyer à la vue 
		//l'id de tous les membres de la famille classé par statut: referent, conjoint et enfants
		$famille = new Famille();
		$famille->where_related_adherent('id', $idAdherent)->select('id')->get();
		
		$referent = new Adherent();
		if($referent->where_related_famille('id', $famille->id)->where_related_statutadherent('id', '1')->get()){
			$data[referent][id]=$referent->id;
		}
		$conjoint = new Adherent();
		if($conjoint->where_related_famille('id', $famille->id)->where_related_statutadherent('id', '2')->get()){
			$data[conjoint][id]=$conjoint->id;
		}
		$enfants = new Adherent();
		if($enfants->where_related_famille('id', $famille->id)->where_related_statutadherent('id', '3')->get()){
			foreach ($enfants->all as $enfant){
				$data[enfants][]=$enfant->id;
			}
		}
		
		
		echo $o->title; 
		$this->load->view('MJC/famille',$data);
	}
}

