<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_famille extends CI_Controller {

	
	public function index()
	{
	
	}
	
	public function display($idAdherent=2)
	{
		$idAdherent=2;
		$data['win']=$this->input->post('win');
		//trouver id famille correspondante et envoyer à la vue 
		//l'id de tous les membres de la famille classé par statut: referent, conjoint et enfants
		
		
		$this->load->model('MJC/famille','run_famille');

		$this->run_famille->where_related_adherent('id', $idAdherent)->select('id')->get();
		
		$this->load->model('MJC/adherent','run_referent');
		if($this->run_referent->where_related_famille('id', $this->run_famille->id)->where_related_statutadherent('id', '1')->get()){
			$data['referent']['id']=$this->run_referent->id;
			$data['referent']['nom']=$this->run_referent->prenom.' '.$this->run_referent->nom;
			$data['referent']['sexe']=$this->run_referent->sexe;			 
		}
		
		
		$this->load->model('MJC/adherent','run_conjoint');
		if($this->run_conjoint->where_related_famille('id', $this->run_famille->id)->where_related_statutadherent('id', '2')->get()){
			$data['conjoint']['id']=$this->run_conjoint->id;
			$data['conjoint']['nom']=$this->run_conjoint->prenom.' '.$this->run_conjoint->nom;
			$data['conjoint']['sexe']=$this->run_conjoint->sexe;
		}
		
		$this->load->model('MJC/adherent','run_enfants');
		if($this->run_enfants->where_related_famille('id', $this->run_famille->id)->where_related_statutadherent('id', '3')->get()){
			foreach ($this->run_enfants->all as $enfant){
				$enfants['id']=$enfant->id;
				$enfants['nom']=$enfant->prenom.' '.$enfant->nom;
				$enfants['sexe']=$enfant->sexe;
				$data['enfants'][]=$enfants;
			}
		}
		//print_r($data['enfants'][0]);die;
		$this->load->view('MJC/famille',$data);
	}
}

