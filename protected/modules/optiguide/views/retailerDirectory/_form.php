<?php
/* @var $this ProfessionalDirectoryController */
/* @var $model ProfessionalDirectory */
/* @var $form CActiveForm */
?>

<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 subscribe-btncont"> 
        <div class="inner-container"> 
            <h2><?php echo $model->isNewRecord ? Myclass::t('OG110') : Myclass::t('OG034', '', 'og'); ?></h2>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'retailer-directory-form',
                'htmlOptions' => array('role' => 'form', 'enctype' => 'multipart/form-data'),
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
            $regions = Myclass::getallregions($model->country);
            $cities = Myclass::getallcities($model->region);
            ?>

            <p><b><?php echo $model->isNewRecord ? Myclass::t('OG111') : ''; ?></b></p>

            <div class="forms-cont"> 
                <div class="forms-heading"><i class="fa fa-building"></i>   <?php echo Myclass::t('OG112'); ?> </div>
                <div class="row"> 

                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php echo $form->labelEx($umodel, 'USR'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">                           
                            <?php if ($model->isNewRecord) {
                                ?> 
                                <?php echo $form->textField($umodel, 'USR', array('class' => 'form-txtfield')); ?>
                                <?php echo $form->error($umodel, 'USR'); ?>
                                <?php echo $form->error($model, 'ID_CLIENT'); ?>
                                <?php
                            } else {
                                echo $umodel->USR;
                            }
                            ?>
                        </div>
                    </div>
                    <?php if ($model->isNewRecord) {
                        ?>
                        <div class="form-row1"> 
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                                <?php echo $form->labelEx($umodel, 'PWD'); ?>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                                <?php echo $form->passwordField($umodel, 'PWD', array('class' => 'form-txtfield')); ?>
                                <?php echo $form->error($umodel, 'PWD'); ?>
                            </div>
                        </div>
                    <?php }
                    ?>
                    <div class="form-row1">                        
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php echo $form->labelEx($model, 'COMPAGNIE'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                            <?php echo $form->textField($model, 'COMPAGNIE', array('class' => 'form-txtfield')); ?>
                            <?php echo $form->error($model, 'COMPAGNIE'); ?>
                        </div>
                    </div>


                    <div class="form-row1">                        
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php echo $form->labelEx($model, 'ID_RETAILER_TYPE'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">                 
                            <?php echo $form->dropDownList($model, 'ID_RETAILER_TYPE', $retailertypes, array('class' => 'selectpicker', 'empty' => Myclass::t('OG118'))); ?>                          
                            <?php echo $form->error($model, 'ID_RETAILER_TYPE'); ?>
                        </div>
                    </div>

                    <div class="form-row1">                        
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php echo $form->labelEx($model, 'ID_GROUPE'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">                 
                            <?php echo $form->dropDownList($model, 'ID_GROUPE', $groupetypes, array('class' => 'selectpicker', 'empty' => Myclass::t('OG119'))); ?>                          
                            <?php echo $form->error($model, 'ID_GROUPE'); ?>
                        </div>
                    </div>

                    <div class="form-row1">                        
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php echo $form->labelEx($model, 'HEAD_OFFICE_NAME'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                            <?php echo $form->textField($model, 'HEAD_OFFICE_NAME', array('class' => 'form-txtfield')); ?>
                            <?php echo $form->error($model, 'HEAD_OFFICE_NAME'); ?>
                        </div>
                    </div>

                    <div class="form-row1">                        
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4"> 
                            <?php echo Myclass::t('OG104'); ?> 
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">                   
                            <div class="row">  
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">  
                                    <?php echo $form->checkBox($model, 'CATEGORY_1', array('value' => 1, 'uncheckValue' => 0)); ?>   
                                    <?php echo $form->labelEx($model, 'CATEGORY_1'); ?>
                                    <br/> 
                                    <?php echo $form->checkBox($model, 'CATEGORY_2', array('value' => 1, 'uncheckValue' => 0)); ?>   
                                    <?php echo $form->labelEx($model, 'CATEGORY_2'); ?>
                                    <br/> 
                                    <?php echo $form->checkBox($model, 'CATEGORY_3', array('value' => 1, 'uncheckValue' => 0)); ?>   
                                    <?php echo $form->labelEx($model, 'CATEGORY_3'); ?>
                                    <br/>                                   
                                    <?php echo $form->checkBox($model, 'CATEGORY_4', array('value' => 1, 'uncheckValue' => 0)); ?>   
                                    <?php echo $form->labelEx($model, 'CATEGORY_4'); ?>
                                    <br/> 
                                    <?php echo $form->checkBox($model, 'CATEGORY_5', array('value' => 1, 'uncheckValue' => 0)); ?>   
                                    <?php echo $form->labelEx($model, 'CATEGORY_5'); ?>
                                    <br/> 
                                </div>         
                            </div>  
                            <?php echo $form->error($model, 'CATEGORY_5'); ?>
                        </div>
                    </div>
                </div>


                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php echo $form->labelEx($model, 'ADRESSE'); ?>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                        <?php echo $form->textField($model, 'ADRESSE', array('class' => 'form-txtfield')); ?>
                        <?php echo $form->error($model, 'ADRESSE'); ?>
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
                        <?php echo $form->labelEx($model, 'ID_VILLE'); ?>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                        <?php echo $form->dropDownList($model, 'ID_VILLE', $cities, array('class' => 'selectpicker', 'empty' => Myclass::t('APP59'))); ?> 
                        <?php echo $form->error($model, 'ID_VILLE'); ?>
                    </div>
                </div>

                <div class="form-row1" id="other_city" style="display:none;"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                        <?php echo $form->labelEx($model, 'autre_ville'); ?>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                        <?php echo $form->textField($model, 'autre_ville', array('class' => 'form-txtfield')); ?>      
                        <?php echo $form->error($model, 'autre_ville'); ?>
                    </div>
                </div>

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php echo $form->labelEx($model, 'CODE_POSTAL'); ?>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                        <?php echo $form->textField($model, 'CODE_POSTAL', array('class' => 'form-txtfield')); ?>
                        <?php echo $form->error($model, 'CODE_POSTAL'); ?>
                    </div>
                </div>

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">&nbsp;  </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                        <a class="mapgenrate" href="javascript:void(0);" id="genratemap">Click to View your location</a>
                        <div id="display_map" style="display:none;width:450px;height:350px; "></div> 
                        <?php echo $form->hiddenField($model, 'map_lat', array('id' => 'latid')); ?>
                        <?php echo $form->hiddenField($model, 'map_long', array('id' => 'longid')); ?>                           
                    </div>
                </div>

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php echo $form->labelEx($model, 'TELEPHONE'); ?>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                        <?php echo $form->textField($model, 'TELEPHONE', array('class' => 'form-txtfield')); ?>
                        <?php echo $form->error($model, 'TELEPHONE'); ?>
                    </div>
                </div>

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php echo $form->labelEx($model, 'TELEPHONE2'); ?>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                        <?php echo $form->textField($model, 'TELEPHONE2', array('class' => 'form-txtfield')); ?>
                        <?php echo $form->error($model, 'TELEPHONE2'); ?>
                    </div>
                </div>

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php echo $form->labelEx($model, 'TELECOPIEUR'); ?>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                        <?php echo $form->textField($model, 'TELECOPIEUR', array('class' => 'form-txtfield')); ?>
                        <?php echo $form->error($model, 'TELECOPIEUR'); ?>
                    </div>
                </div>

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php echo $form->labelEx($model, 'URL'); ?>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                        <?php echo $form->textField($model, 'URL', array('class' => 'form-txtfield')); ?>(http://www.monsite.com )
                        <?php echo $form->error($model, 'URL'); ?>
                    </div>
                </div>

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php echo $form->labelEx($model, 'COURRIEL'); ?>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                        <?php echo $form->textField($model, 'COURRIEL', array('class' => 'form-txtfield')); ?>
                        <?php echo $form->error($model, 'COURRIEL'); ?>
                    </div>
                </div> 

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php echo $form->labelEx($model, 'established', array()); ?>   
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">        
                        <?php echo $form->textField($model, 'established', array('class' => 'form-control', 'size' => 4, 'maxlength' => 4)); ?>
                        <?php echo $form->error($model, 'established'); ?>  
                    </div>      
                </div>

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php echo $form->labelEx($model, 'no_of_employee', array()); ?>     
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">        
                        <?php echo $form->textField($model, 'no_of_employee', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'no_of_employee'); ?>  
                    </div>     
                </div>

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php echo $form->labelEx($model, 'services_offered', array()); ?>     
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">        
                        <?php echo $form->textField($model, 'services_offered', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'services_offered'); ?>  
                    </div>     
                </div>

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php echo $form->labelEx($model, 'description', array()); ?>     
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">        
                        <?php echo $form->textField($model, 'description', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'description'); ?>  
                    </div>     
                </div>

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php echo $form->labelEx($model, 'turnover', array()); ?>     
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">        
                        <?php echo $form->textField($model, 'turnover', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'turnover'); ?>  
                    </div>     
                </div>

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php echo $form->labelEx($model, 'image', array()); ?>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">     
                        <?php echo $form->fileField($model, 'image'); ?>                         
                        <?php echo $form->error($model, 'image'); ?>
                    </div>
                </div>
                <?php
                if ($model->FICHIER != '') {
                    $img_url = Yii::app()->getBaseUrl(true) . '/uploads/retailer_logos/' . $model->FICHIER;
                    ?>   
                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> &nbsp;</div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">     
                            <img src="<?php echo $img_url; ?>" width="100" height="100">
                        </div>
                    </div>
                <?php }
                ?>
                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php
                        $classificationtypes['Upscale'] = "Upscale (high priced)";
                        $classificationtypes['Midscale'] = "Midscale (medium priced)";
                        $classificationtypes['DownRange'] = "Down range (low priced)";
                        echo $form->labelEx($model, 'classification', array());
                        ?>     
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">        
                        <?php echo $form->dropDownList($model, 'classification', $classificationtypes, array('class' => 'selectpicker')); ?>    
                        <?php echo $form->error($model, 'classification'); ?>  
                    </div>     
                </div>

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php
                        $language['EN'] = "English";
                        $language['FR'] = "French";
                        echo $form->labelEx($model, 'language', array());
                        ?>     
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">        
                        <?php echo $form->dropDownList($model, 'language', $language, array('class' => 'selectpicker')); ?>    
                        <?php echo $form->error($model, 'language'); ?>  
                    </div>     
                </div>

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php echo $form->labelEx($model, 'contact_person', array()); ?>     
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">        
                        <?php echo $form->textField($model, 'contact_person', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'contact_person'); ?>  
                    </div>     
                </div>

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php echo $form->labelEx($model, 'facebooklink', array()); ?>     
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">        
                        <?php echo $form->textField($model, 'facebooklink', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'facebooklink'); ?>  
                    </div>     
                </div>

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php echo $form->labelEx($model, 'twitterlink', array()); ?>     
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">        
                        <?php echo $form->textField($model, 'twitterlink', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'twitterlink'); ?>  
                    </div>     
                </div>

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php echo $form->labelEx($model, 'linkedinlink', array()); ?>     
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">        
                        <?php echo $form->textField($model, 'linkedinlink', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'linkedinlink'); ?>  
                    </div>     
                </div>

            </div>

            <div class="forms-cont"> 
                <div class="forms-heading"><i class="fa fa-user"></i>  <?php echo Myclass::t('OG113'); ?></div>
                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php echo $form->labelEx($umodel, 'COURRIEL'); ?>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                        <?php echo $form->textField($umodel, 'COURRIEL', array('class' => 'form-txtfield')); ?>
                        <?php echo $form->error($umodel, 'COURRIEL'); ?>
                    </div>
                </div> 

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-8"> <label> <?php echo Myclass::t('OG114'); ?></label></div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php echo $form->radioButtonList($umodel, 'bSubscription_envision', array('0' => 'No', '1' => 'Yes'), array('separator' => '&nbsp;&nbsp;&nbsp;')); ?>
                    </div>
                </div>

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-8"> <label><?php echo Myclass::t('OG115'); ?> </label>  </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php echo $form->radioButtonList($umodel, 'bSubscription_envue', array('0' => 'No', '1' => 'Yes'), array('separator' => '&nbsp;&nbsp;&nbsp;')); ?>
                    </div>
                </div>

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-8"> <label><?php echo Myclass::t('OG165'); ?>  </label>  </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php echo $form->radioButtonList($umodel, 'print_envision', array('0' => 'No', '1' => 'Yes'), array('separator' => '&nbsp;&nbsp;&nbsp;')); ?>
                    </div>
                </div>

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-8"> <label><?php echo Myclass::t('OG166'); ?>  </label>  </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php echo $form->radioButtonList($umodel, 'print_envue', array('0' => 'No', '1' => 'Yes'), array('separator' => '&nbsp;&nbsp;&nbsp;')); ?>
                    </div>
                </div>

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-8"> <label><?php echo Myclass::t('OG116'); ?>  </label>  </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php echo $form->radioButtonList($umodel, 'ABONNE_MAILING', array('0' => 'No', '1' => 'Yes'), array('separator' => '&nbsp;&nbsp;&nbsp;')); ?>
                    </div>
                </div>

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-8"> <label><?php echo Myclass::t('OG117'); ?>  </label>  </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                        <?php echo $form->radioButtonList($umodel, 'ABONNE_PROMOTION', array('0' => 'No', '1' => 'Yes'), array('separator' => '&nbsp;&nbsp;&nbsp;')); ?>
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
            <?php $this->endWidget(); ?>
        </div>
    </div>


</div>
<?php
$ajaxRegionUrl = Yii::app()->createUrl('/optiguide/retailerDirectory/getregions');
$ajaxCityUrl = Yii::app()->createUrl('/optiguide/retailerDirectory/getcities');
$ajaxGroupUrl = Yii::app()->createUrl('/optiguide/retailerDirectory/getgroups');


$ajaxgetlocation = Yii::app()->createUrl('/optiguide/retailerDirectory/generatelatlong');
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;
$cs->registerScriptFile("http://maps.google.com/maps/api/js?sensor=false");

$lat = $model->map_lat;
$long = $model->map_long;

$ctyval = isset($model->ID_VILLE) ? $model->ID_VILLE : '';

$js = <<< EOD
    $(document).ready(function(){
        
      var latval  = parseFloat("{$lat}") || 0;
      var longval = parseFloat("{$long}") || 0;
              
     function initialize() {
      
        // Define the latitude and longitude positions
        var latitude = parseFloat(latval); // Latitude get from above variable
        var longitude = parseFloat(longval); // Longitude from same
        var latlngPos = new google.maps.LatLng(latitude, longitude);

        // Set up options for the Google map
        var mapOptions = {
            zoom: 15,
            center: latlngPos,
            zoomControlOptions: true,
            zoomControlOptions: {
                style: google.maps.ZoomControlStyle.LARGE
            }
        };
        // Define the map
        $("#display_map").show();
        map = new google.maps.Map(document.getElementById("display_map"), mapOptions);

        var marker = new google.maps.Marker({
                  position: latlngPos,
                  map: map,
                  icon:'{$this->themeUrl}/images/map-red.png',
                  draggable:false,
                  animation: google.maps.Animation.DROP
          });
    }   
    
    if(latval!=0 && longval!=0)
    {    
        google.maps.event.addDomListener(window, 'load', initialize);    
    }    
    
     $('#genratemap').click(function(){
        var form = $('#retailer-directory-form');
        $.ajax({
            type: "POST",
            url: '{$ajaxgetlocation}',
            data: form.serialize(),
            success: function( response ) {
            
                if(response!='')
                {
                    var res = response.split("~");                   

                    // Define the latitude and longitude positions
                    var latitude  = parseFloat(res[0]);
                    var longitude = parseFloat(res[1]);
                    var latlngPos = new google.maps.LatLng(latitude, longitude);
            
                    $('#latid').val(latitude);
                    $('#longid').val(longitude);

                    // Set up options for the Google map
                    var mapOptions = {
                        zoom: 15,
                        center: latlngPos,
                        zoomControlOptions: true,
                        zoomControlOptions: {
                            style: google.maps.ZoomControlStyle.LARGE
                        }
                    };

                    // Define the map and show
                    $("#display_map").show();
                    map = new google.maps.Map(document.getElementById("display_map"), mapOptions);

                    var marker = new google.maps.Marker({
                              position: latlngPos,
                              map: map,
                              icon:'{$this->themeUrl}/images/map-red.png',
                              draggable:false,
                              animation: google.maps.Animation.DROP
                      });
                }        
            }
       });
     });       
        
    $("#RetailerDirectory_country").change(function(){
        var id=$(this).val();
        var dataString = 'id='+ id;
            
        $.ajax({
            type: "POST",
            url: '{$ajaxRegionUrl}',
            data: dataString,
            cache: false,
            success: function(html){             
                $("#RetailerDirectory_region").html(html).selectpicker('refresh');
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
                $("#RetailerDirectory_ID_VILLE").html(html).selectpicker('refresh');
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
                $("#RetailerDirectory_ID_GROUPE").html(html).selectpicker('refresh');
            }
         });
    });
        
    var ctyval = "{$ctyval}";
    if(ctyval=="-1")
    {    
        $("#other_city").show();
    }     
            
   $("#RetailerDirectory_ID_VILLE").change(function(){
        var id=$(this).val();
            
        $("#other_city").hide();
        if(id=="-1")
        {    
            $("#other_city").show();
        }    
    });
            
});
EOD;
Yii::app()->clientScript->registerScript('_form_retailer', $js);
?>