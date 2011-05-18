<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	
	public function index()
	{

	}
	
	public function adherent()
	{
		$this->load->view('menu/adherent_search');
		$this->load->view('menu/adherent_familynew');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
