<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_adherent extends CI_Controller {

	
	public function index()
	{
	
	}
	
	public function display($idAdherent,$statutadherent, $generaldetail, $numeroenfant)
	{
		$data['win']=$this->input->post('win');
		//cherche dans la database l'adherent dont l'idée est fournie en argument
		//renvoie toutes les données à la vue.
		
		
		$this->load->model('MJC/adherent','run_adherent');
		//$fields[]=['nom','prenom','email'];
		$this->run_adherent->where('id', $idAdherent)->get();
		//->select($fields)
		//print_r($this->run_adherent); die;
		$data['run_adherent']['nom']=$this->run_adherent->nom;
		$data['run_adherent']['prenom']=$this->run_adherent->prenom;
		$data['run_adherent']['id']=$this->run_adherent->id;
		$data['run_adherent']['datenaissance']=$this->run_adherent->datenaissance;
		$data['run_adherent']['fichesanitaire']=$this->run_adherent->fichesanitaire;
		$data['run_adherent']['email']=$this->run_adherent->email;
		$data['run_adherent']['telportable']=$this->run_adherent->telportable;
		$data['run_adherent']['teldomicile']=$this->run_adherent->teldomicile;
		$data['run_adherent']['telprofessionel']=$this->run_adherent->telprofessionel;
		$data['run_adherent']['sansviandesansporc']=$this->run_adherent->sansviandesansporc;
		$data['run_adherent']['autorisationsortie']=$this->run_adherent->autorisationsortie;
		$data['run_adherent']['allocataire']=$this->run_adherent->allocataire;
		$data['run_adherent']['employeur']=$this->run_adherent->employeur;
		$data['run_adherent']['noallocataire']=$this->run_adherent->noallocataire;
		$data['run_adherent']['nosecu']=$this->run_adherent->nosecu;
		$data['run_adherent']['csp']=$this->run_adherent->csp;
		$data['run_adherent']['situationfamiliale']=$this->run_adherent->situationfamiliale;		
		
		//$data['run_adherent']=$this->run_adherent;
		if ($statutadherent==1){
			if ($generaldetail==0){$this->load->view('MJC/referent',$data);}
			else {$this->load->view('MJC/referentdetail',$data);}
		}
		elseif ($statutadherent==2){
			if ($generaldetail==0){$this->load->view('MJC/conjoint',$data);}
			else {$this->load->view('MJC/conjointdetail',$data);}
		}
		elseif ($statutadherent==3){
			$data['run_adherent']['numeroenfant']=$numeroenfant;
			if ($generaldetail==0){$this->load->view('MJC/enfant',$data);}
			else {$this->load->view('MJC/enfantdetail',$data);}
		}		
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
