<script type="text/javascript">

var data<?=$run_adherent['numeroenfant']?> = {
        datenaissance: '<?=$run_adherent['datenaissance']?>',
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
                            '<p>Date de naissance: {datenaissance:date("d M Y")}</p>',
                            '<p>Fiche sanitaire: {fichesanitaire}</p>',
                            '<p>Email: {email}</p>',
                            '<p>Tel. portable: {telportable}</p>',
                            '<p>Tel. domicile: {teldomicile}</p>'/*,
                            '<p>Sans viande sans porc: {sansviandesansporc}</p>',
                            '<p>Autorisation de sortie: {autorisationsortie}</p>',
                            '<p>N° sécu: {nosecu}</p>',
                            '<p>Situation familiale: {situationfamiliale}</p>'*/
                        );
tpl<?=$run_adherent['numeroenfant']?>.overwrite(panel<?=$run_adherent['numeroenfant']?>.body, data<?=$run_adherent['numeroenfant']?>);
panel<?=$run_adherent['numeroenfant']?>.doComponentLayout();


//Ext.getCmp('Info_General-panel').add(Window_Referent.get());

</script>
