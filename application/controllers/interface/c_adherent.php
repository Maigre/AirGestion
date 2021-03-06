<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_adherent extends CI_Controller {

	private $idNewadherent;
	
	public function index()
	{
	
	}
	
	public function display($idAdherent)
	{
		$data['win']=$this->input->post('win');
		if ($idAdherent==0){
			//get the new family id
			$this->load->model('MJC/famille','run_famille');
			$famille = $this->run_famille;
			$famille->order_by("id", "desc")->limit(1)->get();
			//find the related adherent
			$this->load->model('MJC/adherent','run_adherent');
			$u = $this->run_adherent;
			$u->where_related_famille('id',$famille->id)->get();
			$idAdherent=$u->id;
		}
		else{
			//test unicité de la famille
			$this->load->model('MJC/famille','famille');
			$this->famille->where_related_adherent('id', $idAdherent)->select('id')->get();
			$number_family=0;
			foreach($this->famille as $famille){
				$number_family=$number_family+1;
			}
			//cas plusieurs familles
			if ($number_family>1){
				$data['double_famille']=true;
				//get all referents
				foreach($this->famille as $famille){
					$famille->adherent->select('id, nom, prenom')->get();
					foreach($famille->adherent->all as $adh)
					{
						//referent
						if ($adh->statutadherent->id == 1){
							$data['referent'][]=$adh->prenom.' '.$adh->nom;
						}
					}				
				} 
			}
			else $data['double_famille']=false;
		}
		$this->load->model('MJC/adherent','adherent');
		$this->adherent->where('id', $idAdherent)->get();
		
		$data['adherent'] = $this->adherent;
		$this->load->view('MJC/adherent',$data);
	}
	
	public function form($idAdherent)
	{
		$data['win']=$this->input->post('win');
		$this->load->model('MJC/adherent','adherent');
		if ($idAdherent!=0){
			$this->adherent->where('id', $idAdherent)->get();
		}
		else{
			$this->adherent->id=0;
		}
		
		$data['adherent'] = $this->adherent;
		$this->load->view('MJC/adherent_form',$data);
	}
	
	public function save($idAdherent, $statutAdherent=1, $idFamille=null){
	
		$this->load->model('MJC/adherent','run_adherent');
		$u = $this->run_adherent;
		
		$array = array('id' => $idAdherent);
		$u->where($array)->get();
		
		// Change fields value
		// Fetching Form Values
		foreach ($u->description as $field=>$data){
			$value=$this->input->post($field);
			if (isset($value) and ($field!='csp') and ($field!='situationfamiliale')){
				$u->$field=$value;
			} 
		}
		
		//formattage des dates
		if ($u->datenaissance!=0){
			$dateexplode = explode('/',$u->datenaissance);
			$datenaissance = $dateexplode[2].'-'.$dateexplode[1].'-'.$dateexplode[0];
			$datenaissance= date("Y-m-d", strtotime($datenaissance));
			$u->datenaissance = $datenaissance;
		}
		else{
			$u->datenaissance = '';
		}
		
		//formattage des booleens
		$boolean_data= array('allocataire','fichesanitaire','sansviandesansporc','autorisationsortie');
		foreach($boolean_data as $nom_data){
			
			if($u->$nom_data=='on') {
					$u->$nom_data=1;
				}
			else{
				$u->$nom_data=0;
			}
		}

		//Tableau des champs liés
		$related_fields= array();
		
		if (isset($_POST['csp'])){
			$csp = new Csp();
			$csp->where('nom', $_POST['csp'])->get();
			$related_fields[]=$csp;
		}
		
		if (isset($_POST['situationfamiliale'])){
			$situationfamiliale = new Situationfamiliale();
			$situationfamiliale->where('nom', $_POST['situationfamiliale'])->get();
			$related_fields[]=$situationfamiliale;
		}
		
		
		$this->load->model('MJC/statutadherent','run_statutadherent');
		$statutadherent = $this->run_statutadherent;
		
		$this->load->model('MJC/famille','run_famille');
		$famille = $this->run_famille;
			
		////////////////////
		//Case of new adherent
		if ($idAdherent==0){
			//verification des données du formulaire adherent
			
			//save the new family (data has been saved in session in c_famille/save())
			//If new referent then also new family
			if ($statutAdherent==1){
				$datafamille=$this->session->userdata('famille');
				//print_r($datafamille);
				foreach($datafamille as $field=>$value){
					if ($field!='groupe'){
					$famille->$field = $value;//reste à formater certains champs.
					}
				}

				if (isset($_POST['groupe'])){
					$groupe = new Groupe();
					$groupe->where('nom', $_POST['groupe'])->get();
					// Save changes to existing family
					$famille->save(array($groupe));
				}
				else{
					$famille->save();
				}
				//send the famille id to the adherent form_data
				$answer['idfamille'] = $famille->id;
				//relate to the statut referent(id=1)
				$statutadherent->where("id", 1)->get();
			}
			else{//new conjoint or kid
				$famille->where("id", $idFamille)->get();
				$statutadherent->where("id", $statutAdherent)->get();
			}
			//to relate the new adherent to the new famille
			$related_fields[]=$famille;
			$related_fields[]=$statutadherent;
		}
		/////////////////
		
		// Save
		
		$u->save($related_fields);
		//case new conjoint or kid send the id to the new_adherent() function.
		if ($idAdherent==0){
			$this->idNewadherent=$u->id;
		}
		else{
			$answer['success'] = true;
	  		echo json_encode($answer);
		}
		
	}
	
	public function load($idAdherent){
		
		$this->load->model('MJC/adherent','run_adherent');
		$u = $this->run_adherent;
		$array = array('id' => $idAdherent);
		$u->where($array)->get();
		//formating data
		$boolean_data= array('allocataire','fichesanitaire','sansviandesansporc','autorisationsortie');
		foreach($boolean_data as $nom_data){
			if($u->$nom_data==1) {
					$u->$nom_data='on';
				}
			else{
				$u->$nom_data='off';
			}
		}
		/*	
		if($u->sansviandesansporc==1) {
				$u->sansviandesansporc=true;
			}
		else{
			$u->sansviandesansporc=false;
		}*/
		
		$u->csp->get();
		$u->situationfamiliale->get();
		
		$data = array(
			'nom'=>$u->nom,
			'prenom'=>$this->run_adherent->prenom,
			'id'=>$u->id,
			'sexe'=>$u->sexe,
			'datenaissance'=>$u->datenaissance,
			'fichesanitaire'=>$u->fichesanitaire,
			'email'=>$u->email,
			'telportable'=>$u->telportable,
			'teldomicile'=>$u->teldomicile,
			'telprofessionel'=>$u->telprofessionel,
			'sansviandesansporc'=>$u->sansviandesansporc,
			'autorisationsortie'=>$u->autorisationsortie,
			'allocataire'=>$u->allocataire,
			'employeur'=>$u->employeur,
			'noallocataire'=>$u->noallocataire,
			'nosecu'=>$u->nosecu,
			'csp'=>$u->csp->nom,
			'situationfamiliale'=>$u->situationfamiliale->nom
			//'title'=>'G-Force',
		);  
  		//enlève les champs nuls
  		foreach ($data as $field=>$value){
  			if ($value=="0"){
  				$data[$field]='';
  			}
  		}
  		$answer['adherent']=$data;
  		$answer['size'] = count($answer['adherent']);
  		$answer['success'] = true;
        
        echo json_encode($answer);  
    }
    
    public function new_adherent($statutAdherent, $idFamille){
    	$this->save(0, $statutAdherent, $idFamille);
    	$this->load->model('process','process');
		$this->process->display($idFamille,$this->idNewadherent,$this->idNewadherent);
    }
    
    public function delete($idAdherent){
    	$this->load->model('MJC/adherent','run_adherent');
		$u = $this->run_adherent;
		$u->where('id', $idAdherent)->get();
		//array of related fields (HAS_ONE)
		$related_table=array('csp','situationfamiliale','statutadherent');
		foreach ($related_table as $field){
			$u->$field->get();
			$field=$u->$field;
			$links_to_delete[]=$field;
		}
		//vérification unicité famille
		//test unicité de la famille
		$this->load->model('MJC/famille','famille');
		$this->famille->where_related_adherent('id', $idAdherent)->get();
		$number_family=0;
		foreach($this->famille as $famille){
			$number_family=$number_family+1;
		}
		//cas famile unique
		if ($number_family<2){
			$links_to_delete[]=$this->famille;
		}
		else{
		
		}
		$u->delete($links_to_delete);
		$u->delete();
	}
	
	public function relate_adherent_to_famille($idFamille, $idAdherent){
		$this->load->model('MJC/adherent','adherent');
		$a = $this->adherent;
		$a->where('id', $idAdherent)->get();
		$this->load->model('MJC/famille','famille');
		$f = $this->famille;
		$f->where('id', $idFamille)->get();
		$a->save($f);
	}
    
    public function comboboxload($nomtable){
		$nomtable=ucword(strtolower($nom));
		$situationfamiliale = new $nomtable();
		$situationfamiliale->get();
		foreach($situationfamiliale->all as $situation){
			$data[]=$situation->nom;
		}
  		$answer['combobox']=$data;
  		$answer['size'] = count($answer['combobox']);
  		$answer['success'] = true;		
	}  
}//relate to the statut referent(id=1)
