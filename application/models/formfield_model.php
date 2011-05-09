<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Formfield
{
	private $name;
	private $label;
	private $raw_value;  //valeur brut (SQL side)
	private $use_value; //valeur formattée (USER side)
	
	private $type;
	private $params;
	private $format;
	private $rules;
	
	private $mode; //display, print, form
	
	//construct by passing name, RAW value, params (type, js, format, label)
	function Formfield($name,$label,$value,$params,$mode=null)
	{
		$this->name = $name;
		$this->label = $label;
		$this->raw_value = $value;
		
		$this->set_type($params);
		if ($mode) $this->set_mode($mode);
	}
	
	//set mode
	function set_mode($mode)
	{
		$this->mode = $mode;	
	}
	
	//set type and formatting
	private function set_type($params)
	{		
		$this->format = null;
		
		$this->type = $params[0];
		$this->params = $params;
		$this->add_format($params['format']);
		$this->add_rules($params['rules']);						
		
		//add auto formatting rules !!
		switch($this->type)
		{
			case 'date':
				$this->add_format('date');
			break;
			
			//QCM (checkbox) avec eventuellement champ 'autre' stocké sous forme de chaine de texte Option1|Option4|Truc(Autre)
			case 'mlist_text':
			case 'mlist_text_autre':
				$this->add_format('mlist_text');
			break;
			
			case 'check':
			case 'yesno':
				$this->add_format('check');
			break;
			
			case 'check1':
				$this->add_format('check1');
			break;
			
			case 'textarea':
				$this->add_format('n_to_br');
			break;
			
			case 'flag':
				$this->add_format('flag');
			break;
			
			
			/*OBSOLETE
			case 'id_select':
			case 'id_select_0':
			case 'id_select_E':
				$this->add_format('idlist');
			break;
			
			case 'mlist_id':
				$this->add_format('mlist_id');
			break;
			*/
		}	
		
		$this->raw_to_use();
			
		return $this;
	}
	
	//make use_value from raw_value
	function raw_to_use() 
	{
		//cook use_value : apply formatting rules :
		$this->use_value = $this->format($this->raw_value,'format',$this->mode);	
	}
	
	//make raw_value from use_value
	function use_to_raw() 
	{
		//cook raw_value : unapply formatting rules
		$this->raw_value = $this->format($this->use_value,'unformat',$this->mode);	
	}
	
	//recupere la valeur postée pour ce champs (repopulate)
	function learn()  
	{
		$this->use_value = $this->input->post($this->name);
	}
	
	//add this field to the validator engine
	function add_to_validator()
	{
		if ($this->rules != '')
			$this->form_validation->set_rules($this->name,$this->label,$this->rules);
	}
	
	// Get data RAW to save it !
	function get_raw()
	{
		$this->use_to_raw();
		return $this->raw_value;
	}
	
	// Get data to USE it ! (HTML style)		
	function get_use()
	{		
		if ($this->mode == 'form') return $this->cook_field();
		else if ($this->mode == 'hide') return '';
		else return $this->use_value;
	}
	
	//Construit le champs formulaire au format HTML en fonction des parametres et valeurs par defaut envoyée
	function cook_field()
	{	
		$params = $this->params;
		
		$data['name'] = $this->name;
		
		if (form_error($this->name)!= '') $params['js'] .= ' style="background-color:#FEE;border: 2px solid red;"';

		switch ($this->type)
		{
			case 'text':
				if ($params[1]) $data['size'] = $params[1];
				$field = form_input($data,$this->value,$params['js']);
			break;
			
			case 'date':
				if ($params[1]) $data['size'] = $params[1];
				else $data['size'] = 8;
				$field = form_input($data,$this->value,$params['js']);
			break;
			
			case 'hidden':
				$field = form_hidden($this->name,$this->value);
			break;
			
			case 'check':
				if ($this->value == 1) $val = true;
				else $val = false;
				$field = form_checkbox($data,1,$val,$params['js']);
			break;
			
			case 'yesno':
				$ye = false;
				$no = false;
				if ($this->value == 1) $ye = 1;
				else if (($this->value == 0)&&(!is_null($this->value))) $no = 1;
				$field = form_radio($data,1,$ye,$params['js']).'oui '.form_radio($data,0,$no,$params['js']).'non ';
			break;
			
			case 'radio':
				$field = form_radio($data,$params[1],$this->value,$params['js']);
			break;
			
			case 'nbr_list10':
				$arr = array(1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9,10=>10);
				$field = form_dropdown($this->name,$arr,$this->value,$params['js']);
			break;
			
			case 'select':
				if (!is_array($params[1])) $params[1] = array();
				$field = form_dropdown($this->name,$params[1],$this->value,$params['js']);
			break;
			
			
			//A REVOIR//
			case 't_select_AE':
				$options['*autre'] = 'Autre';
			case 't_select_E':
				$options = array(' '=>' ');
			case 't_select':
				$table = $this->name;
				if (($params[2])&&($params[2]!='v')&&($params[2]!='h')) $table = $params[2];
			
				//$obj =& get_instance();
				//$obj->load->model('List_model','lister');
		
				foreach($obj->lister->get($table) as $i=>$v) $options[$v] = $v;
				
				$js = 'onChange="if (this.value == \'*autre\') show(\''.$this->name.'_autre\'); else hide(\''.$this->name.'_autre\');"';
				
				if ((!in_array($this->value,$options))&&($this->value != '')) {$defAutre = $this->value; $this->value = '*autre';}
				else $defAutre = '';
			
				$field = form_dropdown($this->name,$options,$this->value,$js);
			
				$data = array(
					'name' => $this->name.'_autre',
					'id'	=> $this->name.'_autre'
					);
				
				if ($params[1]) $data['size'] = $params[1];
				if ($defAutre == '') $data['style'] = "display:none;"; 
				if ($params[2] == 'v') $field .= '<br />';
			
				$field .= form_input($data,$defAutre,$params['js']);
			break;
			
			/*OBSOLETE ?*/
			case 'id_select':
			case 'id_select_E':
			case 'id_select_0':
				if ($params[1]) $nt = $params[1];
				else $nt = $this->name;
			
				$table = explode('id',$nt);
				if ($table[1] != '')
				{
					$obj =& get_instance();
					$obj->load->model('List_model','lister');
				
					$options = array();
				
					if ($type == 'id_select_E') $options[' '] = ' ';
					if ($type == 'id_select_0') $options[0] = ' ';
				
					foreach($obj->lister->get($table[1]) as $i=>$v) $options[$i] = $v;
				
					$field = form_dropdown($this->name,$options,$this->value,$params['js']);
				}
			break;
			
			case 'mlist_text':
			case 'mlist_text_autre':
			case 'mlist_id':
				$type2 = explode('_',$type);
			
				$table = $this->name;
				if ($table != '')
				{
					$defA = explode('|',$this->value);
				
					$obj =& get_instance();
					$obj->load->model('List_model','lister');
				
					$options = array();
					$options = $obj->lister->get($table);
								
								
					$field .= '<table cellspacing="0" class="clean"><tr>';
					foreach ($options as $id=>$nom)
					{
						if ($type2[1] == 'text') $value = $nom;
						else if ($type2[1] == 'id') $value = $id;
					
						if (in_array($value,$defA)) {$check = true; foreach($defA as $k=>$v) if ($v == $value) unset($defA[$k]);}
						else $check = false;
					
						 $field .= '<td>'.form_checkbox($this->name.'[]',$value,$check,$params['js']).'</td><td>'.$nom.'</td>';
					}
				
					if ($type2[2] == 'autre') 
					{					
						$value = '';
						foreach($defA as $v) 
						{
							if ((trim($v) != '')&&(!in_array($v,$options))) 
							{	
								if ($value != '') $value.=', '; 
								$value .= $v;
							}
						}
					
					 	$field .= '<td> &nbsp;&nbsp;/&nbsp;&nbsp; Autre : </td><td>'.form_input($this->name.'[Autre]',$value,$params['js']).'</td>';
					}
				
					$field .= '</tr></table>';
				}
			break;
			
			case 'textarea':
				if ($params[1]) $data['rows'] = $params[1];
				if ($params[2]) $data['cols'] = $params[2];
				$field = form_textarea($data,$this->value,$params['js']);
			break;
			
			case 'submit':
				if (!$this->label) $this->label = 'Envoyer';
				$todo = ''; $bef = '';
			
				if ($params['js']) 
				{
					$bef = "var reponse = prompt('".$params[2]."','');";
					$test = "reponse != false";
					$todo = "this.form.".$params['js'].".value = reponse;";
				}
				else if ($params[2]) $test = "confirm('".$params[2]."')";
				else $test = true;
			
				$js = 'onClick="'.$bef.' if('.$test.') {'.$todo.'this.form.elements[0].value = \''.$params[1].'\'; this.form.submit();} return false;"';
			
				$field = form_button($this->name,$this->label,$js);
			break;
			
			case 'submitIMG':
				if (!$this->label) $this->label = 'Envoyer';
				$todo = ''; $bef = '';
			
				if ($params['js']) 
				{
					$bef = "var reponse = prompt('".$params[2]."','');";
					$test = "reponse != false";
					$todo = "this.form.".$params['js'].".value = reponse;";
				}
				else if ($params[2]) $test = "confirm('".$params[2]."')";
				else $test = true;
			
			
				$js = 'onClick="'.$bef.' if('.$test.') {'.$todo.'this.form.elements[0].value = \''.$params[1].'\'; this.form.submit();} return false;"';
			
				$field = form_button($this->name,'<img src="'.base_url().'/images/icons/selection/'.$this->label.'.png" />',$js);
			break;
		}
		
		return form_error($this->name,'<div style="padding:0;margin:0;color:red";>','</div>').$field;
	}
	
	function add_rule($rule,$force=false) //regle de verification
	{
		if ($this->rules == '') $this->rules = $rule;
		else 
		{
			$rul = explode('|',$rule);
			$for = explode('|',$this->rules);
			foreach ($rul as $r) if ((!in_array($r,$for))||($force)) $this->rules .= '|'.$r;
		}
		
		return $this;
	}
	
	function rem_rule($rule)
	{
		if($this->rules == $rule) $this->rules = '';
		else 
		{
			str_replace($rule.'|','',$this->rules);
			str_replace('|'.$rule,'',$this->rules);
		}
	}
	
	function add_format($rule,$force=false) //regle de formatage
	{
		if ($this->format == '') $this->format = $rule;
		else 
		{
			$rul = explode('|',$rule);
			$for = explode('|',$this->format);
			foreach ($rul as $r) if ((!in_array($r,$for))||($force)) $this->format .= '|'.$r;
		}
	}
	
	function format($val,$way) 
	{
		$rules = explode('|',$this->format);
		
		foreach($rules as $rul) if ($rul != '') $val = $this->{'f_'.$rul}($val,$way);
		
		return $val;
	}
}
