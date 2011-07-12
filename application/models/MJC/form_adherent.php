<?php

// Get adherent with his name

$this->load->model('MJC/adherent','run_adherent');
$u = $this->run_adherent;
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$array = array('nom' => $nom, 'prenom' => $prenom);
$u->where($array)->get();

// Change fields value
// Fetching Form Values
$u->sexe = $_POST['sexe'];
$u->datenaissance = $_POST['datenaissance'];
$u->fichesanitaire = $_POST['fichesanitaire'];
$u->email = $_POST['email'];
$u->telportable = $_POST['telportable'];
$u->teldomicile = $_POST['teldomicile'];
$u->telprofessionel = $_POST['telprofessionel'];
$u->sansviandesansporc = $_POST['sansviandesansporc'];
$u->autorisationsortie = $_POST['autorisationsortie'];
$u->allocataire = $_POST['allocataire'];
$u->employeur = $_POST['employeur'];
$u->noallocataire = $_POST['noallocataire'];
$u->nosecu = $_POST['nosecu'];

$csp = new Csp();
$csp->where('nom', $_POST['csp'])->get();


// Save changes to existing user
$u->save(array($csp)); 

// Storing data in database

// Generating appropriate server response

?>


