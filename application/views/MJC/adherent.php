<script type="text/javascript">

MainApp.Content = {
	
	Info_Panel_<?=$adherent->id?> : new PanelItem(),
	
	make_info_<?=$adherent->id?> : function () {
		
		this.Info_Panel_<?=$adherent->id?>.panel = new Ext.Panel({  
						id: 'Info_Adherent_<?=$adherent->id?>-panel',
						bodyStyle: 'padding:5px',
						border: 0,
						html: '<table class="tableau_membre">'+
		                        <?php if ($adherent->datenaissance > 0): ?> 
		                        '<TR><TD><?=icon('cake')?></TD><TD><?=date('d M Y',strtotime($adherent->datenaissance))?></TD></TR>'+
		                        <?php endif; ?>
		                        <?php if ($adherent->email != ''): ?> 
		                        '<TR><TD>Email</TD><TD><?=$adherent->email?></TD></TR>'+
								<?php endif; ?>
								<?php if ($adherent->telportable > 0): ?>
		                        '<TR><TD>Portable</TD><TD><?=$adherent->telportable?></TD></TR>'+
		                        <?php endif; ?>
		                        <?php if ($adherent->statutadherent->id <= 2): ?> 
		                        	<?php if ($adherent->teldomicile > 0): ?> '<TR><TD>Domicile</TD><TD><?=$adherent->teldomicile?></TD></TR>'+<?php endif; ?>
		                        	<?php if ($adherent->telprofessionel > 0): ?> '<TR><TD>Travail</TD><TD><?=$adherent->telprofessionel?></TD></TR>'+<?php endif; ?>
		                        <?php endif; ?>
		                        '<TR><TD colspan="2"><hr></TD></TR>'+
		                        '<TR><TD>Regime</TD><TD><b><?=($adherent->sansviandesansporc==1)?'SVSP':'';?></b></TD></TR>'+
		                        <?php if ($adherent->statutadherent->id <= 2): ?> 
		                        '<TR><TD>Allocataire</TD><TD><?=($adherent->allocataire==1)?'OUI':'NON'?></TD></TR>'+
		                        '<TR><TD>N° allocataire</TD><TD><?=$adherent->noallocataire?></TD></TR>'+
		                        '<TR><TD>Employeur</TD><TD><?=$adherent->employeur?></TD></TR>'+
			                    '<TR><TD>CSP</TD><TD><?=$adherent->csp->nom?></TD></TR>'+
			                    '<TR><TD>Sit. familiale</TD><TD><?=$adherent->situationfamiliale->nom?></TD></TR>'+
		                        <?php endif; ?>
		                        <?php if ($adherent->statutadherent->id >= 3): ?> 
		                        '<TR><TD>Santé</TD><TD><?=($adherent->fichesanitaire==1)?'OUI':'NON'?></TD></TR>'+
                           		'<TR><TD>A. Sortie</TD><TD><?=($adherent->autorisationsortie==1)?'OUI':'NON'?></TD></TR>'+
                            	<?php endif; ?>      	
                            	'<TR><TD>N° sécu</TD><TD><?=$adherent->nosecu?></TD></TR>'+
                            '</table>'
                     });
        
        Ext.getCmp('<?=$win?>').removeAll();             
		Ext.getCmp('<?=$win?>').add(this.Info_Panel_<?=$adherent->id?>.get());
		
		<?php $title='';
		if (isset($adherent->prenom)){
			$title=$title.$adherent->prenom;
		}
		if (isset($adherent->nom)){
			$title=$title.' '.$adherent->nom;
		}
		if (isset($adherent->datenaissance)){
			$title=$title.' '.calcul_age($adherent->datenaissance).' ans';
		}
		?>
		Ext.getCmp('<?=$win?>').setTitle('<?=$title?>');
		<?php if ($adherent->sexe == 1): ?> 
			Ext.getCmp('<?=$win?>').setIconCls('user_female'); 
		<?php endif; ?>
	}
}
MainApp.Content.make_info_<?=$adherent->id?>();
</script>
