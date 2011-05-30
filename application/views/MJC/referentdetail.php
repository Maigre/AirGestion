<script type="text/javascript">

var data_referent = {
        /*datenaissance: '<?=$run_adherent['datenaissance']?>',
		email: '<?=$run_adherent['email']?>' ,
		telportable: '<?=$run_adherent['telportable']?>',
		teldomicile: '<?=$run_adherent['teldomicile']?>',
		telprofessionel: '<?=$run_adherent['telprofessionel']?>',*/
		sansviandesansporc: '<?php if ($run_adherent['sansviandesansporc']==1) echo 'SVSP';?>',
		allocataire: '<?=$run_adherent['allocataire']?>',
		employeur: '<?=$run_adherent['employeur']?>',
		noallocataire: '<?=$run_adherent['noallocataire']?>',
		nosecu: '<?=$run_adherent['nosecu']?>',
		csp: '<?=$run_adherent['csp']?>',
		situationfamiliale: '<?=$run_adherent['situationfamiliale']?>'
    };


var panel_referent = Ext.getCmp('Info_Detail_referent-panel'),
tpl_referent = Ext.create('Ext.Template', 
                            /*'<p>Date de naissance: {datenaissance}</p>',
                            '<p>Email: {email}</p>',
                            '<p>Tel. portable: {telportable}</p>',
                            '<p>Tel. domicile: {teldomicile}</p>',
                            '<p>Tel. professionel: {telprofessionel}</p>',
                            '<p>Sans viande sans porc: {sansviandesansporc}</p>',*/
                            '<table class="tableau_membre">',
				                '<TR><TDcolspan=2><b>{sansviandesansporc}</b></TD></TR>',
		                        '<TR><TD>Allocataire</TD><TD>{allocataire}</TD></TR>',
		                        '<TR><TD>Employeur</TD><TD>{employeur}</TD></TR>',
		                        '<TR><TD>N° allocataire</TD><TD>{noallocataire}</TD></TR>',
		                        '<TR><TD>N° sécu</TD><TD>{nosecu}</TD></TR>',
		                        '<TR><TD>CSP</TD><TD>{csp}</TD></TR>',
		                        '<TR><TD>Situation familiale</TD><TD>{situationfamiliale}</TD></TR>',
                            '</table>'
                        );
tpl_referent.overwrite(panel_referent.body, data_referent);
panel_referent.doComponentLayout();


//Ext.getCmp('Info_General-panel').add(Window_Referent.get());

</script>
