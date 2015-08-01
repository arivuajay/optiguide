<?php
/* @var $this UserDirectoryController */
/* @var $model UserDirectory */
/* @var $form CActiveForm */

?>

<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 subscribe-btncont"> 
        <div class="inner-container">          
            <h2><?php echo  Myclass::t('OG034', '', 'og');?></h2>
            <p><b><?php echo  Myclass::t('OG035', '', 'og');?></b></p>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'user-directory-form',
                'htmlOptions' => array('role' => 'form'),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'enableAjaxValidation' => true,
            ));
            ?>
            <div class="forms-cont"> 
                
                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php echo $form->labelEx($model, 'COURRIEL'); ?>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                        <?php echo $form->textField($model, 'COURRIEL', array('class' => 'form-txtfield')); ?>
                        <?php echo $form->error($model, 'COURRIEL'); ?>
                    </div>
                </div> 

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-8"> 
                        <label> <?php echo Myclass::t('OG114'); ?></label>  
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php echo $form->radioButtonList($model, 'bSubscription_envision', array('0' => 'No', '1' => 'Yes'), array('separator' => '&nbsp;&nbsp;&nbsp;')); ?>
                    </div>
                </div>

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-8"> <label><?php echo Myclass::t('OG115'); ?> </label>  </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php echo $form->radioButtonList($model, 'bSubscription_envue', array('0' => 'No', '1' => 'Yes'), array('separator' => '&nbsp;&nbsp;&nbsp;')); ?>
                    </div>
                </div>

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-8"> <label><?php echo Myclass::t('OG116'); ?>  </label>  </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php echo $form->radioButtonList($model, 'ABONNE_MAILING', array('0' => 'No', '1' => 'Yes'), array('separator' => '&nbsp;&nbsp;&nbsp;')); ?>
                    </div>
                </div>

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-8"> <label><?php echo Myclass::t('OG117'); ?>  </label>  </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php echo $form->radioButtonList($model, 'ABONNE_PROMOTION', array('0' => 'No', '1' => 'Yes'), array('separator' => '&nbsp;&nbsp;&nbsp;')); ?>
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
            <?php $this->endWidget(); ?>
        </div>
    </div>


</div>