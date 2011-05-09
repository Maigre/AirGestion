<?php

class DataMapperCustom extends DataMapper {
	
	protected $description;
	protected $templates;
	protected $modes;
	
	private $display;

	function __construct()
	{
		//create validation from description
		build_validation();
		$this->display = new FormAndDisplayModel($this->description,$this->templates,$this->modes);
		
		//build_fields();
		
		parent::DataMapper();
	}
	
	function build_validation() //crée la variable $validation, nécessaire à datamapper pour effectuer la validation des champs
	{
		foreach ($this->description as $name=>$details)
			$this->validation[] = array(
							'field' => $name,
							'label' => $details['label'],
							//'rules' => array_merge($details['rules'])
						);
	}
	
	function checkfields() //appelle checkfields() de l'objet et si les champs sont valides, peuple les attributs de l'objet avec ceux-ci.
	{
		if ($data = $this->display->checkfields())
		{
			foreach($data as $name=>$value)
				$this->{$name} = $value;
				
			return true;
		}
		else return false;
	}
	
	/*
	function build_fields()
	{
		foreach ($this->description as $name=>$details)
			$this->fields[$name] = new FormFields($name,$details['formfields'],$details['label'],$details['format']);
	}
	
	function _unformat($name)
	{
		$this->fields[$name]->unformat();
	}
	*/
}