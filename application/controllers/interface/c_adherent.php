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
	
	public function form($idAdherent)
	{
		$data['win']=$this->input->post('win');
		
		$this->load->model('MJC/adherent','adherent');
		$this->adherent->where('id', $idAdherent)->get();
		
		$data['adherent'] = $this->adherent;
		$this->load->view('MJC/adherent_form',$data);
	}
	
	public function save($idAdherent){
	
		
		$this->load->model('MJC/adherent','run_adherent');
		$u = $this->run_adherent;
		
		
		$array = array('id' => $idAdherent);
		$u->where($array)->get();
		
		// Change fields value
		// Fetching Form Values
		foreach ($_POST as $field=>$value){
			$u->$field = $value;//reste à formater certains champs.
		}
		/*
		$u->sexe = $_POST['sexe'];
		$u->datenaissance = $_POST['datenaissance'];
		$u->fichesanitaire = $_POST['fichesanitaire'];
		$u->nom = $this->input->post('nom');
		$u->prenom = $this->input->post('prenom');
		$u->email = $this->input->post('email');
		$u->telportable = $_POST['telportable'];
		$u->teldomicile = $_POST['teldomicile'];
		$u->telprofessionel = $_POST['telprofessionel'];
		$u->sansviandesansporc = $_POST['sansviandesansporc'];
		$u->autorisationsortie = $_POST['autorisationsortie'];
		$u->allocataire = $_POST['allocataire'];
		$u->employeur = $_POST['employeur'];
		$u->noallocataire = $_POST['noallocataire'];
		$u->nosecu = $_POST['nosecu'];

//		$csp = new Csp();
//		$csp->where('nom', $_POST['csp'])->get();*/


		// Save changes to existing adherent
		$u->save(/*array($csp)*/); 
		
	}
	
	public function load($idAdherent){
		
		$this->load->model('MJC/adherent','run_adherent');
		$u = $this->run_adherent;
		$array = array('id' => $idAdherent);
		$u->where($array)->get();
		
		$data = array(
			'nom'=>$this->run_adherent->nom,
			'prenom'=>$this->run_adherent->prenom,
			'id'=>$this->run_adherent->id,
			'datenaissance'=>$this->run_adherent->datenaissance,
			'fichesanitaire'=>$this->run_adherent->fichesanitaire,
			'email'=>$this->run_adherent->email,
			'telportable'=>$this->run_adherent->telportable,
			'teldomicile'=>$this->run_adherent->teldomicile,
			'telprofessionel'=>$this->run_adherent->telprofessionel,
			'sansviandesansporc'=>$this->run_adherent->sansviandesansporc,
			'autorisationsortie'=>$this->run_adherent->autorisationsortie,
			'allocataire'=>$this->run_adherent->allocataire,
			'employeur'=>$this->run_adherent->employeur,
			'noallocataire'=>$this->run_adherent->noallocataire,
			'nosecu'=>$this->run_adherent->nosecu
			//'csp'=>$this->run_adherent->csp,
			//'situationfamiliale'=>$this->run_adherent->situationfamiliale,
			//'title'=>'G-Force',
		);  
  		//print_r($data); die;
  		$answer['adherent']=$data;
  		$answer['size'] = count($answer['adherent']);
  		$answer['success'] = true;
        
        echo json_encode($answer);  
    }  
}
