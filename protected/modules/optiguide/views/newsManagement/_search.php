<div class="search-bg"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 "> 
        <div class="search-heading">  
            <i class="fa fa-file-text"></i> <?php echo Myclass::t('OG026', '', 'og') ?>  
        </div>
    </div>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'search-form',
        'method' => 'get',
        'action' => array('/optiguide/newsManagement/index'),
        'htmlOptions' => array('role' => 'form')
    ));
    ?>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 "> 
        <?php echo $form->textField($searchModel, 'TEXTE', array('class' => 'txtfield', 'placeholder' => Myclass::t('OG027', '', 'og'))); ?>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 "> 
        <?php echo CHtml::submitButton(Myclass::t('OG024', '', 'og'), array('class' => 'find-btn')); ?>
    </div>
    <?php $this->endWidget(); ?>
</div>