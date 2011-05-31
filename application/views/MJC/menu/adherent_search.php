<script type="text/javascript">

 
	 Ext.QuickTips.init();
 
	// ----------------
	//	vars
	// ----------------
	var ds;	// datasource
	var grid; // grid component
	var searchfield; //form
 
	// ----------------
	//	Create searchform
	// ----------------	
	//The formfield is where the user types in the name. On each stroke, the input will be given to the datastore. 
	searchfield = new Ext.FormPanel({
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
 
	Ext.getCmp('<?=$win?>').add(searchfield);

 
	// ----------------
	//	Create datasource
	// ----------------

	ds = new Ext.data.Store({
 			fields: ['id','prenom','nom'],
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

    searchgrid = new Ext.grid.GridPanel(
    {
        store: ds, // use the datasource
		columns: [
			{dataIndex: 'nom', flex:1, sortable: true},
			{dataIndex: 'prenom',  sortable: true},
			{dataIndex: 'id',  hidden: true}
		],
		hideHeaders: true,
		autoScroll: true,
		listeners: {
			itemclick: function(g,i){ 
			    	MainApp.ViewPort.AppPort.layout.regions.center.removeAll();
			    	askAndDo(MainApp.ViewPort.AppPort.layout.regions.center.id,'interface/c_famille/display/'+i.data.id);
			}
		},
		stripeRows:true,
        autoHeight:true 
    });
	
    Ext.getCmp('<?=$win?>').add(searchgrid);	
 
</script>
