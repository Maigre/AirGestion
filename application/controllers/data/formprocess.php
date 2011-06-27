<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Formprocess extends CI_Controller {

	
	public function index()
	{
	
	}
	
	public function comboboxload($nomtable){ //$nomtable sans le 's' final
		$nomtable=ucwords(strtolower($nomtable));
		$table = new $nomtable();
		$table->get();
		foreach($table->all as $entree){
			$data[]=array(
						'id'=>$entree->id,
						'name'=>$entree->nom
					);
		}
  		//print_r($data); die;
  		$answer['combobox']=$data;
  		$answer['size'] = count($answer['combobox']);
  		$answer['success'] = true;
  		
  		echo json_encode($answer); 	
	}
	
	public function famille_from_adherent($idAdherent){ //$nomtable sans le 's' final
		
		$this->load->model('MJC/famille','famille_reliee');
		$this->famille_reliee->where_related_adherent('id',$idAdherent)->get();
		foreach($this->famille_reliee->all as $famille){
			$this->load->model('MJC/adherent','referent_famille');
			$this->referent_famille->where_related_famille('id',$famille->id)->where_related_statutadherent('id',1)->get();
			$nom_complet=$this->referent_famille->nom.' '.$this->referent_famille->prenom;
			$data[]=array(
						'idfamille'=>$famille->id,
						'nom_complet'=>$nom_complet						
			);
		}
  		//print_r($data); die;
  		$answer['combobox']=$data;
  		$answer['size'] = count($answer['combobox']);
  		$answer['success'] = true;
  		
  		echo json_encode($answer); 	
	}
}

?>
