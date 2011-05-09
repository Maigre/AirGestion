<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dmc extends DataMapper {
	
	protected $description;
	/*
	array(
		'nom' => 	array(
				'label' 	=> array('Nom',false),                 	// field label, 0: form / 1: display
				'rules' 	=> array('required', 'xss_clean'),	// rules to apply on checkfields
				'format'	=> array(),				// formating & unformattig data method raw<=>use
				'defval'	=> '',					// default value for new oject
				'type'		=> 'normal',				// normal : existing field in DB / link : link to another table in DB / virtual : unexisting field in DB
				'formfield' 	=> array('text',15, 'js'=> '')		// form style properties
		)
	)
	*/
	
	protected $templates;
	/* list of mini-view -> views/class_name/template.php */
	
	protected $modes;
	/*
	array(
		'mode1' => array(
					'default' => 'display', 	//default mode for unspecified fields 
					'nom'	  => 'form'		//available mode : display / form / print / hide
				)		
	)
	*/
	

	function __construct()
	{		
		parent::DataMapper();
	}
	
	
	function checkfields() //appelle checkfields() de l'objet et si les champs sont valides, peuple les attributs de l'objet avec ceux-ci.
	{
		
	}
	
	function display($template,$mode)
	{
	
	}
}
