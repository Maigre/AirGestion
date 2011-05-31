<script type="text/javascript">

MainApp.Content = {
	
	Form_Adherent_<?=$adherent->id?> : new PanelItem(),
	Form_Data_<?=$adherent->id?> : {},
	
	//build the form
	make_form_<?=$adherent->id?> : function () {
		
		//load the data to populate the form
		this.Form_Data_<?=$adherent->id?> = new Ext.data.Store({
 			fields: ['nom','prenom','id','datenaissance','fichesanitaire','email','telportable','teldomicile','telprofessionel','sansviandesansporc','autorisationsortie','allocataire','employeur','noallocataire','nosecu','csp','situationfamiliale'],
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
		this.Form_Data_<?=$adherent->id?>.load();
		
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
							value:'Byles',
							anchor:'96%'
						},{
							xtype:'textfield',
							name : "prenom",
							fieldLabel : "Pr&eacutenom",
							value:'Junior',
							anchor:'96%'
						}, {
							xtype: 'radiofield',
							name: 'sexe',
							inputValue: 'Femme',
							//value: ,
							fieldLabel: 'Sexe',
							boxLabel: 'Femme',
							anchor:'96%'
						}, {
							xtype: 'radiofield',
							name: 'sexe',
							//value: 'on',
							inputValue: 'Homme',
							fieldLabel: '',
							labelSeparator: '',
							hideEmptyLabel: false,
							boxLabel: 'Homme',
							anchor:'96%'
						},{
							xtype: 'datefield',
							name : "datenaissance",
							fieldLabel : "Date de naissance",
							value:'Byles',
							anchor:'96%'
						},{
							xtype: 'textfield',
							name : "fichesanitaire",
							fieldLabel : "Fiche sanitaire",
							value:'Byles',
							anchor:'96%'
						},{
							xtype:'textfield',
							vtype: 'email',
							name : "email",
							fieldLabel : "Email",
							value:'yeah@airlab.fr',
							anchor:'96%'
						},{
							xtype: 'textfield',
							name : "telportable",
							fieldLabel : "Tel. portable",
							value:'0635268053',
							minLength: 10,
							maxLength: 10,
							hideTrigger: true,
							keyNavEnabled: false,
							mouseWheelEnabled: false,
							anchor:'96%'

						},{
							xtype: 'textfield',
							name : "teldomicile",
							fieldLabel : "Tel. domicile",
							value:'0635268053',
							minLength: 10,
							maxLength: 10,
							hideTrigger: true,
							keyNavEnabled: false,
							mouseWheelEnabled: false,
							anchor:'96%'

						},{
							xtype: 'textfield',
							name : "telprofessionel",
							fieldLabel : "Tel. pro",
							value:'0635268053',
							minLength: 10,
							maxLength: 10,
							hideTrigger: true,
							keyNavEnabled: false,
							mouseWheelEnabled: false,
							anchor:'96%'

						}]
						},{
						xtype: 'container',
					    columnWidth:0.5,
					    layout: 'anchor',
					    items: [{
					    	xtype:'checkboxfield',
							name : "sansviandesansporc",
							fieldLabel : "Sans Viande Sans Porc",
							value:'Oui',
							anchor:'100%'
						},{
							xtype:'checkboxfield',
							name : "autorisationsortie",
							fieldLabel : "Autorisation de Sortie",
							value: false,
							anchor:'100%'
						},{
							xtype:'checkboxfield',
							name : "allocataire",
							fieldLabel : "Allocataire",
							//value:'',
							anchor:'100%'
						},{
							xtype:'textfield',
							name : "employeur",
							fieldLabel : "Employeur",
							value:'John',
							anchor:'100%'
						},{
							xtype: 'numberfield',
							name : "noallocataire",
							fieldLabel : "N&deg allocataire",
							value:'4675849',
							hideTrigger: true,
							keyNavEnabled: false,
							mouseWheelEnabled: false,
							anchor:'100%'
						},{
							xtype: 'numberfield',
							name : "nosecu",
							fieldLabel : "N&deg s&eacutecu",
							value:'185126544010229',
							minLength: 15,
							maxLength: 15,
							hideTrigger: true,
							keyNavEnabled: false,
							mouseWheelEnabled: false,
							anchor:'100%'
						},{
							xtype:'textfield',
							name : "csp",
							fieldLabel : "CSP",
							value:'klj',
							hideTrigger: true,
							keyNavEnabled: false,
							mouseWheelEnabled: false,
							anchor:'100%'
						}
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
								Ext.Msg.alert('Success', action.result.msg);
								console.info(windowindex);
								//windowarray[windowindex].remove(Ext.getCmp('Main_Panel_Referent_Form'));
								//using Ajax to insert the content
								//windowarray[windowindex].add(ficheadherentcreate());
								//windowarray[windowindex].doLayout();
						},		
						failure: function(form, action) {
						   Ext.Msg.alert('Failure', "An error occured, please try again later.");
						}
					});
				}
			}]
		});
		
		this.Form_Data_<?=$adherent->id?>.on('load', function () {
			var rec= this.Form_Data_<?=$adherent->id?>.getAt(0);
			this.Form_Adherent_<?=$adherent->id?>.panel.getForm().loadRecord(rec);
		});
        
        Ext.getCmp('<?=$win?>').removeAll();             
		Ext.getCmp('<?=$win?>').add(this.Form_Adherent_<?=$adherent->id?>.get());
	}
}

MainApp.Content.make_form_<?=$adherent->id?>();
</script>
