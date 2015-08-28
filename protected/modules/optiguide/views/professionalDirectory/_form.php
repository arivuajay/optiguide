<?php
/* @var $this ProfessionalDirectoryController */
/* @var $model ProfessionalDirectory */
/* @var $form CActiveForm */
?>

<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 subscribe-btncont"> 
        <div class="inner-container"> 
            <h2> <?php echo $model->isNewRecord ?  Myclass::t('OG110'):Myclass::t('OG034','','og');?> </h2>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'professional-directory-form',
                'htmlOptions' => array('role' => 'form'),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'enableAjaxValidation' => true,
            ));

            $professional_types = CHtml::listData(ProfessionalType::model()->findAll(), 'ID_TYPE_SPECIALISTE', 'TYPE_SPECIALISTE_FR');           
            $country   = Myclass::getallcountries();               
            $regions   = Myclass::getallregions($model->country);
            $cities    = Myclass::getallcities($model->region);
            ?>

            <div class="forms-cont"> 
                <div class="forms-heading"><i class="fa fa-briefcase"></i>    <?php echo $model->isNewRecord ?  Myclass::t('OGO137','','og'):Myclass::t('OGO138','','og');?>  </div>
                <div class="row"> 
                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php echo $form->labelEx($model, 'PRENOM'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                            <?php echo $form->textField($model, 'PRENOM', array('class' => 'form-txtfield')); ?>
                            <?php echo $form->error($model, 'PRENOM'); ?>
                        </div>
                    </div>

                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php echo $form->labelEx($model, 'NOM'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">                              
                            <?php echo $form->textField($model, 'NOM', array('class' => 'form-txtfield')); ?>
                            <?php echo $form->error($model, 'NOM'); ?>      
                        </div>
                    </div>

                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php echo $form->labelEx($umodel, 'USR'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                            <?php if($model->isNewRecord)
                            {?> 
                            <?php echo $form->textField($umodel, 'USR', array('class' => 'form-txtfield')); ?>
                            <?php echo $form->error($umodel, 'USR'); ?>
                            <?php echo $form->error($model, 'ID_CLIENT'); ?>
                            <?php }else{
                              echo $umodel->USR; 
                            } ?>
                        </div>
                    </div>
                <?php if($model->isNewRecord)
                  {?>
                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php echo $form->labelEx($umodel, 'PWD'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                            <?php echo $form->passwordField($umodel, 'PWD', array('class' => 'form-txtfield')); ?>
                            <?php echo $form->error($umodel, 'PWD'); ?>
                        </div>
                    </div>
                 <?php
                  }?>
                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                            <?php echo $form->labelEx($model, 'ID_TYPE_SPECIALISTE'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                            <?php echo $form->dropDownList($model, 'ID_TYPE_SPECIALISTE', $professional_types, array('class' => 'selectpicker')); ?> 
                            <?php echo $form->error($model, 'ID_TYPE_SPECIALISTE'); ?>
                        </div>
                    </div>

                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php echo $form->labelEx($model, 'BUREAU'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                            <?php echo $form->textField($model, 'BUREAU', array('class' => 'form-txtfield')); ?>
                            <?php echo $form->error($model, 'BUREAU'); ?>
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
                            <?php echo $form->labelEx($model, 'ADRESSE2'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                            <?php echo $form->textField($model, 'ADRESSE2', array('class' => 'form-txtfield')); ?>
                            <?php echo $form->error($model, 'ADRESSE2'); ?>
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
                            <?php echo $form->labelEx($model, 'TELECOPIEUR2'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                            <?php echo $form->textField($model, 'TELECOPIEUR2', array('class' => 'form-txtfield')); ?>
                            <?php echo $form->error($model, 'TELECOPIEUR2'); ?>
                        </div>
                    </div>

                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php echo $form->labelEx($model, 'SITE_WEB'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                            <?php echo $form->textField($model, 'SITE_WEB', array('class' => 'form-txtfield')); ?>
                            <?php echo $form->error($model, 'SITE_WEB'); ?>
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

                    <!--                    <div class="form-row1"> 
                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                    <?php //echo $form->labelEx($model, 'TYPE_AUTRE'); ?>
                                            </div>
                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                    <?php //echo $form->textArea($model, 'TYPE_AUTRE', array('class' => 'form-txtfield')); ?>
                    <?php //echo $form->error($model, 'TYPE_AUTRE'); ?>
                                            </div>
                                        </div>-->
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

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 pull-right"> 
                        <?php
                        echo CHtml::tag('button', array(
                            'name' => 'btnSubmit',
                            'type' => 'submit',
                            'class' => 'submit-btn'
                                ), '<i class="fa fa-check-circle"></i> ' . Myclass::t('OG120'));
                        ?>
                    </div>
                </div>

            </div>  
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>

<?php
$ajaxRegionUrl = Yii::app()->createUrl('/optiguide/professionalDirectory/getregions');
$ajaxCityUrl = Yii::app()->createUrl('/optiguide/professionalDirectory/getcities');
$js = <<< EOD
    $(document).ready(function(){
    $("#ProfessionalDirectory_country").change(function(){
        var id=$(this).val();
        var dataString = 'id='+ id;
            
        $.ajax({
            type: "POST",
            url: '{$ajaxRegionUrl}',
            data: dataString,
            cache: false,
            success: function(html){             
                $("#ProfessionalDirectory_region").html(html).selectpicker('refresh');
            }
         });
    });
   
   $("#ProfessionalDirectory_region").change(function(){
        var id=$(this).val();
        var dataString = 'id='+ id;
            
        $.ajax({
            type: "POST",
            url: '{$ajaxCityUrl}',
            data: dataString,
            cache: false,
            success: function(html){             
                $("#ProfessionalDirectory_ID_VILLE").html(html).selectpicker('refresh');
            }
         });

    });
});
EOD;
Yii::app()->clientScript->registerScript('_form_prof', $js);
?>