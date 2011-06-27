<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_famille extends CI_Controller {

	
	public function index()
	{
	
	}
	
	public function displayfamille($idFamille)
	{
		$data['win']=$this->input->post('win');
		
		if (!is_null($idFamille)){
			$this->load->model('MJC/famille','famille');
			$this->famille->where('id', $idFamille)->get();
			$data['famille'] = $this->famille;
		}
		else $data['famille'] = '';
		$this->load->view('MJC/famille_display',$data);
	}
	
	public function display($idFamille=0,$idAdherent=0)
	{
		//test unicité famille
		$this->load->model('process','process');
		$this->process->display($idFamille,$idAdherent);
	}
	
	public function form($idFamille)
	{
		$data['win']=$this->input->post('win');
		$this->load->model('MJC/famille','famille');
		if ($idFamille!=0){
			$this->famille->where('id', $idFamille)->get();
		}
		else{
			$this->famille->id=0;
		}
		$data['famille'] = $this->famille;
		$this->load->view('MJC/famille_form',$data);
	}
	
	public function save($idFamille){
	
		
		$this->load->model('MJC/famille','run_famille');
		$u = $this->run_famille;
		
		
		$array = array('id' => $idFamille);
		$u->where($array)->get();
		
		// Change fields value
		// Fetching Form Values
		foreach ($_POST as $field=>$value){
			if ($field!='groupe'){
				$u->$field = $value;//reste à formater certains champs.
			}
		}
		
		//formattage des booleens
		$boolean_data= array('exterieur','bonvacance');
		foreach($boolean_data as $nom_data){
			
			if($u->$nom_data=='on') {
				$u->$nom_data=1;
			}
			else{
				$u->$nom_data=0;
			}
		}
		//Nouvelle famille les informations sont stockées en session, et rechargées après validation du référent
		if ($idFamille==0){
			foreach ($u->description as $id=>$field){
				$field=$this->input->post($id);
				if (isset($field)){
					$newdata['famille'][$id]=$field;
				} 
			}
			$this->session->set_userdata($newdata);
			$answer['success'] = true;
		}
		else{
			if (isset($_POST['groupe'])){
				$groupe = new Groupe();
				$groupe->where('nom', $_POST['groupe'])->get();
				// Save changes to existing family
				$u->save(array($groupe));
			}
			else{
				$u->save();
			}
			$answer['success'] = true;
		}		
		echo json_encode($answer);		
	}
	
	public function load($idFamille){
		
		$this->load->model('MJC/famille','run_famille');
		$u = $this->run_famille;
		$array = array('id' => $idFamille);
		$u->where($array)->get();
		//formating data
		$boolean_data= array('exterieur','bonvacance');
		foreach($boolean_data as $nom_data){
			if($u->$nom_data==1) {
					$u->$nom_data='on';
				}
			else{
				$u->$nom_data='off';
			}
		}
		
		$u->groupe->get();
		
		$data = array(
			'adresse1'=>$u->adresse1,
			'adresse2'=>$u->adresse2,
			'codepostal'=>$u->codepostal,
			'ville'=>$u->ville,
			'exterieur'=>$u->exterieur,
			'qf'=>$u->qf,
			'ccas'=>$u->ccas,
			'bonvacance'=>$u->bonvacance,
			'teldomicile'=>$u->teldomicile,
			'telprofessionel'=>$u->telprofessionel,
			'sansviandesansporc'=>$u->sansviandesansporc,
			'autorisationsortie'=>$u->autorisationsortie,
			'groupe'=>$u->groupe->nom
		);
  		$answer['adherent']=$data;
  		$answer['size'] = count($answer['adherent']);
  		$answer['success'] = true;
        
        echo json_encode($answer);  
    }
	
	
}

