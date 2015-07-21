<?php
/* @var $this ProductDirectoryController */
/* @var $model ProductDirectory */
/* @var $form CActiveForm */
?>

<div class="row">
    <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'product-directory-form',
                'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'enableAjaxValidation' => true,
            ));

            $sectiontypes = CHtml::listData(SectionDirectory::model()->findAll(array("order" => "NOM_SECTION_FR")), 'ID_SECTION', 'NOM_SECTION_FR');
            $marque_datas = CHtml::listData(MarqueDirectory::model()->findAll(array("order" => "NOM_MARQUE")), 'ID_MARQUE', 'NOM_MARQUE');
            ?>
            <div class="box-body">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'ID_SECTION', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">                       
                        <?php echo $form->dropDownList($model, 'ID_SECTION', $sectiontypes, array('class' => 'form-control')); ?>                          
                        <?php echo $form->error($model, 'ID_SECTION'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'NOM_PRODUIT_FR', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'NOM_PRODUIT_FR', array('class' => 'form-control', 'size' => 60, 'maxlength' => 70)); ?>
                        <?php echo $form->error($model, 'NOM_PRODUIT_FR'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'NOM_PRODUIT_EN', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'NOM_PRODUIT_EN', array('class' => 'form-control', 'size' => 60, 'maxlength' => 70)); ?>
                        <?php echo $form->error($model, 'NOM_PRODUIT_EN'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'Marques2', array('class' => 'col-sm-2 control-label')); ?>
                     <div class="col-sm-5">
                    <?php
                    //$data = array('101' => 'Faraz Khan', '102' => 'Depesh Saini', '103' => 'Nalin Gehlot', '104' => 'Hari Maliya');
                    //  $selected   = array(
                    //    '102' => array('selected' => 'selected'),
                    //    '103' => array('selected' => 'selected'),
                    //  );
                    //, 'options' => $selected
                    $htmlOptions = array('size' => '5', 'multiple' => 'true' , 'id' => 'MasterSelectBox','class' => 'form-control' );
                    echo $form->listBox($model, 'Marques1', $marque_datas, $htmlOptions);
                    ?>                      
                    <br>    
                    <button class="btn btn-info btn-sm" id="btnAdd">Add</button>
                    <button class="btn btn-info btn-sm" id="btnRemove">Remove</button>          
                    <br>
                    <?php
                    $data = array();                  
                    $htmlOptions = array('size' => '5', 'multiple' => 'true' , 'id' => 'PairedSelectBox','class' => 'form-control');
                    echo $form->listBox($model, 'Marques2', $data, $htmlOptions);
                    ?>
                    <?php echo $form->error($model, 'Marques2'); ?>
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
<?php

 $cs_pos_end = CClientScript::POS_END;
 $themeUrl   = $this->themeUrl;
 $cs         = Yii::app()->getClientScript();
 $cs->registerScriptFile($themeUrl . '/js/pair-select.min.js', $cs_pos_end);
 
$js = <<< EOD
$(document).ready(function()
{
        
     $('#MasterSelectBox').pairMaster();

	$('#btnAdd').click(function(){
		$('#MasterSelectBox').addSelected('#PairedSelectBox');
	});

	$('#btnRemove').click(function(){
		$('#PairedSelectBox').removeSelected('#MasterSelectBox'); 
	});   
});     
EOD;
Yii::app()->clientScript->registerScript('_form', $js);
?>