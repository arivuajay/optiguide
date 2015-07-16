<?php
/* @var $this ProfessionalDirectoryController */
/* @var $model ProfessionalDirectory */
/* @var $form CActiveForm */


?>

<div class="row">
    <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'professional-directory-form',
                'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'enableAjaxValidation' => true,
            ));

            $drp_val['class'] = 'form-control';
            if (isset($cid)) {
                $drp_val['options'] = array($cid => array('selected' => true));
            }


            $drp_val_cntry['class']   = 'form-control';
            $drp_val_cntry['empty']   = Myclass::t('APP43');        
            if(isset($cid))
            {    
                $drp_val_cntry['options'] =  array( $cid => array('selected'=>true));
            } 

            $drp_val_region['class']   = 'form-control';
            $drp_val_region['empty']   = Myclass::t('APP44');        
            if(isset($rid))
            {   
                $drp_val_region['options'] =  array( $rid => array('selected'=>true));
            } 
   

            ?>

            <div class="box-body">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'ID_TYPE_SPECIALISTE', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">                       
                        <?php echo $form->dropDownList($model, 'ID_TYPE_SPECIALISTE', $proftypes, $drp_val); ?>                          
                        <?php echo $form->error($model, 'ID_TYPE_SPECIALISTE'); ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'ID_CLIENT', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'ID_CLIENT', array('class' => 'form-control', 'size' => 8, 'maxlength' => 8)); ?>
                        <?php echo $form->error($model, 'ID_CLIENT'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'PREFIXE_FR', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'PREFIXE_FR', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'PREFIXE_FR'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'PREFIXE_EN', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'PREFIXE_EN', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'PREFIXE_EN'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'PRENOM', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'PRENOM', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'PRENOM'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'NOM', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'NOM', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'NOM'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'BUREAU', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'BUREAU', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'BUREAU'); ?>
                    </div>
                </div>

                
                 <div class="form-group">
                        <?php echo $form->labelEx($model,'country',  array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">                       
                            <?php echo $form->dropDownList($model, 'country', $country, $drp_val_cntry); ?>                          
                        <?php echo $form->error($model,'country'); ?>
                        </div>
                    </div>
                
                     <div class="form-group">
                        <?php echo $form->labelEx($model,'region',  array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">                       
                            <?php echo $form->dropDownList($model, 'region', $regions , $drp_val_region); ?>                          
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
                    <?php echo $form->labelEx($model, 'SITE_WEB', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'SITE_WEB', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'SITE_WEB'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'COURRIEL', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'COURRIEL', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'COURRIEL'); ?>
                    </div>
                </div>


            </div><!-- /.box-body -->
            <div class="box-footer">
                <div class="form-group">
                    <div class="col-sm-0 col-sm-offset-2">
                        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary')); ?>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div><!-- ./col -->
</div>
   <script type="text/javascript">
$(document).ready(function()
{
   
    //var availableTags = <?php //echo json_encode($all_USR); ?>;
   // $( "#ProfessionalDirectory_ID_CLIENT" ).autocomplete({
   //   source: availableTags
   // });
    
    var basepath = "<?php echo Yii::app()->baseUrl;?>";
    
    $("#ProfessionalDirectory_country").change(function()
    {
        var id=$(this).val();
        var dataString = 'id='+ id;
            
        $.ajax
        ({
            type: "POST",
            url: basepath+"/admin/citydirectory/getregions",
            data: dataString,
            cache: false,
            success: function(html)
            {             
                $("#ProfessionalDirectory_region").html(html);
            }
         });

    });
   
   $("#ProfessionalDirectory_region").change(function()
    {
        var id=$(this).val();
        var dataString = 'id='+ id;
            
        $.ajax
        ({
            type: "POST",
            url: basepath+"/admin/categoryinformation/getcities",
            data: dataString,
            cache: false,
            success: function(html)
            {             
                $("#ProfessionalDirectory_ID_VILLE").html(html);
            }
         });

    });
});
</script>