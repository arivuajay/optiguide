<?php
$session_userid = $uid;

if ($user1_id != $session_userid) {
    $userto_id = $user1_id;
}
if ($user2_id != $session_userid) {
    $userto_id = $user2_id;
}

// Update the unread messages to read
$convid = Yii::app()->getRequest()->getQuery('convid');
$sql = "UPDATE internal_message SET user2read = 'yes' WHERE  user2 = '$session_userid' and id1= '$convid'";
$command = Yii::app()->db->createCommand($sql)->execute();
?>
<div class="cate-bg user-right">
    <h2> <?php echo Myclass::t('OR626', '', 'or') ?> </h2>   
    <div class="row"> 
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 "> 
            <div class="nano">
                <div class="table-responsive nano-content">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered">
                        <tr>          
                            <th class="author"><?php echo Myclass::t('OR627', '', 'or') ?></th>
                            <th><?php echo Myclass::t('OR624', '', 'or') ?></th>
                            <th><?php echo Myclass::t('OR628', '', 'or') ?></th>
                        </tr>
                        <?php
                        foreach ($mymessages as $minfos) {
                            ?>
                            <tr>
                                <td><?php echo $minfos['NOM_UTILISATEUR']; ?></td>
                                <td><?php echo $minfos['message']; ?></td>
                                <td><?php echo date('m/d/Y H:i:s', $minfos['timestamp']); ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                </div>
            </div>     
        </div>    
        <br />
        <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
            <h2><?php echo Myclass::t('OR629', '', 'or') ?></h2>
        </div>  
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'internal-message-form',
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
        ));
        ?>
        <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8"><?php echo $form->errorSummary(array($model)); ?></div>        
        <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
            <?php echo $form->labelEx($model, 'message'); ?>
            <?php echo $form->textArea($model, 'message', array('class' => 'form-control', 'maxlength' => 1000, 'rows' => 5, 'cols' => 50)); ?>         
        </div>    
        <?php echo $form->hiddenField($model, 'user2', array("value" => $userto_id)); ?>
        <?php echo $form->hiddenField($model, 'id2', array("value" => count($mymessages) + 1)); ?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php
            echo CHtml::tag('button', array(
                'name' => 'btnSubmit',
                'type' => 'submit',
                'class' => 'register-btn'
                    ), Myclass::t('OG120'));
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>   
</div>

<?php
$js = <<< EOD
         $(document).ready(function () {
            $(".nano").nanoScroller({ 
                scroll: 'bottom',
                alwaysVisible: true 
                });
         });
EOD;
Yii::app()->clientScript->registerScript('_form_prof', $js);
?>