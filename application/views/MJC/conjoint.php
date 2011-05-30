<script type="text/javascript">

var data_conjoint = {
        datenaissance: '<?=$run_adherent['datenaissance']?>',
        age: '<?=calcul_age($run_adherent['datenaissance'])?>',
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
                            '<table class="tableau_membre">',
		                        '<TR><TD><b>{age} ans</b></TD><TD>{datenaissance:date("d/m/y")}</TD></TR>',
		                        '<TR><TD>Email</TD><TD>{email}</TD></TR>',
		                        '<TR><TD>Tel. portable</TD><TD>{telportable}</TD></TR>',
		                        '<TR><TD>Tel. domicile</TD><TD>{teldomicile}</TD></TR>',
		                        '<TR><TD>Tel. professionel</TD><TD>{telprofessionel}</TD></TR>',
                            '</table>'/*,
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
