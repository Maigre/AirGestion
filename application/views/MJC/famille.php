<script type="text/javascript">
//affiche 1 fenêtre vide pour chaque membre de la famille
//et lui donne l'url pour se charger
//console.info('ok');

width_value= 200;
height_value = 200;
margin= 5;

Window_Referent = {
		
		Main_Panel : new PanelItem(),
		Info_General : new PanelItem(),
		Info_Detail : new PanelItem(),
		
		init : function() {
		
			this.Info_General.panel = new Ext.Panel({
					id: 'Info_General_referent-panel',
					title: 'Informations Generales',
					
					layout: 'auto',
					url: 'interface/c_adherent/display/<?=$referent['id']?>/1/0/0'
			});
			this.Info_Detail.panel = new Ext.Panel({
					id: 'Info_Detail_referent-panel',
					title: 'Détails',
					//iconCls: 'user',
					layout: 'auto',
					url: 'interface/c_adherent/display/<?=$referent['id']?>/1/1/0'
			});
			this.Main_Panel.panel = new Ext.Panel({  
						x:margin,
						y:margin,
						height: height_value,
						width: width_value,
						title: '<?=$referent['nom']?> - Référent',
						iconCls: '<?php if ($referent['sexe']==0) echo 'user'; else echo 'user_female';?>',
						constrain: true,
						layout: 'accordion',
						items: [this.Info_General.get(),this.Info_Detail.get()]
			});
		
			Ext.getCmp('<?=$win?>').add(this.Main_Panel.get());
			this.Info_General.load();
			this.Info_Detail.load();
		}
}
Window_Referent.init();

//Ext.getCmp('<?=$win?>').add(Window_Referent.Main_Panel.get());
//Window_Referent.Info_General.load();
//Window_Referent.Info_Detail.load();


Window_Conjoint = {
		
		Main_Panel : new PanelItem(),
		Info_General : new PanelItem(),
		Info_Detail : new PanelItem(),
		
		init : function() {
			this.Info_General.panel = new Ext.Panel({
					id: 'Info_General_conjoint-panel',
					title: 'Informations Generales',
					layout: 'auto',
					url: 'interface/c_adherent/display/<?=$conjoint['id']?>/2/0/0'
			});
			this.Info_Detail.panel = new Ext.Panel({
					id: 'Info_Detail_conjoint-panel',
					title: 'Détails',
					layout: 'auto',
					url: 'interface/c_adherent/display/<?=$conjoint['id']?>/2/1/0'
			});
			this.Main_Panel.panel = new Ext.Panel({  
						x:(2*margin+width_value),
						y:margin,
						height: height_value,
						width: width_value,
						title: '<?=$conjoint['nom']?> - Conjoint',
						iconCls: '<?php if ($conjoint['sexe']==0) echo 'user'; else echo 'user_female';?>',
						constrain: true,
						layout: 'accordion',
						items: [this.Info_General.get(),this.Info_Detail.get()]
			});
		
			Ext.getCmp('<?=$win?>').add(this.Main_Panel.get());
			this.Info_General.load();
			this.Info_Detail.load();
		}
}
Window_Conjoint.init();




<?php foreach ($enfants as $numero=>$enfant){?>
	
	Window_Enfant<?=$numero?> = {
		
		Main_Panel<?=$numero?> : new PanelItem(),
		Info_General<?=$numero?> : new PanelItem(),
		Info_Detail<?=$numero?> : new PanelItem(),
		
		init : function() {
			this.Info_General<?=$numero?>.panel = new Ext.Panel({
				id: 'Info_General_enfant<?=$numero?>-panel',
				title: 'Informations Generales',
				//html: 'Menu Adherents...',
				layout: 'auto',
				url: 'interface/c_adherent/display/<?=$enfant['id']?>/3/0/<?=$numero?>'
			});
			this.Info_Detail<?=$numero?>.panel = new Ext.Panel({
				title: 'Détails',
				id: 'Info_Detail_enfant<?=$numero?>-panel',
				//html: 'Menu Adherents...',
				layout: 'auto',
				url: 'interface/c_adherent/display/<?=$enfant['id']?>/3/1/<?=$numero?>'
			});
			this.Main_Panel<?=$numero?>.panel = new Ext.Panel({  
				title: 'Enfant <?=$numero?> - <?=$enfant['nom']?>',
				x: (margin+<?=$numero?>*(width_value+margin)),
				y: (2*margin+height_value),
				height: height_value,
				width: width_value,
				iconCls: '<?php if ($enfant['sexe']==0) echo 'user'; else echo 'user_female';?>',
				constrain: true,
				layout: 'accordion',
				items: [this.Info_General<?=$numero?>.get(),this.Info_Detail<?=$numero?>.get()]
			});
	
			Ext.getCmp('<?=$win?>').add(this.Main_Panel<?=$numero?>.get());
			//Window_Enfant<?=$numero?>.panel.show();
			this.Info_General<?=$numero?>.load();
			this.Info_Detail<?=$numero?>.load();
		}
		
	}
	Window_Enfant<?=$numero?>.init();
	
<?php } ?>  

Ext.getCmp('<?=$win?>').doLayout();

</script>
