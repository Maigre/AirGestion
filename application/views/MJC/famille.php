<script type="text/javascript">

MainApp.Content = {

	Region_famille : new PanelItem(),
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
	// ----------------
	//	Create family buttons bar
	// ----------------	
	//Buttons to delete family, add conjoint/enfant
	
	addFamilypanel : function (w_id,f_id,himself) {	
		return new Ext.Panel({
						id: w_id,
						him: himself,
						autoHeight: true,
						autoWidth: true,
						bodyStyle: 'padding:5px',
						minWidth:  this.width,
						iconCls: 'group',
						constrain: true,
						layout: 'auto',
						//style : 'margin-left:5px;margin-top:5px',
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
							   		}
							   	},
							   	{
								   type: 'close',
								   handler: function(e,f,g){
									   	Ext.Msg.show({
											title: 'Alerte',
											msg: 'Voulez-vous vraiment supprimer cette famille et tous ses adhérents?',
											width: 300,
											buttons: Ext.Msg.YESNO,
											//multiline: true,
											fn: function(btn,f,g,h){
												if (btn == 'yes'){
													Ext.getCmp(w_id).url = 'interface/c_famille/delete/'+f_id;
													Ext.getCmp(w_id).him.load();
													Ext.getCmp('Region_famille').removeAll();
													Ext.getCmp('Region_famille').setVisible(false);
													Ext.getCmp('Region_parent').removeAll();
													Ext.getCmp('Region_parent').setVisible(false);
													Ext.getCmp('Region_parent2').removeAll();
													Ext.getCmp('Region_parent2').setVisible(false);
													<?php for ($i=1; $i<=4; $i++){ ?>
														Ext.getCmp('Region_enfant<?=$i?>').removeAll();
														Ext.getCmp('Region_enfant<?=$i?>').setVisible(false);
													<?php } ?>
												}
											},
											animateTarget: false,
											icon: Ext.window.MessageBox.INFO
										});
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
						//style : 'margin-left:5px;margin-top:5px',
						<?php if ($referent===0): ?> //nouvel adherent, acces direct au formulaire
							title: 'Nouveau référent',
							url : 'interface/c_adherent/form/0',
						<?php else: ?>
							title: 'Adherent '+a_id,
							url: 'interface/c_adherent/display/'+a_id,			
						<?php endif; ?>			
						tools: [{
								   type: 'refresh',
								   toolip: 'refresh',
								   handler: function(e,f,g){
									   g.ownerCt.url = 'interface/c_adherent/form/'+a_id;
									   g.ownerCt.him.load();
							   		}
							   	},
							   	//Bouton de suppression d'un adherent
							   	{
								   type: 'close',
								   toolip: 'Supprimer',
								   handler: function(e,f,g){
									   	Ext.Msg.show({
											title: 'Alerte',
											msg: 'Voulez-vous vraiment supprimer cet adhérent?',
											width: 300,
											buttons: Ext.Msg.YESNO,
											fn: function(btn,f,g,h){
												if (btn == 'yes'){
													Ext.getCmp(w_id).url = 'interface/c_adherent/delete/'+a_id;						
													Ext.getCmp(w_id).him.load();													
													Ext.getCmp(w_id).ownerCt.remove(Ext.getCmp(w_id));
												}
											},
											animateTarget: false,
											icon: Ext.window.MessageBox.INFO
										});
							   		}
							   	},
							   	////Bouton de rattachement a une deuxieme famille
							   	{
								 	type: 'pin',
								 	tooltip: 'Refresh form Data',
									handler: function(e,f,g){
										// ----------------
										//	Create searchform
										// ----------------	
										//The formfield is where the user types in the name. On each stroke, the input will be given to the datastore. 
										this.searchfield = new Ext.FormPanel({
											id: 'searchform',
											layout: 'fit',
											bodyStyle: 'margin:5px',
											height: 30,
											items: [
												{
													xtype: 'textfield',
													fieldLabel: '',
													name: 'searched_name',
													allowBlank:true,
													enableKeyEvents: true,
			
													listeners: 
													{
														keyup: function(el) {ds.load({params: {name_search: el.getValue()}});}
													}
												}
											]	
										});

									 
										// ----------------
										//	Create datasource
										// ----------------

										ds = new Ext.data.Store({
									 			fields: ['id','prenom','nom','idfamille'],
									 			autoLoad: true,
									 			proxy: {
													type: 'ajax',
													url: BASE_URL+'data/search/adherent/',  // url that will load data with respect to start and limit params
													actionMethods : {read: 'POST'},
													reader : {
														type : 'json',
														totalProperty: 'size',
														root: 'adherent'
													}
												}          			
										});				

									  
									 
										// ----------------
										//	Create grid
										// ----------------	

										this.searchgrid = new Ext.grid.GridPanel(
										{
											id: 'searchgrid',
											store: ds, // use the datasource
											columns: [
												{dataIndex: 'nom', flex:1, sortable: true},
												{dataIndex: 'prenom',  sortable: true},
												{dataIndex: 'id',  hidden: true},
												{dataIndex: 'idfamille',  hidden: true}
											],
											hideHeaders: true,
											autoScroll: true,
											listeners: {
												itemclick: function(g,i){ 
														askAndDo(MainApp.ViewPort.AppPort.layout.regions.center.id,'interface/c_adherent/relate_adherent_to_famille/'+i.data.idfamille+'/'+a_id);			    	
														Ext.getCmp('doublefamilleWindow').close();
														Ext.Msg.alert('Info', 'L\'enfant a été relié avec succès à une deuxième famille.');
												}
											},
											stripeRows:true,
											autoHeight:true 
										});	

										Adherent_double_famille = new Ext.Panel({
												id : 'Adherent_double_famille-panel',
												width: 500,
												buttonAlign: 'center',
												defaults: {anchor: '100%'},
												defaultType: 'textfield',
												frame : true,
												labelAlign : "top",
												msgTarget: 'side',
												method: 'post',		
												url: BASE_URL+'interface/c_adherent/save',
												items:[this.searchfield,this.searchgrid],
												modal: true
										});

										doublefamilleWindow = new Ext.Window({
													id: 'doublefamilleWindow',
													title: 'Sélectionner une deuxième famille',
													width: 240,
													layout: 'fit',
													modal: true,
													closable: true,
													resizable: true,
													items: [Adherent_double_famille],
													url: BASE_URL+'interface/c_adherent/save/1'
												});
										
										//Si deja deux familles, affiche les deux referents et demande confirmation
										if (this.ownerCt.ownerCt.items.items[0].referent1 !=''){
												Ext.Msg.show({
													title: 'Alerte',
													msg: 'Cet enfant est déjà relié à '+this.ownerCt.ownerCt.items.items[0].referent1+' et à '+this.ownerCt.ownerCt.items.items[0].referent2+'. Souhaitez-vous le rattacher à une troisième famille?',
													width: 300,
													buttons: Ext.Msg.YESNO,
													//multiline: true,
													fn: function(btn,f,g,h){
														if (btn == 'yes'){
															Ext.getCmp('doublefamilleWindow').show();
														}
													},
													animateTarget: false,
													icon: Ext.window.MessageBox.INFO
												});
										}
										else Ext.getCmp('doublefamilleWindow').show();
									}
							   	}]
			});
	},
	
	make : function () {
		
		Ext.getCmp('viewport_center_region').removeAll();
		
		//Layout the center region
		this.Region_famille.panel = new Ext.Panel({
				id: 'Region_famille',
				border: false,
				layout: 'border',
				items:[{
					region: 'center',
					autoScroll: true,
					border: true,
					id: 'Region_info_famille',
					layout: 'accordion',
					layoutConfig: {
						//layout-specific configs go here
						//titleCollapse: true,
						animate: true,
						align: 'center',
						hideCollapseTool: true,
						collapseFirst: false,
						multi: true
					}},
					{region: 'east',
					width: 520,
					autoScroll: true,
					border: true,
					id: 'Region_activite'}					
				]
		});
		
		//Height & width
		Ext.getCmp('Region_famille').setHeight(Ext.getCmp('viewport_center_region').getHeight()-2);
		Ext.getCmp('Region_info_famille').setWidth(Ext.getCmp('viewport_center_region').getWidth()-400);
		
		//add & clean
		Ext.getCmp('viewport_center_region').add(this.Region_famille.get());
		Ext.getCmp('Region_info_famille').removeAll();
				
		//////Create & add family&adherent panels
		//famille
		this.Famille.panel = this.addFamilypanel('Famille-panel','<?=$famille?>',this.Famille);
		this.Famille.load();
		Ext.getCmp('Region_info_famille').add(this.Famille.get());
				
		//referent		
		this.Referent.panel = this.addMember('Content_Adherent-<?=$referent?>-panel','<?=$referent?>',this.Referent);
		this.Referent.panel.tools[2].hidden = true; //désactiver le rattachement à une autre famille pour le référent
		this.Referent.panel.tools[1].hidden = true; //désactiver la supression d'un référent, elle se fait par supression de sa famille
		this.Referent.load();
		Ext.getCmp('Region_info_famille').add(this.Referent.get());
		
		//conjoint		
		<?php if (isset($conjoint)): ?> 
			this.Conjoint.panel = this.addMember('Content_Adherent-<?=$conjoint?>-panel',<?=$conjoint?>,this.Conjoint); 
			<?php if ($isnewconjoint): ?>
				this.Conjoint.panel.url = 'interface/c_adherent/form/<?=$conjoint?>',
			<?php endif; ?>
			this.Conjoint.panel.tools[2].hidden = true; //désactiver le rattachement à une autre famille pour le conjoint
			this.Conjoint.load();
			Ext.getCmp('Region_info_famille').add(this.Conjoint.get());
		<?php endif; ?>
		
		//enfant
		<?php if (isset($enfants)) foreach($enfants as $i=>$kid): ?>
			this.Enfant_<?=$i?>.panel = this.addMember('Content_Adherent-<?=$kid?>-panel',<?=$kid?>,this.Enfant_<?=$i?>);
			
			<?php if ($isnewkid[$i]): ?>
				this.Enfant_<?=$i?>.panel.url = 'interface/c_adherent/form/<?=$kid?>',
			<?php endif ?>
			
			this.Enfant_<?=$i?>.load();
			<?php $k=$i+1;
			$region='Region_enfant'.$k;?>
			Ext.getCmp('Region_info_famille').add(this.Enfant_<?=$i?>.get());
		<?php endforeach; ?>
		
		//Ouvre le panel de l'adherent selectionne
		<?php if (isset($enfants)):?>
		Ext.getCmp('Content_Adherent-<?=$selected_adherent?>-panel').expand();
		<?php endif; ?>
		////boutons de creation nouveaux adherents
		this.family_bar.panel = new Ext.Panel({
		    title: 'Famille <?=$nom?>',
		    id: 'family_bar',
		    iconCls: 'group',
		    tbar: [
			//conjoint
		    <?php if (!isset($conjoint)): ?> 
		    {
		        text: 'Conjoint',
		        iconCls: 'add',
		        scale: 'small',
		        handler: function() {
					askAndDo(MainApp.ViewPort.AppPort.layout.regions.center.id,'interface/c_adherent/new_adherent/2/<?=$famille?>');
				} 
		    },
		    <?php endif; ?>
		    //enfant
		    {
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
