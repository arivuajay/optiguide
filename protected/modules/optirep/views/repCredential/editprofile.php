<div class="cate-bg user-right">
    <h2> Edit profile </h2>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
           'id' => 'rep-credential-form',         
           'clientOptions' => array(
                    'validateOnSubmit' => true,                
                ),    
      ));
      echo $form->errorSummary(array($model, $profile));
?>
    <div class="row"> 
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <?php echo $form->labelEx($model, 'rep_username'); ?>
                <?php echo $form->textField($model, 'rep_username', array('class' => 'form-field')); ?>                
            </div>            
            
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <?php echo $form->labelEx($profile, 'rep_profile_firstname'); ?>
                <?php echo $form->textField($profile, 'rep_profile_firstname', array('class' => 'form-field')); ?>               
            </div>
            
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <?php echo $form->labelEx($profile, 'rep_profile_lastname'); ?>
                <?php echo $form->textField($profile, 'rep_profile_lastname', array('class' => 'form-field')); ?>               
            </div>
            
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <?php echo $form->labelEx($profile, 'rep_profile_email'); ?>
                <?php echo $form->textField($profile, 'rep_profile_email', array('class' => 'form-field')); ?>                  
            </div>
            
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <?php echo $form->labelEx($profile, 'rep_profile_phone'); ?>
                <?php echo $form->textField($profile, 'rep_profile_phone', array('class' => 'form-field')); ?>                 
            </div>
        
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <?php
                echo CHtml::tag('button', array(
                    'name' => 'btnSubmit',
                    'type' => 'submit',
                    'class' => 'register-btn'
                        ), 'Update');
                ?>
            </div>
    </div>
    <?php $this->endWidget(); ?>
</div>

