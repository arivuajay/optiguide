<?php
/* @var $this UserDirectoryController */
/* @var $model UserDirectory */
/* @var $form CActiveForm */
?>

<?php
  
//    $relid    = Yii::app()->getRequest()->getQuery('relid');
//    $nomtable = Yii::app()->getRequest()->getQuery('nomtable');
//    $userslist_query = Yii::app()->db->createCommand() //this query contains all the data
//            ->select('ID_UTILISATEUR , NOM_UTILISATEUR , USR')
//            ->from(array('repertoire_utilisateurs'))
//            ->where("ID_RELATION='$relid' AND NOM_TABLE='$nomtable'")
//            ->order('NOM_UTILISATEUR')
//            ->limit(1)
//            ->queryAll();  
//    if(!empty($userslist_query))
//    {       
//        foreach($userslist_query as $info)
//        {
//         $edituserlink =  '/admin/userDirectory/update';
//         $uid =  $info['ID_UTILISATEUR'];
//        } 
//        $this->redirect(array($edituserlink,"id"=>$uid));
//    }
$cs_pos_end = CClientScript::POS_END;
        $themeUrl = $this->themeUrl;

        if ($model->rep_credential_id) {
            $actn_url = Yii::app()->createUrl('/admin/repCredential/update', array('id' => $model->rep_credential_id));
        } else {
            $actn_url = Yii::app()->createUrl('/admin/repCredential/create/');
        }
$country = Myclass::getallcountries();
        $regions = Myclass::getallregions($profile->country);
        $cities = Myclass::getallcities($profile->region);
        $paymentcounts = 0;
        if ($model->rep_credential_id) {
            $paymentcounts = PaymentTransaction::model()->count("NOMTABLE='rep_credentials' AND user_id=" . $model->rep_credential_id);
        }
    
?>

