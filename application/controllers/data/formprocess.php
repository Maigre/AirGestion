<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Formprocess extends CI_Controller {

	
	public function index()
	{
	
	}
	
	public function comboboxload($nomtable){ //$nomtable sans le 's' final
		$nomtable=ucwords(strtolower($nomtable));
		$situationfamiliale = new $nomtable();
		$situationfamiliale->get();
		foreach($situationfamiliale->all as $situation){
			$data[]=array(
						'id'=>$situation->id,
						'name'=>$situation->nom
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
