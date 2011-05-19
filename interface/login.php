<?php

session_start();
if (!isset($_SESSION['user'])) $_SESSION['user'] = null;

// want to know if a user is logged in
if ($_POST['action'] == 'log')
{
	if ($_SESSION['user'])
		echo "
			{
				success : true,
				user: \"".$_SESSION['user']."\"
			}
		";
	else
		echo "
			{
				success : false
			}
		";

}
//try to login ?
else if ($_POST['action'] == 'login')
{
	if (($_POST['password'] == 'pass') && (trim($_POST['login']) != ''))
	{
		$_SESSION['user'] = $_POST['login'];
		echo "
			{
				success : true,
				user : \"".$_SESSION['user']."\"
			}
			";
	}
	else 
		echo "
			{
				success : false,
				msg : \"Mauvais mot de passe !\"
			}
			";
}
//logout
else if ($_POST['action'] == 'logout')
{
	$_SESSION['user'] = null;

	if ($_SESSION['user'] == null)
		echo "
			{
				success : true
			}
			";
	else 
		echo "
			{
				success : false,
				user : \"".$_SESSION['user']."\"
			}
			";
}
else
		echo "
			{
				success : false,
				msg : \"No action selected !\"
			}
		";

?>
