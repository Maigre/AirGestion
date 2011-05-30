<script type="text/javascript">

var data<?=$run_adherent['numeroenfant']?> = {
        nom: '<?=$run_adherent['nom']?>',
        prenom: '<?=$run_adherent['prenom']?>'
    };



var panel<?=$run_adherent['numeroenfant']?> = Ext.getCmp('Info_General_enfant<?=$run_adherent['numeroenfant']?>-panel'),
tpl<?=$run_adherent['numeroenfant']?> = Ext.create('Ext.Template', 
                            '<p>Nom: {nom}</p>',
                            '<p>Prenom: {prenom}</p>'
                        );
tpl<?=$run_adherent['numeroenfant']?>.overwrite(panel<?=$run_adherent['numeroenfant']?>.body, data<?=$run_adherent['numeroenfant']?>);
panel<?=$run_adherent['numeroenfant']?>.doComponentLayout();


//Ext.getCmp('Info_General-panel').add(Window_Referent.get());

</script>
