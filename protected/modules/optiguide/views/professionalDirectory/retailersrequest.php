<?php
/* @var $this ProfessionalDirectoryController */
/* @var $model ProfessionalDirectory */
/* @var $form CActiveForm */
?>

<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 subscribe-btncont"> 
        <div class="inner-container"> 
            <h2> <?php echo Myclass::t('OGO160', '', 'og');?> </h2>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'professional-directory-form',
                'htmlOptions' => array('role' => 'form'),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'enableAjaxValidation' => true,
            ));
            ?>

            <div class="forms-cont">                 
                <div class="row"> 
                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php echo $form->labelEx($model, 'retailername'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                            <?php echo $form->textField($model, 'retailername', array('class' => 'form-txtfield')); ?>
                            <?php echo $form->error($model, 'retailername'); ?>
                        </div>
                    </div>

                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php echo $form->labelEx($model, 'retaileremail'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">                              
                            <?php echo $form->textField($model, 'retaileremail', array('class' => 'form-txtfield')); ?>
                            <?php echo $form->error($model, 'retaileremail'); ?>      
                        </div>
                    </div>
                    
                     <div class="form-row1">      
                           <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                                <?php echo $form->labelEx($model, 'message'); ?>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">        
                                <?php echo $form->textArea($model, 'message', array('class' => 'form-control', 'maxlength' => 1000, 'rows' => 5, 'cols' => 50)); ?>
                                <?php echo $form->error($model, 'message'); ?>
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
            </div>    
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>