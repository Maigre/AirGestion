
Ext.ns('MainApp');

function askAndDo (winID,controller)
	{	
		Ext.Ajax.request({
		    url: BASE_URL+controller,
		    method : 'POST',
		    params : {
		    	win: winID
		    },
		    success: function(response){
		    		Ext.get('working-area').insertHtml('beforeBegin',response.responseText,true);
		    }
		});
	}	

function PanelItem() {
		this.panel = null;
		this.get = function(){return this.panel;};
		this.load = function(){askAndDo(this.panel.id,this.panel.url);};
	}
	

MainApp.ViewPort = {
	
	AppPort : null,

	Menu_Accueil : new PanelItem(),

	Menu_Adherents : new PanelItem(),
	
	Menu_Activites : new PanelItem(),
	
	Menu_Clsh : new PanelItem(),
	
	Menu_Perisco : new PanelItem(),
	
	Menu_Paiements : new PanelItem(),

	Menu_Config : new PanelItem(),
 
	Menu_User : new PanelItem(),
	
	/*Region_famille : new PanelItem(),
	Region_parent : new PanelItem(),
	Region_parent2 : new PanelItem(),
	Region_enfant1 : new PanelItem(),
	Region_enfant2 : new PanelItem(),
	Region_enfant3 : new PanelItem(),
	Region_enfant4 : new PanelItem(),
	Region_adherent : new PanelItem(),
	*/
	
	init : function() {
	
		//détection online/offline
		//window.addEventListener("offline", function(e) {alert("offline");});
		
		this.Menu_Accueil.panel = new Ext.Panel({
				id: 'Menu_Accueil-panel',
				title: 'Accueil',
				iconCls: 'house',
				html: 'Menu Accueil...'
			});
		this.Menu_Adherents.panel = new Ext.Panel({
				id: 'Menu_Adherents-panel',
				title: 'Adherents',
				iconCls: 'user',
				//html: 'Menu Adherents...',
				layout: 'auto',
				url: 'interface/menu/adherent'
			});
		this.Menu_Activites.panel = new Ext.Panel({
				id: 'Menu_Activites-panel',
				title: 'Activites',
				iconCls: 'palette',
				html: 'Menu Activites...'
			});
		this.Menu_Clsh.panel = new Ext.Panel({
				id: 'Menu_Clsh-panel',
				title: 'Centre de Loisirs',
				iconCls: 'slide',
				html: 'Menu CLSH...'
			});
		this.Menu_Perisco.panel = new Ext.Panel({
				id: 'Menu_Perisco-panel',
				title: 'Periscolaire',
				iconCls: 'ruler',
				html: 'Menu Periscolaire...'
			});
		this.Menu_Paiements.panel = new Ext.Panel({
				id: 'Menu_Paiements-panel',
				title: 'Paiements',
				iconCls: 'money',
				html: 'Menu Paiements...'
			});
		this.Menu_Config.panel = new Ext.Panel({
				id: 'Menu_Config-panel',
				title: 'Configuration',
				iconCls: 'cog',
				html: 'Menu Configuration...'
			});
			
		this.Menu_User.panel = new Ext.menu.Menu({
				id: 'Menu_User-menu',
				items: [{text:'Connexion',iconCls:'key',handler: function(){MainApp.Login.ask();}}]
		});
		
		/*this.Region_famille.panel = new Ext.Panel({
				id: 'Region_famille',
				title: 'Info Famille',
				iconCls: 'group',
				width: 600,
				border: false,
				hidden: true,
				//height: 100,
				layout : 'column'
		});
		this.Region_parent.panel = new Ext.Panel({
				id: 'Region_parent',
				iconCls: 'user',
				width: 600,
				border: false,
				hidden: true,
				//height: 100,
				layout : 'column'
		});
		this.Region_parent2.panel = new Ext.Panel({
				id: 'Region_parent2',
				iconCls: 'user',
				width: 600,
				border: false,
				hidden: true,
				//height: 100,
				layout : 'column'
		});
		this.Region_enfant1.panel = new Ext.Panel({
				id: 'Region_enfant1',
				iconCls: 'user',
				width: 600,
				border: false,
				hidden: true,
				layout : 'column'
		});
		this.Region_enfant2.panel = new Ext.Panel({
				id: 'Region_enfant2',
				iconCls: 'user',
				width: 600,
				border: false,
				hidden: true,
				layout : 'column'
		});
		this.Region_enfant3.panel = new Ext.Panel({
				id: 'Region_enfant3',
				iconCls: 'user',
				width: 600,
				border: false,
				hidden: true,
				layout : 'column'
		});
		this.Region_enfant4.panel = new Ext.Panel({
				id: 'Region_enfant4',
				iconCls: 'user',
				width: 600,
				border: false,
				hidden: true,
				layout : 'column'
		});
		this.Region_adherent.panel= new Ext.Panel({
				id: 'Region_adherent',
				width: 600,
				height: 650,
				border: true,
				layout : 'accordion',
				items: [this.Region_famille.get(),this.Region_parent.get(),this.Region_parent2.get(),this.Region_enfant1.get(),this.Region_enfant2.get(),this.Region_enfant3.get(),this.Region_enfant4.get()]
		});
		*/
	
		this.AppPort = new Ext.Viewport({
				id: 'MainApp-viewport',
				layout: 'border',
				items: [{
					region: 'north',
					html: '<div id="title-img" style="float:right;padding:7px 50px"><img src="interface/images/airgestion-tr.png" alt="AirGestion!" height="45px" width="auto" /></div>',
					bodyStyle: "background-image:url(interface/images/bck3.jpg)",
					height: 56,
					border: false,
				}, {
					region: 'west',
					width:200,
					border: true,
					defaults: {
							// applied to each contained panel
							bodyStyle: 'padding:5px'
						},
					layout: 'accordion',
					layoutConfig: {
							// layout-specific configs go here
							titleCollapse: true,
							animate: true,
							activeOnTop: true
					},
					items:[this.Menu_Accueil.get(),this.Menu_Adherents.get(),this.Menu_Activites.get(),this.Menu_Clsh.get(),this.Menu_Perisco.get(),this.Menu_Paiements.get(),this.Menu_Config.get()]
				}, {
					region: 'center',
					//layout: 'vbox',
					autoScroll: true,
					border: true,
					margin: 5,
					id: 'viewport_center_region'//,
					//items:[this.Region_adherent.get()]
				}, {
					region: 'south',
					html: '',
					//bodyStyle: "background-image:url(interface/images/bck3.jpg)",
					//height: 30,
					border: false,
					tbar: [
						{xtype: 'tbfill'},
						{
							id: 'Menu_User-button',
							text:'Utilisateur',
							split: true,
							iconCls:'color_swatch_2',
							menu: this.Menu_User.get()
						}
						]
				}]
			});
	},
	
	//called when login is validated
	start: function () {
		//load menu content
		this.loadMenus();

		//change user toolbar
		this.loadToolbar();
	},
	
	loadMenus: function () {
		//put here menu content loading (called after login check)
		this.Menu_Adherents.load();
		
		//
	},
	
	loadToolbar: function () {
		//create user tollbar

		Ext.getCmp('Menu_User-button').setText(MainApp.Login.user);
		Ext.getCmp('Menu_User-menu').removeAll();
		Ext.getCmp('Menu_User-menu').add([{                        
                    text: 'Deconnexion',iconCls:'key',handler: function(){MainApp.Login.logout();}        
            },{
                	text: 'Redemarrer',iconCls:'arrow_redo',handler: function(){MainApp.ViewPort.reload();}
            }]);
	},
	
	reload: function() {
		window.location.reload();
	}		
}


