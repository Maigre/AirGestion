<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Process extends CI_Model
{
	public function display($idFamille=0, $idAdherent=0, $idNewAdherent=0)
	{
		$data['win']=$this->input->post('win');
		
		if ($idFamille > 0){		
			
			//get the related family(s)
			$this->load->model('MJC/famille','famille');
			if ($idAdherent==0){
				$this->famille->where('id', $idFamille)->select('id')->get();
				$data['famille'] = $idFamille;
			}
			else{
				$this->famille->where_related_adherent('id', $idAdherent)->select('id')->get();
				$data['famille'] = $this->famille->id;
			}
						
			$count=0;
			foreach($this->famille as $famille){
				$count=$count+1;
			}
			//demande quelle famille si il y en a plusieurs !!
			if ($count>1){
				
				//get all referents
				foreach($this->famille as $famille){
				
					$famille->adherent->select('id, nom, prenom')->get();
					foreach($famille->adherent->all as $adh)
					{
						//referent
						if ($adh->statutadherent->id == 1){
							$data['familles'][]=array(
								'id' => $adh->id,
								'idFamille' => $famille->id,
								'nom'=> $adh->nom,
								'prenom'=> $adh->prenom
							);
						}
					}				
				}
				$this->load->view('MJC/double_famille',$data);
			}
			else{
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
						if($idNewAdherent==$adh->id){
							$data['isnewconjoint']=true;
						}
						else $data['isnewconjoint']=false;
					}
					//enfants
					else{
						$data['enfants'][] = $adh->id;
						if($idNewAdherent==$adh->id){
							$data['isnewkid'][]=true;
						}
						else $data['isnewkid'][]=false;
					
					} 
				}
				$this->load->view('MJC/famille',$data);
			}
		}
		else{//nouvelle famille
			$data['famille'] = 0;
			$data['referent'] = 0;
			$data['nom']= null;
			$this->load->view('MJC/famille',$data);
		}
	}	
	
}
