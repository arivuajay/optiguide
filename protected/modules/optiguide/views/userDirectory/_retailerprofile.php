<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
       <div class="inner-container"> 
            <h2>  <?php echo Myclass::t('OGO214', '', 'og');?></h2>           
            <p>   <?php echo Myclass::t('OGO215', '', 'og');?></p>
            <div class="forms-cont"> 
                <div class="forms-heading"><i class="fa fa-user"></i> <?php echo $pmodel->COMPAGNIE; ?></div>
                <div class="row"> 
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <table class="table table-bordered" id="bckrnd"> 


                            <?php
                            if (!empty($pmodel)) {

                                $cityinfo = CityDirectory::model()->findByPk($pmodel->ID_VILLE);
                                $regionid = $cityinfo->ID_REGION;
                                $citynme = $cityinfo->NOM_VILLE;

                                $regioninfo = RegionDirectory::model()->findByPk($regionid);
                                $countryid = $regioninfo->ID_PAYS;
                                $regionnme = $regioninfo->NOM_REGION_EN;

                                $countryname = CountryDirectory::model()->findByPk($countryid)->NOM_PAYS_EN;
                                ?>
                                <tr>                                        
                                    <td><strong>Store name</strong></td>   
                                    <td><?php echo $pmodel->COMPAGNIE; ?></td>   
                                </tr>   

                                <tr>
                                    <td><strong>Type</strong></td>   
                                    <td><?php echo RetailerType::model()->findByPk($pmodel->ID_RETAILER_TYPE)->NOM_TYPE_EN; ?></td>   
                                </tr>

                                <tr>
                                    <td><strong>Grouping </strong></td>   
                                    <td><?php echo RetailerGroup::model()->find("ID_GROUPE=".$pmodel->ID_GROUPE)->NOM_GROUPE;   ?></td>   
                                </tr>

                                <?php if ($pmodel->HEAD_OFFICE_NAME != '') {
                                    ?>                                      
                                    <tr>                                        
                                        <td><strong>Head Office</strong></td>   
                                        <td><?php echo $pmodel->HEAD_OFFICE_NAME; ?></td>  
                                    </tr> 
                                <?php }
                                ?>  

                                <tr>                                        
                                    <td><strong>Establishment's primary profession or activity</strong></td>   
                                    <td><?php
                                            $cat = array();
                                            $cat[] = $pmodel->CATEGORY_1;
                                            $cat[] = $pmodel->CATEGORY_2;
                                            $cat[] = $pmodel->CATEGORY_3;
                                            $cat[] = $pmodel->CATEGORY_4;
                                            $cat[] = $pmodel->CATEGORY_5;
                                            $categories = array("0" => Myclass::t('OG105'), "1" => Myclass::t('OG106'), "2" => Myclass::t('OG107'), "3" => Myclass::t('OG108'), "4" => Myclass::t('OG109'));
                                           
                                            $str = '';
                                            foreach ($cat as $key => $info) {
                                                if ($info == 1) {
                                                    $str[] = $categories[$key];
                                                }
                                            }
                                            if (!empty($str)) {
                                                echo implode(',', $str);
                                            }
                                            ?>
                                    </td>  
                                </tr>   


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

                                <?php if ($pmodel->URL != '') {
                                    ?>  
                                    <tr>                                        
                                        <td><strong>Store Web site</strong></td>   
                                        <td><?php echo $pmodel->URL; ?></td>  
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

                                <?php if ($pmodel->established != '') {
                                    ?>  
                                    <tr>                                        
                                        <td><strong>Established since</strong></td>   
                                        <td><?php echo $pmodel->established; ?></td>  
                                    </tr> 
                                <?php }
                                ?>


                                <?php if ($pmodel->no_of_employee != '') {
                                    ?>  
                                    <tr>                                        
                                        <td><strong>Number of employees</strong></td>   
                                        <td><?php echo $pmodel->no_of_employee; ?></td>  
                                    </tr> 
                                <?php }
                                ?>

                                <?php if ($pmodel->services_offered != '') {
                                    ?>  
                                    <tr>                                        
                                        <td><strong>Services offered</strong></td>   
                                        <td><?php echo $pmodel->services_offered; ?></td>  
                                    </tr> 
                                <?php }
                                ?>

                                <?php if ($pmodel->description != '') {
                                    ?>  
                                    <tr>                                        
                                        <td><strong>Description</strong></td>   
                                        <td><?php echo $pmodel->description; ?></td>  
                                    </tr> 
                                <?php }
                                ?>

                                <?php if ($pmodel->turnover != '') {
                                    ?>  
                                    <tr>                                        
                                        <td><strong>TurnOver (in $)</strong></td>   
                                        <td><?php echo $pmodel->turnover; ?></td>  
                                    </tr> 
                                <?php }
                                ?>

                                <?php if ($pmodel->contact_person != '') {
                                    ?>  
                                    <tr>                                        
                                        <td><strong>Contact person</strong></td>   
                                        <td><?php echo $pmodel->contact_person; ?></td>  
                                    </tr> 
                                <?php }
                                ?>

                                <?php if ($pmodel->classification != '') {
                                    ?>  
                                    <tr>                                        
                                        <td><strong>Classification of goods</strong></td>   
                                        <td><?php echo $pmodel->classification; ?></td>  
                                    </tr> 
                                <?php }
                                ?>


                                <?php
                                $retid = $pmodel->ID_RETAILER;
                                $uinfos = UserDirectory::model()->find("ID_RELATION=$retid AND NOM_TABLE='Detaillants' and status=1");

                                if ($uinfos->ABONNE_MAILING != '0' || $uinfos->ABONNE_PROMOTION != '0' ||
                                        $uinfos->bSubscription_envision != '0' || $uinfos->bSubscription_envue != '0' ||
                                        $uinfos->print_envision != '0' || $uinfos->print_envue != '0') {

                                    $disptxt = array();

                                    if ($uinfos->ABONNE_MAILING == 1) {
                                        $disptxt[] = "OPTI-NEWS by e-mail";
                                    }

                                    if ($uinfos->ABONNE_PROMOTION == 1) {
                                        $disptxt[] = "OPTI-PROMOS by e-mail";
                                    }

                                    if ($uinfos->bSubscription_envision == 1) {
                                        $disptxt[] = "Free English digital magazine ENVISION";
                                    }

                                    if ($uinfos->bSubscription_envue == 1) {
                                        $disptxt[] = "Free French digital magazine ENVUE";
                                    }

                                    if ($uinfos->print_envision == 1) {
                                        $disptxt[] = "Envue Print Edition";
                                    }

                                    if ($uinfos->print_envue == 1) {
                                        $disptxt[] = "Envision Print Edition";
                                    }
                                    ?>  
                                    <tr>                                        
                                        <td><strong>Abonnement</strong></td>   
                                        <td><?php
                                            $k = 1;
                                            foreach ($disptxt as $info) {
                                                echo $k . ") " . $info . "<br>";
                                                $k++;
                                            }
                                            ?></td>  
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