<?php
/* @var $this ClassifiedsController */
/* @var $model Classifieds */
/* @var $form CActiveForm */
?>

<?php
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerScriptFile(Yii::app()->baseUrl . '/protected/extensions/yiibooster/assets/ckeditor/ckeditor.js');
$cs->registerScriptFile(Yii::app()->baseUrl . '/protected/extensions/yiibooster/assets/ckeditor/adapters/jquery.js');
$cs->registerScript(
        'js2', '
    var config = {
    toolbar:
    [
     ["Bold", "Italic","Underline", "-", "NumberedList", "BulletedList", "-" ],  
     ["UIColor"],["TextColor"],["Undo","Redo","Link"],
     ["JustifyLeft","JustifyCenter","JustifyRight","JustifyBlock"],
     ["NumberedList","BulletedList","FontSize","Font"]
    ],
    height:150,
    };
    $("#Classifieds_classified_message").ckeditor(config);
  ', CClientScript::POS_LOAD
);
?>

<div class="row">
    <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
            <?php
            $classified_categories = CHtml::listData(ClassifiedCategories::model()->findAll(array("order" => "classified_category_id asc")), 'classified_category_id', 'classified_category_name_FR');

            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'classifieds-form',
                'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'enableAjaxValidation' => true,
            ));
            ?>
            <div class="box-body">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'classified_category_id', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->dropDownList($model, 'classified_category_id', $classified_categories, array('class' => 'form-control', "empty" => "Select classified category")); ?> 
                        <?php echo $form->error($model, 'classified_category_id'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'language', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->dropDownList($model, 'language', array("FR" => 'Français', "EN" => 'Anglais'), array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'language'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'classified_title', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'classified_title', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'classified_title'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'classified_message', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textArea($model, 'classified_message', array('class' => 'form-control', 'rows' => 6, 'cols' => 50)); ?>
                        <?php echo $form->error($model, 'classified_message'); ?>
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