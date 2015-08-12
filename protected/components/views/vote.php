<div class="optinews-left"> 
    <div class="optinews-left-heading"> Poll </div>
    <div class="optinews-left-bg"> 
        <h4><?php echo $Title;?></h4>
        <div class="form">
        <?php $form=$this->beginWidget('CActiveForm', array('id'=>'portlet-poll-form','enableAjaxValidation'=>false,)); ?>
        <?php echo $form->errorSummary($model); ?>       
        <?php //echo $form->labelEx($userVote,'choice_id'); ?>
        <?php $template = '{input} {label}'; ?>
        <?php echo $form->radioButtonList($userVote,'choice_id',$choices,array('template' =>$template,'separator'=>'<br>','name'=>'PortletPollVote_choice_id')); ?>
        <?php echo $form->error($userVote,'choice_id'); ?>          
        <?php echo CHtml::submitButton('Vote',array('class' => 'basic-btn')); ?>      
        <?php $this->endWidget(); ?>
        </div><!-- form -->
    </div>
</div>