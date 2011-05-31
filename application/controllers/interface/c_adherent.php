<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_adherent extends CI_Controller {

	
	public function index()
	{
	
	}
	
	public function display($idAdherent)
	{
		$data['win']=$this->input->post('win');
		
		$this->load->model('MJC/adherent','adherent');
		$this->adherent->where('id', $idAdherent)->get();
		
		$data['adherent'] = $this->adherent;
		$this->load->view('MJC/adherent',$data);
	}
	
	public function save($idAdherent){
	
		
		$this->load->model('MJC/adherent','run_adherent');
		$u = $this->run_adherent;
		
		
		$array = array('id' => $idAdherent);
		$u->where($array)->get();
		
		// Change fields value
		// Fetching Form Values
		/*$u->sexe = $_POST['sexe'];
		$u->datenaissance = $_POST['datenaissance'];
		$u->fichesanitaire = $_POST['fichesanitaire'];*/
		$u->nom = $this->input->post('nom');
		$u->prenom = $this->input->post('prenom');
		$u->email = $this->input->post('email');/*
		$u->telportable = $_POST['telportable'];
		$u->teldomicile = $_POST['teldomicile'];
		$u->telprofessionel = $_POST['telprofessionel'];
		$u->sansviandesansporc = $_POST['sansviandesansporc'];
		$u->autorisationsortie = $_POST['autorisationsortie'];
		$u->allocataire = $_POST['allocataire'];
		$u->employeur = $_POST['employeur'];
		$u->noallocataire = $_POST['noallocataire'];
		$u->nosecu = $_POST['nosecu'];

		$csp = new Csp();
		$csp->where('nom', $_POST['csp'])->get();

		*/
		// Save changes to existing adherent
		$u->save(/*array($csp)*/); 
		
	}
	
}
