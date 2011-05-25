<script type="text/javascript">

var data_referent = {
        nom: '<?=$run_adherent['nom']?>',
        prenom: '<?=$run_adherent['prenom']?>'
    };


var panel_referent = Ext.getCmp('Info_General_referent-panel'),
tpl_referent = Ext.create('Ext.Template', 
                            '<p>Nom: {nom}</p>',
                            '<p>Prenom: {prenom}</p>'
                        );
tpl_referent.overwrite(panel_referent.body, data_referent);
panel_referent.doComponentLayout();


//Ext.getCmp('Info_General-panel').add(Window_Referent.get());

</script>
