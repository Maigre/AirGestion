<script type="text/javascript">

Ext.override(Ext.form.Field, {
        fireKey : function(e) {
            if(((Ext.isIE && e.type == 'keydown') || e.type == 'keypress') && e.isSpecialKey()) {
                this.fireEvent('specialkey', this, e);
            }
            else {
                this.fireEvent(e.type, this, e);
            }
        }
      , initEvents : function() {
            /*this.el.on("focus", this.onFocus,  this);
            this.el.on("blur", this.onBlur,  this);
            this.el.on("keydown", this.fireKey, this);
            this.el.on("keypress", this.fireKey, this);*/
            this.el.on("keyup", this.fireKey, this);
            this.originalValue = this.getValue();
        }
    });
 
 
	 Ext.QuickTips.init();
 
	// ----------------
	//	vars
	// ----------------
	var ds;	// datasource
	var grid; // grid component
	var xg = Ext.grid;
	var expander;
	var simple;
 
	// ----------------
	//	Create searchform
	// ----------------	
	//The formfield is where the user types in the name. On each stroke, the input will be given to the datastore. 
	
	function createSearchForm()
	{
    	simple = new Ext.FormPanel({
		    //width:180,
	        labelWidth: 75,
	        frame:true,
	        title: 'Rechercher adhérent',
	        bodyStyle:'padding:5px 5px 0',
	        //defaults: {width: 180},
	        //defaultType: 'textfield',
 
	        items: [{
	                xtype: 'textfield',
	                fieldLabel: '',
	                name: 'searched_name',
	                allowBlank:true,
	                enableKeyEvents: true,
 
					listeners: 
					{
						keyup: function(el,type)
						{
							var theQuery=el.getValue();
 							
							ds.load(
							{
								params: 
								{	
									name_search: theQuery
								}
							});
							
							//createGrid();
 
						}
					}
	            }
	        ]	
    	});
 
	   Ext.getCmp('<?=$win?>').add(simple)	;
	}	
 
	// ----------------
	//	Create datasource
	// ----------------

			ds = new Ext.data.Store({
            /*
            proxy: new Ext.data.HttpProxy({
                url: BASE_URL+'data/search/adherent',
                method: 'POST'
            }),                        
 			*/
 			//pageSize: 50,
			// allow the grid to interact with the paging scroller by buffering
			//buffered: true,
			// never purge any data, we prefetch all up front
			//purgePageCount: 0,
 			fields: ['prenom','nom'],
 			autoLoad: true,
 			proxy: {
				type: 'ajax',
				url: BASE_URL+'data/search/adherent',  // url that will load data with respect to start and limit params
			    actionMethods : {read: 'POST'},
				reader : {
			    	type : 'json',
					//totalProperty: 'size',
					root: 'adherent'
				}
			    /*
				remoteSort: true,
				
				reader: {
					type: 'json',
					root: 'searched_name',
					totalProperty: 'size'
		   		}*/
			},
			            			
		});				
	
 
 
	// ----------------
	//	Create expander
	// ----------------	
    /*
    var expander = new xg.RowExpander({
        tpl : new Ext.Template(
            '<p>{comments}</p>'
        )
    });
    */	
 
 
 
	// ----------------
	//	Create grid
	// ----------------	

	    searchgrid = new xg.GridPanel(
	    {
	        store: ds, // use the datasource
 			columns: [
				{header: 'Prenom',  dataIndex: 'prenom',  sortable: true},
				{header: 'Nom', dataIndex: 'nom',flex:1, sortable: true}
			],
			hideHeaders: true,
			autoScroll: true,
	        /*listeners: {
				rowclick:{function(grid, rowIndex, e) {
				  		alert('yo');
				  		console.log('click el');
					}
				}
			},
	        viewConfig: 
	        {
	            forceFit:true
	        },
 			*/
 			listeners: {
				click: {
				    element: 'el', //bind to the underlying el property on the panel
				    fn: function(){ 
				    	console.log('click el');
				    	askAndDo(MainApp.ViewPort.AppPort.layout.regions.center.id,'interface/c_famille/display');//'display/1');
				    }
				},
				dblclick: {
				    element: 'body', //bind to the underlying body property on the panel
				    fn: function(){ console.log('dblclick body'); }
				}
    		},
	        //plugins: expander,
			//collapsible: true,
			//animCollapse: false,
 			stripeRows:true,
	        //title:'Search results',
	        //iconCls:'icon-grid',
	        //renderTo: Ext.getCmp('<?=$win?>'),
	        autoHeight:true 
	        //height : 100
	    });
	/*
	grid.on('rowdblclick',
		function(mygrid, rowIndex, e) {
		showdialog(rowIndex, mygrid, mygrid.store, top, false, 'rowdblclick', bdate, ltime);
	});*/

	createSearchForm();

    Ext.getCmp('<?=$win?>').add(searchgrid);	
 
</script>
