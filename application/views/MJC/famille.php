<script type="text/javascript">
//affiche 1 fenêtre vide pour chaque membre de la famille
//et lui donne l'url pour se charger

width_value= 200,
height_value = 200,
margin =5,
Window_Referent = new PanelItem(),
Window_Conjoint = new PanelItem(),
Info_General_referent = new PanelItem(),
Info_Detail_referent = new PanelItem(),
Info_General_conjoint = new PanelItem(),
Info_Detail_conjoint = new PanelItem(),

Info_General_referent.panel = new Ext.Panel({
				id: 'Info_General_referent-panel',
				title: 'Informations Generales',
				iconCls: '<?php if ($referent['sexe']==0) echo 'user'; else echo 'user_female';?>',
				layout: 'auto',
				url: 'interface/c_adherent/display/<?=$referent['id']?>/1/0'
			});
Info_Detail_referent.panel = new Ext.Panel({
				id: 'Info_Detail_referent-panel',
				title: 'Détails',
				//iconCls: 'user',
				layout: 'auto',
				url: 'interface/c_adherent/display/<?=$referent['id']?>/1/0'
			});


Window_Referent.panel = new Ext.Panel({  
					x:margin,
					y:margin,
					height: height_value,
					width: width_value,
					title: 'Référent - <?=$referent['nom']?>',
					constrain: true,
					layout: 'accordion',
					items: [Info_General_referent.get(),Info_Detail_referent.get()]
			});

Ext.getCmp('<?=$win?>').add(Window_Referent.get());
//Window_Referent.panel.show();
Info_General_referent.load();
//Info_Detail_referent.load(),
//Window_Referent.load();

Info_General_conjoint.panel = new Ext.Panel({
				id: 'Info_General_conjoint-panel',
				title: 'Informations Generales',
				iconCls: '<?php if ($conjoint['sexe']==0) echo 'user'; else echo 'user_female';?>',
				layout: 'auto',
				url: 'interface/c_adherent/display/<?=$conjoint['id']?>/2/0'
			});
Info_Detail_conjoint.panel = new Ext.Panel({
				id: 'Info_Detail_conjoint-panel',
				title: 'Détails',
				layout: 'auto',
				url: 'interface/c_adherent/display/<?=$conjoint['id']?>/2/0'
			});

Window_Conjoint.panel = new Ext.Panel({  
					x: (width_value+2*margin),
					y: margin,
					height: height_value,
					width: width_value,
					title: 'Conjoint - <?=$conjoint['nom']?>',
					constrain: true,
					layout: 'accordion',
					items: [Info_General_conjoint.get(),Info_Detail_conjoint.get()]
			});

Ext.getCmp('<?=$win?>').add(Window_Conjoint.get());
//Window_Conjoint.panel.show();
Info_General_conjoint.load();
//Info_Detail_conjoint.load(),
//Window_Conjoint.load();

<?php foreach ($enfants as $numero=>$enfant){?>
	
	Info_General_enfant<?=$numero?> = new PanelItem(),
	Info_Detail_enfant<?=$numero?> = new PanelItem(),
	Info_General_enfant<?=$numero?>.panel = new Ext.Panel({
				id: 'Info_General_enfant<?=$numero?>-panel',
				title: 'Informations Generales',
				iconCls: '<?php if ($enfant['sexe']==0) echo 'user'; else echo 'user_female';?>',
				//html: 'Menu Adherents...',
				layout: 'auto',
				url: 'interface/c_adherent/display/<?=$enfant['id']?>/3/<?=$numero?>'
			});
	Info_Detail_enfant<?=$numero?>.panel = new Ext.Panel({
				title: 'Détails',
				id: 'Info_Detail_enfant<?=$numero?>-panel',
				//html: 'Menu Adherents...',
				layout: 'auto',
				url: 'interface/c_adherent/display/<?=$enfant['id']?>/3/<?=$numero?>'
			});
	Window_Enfant<?=$numero?> = new PanelItem();
	Window_Enfant<?=$numero?>.panel = new Ext.Panel({  
						title: 'Enfant <?=$numero?> - <?=$enfant['nom']?>',
						x: (margin+<?=$numero?>*(width_value+margin)),
						y: (2*margin+height_value),
						height: height_value,
						width: width_value,
						constrain: true,
						layout: 'accordion',
						items: [Info_General_enfant<?=$numero?>.get(),Info_Detail_enfant<?=$numero?>.get()]
				});
	
	Ext.getCmp('<?=$win?>').add(Window_Enfant<?=$numero?>.get());
	//Window_Enfant<?=$numero?>.panel.show();
	Info_General_enfant<?=$numero?>.load();
//	Info_Detail_enfant<?=$numero?>.load(),
<?php } ?>  
Ext.getCmp('<?=$win?>').doLayout();
</script>
