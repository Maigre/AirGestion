<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {

	
	public function index()
	{
		if ($this->auth37->logged() > 0)
		{
			echo "{success : true,user: \"".$this->auth37->user()."\",level: \"".$this->auth37->logged()."\"}";
		}
		else
		{
			echo "{success : false}";
		}
	}
	
	public function login()
	{
		$log = $this->auth37->login($this->input->post('login'),$this->input->post('password'));
		
		if ($log) echo "{success : true, user : \"".$this->auth37->user()."\"}";
		else echo "{success : false, msg : \"Mauvais mot de passe !\"}";
	}
}
