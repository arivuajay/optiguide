<div class="row">
    <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">

            <?php
           
            $themeUrl = $this->themeUrl;
            $cs = Yii::app()->getClientScript();
            $cs_pos_end = CClientScript::POS_END;

            $cs->registerCssFile($themeUrl . '/css/datepicker/datepicker3.css');
            $cs->registerScriptFile($themeUrl . '/js/datepicker/bootstrap-datepicker.js', $cs_pos_end);
             
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'poll-form',
                'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
                 'clientOptions'=>array(
                    'validateOnSubmit'=>true,
                ),
                'enableAjaxValidation'=>true,
            ));
               
            if($model->polldate!='')
            {    
             $model->polldate =  date("F Y",strtotime($model->polldate));      
            } 
            ?>

            <?php //echo $form->errorSummary($model); ?>
            <br>    
        <div class="col-lg-6 col-xs-12">
            <div class="box-header">
                <h3 class="box-title">English</h3>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'title', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-7">
                        <?php echo $form->textField($model, 'title', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'title'); ?>
                    </div>   
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'description', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-7">
                        <?php echo $form->textArea($model, 'description', array('class' => 'form-control', 'rows' => 6, 'cols' => 50)); ?>
                        <?php echo $form->error($model, 'description'); ?>
                    </div>      
                </div>



    <!--             <div class="form-group">
                    <?php //echo $form->labelEx($model, 'usertype', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-7">
                        <?php //echo $form->dropDownList($model, 'usertype', array("1" => 'Professionals', "2" => 'Suppliers', "3" => 'Optical Retailers', "4" => 'Representatives' , '5' =>'others'), array('class' => 'form-control')); ?>
                        <?php //echo $form->error($model, 'usertype'); ?>
                    </div>                  
                </div> -->



                <div class="form-group">
                    <label for="Poll_usertype" class="col-sm-3 control-label required">Choices<span class="required">*</span></label>
                    <div class="col-sm-7">   
                        <div class="row">
                        <table id="poll-choices" >      
                            <tbody>
                                <?php
                                $newChoiceCount = 0;
                                foreach ($choices as $choice) {
                                    $this->renderPartial('/pollchoice/_formChoice', array(
    //                                    'id' => isset($choice->id) ? $choice->id : 'new' . ++$newChoiceCount,
                                        'id' => 'en',
                                        'flag' => 'new'.++$newChoiceCount,
                                        'choice' => $choice,
                                    ));
                                }
                                ++$newChoiceCount; // Increase once more for Ajax additions
                                ?>
                                <tr id="add-pollchoice-row">                              
                                    <td class="labeltxt col-sm-7" style="padding-top: .5em; padding-bottom: .5em;">
                                        <?php echo CHtml::textField('add_choice', '', array('class' => 'form-control', 'size' => 60, 'id' => 'add_choice')); ?>
                                        <div class="errorMessage" id="labelerror" style="display:none;">You must enter a choice.</div>  
                                         <?php echo $form->error($model, 'labelerror'); ?>
                                    </td>                      
                                </tr>
                                <tr>                           
                                    <td class="labeltxt col-sm-7">
                                        <a href="#" id="add-pollchoice"><i class="glyphicon glyphicon-plus-sign"></i> Add choice</a>
                                    </td>       
                                </tr>
                            </tbody>    
                        </table>
                        </div>
                    </div>
                </div> 
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'polldate', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-7">
                        <?php echo $form->textField($model, 'polldate', array('class' => 'form-control date', 'readonly' => 'true')); ?>
                        <?php echo $form->error($model, 'polldate'); ?>
                    </div>   
                </div>
            </div>
    </div>
    <div class="col-lg-6 col-xs-12">
        <div class="box-header">
            <h3 class="box-title">French</h3>
        </div>
        <div class="box-body">
            <div class="form-group">
                <?php echo $form->labelEx($model, 'title_FR', array('class' => 'col-sm-3 control-label')); ?>
                <div class="col-sm-7">
                    <?php echo $form->textField($model, 'title_FR', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'title_FR'); ?>
                </div>   
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model, 'description_FR', array('class' => 'col-sm-3 control-label')); ?>
                <div class="col-sm-7">
                    <?php echo $form->textArea($model, 'description_FR', array('class' => 'form-control', 'rows' => 6, 'cols' => 50)); ?>
                    <?php echo $form->error($model, 'description_FR'); ?>
                </div>      
            </div>
            
<!--             <div class="form-group">
                <?php //echo $form->labelEx($model, 'usertype', array('class' => 'col-sm-3 control-label')); ?>
                <div class="col-sm-7">
                    <?php //echo $form->dropDownList($model, 'usertype', array("1" => 'Professionals', "2" => 'Suppliers', "3" => 'Optical Retailers', "4" => 'Representatives' , '5' =>'others'), array('class' => 'form-control')); ?>
                    <?php //echo $form->error($model, 'usertype'); ?>
                </div>                  
            </div> -->
            
