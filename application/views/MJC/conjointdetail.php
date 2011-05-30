<script type="text/javascript">

var data_conjoint = {
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



var panel_conjoint = Ext.getCmp('Info_Detail_conjoint-panel'),
tpl_conjoint = Ext.create('Ext.Template', 
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
tpl_conjoint.overwrite(panel_conjoint.body, data_conjoint);
panel_conjoint.doComponentLayout();


//Ext.getCmp('Info_General-panel').add(Window_Referent.get());

</script>
