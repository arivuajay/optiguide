<?php
/* @var $this SuppliersDirectoryController */
/* @var $model SuppliersDirectory */
/* @var $form CActiveForm */

$cs_pos_end = CClientScript::POS_END;
$themeUrl = $this->themeUrl;

$relid = Yii::app()->user->relationid;
$get_expirydate = SuppliersDirectory::model()->findByPk($relid);

$profile_expirydate = $get_expirydate['profile_expirydate'];
$logo_expirydate = $get_expirydate['logo_expirydate'];

$subprices = SupplierSubscriptionPrice::model()->findByPk(1);
$profile_price = $subprices->profile_price;
$profile_logo_price = $subprices->profile_logo_price;
$logo_price = $profile_logo_price - $profile_price;
?>
<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 subscribe-btncont"> 
        <div class="inner-container"> 
            <h2> <?php echo Myclass::t('OGO201','','og');?></h2>     

            <div class="row"> 
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <table class="table table-bordered" id="bckrnd">
                        <tr>  
                            <th><?php echo Myclass::t('OGO190','','og');?></th>
                            <th><?php echo Myclass::t('OGO191','','og');?></th>                        
                        </tr>                             
                        <tr>                              
                            <td><?php echo ($profile_expirydate=="0000-00-00 00:00:00")?Myclass::t('OGO200','','og'):date("d-m-Y", strtotime($profile_expirydate)); ?></td>
                            <td><?php echo ($logo_expirydate=="0000-00-00 00:00:00")?Myclass::t('OGO200','','og'):date("d-m-Y", strtotime($logo_expirydate)); ?></td>
                        </tr>
                    </table>                    
                </div>                  
            </div>
            
            <p><?php echo Myclass::t('OGO193','','og');?></p>

            <h4><?php echo Myclass::t('OGO194','','og');?></h4>
            <ul>
                <li><?php echo Myclass::t('OGO195','','og');?></li>
                <li><?php echo Myclass::t('OGO196','','og');?></li>
                <li><?php echo Myclass::t('OGO197','','og');?></li>
            </ul>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'suppliers-renewsubscription-form',
                'htmlOptions' => array('role' => 'form'),
            ));
            ?>    
            <div class="forms-cont"> 
                <div class="forms-heading"><i class="fa fa-thumb-tack"></i> <?php echo Myclass::t('OGO198','','og');?></div>
                <div class="row"> 
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <table class="table table-bordered" id="bckrnd">
                            <tr>   
                                <th><?php echo Myclass::t('OGO202', '', 'og'); ?></th>
                                <th><?php echo Myclass::t('OGO141', '', 'og'); ?></th>
                                <th><?php echo Myclass::t('OG138'); ?></th>                        
                            </tr>                             
                            <tr>
                                <td><input type="checkbox" name="subvals[]" value="1" ></td>
                                <td>Profile</td>
                                <td><?php echo $profile_price; ?> CAD</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" name="subvals[]" value="3" ></td>
                                <td>Logo</td>
                                <td><?php echo $logo_price; ?> CAD</td>
                            </tr>
                        </table>
                        <div id="errormsg" class="errorMessage" style="display:none;"><?php echo Myclass::t('OGO192','','og');?></div>
                    </div>                  
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 pull-right"> 
                    <?php
                    echo CHtml::tag('button', array(
                        'name' => 'btnSubmit',
                        'value' => 'subscriptionpay',
                        'type' => 'submit',
                        'class' => 'submit-btn'
                            ), '<i class="fa fa-arrow-circle-right"></i> '.Myclass::t('OGO199','','og'));
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
