<div class="clearfix"> </div>
<?php if (Yii::app()->user->isGuest) { ?>
    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-4 col-sm-offset-2 col-md-offset-3 col-lg-offset-4">
        <?php $form = $this->beginWidget('CActiveForm', array('id' => 'user-form')); ?>
        <div class="rep-login">
            <h2> <?php echo Myclass::t('OR504', '', 'or') ?> </h2>
            <?php
            echo $form->textField($model, 'username', array('autofocus', 'class' => 'rep-loginfield', 'placeholder' => Myclass::t('OR502', '', 'or')));
            echo $form->error($model, 'username');
            ?>
            <div class="row"> 
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
                    <?php echo CHtml::submitButton(Myclass::t('OR504', '', 'or'), array('class' => 'rep-login-btn', 'name' => 'forgot')) ?>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
        <div class="signup-cont"> 
            <p>  <?php echo Myclass::t('OR508', '', 'or') ?> <br/>  </p>
            <?php echo CHtml::link(Myclass::t('OR505', '', 'or'), '/') ?>    
        </div>
    </div>
<?php } ?>