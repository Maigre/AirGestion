<script type="text/javascript">

MainApp.Content = {

	Famille : new PanelItem(),
	Referent : new PanelItem(),
	Conjoint : new PanelItem(),
	<?php if (isset($enfants)) foreach($enfants as $i=>$kid): ?>
		Enfant_<?=$i?>: new PanelItem(),
	<?php endforeach; ?>
	
	family_bar : new PanelItem(),
	
	width : 200,
	height_adults : 210,
	height_kids : 150,
	margin : 5,
	
	// ----------------
	//	Create family buttons bar
	// ----------------	
	//Buttons to delete family, add conjoint/enfant
	
	addFamilypanel : function (w_id,f_id,himself) {	
		return new Ext.Panel({
						id: w_id,
						him: himself,
						//x: this.x,
						//y: this.y,
						//height: c_height,
						autoHeight: true,
						autoWidth: true,
						bodyStyle: 'padding:5px',
						minWidth:  this.width,
						iconCls: 'group',
						constrain: true,
						layout: 'auto',
						style : 'margin-left:5px;margin-top:5px',
						<?php if ($famille===0): ?> //nouvelle famille acces direct au formulaire
							title: 'Nouvelle Famille ',
							url : 'interface/c_famille/form/0',
						<?php else: ?>	
							title: 'Famille '+f_id,
							url: 'interface/c_famille/displayfamille/'+f_id,	
						<?php endif; ?>			
						tools: [{
								   type: 'refresh',
								   handler: function(e,f,g){
									   g.ownerCt.url = 'interface/c_famille/form/'+f_id;
									   g.ownerCt.him.load();
									   //this.ownerCt.ownerCt.parent.load();
									   //console.info(this.ownerCt.ownerCt);
									   //Ext.getCmp('Main_Panel_Referent').setAutoHeight(true);
									   //Ext.getCmp('Main_Panel_Referent').setAutoWidth(true);
									   //Ext.getCmp('Main_Panel_Referent').close();
									  // Window_Referent_form.init();
							   		}
							   	}]
			});
	},
	
	addMember : function (w_id,a_id,himself) {
		return new Ext.Panel({  
						id: w_id,
						him: himself,
						//x: this.x,
						//y: this.y,
						//height: c_height,
						autoHeight: true,
						autoWidth: true,
						bodyStyle: 'padding:5px',
						minWidth:  this.width,
						iconCls: 'user',
						constrain: true,
						layout: 'auto',
						style : 'margin-left:5px;margin-top:5px',
						<?php if ($referent===0): ?> //nouvel adherent, acces direct au formulaire
							title: 'Nouveau référent',
							url : 'interface/c_adherent/form/0',
						<?php else: ?>
							title: 'Adherent '+a_id,
							url: 'interface/c_adherent/display/'+a_id,			
						<?php endif; ?>			
						tools: [{
								   type: 'refresh',
								   handler: function(e,f,g){
									   g.ownerCt.url = 'interface/c_adherent/form/'+a_id;
									   g.ownerCt.him.load();
									   //this.ownerCt.ownerCt.parent.load();
									   //console.info(this.ownerCt.ownerCt);
									   //Ext.getCmp('Main_Panel_Referent').setAutoHeight(true);
									   //Ext.getCmp('Main_Panel_Referent').setAutoWidth(true);
									   //Ext.getCmp('Main_Panel_Referent').close();
									  // Window_Referent_form.init();
							   		}
							   	}]
			});
	},
	
	make : function () {
		
		//Ext.getCmp('<?=$win?>').removeAll();
		Ext.getCmp('Region_famille').removeAll();
		Ext.getCmp('Region_parent').removeAll();
		Ext.getCmp('Region_enfant1').removeAll();
		Ext.getCmp('Region_enfant2').removeAll();
		
		
		
		this.Famille.panel = this.addFamilypanel('Famille-panel','<?=$famille?>',this.Famille);
		this.Famille.load();
		Ext.getCmp('Region_famille').add(this.Famille.get());
		
		this.Referent.panel = this.addMember('Content_Referent-panel','<?=$referent?>',this.Referent);
		this.Referent.load();
		Ext.getCmp('Region_parent').add(this.Referent.get());
		<?php if (isset($conjoint)): ?> 
			this.Conjoint.panel = this.addMember('Content_Conjoint-panel',<?=$conjoint?>,this.Conjoint); 
			
			<?php if ($isnewconjoint): ?>
				this.Conjoint.panel.url = 'interface/c_adherent/form/<?=$conjoint?>',
			<?php endif; ?>
			
			this.Conjoint.load();
			Ext.getCmp('Region_parent').add(this.Conjoint.get());
		<?php endif; ?>
		
		<?php if (isset($enfants)) foreach($enfants as $i=>$kid): ?>
			this.Enfant_<?=$i?>.panel = this.addMember('Content_Enfant_<?=$i?>-panel',<?=$kid?>,this.Enfant_<?=$i?>);
			
			<?php if ($isnewkid[$i]): ?>
				this.Enfant_<?=$i?>.panel.url = 'interface/c_adherent/form/<?=$kid?>',
			<?php endif ?>
			
			this.Enfant_<?=$i?>.load();
			<?php if ($i<2) $region="Region_enfant1";
					elseif (($i>1) AND ($i<4)) $region="Region_enfant2";
					elseif (($i>3) AND ($i<6)) $region="Region_enfant3";
					elseif (($i>5) AND ($i<8)) $region="Region_enfant4";
			?>
			Ext.getCmp('<?=$region?>').add(this.Enfant_<?=$i?>.get());
		<?php endforeach; ?>
		
		this.family_bar.panel = new Ext.Panel({
		    title: 'Famille <?=$nom?>',
		    id: 'family_bar',
		    iconCls: 'group',
		    tbar: [{
		        text: 'Famille',
		        iconCls: 'cancel',
		        scale: 'small'
		    },{
		        text: 'Conjoint',
		        iconCls: 'add',
		        scale: 'small',
		        handler: function() {
					askAndDo(MainApp.ViewPort.AppPort.layout.regions.center.id,'interface/c_adherent/new_adherent/2/<?=$famille?>');
				} 
		    },{
		        text: 'Enfant',
		        iconCls: 'add',
		        scale: 'small',
		        handler: function() {
					askAndDo(MainApp.ViewPort.AppPort.layout.regions.center.id,'interface/c_adherent/new_adherent/3/<?=$famille?>');
				} 
		    }]
		});
		Ext.getCmp('Menu_Adherents-panel').remove('family_bar');
		Ext.getCmp('Menu_Adherents-panel').add(this.family_bar.panel);
	}
}
MainApp.Content.make();
</script>
