<?php
$session_userid = $uid;

if($user1_id!=$session_userid)
{
    $userto_id = $user1_id;
}    
if($user2_id!=$session_userid)
{
    $userto_id = $user2_id;
}  

// Update the unread messages to read
$convid = Yii::app()->getRequest()->getQuery('convid');
$sql = "UPDATE internal_message SET user2read = 'yes' WHERE  user2 = '$session_userid' and id1= '$convid'";
$command = Yii::app()->db->createCommand($sql)->execute();
?>
<div class="cate-bg user-right">
    <h2> Conversation </h2>   
    <div class="row"> 
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 "> 
            <div class="box" id="box1">
              <div class="table-responsive">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered">
                    <tr>          
                        <th class="author">User</th>
                        <th>Message</th>
                        <th>Sent</th>
                    </tr>
                    <?php
                    foreach($mymessages as $minfos)
                    {    
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
        <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8"><h2>Reply</h2></div>  
      <?php  
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'internal-message-form',
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
        ));
        echo $form->errorSummary(array($model));?>
        <div class="col-xs-12 col-sm-6 col-md-8 col-lg-6">
            <?php echo $form->labelEx($model, 'message'); ?>
            <?php echo $form->textArea($model, 'message', array('class' => 'form-control', 'maxlength' => 1000, 'rows' => 5, 'cols' => 50)); ?>         
        </div>    
        <?php echo $form->hiddenField($model, 'user2', array("value" => $userto_id)); ?>
        <?php echo $form->hiddenField($model, 'id2', array("value" => count($mymessages)+1)); ?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php
            echo CHtml::tag('button', array(
                'name' => 'btnSubmit',
                'type' => 'submit',
                'class' => 'register-btn'
                    ), 'Submit');
            ?>
        </div>
     <?php $this->endWidget(); ?>
    </div>   
</div>