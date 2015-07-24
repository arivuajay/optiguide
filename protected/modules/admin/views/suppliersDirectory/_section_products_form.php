<?php
/* @var $this SuppliersDirectoryController */
/* @var $model SuppliersDirectory */
/* @var $form CActiveForm */
?>
 <?php
    // echo $form->hiddenField($model, 'Auth_Acc_Id', array('value' => $author_model->Auth_Acc_Id));
    $sectiontypes = CHtml::listData(SectionDirectory::model()->findAll(array("order" => "NOM_SECTION_FR")), 'ID_SECTION', 'NOM_SECTION_FR');
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'select-products-form',
        'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
        'action'=>Yii::app()->createUrl('/admin/suppliersDirectory/addproducts/'),
    ));
   // echo $form->hiddenField($model, 'Auth_Acc_Id', array('value' => $author_model->Auth_Acc_Id));
    ?>   
<div class="box box-primary">   
    <div class="box-body">
        <div class="form-group">
            <?php echo $form->labelEx($model, 'IDSECTION', array('class' => 'col-sm-2 control-label')); ?>
            <div class="col-sm-5">                       
                <?php echo $form->dropDownList($model, 'IDSECTION', $sectiontypes, array('class' => 'form-control' , "empty" => "-- Sélectionnez la catégorie --")); ?>                          
                <?php echo $form->error($model, 'IDSECTION'); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'Products', array('class' => 'col-sm-2 control-label')); ?>
            <div class="col-sm-5">
                <?php
                $marque_datas = array();
                $data = array();
                $htmlOptions = array('size' => '5', 'multiple' => 'true', 'id' => 'MasterSelectBox', 'class' => 'form-control');
                echo $form->listBox($model, 'Products1', $marque_datas, $htmlOptions);
                ?>                      
                <br>    
                <a href='javascript:void(0);' class="btn btn-info btn-sm" id="Addmarque">Add</a>
                <a href='javascript:void(0);' class="btn btn-info btn-sm" id="Removemarque">Remove</a>          
                <br>
                <?php
                // $data = $get_selected_marques;
                $htmlOptions = array('size' => '5', 'multiple' => 'true', 'class' => 'form-control', 'options' => $selected);
                echo $form->listBox($model, 'Products2', $data, $htmlOptions);
                ?>                       
            </div>
        </div>
        <?php echo CHtml::submitButton('Save', array('class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary')); ?>
    </div><!-- /.box-body -->    
    
</div> 
<?php $this->endWidget(); ?>