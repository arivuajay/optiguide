<?php
/* @var $this SuppliersDirectoryController */
/* @var $model SuppliersDirectory */
/* @var $form CActiveForm */
?>
<div class="box box-primary">
    <?php
    // echo $form->hiddenField($model, 'Auth_Acc_Id', array('value' => $author_model->Auth_Acc_Id));
    $sectiontypes = CHtml::listData(SectionDirectory::model()->findAll(array("order" => "NOM_SECTION_FR")), 'ID_SECTION', 'NOM_SECTION_FR');
    ?>
    <div class="box-header">
        <h3 class="box-title">Général</h3>
    </div>
    <div class="box-body">
        <div class="form-group">
            <?php echo $form->labelEx($model, 'IDSECTION', array('class' => 'col-sm-2 control-label')); ?>
            <div class="col-sm-5">                       
                <?php echo $form->dropDownList($model, 'IDSECTION', $sectiontypes, array('class' => 'form-control')); ?>                          
                <?php echo $form->error($model, 'IDSECTION'); ?>
            </div>
        </div>
    </div><!-- /.box-body -->    
</div>