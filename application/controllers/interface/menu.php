<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends CI_Controller {

	
	public function index()
	{
		echo 'ok';
	}
	
	public function adherent()
	{
		$data['win']=$this->input->post('win');
		$this->load->view('MJC/menu/adherent_search',$data);
	}
}
