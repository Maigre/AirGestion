<script type="text/javascript">

MainApp.Content = {
	
	Form_Famille : new PanelItem(),
	Form_Famille_Data : {},
	
	//build the form
	make_form : function () {
		
		/*var comboboxstore_situationfamiliale = new Ext.data.Store({
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
		*/
		var comboboxstore_groupe = new Ext.data.Store({
 			id: 'store_combobox_groupe',
 			fields: [{name: "name"}],
 			autoLoad: true,
 			proxy: {
				type: 'ajax',
				url: BASE_URL+'data/formprocess/comboboxload/groupe',  // url that will load data
			    actionMethods : {read: 'POST'},
				reader : {
			    	type : 'json',
					totalProperty: 'size',
					root: 'combobox'
				}
			}          			
		});
		this.combobox_groupe = new Ext.form.ComboBox ({
			fieldLabel: 'Groupe',
 			name: "groupe",
			store: comboboxstore_groupe,
			queryMode: 'remote',
			displayField: 'name',
			valueField: 'name',
			anchor: '96%'
		});
		
		
		//load the data to populate the form
		this.Form_Famille_Data = new Ext.data.Store({
 			id: 'form_famille_data',
 			fields: ['adresse1','adresse2','codepostal','ville','exterieur','qf','ccas','bonvacance','groupe'],
 			autoLoad: true,
 			proxy: {
				type: 'ajax',
				url: BASE_URL+'interface/c_famille/load/<?=$famille->id?>',  // url that will load data
			    actionMethods : {read: 'POST'},
				reader : {
			    	type : 'json',
					totalProperty: 'size',
					root: 'adherent'
				}
			}          			
		});
		//
		<?php if ($famille->id!=0):?>
		this.Form_Famille_Data.load();
		<?php endif ?>
		
		//create the form panel
		this.Form_Famille.panel = new Ext.FormPanel
		({
			id : 'Form_Famille-panel',
			width: 500,
			buttonAlign: 'center',
			defaults: {anchor: '100%'},
			defaultType: 'textfield',
			frame : true,
			labelAlign : "top",
			msgTarget: 'side',
			method: 'post',		
			url: BASE_URL+'interface/c_famille/save/<?=$famille->id?>',
		
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
							name : "adresse1",
							fieldLabel : "Adresse",
							allowBlank: false,
							value:'',
							anchor:'96%'
						},{
							xtype:'textfield',
							name : "adresse2",
							fieldLabel : "",
							value:'',
							anchor:'96%'
						},{
							xtype:'textfield',
							name : "codepostal",
							fieldLabel : "Code Postal",
							value:'',
							anchor:'96%'
						},{
							xtype: 'textfield',
							name : "ville",
							fieldLabel : "Ville",
							value:'',
							anchor:'96%'
						}]
						},{
						xtype: 'container',
					    columnWidth:0.5,
					    layout: 'anchor',
					    items: [{
							xtype: 'checkboxfield',
							name : "exterieur",
							fieldLabel : "Ext&eacuterieur",
							value:'',
							anchor:'96%'
						},{
							xtype:'textfield',
							name : "qf",
							fieldLabel : "Q.F",
							value: '',
							anchor:'100%'
						},{
							xtype:'checkboxfield',
							name : "ccas",
							fieldLabel : "CCAS",
							value: '',
							anchor:'100%'
						},{
							xtype:'checkboxfield',
							name : "bonvacance",
							fieldLabel : "Bons vacances",
							value: '',
						},this.combobox_groupe
						]}]}],
	
			buttons:
			[{
				text: 'Reset',
				handler: function()
				{
					this.ownerCt.ownerCt.getForm().reset();
				}
			},{
				text: 'Submit',
				handler: function()
				{
					this.ownerCt.ownerCt.getForm().submit ({
						success: function(form, action) {
								<?php if ($famille->id==0):?> //Création d'une nouvelle famille lance sauvegarde adherent
									Ext.getCmp('Form_Adherent_0-panel').submit();
								<?php endif ?>
								Ext.Msg.alert('Famille Success', action.result.msg);
								//console.info(this);
								this.form.owner.ownerCt.url = 'interface/c_famille/displayfamille/'+<?=$famille->id?>,
							   	this.form.owner.ownerCt.him.load();
								//console.info(this.form.owner.ownerCt);
								//this.form.owner.ownerCt.doLayout();
								console.info(windowindex);
						},
						failure: function(form, action) {
						   Ext.Msg.alert('Failure', "An error occured, please try again later.");
						}
					});
				},
				<?php if ($famille->id==0):?>
					disabled: true
				<?php else: ?>
					disabled: false
				<?php endif ?>
				
			}]
		});
		/*
		this.comboboxstore.on('load', function (datastore) {
			var rec= datastore.getAt(0);
		});
		*/
		this.Form_Famille_Data.on('load', function (datastore) {
			var rec= datastore.getAt(0);
			Ext.getCmp('Form_Famille-panel').getForm().loadRecord(rec);
		});
		
        
        Ext.getCmp('<?=$win?>').removeAll();             
		Ext.getCmp('<?=$win?>').add(this.Form_Famille.get());
	}
}

MainApp.Content.make_form();
</script>