<!--            <div class="form-group" style="display:none;">
                <?php // echo $form->labelEx($model, 'status', array('class' => 'col-sm-3 control-label')); ?>
                <div class="col-sm-7">
                    <?php // echo $form->dropDownList($model, 'status', $model->statusLabels(), array('class' => 'form-control')); ?>
                    <?php // echo $form->error($model, 'status'); ?>
                </div>    
            </div>-->

            <div class="form-group">
                <label for="Poll_usertype1" class="col-sm-3 control-label required">Choices<span class="required">*</span></label>
                <div class="col-sm-7">   
                    <div class="row">
                    <table id="poll-choices1" >      
                        <tbody>
                            <?php
                            $newChoiceCount1 = 0;
                            foreach ($choices as $choice) {
                                $this->renderPartial('/pollchoice/_formChoice', array(
//                                    'id' => isset($choice->id) ? $choice->id : 'new' . ++$newChoiceCount1,
                                    'id' => 'fr',
                                    'flag' => 'new'.++$newChoiceCount1,
                                    'choice' => $choice,
//                                    'choice' => $choice,
                                ));
                            }
                            ++$newChoiceCount1; // Increase once more for Ajax additions
                            ?>
                            <tr id="add-pollchoice1-row">                              
                                <td class="labeltxt1 col-sm-7" style="padding-top: .5em; padding-bottom: .5em;">
                                    <?php echo CHtml::textField('add_choice', '', array('class' => 'form-control', 'size' => 60, 'id' => 'add_choice')); ?>
                                    <div class="errorMessage" id="labelerror" style="display:none;">You must enter a choice.</div>  
                                     <?php echo $form->error($model, 'labelerror'); ?>
                                </td>                      
                            </tr>
                            <tr>                           
                                <td class="labeltxt1 col-sm-7">
                                    <a href="#" id="add-pollchoice1"><i class="glyphicon glyphicon-plus-sign"></i> Add choice</a>
                                </td>       
                            </tr>
                        </tbody>    
                    </table>
                    </div>
                </div>
            </div>   
        </div>
    </div>
            <div class="form-group">
                <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-3 control-label hidden')); ?>
                <div class="col-sm-7" >
                    <?php echo $form->dropDownList($model, 'status', $model->statusLabels(), array('class' => 'form-control hidden')); ?>
                    <?php echo $form->error($model, 'status'); ?>
                </div>    
            </div>
            <br>
            
            <div class="box-footer">
                <div class="form-group">
                    <div class="col-sm-0 col-sm-offset-2">
                        <?php echo CHtml::submitButton($model->isNewRecord ? 'Ajouter un sondages' : 'Modifier ce sondages', array('class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary')); ?>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div><!-- ./col -->
</div>
<?php
$callback = Yii::app()->createUrl('/admin/pollchoice/ajaxcreate');
$js = <<<JS
            
jQuery('.date').datepicker({     
    format: 'MM yyyy',
    viewMode: "months", 
    minViewMode: "months",
    startDate: '+0m',
});             
        
var PollChoice = function(o) {
    this.target = o;
    this.labeltxt  = jQuery(".labeltxt input", o);   
    this.errorMessage = jQuery(".errorMessage", o);

    var pc = this;

    pc.labeltxt.blur(function() {
      pc.validate();
    });
  }
        
PollChoice.prototype.validate = function() {
    var valid = true;

    if (this.labeltxt.val() == "") {
      valid = false;
      this.errorMessage.fadeIn();
    }
    else {
      this.errorMessage.fadeOut();
    }

    return valid;
  }

var newChoiceCount = {$newChoiceCount};
var addPollChoice = new PollChoice(jQuery("#add-pollchoice-row"));

jQuery("tr", "#poll-choices tbody").each(function() {
  new PollChoice(jQuery(this));
});


jQuery("#add-pollchoice").click(function() {
  if (addPollChoice.validate()) {
    jQuery.ajax({
      url: "{$callback}",
      type: "POST",
      dataType: "json",
      data: {
        id: "en",
        flag:"new"+newChoiceCount,
        label: addPollChoice.labeltxt.val()
      },
      success: function(data) {
        addPollChoice.target.before(data.html);
        addPollChoice.labeltxt.val('');
        new PollChoice(jQuery('#'+ data.id));
      }
    });

    newChoiceCount += 1;
  }

  return false;
});
      
      var PollChoice1 = function(o) {
    this.target = o;
    this.labeltxt1  = jQuery(".labeltxt1 input", o);   
    this.errorMessage = jQuery(".errorMessage", o);

    var pc = this;

    pc.labeltxt1.blur(function() {
      pc.validate();
    });
  }
        
PollChoice1.prototype.validate = function() {
    var valid = true;

    if (this.labeltxt1.val() == "") {
      valid = false;
      this.errorMessage.fadeIn();
    }
    else {
      this.errorMessage.fadeOut();
    }

    return valid;
  }

var newChoiceCount1 = {$newChoiceCount1};
var addPollChoice1 = new PollChoice1(jQuery("#add-pollchoice1-row"));

jQuery("tr", "#poll-choices1 tbody").each(function() {
  new PollChoice1(jQuery(this));
});


jQuery("#add-pollchoice1").click(function() {
  if (addPollChoice1.validate()) {
    jQuery.ajax({
      url: "{$callback}",
      type: "POST",
      dataType: "json",
      data: {
        id: "fr",
        flag:"new"+newChoiceCount1,
        label_FR: addPollChoice1.labeltxt1.val()
      },
      success: function(data) {
        addPollChoice1.target.before(data.html);
        addPollChoice1.labeltxt1.val('');
        new PollChoice1(jQuery('#'+ data.id));
      }
    });

    newChoiceCount1 += 1;
  }

  return false;
});
JS;

Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerScript('pollHelp', $js, CClientScript::POS_END);
?>