<div class="row">
    <div class="col-lg-12 col-xs-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a id="a_tab_1" href="#tab_1" data-toggle="tab">Renseignements généraux</a></li>
                <li><a id="a_tab_2" href="#tab_2" <?php
                    if (Yii::app()->user->hasState("secondtab")) {
                        echo 'data-toggle="tab"';
                    } elseif ($model->rep_credential_id) {
                        echo 'data-toggle="tab"';
                    }
                    ?>>Subscription Payment</a></li>
                    <?php if ($paymentcounts > 0) { ?>
                    <li><a id="a_tab_3" href="#tab_3" data-toggle="tab">Payment Transactions</a></li>
                <?php } ?>
            </ul>
            <div class="tab-content">                
                <div class="tab-pane active" id="tab_1">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'rep-credential-form',
                        'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
                        'action' => $actn_url,
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                        ),
                        'enableAjaxValidation' => true,
                    ));
                    ?>
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="form-group">
                            <?php echo $form->labelEx($profile, 'rep_profile_firstname', array('class' => 'col-sm-2 control-label')); ?>
                            <div class="col-sm-5">
                                <?php echo $form->textField($profile, 'rep_profile_firstname', array('class' => 'form-control', 'size' => 50, 'maxlength' => 50)); ?>
                                <?php echo $form->error($profile, 'rep_profile_firstname'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <?php echo $form->labelEx($profile, 'rep_profile_lastname', array('class' => 'col-sm-2 control-label')); ?>
                            <div class="col-sm-5">
                                <?php echo $form->textField($profile, 'rep_profile_lastname', array('class' => 'form-control', 'size' => 50, 'maxlength' => 50)); ?>
                                <?php echo $form->error($profile, 'rep_profile_lastname'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'rep_username', array('class' => 'col-sm-2 control-label')); ?>
                            <div class="col-sm-5">
                                <?php echo $form->textField($model, 'rep_username', array('class' => 'form-control', 'size' => 50, 'maxlength' => 50)); ?>
                                <?php echo $form->error($model, 'rep_username'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'rep_password', array('class' => 'col-sm-2 control-label')); ?>
                            <div class="col-sm-5">
                                <?php echo $form->textField($model, 'rep_password', array('class' => 'form-control', 'size' => 50, 'maxlength' => 50)); ?>
                                <?php echo $form->error($model, 'rep_password'); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php echo $form->labelEx($profile, 'rep_profile_email', array('class' => 'col-sm-2 control-label')); ?>
                            <div class="col-sm-5">
                                <?php echo $form->textField($profile, 'rep_profile_email', array('class' => 'form-control', 'size' => 50, 'maxlength' => 50)); ?>
                                <?php echo $form->error($profile, 'rep_profile_email'); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php echo $form->labelEx($profile, 'rep_profile_phone', array('class' => 'col-sm-2 control-label')); ?>
                            <div class="col-sm-5">
                                <?php echo $form->textField($profile, 'rep_profile_phone', array('class' => 'form-control', 'size' => 50, 'maxlength' => 50)); ?>
                                <?php echo $form->error($profile, 'rep_profile_phone'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <?php echo $form->labelEx($profile, 'rep_address', array('class' => 'col-sm-2 control-label')); ?>
                            <div class="col-sm-5">
                                <?php echo $form->textField($profile, 'rep_address', array('class' => 'form-control', 'size' => 50, 'maxlength' => 50)); ?>
                                <?php echo $form->error($profile, 'rep_address'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <?php echo $form->labelEx($profile, 'country', array('class' => 'col-sm-2 control-label')); ?>      
                            <div class="col-sm-5">
                            <?php echo $form->dropDownList($profile, 'country', $country, array('class' => 'form-control', 'empty' => Myclass::t('APP43'))); ?>                          
                            <?php echo $form->error($profile, 'country'); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php echo $form->labelEx($profile, 'region', array('class' => 'col-sm-2 control-label')); ?>
                            <div class="col-sm-5">
                            <?php echo $form->dropDownList($profile, 'region', $regions, array('class' => 'form-control', 'empty' => Myclass::t('APP44'))); ?>                          
                            <?php echo $form->error($profile, 'region'); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php echo $form->labelEx($profile, 'ID_VILLE', array('class' => 'col-sm-2 control-label')); ?>
                            <div class="col-sm-5">
                            <?php echo $form->dropDownList($profile, 'ID_VILLE', $cities, array('class' => 'form-control', 'empty' => Myclass::t('APP59'))); ?>   
                            <?php echo $form->error($profile, 'ID_VILLE'); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'rep_status', array('class' => 'col-sm-2 control-label')); ?>         
                            <div class="col-sm-5">
                            <?php echo $form->radioButtonList($model, 'rep_status', array('1' => 'Oui', '0' => 'Non'), array('separator' => ' ')); ?> 
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                    </div>
                <div class="box-footer">
                    <div class="form-group">
                        <div class="col-sm-0 col-sm-offset-2">
                            <?php echo CHtml::submitButton($model->isNewRecord ? 'Ajouter ce utilisateur et passer à l\'étape suivante' : 'Modifier ce utilisateur', array('class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary')); ?>
                            <?php // echo CHtml::submitButton($model->isNewRecord ? 'Ajouter cet utilisateur' : 'Modifier cet utilisateur', array('class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','name'=>'client_sub')); ?>
                        </div>
                    </div>
                </div>
                <?php $this->endWidget(); ?>
            </div>
                <div class="tab-pane" id="tab_2">
                    <?php
                    $this->renderPartial('_payment_form', array('model' => $model, 'form' => $form, 'data_products' => $data_products, 'pmodel' => $pmodel,'profile'=>$profile));
                    ?>
                </div>  

                <div class="tab-pane" id="tab_3">
                    <?php
                    $this->renderPartial('_payment_transactions', array('model' => $model, 'form' => $form, 'data_products' => $data_products, 'pmodel' => $pmodel));
                    ?>
                </div>  
            </div>
    </div><!-- ./col -->
</div>
<?php
$cs = Yii::app()->getClientScript();

$ajaxRegionUrl = Yii::app()->createUrl('/admin/repCredential/getregions');
$ajaxCityUrl = Yii::app()->createUrl('/admin/repCredential/getcities');

$jsoncde = array();

if (Yii::app()->user->hasState("product_ids")) {
    $sess_product_ids = Yii::app()->user->getState("product_ids");
    $jsoncde = json_encode($sess_product_ids);
}


$pay_type = isset($pmodel->pay_type) ? $pmodel->pay_type : 1;
$js = <<< EOD
    $(document).ready(function(){
   
// Get region for seleted country   
    $("#RepCredentialProfiles_country").change(function(){
        var id=$(this).val();
        var dataString = 'id='+ id;
         
        $.ajax({
            type: "POST",
            url: '{$ajaxRegionUrl}',
            data: dataString,
            cache: false,
            success: function(html){             
                $("#RepCredentialProfiles_region").html(html);
            }
         });
    });
   
// Get cities for seleted region
   $("#RepCredentialProfiles_region").change(function(){
        var id=$(this).val();
        var dataString = 'id='+ id;
            
        $.ajax({
            type: "POST",
            url: '{$ajaxCityUrl}',
            data: dataString,
            cache: false,
            success: function(html){             
                $("#RepCredentialProfiles_ID_VILLE").html(html);
            }
         });

    });  


            
});
EOD;
Yii::app()->clientScript->registerScript('_form', $js);
?>