<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">   
    <div class="latest-newscont"> 
        <h2><?php echo  Myclass::t('OG151');?></h2>
        
         <?php $professional_types = CHtml::listData(ProfessionalType::model()->findAll(), 'ID_TYPE_SPECIALISTE', 'TYPE_SPECIALISTE_FR');?>
            <?php $form=$this->beginWidget('CActiveForm', array('id'=>'portlet-poll-form','enableAjaxValidation'=>false,)); ?>            
            <?php echo $form->errorSummary($model); ?>   
            <?php if (Yii::app()->user->isGuest)
            {?>
           
                <div class="col-xs-12 col-sm-3 col-md-6 col-lg-4"> 
                    <?php echo $form->labelEx($userVote, 'ID_TYPE_SPECIALISTE' , array('class' => 'poll-label')); ?>    
                </div>
                <div class="col-xs-12 col-sm-9 col-md-6 col-lg-8">    
                    <?php echo $form->dropDownList($userVote, 'ID_TYPE_SPECIALISTE', $professional_types, array('class' => 'selectpicker','options' => array('11'=>array('selected'=>true)))); ?> 
                </div>
           
            <?php
            }?>
            <br>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h4><?php echo $Title;?></h4>
            </div>
            <!-- form -->
            <div class="form">
                <?php //echo $form->labelEx($userVote,'choice_id'); ?>
                <?php $template = '{input} {label}'; ?>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">  
                <?php echo $form->radioButtonList($userVote,'choice_id',$choices,array('template' =>$template,'separator'=>'<br>','name'=>'PortletPollVote_choice_id')); ?>
                <?php echo $form->error($userVote,'choice_id'); ?>  
                </div>    
                <div class="clearfix"></div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
                <?php echo CHtml::submitButton('Vote',array('class' => 'basic-btn right')); ?>                  
                </div>     
            </div><!-- form -->
            <?php $this->endWidget(); ?>
    </div>
</div>