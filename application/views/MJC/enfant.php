<script type="text/javascript">

var data<?=$run_adherent['numeroenfant']?> = {
        datenaissance: '<?=$run_adherent['datenaissance']?>',
        age: '<?=calcul_age($run_adherent['datenaissance'])?>',
        fichesanitaire: '<?=$run_adherent['fichesanitaire']?>',
		email: '<?=$run_adherent['email']?>' ,
		telportable: '<?=$run_adherent['telportable']?>',
		teldomicile: '<?=$run_adherent['teldomicile']?>'/*,
		sansviandesansporc: '<?=$run_adherent['sansviandesansporc']?>',
		autorisationsortie: '<?=$run_adherent['autorisationsortie']?>',
		nosecu: '<?=$run_adherent['nosecu']?>',
		situationfamiliale: '<?=$run_adherent['situationfamiliale']?>'*/
    };



var panel<?=$run_adherent['numeroenfant']?> = Ext.getCmp('Info_General_enfant<?=$run_adherent['numeroenfant']?>-panel'),
tpl<?=$run_adherent['numeroenfant']?> = Ext.create('Ext.Template', 
                            '<table class="tableau_membre">',
		                        '<TR><TD><b>{age} ans</b></TD><TD>{datenaissance:date("d/m/y")}</TD></TR>',
		                        '<TR><TD>Email</TD><TD>{email}</TD></TR>',
		                        '<TR><TD>Tel. portable</TD><TD>{telportable}</TD></TR>',
		                        '<TR><TD>Tel. domicile</TD><TD>{teldomicile}</TD></TR>',
		                        '<TR><TD>Fiche sanitaire</TD><TD>{fichesanitaire}</TD></TR>',
                            '</table>'/*,
                            '<p>Sans viande sans porc: {sansviandesansporc}</p>',
                            '<p>Autorisation de sortie: {autorisationsortie}</p>',
                            '<p>N° sécu: {nosecu}</p>',
                            '<p>Situation familiale: {situationfamiliale}</p>'*/
                        );
tpl<?=$run_adherent['numeroenfant']?>.overwrite(panel<?=$run_adherent['numeroenfant']?>.body, data<?=$run_adherent['numeroenfant']?>);
panel<?=$run_adherent['numeroenfant']?>.doComponentLayout();


//Ext.getCmp('Info_General-panel').add(Window_Referent.get());

</script>
