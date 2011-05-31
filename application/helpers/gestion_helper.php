<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function calcul_age($date_naissance){

	list($y,$m,$d)=explode('-', $date_naissance);
	$age= date('Y')-$y;
	if (date('M')<$m) $age=$age-1;
	elseif ((date('M')==$m) and (date('D')<$d)) $age=$age-1;
	return $age;
}

function date_disp($dateSQL){
	
	$date = strtotime($dateSQL);
	if ($date>0) return date('d/m/y',$date);
	else return null;
}

function icon($class){
	return '<img class="x-panel-header-icon '.$class.'" src="interface/ext4/resources/s.gif" alt="" />';
}

/* End of file gestion_helper.php */
/* Location: ./application/helpers/gestion_helper.php */
