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
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'newsmanagement-search-form',
                        'method' => 'get',
                        'action' => array('/admin/suppliersDirectory/index/'),
                        'htmlOptions' => array('role' => 'form')
                    ));
                    ?>
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'keyword', array('class' => ' control-label')); ?>
                            <?php echo $form->textField($model, 'keyword', array('class' => 'form-control', 'size' => 60)); ?>                     
                        </div>
                    </div> 
                    
                    <div class="col-lg-2 col-md-2">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <?php echo CHtml::submitButton('Filtrer', array('class' => 'btn btn-primary form-control')); ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-lg-12 col-md-12">
                        <p>
                            <strong>Hint*</strong>
                            Searching keyword results are get from the following fields
                            (Address, Postal code, Telephone, Fax, Email, Store Web site, Office / Company name, Branches, Toll Free Phone Number and Fax Number)
                        </p>
                    </div> 
                    <?php $this->endWidget(); ?>
                </div>
            </section>
            
        </div>
    </div>
</div>
