<script type="text/javascript">

MainApp.Content = {
	
	Form_Adherent_<?=$adherent->id?> : new PanelItem(),
	Form_Data_<?=$adherent->id?> : {},
	
	//build the form
	make_form_<?=$adherent->id?> : function () {
		
		var comboboxstore_situationfamiliale = new Ext.data.Store({
 			id: 'store_combobox_situation_familiale',
 			fields: [{name: "name"}],
 			autoLoad: true,
 			proxy: {
				type: 'ajax',
				url: BASE_URL+'data/formprocess/comboboxload/situationfamiliale',  // url that will load data
			    actionMethods : {read: 'POST'},
				reader : {
			    	type : 'json',
					totalProperty: 'size',
					root: 'combobox'
				}
			}          			
		});
		this.combobox_situationfamiliale = new Ext.form.ComboBox ({
			fieldLabel: 'Situation familiale',
 			name: "situationfamiliale",
			store: comboboxstore_situationfamiliale,
			queryMode: 'remote',
			displayField: 'name',
			valueField: 'name',
			anchor: '96%'
		});
		
		var comboboxstore_csp = new Ext.data.Store({
 			id: 'store_combobox_csp',
 			fields: [{name: "name"}],
 			autoLoad: true,
 			proxy: {
				type: 'ajax',
				url: BASE_URL+'data/formprocess/comboboxload/csp',  // url that will load data
			    actionMethods : {read: 'POST'},
				reader : {
			    	type : 'json',
					totalProperty: 'size',
					root: 'combobox'
				}
			}          			
		});
		this.combobox_csp = new Ext.form.ComboBox ({
			fieldLabel: 'CSP',
 			name: "csp",
			store: comboboxstore_csp,
			queryMode: 'remote',
			displayField: 'name',
			valueField: 'name',
			anchor: '96%'
		});
		
		
		//load the data to populate the form
		this.Form_Data_<?=$adherent->id?> = new Ext.data.Store({
 			id: 'form_data',
 			fields: ['nom','prenom','id',
 					{name : 'datenaissance',
 					type : 'date'},
 					'fichesanitaire','email','telportable','teldomicile','telprofessionel','sansviandesansporc','autorisationsortie','allocataire','employeur','noallocataire','nosecu','csp','situationfamiliale'],
 			autoLoad: true,
 			proxy: {
				type: 'ajax',
				url: BASE_URL+'interface/c_adherent/load/<?=$adherent->id?>',  // url that will load data
			    actionMethods : {read: 'POST'},
				reader : {
			    	type : 'json',
					totalProperty: 'size',
					root: 'adherent'
				}
			}          			
		});
		/*<?php if ($adherent->id!=0):?>
			this.Form_Data_<?=$adherent->id?>.load();
		<?php endif ?>*/
		
		//create the form panel
		this.Form_Adherent_<?=$adherent->id?>.panel = new Ext.FormPanel
		({
			id : 'Form_Adherent_<?=$adherent->id?>-panel',
			width: 500,
			buttonAlign: 'center',
			defaults: {anchor: '100%'},
			defaultType: 'textfield',
			frame : true,
			labelAlign : "top",
			msgTarget: 'side',
			method: 'post',		
			url: BASE_URL+'interface/c_adherent/save/<?=$adherent->id?>',
		
			items:[{
			        xtype: 'container',
			        anchor: '100%',
			        layout: 'column',
					items:[{
					    xtype: 'container',
					    columnWidth:0.5,
					    layout: 'anchor',		
						items : 
						[{	
							xtype:'textfield',
							name : "nom",
							fieldLabel : "Nom",
							allowBlank: false,
							value:'',
							anchor:'96%'
						},{
							xtype:'textfield',
							name : "prenom",
							fieldLabel : "Pr&eacutenom",
							value:'',
							anchor:'96%'
						}/*,{
							  xtype: 'radiogroup',
							  fieldLabel: 'Sexe',
							  name: 'sexe',
							  items: [
								   {boxLabel: 'Femme', name: 'sexe', inputValue: 1},
								   {boxLabel: 'Homme', name: 'sexe', inputValue: 0}
							  ]
						}*/,{
							xtype: 'radiofield',
							name: 'sexe',
							inputValue: "1",
							//value: ,
							fieldLabel: 'Sexe',
							boxLabel: 'Femme',
							anchor:'96%'
						}, {
							xtype: 'radiofield',
							name: 'sexe',
							//value: 'on',
							inputValue: "0",
							fieldLabel: '',
							labelSeparator: '',
							hideEmptyLabel: false,
							boxLabel: 'Homme',
							anchor:'96%'
						},{
							xtype: 'datefield',
							name : "datenaissance",
							fieldLabel : "Date de naissance",
							value:'',
							anchor:'96%'
						},{
							xtype:'textfield',
							vtype: 'email',
							name : "email",
							fieldLabel : "Email",
							value:'@airlab.fr',
							anchor:'96%'
						},{
							xtype: 'textfield',
							name : "telportable",
							fieldLabel : "Tel. portable",
							value:'',
							minLength: 10,
							maxLength: 10,
							hideTrigger: true,
							keyNavEnabled: false,
							mouseWheelEnabled: false,
							anchor:'96%'

						}<?php if ($adherent->statutadherent->id <= 2): ?>
						,{
							xtype: 'textfield',
							name : "teldomicile",
							fieldLabel : "Tel. domicile",
							value:'',
							maxLength: 10,
							hideTrigger: true,
							keyNavEnabled: false,
							mouseWheelEnabled: false,
							anchor:'96%'

						},{
							xtype: 'textfield',
							name : "telprofessionel",
							fieldLabel : "Tel. pro",
							value:'',
							maxLength: 10,
							hideTrigger: true,
							keyNavEnabled: false,
							mouseWheelEnabled: false,
							anchor:'96%'

						}
						<?php endif; ?>
						]
						},
						//deuxieme colonne du formulaire
						{
						xtype: 'container',
					    columnWidth:0.5,
					    layout: 'anchor',
					    items: [{
					    	xtype:'checkboxfield',
							name : "sansviandesansporc",
							fieldLabel : "Sans Viande Sans Porc",
							value:'Oui',
							anchor:'96%'
						}<?php if ($adherent->statutadherent->id > 2): ?>
						,{
							xtype:'checkboxfield',
							name : "autorisationsortie",
							fieldLabel : "Autorisation de Sortie",
							value: false,
							anchor:'100%'
						}<?php endif; ?>
						,{
							xtype:'checkboxfield',
							name : "fichesanitaire",
							fieldLabel : "Fiche sanitaire",
							value: false,
							anchor:'100%'
						}
						<?php if ($adherent->statutadherent->id <= 2): ?>
						,{
							xtype:'checkboxfield',
							name : "allocataire",
							fieldLabel : "Allocataire",
							value: false,
							anchor:'100%'
						},{
							xtype:'textfield',
							name : "employeur",
							value:'',
							fieldLabel : "Employeur",
							anchor:'96%'
						},{
							xtype: 'numberfield',
							name : "noallocataire",
							fieldLabel : "N&deg allocataire",
							value:'',
							hideTrigger: true,
							keyNavEnabled: false,
							mouseWheelEnabled: false,
							anchor:'96%'
						}
						<?php endif; ?>
						,{
							xtype: 'numberfield',
							name : "nosecu",
							fieldLabel : "N&deg s&eacutecu",
							value:'',
							//minLength: 15,
							maxLength: 15,
							hideTrigger: true,
							keyNavEnabled: false,
							mouseWheelEnabled: false,
							anchor:'96%'
						}
						<?php if ($adherent->statutadherent->id <= 2): ?>
						,this.combobox_situationfamiliale,
						this.combobox_csp
						<?php endif; ?>
						]}]}],
	
			buttons:
			[/*{
				text: 'Reset',
				handler: function()
				{
					this.ownerCt.ownerCt.getForm().reset();
				}
			},*/{
				text: 'Submit',
				handler: function()
				{
					<?php if ($adherent->id==0):?> //Création d'un nouvel adherent lance sauvegarde famille
								Ext.getCmp('Form_Famille-panel').submit();
					<?php endif ?>
					
					this.ownerCt.ownerCt.getForm().submit ({
						
						
						success: function(form, action) {
								<?php if ($adherent->id==0):?>
									askAndDo(MainApp.ViewPort.AppPort.layout.regions.center.id,'interface/c_famille/display/'+action.result.idfamille);
								<?php endif ?>
								this.form.owner.ownerCt.url = 'interface/c_adherent/display/'+<?=$adherent->id?>,
							   	this.form.owner.ownerCt.him.load();
						},
						failure: function(form, action) {
						   Ext.Msg.alert('Failure', "An error occured, please try again later.");
						}
					});
				}
			}]
		});
		/*
		this.comboboxstore.on('load', function (datastore) {
			var rec= datastore.getAt(0);
		});
		*/
		this.Form_Data_<?=$adherent->id?>.on('load', function (datastore) {
			var rec= datastore.getAt(0);
			Ext.getCmp('Form_Adherent_<?=$adherent->id?>-panel').getForm().loadRecord(rec);
		});
        
        Ext.getCmp('<?=$win?>').removeAll();             
		Ext.getCmp('<?=$win?>').add(this.Form_Adherent_<?=$adherent->id?>.get());
	}
}

MainApp.Content.make_form_<?=$adherent->id?>();
</script>
