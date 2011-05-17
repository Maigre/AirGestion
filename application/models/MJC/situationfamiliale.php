<?php

class Situationfamiliale extends DataMapperCustom {
	
	var $has_many=array("adherents");

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
		'display' => array(),
		'form' => array()	
		);

	function Situationfamiliale()
	{
		parent::__construct();
	}
	
	
	
	

}