<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 subscribe-btncont"> 
        <div class="inner-container"> 
            <h2> <?php echo Myclass::t('OG034', '', 'og'); ?> </h2>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'client-profiles-form',
                'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data'), 
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'enableAjaxValidation' => true,
            ));
            
            $category_names = array();
            $cat_types = CHtml::listData(ClientCategoryTypes::model()->findAll(array("order"=>"cat_type_id asc")), 'cat_type_id', 'cat_type');
            if($model->cat_type_id){
                $category_names = CHtml::listData(ClientCategory::model()->findAll(array("order"=>"category asc","condition"=>"cat_type_id=".$model->cat_type_id)), 'category', 'cat_name');
            }else
            {
                $category_names = CHtml::listData(ClientCategory::model()->findAll(array("order"=>"category asc","condition"=>"cat_type_id=2")), 'category', 'cat_name');
            }    
            
            $country = Myclass::getallcountries_client();
            $regions = Myclass::getallregions_client($model->country,2);
            $cities = Myclass::getallcities_other($model->region);
            ?>    
            <div class="forms-cont"> 
                
                <div class="row"> 

                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                           <?php echo $form->labelEx($model, 'name'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                           <?php echo $form->textField($model, 'name', array('class' => 'form-txtfield')); ?>
                           <?php echo $form->error($model, 'name'); ?>
                        </div>
                    </div>
                    
                    <div class="form-row1">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php echo $form->labelEx($model, 'company'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                            <?php echo $form->textField($model, 'company', array('class' => 'form-txtfield')); ?>
                            <?php echo $form->error($model, 'company'); ?>
                        </div>
                    </div>

                    <div class="form-row1">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php echo $form->labelEx($model, 'job_title'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                            <?php echo $form->textField($model, 'job_title', array('class' => 'form-txtfield')); ?>
                            <?php echo $form->error($model, 'job_title'); ?>
                        </div>
                    </div>

                    <div class="form-row1">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                             <?php echo $form->labelEx($model, 'member_type'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                             <?php echo $form->dropDownList($model, 'member_type', array("free_member"=>'Free member','advertiser'=>'Advertiser'), array('class' => 'selectpicker')); ?> 
                        </div>
                    </div>

                     <div class="form-row1">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                              <?php echo $form->labelEx($model, 'sex'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                             <?php echo $form->dropDownList($model, 'sex', array("M"=>'Male','F'=>'Female'), array('class' => 'selectpicker')); ?> 
                        </div>
                    </div>

                    <div class="form-row1">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                             <?php echo $form->labelEx($model, 'lang'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                            <?php echo $form->dropDownList($model, 'lang', array("FR" => 'Français', "EN" => 'Anglais'), array('class' => 'selectpicker')); ?>
                            <?php echo $form->error($model, 'lang'); ?>
                        </div>
                    </div>


                    <div class="form-row1">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                             <?php echo $form->labelEx($model, 'ID_CLIENT'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">                    
                             <?php echo $model->ID_CLIENT; ?> 
                        </div>
                    </div>

                    <div class="form-row1">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                             <?php echo $form->labelEx($model, 'cat_type_id'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">    
                             <?php echo $form->dropDownList($model, 'cat_type_id', $cat_types, array('class' => 'selectpicker')); ?> 
                        </div>
                    </div>

                     <div class="form-row1">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php echo $form->labelEx($model, 'category'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">   
                            <?php 
                            $options_sections = $selected_sections;                        
                            $htmlOptions = array('size' => '7', 'multiple' => 'true', 'id' => 'ClientProfiles_category', 'class' => 'form-control','options'=>$options_sections);
                            echo $form->listBox($model, 'category', $category_names, $htmlOptions);
                            echo $form->error($model, 'category');
                            ?> 
                        </div>
                    </div>

                    <div class="form-row1">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                             <?php echo $form->labelEx($model, 'address'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                            <?php echo $form->textField($model, 'address', array('class' => 'form-txtfield')); ?>
                            <?php echo $form->error($model, 'address'); ?>
                        </div>
                    </div>

                    <div class="form-row1">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                            <?php echo $form->labelEx($model, 'local_number'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                            <?php echo $form->textField($model, 'local_number', array('class' => 'form-txtfield')); ?>
                            <?php echo $form->error($model, 'local_number'); ?>
                        </div>
                    </div>

                   <div class="form-row1">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                            <?php echo $form->labelEx($model, 'country'); ?>
                       </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">                 
                            <?php echo $form->dropDownList($model, 'country', $country, array('class' => 'selectpicker', 'empty' => Myclass::t('APP43'))); ?>                          
                            <?php echo $form->error($model, 'country'); ?>
                        </div>
                    </div>

                    <div class="form-row1">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                            <?php echo $form->labelEx($model, 'region'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">                      
                            <?php echo $form->dropDownList($model, 'region', $regions, array('class' => 'selectpicker', 'empty' => Myclass::t('APP44'))); ?>                          
                            <?php echo $form->error($model, 'region'); ?>
                        </div>
                    </div>

                    <div class="form-row1">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                           <?php echo $form->labelEx($model, 'ville'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">                     
                            <?php echo $form->dropDownList($model, 'ville', $cities, array('class' => 'selectpicker', 'empty' => Myclass::t('APP59'))); ?>   
                            <?php echo $form->error($model, 'ville'); ?>
                        </div>
                    </div>

                    <div class="form-row1">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                             <?php echo $form->labelEx($model, 'CodePostal'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">  
                            <?php echo $form->textField($model, 'CodePostal', array('class' => 'form-txtfield')); ?>(Password)
                            <?php echo $form->error($model, 'CodePostal'); ?>
                        </div>
                    </div>

                    <div class="form-row1">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                             <?php echo $form->labelEx($model, 'phonenumber1'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">    
                            <?php echo $form->textField($model, 'phonenumber1', array('class' => 'form-txtfield')); ?>
                            <?php echo $form->error($model, 'phonenumber1'); ?>
                        </div>
                    </div>

                    <div class="form-row1">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                            <?php echo $form->labelEx($model, 'phonenumber2'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">    
                            <?php echo $form->textField($model, 'phonenumber2', array('class' => 'form-txtfield')); ?>
                            <?php echo $form->error($model, 'phonenumber2'); ?>
                        </div>
                    </div>

                     <div class="form-row1">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                           <?php echo $form->labelEx($model, 'phonenumber3'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">    
                            <?php echo $form->textField($model, 'phonenumber3', array('class' => 'form-txtfield')); ?>
                            <?php echo $form->error($model, 'phonenumber3'); ?>
                        </div>
                    </div>

                    <div class="form-row1">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                            <?php echo $form->labelEx($model, 'mobile_number'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">  
                            <?php echo $form->textField($model, 'mobile_number', array('class' => 'form-txtfield')); ?>
                            <?php echo $form->error($model, 'mobile_number'); ?>
                        </div>
                    </div>

                    <div class="form-row1">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                            <?php echo $form->labelEx($model, 'tollfree_number'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">  
                            <?php echo $form->textField($model, 'tollfree_number', array('class' => 'form-txtfield')); ?>
                            <?php echo $form->error($model, 'tollfree_number'); ?>
                        </div>
                    </div>

                    <div class="form-row1">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                            <?php echo $form->labelEx($model, 'fax'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">  
                            <?php echo $form->textField($model, 'fax', array('class' => 'form-txtfield')); ?>
                            <?php echo $form->error($model, 'fax'); ?>
                        </div>
                    </div>

                    <div class="form-row1">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                           <?php echo $form->labelEx($model, 'Poste1'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <?php echo $form->textField($model, 'Poste1', array('class' => 'form-txtfield')); ?> 
                            <?php echo $form->error($model, 'Poste1'); ?>
                        </div>
                    </div>

                    <div class="form-row1">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                            <?php echo $form->labelEx($model, 'Poste2'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <?php echo $form->textField($model, 'Poste2', array('class' => 'form-txtfield')); ?>
                            <?php echo $form->error($model, 'Poste2'); ?>
                        </div>
                    </div>     

                    <div class="form-row1">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                            <?php echo $form->labelEx($model, 'email'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <?php echo $form->textField($model, 'email', array('class' => 'form-txtfield')); ?>
                            <?php echo $form->error($model, 'email'); ?>
                        </div>
                    </div>

                    <div class="form-row1">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                           <?php echo $form->labelEx($model, 'site_address'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <?php echo $form->textField($model, 'site_address', array('class' => 'form-txtfield')); ?>(http://www.monsite.com )
                            <?php echo $form->error($model, 'site_address'); ?>
                        </div>
                    </div>
                     <div class="form-row1">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                            <?php echo $form->labelEx($model, 'Website2'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <?php echo $form->textField($model, 'Website2', array('class' => 'form-txtfield')); ?>(http://www.monsite.com )
                            <?php echo $form->error($model, 'Website2'); ?>
                        </div>
                    </div>
                     <div class="form-row1">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                            <?php echo $form->labelEx($model, 'Rep'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <?php echo $form->textField($model, 'Rep', array('class' => 'form-txtfield')); ?>
                            <?php echo $form->error($model, 'Rep'); ?>
                        </div>
                    </div>

                    <div class="box-header">
                        <h3 class="box-title">Subscription</h3>
                    </div>

                    <div class="form-row1">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                            <?php echo $form->labelEx($model, 'subscription', array('class' => 'col-sm-2 control-label')); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">    
                              <?php echo $form->checkBox($model, 'Optipromo', array('value' => 1, 'uncheckValue' => 0)); ?>   
                                <?php echo $form->labelEx($model, 'Optipromo'); ?>
                                <br/> 
                                <?php echo $form->checkBox($model, 'Optinews', array('value' => 1, 'uncheckValue' => 0)); ?>   
                                <?php echo $form->labelEx($model, 'Optinews'); ?>
                                <br/> 
                                <?php echo $form->checkBox($model, 'Envision_print', array('value' => 1, 'uncheckValue' => 0)); ?>   
                                <?php echo $form->labelEx($model, 'Envision_print'); ?>
                                <br/>                                   
                                <?php echo $form->checkBox($model, 'Envision_digital', array('value' => 1, 'uncheckValue' => 0)); ?>   
                                <?php echo $form->labelEx($model, 'Envision_digital'); ?>
                                <br/> 
                                <?php echo $form->checkBox($model, 'Envue_print', array('value' => 1, 'uncheckValue' => 0)); ?>   
                                <?php echo $form->labelEx($model, 'Envue_print'); ?>
                                <br/> 
                                <?php echo $form->checkBox($model, 'Envue_digital', array('value' => 1, 'uncheckValue' => 0)); ?>   
                                <?php echo $form->labelEx($model, 'Envue_digital'); ?>
                        </div>         
                    </div>

                    <div class="form-row1"> 
                       <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 pull-right"> 
                           <?php
                           echo CHtml::tag('button', array(
                               'name' => 'btnSubmit',
                               'type' => 'submit',
                               'class' => 'submit-btn'
                                   ), '<i class="fa fa-check-circle"></i> ' . Myclass::t('OG120'));
                           ?>
                       </div>
                   </div>

                </div> 
            </div>
       <?php $this->endWidget(); ?>
        </div>     
    </div>
</div>
<?php
$ajaxCatUrl = Yii::app()->createUrl('/admin/clientProfiles/getcategories');
$ajax_getmessage  = Yii::app()->createUrl('/admin/clientProfiles/getmessage');

$ajaxRegionUrl = Yii::app()->createUrl('/admin/professionalDirectory/getregions');
$ajaxCityUrl = Yii::app()->createUrl('/admin/professionalDirectory/getcities');

$ajax_get_client_mess_update = Yii::app()->createUrl('/admin/clientProfiles/updateMessage');
$js = <<< EOD

   $(document).ready(function(){
        
    $("#ClientProfiles_cat_type_id").change(function(){
        var id=$(this).val();
        var dataString = 'id='+ id;
            
        $.ajax({
            type: "POST",
            url: '{$ajaxCatUrl}',
            data: dataString,
            cache: false,
            success: function(html){             
                $("#ClientProfiles_category").html(html);
            }
         });
    });
            
   $('.year').datepicker({ dateFormat: 'yyyy' });
   $('.date').datepicker({ format: 'dd-mm-yyyy', startDate: '+0d',});   
            
   $('.popupmessage').live('click',function(event){
        event.preventDefault();
        var message_id = $(this).attr("id");      
        var dataString = 'id='+message_id;
            
        $.ajax({
            type: "POST",
            url: '{$ajax_getmessage}',
            data: dataString,
            cache: false,
            success: function(html){             
                $("#product_contents").html(html);               
            }
         });
       
    });
            
     $('.client_message_update_popup').live('click',function(event){
        event.preventDefault();
        var client_message_id = $(this).attr("id");
        var dataString = 'message_id='+client_message_id;

        $.ajax({
            type: "GET",
            url: '{$ajax_get_client_mess_update}',
            data: dataString,
            cache: false,
            success: function(html){             
                $("#client_message_contents").html(html);  
                $('.year').datepicker({ dateFormat: 'yyyy' });
                $('.date').datepicker({ format: 'dd-mm-yyyy', startDate: '+0d',});   
            }
         });
    });  
        
    $("#ClientProfiles_country").change(function(){
        var id=$(this).val();
        var dataString = 'id='+ id;
            
        $.ajax({
            type: "POST",
            url: '{$ajaxRegionUrl}',
            data: dataString+'&client_disp=2',
            cache: false,
            success: function(html){             
                $("#ClientProfiles_region").html(html);
            }
         });
    });
   
   $("#ClientProfiles_region").change(function(){
        var id=$(this).val();
        var dataString = 'id='+ id;
            
        $.ajax({
            type: "POST",
            url: '{$ajaxCityUrl}',
            data: dataString+'&client_dis=1',
            cache: false,
            success: function(html){             
                $("#ClientProfiles_ville").html(html);
            }
         });

    });         
  
});
EOD;
Yii::app()->clientScript->registerScript('_form_prof', $js);
?>