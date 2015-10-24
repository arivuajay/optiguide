<?php
/* @var $this NewsManagementController */
/* @var $model NewsManagement */
/* @var $form CActiveForm */
?>
<div class="col-lg-12 col-md-12">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="glyphicon glyphicon-search"></i>  Search
                </h3>
                <div class="clearfix"></div>
            </div>

            <section class="content">
                <div class="row">
                    <?php
                    $criteria = new CDbCriteria();
                    $criteria->select = 'YEAR(DATE_AJOUT1) as Year';
                    $criteria->group = 'YEAR(DATE_AJOUT1)';
                    $criteria->order = 'Year DESC';
                    $reslt = NewsManagement::model()->findAll($criteria);
                    foreach ($reslt as $res) {
                        $years[$res->Year] = $res->Year;
                    }

                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'newsmanagement-search-form',
                        'method' => 'get',
                        'action' => array('/admin/newsManagement/index/'),
                        'htmlOptions' => array('role' => 'form')
                    ));
                    ?>
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'TITRE', array('class' => ' control-label')); ?>
                            <?php echo $form->textField($model, 'TITRE', array('class' => 'form-control', 'size' => 60)); ?>                     
                        </div>
                    </div> 
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'LANGUE', array('class' => ' control-label')); ?>
                            <?php echo $form->dropDownList($model, 'LANGUE', array("FR" => 'Français', "EN" => 'Anglais'), array('class' => 'form-control', 'prompt' => 'Tous')); ?>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'Year', array('class' => ' control-label')); ?>
                            <?php echo $form->dropDownList($model, 'Year', $years, array('class' => 'form-control', 'prompt' => 'Toutes')); ?>                          
                        </div>
                    </div>
                    
                    <div class="col-lg-2 col-md-2">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <?php echo CHtml::submitButton('Filtrer', array('class' => 'btn btn-primary form-control')); ?>
                        </div>
                    </div>
                    <?php $this->endWidget(); ?>
                </div>
            </section>
            
        </div>
    </div>
</div>
