<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_famille extends CI_Controller {

	
	public function index()
	{
	
	}
	
	public function display($idAdherent,$idFamille=null)
	{
		$data['win']=$this->input->post('win');
		
		$this->load->model('MJC/famille','famille');
		$this->famille->where_related_adherent('id', $idAdherent)->select('id')->get();
		//TODO : demande quelle famille si il y en a plusieurs !!
		
		//get all family members
		$this->famille->adherent->select('id')->order_by('datenaissance')->get();
		foreach($this->famille->adherent->all as $adh)
		{
			//referent
			if ($adh->statutadherent->id == 1) $data['referent'] = $adh->id;
			//conjoint
			else if ($adh->statutadherent->id == 2) $data['conjoint'] = $adh->id;
			//enfants
			else $data['enfants'][] = $adh->id;
		}
				
		$this->load->view('MJC/famille',$data);
	}
}

