<?php
/* @var $this CategoryInformationController */
/* @var $model CategoryInformation */
/* @var $form CActiveForm */
?>

<div class="row">
    <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
            <?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'category-information-form',
        'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
	'enableAjaxValidation'=>true,
));        

        $country = Myclass::getallcountries();               
        $regions = Myclass::getallregions($model->country);
        $cities  = Myclass::getallcities($model->region);

?>
            <div class="box-body">
                    <div class="form-group">
                        <?php echo $form->labelEx($model,'CATEGORIE_FR',  array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                        <?php echo $form->textField($model,'CATEGORIE_FR',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
                        <?php echo $form->error($model,'CATEGORIE_FR'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo $form->labelEx($model,'CATEGORIE_EN',  array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                        <?php echo $form->textField($model,'CATEGORIE_EN',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
                        <?php echo $form->error($model,'CATEGORIE_EN'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo $form->labelEx($model,'NOM_ASSOCIATION_FR',  array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                        <?php echo $form->textField($model,'NOM_ASSOCIATION_FR',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
                        <?php echo $form->error($model,'NOM_ASSOCIATION_FR'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo $form->labelEx($model,'NOM_ASSOCIATION_EN',  array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                        <?php echo $form->textField($model,'NOM_ASSOCIATION_EN',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
                        <?php echo $form->error($model,'NOM_ASSOCIATION_EN'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo $form->labelEx($model,'ADRESSE',  array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                        <?php echo $form->textField($model,'ADRESSE',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
                        <?php echo $form->error($model,'ADRESSE'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo $form->labelEx($model,'ADRESSE2',  array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                        <?php echo $form->textField($model,'ADRESSE2',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
                        <?php echo $form->error($model,'ADRESSE2'); ?>
                        </div>
                    </div>
                
                    <div class="form-group">
                        <?php echo $form->labelEx($model,'country',  array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">                       
                            <?php echo $form->dropDownList($model, 'country', $country, array('class' => 'form-control','empty'=>Myclass::t('APP43'))); ?>                          
                        <?php echo $form->error($model,'country'); ?>
                        </div>
                    </div>
                
                     <div class="form-group">
                        <?php echo $form->labelEx($model,'region',  array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">                       
                            <?php echo $form->dropDownList($model, 'region', $regions , array('class' => 'form-control','empty'=>Myclass::t('APP44'))); ?>                          
                        <?php echo $form->error($model,'region'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo $form->labelEx($model,'ID_VILLE',  array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">                       
                             <?php echo $form->dropDownList($model, 'ID_VILLE', $cities  ,array('class'=>'form-control','empty'=>Myclass::t('APP59'))); ?>   
                        <?php echo $form->error($model,'ID_VILLE'); ?>
                        </div>
                    </div>

                                        <div class="form-group">
                        <?php echo $form->labelEx($model,'CODE_POSTAL',  array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                        <?php echo $form->textField($model,'CODE_POSTAL',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
                        <?php echo $form->error($model,'CODE_POSTAL'); ?>
                        </div>
                    </div>

                                        <div class="form-group">
                        <?php echo $form->labelEx($model,'TELEPHONE',  array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                        <?php echo $form->textField($model,'TELEPHONE',array('class'=>'form-control','size'=>20,'maxlength'=>20)); ?>
                        <?php echo $form->error($model,'TELEPHONE'); ?>
                        </div>
                    </div>

                                        <div class="form-group">
                        <?php echo $form->labelEx($model,'TELECOPIEUR',  array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                        <?php echo $form->textField($model,'TELECOPIEUR',array('class'=>'form-control','size'=>20,'maxlength'=>20)); ?>
                        <?php echo $form->error($model,'TELECOPIEUR'); ?>
                        </div>
                    </div>

                                        <div class="form-group">
                        <?php echo $form->labelEx($model,'TEL_SANS_FRAIS',  array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                        <?php echo $form->textField($model,'TEL_SANS_FRAIS',array('class'=>'form-control','size'=>20,'maxlength'=>20)); ?>
                        <?php echo $form->error($model,'TEL_SANS_FRAIS'); ?>
                        </div>
                    </div>

                                        <div class="form-group">
                        <?php echo $form->labelEx($model,'COURRIEL',  array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                        <?php echo $form->textField($model,'COURRIEL',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
                        <?php echo $form->error($model,'COURRIEL'); ?>
                        </div>
                    </div>

                                        <div class="form-group">
                        <?php echo $form->labelEx($model,'SITE_WEB',  array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                        <?php echo $form->textField($model,'SITE_WEB',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
                        <?php echo $form->error($model,'SITE_WEB'); ?>
                        </div>
                    </div>

                                        <div class="form-group">
                        <?php echo $form->labelEx($model,'PREFIXE_REPRESENTANT_FR',  array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                        <?php echo $form->textField($model,'PREFIXE_REPRESENTANT_FR',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
                        <?php echo $form->error($model,'PREFIXE_REPRESENTANT_FR'); ?>
                        </div>
                    </div>

                                        <div class="form-group">
                        <?php echo $form->labelEx($model,'PREFIXE_REPRESENTANT_EN',  array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                        <?php echo $form->textField($model,'PREFIXE_REPRESENTANT_EN',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
                        <?php echo $form->error($model,'PREFIXE_REPRESENTANT_EN'); ?>
                        </div>
                    </div>

                                        <div class="form-group">
                        <?php echo $form->labelEx($model,'NOM_REPRESENTANT',  array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                        <?php echo $form->textField($model,'NOM_REPRESENTANT',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
                        <?php echo $form->error($model,'NOM_REPRESENTANT'); ?>
                        </div>
                    </div>

                                        <div class="form-group">
                        <?php echo $form->labelEx($model,'TITRE_REPRESENTANT_FR',  array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                        <?php echo $form->textField($model,'TITRE_REPRESENTANT_FR',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
                        <?php echo $form->error($model,'TITRE_REPRESENTANT_FR'); ?>
                        </div>
                    </div>

                                        <div class="form-group">
                        <?php echo $form->labelEx($model,'TITRE_REPRESENTANT_EN',  array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                        <?php echo $form->textField($model,'TITRE_REPRESENTANT_EN',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
                        <?php echo $form->error($model,'TITRE_REPRESENTANT_EN'); ?>
                        </div>
                    </div>

                                </div><!-- /.box-body -->
            <div class="box-footer">
                <div class="form-group">
                    <div class="col-sm-0 col-sm-offset-2">
                        <?php echo CHtml::submitButton($model->isNewRecord ? Myclass::t('APP504') : Myclass::t('APP25'), array('class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary')); ?>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div><!-- ./col -->
</div>
<?php
$ajaxRegionUrl = Yii::app()->createUrl('/admin/cityDirectory/getregions');
$ajaxCityUrl = Yii::app()->createUrl('/admin/categoryInformation/getcities');

$js = <<< EOD
$(document).ready(function()
{
    $("#CategoryInformation_country").change(function()
    {
        var id=$(this).val();
        var dataString = 'id='+ id;
            
        $.ajax
        ({
            type: "POST",
            url: '{$ajaxRegionUrl}',
            data: dataString,
            cache: false,
            success: function(html)
            {             
                $("#CategoryInformation_region").html(html);
            }
         });

    });
   
   $("#CategoryInformation_region").change(function()
    {
        var id=$(this).val();
        var dataString = 'id='+ id;
            
        $.ajax
        ({
            type: "POST",
            url: '{$ajaxCityUrl}',
            data: dataString,
            cache: false,
            success: function(html)
            {             
                $("#CategoryInformation_ID_VILLE").html(html);
            }
         });

    });
});     
        
EOD;
Yii::app()->clientScript->registerScript('_form', $js);
?>
