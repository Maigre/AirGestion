<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends CI_Controller {

	
	public function index()
	{
		echo 'ok';
	}
	
	public function adherent()
	{
		$data['win']=$this->input->post('win');
		$this->load->view('menu/adherent_search.php',$data);
		//$this->load->view('menu/adherent_familynew');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
