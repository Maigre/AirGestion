<?php

class Famille extends DataMapper {
	
	var $has_one=array("groupes");
	var $has_many=array("adherents");

	var $description = array(
		'adresse1' => 	array(
				'label' 	=> array('Adresse n°1'),
				'rules' 	=> array('xss_clean'),
				'defval'	=> '',
				'type'		=> 'normal',
				'format'	=> array(),
				'formfield' 	=> array('text', 40)
		)
		'adresse2' =>	array(,
				'label' 	=> array('Adresse n°2'),
				'rules' 	=> array('xss_clean'),
				'defval'	=> '',
				'type'		=> 'normal',
				'format'	=> array(),
				'formfield' 	=> array('text', 40)
		)
		'codepostal' => array(
				'label' 	=> array('Code postal)',
				'rules' 	=> array('xss_clean', 'required'),
				'defval'	=> '',
				'type'		=> 'normal',
				'format'	=> array(),
				'formfield' 	=> array('text', 5)
		)
		'ville' => 	array(
				'label' 	=> array('Ville'),
				'rules' 	=> array('xss_clean'),
				'defval'	=> '',
				'type'		=> 'normal',
				'format'	=> array(),
				'formfield' 	=> array('text', 25)
		)
		'exterieur' => 	array(
				'label' 	=> array('Extérieur'),
				'rules' 	=> array('xss_clean'),
				'defval'	=> '',
				'type'		=> 'normal',
				'format'	=> array(),
				'formfield' 	=> array('check')
		)
		'qf' => 	array(
				'label' 	=> array('Q.F'),
				'rules' 	=> array('xss_clean'),
				'defval'	=> '',
				'type'		=> 'normal',
				'format'	=> array(),
				'formfield' 	=> array('text', 5)
		)
		'ccas' => 	array(
				'label' 	=> array('CCAS'),
				'rules' 	=> array('xss_clean'),
				'defval'	=> '',
				'type'		=> 'normal',
				'format'	=> array(),
				'formfield' 	=> array('text', 10)
		)
		'bonvacance' => array(
				'label' 	=> array('Bons Vacances'),
				'rules' 	=> array('xss_clean'),
				'defval'	=> '',
				'type'		=> 'normal',
				'format'	=> array(),
				'formfield' 	=> array('check')
		)
		'groupe' => 	array(
				'label' 	=> array('Groupe'),
				'rules' 	=> array('xss_clean'),
				'defval'	=> '',
				'type'		=> 'link',
				'format'	=> array(),
				'formfield' 	=> array('listbox')
		)
	);
	
	var $templates = array(
		'tpl1' => '<table>
				<tr><th>Situation familiale</th></tr>
				<tr><td>{nom}</td></tr>
			     </table>',
	
		'tpl2' => '<table>
				<tr><td>{nom}</td></tr>
			     </table>'
		);
	
	var $modes = array(
		'display' => 'display',
		'edit' => array('nom' => 'form')	
		);
	
	function Famille()
	{
		parent::DataMapper();
	}

}