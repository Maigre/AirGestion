<script type="text/javascript">

MainApp.Content = {


	make : function () {

		// ----------------
		//	Create datasource
		// ----------------

	
		var mydata = [
				<?php $count=0;
				foreach($familles as $famille){?>
					<?php if ($count>0) {echo ',';}?>
					<?php $count=$count+1 ?>
					['<?=$famille['nom']?>','<?=$famille['prenom']?>',<?=$famille['id']?>,<?=$famille['idFamille']?>]
				<?php } ?>
		];
		
		var ds = new Ext.data.ArrayStore({
			fields: [
				{name: 'nom',  type: 'string'},
				{name: 'prenom',  type: 'string'},
				{name: 'id',    type: 'int'},
				{name: 'idFamille',    type: 'int'}
			]
		});
		ds.loadData(mydata);
	 
		// ----------------
		//	Create grid
		// ----------------	

		this.searchgrid = new Ext.grid.GridPanel(
		{
			id: 'searchgrid',
			store: ds, // use the datasource
			columns: [
				{dataIndex: 'nom', flex:1, sortable: true},
				{dataIndex: 'prenom',  sortable: true},
				{dataIndex: 'id',  hidden: true},
				{dataIndex: 'idFamille',  hidden: true}
			],
			hideHeaders: true,
			autoScroll: true,
			listeners: {
				itemclick: function(g,i){ 
						askAndDo(MainApp.ViewPort.AppPort.layout.regions.center.id,'interface/c_famille/display/'+i.data.idFamille+'/'+i.data.id);			    	
						Ext.getCmp('doublefamilleWindow').close();
				}
			},
			stripeRows:true,
			autoHeight:true 
		});	

	
		doublefamilleWindow = new Ext.Window({
					id: 'doublefamilleWindow',
					title: 'Sélection famille par adhérent',
					width: 240,
					layout: 'fit',
					modal: true,
					closable: true,
					resizable: true,
					items: [this.searchgrid],
					url: BASE_URL+'interface/c_adherent/save/1'
				});
		Ext.getCmp('doublefamilleWindow').show();	
	}	
}
MainApp.Content.make();
</script>
