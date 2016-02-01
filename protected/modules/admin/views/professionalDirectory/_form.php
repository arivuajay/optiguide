<?php
/* @var $this ProfessionalDirectoryController */
/* @var $model ProfessionalDirectory */
/* @var $form CActiveForm */

?>

<div class="row">
    <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'professional-directory-form',
                'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data'),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'enableAjaxValidation' => true,
            ));

            $proftypes = CHtml::listData(ProfessionalType::model()->findAll(), 'ID_TYPE_SPECIALISTE', 'TYPE_SPECIALISTE_FR');
            $country = Myclass::getallcountries();
            $regions = Myclass::getallregions_client($model->country,2);
            $cities = Myclass::getallcities($model->region);
            ?>

            <div class="box-body">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'ID_TYPE_SPECIALISTE', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">                       
                        <?php echo $form->dropDownList($model, 'ID_TYPE_SPECIALISTE', $proftypes, array('class' => 'form-control')); ?>                          
                        <?php echo $form->error($model, 'ID_TYPE_SPECIALISTE'); ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'PREFIXE_FR', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'PREFIXE_FR', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'PREFIXE_FR'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'PREFIXE_EN', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'PREFIXE_EN', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'PREFIXE_EN'); ?>
                    </div>
                </div>
                
                <?php
                if (!$model->isNewRecord) {
                ?>    
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'ID_CLIENT', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $model->ID_CLIENT; ?>                       
                       
                    </div>
                </div>
                <?php
                }
                ?>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'PRENOM', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'PRENOM', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'PRENOM'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'NOM', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'NOM', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'NOM'); ?>
                    </div>
                </div>

                <div class="form-group">                        
                    <?php echo $form->labelEx($model, 'age', array('class' => 'col-sm-2 control-label')); ?>                       
                    <div class="col-sm-5"> 
                        <?php echo $form->textField($model, 'age', array('class' => 'form-control', 'size' => 2,)); ?>
                        <?php echo $form->error($model, 'age'); ?>
                    </div>
                </div>

                <div class="form-group">                     
                    <?php echo $form->labelEx($model, 'sex', array('class' => 'col-sm-2 control-label')); ?>     
                    <div class="col-sm-5"> 
                        <?php echo $form->radioButtonList($model, 'sex', array('male' => Myclass::t('OG147'), 'female' => Myclass::t('OG148')), array('separator' => '&nbsp;&nbsp;&nbsp;')); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'BUREAU', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'BUREAU', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'BUREAU'); ?>
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
                    <?php echo $form->labelEx($model, 'SITE_WEB', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'SITE_WEB', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>(http://www.monsite.com )
                        <?php echo $form->error($model, 'SITE_WEB'); ?>
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
                            echo CHtml::link('( <i class="fa fa-remove"></i> )', array('/admin/professionalDirectory/deleteProof', 'id' => $model->ID_SPECIALISTE, 'file_name' => $model->proof_file), array('confirm' => 'Are you sure?'));
                            ?>
                        </div> 
                    </div>
                <?php }
                ?>
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
                if (!$pmodel->status) {
                    $pmodel->status = 0;
                }
                $employees = CHtml::listData(EmployeeProfiles::model()->findall(array("order" => "employee_name asc")), 'employee_id', 'employee_name');
                ?>

                <div class="form-group">
                    <?php echo $form->labelEx($pmodel, 'employee_id', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->dropDownList($pmodel, 'employee_id', $employees, array('class' => 'form-control')); ?> 
                        <?php echo $form->error($pmodel, 'employee_id'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($pmodel, 'date_remember', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($pmodel, 'date_remember', array('class' => 'form-control date')); ?>
                        <?php echo $form->error($pmodel, 'date_remember'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($pmodel, 'message', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textArea($pmodel, 'message', array('class' => 'form-control', 'rows' => 6, 'cols' => 50)); ?>
                        <?php echo $form->error($pmodel, 'message'); ?>
                    </div>
                </div>

                <div class="form-group"> 
                    <?php echo $form->labelEx($pmodel, 'afile', array('class' => 'col-sm-2 control-label')); ?>                   
                    <div class="col-sm-5">     
                        <?php echo $form->fileField($pmodel, 'afile'); ?>                         
                        <?php echo $form->error($pmodel, 'afile'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($pmodel, 'status', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->radioButtonList($pmodel, 'status', array('1' => 'Oui', '0' => 'Non'), array('separator' => ' ')); ?> 
                        <?php echo $form->error($pmodel, 'status'); ?>
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
                                            'class' => 'ButtonColumn',
                                            'htmlOptions' => array('style' => 'text-align:center;width:30%', 'vAlign' => 'middle', 'class' => 'action_column'),
                                            'template' => '{download}&nbsp;&nbsp;{update}&nbsp;&nbsp;{delete}',
                                            'evaluateID' => true,
                                            'buttons' => array
                                                (
                                                
                                                'download' => array(
                                                   'label' => "<i class='fa fa-download'></i>",                         
                                                   'url' => '(file_exists(YiiBase::getPathOfAlias("webroot")."/uploads/alerts_attachments/".$data->alertfile)) ? Yii::app()->createAbsoluteUrl("/uploads/alerts_attachments/".$data->alertfile) : ""',                            
                                                   'options' => array('class' => 'newWindow','title' => "Attachment" ,"target" => "_blank"),
                                                   'visible' => '($data->alertfile!="")'
                                                    ), 
                                                'delete' => array(
                                                        'label' => 'Delete',
                                                        'url' => 'Yii::app()->createUrl("admin/professionalDirectory/deleteMessage", array("id"=>$data->message_id))',
                                                    ),
                                               'update' => array(
                                                        'label' => 'Update',
                                                        'url' => '"javascript:void(0)"',
                                                        'options' => array(
                                                            "id" => '\'messageid_\'.$data->message_id',
                                                            'data-target' => '#prof-message-update-modal',
                                                            'data-toggle' => 'modal',
                                                            'class' => 'prof_message_update_popup',
                                                            ),
                                                )
                                            ),
                                        )
                                    );

                                    $this->widget('booster.widgets.TbExtendedGridView', array(
                                        'type' => 'striped bordered datatable',
                                        'enableSorting' => false,
                                        'dataProvider' => $pcurrentmodel,
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
                                            'template' => '{download}&nbsp;&nbsp;{delete}',
                                            'buttons' => array
                                                (
                                                  'download' => array(
                                                   'label' => "<i class='fa fa-download'></i>",                         
                                                   'url' => '(file_exists(YiiBase::getPathOfAlias("webroot")."/uploads/alerts_attachments/".$data->alertfile)) ? Yii::app()->createAbsoluteUrl("/uploads/alerts_attachments/".$data->alertfile) : ""',                            
                                                   'options' => array('class' => 'newWindow','title' => "Attachment" ,"target" => "_blank"),
                                                   'visible' => '($data->alertfile!="")'
                                                    ), 
                                                    'delete' => array(
                                                        'label' => 'Delete',
                                                        'url' => 'Yii::app()->createUrl("admin/professionalDirectory/deleteMessage", array("id"=>$data->message_id))',
                                                    ),
                                                
                                            ),
                                        )
                                    );

                                    $this->widget('booster.widgets.TbExtendedGridView', array(
                                        'type' => 'striped bordered datatable',
                                        'enableSorting' => false,
                                        'dataProvider' => $pexpiremodel,
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

                <!--                <div class="form-group">
                <?php //echo $form->labelEx($umodel, 'MUST_VALIDATE', array('class' => 'col-sm-2 control-label')); ?>       
                                    <div class="col-sm-5">
                <?php //echo $form->radioButtonList($umodel, 'MUST_VALIDATE', array('1' => 'Oui', '0' => 'Non'), array('separator' => ' '));  ?> 
                                    </div>
                                </div>-->

                <?php // echo $form->hiddenField($umodel,'bSubscription_envision'); ?>
                <?php // echo $form->hiddenField($umodel,'bSubscription_envue'); ?>
                <?php // echo $form->hiddenField($umodel,'ABONNE_MAILING'); ?>
                <?php // echo $form->hiddenField($umodel,'ABONNE_PROMOTION');?>


            </div><!-- /.box-body -->
            <div class="box-footer">
                <div class="form-group">
                    <div class="col-sm-0 col-sm-offset-2">
                        <?php echo CHtml::submitButton($model->isNewRecord ? 'Ajouter ce professionnel' : 'Modifier ce professionnel', array('class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','name' => $model->isNewRecord ? 'create-professional' : 'modified-professional')); ?>                       
                        <?php if (!$model->isNewRecord) {echo CHtml::submitButton('Mise à jour des alertes', array('class' => 'btn btn-success','name'=>'update-professional-alerts')); }?>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div><!-- ./col -->
</div>

<div class="modal fade" id="prof-message-update-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"> Update Alerts </h4>
                <div id="prof_message_contents"></div>
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
$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerCssFile($themeUrl . '/css/datepicker/datepicker3.css');
$cs->registerScriptFile($themeUrl . '/js/datepicker/bootstrap-datepicker.js', $cs_pos_end);

$cs->registerScriptFile($themeUrl . '/js/datatables/jquery.dataTables.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/datatables/dataTables.bootstrap.js', $cs_pos_end);
                
$alerthistory = Yii::app()->request->getQuery('alerthistory', '0');
$ajaxRegionUrl = Yii::app()->createUrl('/admin/professionalDirectory/getregions');
$ajaxCityUrl = Yii::app()->createUrl('/admin/professionalDirectory/getcities');
$ajax_getmessage = Yii::app()->createUrl('/admin/professionalDirectory/getmessage');

$ajax_get_prof_mess_update = Yii::app()->createUrl('/admin/professionalDirectory/updateMessage');
$js = <<< EOD
    $(document).ready(function(){
        
    if({$alerthistory}=='1')
    {
        $('#histrydisp').css('outline', 0).focus();
    } 
        
    $("#ProfessionalDirectory_country").change(function(){
        var id=$(this).val();
        var dataString = 'id='+ id;
            
        $.ajax({
            type: "POST",
            url: '{$ajaxRegionUrl}',
            data: dataString+'&client_disp=2',
            cache: false,
            success: function(html){             
                $("#ProfessionalDirectory_region").html(html);
            }
         });
    });
   
   $("#ProfessionalDirectory_region").change(function(){
        var id=$(this).val();
        var dataString = 'id='+ id;
            
        $.ajax({
            type: "POST",
            url: '{$ajaxCityUrl}',
            data: dataString,
            cache: false,
            success: function(html){             
                $("#ProfessionalDirectory_ID_VILLE").html(html);
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
        
    $('.prof_message_update_popup').live('click',function(event){
        event.preventDefault();
        var professional_message_id = $(this).attr("id");
        var dataString = 'message_id='+professional_message_id;

        $.ajax({
            type: "GET",
            url: '{$ajax_get_prof_mess_update}',
            data: dataString,
            cache: false,
            success: function(html){             
                $("#prof_message_contents").html(html);               
            }
         });
    });
            
});
EOD;
Yii::app()->clientScript->registerScript('_form', $js);
?>