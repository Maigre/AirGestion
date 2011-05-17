<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	
	public function index()
	{
		$adherent = new Adherent();
		
		$adherent->makeFields('form');
		
		$data['adherent'] = $adherent->display('template1');		
		
		$this->load->view('welcome_message',$data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
