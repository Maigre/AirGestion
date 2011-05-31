<script type="text/javascript">

MainApp.Content = {

	Referent : new PanelItem(),
	Conjoint : new PanelItem(),
	<?php if (isset($enfants)) foreach($enfants as $i=>$kid): ?>
		Enfant_<?=$i?>: new PanelItem(),
	<?php endforeach; ?>
	
	width : 200,
	height_adults : 210,
	height_kids : 150,
	margin : 5,

	addMember : function (w_id,a_id,himself) {	
		return new Ext.Panel({  
						id: w_id,
						him: himself,
						//x: this.x,
						//y: this.y,
						//height: c_height,
						autoHeight: true,
						autoWidth: true,
						bodyStyle: 'padding:5px',
						minWidth:  this.width,
						title: 'Adherent '+a_id,
						iconCls: 'user',
						constrain: true,
						layout: 'auto',
						style : 'margin-left:5px;margin-top:5px',
						url: 'interface/c_adherent/display/'+a_id,				
						tools: [{
								   type: 'refresh',
								   handler: function(e,f,g){
									   g.ownerCt.url = 'interface/c_adherent/form/'+a_id;
									   g.ownerCt.him.load();
									   //this.ownerCt.ownerCt.parent.load();
									   //console.info(this.ownerCt.ownerCt);
									   //Ext.getCmp('Main_Panel_Referent').setAutoHeight(true);
									   //Ext.getCmp('Main_Panel_Referent').setAutoWidth(true);
									   //Ext.getCmp('Main_Panel_Referent').close();
									  // Window_Referent_form.init();
							   		}
							   	}]
			});
	},
	
	make : function () {
		
		Ext.getCmp('<?=$win?>').removeAll();
		
		this.Referent.panel = this.addMember('Content_Referent-panel',<?=$referent?>,this.Referent);
		this.Referent.load();
		Ext.getCmp('<?=$win?>').add(this.Referent.get());
		
		<?php if (isset($conjoint)): ?> 
			this.Conjoint.panel = this.addMember('Content_Conjoint-panel',<?=$conjoint?>,this.Conjoint); 
			this.Conjoint.load();
			Ext.getCmp('<?=$win?>').add(this.Conjoint.get());
		<?php endif; ?>
		
		<?php if (isset($enfants)) foreach($enfants as $i=>$kid): ?>
			this.Enfant_<?=$i?>.panel = this.addMember('Content_Enfant_<?=$i?>-panel',<?=$kid?>,this.Enfant_<?=$i?>); 
			this.Enfant_<?=$i?>.load();
			Ext.getCmp('<?=$win?>').add(this.Enfant_<?=$i?>.get());
		<?php endforeach; ?>

	}
}

MainApp.Content.make();
</script>
