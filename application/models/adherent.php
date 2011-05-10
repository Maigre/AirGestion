<?php

class Adherent extends DataMapper {
	
	var $has_one=array("csps", "situationfamiliales", "statutadherents");
	var $has_many=array("familles");
	
	var $description = array(
		'nom' => 	array(
				'label' 	=> array('Nom',false),
				'rules' 	=> array('required', 'xss_clean'),
				'defval'	=> '',
				'type'		=> 'normal',				
				'formfield' 	=> array('text', 15)
		),
		'prenom' => 	array(
				'label' 	=> array('Prénom',false),
				'rules' 	=> array('required', 'xss_clean'),
				'defval'	=> '',
				'type'		=> 'normal',
				'formfield' 	=> array('text', 15)
		),
		'sexe' => 	array(
				'label' 	=> array('Sexe'),
				'rules' 	=> array('xss_clean'),
				'defval'	=> '',
				'type'		=> 'normal',
				'formfield' 	=> array('radio')
		),
		'datenaissance' => array(
				'label' 	=> array('Date de naissance'),
				'rules' 	=> array('required', 'xss_clean', 'valid_date'),
				'defval'	=> '',
				'type'		=> 'normal',
				'formfield' 	=> array('date')
		),
		'fichesanitaire' => array(
				'label' 	=> array('Fiche Sanitaire'),
				'rules' 	=> array('xss_clean'),
				'defval'	=> '',
				'type'		=> 'normal',
				'formfield' 	=> array('text', 15)
		),
		'email' => 	array(
				'label' 	=> array('Email'),
				'rules' 	=> array('xss_clean', 'valid_email'),
				'defval'	=> '',
				'type'		=> 'normal',
				'formfield' 	=> array('text', 30)
		),
		'telportable' => array(
				'label' 	=> array('Tél. Portable'),
				'rules' 	=> array('xss_clean', 'numeric', 'exact_length[10]'),
				'defval'	=> '',
				'type'		=> 'normal',
				'formfield' 	=> array('text', 10)
		),
		'teldomicile' => array(
				'label' 	=> array('Tel. Domicile'),
				'rules' 	=> array('xss_clean', 'numeric', 'exact_length[10]'),
				'defval'	=> '',
				'type'		=> 'normal',
				'formfield' 	=> array('text', 10)
		),
		'telprofessionel' => array(
				'label' 	=> array('Tel. Professionel'),
				'rules' 	=> array('xss_clean', 'numeric', 'exact_length[10]'),
				'defval'	=> '',
				'type'		=> 'normal',
				'formfield' 	=> array('text', 10)
		),
		'sansviandesansporc' => array(
				'label' 	=> array('Sans Viande Sans Porc'),
				'rules' 	=> array('xss_clean'),
				'defval'	=> '',
				'type'		=> 'normal',
				'formfield' 	=> array('check')
		),
		'autorisationsortie' => array(
				'label' 	=> array('Autorisation de sortie'),
				'rules' 	=> array('xss_clean'),
				'defval'	=> '',
				'type'		=> 'normal',
				'formfield' 	=> array('check')
		),
		'allocataire' => array(
				'label' 	=> array('Allocataire'),
				'rules' 	=> array('xss_clean'),
				'defval'	=> '',
				'type'		=> 'normal',
				'formfield' 	=> array('check')
		),
		'employeur' => 	array(
				'label' 	=> array('Employeur'),
				'rules' 	=> array('xss_clean'),
				'defval'	=> '',
				'type'		=> 'normal',
				'formfield' 	=> array('text', 15)
		),
		'noallocataire' => array(
				'label' 	=> array('N° d\'Allocataire'),
				'rules' 	=> array('xss_clean'),
				'defval'	=> '',
				'type'		=> 'normal',
				'formfield' 	=> array('text', 10)
		),
		'nosecu' => 	array(
				'label' 	=> array('N° Sécu'),
				'rules' 	=> array('xss_clean', 'exact_length[15]'),
				'defval'	=> '',
				'type'		=> 'normal',
				'formfield' 	=> array('text', 15)
		),
		'csp' => 	array(
				'label' 	=> array('CSP'),
				'rules' 	=> array('xss_clean'),
				'defval'	=> '',
				'type'		=> 'link',
				'formfield' 	=> array('listbox')
		),
		'situationfamiliale' => array(
				'label' 	=> array('Situation familiale'),
				'rules' 	=> array('xss_clean'),
				'defval'	=> '',
				'type'		=> 'link',
				'formfield' 	=> array('listbox')
		)
	);
	
	//Generation des templates
		$tpl1 = '<table>';
		foreach $description as $nom_champ=>$properties
		{
			$tpl1 .= '<tr><td>{'.$nom_champ.'}</td></tr>';
		}
		$tpl1 .= '</table>';
	
		'tpl2' => '<table>
				<tr><td>{nom}</td></tr>
			     </table>'
		);
	var $templates = array('template1','template2_mainview_adulte','template2_mainview_enfant');
	
	var $modes = array(
		'display' => array(),
		'form' => array()	
		);

	function Adherent()
	{
		parent::DataMapper();
	}

}