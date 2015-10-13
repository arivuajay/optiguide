<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
        <div class="inner-container"> 
            <?php if (Yii::app()->language == "en") {
                ?>   
                <h2>Advertise with us </h2>
                <p>Please contact Martine Breton or Isabelle Groulx at the following :</p>           
                <p>Tel. : 450 629-6005<br>
                    Toll Free : 1 888 462-2112<br>
                    Fax : 450 629-6044<br>
                    Email Martine: <a href="mailto:martine@bretoncom.com">martine@bretoncom.com</a><br>
                    Email Isabelle: <a href="mailto:isabelle@bretoncom.com">isabelle@bretoncom.com</a>
                </p>
            <?php } else {
                ?>
                <h2>Annoncer avec nous </h2>
                <p>Nous vous invitons à contacter Martine Breton ou Isabelle Groulx aux coordonnées suivantes :</p>           
                <p>Tél. : 450 629-6005<br>
                    Sans frais : 1 888 462-2112<br>
                    Téléc : 450 629-6044<br>
                    Courriel Martine: <a href="mailto:martine@bretoncom.com">martine@bretoncom.com</a><br>
                    Courriel Isabelle: <a href="mailto:isabelle@bretoncom.com">isabelle@bretoncom.com</a>
                </p>                        
            <?php }
            ?>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'advertise-form',
                'htmlOptions' => array('role' => 'form'),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'enableAjaxValidation' => true,
            ));

            $all_banner_poitions = PublicityPosition::model()->findAll(array('order' => 'iId_position ASC','condition'=>"site='optiguide' and iId_position!=0" ));
            foreach ($all_banner_poitions as $positions) {
                $position = $positions['sPosition'] . " " . $positions['sFormat'];
                $banner_poitions[$position] = $position ;
            }
            ?>
            <div class="forms-cont">                   
                <div class="row"> 

                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"><?php echo $form->labelEx($model, 'name'); ?></div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"><?php echo $form->textField($model, 'name', array('class' => 'form-txtfield')); ?>
                            <?php echo $form->error($model, 'name'); ?>
                        </div>
                    </div>    

                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"><?php echo $form->labelEx($model, 'email'); ?></div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"><?php echo $form->textField($model, 'email', array('class' => 'form-txtfield')); ?>
                            <?php echo $form->error($model, 'email'); ?>
                        </div>
                    </div> 

                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"><?php echo $form->labelEx($model, 'telephone'); ?></div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"><?php echo $form->textField($model, 'telephone', array('class' => 'form-txtfield')); ?>
                            <?php echo $form->error($model, 'telephone'); ?>
                        </div>
                    </div>

                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"><?php echo $form->labelEx($model, 'informations'); ?></div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                            <?php echo $form->textArea($model, 'informations', array('class' => 'form-control', 'maxlength' => 500, 'rows' => 6, 'cols' => 50)); ?>
                            <?php echo $form->error($model, 'informations'); ?>
                        </div>
                    </div>                    

                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> <?php echo $form->labelEx($model, 'position'); ?></div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                                <?php echo $form->dropDownList($model, 'position', $banner_poitions, array('class' => 'form-control')); ?>
                                <?php echo $form->error($model, 'position'); ?>                  
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

