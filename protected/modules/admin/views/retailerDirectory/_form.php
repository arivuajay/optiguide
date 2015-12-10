<?php
/* @var $this RetailerDirectoryController */
/* @var $model RetailerDirectory */
/* @var $form CActiveForm */
?>

<div class="row">
    <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'retailer-directory-form',
                'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data'),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'enableAjaxValidation' => true,
            ));

            $retailertypes = CHtml::listData(RetailerType::model()->findAll(), 'ID_RETAILER_TYPE', 'NOM_TYPE_FR');
            $groupetypes = array();
            if ($model->ID_RETAILER_TYPE) {
                $groupetypes = CHtml::listData(RetailerGroup::model()->findAll("ID_RETAILER_TYPE=" . $model->ID_RETAILER_TYPE), 'ID_GROUPE', 'NOM_GROUPE');
            }
            $country = Myclass::getallcountries();
            $regions = Myclass::getallregions(@$model->country);
            $cities = Myclass::getallcities(@$model->region);
            ?>
            <div class="box-body">

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'ID_RETAILER_TYPE', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">                       
                        <?php echo $form->dropDownList($model, 'ID_RETAILER_TYPE', $retailertypes, array('class' => 'form-control', 'empty' => 'Choisir le type')); ?>                          
                        <?php echo $form->error($model, 'ID_RETAILER_TYPE'); ?>
                    </div>
                </div>

                <div class="form-group">                  

                    <?php echo $form->labelEx($model, 'ID_GROUPE', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">                       
                        <?php echo $form->dropDownList($model, 'ID_GROUPE', $groupetypes, array('class' => 'form-control', 'empty' => 'Sélectionnez le groupe')); ?>                          
                        <?php echo $form->error($model, 'ID_GROUPE'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'COMPAGNIE', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'COMPAGNIE', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'COMPAGNIE'); ?>
                    </div>
                </div>


                <div class="form-group">
                    <?php echo $form->labelEx($model, 'Categories', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">                     
                        <div class="checkbox">
                            <label>
                                <?php echo $form->checkBox($model, 'CATEGORY_1', array('value' => 1, 'uncheckValue' => 0)); ?>   
                                <?php echo $form->labelEx($model, 'CATEGORY_1'); ?>
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <?php echo $form->checkBox($model, 'CATEGORY_2', array('value' => 1, 'uncheckValue' => 0)); ?>   
                                <?php echo $form->labelEx($model, 'CATEGORY_2'); ?>
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <?php echo $form->checkBox($model, 'CATEGORY_3', array('value' => 1, 'uncheckValue' => 0)); ?>   
                                <?php echo $form->labelEx($model, 'CATEGORY_3'); ?>
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <?php echo $form->checkBox($model, 'CATEGORY_4', array('value' => 1, 'uncheckValue' => 0)); ?>   
                                <?php echo $form->labelEx($model, 'CATEGORY_4'); ?>
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <?php echo $form->checkBox($model, 'CATEGORY_5', array('value' => 1, 'uncheckValue' => 0)); ?>   
                                <?php echo $form->labelEx($model, 'CATEGORY_5'); ?>
                            </label>
                        </div>
                        <?php echo $form->error($model, 'CATEGORY_5'); ?>
                    </div>

                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'HEAD_OFFICE_NAME', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'HEAD_OFFICE_NAME', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'HEAD_OFFICE_NAME'); ?>
                    </div>
                </div>

<!--                <div class="form-group">
                    <?php //echo $form->labelEx($model, 'ID_CLIENT', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">                             
                        <?php //echo $form->textField($model, 'ID_CLIENT', array('class' => 'form-control', 'size' => 10, 'maxlength' => 10)); ?>
                        <?php //echo $form->error($umodel, 'USR'); ?>
                        <?php //echo $form->error($model, 'ID_CLIENT'); ?>
                    </div>
                </div>-->

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
                    <?php echo $form->labelEx($model, 'ID_VILLE', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">                       
                        <?php echo $form->dropDownList($model, 'ID_VILLE', $cities, array('class' => 'form-control', 'empty' => Myclass::t('APP59'))); ?>   
                        <?php echo $form->error($model, 'ID_VILLE'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'ADRESSE', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'ADRESSE', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'ADRESSE'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'ADRESSE2', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'ADRESSE2', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'ADRESSE2'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'CODE_POSTAL', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'CODE_POSTAL', array('class' => 'form-control', 'size' => 20, 'maxlength' => 20)); ?>
                        <?php echo $form->error($model, 'CODE_POSTAL'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'TELEPHONE', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'TELEPHONE', array('class' => 'form-control', 'size' => 20, 'maxlength' => 20)); ?>
                        <?php echo $form->error($model, 'TELEPHONE'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'TELEPHONE2', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'TELEPHONE2', array('class' => 'form-control', 'size' => 20, 'maxlength' => 20)); ?>
                        <?php echo $form->error($model, 'TELEPHONE2'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'TELECOPIEUR', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'TELECOPIEUR', array('class' => 'form-control', 'size' => 20, 'maxlength' => 20)); ?>
                        <?php echo $form->error($model, 'TELECOPIEUR'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'TEL_1800', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'TEL_1800', array('class' => 'form-control', 'size' => 20, 'maxlength' => 20)); ?>
                        <?php echo $form->error($model, 'TEL_1800'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'URL', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'URL', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>(http://www.monsite.com )
                        <?php echo $form->error($model, 'URL'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'COURRIEL', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'COURRIEL', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'COURRIEL'); ?>
                    </div>
                </div>

                <div class="form-group"> 
                    <?php echo $form->labelEx($model, 'established', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">        
                        <?php echo $form->textField($model, 'established', array('class' => 'form-control', 'size' => 4, 'maxlength' => 4)); ?>
                        <?php echo $form->error($model, 'established'); ?>  
                    </div>      
                </div>

                <div class="form-group">                   
                    <?php echo $form->labelEx($model, 'no_of_employee', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">        
                        <?php echo $form->textField($model, 'no_of_employee', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'no_of_employee'); ?>  
                    </div>     
                </div>

                <div class="form-group">                     
                    <?php echo $form->labelEx($model, 'services_offered', array('class' => 'col-sm-2 control-label')); ?>                         
                    <div class="col-sm-5">        
                        <?php echo $form->textField($model, 'services_offered', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'services_offered'); ?>  
                    </div>     
                </div>

                <div class="form-group">                     
                    <?php echo $form->labelEx($model, 'description', array('class' => 'col-sm-2 control-label')); ?>                         
                    <div class="col-sm-5">        
                        <?php echo $form->textField($model, 'description', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'description'); ?>  
                    </div>     
                </div>

                <div class="form-group">                     
                    <?php echo $form->labelEx($model, 'turnover', array('class' => 'col-sm-2 control-label')); ?>    
                    <div class="col-sm-5">        
                        <?php echo $form->textField($model, 'turnover', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'turnover'); ?>  
                    </div>     
                </div>


                <div class="form-group"> 
                    <?php echo $form->labelEx($model, 'image', array('class' => 'col-sm-2 control-label')); ?>                   
                    <div class="col-sm-5">     
                        <?php echo $form->fileField($model, 'image'); ?>                         
                        <?php echo $form->error($model, 'image'); ?>
                    </div>
                </div>
                <?php
                if ($model->FICHIER != '') {
                    $img_url = Yii::app()->getBaseUrl(true) . '/uploads/retailer_logos/' . $model->FICHIER;
                    ?>   
                    <div class="form-group">  
                        <label for="RetailerDirectory_Logo" class="col-sm-2 control-label">&nbsp;</label>
                        <div class="col-sm-5">     
                            <img src="<?php echo $img_url; ?>" width="100" height="100">
                        </div>
                    </div>
                <?php }
                ?>
                <div class="form-group">                  
                    <?php
                    $classificationtypes['Upscale'] = "Upscale (high priced)";
                    $classificationtypes['Midscale'] = "Midscale (medium priced)";
                    $classificationtypes['DownRange'] = "Down range (low priced)";
                    echo $form->labelEx($model, 'classification', array('class' => 'col-sm-2 control-label'));
                    ?>    
                    <div class="col-sm-5">        
                        <?php echo $form->dropDownList($model, 'classification', $classificationtypes, array('class' => 'form-control')); ?>    
                        <?php echo $form->error($model, 'classification'); ?>  
                    </div>     
                </div>
                
                <div class="form-group">                    
                    <?php echo $form->labelEx($model, 'contact_person', array('class' => 'col-sm-2 control-label')); ?>    
                    <div class="col-sm-5">        
                        <?php echo $form->textField($model, 'contact_person', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'contact_person'); ?>  
                    </div>     
                </div>

                <div class="form-group">                    
                    <?php echo $form->labelEx($model, 'facebooklink', array('class' => 'col-sm-2 control-label')); ?>                       
                    <div class="col-sm-5">        
                        <?php echo $form->textField($model, 'facebooklink', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'facebooklink'); ?>  
                    </div>     
                </div>

                <div class="form-group"> 
                    <?php echo $form->labelEx($model, 'twitterlink', array('class' => 'col-sm-2 control-label')); ?> 
                    <div class="col-sm-5">        
                        <?php echo $form->textField($model, 'twitterlink', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'twitterlink'); ?>  
                    </div>     
                </div>

                <div class="form-group">                   
                    <?php echo $form->labelEx($model, 'linkedinlink', array('class' => 'col-sm-2 control-label')); ?>                        
                    <div class="col-sm-5">        
                        <?php echo $form->textField($model, 'linkedinlink', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'linkedinlink'); ?>  
                    </div>     
                </div>

                <div class="form-group"> 
                    <?php echo $form->labelEx($model, 'pfile', array('class' => 'col-sm-2 control-label')); ?>                   
                    <div class="col-sm-5">     
                        <?php echo $form->fileField($model, 'pfile'); ?>                         
                        <?php echo $form->error($model, 'pfile'); ?>
                    </div>
                </div>
                <?php
                if ($model->proof_file != '') {
                    $file_url = Yii::app()->getBaseUrl(true) . '/uploads/user_proofs/' . $model->proof_file;
                    ?>   
                    <div class="form-group"> 
                        <label for="ProfessionalDirectory_prooffile" class="col-sm-2 control-label">&nbsp;</label>
                        <div class="col-sm-5">     
                            <a href="<?php echo $file_url; ?>" target="_blank">Click to view the proof</a>
                            &nbsp;&nbsp;
                            <?php 
                            echo CHtml::link('( <i class="fa fa-remove"></i> )', array('/admin/retailerDirectory/deleteProof', 'id' => $model->ID_RETAILER, 'file_name' => $model->proof_file), array('confirm' => 'Are you sure?'));
                            ?>
                        </div> 
                    </div>
                <?php } ?>
                <?php
                if (!$model->isNewRecord) {
                    ?>
                <div class="form-group"> 
                    <?php echo $form->labelEx($model, 'DATE_MODIFICATION', array('class' => 'col-sm-2 control-label')); ?> 
                    <div class="col-sm-5">        
                        <?php echo $model->DATE_MODIFICATION; ?>
                    </div>     
                </div>
                <div class="form-group"> 
                    <?php echo $form->labelEx($model, 'CREATED_DATE', array('class' => 'col-sm-2 control-label')); ?> 
                    <div class="col-sm-5">        
                        <?php echo $model->CREATED_DATE; ?>
                    </div>     
                </div>
                <div class="box-header">
                    <h3 class="box-title">Réglez l'alerte à l'employé</h3>
                </div>
                <?php
                $themeUrl = $this->themeUrl;
                $cs = Yii::app()->getClientScript();
                $cs_pos_end = CClientScript::POS_END;

                $cs->registerCssFile($themeUrl . '/css/datepicker/datepicker3.css');
                $cs->registerScriptFile($themeUrl . '/js/datepicker/bootstrap-datepicker.js', $cs_pos_end);

                $cs->registerScriptFile($themeUrl . '/js/datatables/jquery.dataTables.js', $cs_pos_end);
                $cs->registerScriptFile($themeUrl . '/js/datatables/dataTables.bootstrap.js', $cs_pos_end);

                if (!$rmodel->status) {
                    $rmodel->status = 0;
                }
                $employees = CHtml::listData(EmployeeProfiles::model()->findall(array("order" => "employee_name asc")), 'employee_id', 'employee_name');
                ?>

                <div class="form-group">
                    <?php echo $form->labelEx($rmodel, 'employee_id', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->dropDownList($rmodel, 'employee_id', $employees, array('class' => 'form-control')); ?> 
                        <?php echo $form->error($rmodel, 'employee_id'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($rmodel, 'date_remember', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($rmodel, 'date_remember', array('class' => 'form-control date')); ?>
                        <?php echo $form->error($rmodel, 'date_remember'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($rmodel, 'message', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textArea($rmodel, 'message', array('class' => 'form-control', 'rows' => 6, 'cols' => 50)); ?>
                        <?php echo $form->error($rmodel, 'message'); ?>
                    </div>
                </div>

                <div class="form-group"> 
                    <?php echo $form->labelEx($rmodel, 'afile', array('class' => 'col-sm-2 control-label')); ?>                   
                    <div class="col-sm-5">     
                        <?php echo $form->fileField($rmodel, 'afile'); ?>                         
                        <?php echo $form->error($rmodel, 'afile'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($rmodel, 'status', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->radioButtonList($rmodel, 'status', array('1' => 'Oui', '0' => 'Non'), array('separator' => ' ')); ?> 
                        <?php echo $form->error($rmodel, 'status'); ?>
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
                                            'name' => 'employeeProfiles.employee_name',
                                            'value' => $data->employeeProfiles->employee_name,
                                        ),
                                        array('name' => 'date_remember',
                                            'type' => 'raw',
                                            'value' => function($data) {
                                                echo date("d-m-Y", strtotime($data->date_remember));
                                            },
                                            'filter' => false,
                                        ),
                                        array('name' => 'status',
                                            'type' => 'raw',
                                            'value' => function($data) {
                                                echo ($data->status == "1") ? '<span class="label label-success">Enable</span>' : '<span class="label label-warning">Disable</span>';
                                            },
                                            'filter' => false,
                                        ),
                                        array(
                                            'name' => 'user_view_status',
                                            'type' => 'HTML',
                                            'value' => function($data) {
                                                echo ($data->user_view_status == "1") ? '<span class="label label-success">User saw the infos.</span>' : '<span class="label label-warning">User not yet see the alert.</span>';
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
                                            // 'class' => 'booster.widgets.TbButtonColumn',
                                            'class' => 'ButtonColumn',
                                            'htmlOptions' => array('style' => 'text-align:center;width:10%', 'vAlign' => 'middle', 'class' => 'action_column'),
                                            'template' => '{update}&nbsp;&nbsp;{delete}',
                                            'evaluateID' => true,
                                            'buttons' => array
                                                (
                                                'delete' => array
                                                    (
                                                    'label' => 'Delete',
                                                    'url' => 'Yii::app()->createUrl("admin/retailerDirectory/deleteMessage", array("id"=>$data->message_id))',
                                                ),
                                                'update' => array(
                                                    'label' => 'Update',
                                                    'url' => '"javascript:void(0)"',
                                                    'options' => array(
                                                        "id" => '\'messageid_\'.$data->message_id',
                                                        'data-target' => '#ret-message-update-modal',
                                                        'data-toggle' => 'modal',
                                                        'class' => 'ret_message_update_popup',
                                                    ),
                                                )
                                            ),
                                        )
                                    );

                                    $this->widget('booster.widgets.TbExtendedGridView', array(
                                        'type' => 'striped bordered datatable',
                                        'enableSorting' => false,
                                        'dataProvider' => $rcurrentmodel,
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
                                            'name' => 'employeeProfiles.employee_name',
                                            'value' => $data->employeeProfiles->employee_name,
                                        ),
                                        array('name' => 'date_remember',
                                            'type' => 'raw',
                                            'value' => function($data) {
                                                echo date("d-m-Y", strtotime($data->date_remember));
                                            },
                                            'filter' => false,
                                        ),
                                        array('name' => 'status',
                                            'type' => 'raw',
                                            'value' => function($data) {
                                                echo ($data->status == "1") ? '<span class="label label-success">Enable</span>' : '<span class="label label-warning">Disable</span>';
                                            },
                                            'filter' => false,
                                        ),
                                        array(
                                            'name' => 'user_view_status',
                                            'type' => 'HTML',
                                            'value' => function($data) {
                                                echo ($data->user_view_status == "1") ? '<span class="label label-success">User saw the infos.</span>' : '<span class="label label-warning">User not yet see the alert.</span>';
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
                                            'buttons' => array
                                                (
                                                'delete' => array
                                                    (
                                                    'label' => 'Delete',
                                                    'url' => 'Yii::app()->createUrl("admin/retailerDirectory/deleteMessage", array("id"=>$data->message_id))',
                                                ),
                                            ),
                                        )
                                    );

                                    $this->widget('booster.widgets.TbExtendedGridView', array(
                                        'type' => 'striped bordered datatable',
                                        'enableSorting' => false,
                                        'dataProvider' => $rexpiremodel,
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
                <?php }
                ?>


                <!--                  <div class="form-group">
                <?php //echo $form->labelEx($umodel, 'MUST_VALIDATE', array('class' => 'col-sm-2 control-label'));   ?>       
                                    <div class="col-sm-5">
                <?php //echo $form->radioButtonList($umodel, 'MUST_VALIDATE', array('1' => 'Oui', '0' => 'Non'), array('separator' => ' '));   ?> 
                                    </div>
                                </div>-->

                <?php //echo $form->hiddenField($umodel,'bSubscription_envision'); ?>
                <?php // echo $form->hiddenField($umodel,'bSubscription_envue');?>
                <?php // echo $form->hiddenField($umodel,'ABONNE_MAILING');?>
                <?php // echo $form->hiddenField($umodel,'ABONNE_PROMOTION'); ?>

            </div><!-- /.box-body -->
            <div class="box-footer">
                <div class="form-group">
                    <div class="col-sm-0 col-sm-offset-2">
                        <?php echo CHtml::submitButton($model->isNewRecord ? 'Ajouter ce détaillant' : 'Modifier ce détaillant', array('class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','name' => $model->isNewRecord ? 'create-retailer' : 'modified-retailer')); ?>                       
                        <?php if (!$model->isNewRecord) {echo CHtml::submitButton('Mise à jour des alertes', array('class' => 'btn btn-success','name'=>'update-alerts')); }?>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div><!-- ./col -->
</div>

<div class="modal fade" id="ret-message-update-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"> Update Alerts </h4>
                <div id="ret_message_contents"></div>
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
$alerthistory = Yii::app()->request->getQuery('alerthistory', '0');
$ajaxRegionUrl = Yii::app()->createUrl('/admin/retailerDirectory/getregions');
$ajaxCityUrl = Yii::app()->createUrl('/admin/retailerDirectory/getcities');
$ajaxGroupUrl = Yii::app()->createUrl('/admin/retailerDirectory/getgroups');
$ajax_getmessage = Yii::app()->createUrl('/admin/retailerDirectory/getmessage');


$ajax_get_ret_mess_update = Yii::app()->createUrl('/admin/retailerDirectory/updateMessage');
$js = <<< EOD
    $(document).ready(function(){
    
    if({$alerthistory}=='1')
    {
        $('#histrydisp').css('outline', 0).focus();
    } 
        
    $("#RetailerDirectory_country").change(function(){
        var id=$(this).val();
        var dataString = 'id='+ id;
            
        $.ajax({
            type: "POST",
            url: '{$ajaxRegionUrl}',
            data: dataString,
            cache: false,
            success: function(html){             
                $("#RetailerDirectory_region").html(html);
            }
         });
    });
   
   $("#RetailerDirectory_region").change(function(){
        var id=$(this).val();
        var dataString = 'id='+ id;
            
        $.ajax({
            type: "POST",
            url: '{$ajaxCityUrl}',
            data: dataString,
            cache: false,
            success: function(html){             
                $("#RetailerDirectory_ID_VILLE").html(html);
            }
         });

    });
            
   $("#RetailerDirectory_ID_RETAILER_TYPE").change(function(){
        var id=$(this).val();
        var dataString = 'id='+ id;
            
        $.ajax({
            type: "POST",
            url: '{$ajaxGroupUrl}',
            data: dataString,
            cache: false,
            success: function(html){             
                $("#RetailerDirectory_ID_GROUPE").html(html);
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
        
    $('.ret_message_update_popup').live('click',function(event){
        event.preventDefault();
        var retailer_message_id = $(this).attr("id");
        var dataString = 'message_id='+retailer_message_id;

        $.ajax({
            type: "GET",
            url: '{$ajax_get_ret_mess_update}',
            data: dataString,
            cache: false,
            success: function(html){             
                $("#ret_message_contents").html(html);               
            }
         });
    });
            
});
EOD;
Yii::app()->clientScript->registerScript('_form', $js);
?>