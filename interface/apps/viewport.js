
Ext.ns('MainApp');

function askAndDo (winID,controller)
	{	
		Ext.Ajax.request({
		    url: 'http://localhost/AirGestion/index.php/'+controller,
		    method : 'POST',
		    params : {
		    	win: winID
		    },
		    success: function(response){
		    		Ext.get('working-area').update(response.responseText,true);
		    }
		});
	}	

function MenuItem() {
		this.panel = null;
		this.get = function(){return this.panel;};
		this.load = function(){askAndDo(this.panel.id,this.panel.url);};
	}
	
/*function windowcreate(){
		var win = new Ext.Window({  
					title: 'User form',
					iconCls: 'user',  
					bodyStyle: 'padding:10px;background-color:#fff;',  
					width:400,
					height:400, 
					//items:[formcreate()],
					layout: 'fit' 
				});
		return win;
	}*/

MainApp.ViewPort = {
	
	AppPort : null,

	Menu_Accueil : new MenuItem(),

	Menu_Adherents : new MenuItem(),
	
	Menu_Activites : new MenuItem(),
	
	Menu_Clsh : new MenuItem(),
	
	Menu_Perisco : new MenuItem(),
	
	Menu_Paiements : new MenuItem(),

	Menu_Config : new MenuItem(),
	
	Window_User : new MenuItem(),
	
	init : function() {
	
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
		this.Window_User.panel = new Ext.Window({  
					title: 'User form',
					bodyStyle: 'padding:10px;background-color:#fff;',  
					width:400,
					height:400,
					constrain: true
			});
		//this.Window_User.panel.show();
		
	
		this.AppPort = new Ext.Viewport({
				id: 'MainApp-viewport',
				layout: 'border',
				items: [{
					region: 'north',
					html: '<div id="title-img" style="padding:7px 50px"><img src="images/airgestion-tr.png" alt="AirGestion!" height="45px" width="auto" /></div>',
					bodyStyle: "background-image:url(images/bck3.jpg)",
					heiht: 200,
					border: true,
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
					items:[this.Menu_Accueil.get(),this.Menu_Adherents.get(),this.Menu_Activites.get(),this.Menu_Clsh.get(),this.Menu_Perisco.get(),this.Menu_Paiements.get(),this.Menu_Config.get()]
				}, {
					region: 'center',
					//layout: 'auto',
					id: 'viewport_center_region'
				}, {
					region: 'south',
					html: '',
					bodyStyle: "background-image:url(images/bck3.jpg)",
					height: 30
				}]
			});
		
		
		//this.AppPort.layout.regions.center.add(this.Window_User.get()); // using add()
        //this.Window_User.get().show();
        this.Menu_Adherents.load();
        
        //this.AppPort.endUpdate();  	
	},
	
	reload: function() {
		window.location.reload();
	},
		
}


