<div class="col-lg-12 col-md-12">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="glyphicon glyphicon-search"></i>  Search
                </h3>
                <div class="clearfix"></div>
            </div>

            <section class="content">
                <div class="row">
                    <?php
                    $country = Myclass::getallcountries();
                    $regions = Myclass::getallregions($model->ID_PAYS);
                    $cities = Myclass::getallcities_other($model->ID_REGION);

                    $criteria = new CDbCriteria();
                    $criteria->select = 'YEAR(DATE_AJOUT1) as Year';
                    $criteria->group = 'YEAR(DATE_AJOUT1)';
                    $criteria->order = 'Year DESC';
                    $reslt = CalenderEvent::model()->findAll($criteria);
                    foreach ($reslt as $res) {
                        $years[$res->Year] = $res->Year;
                    }

                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'calenderevent-search-form',
                        'method' => 'get',
                        'action' => array('/admin/calenderEvent/index/'),
                        'htmlOptions' => array('role' => 'form')
                    ));
                    ?>
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'keyword', array('class' => ' control-label')); ?>
                            <?php echo $form->textField($model, 'keyword', array('class' => 'form-control', 'size' => 60)); ?>                     
                        </div>
                    </div> 
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'LANGUE', array('class' => ' control-label')); ?>
                            <?php echo $form->dropDownList($model, 'LANGUE', array("FR" => 'Français', "EN" => 'Anglais'), array('class' => 'form-control', 'prompt' => 'Tous')); ?>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'Year', array('class' => ' control-label')); ?>
                            <?php echo $form->dropDownList($model, 'Year', $years, array('class' => 'form-control', 'prompt' => 'Toutes')); ?>                          
                        </div>
                    </div>                  

                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'ID_PAYS', array('class' => 'control-label')); ?>                                           
                            <?php echo $form->dropDownList($model, 'ID_PAYS', $country, array('class' => 'form-control', 'empty' => Myclass::t('APP43'))); ?>   
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'ID_REGION', array('class' => 'control-label')); ?>                                          
                            <?php echo $form->dropDownList($model, 'ID_REGION', $regions, array('class' => 'form-control', 'empty' => Myclass::t('APP44'))); ?>   
                        </div>
                    </div>    
                    <div class="col-lg-4 col-md-4">    
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'ID_VILLE', array('class' => 'control-label')); ?>                                       
                            <?php echo $form->dropDownList($model, 'ID_VILLE', $cities, array('class' => 'form-control', 'empty' => Myclass::t('APP59'))); ?>                           
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <?php echo CHtml::submitButton('Filtrer', array('class' => 'btn btn-primary form-control')); ?>
                        </div>
                    </div>
                    <?php $this->endWidget(); ?>
                </div>
            </section>
            
        </div>
    </div>
</div>
