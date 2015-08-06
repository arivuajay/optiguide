<?php
/* @var $this ProfessionalDirectoryController */
/* @var $model ProfessionalDirectory */
/* @var $form CActiveForm */
?>

<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 subscribe-btncont"> 
        <div class="inner-container"> 
            <h2><?php echo  Myclass::t('OG110');?></h2>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'retailer-directory-form',
                'htmlOptions' => array('role' => 'form'),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'enableAjaxValidation' => true,
            ));

            $retailertypes = CHtml::listData(RetailerType::model()->findAll(), 'ID_RETAILER_TYPE', 'NOM_TYPE_FR');
            $groupetypes = array();
            $country = Myclass::getallcountries();
            $regions = Myclass::getallregions();
            $cities = Myclass::getallcities();
            ?>

            <p><b><?php echo  Myclass::t('OG111');?></b></p>

            <div class="forms-cont"> 
                <div class="forms-heading"><i class="fa fa-building"></i>   <?php echo  Myclass::t('OG112');?> </div>
                <div class="row"> 

                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php echo $form->labelEx($umodel, 'USR'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                            <?php echo $form->textField($umodel, 'USR', array('class' => 'form-txtfield')); ?>
                            <?php echo $form->error($umodel, 'USR'); ?>
                             <?php echo $form->error($model, 'ID_CLIENT'); ?>
                        </div>
                    </div>

                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php echo $form->labelEx($umodel, 'PWD'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                            <?php echo $form->passwordField($umodel, 'PWD', array('class' => 'form-txtfield')); ?>
                            <?php echo $form->error($umodel, 'PWD'); ?>
                        </div>
                    </div>

                    <div class="form-row1">                        
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php echo $form->labelEx($model, 'COMPAGNIE'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                            <?php echo $form->textField($model, 'COMPAGNIE', array('class' => 'form-txtfield')); ?>
                            <?php echo $form->error($model, 'COMPAGNIE'); ?>
                        </div>
                    </div>


                    <div class="form-row1">                        
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php echo $form->labelEx($model, 'ID_RETAILER_TYPE'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">                 
                            <?php echo $form->dropDownList($model, 'ID_RETAILER_TYPE', $retailertypes, array('class' => 'selectpicker', 'empty' => Myclass::t('OG118'))); ?>                          
                            <?php echo $form->error($model, 'ID_RETAILER_TYPE'); ?>
                        </div>
                    </div>

                    <div class="form-row1">                        
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php echo $form->labelEx($model, 'ID_GROUPE'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">                 
                            <?php echo $form->dropDownList($model, 'ID_GROUPE', $groupetypes, array('class' => 'selectpicker', 'empty' => Myclass::t('OG119'))); ?>                          
                            <?php echo $form->error($model, 'ID_GROUPE'); ?>
                        </div>
                    </div>

                    <div class="form-row1">                        
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php echo $form->labelEx($model, 'HEAD_OFFICE_NAME'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                            <?php echo $form->textField($model, 'HEAD_OFFICE_NAME', array('class' => 'form-txtfield')); ?>
                            <?php echo $form->error($model, 'HEAD_OFFICE_NAME'); ?>
                        </div>
                    </div>

                    <div class="form-row1">                        
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4"> 
                          <?php echo  Myclass::t('OG104');?> 
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">                   
                            <div class="row">  
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">  
                                    <?php echo $form->checkBox($model, 'CATEGORY_1', array('value' => 1, 'uncheckValue' => 0)); ?>   
                                    <?php echo $form->labelEx($model, 'CATEGORY_1'); ?>
                                    <br/> 
                                    <?php echo $form->checkBox($model, 'CATEGORY_2', array('value' => 1, 'uncheckValue' => 0)); ?>   
                                    <?php echo $form->labelEx($model, 'CATEGORY_2'); ?>
                                    <br/> 
                                    <?php echo $form->checkBox($model, 'CATEGORY_3', array('value' => 1, 'uncheckValue' => 0)); ?>   
                                    <?php echo $form->labelEx($model, 'CATEGORY_3'); ?>
                                    <br/>                                   
                                    <?php echo $form->checkBox($model, 'CATEGORY_4', array('value' => 1, 'uncheckValue' => 0)); ?>   
                                    <?php echo $form->labelEx($model, 'CATEGORY_4'); ?>
                                    <br/> 
                                    <?php echo $form->checkBox($model, 'CATEGORY_5', array('value' => 1, 'uncheckValue' => 0)); ?>   
                                    <?php echo $form->labelEx($model, 'CATEGORY_5'); ?>
                                    <br/> 
                                </div>         
                            </div>  
                              <?php echo $form->error($model, 'CATEGORY_5'); ?>
                        </div>
                    </div>
                </div>


                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php echo $form->labelEx($model, 'ADRESSE'); ?>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                        <?php echo $form->textField($model, 'ADRESSE', array('class' => 'form-txtfield')); ?>
                        <?php echo $form->error($model, 'ADRESSE'); ?>
                    </div>
                </div>

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                        <?php echo $form->labelEx($model, 'country'); ?>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                        <?php echo $form->dropDownList($model, 'country', $country, array('class' => 'selectpicker', 'empty' => Myclass::t('APP43'))); ?> 
                        <?php echo $form->error($model, 'country'); ?>
                    </div>
                </div>

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                        <?php echo $form->labelEx($model, 'region'); ?>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                        <?php echo $form->dropDownList($model, 'region', $regions, array('class' => 'selectpicker', 'empty' => Myclass::t('APP44'))); ?> 
                        <?php echo $form->error($model, 'region'); ?>
                    </div>
                </div>

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                        <?php echo $form->labelEx($model, 'ID_VILLE'); ?>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                        <?php echo $form->dropDownList($model, 'ID_VILLE', $cities, array('class' => 'selectpicker', 'empty' => Myclass::t('APP59'))); ?> 
                        <?php echo $form->error($model, 'ID_VILLE'); ?>
                    </div>
                </div>

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php echo $form->labelEx($model, 'CODE_POSTAL'); ?>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                        <?php echo $form->textField($model, 'CODE_POSTAL', array('class' => 'form-txtfield')); ?>
                        <?php echo $form->error($model, 'CODE_POSTAL'); ?>
                    </div>
                </div>

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php echo $form->labelEx($model, 'TELEPHONE'); ?>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                        <?php echo $form->textField($model, 'TELEPHONE', array('class' => 'form-txtfield')); ?>
                        <?php echo $form->error($model, 'TELEPHONE'); ?>
                    </div>
                </div>

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php echo $form->labelEx($model, 'TELEPHONE2'); ?>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                        <?php echo $form->textField($model, 'TELEPHONE2', array('class' => 'form-txtfield')); ?>
                        <?php echo $form->error($model, 'TELEPHONE2'); ?>
                    </div>
                </div>

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php echo $form->labelEx($model, 'TELECOPIEUR'); ?>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                        <?php echo $form->textField($model, 'TELECOPIEUR', array('class' => 'form-txtfield')); ?>
                        <?php echo $form->error($model, 'TELECOPIEUR'); ?>
                    </div>
                </div>

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php echo $form->labelEx($model, 'URL'); ?>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                        <?php echo $form->textField($model, 'URL', array('class' => 'form-txtfield')); ?>
                        <?php echo $form->error($model, 'URL'); ?>
                    </div>
                </div>

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php echo $form->labelEx($model, 'COURRIEL'); ?>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                        <?php echo $form->textField($model, 'COURRIEL', array('class' => 'form-txtfield')); ?>
                        <?php echo $form->error($model, 'COURRIEL'); ?>
                    </div>
                </div> 
            </div>
            <div class="forms-cont"> 
                <div class="forms-heading"><i class="fa fa-user"></i>  <?php echo  Myclass::t('OG113');?></div>
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
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-8"> <label> <?php echo  Myclass::t('OG114');?></label></div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php echo $form->radioButtonList($umodel, 'bSubscription_envision', array('0' => 'No', '1' => 'Yes'), array('separator' => '&nbsp;&nbsp;&nbsp;')); ?>
                    </div>
                </div>

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-8"> <label><?php echo  Myclass::t('OG115');?> </label>  </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php echo $form->radioButtonList($umodel, 'bSubscription_envue', array('0' => 'No', '1' => 'Yes'), array('separator' => '&nbsp;&nbsp;&nbsp;')); ?>
                    </div>
                </div>

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-8"> <label><?php echo  Myclass::t('OG116');?>  </label>  </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php echo $form->radioButtonList($umodel, 'ABONNE_MAILING', array('0' => 'No', '1' => 'Yes'), array('separator' => '&nbsp;&nbsp;&nbsp;')); ?>
                    </div>
                </div>

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-8"> <label><?php echo  Myclass::t('OG117');?>  </label>  </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php echo $form->radioButtonList($umodel, 'ABONNE_PROMOTION', array('0' => 'No', '1' => 'Yes'), array('separator' => '&nbsp;&nbsp;&nbsp;')); ?>
                    </div>
                </div>
           
                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 pull-right"> 
                        <?php
                        echo CHtml::tag('button', array(
                            'name' => 'btnSubmit',
                            'type' => 'submit',
                            'class' => 'submit-btn'
                                ), '<i class="fa fa-check-circle"></i> '. Myclass::t('OG120'));
                        ?>
                    </div>
                </div>
                
            </div>    
             <?php $this->endWidget(); ?>
        </div>
    </div>

   
</div>
<?php
$ajaxRegionUrl = Yii::app()->createUrl('/optiguide/retailerDirectory/getregions');
$ajaxCityUrl = Yii::app()->createUrl('/optiguide/retailerDirectory/getcities');
$ajaxGroupUrl = Yii::app()->createUrl('/optiguide/retailerDirectory/getgroups');
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
                $("#RetailerDirectory_region").html(html).selectpicker('refresh');;
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
                $("#RetailerDirectory_ID_VILLE").html(html).selectpicker('refresh');;
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
                $("#RetailerDirectory_ID_GROUPE").html(html).selectpicker('refresh');;
            }
         });
    });         
            
});
EOD;
Yii::app()->clientScript->registerScript('_form', $js);
?>