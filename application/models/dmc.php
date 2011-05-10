<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once('formfield.php');

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

	private $formfields; //array containing all formfields objects builded from description
	
	private $currentMode = null;
	private $relationUpdated = array(); //list relation updated by checkFields() and that must be saved by saveAll()
	
	private $valid_DM = true;
	
	function Dmc()
	{				
		if (!is_array($this->description)) {/*echo 'ERROR : No description for this object ! '.get_class($this); die;*/ $this->valid_DM = false;}
		else parent::DataMapper();
	}
	
	function makeFields($mode)
	{
		if (is_null($mode)) {echo 'ERROR : No mode selected ! '.get_class($this); die;}
		else $this->currentMode = $mode;
		
		//destruct previously build FormFields
		if (is_array($this->formfields))
			foreach($this->formfields as $i=>$v) unset($this->formfields[$i]);
		
		$this->formfields = array();

	
		//make defval for virtual fields
		$this->beforeMake();
	
		//make defval for normal & linked fields
		foreach ($this->description as $name => $desc)
		{
			//defval for normal fields (directly from DB)
			if ((!isset($desc['type']))||($desc['type'] == 'normal')) $this->description[$name]['defval'] = $this->{$name};
			
			//defval for linked fields (hasone!!)
			else if ($desc['type'] == 'link') 
			{
				list($table,$link) = explode($name,'-');
				if ($link == '') $link = 'nom';
																			
				$this->{$table}->get();
				$this->description[$name]['defval'] = $this->{$table}->{$link};
			}
		}	
	
	
		//build up Formfields !	
		foreach ($this->description as $name => $desc)
		{				
			//merge rules & format into params
			$desc['formfield']['format'] = $desc['format'];
			$desc['formfield']['rules'] = $desc['rules'];
			$desc['formfield']['value'] = $desc['defval'];
	
			//mode
			$fmode = $mode;
			if (isset($this->modes[$mode][$name])) $fmode = $this->modes[$mode][$name];
	
			//new Formfield !
			$this->formfields[$name] = new FormField($name,$desc['label'],$desc['formfield'],$fmode);
		}
	}
	
	function checkFields($mode=null) //appelle checkField() pour chaque champs, si les champs sont valides, peuple les attributs de l'objet avec ceux-ci.
	{
		if (is_null($mode)) $mode = $this->currentMode;
		if ((!is_array($this->formfields))||($mode != $this->currentMode)) $this->makeFields($mode);	
		
		//learn & add to validator	
		foreach ($this->description as $name => $desc) $this->formfields[$name]->checkField(); 
	
		//run validation && store in DMC the new values
		if ($this->form_validation->run()) 
		{
			//populate DMC attributes from normal && link fields	
			foreach ($this->description as $name => $desc)
			{
				if ($this->formfields[$name]->mode == 'form')
				{
					//value from a normal field
					if ((!isset($desc['type']))||($desc['type'] == 'normal')) $this->{$name} = $this->formfields[$name]->getRaw();
			
					//value from link field (update link !)
					else if ($desc['type'] == 'link') 
					{
						list($table) = explode($name,'-');
															
						$this->{$table}->get();
						$idrecieved = $this->formfields[$name]->getRaw();
						
						if ($idrecieved != $this->{$table}->id)
						{
							if ($idrecieved > 0)
							{
								$className = ucwords($table);
								$newLink =  new $className();
								$newLink->get_by_id($idrecieved);
								$this->{$table} = $newLink;
								
							}
							else $this->{$table} = null;
							
							$this->relationUpdated[] = $table;
						} 
					}
				}
			}
			
			//run afterCheck to customly use virtual fields
			$this->afterCheck();
			
			return true;
		}
		return false;
	}
	
	function saveAll()
	{
		$relations = array();
		
		foreach($this->relationUpdated as $table) 
		{
			

		}
	
		//TODO see if save function save relationships too !
		$this->save();
	}
	
	function display($template,$mode=null)
	{
		if (is_null($mode)) $mode = $this->currentMode;
		if ((!is_array($this->formfields))||($mode != $this->currentMode)) $this->makeFields($mode);
		
		foreach($this->formfields as $name=>$field) $data[$name] = $field->getUse();
		
		return $this->parser->parse(get_class($this).'/'.$template,$data,TRUE);
	}
	
	function beforeMake()
	{
		/* 
			Overwrited!
			describe here how to make default value for virtual fields !
		*/
	}
	
	function afterCheck()
	{
		/* 
			Overwrited!
			describe here how to fill real DB fields from virtual ones
		*/
	}
}
