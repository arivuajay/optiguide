<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">   
    <div class="latest-newscont"> 
        <h2><?php echo  Myclass::t('OG151');?></h2>
        <h4><?php echo $Title;?></h4>
        <!-- form -->
        <div class="form">
            <?php $form=$this->beginWidget('CActiveForm', array('id'=>'portlet-poll-form','enableAjaxValidation'=>false,)); ?>
            <?php echo $form->errorSummary($model); ?>       
            <?php //echo $form->labelEx($userVote,'choice_id'); ?>
            <?php $template = '{input} {label}'; ?>
            <?php echo $form->radioButtonList($userVote,'choice_id',$choices,array('template' =>$template,'separator'=>'<br>','name'=>'PortletPollVote_choice_id')); ?>
            <?php echo $form->error($userVote,'choice_id'); ?>  
            <div class="clearfix"></div>
            <?php echo CHtml::submitButton('Vote',array('class' => 'basic-btn')); ?>   
            <?php $this->endWidget(); ?>
        </div><!-- form -->
    </div>
</div>