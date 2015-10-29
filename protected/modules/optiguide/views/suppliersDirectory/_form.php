<?php
/* @var $this SuppliersDirectoryController */
/* @var $model SuppliersDirectory */
/* @var $form CActiveForm */

$cs_pos_end = CClientScript::POS_END;
$themeUrl = $this->themeUrl;
//$actn_url = Yii::app()->createUrl('/admin/suppliersDirectory/create/');
//check if session exists
if (Yii::app()->user->hasState("scountry")) {
    //get session variable
    $scountry = Yii::app()->user->getState("scountry");
    $model->country = $scountry;
    $sregion = Yii::app()->user->getState("sregion");
    $model->region = $sregion;
}

$suppliertypes = CHtml::listData(SupplierType::model()->findAll(), 'ID_TYPE_FOURNISSEUR', 'TYPE_FOURNISSEUR_FR');
$country = Myclass::getallcountries();
$regions = Myclass::getallregions($model->country);
$cities = Myclass::getallcities($model->region);
//$archivecats = CHtml::listData(ArchiveCategory::model()->findAll(array("order" => 'NOM_CATEGORIE_FR')), 'ID_CATEGORIE', 'NOM_CATEGORIE_FR');
?>

<div class="row"> 

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 subscribe-btncont"> 
        <div class="inner-container"> 
            <h2> <?php echo $model->isNewRecord ? Myclass::t('OGO81', '', 'og') : Myclass::t('OG034', '', 'og'); ?> </h2>

            <?php
            if ($model->isNewRecord) {
                $this->renderPartial('_menu_steps', array());
            }
            ?>

            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'suppliers-directory-form',
                'htmlOptions' => array('role' => 'form'),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'enableAjaxValidation' => true,
            ));
            ?>

            <div class="forms-cont"> 
                <div class="forms-heading"><i class="fa fa-building"></i>   <?php echo Myclass::t('OG112'); ?>  </div>
                <div class="row"> 

                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php echo $form->labelEx($model, 'COMPAGNIE', array()); ?> 
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">  
                            <?php echo $form->textField($model, 'COMPAGNIE', array('class' => 'form-txtfield', 'size' => 60, 'maxlength' => 255)); ?>
                            <?php echo $form->error($model, 'COMPAGNIE'); ?>
                        </div>
                    </div>



                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php echo $form->labelEx($model, 'ID_TYPE_FOURNISSEUR', array()); ?> 
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">                                                                                     
                            <?php echo $form->dropDownList($model, 'ID_TYPE_FOURNISSEUR', $suppliertypes, array('class' => 'selectpicker')); ?>                          
                            <?php echo $form->error($model, 'ID_TYPE_FOURNISSEUR'); ?>   
                        </div>
                    </div>                   

                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">  
                            <?php echo $form->labelEx($umodel, 'USR'); ?> 
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                            <?php if ($model->isNewRecord) {
                                ?> 
                                <?php echo $form->textField($umodel, 'USR', array('class' => 'form-txtfield')); ?>
                                <?php echo $form->error($umodel, 'USR'); ?>
                                <?php echo $form->error($model, 'ID_CLIENT'); ?>
                                <?php
                            } else {
                                echo $umodel->USR;
                            }
                            ?>
                        </div>
                    </div>

                    <?php if ($model->isNewRecord) {
                        ?>
                        <div class="form-row1"> 
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                                <?php echo $form->labelEx($umodel, 'PWD'); ?>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                                <?php echo $form->passwordField($umodel, 'PWD', array('class' => 'form-txtfield')); ?>
                                <?php echo $form->error($umodel, 'PWD'); ?>
                            </div>
                        </div>
                    <?php }
                    ?>

                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php echo $form->labelEx($model, 'ADRESSE', array()); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">     
                            <?php echo $form->textField($model, 'ADRESSE', array('class' => 'form-txtfield', 'size' => 60, 'maxlength' => 255)); ?>                           
                        </div>    
                    </div>

                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            &nbsp;
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">     
                            <?php echo $form->textField($model, 'ADRESSE2', array('class' => 'form-txtfield', 'size' => 60, 'maxlength' => 255)); ?>
                            <?php echo $form->error($model, 'ADRESSE'); ?>
                        </div>    
                    </div>  

                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php echo $form->labelEx($model, 'country', array()); ?>    
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                            <?php echo $form->dropDownList($model, 'country', $country, array('class' => 'selectpicker', 'empty' => Myclass::t('APP43'))); ?>                         
                            <?php echo $form->error($model, 'country'); ?>
                        </div>
                    </div>                          

                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php echo $form->labelEx($model, 'region', array()); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                            <?php echo $form->dropDownList($model, 'region', $regions, array('class' => 'selectpicker', 'empty' => Myclass::t('APP44'))); ?>                         
                            <?php echo $form->error($model, 'region'); ?>
                        </div>
                    </div>

                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php echo $form->labelEx($model, 'ID_VILLE', array()); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">    
                            <?php echo $form->dropDownList($model, 'ID_VILLE', $cities, array('class' => 'selectpicker', 'empty' => Myclass::t('APP59'))); ?>  
                            <?php echo $form->error($model, 'ID_VILLE'); ?>
                        </div>    
                    </div>

                    <div class="form-row1" id="other_city" style="display:none;"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                            <?php echo $form->labelEx($model, 'autre_ville'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                            <?php echo $form->textField($model, 'autre_ville', array('class' => 'form-txtfield')); ?>      
                            <?php echo $form->error($model, 'autre_ville'); ?>
                        </div>
                    </div>

                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php echo $form->labelEx($model, 'CODE_POSTAL', array()); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">     
                            <?php echo $form->textField($model, 'CODE_POSTAL', array('class' => 'form-control', 'size' => 20, 'maxlength' => 20)); ?>
                            <?php echo $form->error($model, 'CODE_POSTAL'); ?>
                        </div>     
                    </div>

                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php echo $form->labelEx($model, 'TELEPHONE', array()); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">     
                            <?php echo $form->textField($model, 'TELEPHONE', array('class' => 'form-control', 'size' => 20, 'maxlength' => 20)); ?>
                            <?php echo $form->error($model, 'TELEPHONE'); ?>
                        </div>     
                    </div>

                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php echo $form->labelEx($model, 'TELECOPIEUR', array()); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">     
                            <?php echo $form->textField($model, 'TELECOPIEUR', array('class' => 'form-control', 'size' => 20, 'maxlength' => 20)); ?>
                            <?php echo $form->error($model, 'TELECOPIEUR'); ?>
                        </div>     
                    </div>

                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php echo $form->labelEx($model, 'TEL_SANS_FRAIS', array()); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">        
                            <?php echo $form->textField($model, 'TEL_SANS_FRAIS', array('class' => 'form-control', 'size' => 20, 'maxlength' => 20)); ?>
                            <?php echo $form->error($model, 'TEL_SANS_FRAIS'); ?>
                        </div>     
                    </div>

                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php echo $form->labelEx($model, 'TEL_SECONDAIRE', array()); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">        
                            <?php echo $form->textField($model, 'TEL_SECONDAIRE', array('class' => 'form-control', 'size' => 20, 'maxlength' => 20)); ?>
                            <?php echo $form->error($model, 'TEL_SECONDAIRE'); ?>
                        </div>     
                    </div>

                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php echo $form->labelEx($model, 'COURRIEL', array()); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">     
                            <?php echo $form->textField($model, 'COURRIEL', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                            <?php echo $form->error($model, 'COURRIEL'); ?>
                        </div>     
                    </div>

                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php echo $form->labelEx($model, 'SITE_WEB', array()); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">     
                            <?php echo $form->textField($model, 'SITE_WEB', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>(http://www.monsite.com )
                            <?php echo $form->error($model, 'SITE_WEB'); ?>
                        </div> 
                    </div>

                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php echo $form->labelEx($model, 'SUCCURSALES', array()); ?>    
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">        
                            <?php echo $form->textField($model, 'SUCCURSALES', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                            <?php echo $form->error($model, 'SUCCURSALES'); ?>
                        </div>     
                    </div>

                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php echo $form->labelEx($model, 'ETABLI_DEPUIS', array()); ?>   
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">        
                            <?php echo $form->textField($model, 'ETABLI_DEPUIS', array('class' => 'form-control', 'size' => 20, 'maxlength' => 20)); ?>
                            <?php echo $form->error($model, 'ETABLI_DEPUIS'); ?>  
                        </div>      
                    </div>

                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php echo $form->labelEx($model, 'NB_EMPLOYES', array()); ?>     
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">        
                            <?php echo $form->textField($model, 'NB_EMPLOYES', array('class' => 'form-control', 'size' => 10, 'maxlength' => 10)); ?>
                            <?php echo $form->error($model, 'NB_EMPLOYES'); ?>  
                        </div>     
                    </div>

                </div>
            </div>

            <div class="forms-cont"> 
                <div class="forms-heading"><i class="fa fa-user"></i>   <?php echo Myclass::t('OG131'); ?>  </div>
                <div class="row"> 


                    <?php if (Yii::app()->session['language'] == "EN") {
                        ?>   
                        <div class="form-row1"> 
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                                <?php echo $form->labelEx($model, 'PERSONNEL_TITRE1_EN', array()); ?>    
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">     
                                <?php echo $form->textField($model, 'PERSONNEL_TITRE1_EN', array('class' => 'form-control', 'size' => 60)); ?>
                                <?php echo $form->error($model, 'PERSONNEL_TITRE1_EN'); ?>    
                            </div>
                        </div>
                        <?php
                    } else {
                        ?>
                        <div class="form-row1"> 
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                                <?php echo $form->labelEx($model, 'PERSONNEL_TITRE1', array()); ?>     
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">     
                                <?php echo $form->textField($model, 'PERSONNEL_TITRE1', array('class' => 'form-control', 'size' => 60)); ?>
                                <?php echo $form->error($model, 'PERSONNEL_TITRE1'); ?>    
                            </div>
                        </div>
                    <?php } ?>

                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php echo $form->labelEx($model, 'PERSONNEL_NOM1', array()); ?> 
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">     
                            <?php echo $form->textField($model, 'PERSONNEL_NOM1', array('class' => 'form-control', 'size' => 60)); ?>
                            <?php echo $form->error($model, 'PERSONNEL_NOM1'); ?>
                        </div>
                    </div>                    

                    <?php if (Yii::app()->session['language'] == "EN") {
                        ?>  

                        <div class="form-row1"> 
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                                <?php echo $form->labelEx($model, 'PERSONNEL_TITRE2_EN', array()); ?> 
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">     
                                <?php echo $form->textField($model, 'PERSONNEL_TITRE2_EN', array('class' => 'form-control', 'size' => 60)); ?>
                                <?php echo $form->error($model, 'PERSONNEL_TITRE2_EN'); ?>  
                            </div>
                        </div>
                        <?php
                    } else {
                        ?>
                        <div class="form-row1"> 
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                                <?php echo $form->labelEx($model, 'PERSONNEL_TITRE2', array()); ?>    
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">     
                                <?php echo $form->textField($model, 'PERSONNEL_TITRE2', array('class' => 'form-control', 'size' => 60)); ?>
                                <?php echo $form->error($model, 'PERSONNEL_TITRE2'); ?> 
                            </div>
                        </div>
                    <?php } ?>

                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php echo $form->labelEx($model, 'PERSONNEL_NOM2', array()); ?>     
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">     
                            <?php echo $form->textField($model, 'PERSONNEL_NOM2', array('class' => 'form-control', 'size' => 60)); ?>
                            <?php echo $form->error($model, 'PERSONNEL_NOM2'); ?>
                        </div>
                    </div>                    


                    <?php if (Yii::app()->session['language'] == "EN") {
                        ?>  

                        <div class="form-row1"> 
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                                <?php echo $form->labelEx($model, 'PERSONNEL_TITRE3_EN', array()); ?>   
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">     
                                <?php echo $form->textField($model, 'PERSONNEL_TITRE3_EN', array('class' => 'form-control', 'size' => 60)); ?>
                                <?php echo $form->error($model, 'PERSONNEL_TITRE3_EN'); ?>              
                            </div>
                        </div>
                        <?php
                    } else {
                        ?>
                        <div class="form-row1"> 
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                                <?php echo $form->labelEx($model, 'PERSONNEL_TITRE3', array()); ?>   
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">     
                                <?php echo $form->textField($model, 'PERSONNEL_TITRE3', array('class' => 'form-control', 'size' => 60)); ?>
                                <?php echo $form->error($model, 'PERSONNEL_TITRE3'); ?>   
                            </div>
                        </div>  

                    <?php } ?>

                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php echo $form->labelEx($model, 'PERSONNEL_NOM3', array()); ?>     
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">     
                            <?php echo $form->textField($model, 'PERSONNEL_NOM3', array('class' => 'form-control', 'size' => 60)); ?>
                            <?php echo $form->error($model, 'PERSONNEL_NOM3'); ?>
                        </div>
                    </div>

                </div>
            </div>

            <div class="forms-cont"> 
                <div class="forms-heading"><i class="fa fa-building"></i> <?php echo Myclass::t('OG134'); ?> </div>
                <div class="row"> 
                    <?php if (Yii::app()->session['language'] == "EN") {
                        ?>  
                        <div class="form-row1">                            
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">        
                                <?php echo $form->textArea($model, 'REGIONS_EN', array('class' => 'form-control', 'maxlength' => 1000, 'rows' => 5, 'cols' => 50)); ?>
                                <?php echo $form->error($model, 'REGIONS_EN'); ?>
                            </div>    
                        </div>

                        <?php
                    } else {
                        ?>
                        <div class="form-row1">                            
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">        
                                <?php echo $form->textArea($model, 'REGIONS_FR', array('class' => 'form-control', 'maxlength' => 1000, 'rows' => 5, 'cols' => 50)); ?>
                                <?php echo $form->error($model, 'REGIONS_FR'); ?>
                            </div>    
                        </div>
                    <?php } ?>

                </div>
            </div>


            <div class="forms-cont"> 
                <div class="forms-heading"><i class="fa fa-user"></i>  <?php echo Myclass::t('OG113'); ?></div>
                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php echo $form->labelEx($umodel, 'COURRIEL'); ?>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                        <?php echo $form->textField($umodel, 'COURRIEL', array('class' => 'form-txtfield')); ?>
                        <?php echo $form->error($umodel, 'COURRIEL'); ?>
                    </div>
                </div> 

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-8"> <label> <?php echo Myclass::t('OG114'); ?></label></div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php echo $form->radioButtonList($umodel, 'bSubscription_envision', array('0' => 'No', '1' => 'Yes'), array('separator' => '&nbsp;&nbsp;&nbsp;')); ?>
                    </div>
                </div>

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-8"> <label><?php echo Myclass::t('OG115'); ?> </label>  </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php echo $form->radioButtonList($umodel, 'bSubscription_envue', array('0' => 'No', '1' => 'Yes'), array('separator' => '&nbsp;&nbsp;&nbsp;')); ?>
                    </div>
                </div>

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-8"> <label><?php echo Myclass::t('OG165'); ?>  </label>  </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php echo $form->radioButtonList($umodel, 'print_envision', array('0' => 'No', '1' => 'Yes'), array('separator' => '&nbsp;&nbsp;&nbsp;')); ?>
                    </div>
                </div>

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-8"> <label><?php echo Myclass::t('OG166'); ?>  </label>  </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php echo $form->radioButtonList($umodel, 'print_envue', array('0' => 'No', '1' => 'Yes'), array('separator' => '&nbsp;&nbsp;&nbsp;')); ?>
                    </div>
                </div>

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-8"> <label><?php echo Myclass::t('OG116'); ?>  </label>  </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php echo $form->radioButtonList($umodel, 'ABONNE_MAILING', array('0' => 'No', '1' => 'Yes'), array('separator' => '&nbsp;&nbsp;&nbsp;')); ?>
                    </div>
                </div>

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-8"> <label><?php echo Myclass::t('OG117'); ?>  </label>  </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php echo $form->radioButtonList($umodel, 'ABONNE_PROMOTION', array('0' => 'No', '1' => 'Yes'), array('separator' => '&nbsp;&nbsp;&nbsp;')); ?>
                    </div>
                </div>

            </div>   

            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 pull-right"> 
                <?php
                $btnval = $model->isNewRecord ? Myclass::t('OGO80', '', 'og') : Myclass::t('OG120');
                echo CHtml::tag('button', array(
                    'name' => 'btnSubmit',
                    'type' => 'submit',
                    'class' => 'submit-btn'
                        ), '<i class="fa fa-arrow-circle-right"></i> ' . $btnval);
                ?>
            </div>
            <?php $this->endWidget(); ?> 
        </div>
    </div>

    <?php
    if (!$model->isNewRecord) {
        $supplierproducts = array();
        $supp_id = Yii::app()->user->relationid;
        //this query contains get all products with marques list for the supplier
        $products_query = Yii::app()->db->createCommand() //this query contains all the data
                ->select('rp.ID_PRODUIT , rm.ID_MARQUE , rp.NOM_PRODUIT_' . $this->lang . ' , rm.NOM_MARQUE')
                ->from(array('repertoire_fournisseur_produit rfp', 'repertoire_produit_marque rpm', 'repertoire_produit AS rp', 'repertoire_marque AS rm'))
                ->where("rfp.ID_LIEN_PRODUIT_MARQUE = rpm.ID_LIEN_MARQUE AND rpm.ID_PRODUIT = rp.ID_PRODUIT AND rpm.ID_MARQUE = rm.ID_MARQUE AND rfp.ID_FOURNISSEUR =" . $supp_id)
                ->order('rp.NOM_PRODUIT_' . $this->lang . ',rm.NOM_MARQUE')
                ->queryAll();

        $result = array();
        foreach ($products_query as $infos) {
            $pid = $infos['ID_PRODUIT'];
            $prod = $pid . '~' . $infos['NOM_PRODUIT_' . $this->lang . ''];
            $supplierproducts[$prod][] = $infos;
        }

        if (!empty($supplierproducts)) {
            ?>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scroll-cont brands">  
                <h2> <?php echo Myclass::t('OG073', '', 'og'); ?> </h2> 
                <div class="box" id="box1">
                    <div class="brands">                         
                        <ul>
                            <?php
                            foreach ($supplierproducts as $pkey => $products) {
                                $exp_key = explode('~', $pkey);
                                ?>    
                                <li class="noBorder"><?php echo $exp_key[1]; ?>
                                    <?php
                                    if (!empty($products)) {
                                        ?>    
                                        <ul>
                                            <?php
                                            foreach ($products as $brand) {
                                                ?>
                                                <li class="noBorder"><?php echo $brand['NOM_MARQUE']; ?></li>       
                                                <?php }
                                                ?>
                                        </ul>    
                                    <?php }
                                    ?>  
                                </li>                                                        
                                <?php
                            }
                            ?>
                        </ul>
                        <p>&nbsp;</p>
                    </div>
                </div>
            </div>   
            <?php
        }
    }
    ?>


</div>
<?php
$cs = Yii::app()->getClientScript();
$ajaxRegionUrl = Yii::app()->createUrl('/optiguide/suppliersDirectory/getregions');
$ajaxCityUrl = Yii::app()->createUrl('/optiguide/suppliersDirectory/getcities');

$ctyval = isset($model->ID_VILLE) ? $model->ID_VILLE : '';

$js = <<< EOD
$(document).ready(function(){
   
// Get region for seleted country   
    $("#SuppliersDirectory_country").change(function(){
        var id=$(this).val();
        var dataString = 'id='+ id;
         
        $.ajax({
            type: "POST",
            url: '{$ajaxRegionUrl}',
            data: dataString,
            cache: false,
            success: function(html){             
                $("#SuppliersDirectory_region").html(html).selectpicker('refresh');
            }
         });
    });
   
// Get cities for seleted region
   $("#SuppliersDirectory_region").change(function(){
        var id=$(this).val();
        var dataString = 'id='+ id;
            
        $.ajax({
            type: "POST",
            url: '{$ajaxCityUrl}',
            data: dataString,
            cache: false,
            success: function(html){             
                $("#SuppliersDirectory_ID_VILLE").html(html).selectpicker('refresh');
            }
         });

    });   
        
 $('.repbox').lionbars();   
     
    var ctyval = "{$ctyval}";
    if(ctyval=="-1")
    {    
        $("#other_city").show();
    }     
            
   $("#SuppliersDirectory_ID_VILLE").change(function(){
        var id=$(this).val();
            
        $("#other_city").hide();
        if(id=="-1")
        {    
            $("#other_city").show();
        }    
    });
            
});
EOD;
Yii::app()->clientScript->registerScript('_form_supplier', $js);
?>
