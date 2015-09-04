<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">   
    <div class="latest-newscont"> 
        <h2><?php echo  Myclass::t('OG151');?></h2>
        
         <?php $professional_types = CHtml::listData(ProfessionalType::model()->findAll(), 'ID_TYPE_SPECIALISTE', 'TYPE_SPECIALISTE_FR');?>
            <?php $form=$this->beginWidget('CActiveForm', array('id'=>'portlet-poll-form','enableAjaxValidation'=>false,)); ?>            
            <?php echo $form->errorSummary($model); ?>   
            <?php if (Yii::app()->user->isGuest)
            {?>
             <div class="form-row1"> 
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-2"> 
                    <?php echo $form->labelEx($userVote, 'ID_TYPE_SPECIALISTE'); ?>    
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-8">    
                    <?php echo $form->dropDownList($userVote, 'ID_TYPE_SPECIALISTE', $professional_types, array('class' => 'selectpicker','options' => array('11'=>array('selected'=>true)))); ?> 
                </div>
            </div>
            <?php
            }?>
            <h4><?php echo $Title;?></h4>
            <!-- form -->
            <div class="form">
                <?php //echo $form->labelEx($userVote,'choice_id'); ?>
                <?php $template = '{input} {label}'; ?>
                <?php echo $form->radioButtonList($userVote,'choice_id',$choices,array('template' =>$template,'separator'=>'<br>','name'=>'PortletPollVote_choice_id')); ?>
                <?php echo $form->error($userVote,'choice_id'); ?>  
                <div class="clearfix"></div>
                <?php echo CHtml::submitButton('Vote',array('class' => 'basic-btn')); ?>                  
            </div><!-- form -->
            <?php $this->endWidget(); ?>
    </div>
</div>