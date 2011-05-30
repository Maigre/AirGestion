<script type="text/javascript">

var data_conjoint = {
        nom: '<?=$run_adherent['nom']?>',
        prenom: '<?=$run_adherent['prenom']?>'
    };



var panel_conjoint = Ext.getCmp('Info_General_conjoint-panel'),
tpl_conjoint = Ext.create('Ext.Template', 
                            '<p>Nom: {nom}</p>',
                            '<p>Prenom: {prenom}</p>'
                        );
tpl_conjoint.overwrite(panel_conjoint.body, data_conjoint);
panel_conjoint.doComponentLayout();


//Ext.getCmp('Info_General-panel').add(Window_Referent.get());

</script>
