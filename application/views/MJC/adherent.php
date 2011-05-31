<script type="text/javascript">

MainApp.Content = {
	
	Info_Panel_<?=$adherent->id?> : new PanelItem(),
	
	make_info_<?=$adherent->id?> : function () {
		
		this.Info_Panel_<?=$adherent->id?>.panel = new Ext.Panel({  
						id: 'Info_Adherent_<?=$adherent->id?>-panel',
						bodyStyle: 'padding:5px',
						border: 0,
						html: '<table class="tableau_membre">'+
		                        '<TR><TD><?=icon('cake right')?></TD><TD><?=date('d M Y',strtotime($adherent->datenaissance))?></TD></TR>'+
		                        '<TR><TD>Email</TD><TD><?=$adherent->email?></TD></TR>'+
		                        '<TR><TD>Portable</TD><TD><?=$adherent->telportable?></TD></TR>'+
		                        <?php if ($adherent->statutadherent->id <= 2): ?> 
		                        	<?php if ($adherent->teldomicile != ''): ?> '<TR><TD>Domicile</TD><TD><?=$adherent->teldomicile?></TD></TR>'+<?php endif; ?>
		                        	<?php if ($adherent->telprofessionel != ''): ?> '<TR><TD>Travail</TD><TD><?=$adherent->telprofessionel?></TD></TR>'+<?php endif; ?>
		                        <?php endif; ?>
		                        '<TR><TD colspan="2"><hr></TD></TR>'+
		                        '<TR><TD>Regime</TD><TD><b><?=($adherent->sansviandesansporc==1)?'SVSP':'';?></b></TD></TR>'+
		                        <?php if ($adherent->statutadherent->id <= 2): ?> 
		                        '<TR><TD>Allocataire</TD><TD><?=$adherent->allocataire?></TD></TR>'+
		                        '<TR><TD>N° allocataire</TD><TD><?=$adherent->noallocataire?></TD></TR>'+
		                        '<TR><TD>Employeur</TD><TD><?=$adherent->employeur?></TD></TR>'+
			                    '<TR><TD>CSP</TD><TD><?=$adherent->csp->nom?></TD></TR>'+
			                    '<TR><TD>Sit. familiale</TD><TD><?=$adherent->situationfamiliale->nom?></TD></TR>'+
		                        <?php endif; ?>
		                        <?php if ($adherent->statutadherent->id >= 3): ?> 
		                        '<TR><TD>Santé</TD><TD><?=$adherent->fichesanitaire?></TD></TR>'+
                           		'<TR><TD>A. Sortie</TD><TD><?=($adherent->autorisationsortie==1)?'OUI':'NON'?></TD></TR>'+
                            	<?php endif; ?>      	
                            	'<TR><TD>N° sécu</TD><TD><?=$adherent->nosecu?></TD></TR>'+
                            '</table>'
                     });
        
        Ext.getCmp('<?=$win?>').removeAll();             
		Ext.getCmp('<?=$win?>').add(this.Info_Panel_<?=$adherent->id?>.get());
		Ext.getCmp('<?=$win?>').setTitle('<?=$adherent->prenom.' '.$adherent->nom.' - '.calcul_age($adherent->datenaissance).' ans'?>');
		<?php if ($adherent->sexe == 1): ?> 
			Ext.getCmp('<?=$win?>').setIconCls('user_female'); 
		<?php endif; ?>
	}
}
MainApp.Content.make_info_<?=$adherent->id?>();
</script>
