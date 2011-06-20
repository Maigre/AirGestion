<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Process extends CI_Model
{
	public function display($idFamille=0, $idNewadherent=0)
	{
		$data['win']=$this->input->post('win');
		
		if ($idFamille > 0){		
			$this->load->model('MJC/famille','famille');
			$this->famille->where('id', $idFamille)->select('id')->get();
			$data['famille'] = $this->famille->id;
			//TODO : demande quelle famille si il y en a plusieurs !!
		
			//get all family members
			$this->famille->adherent->select('id, nom')->order_by('datenaissance')->get();
			foreach($this->famille->adherent->all as $adh)
			{
				//referent
				if ($adh->statutadherent->id == 1){
					$data['referent'] = $adh->id;
					$data['nom']= $adh->nom;
				}
				//conjoint
				else if ($adh->statutadherent->id == 2){
					$data['conjoint'] = $adh->id;
					if($idNewadherent==$adh->id){
						$data['isnewconjoint']=true;
					}
					else $data['isnewconjoint']=false;
				}
				//enfants
				else{
					$data['enfants'][] = $adh->id;
					if($idNewadherent==$adh->id){
						$data['isnewkid'][]=true;
					}
					else $data['isnewkid'][]=false;
					
				} 
			}
		}
		else{ //nouvelle famille
			$data['famille'] = 0;
			$data['referent'] = 0;
			$data['nom']= null;
		}
				
		$this->load->view('MJC/famille',$data);
	}	
}
