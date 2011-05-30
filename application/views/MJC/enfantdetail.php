<script type="text/javascript">

var data<?=$run_adherent['numeroenfant']?> = {
       	/*datenaissance: '<?=$run_adherent['datenaissance']?>',
        fichesanitaire: '<?=$run_adherent['fichesanitaire']?>',
		email: '<?=$run_adherent['email']?>' ,
		telportable: '<?=$run_adherent['telportable']?>',
		teldomicile: '<?=$run_adherent['teldomicile']?>',*/
		sansviandesansporc: '<?php if ($run_adherent['sansviandesansporc']==1) echo 'SVSP';?>',
		autorisationsortie: '<?php if ($run_adherent['autorisationsortie']==1) echo 'OUI';else echo 'NON'?>',
		nosecu: '<?=$run_adherent['nosecu']?>'
    };

var panel<?=$run_adherent['numeroenfant']?> = Ext.getCmp('Info_Detail_enfant<?=$run_adherent['numeroenfant']?>-panel'),
tpl<?=$run_adherent['numeroenfant']?> = Ext.create('Ext.Template', 
                            /*'<p>Date de naissance: {datenaissance}</p>',
                            '<p>Fiche sanitaire: {fichesanitaire}</p>',
                            '<p>Email: {email}</p>',
                            '<p>Tel. portable: {telportable}</p>',
                            '<p>Tel. domicile: {teldomicile}</p>',*/
                            '<table class="tableau_membre">',
		                    '<TR><TDcolspan=2><b>{sansviandesansporc}</b></TD></TR>',
                            '<TR><TD>Autorisation de sortie </TD><TD>{autorisationsortie}</TD></TR>',
                            '<TR><TD>N° sécu</TD><TD>{nosecu}</TD></TR>',
                            '</table>'
                        );
tpl<?=$run_adherent['numeroenfant']?>.overwrite(panel<?=$run_adherent['numeroenfant']?>.body, data<?=$run_adherent['numeroenfant']?>);
panel<?=$run_adherent['numeroenfant']?>.doComponentLayout();


//Ext.getCmp('Info_General-panel').add(Window_Referent.get());

</script>
