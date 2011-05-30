<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_famille extends CI_Controller {

	
	public function index()
	{
		echo 'okdude';
	}
	
	public function display($idAdherent)
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
		}
		
		
		$this->load->model('MJC/adherent','run_conjoint');
		if($this->run_conjoint->where_related_famille('id', $this->run_famille->id)->where_related_statutadherent('id', '2')->get()){
			$data['conjoint']['id']=$this->run_conjoint->id;
		}
		
		$this->load->model('MJC/adherent','run_enfants');
		if($this->run_enfants->where_related_famille('id', $this->run_famille->id)->where_related_statutadherent('id', '3')->get()){
			foreach ($this->run_enfants->all as $enfant){
				$data['enfants'][]=$enfant->id;
			}
		}
		//print_r($data['enfants'][0]);die;
		$this->load->view('MJC/famille',$data);
	}
}

