<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


//FORMATTING RULES 
/*
$val 	-> valeur à transformer
$way 	-> format (to use) or unformat (to save)
$mode 	-> display, print, form
*/

//AFFICHAGE DE DRAPEAUX
function f_flag($val,$way,$mode)
{
	if($way == 'format') 
	{
		if($mode == 'display')
		{
			if ($val == 1) return '<img src="'.base_url().'images/icons/selection/flag_red.png" />';
			elseif ($val == 2) return '<img src="'.base_url().'images/icons/selection/flag_orange.png" />';
			elseif ($val == 3) return '<img src="'.base_url().'images/icons/selection/flag_green.png" />';
			else return '<img src="'.base_url().'images/icons/selection/flag_blue.png" />';
		}
		
		if($mode == 'print')
		{
			if ($val == 1) return '<img src="'.base_url().'images/icons/selection/flag_red.png" width="3.5mm" height="auto" />';
			elseif ($val == 2) return '<img src="'.base_url().'images/icons/selection/flag_orange.png" width="3.5mm" height="auto" />';
			elseif ($val == 3) return '<img src="'.base_url().'images/icons/selection/flag_green.png" width="3.5mm" height="auto" />';
			else return '<img src="'.base_url().'images/icons/selection/flag_blue.png" width="3.5mm" height="auto" />';
		}
	}
		
	else if($way == 'unformat');
	
	return $val;
}

//AFFICHAGE DE X ROUGE OU V VERT
function f_check($val,$way,$mode)
{
	if($way == 'format') 
	{
		if($mode == 'display')
		{
			if ($val == 1) return '<img src="'.base_url().'/images/icons/selection/valid.png" />';
			else return '<img src="'.base_url().'/images/icons/selection/invalid.png" />';
		}
		else if($mode == 'print')
		{
			if ($val == 1) return '<img src="'.base_url().'/images/icons/selection/valid.png" width="3.5mm" height="auto" />';
			else return '<img src="'.base_url().'/images/icons/selection/invalid.png" width="3.5mm" height="auto" />';
		}
		else if($mode == 'form')
		{
			if ($val == 1) return true;
			else return false;
		}
	}
		
	else if($way == 'unformat');
	
	return $val;
}

//AFFICHAGE V VERT SEULEMENT
function f_check1($val,$way,$mode)
{
	if($way == 'format') 
	{
		if($mode == 'display')
		{
			if ($val == 1) return '<img src="'.base_url().'/images/icons/selection/valid.png" />';
			else return '';
		}
		else if($mode == 'print')
		{
			if ($val == 1) return '<img src="'.base_url().'/images/icons/selection/valid.png" width="3.5mm" height="auto" />';
			else return '';
		}
		else if($mode == 'form')
		{
			if ($val == 1) return true;
			else return false;
		}
	}
		
	else if($way == 'unformat');
	
	return $val;
}

//Gestion date dd/mm/yyyy <=> yyyy-mm-dd
function f_date($val,$way,$mode)
{
	if ($val)
	{
		if($way == 'format') 
		{	
			if (strtotime($val) > 0) $val = date('d/m/Y',strtotime($val));
			else $val = null;
		}	
		else if($way == 'unformat') 
		{
			list($d,$m,$y) = explode('/',$val);
			if (strtotime($y.'-'.$m.'-'.$d) > 0) $val = date('Y-m-d',strtotime($y.'-'.$m.'-'.$d));
			else $val = null;
		}
	}
		
	return $val;
}

//replace \n with <br /> for html display
function f_n_to_br($val,$way,$mode)
{
	if($way == 'format') 
		if(($mode == 'display')||($mode == 'print')) $val = str_replace("\n",'<br />',$val);
		
	return $val;
}


//affichce une liste de la forme
function f_array($val,$way,$mode)
{
	if($way == 'format')
	{
		$ret = '';
		if(!is_array($val)) $val = explode('|',$val); 
		foreach($val as $v) 
		{
			if ($ret!='') $ret .= ', ';
			$ret .= $v;
		}
		$val = $ret;
	}
	else if (($way == 'unformat')&&(is_array($val)))
	{
		$ret = '';
		foreach($val as $key=>$v)
		{
			if (trim($v) != '')
			{
				if ($ret!='') $ret.= '|';
				$ret.=$v;
			}
		}
		$val = $ret;
	}
	
	return $val;
}


//transforme un id etranger en texte
/* OBSOLETE : plus aucune clé étrangère directe...
function f_idlist($val,$way,$mode)
{
	if((($mode == 'display')||($mode == 'print'))&&($way == 'format')) 
	{
		if ($params[1]) $nt = $params[1];
		else $nt = $this->name;
		
		list ($g,$table) = explode('id',$nt);
		
		if (($table != '')&&(is_numeric($val)))
		{
			$obj =& get_instance();
			
			$obj->db->select('Nom');
			$obj->db->where($nt, $val);
			$obj->db->limit(1);
			$query = $obj->db->get($table);
			
			if ($query->num_rows() > 0)
			{
				$row = $query->row();
				return $row->Nom;
			}
		}
	}	
	
	return $val;
}

function f_mlist_id($val,$way,$mode)
{
	if((($mode == 'display')||($mode == 'print'))&&($way = 'format')) 
	{
		$table = $this->name;			
		if ($table != '')
		{
			$ret = array();
			$val = explode('|',$val);
			$obj =& get_instance();
			
			foreach($val as $v)
			{
				$obj->db->select('Nom');
				$obj->db->where('id'.$this->name, $v);
				$obj->db->limit(1);
				$query = $obj->db->get($table);
				
				if ($query->num_rows() > 0)
				{
					$row = $query->row();
					$ret[] = $row->Nom;
				}
			}
			
			$val = $this->f_array($ret,'format');
		}
	}	
	else if ($way = 'unformat') $val = $this->f_array($val,'unformat');

	
	return $val;
}

*/
*/
