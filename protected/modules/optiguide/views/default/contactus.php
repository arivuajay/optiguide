<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
        <div class="inner-container"> 
            <h2><?php echo Myclass::t('OG004', '', 'og'); ?> </h2>
            <p><?php echo Myclass::t('OGO131', '', 'og'); ?></p>
            <p>
                <strong>Breton Communications</strong><br>
                495 St-Martin Blvd, local 202<br>
                Laval, Quebec<br>
                H7M 1Y9
            </p>
            <p><?php echo Myclass::t('OG041', '', 'og'); ?>. : 450 629-6005<br>
                <?php echo Myclass::t('OG046', '', 'og'); ?> : 1 888 462-2112<br>
                <?php echo Myclass::t('OG042', '', 'og'); ?> : 450 629-6044<br>
                <?php echo Myclass::t('APP6'); ?> : <a href="mailto:info@bretoncom.com">info@bretoncom.com</a><br>                
            </p>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6"> 
                    <div class="contact-cont"> 
                        <p><strong><?php echo Myclass::t('OGO126', '', 'og'); ?></strong><br>
                            Martine Breton<br>
                            <a href="mailto:martine@bretoncom.com">martine@bretoncom.com</a></p>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6"> 
                    <div class="contact-cont"> 
                        <p><strong><?php echo Myclass::t('OGO127', '', 'og'); ?></strong><br>
                            Nicky Fambios<br>
                            <a href="mailto:nicky@bretoncom.com">nicky@bretoncom.com</a></p>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6"> 
                    <div class="contact-cont"> 
                        <p><strong><?php echo Myclass::t('OGO128', '', 'og'); ?></strong><br>
                            Martine Breton<br>
                            <a href="mailto:martine@bretoncom.com">martine@bretoncom.com</a></p>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6"> 
                    <div class="contact-cont"> 
                        <p><strong>Opti-News</strong><br>
                            Isabelle Groulx<br>
                            <a href="mailto:isabelle@bretoncom.com">isabelle@bretoncom.com</a></p>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6"> 
                    <div class="contact-cont"> 
                        <p><strong><?php echo Myclass::t('OGO129', '', 'og'); ?></strong><br>
                            Aurélie Vasseur<br>
                            <a href="mailto:aurelie@bretoncom.com">aurelie@bretoncom.com</a></p>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6"> 
                    <div class="contact-cont"> 
                        <p><strong><?php echo Myclass::t('OGO130', '', 'og'); ?></strong><br>
                            Louise Chalifoux<br>
                            <a href="mailto:louise@bretoncom.com">louise@bretoncom.com</a></p>
                    </div>
                </div>
            </div>            
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'advertise-form',
            'htmlOptions' => array('role' => 'form'),
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
            'enableAjaxValidation' => true,
        ));
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
                        <?php echo $form->labelEx($model, 'email'); ?>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <?php echo $form->textField($model, 'email', array('class' => 'form-txtfield')); ?>
                        <?php echo $form->error($model, 'email'); ?>
                    </div>
                </div> 

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                        <?php echo $form->labelEx($model, 'phone'); ?>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <?php echo $form->textField($model, 'phone', array('class' => 'form-txtfield')); ?>
                        <?php echo $form->error($model, 'phone'); ?>
                    </div>
                </div>

                <div class="form-row1"> 
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                        <?php echo $form->labelEx($model, 'message'); ?></div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                        <?php echo $form->textArea($model, 'message', array('class' => 'form-control', 'maxlength' => 500, 'rows' => 6, 'cols' => 50)); ?>
                        <?php echo $form->error($model, 'message'); ?>
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