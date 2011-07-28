<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function histo_parse($sql)
{
	$parse = array();
	
	$sql = str_replace("\n"," ",$sql);	
	$parse['tree'] = explode(" ",$sql);
	
	$parse['type'] = $parse['tree'][0];
	
	switch ($parse['type'])
	{
		case 'INSERT' :
			if ($parse['tree'][1] == 'INTO') 
			{
				$parse['table'] = str_replace("`","",$parse['tree'][2]);
				
				$j = 3;
				$parse['fields'] = array();
				while ( isset($parse['tree'][$j]) AND ($parse['tree'][$j] != 'VALUES') )
				{
					$search = array("(",")",",","`");
					$replace = array("","","","");
					
					$parse['fields'][] = str_replace($search,$replace,$parse['tree'][$j]);
					$j++;
				}
				
				if ($j == 3) return false;
				
				if ($parse['tree'][$j] == 'VALUES')
				{
					$j++;
					$parse['values'] = array();
					while (isset($parse['tree'][$j]))
					{
						$search = array("(",")",",");
						$replace = array("","","");
									
						$parse['values'][] = str_replace($search,$replace,$parse['tree'][$j]);
						$j++;
					}
				}
				else return false;
			}
			else return false;
		break;
		
		case 'UPDATE' :
			$parse['table'] = str_replace("`","",$parse['tree'][1]);
			
			if ($parse['tree'][2] == 'SET')
			{
				$j = 3;
				$k = 1;
				$parse['sets'] = array();
				$arr = array();
				while ( isset($parse['tree'][$j]) AND ($parse['tree'][$j] != 'WHERE') )
				{
					$search = array("(",")",",","`");
					$replace = array("","","","");
					
					if ($k == 1) $arr['field'] = str_replace($search,$replace,$parse['tree'][$j]);
					else if ($k == 2) $arr['operator'] = str_replace($search,$replace,$parse['tree'][$j]);
					else 
					{						
						$arr['value'] = str_replace($search,$replace,$parse['tree'][$j]);
						$parse['sets'][] = $arr;
						$k = 0;
					}
					
					$k++;								
					$j++;
				}

				if ($k != 1) return false;
				
				if ($parse['tree'][$j] == 'WHERE')
				{
					$j++;
					$k = 1;
					$parse['where'] = array();
					$arr = array();
					while ( isset($parse['tree'][$j]) AND ($parse['tree'][$j] != 'WHERE') )
					{
						$search = array("(",")",",","`");
						$replace = array("","","","");
					
						if ($k == 0) $arr['preLink'] = $parse['tree'][$j];
						else if ($k == 1) $arr['field'] = str_replace($search,$replace,$parse['tree'][$j]);
						else if ($k == 2) $arr['operator'] = str_replace($search,$replace,$parse['tree'][$j]);
						else 
						{						
							$arr['value'] = str_replace($search,$replace,$parse['tree'][$j]);
							$parse['where'][] = $arr;
							$k = -1;
						}
					
						$k++;								
						$j++;
					}
					
					if ($k != 0) return false;
				}
				else return false;
			}
			else return false;
			
		break;
		
		case 'DELETE' :
			
			if ($parse['tree'][1] == 'FROM')
			{
				$parse['table'] = str_replace("`","",$parse['tree'][2]);
				
				//print_r($parse['tree']); die;
				
				if ($parse['tree'][3] == 'WHERE')
				{
					$j = 4;
					$k = 1;
					$parse['where'] = array();
					$arr = array();
					while ( isset($parse['tree'][$j]) AND ($parse['tree'][$j] != 'WHERE') )
					{
						$search = array("(",")",",","`");
						$replace = array("","","","");
				
						if ($k == 0) $arr['preLink'] = $parse['tree'][$j];
						else if ($k == 1) $arr['field'] = str_replace($search,$replace,$parse['tree'][$j]);
						else if ($k == 2) $arr['operator'] = str_replace($search,$replace,$parse['tree'][$j]);
						else 
						{						
							$arr['value'] = str_replace($search,$replace,$parse['tree'][$j]);
							$parse['where'][] = $arr;
							$k = -1;
						}
				
						$k++;								
						$j++;
					}
				
					if ($k != 0) return false;
				}
				else return false;
			}
			else return false;
			
		break;
		
		default: return true;
	}
	
	return $parse;
}

function histo_unparse($parse)
{
	if ($parse['table'] != '')
	{
		switch ($parse['type'])
		{
			case 'INSERT' :
		
				$sql = "INSERT INTO `".$parse['table']."` (";
			
				$ctrl = 0;	 
				foreach ($parse['fields'] as $field_name) 
				{
					if ($ctrl > 0) $sql .= ", ";
					$sql .= "`".$field_name."`";
					$ctrl++;
				}

			
				$ctrl = 0;
				$sql .= ") VALUES (";
					 
				foreach ($parse['values'] as $value) 
				{
					if ($ctrl > 0) $sql .= ", ";
					$sql .= $value;
					$ctrl++;
				}
			
				$sql .= ")";

			break;
		
			case 'UPDATE' :
			
				$sql = "UPDATE `".$parse['table']."` SET ";
			
				$ctrl = 0;	 
				foreach ($parse['sets'] as $set) 
				{
					if ($ctrl > 0) $sql .= ", ";
					$sql .= "`".$set['field']."` ".$set['operator']." ".$set['value'];
					$ctrl++;
				}
			
				$sql .= " WHERE (";
			
				$ctrl = 0;
				foreach ($parse['where'] as $where) 
				{
					if ($ctrl > 0) $sql .= " ".$where['preLink']." ";
					$sql .= "`".$where['field']."` ".$where['operator']." ".$where['value'];
					$ctrl++;
				}
			
				$sql .= ")";
			
			break;
		
			case 'DELETE' :
			
				$sql = "DELETE FROM `".$parse['table']."` WHERE (";
						
				$ctrl = 0;
				foreach ($parse['where'] as $where) 
				{
					if ($ctrl > 0) $sql .= " ".$where['preLink']." ";
					$sql .= "`".$where['field']."` ".$where['operator']." ".$where['value'];
					$ctrl++;
				}
			
				$sql .= ")";
			
			break;
	
			default: return false;
		}
	
		return $sql;
	}
	return false;
}


function histo_changeID(&$parse,$insert_table,$old_id,$new_id)
{
	if (($parse['type'] == "INSERT") and ($parse['table'] != $insert_table))
	{
		$field_search = substr($insert_table,0,-1).'_id';
		
		$fields_i = array_flip($parse['fields']);
		
		if (isset($fields_i[$field_search])) 
		{
			if (($parse['values'][$fields_i[$field_search]] == $old_id) or ($parse['values'][$fields_i[$field_search]] == "'".$old_id."'"))
											$parse['values'][$fields_i[$field_search]] = str_replace($old_id,$new_id,$parse['values'][$fields_i[$field_search]]);
		}
	}
	
	else if (($parse['type'] == "UPDATE") or ($parse['type'] == "DELETE"))
	{
		if ($parse['table'] != $insert_table) $field_search = substr($insert_table,0,-1).'_id';
		else $field_search = 'id';
				
		if ($parse['type'] == "UPDATE") $todo = array('sets','where');
		else if ($parse['type'] == "DELETE") $todo = array('where');
		
		foreach ($todo as $class)
		{
			foreach($parse[$class] as $i=>$set)
			{
				if ($set['field'] == $field_search)
				{
					if (($set['value'] == $old_id) or ($set['value'] == "'".$old_id."'"))
						$parse[$class][$i]['value'] = str_replace($old_id,$new_id,$set['value']);
				}
			}
		}
		
		
	}
}



