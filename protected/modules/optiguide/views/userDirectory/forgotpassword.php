<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
        <div class="inner-container eventslist-cont"> 
            <h2> <?php echo Myclass::t('OGO221', '', 'og');?> </h2>
            <div class="row"> 
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">  
                    <div class="forms-cont"> 
                        <div class="row"> 
                            
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
                            
                            <div class="form-row1"> 
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                                    <?php echo $form->labelEx($model, 'username'); ?>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                                    <?php echo $form->textField($model, 'username', array('class' => 'form-txtfield')); ?>
                                    <?php echo $form->error($model, 'username'); ?>
                                </div>
                            </div>
                            
                            <div class="form-row1"> 
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                                    <?php echo $form->labelEx($model, 'email'); ?>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                                    <?php echo $form->textField($model, 'email', array('class' => 'form-txtfield')); ?>
                                    <?php echo $form->error($model, 'email'); ?>
                                </div>
                            </div>
                            
                            <div class="form-row1"> 
                                <div class="col-xs-12 col-sm-8 col-md-4 col-lg-4 pull-right">
                                    <?php
                                    echo CHtml::tag('button', array(
                                        'name' => 'btnSubmit',
                                        'type' => 'submit',
                                        'class' => 'submit-btn'
                                            ), '<i class="fa fa-check-circle"></i> '. Myclass::t('OG120'));
                                    ?>
                                </div>
                            </div>
                            <div class="form-row1"> 
                                <div class="col-xs-12 col-sm-8 col-md-12 col-lg-12">
                                    <h6><strong><?php echo Myclass::t('OG197'); ?> <?php echo CHtml::link(Myclass::t('OG198'), array('/optiguide/default/contactus'),array("class"=>"sendrequest")); ?><?php echo Myclass::t('OG199'); ?></strong></h6>
                                </div>
                            </div>
                            <?php $this->endWidget(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>