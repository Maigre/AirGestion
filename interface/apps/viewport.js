
Ext.ns('MainApp');

function MenuItem() {
		this.panel = null;
		this.get = function(){return this.panel;}
	}

MainApp.ViewPort = {
	
	AppPort : null,

	Menu_Accueil : new MenuItem(),

	Menu_Adherents : new Ext.Panel({
			id: 'Menu_Adherents-panel',
			title: 'Adherents',
			iconCls: 'user',
			html: 'Menu Adherents...'
		}),
	
	Menu_Activites : new Ext.Panel({
			id: 'Menu_Activites-panel',
			title: 'Activites',
			iconCls: 'palette',
			html: 'Menu Activites...'
		}),
	
	Menu_Clsh : new Ext.Panel({
			id: 'Menu_Clsh-panel',
			title: 'Centre de Loisirs',
			iconCls: 'slide',
			html: 'Menu CLSH...'
		}),
	
	Menu_Perisco : new Ext.Panel({
			id: 'Menu_Perisco-panel',
			title: 'Periscolaire',
			iconCls: 'ruler',
			html: 'Menu Periscolaire...'
		}),
	
	Menu_Paiements : new Ext.Panel({
			id: 'Menu_Paiements-panel',
			title: 'Paiements',
			iconCls: 'money',
			html: 'Menu Paiements...'
		}),

	Menu_Config : new Ext.Panel({
			id: 'Menu_Config-panel',
			title: 'Configuration',
			iconCls: 'cog',
			html: 'Menu Configuration...'
		}),
	
	init : function() {
	
		this.Menu_Accueil.panel = new Ext.Panel({
				id: 'Menu_Accueil-panel',
				title: 'Accueil',
				iconCls: 'house',
				html: 'Menu Accueil...'
			});
	
		this.AppPort = new Ext.Viewport({
				id: 'MainApp-viewport',
				layout: 'border',
				items: [{
					region: 'north',
					html: '<div id="title-img" style="padding:7px 50px"><img src="images/airgestion-tr.png" alt="AirGestion!" height="45px" width="auto" /></div>',
					bodyStyle: "background-image:url(images/bck3.jpg)",
					heiht: 200,
					border: true
				}, {
					region: 'west',
					width:200,
					defaults: {
							// applied to each contained panel
							bodyStyle: 'padding:10px'
						},
					layout: 'accordion',
					layoutConfig: {
							// layout-specific configs go here
							titleCollapse: true,
							animate: true,
							activeOnTop: true
						},
					items:[this.Menu_Accueil.get(),this.Menu_Adherents,this.Menu_Activites,this.Menu_Clsh,this.Menu_Perisco,this.Menu_Paiements,this.Menu_Config]
				}, {
					region: 'center'
					//,bodyStyle: "background-image:url(images/bck3.jpg)"
				}, {
					region: 'south',
					html: '',
					bodyStyle: "background-image:url(images/bck3.jpg)",
					height: 30
				}]
			});  	
	},
	
	reload: function() {
		window.location.reload();
	}	
}


