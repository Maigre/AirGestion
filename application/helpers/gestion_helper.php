<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function calcul_age($date_naissance){

	list($y,$m,$d)=explode('-', $date_naissance);
	$age= date('Y')-$y;
	if (date('M')<$m) $age=$age-1;
	elseif ((date('M')==$m) and (date('D')<$d)) $age=$age-1;
	return $age;
}




/* End of file gestion_helper.php */
/* Location: ./application/helpers/gestion_helper.php */
