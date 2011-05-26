<script type="text/javascript">

var data_conjoint = {
        datenaissance: '<?=$run_adherent['datenaissance']?>',
		email: '<?=$run_adherent['email']?>' ,
		telportable: '<?=$run_adherent['telportable']?>',
		teldomicile: '<?=$run_adherent['teldomicile']?>',
		telprofessionel: '<?=$run_adherent['telprofessionel']?>',
		sansviandesansporc: '<?=$run_adherent['sansviandesansporc']?>'/*,
		allocataire: '<?=$run_adherent['allocataire']?>',
		employeur: '<?=$run_adherent['employeur']?>',
		noallocataire: '<?=$run_adherent['noallocataire']?>',
		nosecu: '<?=$run_adherent['nosecu']?>',
		csp: '<?=$run_adherent['csp']?>',
		situationfamiliale: '<?=$run_adherent['situationfamiliale']?>'*/
    };



var panel_conjoint = Ext.getCmp('Info_General_conjoint-panel'),
tpl_conjoint = Ext.create('Ext.Template', 
                            '<p>Date de naissance: {datenaissance:date("d M Y")}</p>',
                            '<p>Email: {email}</p>',
                            '<p>Tel. portable: {telportable}</p>',
                            '<p>Tel. domicile: {teldomicile}</p>',
                            '<p>Tel. professionel: {telprofessionel}</p>',
                            '<p>Sans viande sans porc: {sansviandesansporc}</p>'/*,
                            '<p>Allocataire: {allocataire}</p>',
                            '<p>Employeur: {employeur}</p>',
                            '<p>N° allocataire: {noallocataire}</p>',
                            '<p>N° sécu: {nosecu}</p>',
                            '<p>CSP: {csp}</p>',
                            '<p>Situation familiale: {situationfamiliale}</p>'*/
                        );
tpl_conjoint.overwrite(panel_conjoint.body, data_conjoint);
panel_conjoint.doComponentLayout();


//Ext.getCmp('Info_General-panel').add(Window_Referent.get());

</script>
