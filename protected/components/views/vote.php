<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">   
    <div class="latest-newscont"> 
        <h2><?php echo  Myclass::t('OG151');?></h2>
        
         <?php      
            $lang = Yii::app()->session['language'];
            $professional_types = CHtml::listData(ProfessionalType::model()->findAll(array('order'=>'TYPE_SPECIALISTE_'.$lang)), 'ID_TYPE_SPECIALISTE', 'TYPE_SPECIALISTE_'.$lang);?>
            <?php $form=$this->beginWidget('CActiveForm', array('id'=>'portlet-poll-form','enableAjaxValidation'=>false,)); ?>            
            <?php echo $form->errorSummary($model); ?>   
            <?php if (Yii::app()->user->isGuest)
            {
            
                $regions = Myclass::getallregions("1");
                $cities  = Myclass::getallcities($userVote->region);
                ?>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"><?php echo $form->labelEx($userVote, 'region'); ?></div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"><?php echo $form->dropDownList($userVote, 'region', $regions, array('class' => 'selectpicker', 'empty' => Myclass::t('APP44'))); ?><?php echo $form->error($userVote, 'region'); ?></div>
            
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"><?php echo $form->labelEx($userVote, 'ID_VILLE'); ?></div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"><?php echo $form->dropDownList($userVote, 'ID_VILLE', $cities, array('class' => 'selectpicker', 'empty' => Myclass::t('APP59'))); ?><?php echo $form->error($userVote, 'ID_VILLE'); ?></div>
              
                <div class="col-xs-12 col-sm-3 col-md-6 col-lg-4"><?php echo $form->labelEx($userVote, 'ID_TYPE_SPECIALISTE' , array('class' => 'poll-label')); ?></div>
                <div class="col-xs-12 col-sm-9 col-md-6 col-lg-8"><?php echo $form->dropDownList($userVote, 'ID_TYPE_SPECIALISTE', $professional_types, array('class' => 'selectpicker','options' => array('11'=>array('selected'=>true)))); ?></div>
           
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
<?php
$ajaxCityUrl   = Yii::app()->createUrl('/optiguide/professionalDirectory/getcities');

$js = <<< EOD
$(document).ready(function(){
         
   $("#PollVote_region").change(function(){
        
        var id=$(this).val();
        var dataString = 'id='+ id;
            
        $.ajax({
            type: "POST",
            url: '{$ajaxCityUrl}',
            data: dataString,
            cache: false,
            success: function(html){             
                $("#PollVote_ID_VILLE").html(html).selectpicker('refresh');
            }
         });

    });
});
EOD;
Yii::app()->clientScript->registerScript('_form_prof', $js);
?>
