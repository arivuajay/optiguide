<?php
/* @var $this SuppliersDirectoryController */
/* @var $model SuppliersDirectory */
/* @var $form CActiveForm */

$cs_pos_end = CClientScript::POS_END;
$themeUrl = $this->themeUrl;

$relid = Yii::app()->user->relationid;
$get_expirydate = SuppliersDirectory::model()->findByPk($relid);
$profile_expirydate = '';
if (!empty($get_expirydate)) {
    if ($get_expirydate['profile_expirydate'] != "0000-00-00 00:00:00") {
        $profile_expirydate = $get_expirydate['profile_expirydate'];
        $profile_expirydate = date("d-m-Y", strtotime($profile_expirydate));
        
        $cur_date = strtotime("now");
        $expdate  = strtotime($profile_expirydate);
        $disp     = ($expdate > $cur_date) ? 1 : 0;
        if($disp==1)
        {    
            $txtdisp = "<p><strong>Your subscription will expire on ".$profile_expirydate.". So here the following subscriptions to renew it.</strong></p>";
        }  else {
            $txtdisp = "<p><strong>Your subscription expired on ".$profile_expirydate.". So here the following subscriptions to renew it.</strong></p>";
        }    
    }
}

$subprices     = SupplierSubscriptionPrice::model()->findByPk(1);
$profile_price = $subprices->profile_price;
$profile_logo_price    = $subprices->profile_logo_price;
$logo_price = $profile_logo_price-$profile_price;
?>
<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 subscribe-btncont"> 
        <div class="inner-container"> 
            <h2> Renew it now!!!</h2>
            <?php if ($profile_expirydate != '') {
                    echo $txtdisp;
                } else { ?>
                <p>Here the following subscriptions to renew it and continue the site features.</p>
            <?php } ?>
            <h4>Subscription Features:</h4>
            <ul>
                <li>Renew the profile subscription only means , your complete profile is visible for all users and you get professionals and retailers menu with searching options.</li>
                <li>Renew the logo subscription only means , you can upload personal logo and its visible for all users.</li>
                <li>Renew the profile and logo subscriptions means , your complete profile and logo is visible for all users and you get professionals and retailers users menu with searching options.</li>
            </ul>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'suppliers-renewsubscription-form',
                'htmlOptions' => array('role' => 'form'),
            ));
            ?>    
            <div class="forms-cont"> 
                <div class="forms-heading"><i class="fa fa-thumb-tack"></i> Renew Subscription</div>
                <div class="row"> 
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <table class="table table-bordered" id="bckrnd">
                            <tr>   
                                <th>Choose Types</th>
                                <th><?php echo Myclass::t('OGO141', '', 'og'); ?></th>
                                <th><?php echo Myclass::t('OG138'); ?></th>                        
                            </tr>                             
                            <tr>
                                <td><input type="checkbox" name="subvals[]" value="1" ></td>
                                <td>Profile</td>
                                <td><?php echo $profile_price;?> CAD</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" name="subvals[]" value="3" ></td>
                                <td>Logo</td>
                                <td><?php echo $logo_price;?> CAD</td>
                            </tr>
                        </table>
                        <div id="errormsg" class="errorMessage" style="display:none;">Please Choose any subscription for payment.</div>
                    </div>                  
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 pull-right"> 
                    <?php
                    echo CHtml::tag('button', array(
                        'name'  => 'btnSubmit',
                        'value' => 'subscriptionpay',
                        'type'  => 'submit',
                        'class' => 'submit-btn'
                            ), '<i class="fa fa-arrow-circle-right"></i> RENEW');
                    ?>
                </div>   
            </div>
            <?php $this->endWidget(); ?>          
        </div>       
    </div>
</div>
<?php
$js = <<< EOD
$(document).ready(function(){ 
  
   $("#suppliers-renewsubscription-form").submit(function() {
        $("#errormsg").hide();   
        var checked = $(this).find("input[name='subvals[]']:checked").length;   
        if ( checked == 0 )     {
            $("#errormsg").show();
            return false;
        }           
    });   
 });
EOD;
Yii::app()->clientScript->registerScript('_form_payment', $js);
?>
