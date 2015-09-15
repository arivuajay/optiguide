<?php
/* @var $this RetailerDirectoryController */
/* @var $model RetailerDirectory */
/* @var $form CActiveForm */
?>

<div class="row">
    <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'retailer-directory-form',
                'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'enableAjaxValidation' => true,
            ));

            $retailertypes = CHtml::listData(RetailerType::model()->findAll(), 'ID_RETAILER_TYPE', 'NOM_TYPE_FR');
            $groupetypes = array();
            if ($model->ID_RETAILER_TYPE) {
                $groupetypes = CHtml::listData(RetailerGroup::model()->findAll("ID_RETAILER_TYPE=" . $model->ID_RETAILER_TYPE), 'ID_GROUPE', 'NOM_GROUPE');
            }
            $country = Myclass::getallcountries();
            $regions = Myclass::getallregions(@$model->country);
            $cities = Myclass::getallcities(@$model->region);
            ?>
            <div class="box-body">

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'ID_RETAILER_TYPE', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">                       
                        <?php echo $form->dropDownList($model, 'ID_RETAILER_TYPE', $retailertypes, array('class' => 'form-control', 'empty' => 'Choisir le type')); ?>                          
                        <?php echo $form->error($model, 'ID_RETAILER_TYPE'); ?>
                    </div>
                </div>

                <div class="form-group">                  

                    <?php echo $form->labelEx($model, 'ID_GROUPE', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">                       
                        <?php echo $form->dropDownList($model, 'ID_GROUPE', $groupetypes, array('class' => 'form-control', 'empty' => 'Sélectionnez le groupe')); ?>                          
                        <?php echo $form->error($model, 'ID_GROUPE'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'COMPAGNIE', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'COMPAGNIE', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'COMPAGNIE'); ?>
                    </div>
                </div>


                <div class="form-group">
                    <?php echo $form->labelEx($model, 'Categories', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">                     
                        <div class="checkbox">
                            <label>
                                <?php echo $form->checkBox($model, 'CATEGORY_1', array('value' => 1, 'uncheckValue' => 0)); ?>   
                                <?php echo $form->labelEx($model, 'CATEGORY_1'); ?>
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <?php echo $form->checkBox($model, 'CATEGORY_2', array('value' => 1, 'uncheckValue' => 0)); ?>   
                                <?php echo $form->labelEx($model, 'CATEGORY_2'); ?>
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <?php echo $form->checkBox($model, 'CATEGORY_3', array('value' => 1, 'uncheckValue' => 0)); ?>   
                                <?php echo $form->labelEx($model, 'CATEGORY_3'); ?>
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <?php echo $form->checkBox($model, 'CATEGORY_4', array('value' => 1, 'uncheckValue' => 0)); ?>   
                                <?php echo $form->labelEx($model, 'CATEGORY_4'); ?>
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <?php echo $form->checkBox($model, 'CATEGORY_5', array('value' => 1, 'uncheckValue' => 0)); ?>   
                                <?php echo $form->labelEx($model, 'CATEGORY_5'); ?>
                            </label>
                        </div>
                        <?php echo $form->error($model, 'CATEGORY_5'); ?>
                    </div>

                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'HEAD_OFFICE_NAME', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'HEAD_OFFICE_NAME', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'HEAD_OFFICE_NAME'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'ID_CLIENT', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">                             
                        <?php echo $form->textField($model, 'ID_CLIENT', array('class' => 'form-control', 'size' => 10, 'maxlength' => 10)); ?>
                        <?php //echo $form->error($umodel, 'USR'); ?>
                        <?php echo $form->error($model, 'ID_CLIENT'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'country', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">                       
                        <?php echo $form->dropDownList($model, 'country', $country, array('class' => 'form-control', 'empty' => Myclass::t('APP43'))); ?>                          
                        <?php echo $form->error($model, 'country'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'region', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">                       
                        <?php echo $form->dropDownList($model, 'region', $regions, array('class' => 'form-control', 'empty' => Myclass::t('APP44'))); ?>                          
                        <?php echo $form->error($model, 'region'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'ID_VILLE', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">                       
                        <?php echo $form->dropDownList($model, 'ID_VILLE', $cities, array('class' => 'form-control', 'empty' => Myclass::t('APP59'))); ?>   
                        <?php echo $form->error($model, 'ID_VILLE'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'ADRESSE', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'ADRESSE', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'ADRESSE'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'ADRESSE2', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'ADRESSE2', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'ADRESSE2'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'CODE_POSTAL', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'CODE_POSTAL', array('class' => 'form-control', 'size' => 20, 'maxlength' => 20)); ?>
                        <?php echo $form->error($model, 'CODE_POSTAL'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'TELEPHONE', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'TELEPHONE', array('class' => 'form-control', 'size' => 20, 'maxlength' => 20)); ?>
                        <?php echo $form->error($model, 'TELEPHONE'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'TELEPHONE2', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'TELEPHONE2', array('class' => 'form-control', 'size' => 20, 'maxlength' => 20)); ?>
                        <?php echo $form->error($model, 'TELEPHONE2'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'TELECOPIEUR', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'TELECOPIEUR', array('class' => 'form-control', 'size' => 20, 'maxlength' => 20)); ?>
                        <?php echo $form->error($model, 'TELECOPIEUR'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'TEL_1800', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'TEL_1800', array('class' => 'form-control', 'size' => 20, 'maxlength' => 20)); ?>
                        <?php echo $form->error($model, 'TEL_1800'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'URL', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'URL', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>(http://www.monsite.com )
                        <?php echo $form->error($model, 'URL'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'COURRIEL', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'COURRIEL', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'COURRIEL'); ?>
                    </div>
                </div>

                <div class="form-group"> 
                    <?php echo $form->labelEx($model, 'established', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">        
                        <?php echo $form->textField($model, 'established', array('class' => 'form-control', 'size' => 4, 'maxlength' => 4)); ?>
                        <?php echo $form->error($model, 'established'); ?>  
                    </div>      
                </div>

                <div class="form-group">                   
                    <?php echo $form->labelEx($model, 'no_of_employee', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">        
                        <?php echo $form->textField($model, 'no_of_employee', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'no_of_employee'); ?>  
                    </div>     
                </div>

                <div class="form-group">                     
                    <?php echo $form->labelEx($model, 'services_offered', array('class' => 'col-sm-2 control-label')); ?>                         
                    <div class="col-sm-5">        
                        <?php echo $form->textField($model, 'services_offered', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'services_offered'); ?>  
                    </div>     
                </div>

                <div class="form-group">                     
                    <?php echo $form->labelEx($model, 'description', array('class' => 'col-sm-2 control-label')); ?>                         
                    <div class="col-sm-5">        
                        <?php echo $form->textField($model, 'description', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'description'); ?>  
                    </div>     
                </div>

                <div class="form-group">                     
                    <?php echo $form->labelEx($model, 'turnover', array('class' => 'col-sm-2 control-label')); ?>    
                    <div class="col-sm-5">        
                        <?php echo $form->textField($model, 'turnover', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'turnover'); ?>  
                    </div>     
                </div>

                <div class="form-group">                
                    <?php
                    $classificationtypes['Upscale'] = "Upscale (high priced)";
                    $classificationtypes['Midscale'] = "Midscale (medium priced)";
                    $classificationtypes['DownRange'] = "Down range (low priced)";
                    echo $form->labelEx($model, 'classification', array('class' => 'col-sm-2 control-label')); ?>                   
                    <div class="col-sm-5">        
                        <?php echo $form->dropDownList($model, 'classification', $classificationtypes, array('class' => 'form-control')); ?>    
                        <?php echo $form->error($model, 'classification'); ?>  
                    </div>     
                </div>

                <!--                  <div class="form-group">
                <?php //echo $form->labelEx($umodel, 'MUST_VALIDATE', array('class' => 'col-sm-2 control-label'));   ?>       
                                    <div class="col-sm-5">
                <?php //echo $form->radioButtonList($umodel, 'MUST_VALIDATE', array('1' => 'Oui', '0' => 'Non'), array('separator' => ' '));   ?> 
                                    </div>
                                </div>-->

                <?php //echo $form->hiddenField($umodel,'bSubscription_envision'); ?>
                <?php // echo $form->hiddenField($umodel,'bSubscription_envue');?>
                <?php // echo $form->hiddenField($umodel,'ABONNE_MAILING');?>
                <?php // echo $form->hiddenField($umodel,'ABONNE_PROMOTION'); ?>

            </div><!-- /.box-body -->
            <div class="box-footer">
                <div class="form-group">
                    <div class="col-sm-0 col-sm-offset-2">
                        <?php echo CHtml::submitButton($model->isNewRecord ? 'Ajouter ce détaillant' : 'Modifier ce détaillant', array('class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary')); ?>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div><!-- ./col -->
</div>
<?php
$ajaxRegionUrl = Yii::app()->createUrl('/admin/retailerDirectory/getregions');
$ajaxCityUrl = Yii::app()->createUrl('/admin/retailerDirectory/getcities');
$ajaxGroupUrl = Yii::app()->createUrl('/admin/retailerDirectory/getgroups');
$js = <<< EOD
    $(document).ready(function(){
    $("#RetailerDirectory_country").change(function(){
        var id=$(this).val();
        var dataString = 'id='+ id;
            
        $.ajax({
            type: "POST",
            url: '{$ajaxRegionUrl}',
            data: dataString,
            cache: false,
            success: function(html){             
                $("#RetailerDirectory_region").html(html);
            }
         });
    });
   
   $("#RetailerDirectory_region").change(function(){
        var id=$(this).val();
        var dataString = 'id='+ id;
            
        $.ajax({
            type: "POST",
            url: '{$ajaxCityUrl}',
            data: dataString,
            cache: false,
            success: function(html){             
                $("#RetailerDirectory_ID_VILLE").html(html);
            }
         });

    });
            
   $("#RetailerDirectory_ID_RETAILER_TYPE").change(function(){
        var id=$(this).val();
        var dataString = 'id='+ id;
            
        $.ajax({
            type: "POST",
            url: '{$ajaxGroupUrl}',
            data: dataString,
            cache: false,
            success: function(html){             
                $("#RetailerDirectory_ID_GROUPE").html(html);
            }
         });
    });         
            
});
EOD;
Yii::app()->clientScript->registerScript('_form', $js);
?>