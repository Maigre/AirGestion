<script type="text/javascript">

MainApp.Content = {

	Famille : new PanelItem(),
	Referent : new PanelItem(),
	Conjoint : new PanelItem(),
	<?php if (isset($enfants)) foreach($enfants as $i=>$kid): ?>
		Enfant_<?=$i?>: new PanelItem(),
	<?php endforeach; ?>
	
	family_bar : new PanelItem(),
	
	//Adherent_double_famille : new PanelItem(),
	//doublefamilleWindow : new PanelItem(),
	
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
							   		}
							   	},
							   	{
								   type: 'close',
								   handler: function(e,f,g){
									   	Ext.Msg.show({
											title: 'Alerte',
											msg: 'Voulez-vous vraiment supprimer cet adhérent?',
											width: 300,
											buttons: Ext.Msg.YESNO,
											//multiline: true,
											fn: function(btn,f,g,h){
												console.info(btn);
												if (btn == 'yes'){
													Ext.getCmp(w_id).ownerCt.url = 'interface/c_adherent/delete/'+a_id;
													Ext.getCmp(w_id).ownerCt.remove(Ext.getCmp(w_id));
												}
											},
											animateTarget: false,
											icon: Ext.window.MessageBox.INFO
										});
							   		}
							   	},
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
										//this.createWindowDoubleFamille();
										Ext.getCmp('doublefamilleWindow').show();
									}
							   	}]
			});
	},
	
	make : function () {
		
		Ext.getCmp('Region_famille').removeAll();
		Ext.getCmp('Region_parent').removeAll();
		<?php for ($i=1; $i<=4; $i++){ ?>
			Ext.getCmp('Region_enfant<?=$i?>').removeAll();
		<?php } ?>
				
		this.Famille.panel = this.addFamilypanel('Famille-panel','<?=$famille?>',this.Famille);
		this.Famille.load();
		Ext.getCmp('Region_famille').add(this.Famille.get());
		
		this.Referent.panel = this.addMember('Content_Referent-panel','<?=$referent?>',this.Referent);
		this.Referent.panel.tools[2].hidden = true; //désactiver le rattachement à une autre famille pour le référent
		this.Referent.load();
		Ext.getCmp('Region_parent').add(this.Referent.get());
		<?php if (isset($conjoint)): ?> 
			this.Conjoint.panel = this.addMember('Content_Conjoint-panel',<?=$conjoint?>,this.Conjoint); 
			
			<?php if ($isnewconjoint): ?>
				this.Conjoint.panel.url = 'interface/c_adherent/form/<?=$conjoint?>',
			<?php endif; ?>
			this.Conjoint.panel.tools[2].hidden = true; //désactiver le rattachement à une autre famille pour le conjoint
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
