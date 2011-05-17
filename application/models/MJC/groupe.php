<?php

class Groupe extends Dmc {
	
	var $has_many=array("familles");
	
	var $description = array(
		'nom' => 	array(
				'label' 	=> array('Nom'),
				'rules' 	=> array('xss_clean'),
				'defval'	=> '',
				'type'		=> 'normal',
				'format'	=> array(),
				'formfield' 	=> array('text', 10)
		)
	);
	
	var $templates = array();
	
	var $modes = array(
		'display' => array(),
		'form' => array()	
		);

	function Groupe()
	{
		parent::Dmc();
	}

}
