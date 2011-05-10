<?php

class Famille extends DataMapper {
	
	var $has_one=array("groupes");
	var $has_many=array("adherents");

	var $description = array(
		'nomreferent' => array(
				'label' 	=> array('Nom du référent'),
				'rules' 	=> array('xss_clean'),
				'defval'	=> '',
				'type'		=> 'virtual',
				'formfield' 	=> array('text', 40)
		),
		'prenomreferent' => array(
				'label' 	=> array('Nom du référent'),
				'rules' 	=> array('xss_clean'),
				'defval'	=> '',
				'type'		=> 'virtual',
				'formfield' 	=> array('text', 40)
		),		
		'adresse1' => 	array(
				'label' 	=> array('Adresse n°1'),
				'rules' 	=> array('xss_clean'),
				'defval'	=> '',
				'type'		=> 'normal',
				'formfield' 	=> array('text', 40)
		),
		'adresse2' =>	array(,
				'label' 	=> array('Adresse n°2'),
				'rules' 	=> array('xss_clean'),
				'defval'	=> '',
				'type'		=> 'normal',
				'formfield' 	=> array('text', 40)
		),
		'codepostal' => array(
				'label' 	=> array('Code postal)',
				'rules' 	=> array('xss_clean', 'required'),
				'defval'	=> '',
				'type'		=> 'normal',
				'formfield' 	=> array('text', 5)
		),
		'ville' => 	array(
				'label' 	=> array('Ville'),
				'rules' 	=> array('xss_clean'),
				'defval'	=> '',
				'type'		=> 'normal',
				'formfield' 	=> array('text', 25)
		),
		'exterieur' => 	array(
				'label' 	=> array('Extérieur'),
				'rules' 	=> array('xss_clean'),
				'defval'	=> '',
				'type'		=> 'normal',
				'formfield' 	=> array('check')
		),
		'qf' => 	array(
				'label' 	=> array('Q.F'),
				'rules' 	=> array('xss_clean'),
				'defval'	=> '',
				'type'		=> 'normal',
				'formfield' 	=> array('text', 5)
		),
		'ccas' => 	array(
				'label' 	=> array('CCAS'),
				'rules' 	=> array('xss_clean'),
				'defval'	=> '',
				'type'		=> 'normal',
				'formfield' 	=> array('text', 10)
		),
		'bonvacance' => array(
				'label' 	=> array('Bons Vacances'),
				'rules' 	=> array('xss_clean'),
				'defval'	=> '',
				'type'		=> 'normal',
				'formfield' 	=> array('check')
		),
		'groupe' => 	array(
				'label' 	=> array('Groupe'),
				'rules' 	=> array('xss_clean'),
				'defval'	=> '',
				'type'		=> 'link',
				'formfield' 	=> array('listbox')
		)
	);
	
	var $templates = array('template1','template2_mainview');
	
	var $modes = array(
		'display' => array(),
		'form' => array('nomreferent','prenomreferent')	
		);
	
	function Famille()
	{
		parent::DataMapper();
	}
	
	function beforeMake()
	{
		// Get adherents linked to this famille and select the one with statutadherent=referent
		$this->adherent->where_related_statutadherent('nom','referent')->get();
		
		// full the defval.
		$this->description['nomreferent']['defval']=$this->adherent->nom;
		$this->description['prenomreferent']['defval']=$this->adherent->prenom;
	}

}