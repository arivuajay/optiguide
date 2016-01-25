<?php
/* @var $this ClientProfilesController */
/* @var $model ClientProfiles */
/* @var $form CActiveForm */

$themeUrl = $this->themeUrl;
                $cs = Yii::app()->getClientScript();
                $cs_pos_end = CClientScript::POS_END;

                $cs->registerCssFile($themeUrl . '/css/datepicker/datepicker3.css');
                $cs->registerScriptFile($themeUrl . '/js/datepicker/bootstrap-datepicker.js', $cs_pos_end);
                
                $cs->registerScriptFile($themeUrl . '/js/datatables/jquery.dataTables.js', $cs_pos_end);
                $cs->registerScriptFile($themeUrl . '/js/datatables/dataTables.bootstrap.js', $cs_pos_end);
?>

<div class="row">
    <?php 
    $form = $this->beginWidget('CActiveForm', array(
                'id' => 'client-profiles-form',
                'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data'), 
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'enableAjaxValidation' => true,
            ));
    ?>
    <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
            <?php          
            
            
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
            $cities = Myclass::getallcities($model->region);
            ?>
            <div class="box-body">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'name', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'name'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'company', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'company', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'company'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'job_title', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'job_title', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'job_title'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'member_type', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                         <?php echo $form->dropDownList($model, 'member_type', array("free_member"=>'Free member','advertiser'=>'Advertiser'), array('class' => 'form-control')); ?> 
                    </div>
                </div>
                
                 <div class="form-group">
                    <?php echo $form->labelEx($model, 'sex', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                         <?php echo $form->dropDownList($model, 'sex', array("M"=>'Male','F'=>'Female'), array('class' => 'form-control')); ?> 
                    </div>
                </div>
                <?php if (!$model->isNewRecord) {   ?>  
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'ID_CLIENT', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                         <?php echo $model->ID_CLIENT; ?> 
                    </div>
                </div>
                <?php } ?>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'cat_type_id', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->dropDownList($model, 'cat_type_id', $cat_types, array('class' => 'form-control')); ?> 
                    </div>
                </div>
                
                 <div class="form-group">
                    <?php echo $form->labelEx($model, 'category', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php 
                        $options_sections = $selected_sections;                        
                        $htmlOptions = array('size' => '7', 'multiple' => 'true', 'id' => 'ClientProfiles_category', 'class' => 'form-control','options'=>$options_sections);
                        echo $form->listBox($model, 'category', $category_names, $htmlOptions);
                        echo $form->error($model, 'category');
                        ?> 
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'address', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'address', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'address'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'local_number', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'local_number', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'local_number'); ?>
                    </div>
                </div>

               <div class="form-group">
                    <?php echo $form->labelEx($model, 'country', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">                       
                        <?php echo $form->dropDownList($model, 'country', $country, array('class' => 'form-control', 'empty' => Myclass::t('APP43'))); ?>                          
                        <?php echo $form->error($model, 'country'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'region', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">                       
                        <?php echo $form->dropDownList($model, 'region', $regions, array('class' => 'form-control', 'empty' => Myclass::t('APP44'))); ?>                          
                        <?php echo $form->error($model, 'region'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'ville', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">                       
                        <?php echo $form->dropDownList($model, 'ville', $cities, array('class' => 'form-control', 'empty' => Myclass::t('APP59'))); ?>   
                        <?php echo $form->error($model, 'ville'); ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'CodePostal', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'CodePostal', array('class' => 'form-control', 'size' => 55, 'maxlength' => 55)); ?>
                        <?php echo $form->error($model, 'CodePostal'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'phonenumber1', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'phonenumber1', array('class' => 'form-control', 'size' => 55, 'maxlength' => 55)); ?>
                        <?php echo $form->error($model, 'phonenumber1'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'phonenumber2', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'phonenumber2', array('class' => 'form-control', 'size' => 55, 'maxlength' => 55)); ?>
                        <?php echo $form->error($model, 'phonenumber2'); ?>
                    </div>
                </div>
                
                 <div class="form-group">
                    <?php echo $form->labelEx($model, 'phonenumber3', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'phonenumber3', array('class' => 'form-control', 'size' => 55, 'maxlength' => 55)); ?>
                        <?php echo $form->error($model, 'phonenumber3'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'mobile_number', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'mobile_number', array('class' => 'form-control', 'size' => 55, 'maxlength' => 55)); ?>
                        <?php echo $form->error($model, 'mobile_number'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'tollfree_number', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'tollfree_number', array('class' => 'form-control', 'size' => 55, 'maxlength' => 55)); ?>
                        <?php echo $form->error($model, 'tollfree_number'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'fax', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'fax', array('class' => 'form-control', 'size' => 55, 'maxlength' => 55)); ?>
                        <?php echo $form->error($model, 'fax'); ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'Poste1', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'Poste1', array('class' => 'form-control', 'size' => 55, 'maxlength' => 55)); ?>
                        <?php echo $form->error($model, 'Poste1'); ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'Poste2', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'Poste2', array('class' => 'form-control', 'size' => 55, 'maxlength' => 55)); ?>
                        <?php echo $form->error($model, 'Poste2'); ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'Europe', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'Europe', array('class' => 'form-control', 'size' => 55, 'maxlength' => 55)); ?>
                        <?php echo $form->error($model, 'Europe'); ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'feurope', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'feurope', array('class' => 'form-control', 'size' => 55, 'maxlength' => 55)); ?>
                        <?php echo $form->error($model, 'feurope'); ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'email', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'email', array('class' => 'form-control', 'size' => 55, 'maxlength' => 55)); ?>
                        <?php echo $form->error($model, 'email'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'site_address', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'site_address', array('class' => 'form-control', 'size' => 55, 'maxlength' => 55)); ?>(http://www.monsite.com )
                        <?php echo $form->error($model, 'site_address'); ?>
                    </div>
                </div>
                 <div class="form-group">
                    <?php echo $form->labelEx($model, 'Website2', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'Website2', array('class' => 'form-control', 'size' => 55, 'maxlength' => 55)); ?>(http://www.monsite.com )
                        <?php echo $form->error($model, 'Website2'); ?>
                    </div>
                </div>
                 <div class="form-group">
                    <?php echo $form->labelEx($model, 'Rep', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'Rep', array('class' => 'form-control', 'size' => 55, 'maxlength' => 55)); ?>
                        <?php echo $form->error($model, 'Rep'); ?>
                    </div>
                </div>
                <div class="box-header">
                    <h3 class="box-title">Subscription</h3>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'subscription', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
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
                <?php
                if (!$model->isNewRecord) {
                    ?>
                <div class="form-group"> 
                    <?php echo $form->labelEx($model, 'modified_date', array('class' => 'col-sm-2 control-label')); ?> 
                    <div class="col-sm-5">        
                        <?php echo $model->modified_date; ?>
                    </div>     
                </div>
                <div class="form-group"> 
                    <?php echo $form->labelEx($model, 'created_date', array('class' => 'col-sm-2 control-label')); ?> 
                    <div class="col-sm-5">        
                        <?php echo $model->created_date; ?>
                    </div>     
                </div>
                 <div class="box-header">
                    <h3 class="box-title">Réglez l'alerte à l'employé</h3>
                </div>
                <?php
                

                if(!$cmodel->status){ $cmodel->status=0;}                
                $employees = CHtml::listData(EmployeeProfiles::model()->findall(array("order"=>"employee_name asc")), 'employee_id', 'employee_name');           
                ?>
              

                <div class="form-group">
                    <?php echo $form->labelEx($cmodel, 'employee_id', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->dropDownList($cmodel, 'employee_id', $employees, array('class' => 'form-control')); ?> 
                        <?php echo $form->error($cmodel, 'employee_id'); ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <?php echo $form->labelEx($cmodel, 'date_remember', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($cmodel, 'date_remember', array('class' => 'form-control date')); ?>
                        <?php echo $form->error($cmodel, 'date_remember'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($cmodel, 'message', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textArea($cmodel, 'message', array('class' => 'form-control', 'rows' => 6, 'cols' => 50)); ?>
                        <?php echo $form->error($cmodel, 'message'); ?>
                    </div>
                </div>
                
                 <div class="form-group"> 
                    <?php echo $form->labelEx($cmodel, 'afile', array('class' => 'col-sm-2 control-label')); ?>                   
                    <div class="col-sm-5">     
                        <?php echo $form->fileField($cmodel, 'afile'); ?>                         
                        <?php echo $form->error($cmodel, 'afile'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($cmodel, 'status', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->radioButtonList($cmodel, 'status', array('1' => 'Oui', '0' => 'Non'), array('separator' => ' ')); ?> 
                        <?php echo $form->error($cmodel, 'status'); ?>
                    </div>
                </div>
                
                <div class="box-header">
                    <h3 class="box-title">L'historique des alertes</h3>
                </div>   
                
                 <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a id="a_tab_1" href="#tab_1" data-toggle="tab">Active Alerts</a></li>
                            <li><a id="a_tab_2" href="#tab_2"  data-toggle="tab">Expire Alerts</a></li>                                                       
                        </ul>

                        <div class="tab-content">                
                            <div class="tab-pane active" id="tab_1">    
                                <div class="row">
                                  <?php
                                        $gridColumns = array(  
                                                array('header' => 'SN.',
                                                    'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                                                ), 
                                                array(
                                               'name'    => 'employeeProfiles.employee_name',
                                               'value'   => $data->employeeProfiles->employee_name,
                                                ), 		
                                                array('name' => 'date_remember',
                                                   'type' => 'raw',
                                                   'value' => function($data){
                                                       echo date("d-m-Y",strtotime($data->date_remember));
                                                   },
                                                   'filter' => false,
                                                ),
                                                array('name' => 'status',
                                                   'type' => 'raw',
                                                   'value' => function($data){
                                                       echo ($data->status == "1") ? '<span class="label label-success">Enable</span>' : '<span class="label label-warning">Disable</span>';
                                                   },
                                                   'filter' => false,
                                                ),  
                                                array(
                                                    'name' => 'user_view_status',
                                                    'type' => 'HTML',
                                                    'value' => function($data){
                                                         echo  ($data->user_view_status == "1") ? '<span class="label label-success">User saw the infos.</span>' : '<span class="label label-warning">User not yet see the alert.</span>';
                                                    }
                                                ) ,
                                                array('header' => 'message',
                                                    'type' => 'raw',
                                                    'htmlOptions' => array('style' => 'text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
                                                    'filter' => false,
                                                      //call the method 'gridDataColumn' from the controller
                                                    'value' => array($this, 'gridDataColumn'),
                                                ), 
                                                array('name' => 'created_date',
                                                    'type' => 'raw',
                                                    'value' => function($data) {
                                                        echo date("d-m-Y", strtotime($data->created_date));
                                                    },
                                                    'filter' => false,
                                                ),
                                                array(
                                                'header' => 'Actes',
                                                'class' => 'ButtonColumn',
                                                'htmlOptions' => array('style' => 'text-align:center;width:10%', 'vAlign' => 'middle', 'class' => 'action_column'),
                                                'template' => '{update}&nbsp;&nbsp;{delete}',
                                                'evaluateID' => true,
                                                'buttons'=>array
                                                    (
                                                        'delete' => array
                                                        (
                                                            'label'=>'Delete',                                            
                                                             'url'=>'Yii::app()->createUrl("admin/clientMessages/delete", array("id"=>$data->message_id))',
                                                        ),
                                                        'update' => array(
                                                            'label' => 'Update',
                                                            'url' => '"javascript:void(0)"',
                                                            'options' => array(
                                                                "id" => '\'messageid_\'.$data->message_id',
                                                                'data-target' => '#client-message-update-modal',
                                                                'data-toggle' => 'modal',
                                                                'class' => 'client_message_update_popup',
                                                            ),
                                                        )                                   
                                                    ),
                                                )
                                        );

                                        $this->widget('booster.widgets.TbExtendedGridView', array(
                                                'type' => 'striped bordered datatable',
                                                'enableSorting' => false,
                                                'dataProvider' => $ccurrentmodel,
                                                'responsiveTable' => true,
                                                'template' => '  <div id="histrydisp" tabindex="-1" class="col-md-7"><div class="box"> <div class="box-body">{items}</div> <div class="box-footer clearfix">{pager}</div> </div></div>',
                                                'columns' => $gridColumns
                                            )
                                        );
                                        ?>
                               </div>
                            </div> 
                            <div class="tab-pane" id="tab_2">
                             <div class="row">
                                  <?php
                                        $gridColumns = array(  
                                                array('header' => 'SN.',
                                                    'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                                                ), 
                                                array(
                                               'name'    => 'employeeProfiles.employee_name',
                                               'value'   => $data->employeeProfiles->employee_name,
                                                ), 		
                                                array('name' => 'date_remember',
                                                   'type' => 'raw',
                                                   'value' => function($data){
                                                       echo date("d-m-Y",strtotime($data->date_remember));
                                                   },
                                                   'filter' => false,
                                                ),
                                                array('name' => 'status',
                                                   'type' => 'raw',
                                                   'value' => function($data){
                                                       echo ($data->status == "1") ? '<span class="label label-success">Enable</span>' : '<span class="label label-warning">Disable</span>';
                                                   },
                                                   'filter' => false,
                                                ), 
                                                array(
                                                    'name' => 'user_view_status',
                                                    'type' => 'HTML',
                                                    'value' => function($data){
                                                         echo  ($data->user_view_status == "1") ? '<span class="label label-success">User saw the infos.</span>' : '<span class="label label-warning">User not yet see the alert.</span>';
                                                    }
                                                ), 
                                                array('header' => 'message',
                                                    'type' => 'raw',
                                                    'htmlOptions' => array('style' => 'text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
                                                    'filter' => false,
                                                      //call the method 'gridDataColumn' from the controller
                                                    'value' => array($this, 'gridDataColumn'),
                                                ), 
                                                array('name' => 'created_date',
                                                    'type' => 'raw',
                                                    'value' => function($data) {
                                                        echo date("d-m-Y", strtotime($data->created_date));
                                                    },
                                                    'filter' => false,
                                                ),   
                                                array(
                                                'header' => 'Actes',
                                                'class' => 'booster.widgets.TbButtonColumn',
                                                'htmlOptions' => array('style' => 'text-align:center;width:10%', 'vAlign' => 'middle', 'class' => 'action_column'),
                                                'template' => '{delete}',
                                                'buttons'=>array
                                                    (
                                                        'delete' => array
                                                        (
                                                            'label'=>'Delete',                                            
                                                             'url'=>'Yii::app()->createUrl("admin/clientMessages/delete", array("id"=>$data->message_id))',
                                                        ),                                   
                                                    ),
                                                )
                                        );

                                        $this->widget('booster.widgets.TbExtendedGridView', array(
                                                'type' => 'striped bordered datatable',
                                                'enableSorting' => false,
                                                'dataProvider' => $cexpiremodel,
                                                'responsiveTable' => true,
                                                'template' => '  <div id="histrydisp" tabindex="-1" class="col-md-7"><div class="box"> <div class="box-body">{items}</div> <div class="box-footer clearfix">{pager}</div> </div></div>',
                                                'columns' => $gridColumns
                                            )
                                        );
                                        ?>
                               </div>
                            </div>    
                        </div>  
                 </div>   
                <?php 
                }?>
                
                </div>   
            </div>

        </div><!-- /.box-body -->
        
        
        <div class="box-footer">
            <div class="form-group">
                <div class="col-sm-0 col-sm-offset-2">
                    <?php echo CHtml::submitButton($model->isNewRecord ? 'créer' : 'modifier', array('class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','name' => $model->isNewRecord ? 'create-profile' : 'modified-profile')); ?>
                    <?php if (!$model->isNewRecord) {echo CHtml::submitButton('Mise à jour des alertes', array('class' => 'btn btn-success','name'=>'client_alerts')); }?>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>


<div class="modal fade" id="client-message-update-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"> Update Alerts </h4>
                <div id="client_message_contents"></div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="products-disp-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-folder-open-o"></i> Message</h4>
                <div id="product_contents"></div>
            </div>
            
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
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
            data: dataString,
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