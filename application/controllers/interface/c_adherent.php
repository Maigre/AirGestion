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
}
