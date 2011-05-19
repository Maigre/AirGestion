<script type="text/javascript">


var panel = new Ext.FormPanel
		({
			//buttonAlign: 'center',
			//defaultType: 'textfield',
			//frame : true,
			//labelAlign : "top",
			//msgTarget: 'side',
			//method: 'post',		
			title: 'Recherche Adhérent',			
			//url: 'php/form.php',
			//width: 300,
			//height: 300,
			//collapsible: true,
			items : [{
						xtype:'textfield',
						id: 'searched_name',
						name: "",
						fieldLabel : "",
						enableKeyEvents: true,
						allowBlank: true,
						value:'',
						anchor:'100%'
					}]
		});
		


Ext.getCmp('searched_name').on('keyup', function() {	
	//console.info('yo');
	var searched_name = Ext.getCmp('searched_name').getValue();
	Ext.Ajax.request({
		    url: 'http://localhost/AirGestion/index.php/data/search/adherent',
		    method : 'POST',
		    params : {
		    	searched_name: searched_name
		    },
		    success: function(response){
		    		Ext.get('work-area').update(response.responseText,true);
		    }
		})
	var store = Ext.create('Ext.data.Store', {
		id: 'store',
		pageSize: 50,
		// allow the grid to interact with the paging scroller by buffering
		buffered: true,
		// never purge any data, we prefetch all up front
		purgePageCount: 0,
		proxy: {
			type: 'ajax',
			url: BASE_URL+'data/search/adherent',  // url that will load data with respect to start and limit params
			reader: {
			    type: 'json',
			    root: 'adherent',
			    totalProperty: 'size'
	   		}
		}
	});
	grid.update();
	Ext.getCmp('<?=$win?>').add(grid);
	
});	
	
//create store to stock the found adherents.
var store = Ext.create('Ext.data.Store', {
    id: 'store',
    pageSize: 50,
    // allow the grid to interact with the paging scroller by buffering
    buffered: true,
    // never purge any data, we prefetch all up front
    purgePageCount: 0,
    proxy: {
	    type: 'ajax',
	    url: BASE_URL+'data/search/adherent',  // url that will load data with respect to start and limit params
	    reader: {
	        type: 'json',
	        root: 'adherent',
	        totalProperty: 'size'
   		}
	}
});
    


var grid = Ext.create('Ext.grid.Panel', {
        //width: 700,
        height: 100,
        title: '',
        store: store,
        verticalScroller: {
            xtype: 'paginggridscroller',
            activePrefetch: false
        },
        loadMask: true,
        disableSelection: true,
        invalidateScrollerOnRefresh: false,
        viewConfig: {
            trackOver: false
        },
        // grid columns
        columns:[{
            text: 'Nom',
            flex:1 ,
            sortable: true,
            dataIndex: 'nom'
        },{
            text: 'Prenom',
            width: 125,
            sortable: true,
            dataIndex: 'prenom'
        }]
    });



Ext.getCmp('<?=$win?>').add(panel);
Ext.getCmp('<?=$win?>').add(grid);
</script>
