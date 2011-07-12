<script type="text/javascript">

MainApp.Content = {
	
	Info_Panel : new PanelItem(),
	
	make_info : function () {
		
		this.Info_Panel.panel = new Ext.Panel({  
						id: 'Info_Famille-panel',
						bodyStyle: 'padding:5px',
						border: 0,
						html: '<table class="tableau_membre">'+
		                        '<TR><TD>Adresse</TD><TD><?=(isset($famille->adresse1))?$famille->adresse1:''?></TD></TR>'+
		                        '<TR><TD></TD><TD><?=(isset($famille->adresse2))?$famille->adresse2:''?></TD></TR>'+
		                        '<TR><TD>Code Postal</TD><TD><?=(isset($famille->codepostal))?$famille->codepostal:''?></TD></TR>'+
		                        '<TR><TD>Ville</TD><TD><?=(isset($famille->ville))?$famille->ville:''?></TD></TR>'+
		                        '<TR><TD colspan="2"><hr></TD></TR>'+
		                        '<TR><TD>Extérieur</TD><TD><?=(isset($famille->exterieur))?(($famille->exterieur==1)?'OUI':'NON'):''?></TD></TR>'+
		                        '<TR><TD>Q.F</TD><TD><?=(isset($famille->qf))?$famille->qf:''?></TD></TR>'+
		                        '<TR><TD>CCAS</TD><TD><?=(isset($famille->ccas))?$famille->ccas:''?></TD></TR>'+
			                    '<TR><TD>Bons Vacances</TD><TD><?=(isset($famille->bonvacance))?(($famille->bonvacance==1)?'OUI':'NON'):''?></TD></TR>'+
			                    '<TR><TD>Groupe</TD><TD><?=(isset($famille->groupe->nom))?$famille->groupe->nom:''?></TD></TR>'+
			           		'</table>'
                     });
        
        Ext.getCmp('<?=$win?>').removeAll();             
		Ext.getCmp('<?=$win?>').add(this.Info_Panel.get());
		Ext.getCmp('<?=$win?>').setTitle('Info Famille');
	}
}
MainApp.Content.make_info();
</script>

