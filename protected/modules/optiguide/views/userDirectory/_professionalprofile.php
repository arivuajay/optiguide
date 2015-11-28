<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
        <div class="inner-container"> 
            <h2>  <?php echo Myclass::t('OGO214', '', 'og');?></h2>           
            <p>   <?php echo Myclass::t('OGO215', '', 'og');?></p>
            <div class="forms-cont"> 
                <div class="forms-heading"><i class="fa fa-user"></i> <?php echo $pmodel->NOM; ?></div>
                <div class="row"> 
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <table class="table table-bordered" id="bckrnd"> 

                            <?php                          
                            
                            if (!empty($pmodel)) {
                                
                            $cityinfo    = CityDirectory::model()->findByPk($pmodel->ID_VILLE);
                            $regionid    = $cityinfo->ID_REGION;
                            $citynme     = $cityinfo->NOM_VILLE;
                            
                            $regioninfo  = RegionDirectory::model()->findByPk($regionid);
                            $countryid   = $regioninfo->ID_PAYS;
                            $regionnme   = $regioninfo->NOM_REGION_EN;
                            
                            $countryname = CountryDirectory::model()->findByPk($countryid)->NOM_PAYS_EN;
                                
                                ?>
                                <tr>                                        
                                    <td><strong>Nom</strong></td>   
                                    <td><?php echo $pmodel->NOM; ?></td>   
                                </tr>   
                                
                                 <tr>                                        
                                    <td><strong>Prenom</strong></td>   
                                    <td><?php echo $pmodel->PRENOM; ?></td>   
                                </tr>  
                                
                                <tr>
                                    <td><strong>Type</strong></td>   
                                    <td><?php echo ProfessionalType::model()->findByPk($pmodel->ID_TYPE_SPECIALISTE)->TYPE_SPECIALISTE_EN; ?></td>   
                                </tr>

                                <?php if ($pmodel->BUREAU != '') {
                                    ?>                                      
                                    <tr>                                        
                                        <td><strong>Numéro de local/bureau</strong></td>   
                                        <td><?php echo $pmodel->BUREAU; ?></td>  
                                    </tr> 
                                <?php }
                                ?>   
                                 <tr>                                        
                                    <td><strong>Adresse</strong></td>   
                                    <td><?php echo $pmodel->ADRESSE; ?></td>  
                                </tr> 
                                
                                <tr>                                        
                                    <td><strong>Ville</strong></td>   
                                    <td><?php echo $citynme; ?></td>  
                                </tr> 

                                <tr>                                        
                                    <td><strong>Province</strong></td>   
                                    <td><?php echo $regionnme; ?></td>  
                                </tr> 

                                <tr>                                        
                                    <td><strong>Pays</strong></td>   
                                    <td><?php echo $countryname; ?></td>  
                                </tr> 
                                
                                 <?php if ($pmodel->CODE_POSTAL != '') {
                                    ?>  
                                    <tr>                                        
                                        <td><strong>Pincode</strong></td>   
                                        <td><?php echo $pmodel->CODE_POSTAL; ?></td>  
                                    </tr> 
                                <?php }
                                ?>

                                <?php if ($pmodel->TELEPHONE != '') {
                                    ?>   
                                    <tr>                                        
                                        <td><strong>Téléphone</strong></td>   
                                        <td><?php echo $pmodel->TELEPHONE; ?></td>  
                                    </tr> 
                                <?php }
                                ?>

                                <?php if ($pmodel->TELEPHONE2 != '') {
                                    ?>  
                                    <tr>                                        
                                        <td><strong>Téléphone 2</strong></td>   
                                        <td><?php echo $pmodel->TELEPHONE2; ?></td>  
                                    </tr> 
                                <?php }
                                ?>

                                <?php if ($pmodel->TELECOPIEUR != '') {
                                    ?>  
                                    <tr>                                        
                                        <td><strong>Fax</strong></td>   
                                        <td><?php echo $pmodel->TELECOPIEUR; ?></td>  
                                    </tr> 
                                <?php }
                                ?>
                                    
                                <?php if ($pmodel->COURRIEL != '') {
                                    ?>  
                                    <tr>                                        
                                        <td><strong>Courriel</strong></td>   
                                        <td><?php echo $pmodel->COURRIEL; ?></td>  
                                    </tr> 
                                <?php }
                                ?>

                                <?php if ($pmodel->SITE_WEB != '') {
                                    ?>  
                                    <tr>                                        
                                        <td><strong>Website</strong></td>   
                                        <td><?php echo $pmodel->SITE_WEB; ?></td>  
                                    </tr> 
                                <?php }
                                ?>
                                <?php
                                $profid = $pmodel->ID_SPECIALISTE;
                                $uinfos = UserDirectory::model()->find("ID_RELATION=$profid AND NOM_TABLE='Professionnels' and status=1");
                                
                                if ($uinfos->ABONNE_MAILING != '0' || $uinfos->ABONNE_PROMOTION != '0' ||
                                    $uinfos->bSubscription_envision != '0' || $uinfos->bSubscription_envue != '0' ||
                                    $uinfos->print_envision != '0' || $uinfos->print_envue != '0') 
                                {
                                    
                                    $disptxt = array();
                                    
                                    if($uinfos->ABONNE_MAILING==1){
                                        $disptxt[] = "OPTI-NEWS by e-mail";
                                    }
                                    
                                    if($uinfos->ABONNE_PROMOTION==1){
                                        $disptxt[] = "OPTI-PROMOS by e-mail";
                                    }
                                    
                                    if($uinfos->bSubscription_envision==1){                                        
                                        $disptxt[] = "Free English digital magazine ENVISION";
                                    }
                                    
                                    if($uinfos->bSubscription_envue==1){                                        
                                        $disptxt[] = "Free French digital magazine ENVUE";
                                    }
                                    
                                    if($uinfos->print_envision==1){                                        
                                        $disptxt[] = "Envue Print Edition";
                                    }
                                    
                                    if($uinfos->print_envue==1){
                                        $disptxt[] = "Envision Print Edition";
                                    }    
                                    
                                                                      
                                ?>  
                                    <tr>                                        
                                        <td><strong>Abonnement</strong></td>   
                                        <td><?php
                                        $k=1;
                                        foreach($disptxt as $info)
                                        {    
                                            echo $k.") ".$info."<br>";
                                            $k++;
                                        }    ?></td>  
                                    </tr> 
                                <?php 
                                }
                                ?>
                                    
                           <?php }
                            ?>                  
                        </table>
                    </div> 
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <p class="confirmation-cont"> <a href="javascript:void(0);" id="confirmation-yes"><?php echo Myclass::t('OGO218', '', 'og');?></a> , <?php echo Myclass::t('OGO216', '', 'og');?>. </p>
                    <p class="confirmation-cont nolink"> <a href="<?php echo $this->createUrl($profileurl);?>"><?php echo Myclass::t('OGO219', '', 'og');?></a> , <?php echo Myclass::t('OGO217', '', 'og');?>. </p>
                     <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'validation-confirm-form',
                        'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
                    ));
                    $model->MUST_VALIDATE = 1;
                    echo $form->hiddenField($model, 'MUST_VALIDATE');
                    $this->endWidget(); ?>
                </div>
            </div>
        </div>
    </div>   
</div>
<?php
$js = <<< EOD
$(document).ready(function(){
    
   $('#confirmation-yes').live('click',function(event){
      $('#validation-confirm-form').submit();
       return false; 
    });
            
});
EOD;
Yii::app()->clientScript->registerScript('_form_validate', $js);
?>