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
					bodyStyle : 'padding: 5px',
					layout: 'auto',
					url: 'interface/c_adherent/display/<?=$referent['id']?>/1/0/0'
			});
			this.Info_Detail.panel = new Ext.Panel({
					id: 'Info_Detail_referent-panel',
					title: 'Détails',
					bodyStyle : 'padding: 5px',
					//iconCls: 'user',
					layout: 'auto',
					url: 'interface/c_adherent/display/<?=$referent['id']?>/1/1/0'
			});
			this.Main_Panel.panel = new Ext.Panel({  
						id: 'Main_Panel_Referent',
						x:margin,
						y:margin,
						height: height_value,
						width: width_value,
						title: '<?=$referent['nom']?> - Référent',
						iconCls: '<?php if ($referent['sexe']==0) echo 'user'; else echo 'user_female';?>',
						constrain: true,
						layout: 'accordion',
						items: [this.Info_General.get(),this.Info_Detail.get()],
						tools: [{
								   type: 'next',
								   handler: function(){
									   Ext.getCmp('viewport_center_region').removeAll();
									   //Ext.getCmp('Main_Panel_Referent').close();
									   Window_Referent_form.init();
							   		}
							   	}]
			});
		
			Ext.getCmp('<?=$win?>').add(this.Main_Panel.get());
			this.Info_General.load();
			this.Info_Detail.load();
		}
}
Window_Referent.init();


Window_Referent_form = {

	Main_Panel : new Ext.Panel,
	
	init : function() {
	
		this.Main_Panel.panel = new Ext.FormPanel
		({
			id : 'Main_Panel_Referent_Form',
			width: 500,
			buttonAlign: 'center',
			defaults: {anchor: '100%'},
			defaultType: 'textfield',
			frame : true,
			labelAlign : "top",
			msgTarget: 'side',
			method: 'post',		
			title: 'Famille',
			url: BASE_URL+'interface/c_adherent/save/<?=$referent['id']?>',
			//width: 300,
			//height: 300,
			collapsible: true,
		
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
					Ext.getCmp('Main_Panel_Referent_Form').getForm().reset();
				}
			},{
				text: 'Submit',
				handler: function()
				{
					Ext.getCmp('Main_Panel_Referent_Form').getForm().submit ({
						success: function(form, action) {
								Ext.Msg.alert('Success', action.result.msg);
								console.info(windowindex);
								windowarray[windowindex].remove(Ext.getCmp('Main_Panel_Referent_Form'));
								//using Ajax to insert the content
								windowarray[windowindex].add(ficheadherentcreate());
								//windowarray[windowindex].doLayout();
						},		
						failure: function(form, action) {
						   Ext.Msg.alert('Failure', "An error occured, please try again later.");
						}
					});
				}
			}]
		});
		Ext.getCmp('<?=$win?>').add(Ext.getCmp('Main_Panel_Referent_Form'));
	}
}




Window_Conjoint = {
		
		Main_Panel : new PanelItem(),
		Info_General : new PanelItem(),
		Info_Detail : new PanelItem(),
		
		init : function() {
			this.Info_General.panel = new Ext.Panel({
					id: 'Info_General_conjoint-panel',
					title: 'Informations Generales',
					bodyStyle : 'padding: 5px',
					layout: 'auto',
					url: 'interface/c_adherent/display/<?=$conjoint['id']?>/2/0/0'
			});
			this.Info_Detail.panel = new Ext.Panel({
					id: 'Info_Detail_conjoint-panel',
					title: 'Détails',
					bodyStyle : 'padding: 5px',
					layout: 'auto',
					url: 'interface/c_adherent/display/<?=$conjoint['id']?>/2/1/0'
			});
			this.Main_Panel.panel = new Ext.Panel({  
						id: 'Main_Panel_Conjoint',
						x:(2*margin+width_value),
						y:margin,
						height: height_value,
						width: width_value,
						title: '<?=$conjoint['nom']?> - Conjoint',
						iconCls: '<?php if ($conjoint['sexe']==0) echo 'user'; else echo 'user_female';?>',
						constrain: true,
						layout: 'accordion',
						items: [this.Info_General.get(),this.Info_Detail.get()],
						tools: [{
								   type: 'next',
								   handler: function(){
									   Ext.getCmp('Main_Panel_Conjoint').close();
							   		}
							   	}]
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
				bodyStyle : 'padding: 5px',
				//html: 'Menu Adherents...',
				layout: 'auto',
				url: 'interface/c_adherent/display/<?=$enfant['id']?>/3/0/<?=$numero?>'
			});
			this.Info_Detail<?=$numero?>.panel = new Ext.Panel({
				title: 'Détails',
				id: 'Info_Detail_enfant<?=$numero?>-panel',
				bodyStyle : 'padding: 5px',
				//html: 'Menu Adherents...',
				layout: 'auto',
				url: 'interface/c_adherent/display/<?=$enfant['id']?>/3/1/<?=$numero?>'
			});
			this.Main_Panel<?=$numero?>.panel = new Ext.Panel({  
				title: '<?=$enfant['nom']?> - Enfant <?=$numero?>',
				id: 'Main_Panel_Enfant<?=$numero?>',
				x: (margin+<?=$numero?>*(width_value+margin)),
				y: (2*margin+height_value),
				height: height_value,
				width: width_value,
				iconCls: '<?php if ($enfant['sexe']==0) echo 'user'; else echo 'user_female';?>',
				constrain: true,
				layout: 'accordion',
				items: [
					this.Info_General<?=$numero?>.get(),
					this.Info_Detail<?=$numero?>.get()],
				tools: [{
						   type: 'next',
						   handler: function(){
							   Ext.getCmp('Main_Panel_Enfant<?=$numero?>').close();
					   		}
					   	}]
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
