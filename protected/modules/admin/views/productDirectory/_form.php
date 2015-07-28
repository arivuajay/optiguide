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

            $criteria1 = new CDbCriteria();
            $criteria1->order = "NOM_MARQUE";
            $criteria1->condition = 'ID_PRODUIT=:id';
            $criteria1->params = array(':id' => $model->ID_PRODUIT);
            $get_selected_marques = CHtml::listData(MarqueDirectory::model()->with("productMarqueDirectory")->isActive()->findAll($criteria1), 'ID_MARQUE', 'NOM_MARQUE');

            $selected = array();
            $marid = array();
            foreach ($get_selected_marques as $k => $item) {
                $selected[$k] = array('selected' => 'selected');
                $marid[] = $k;
            }
            $imp_marque = implode(',', $marid);

            $criteria2 = new CDbCriteria();
            $criteria2->order = "NOM_MARQUE";
            $marque_datas = CHtml::listData(MarqueDirectory::model()->isActive()->findAll($criteria2), 'ID_MARQUE', 'NOM_MARQUE');
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
                        $htmlOptions = array('size' => '5', 'multiple' => 'true', 'id' => 'MasterSelectBox', 'class' => 'form-control');
                        echo $form->listBox($model, 'Marques1', $marque_datas, $htmlOptions);
                        ?> 
                    </div>  
                </div>    
                <div class="form-group">
                    <label class="col-sm-2 control-label required" for="ProductDirectory_buttons">&nbsp;</label>
                        <div class="col-sm-5">  
                            <a href='javascript:void(0);' class="btn btn-info btn-sm" id="Addmarque">Add</a>
                            <a href='javascript:void(0);' class="btn btn-info btn-sm" id="Removemarque">Remove</a>          
                        </div>  
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label required" for="ProductDirectory_Marques2">&nbsp;</label>
                        <div class="col-sm-5">    
                            <?php
                            $data = $get_selected_marques;
                            $htmlOptions = array('size' => '5', 'multiple' => 'true', 'class' => 'form-control', 'options' => $selected);
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
$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($themeUrl . '/js/pair-select.min.js', $cs_pos_end);
$jsoncde = json_encode($marid);
$js = <<< EOD
$(document).ready(function()
{        
     var varray = {$jsoncde}; 
     $('#MasterSelectBox').pairMaster();
      
    for (var i = 0; i < varray.length; i++) {
       var mval = varray[i];
       $("#MasterSelectBox option[value="+mval+"]").remove();
    }
    
    $('#Addmarque').click(function(){
            $('#MasterSelectBox').addSelected('#ProductDirectory_Marques2');
    });

    $('#Removemarque').click(function(){
            $('#ProductDirectory_Marques2').removeSelected('#MasterSelectBox'); 
    });   
});     
EOD;
Yii::app()->clientScript->registerScript('_form', $js);
?>