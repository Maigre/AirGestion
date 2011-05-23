<script type="text/javascript">
//affiche 1 fenêtre vide pour chaque membre de la famille
//et lui donne l'url pour se charger

width_value= 150,
height_value = 150,
margin =5,
Window_Referent = new PanelItem(),

Window_Referent.panel = new Ext.Panel({  
					x:margin,
					y:margin,
					height: height_value,
					width: width_value,
					title: 'Référent',
					bodyStyle: 'padding:10px;background-color:#fff;',
					constrain: true,
					url: 'interface/menu/adherent' //used by the load fonction
			});

Ext.getCmp('<?=$win?>').add(Window_Referent.get());
Window_Referent.panel.show();
Window_Referent.load();

Window_Conjoint = new PanelItem(),
Window_Conjoint.panel = new Ext.Panel({  
					x: (height_value+2*margin),
					y: margin,
					height: height_value,
					width: width_value,
					title: 'Conjoint',
					bodyStyle: 'padding:10px;background-color:#fff;',
					constrain: true,
					url: 'interface/menu/adherent' //used by the load fonction
			});

Ext.getCmp('<?=$win?>').add(Window_Conjoint.get());
Window_Conjoint.panel.show();
Window_Conjoint.load();

<?php foreach ($enfants as $numero=>$idenfant){?>
	Window_Enfant<?=$numero?> = new PanelItem();
	Window_Enfant<?=$numero?>.panel = new Ext.Panel({  
						title: 'Enfant <?=$numero?>',
						bodyStyle: 'padding:10px;background-color:#fff;',  
						x: (margin+<?=$numero?>*height_value),
						y: (2*margin+height_value),
						height: height_value,
						width: width_value,
						constrain: true,
						url: 'interface/menu/adherent' //used by the load fonction
				});

	Ext.getCmp('<?=$win?>').add(Window_Enfant<?=$numero?>.get());
	Window_Enfant<?=$numero?>.panel.show();
	Window_Enfant<?=$numero?>.load();
<?php } ?>  
Ext.getCmp('<?=$win?>').doLayout();
</script>
