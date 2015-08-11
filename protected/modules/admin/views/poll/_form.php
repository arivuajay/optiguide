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
            <div class="form-group">
                <?php echo $form->labelEx($model, 'title', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-5">
                    <?php echo $form->textField($model, 'title', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'title'); ?>
                </div>   
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model, 'description', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-5">
                    <?php echo $form->textArea($model, 'description', array('class' => 'form-control', 'rows' => 6, 'cols' => 50)); ?>
                    <?php echo $form->error($model, 'description'); ?>
                </div>      
            </div>
            
            <div class="form-group">
                <?php echo $form->labelEx($model, 'polldate', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-5">
                    <?php echo $form->textField($model, 'polldate', array('class' => 'form-control date', 'readonly' => 'true')); ?>
                    <?php echo $form->error($model, 'polldate'); ?>
                </div>   
            </div>
            
             <div class="form-group">
                <?php echo $form->labelEx($model, 'usertype', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-5">
                    <?php echo $form->dropDownList($model, 'usertype', array("1" => 'Professionals', "2" => 'Suppliers', "3" => 'Optical Retailers', "4" => 'Representatives' , '5' =>'others'), array('class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'usertype'); ?>
                </div>                  
            </div> 
            
            <div class="form-group">
                <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-5">
                    <?php echo $form->dropDownList($model, 'status', $model->statusLabels(), array('class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'status'); ?>
                </div>    
            </div>

            <div class="box-header">
                <h3 class="box-title">Choices</h3>
            </div>

            <table id="poll-choices" >
                <thead>   
                <th>&nbsp;</th>
                <th align="middle">Label</th>
                <th>Actions</th>
                </thead>
                <tbody>
                    <?php
                    $newChoiceCount = 0;
                    foreach ($choices as $choice) {
                        $this->renderPartial('/pollchoice/_formChoice', array(
                            'id' => isset($choice->id) ? $choice->id : 'new' . ++$newChoiceCount,
                            'choice' => $choice,
                        ));
                    }
                    ++$newChoiceCount; // Increase once more for Ajax additions
                    ?>
                    <tr id="add-pollchoice-row">   
                        <td class="labeltxt col-sm-2">&nbsp;</td>
                        <td class="labeltxt col-sm-5">
                            <?php echo CHtml::textField('add_choice', '', array('class' => 'form-control', 'size' => 60, 'id' => 'add_choice')); ?>
                            <div class="errorMessage" id="labelerror" style="display:none;">You must enter a label.</div>  
                             <?php echo $form->error($model, 'labelerror'); ?>
                        </td>
                        <td class="actions">
                            <a href="#" id="add-pollchoice"><i class="glyphicon glyphicon-pencil"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
           
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
    minViewMode: "months"
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
        id: "new"+ newChoiceCount,
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
JS;

Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerScript('pollHelp', $js, CClientScript::POS_END);
?>
