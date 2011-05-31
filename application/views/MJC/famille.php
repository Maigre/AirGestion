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

	addMember : function (w_id,a_id,c_height) {
		return new Ext.Panel({  
						id: w_id,
						//x: this.x,
						//y: this.y,
						//height: c_height,
						autoHeight: true,
						width:  this.width,
						title: 'Adherent '+a_id,
						iconCls: 'user',
						constrain: true,
						layout: 'auto',
						style : 'margin-left:5px;margin-top:5px',
						url: 'interface/c_adherent/display/'+a_id,				
						tools: [{
								   type: 'refresh',
								   handler: function(){
									   
									   //Ext.getCmp('Main_Panel_Referent').close();
									   //Window_Referent_form.init();
							   		}
							   	}]
			});
		
	},
	
	make : function () {
		
		this.x = this.margin;
		this.y = this.margin;
		
		this.Referent.panel = this.addMember('Content_Referent-panel',<?=$referent?>);
		this.Referent.load();
		Ext.getCmp('<?=$win?>').add(this.Referent.get());
		
		this.x = this.x + this.margin + this.width;
		
		<?php if (isset($conjoint)): ?> 
			this.Conjoint.panel = this.addMember('Content_Conjoint-panel',<?=$conjoint?>); 
			this.Conjoint.load();
			Ext.getCmp('<?=$win?>').add(this.Conjoint.get());
		<?php endif; ?>
		
		this.x = this.margin;
		this.y = this.y + this.margin + this.height_adults;
		
		<?php if (isset($enfants)) foreach($enfants as $i=>$kid): ?>
			this.Enfant_<?=$i?>.panel = this.addMember('Content_Enfant_<?=$i?>-panel',<?=$kid?>); 
			this.Enfant_<?=$i?>.load();
			Ext.getCmp('<?=$win?>').add(this.Enfant_<?=$i?>.get());
			<?=(($i/2)==abs($i/2))?'this.x = this.x + this.margin + this.width;':'this.x = this.margin; this.y = this.y + this.margin + this.height_kids;';?>
		<?php endforeach; ?>
				
	}
}

MainApp.Content.make();
</script>
