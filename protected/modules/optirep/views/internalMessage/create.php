<div class="cate-bg user-right">
    <h2> <?php echo Myclass::t('OR621', '', 'or') ?> </h2>
    <?php
    $userto_id = Yii::app()->getRequest()->getQuery('id');
    $uto_infos = UserDirectory::model()->findByPk($userto_id);

    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'internal-message-form',
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    ));
    echo $form->errorSummary(array($model));
    ?>
    <div class="row"> 
        <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
            <?php echo Myclass::t('OR622', '', 'or') ?>  : <?php echo $uto_infos->NOM_UTILISATEUR; ?>
        </div>  
        <div class="col-xs-12 col-sm-6 col-md-8 col-lg-6">
            <?php echo $form->labelEx($model, 'message'); ?>
            <?php echo $form->textArea($model, 'message', array('class' => 'form-control', 'maxlength' => 1000, 'rows' => 5, 'cols' => 50)); ?>         
        </div>    
        <?php echo $form->hiddenField($model, 'user2', array("value" => $userto_id)); ?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php
            echo CHtml::tag('button', array(
                'name' => 'btnSubmit',
                'type' => 'submit',
                'class' => 'register-btn'
                    ), Myclass::t('OG120'));
            ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>

