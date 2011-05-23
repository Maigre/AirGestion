<?php

class Situationfamiliale extends Dmc {
	
	var $has_many=array("adherent");

	var $description = array(
		'nom' => array(
			'label' 	=> array('Nom'),
			'rules' 	=> array('xss_clean','required'),
			'defval'	=> '',
			'type'		=> 'normal',  //'virtual', 'link'
			'format'	=> array(),
			'formfield' 	=> array('text', 10)
			)
		);
	
	var $templates = array();
	
	var $modes = array(
		'display' => array(),
		'form' => array()	
		);

	function Situationfamiliale()
	{
		parent::Dmc();
	}
	
	
	
	

}
