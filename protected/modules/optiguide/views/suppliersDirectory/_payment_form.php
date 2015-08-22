<?php
/* @var $this SuppliersDirectoryController */
/* @var $model SuppliersDirectory */
/* @var $form CActiveForm */

$cs_pos_end = CClientScript::POS_END;
$themeUrl = $this->themeUrl;
//$actn_url = Yii::app()->createUrl('/admin/suppliersDirectory/addproducts/');
$lstr = Yii::app()->session['language'];
$sectiontypes = CHtml::listData(SectionDirectory::model()->findAll(array("order" => "NOM_SECTION_" . $lstr)), 'ID_SECTION', 'NOM_SECTION_' . $lstr);
//$archivecats = CHtml::listData(ArchiveCategory::model()->findAll(array("order" => 'NOM_CATEGORIE_FR')), 'ID_CATEGORIE', 'NOM_CATEGORIE_FR');
?>

<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 subscribe-btncont"> 
        <div class="inner-container"> 
            <h2> <?php echo Myclass::t('OGO81', '', 'og'); ?> </h2>

            <?php  $this->renderPartial('_menu_steps', array());?>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'suppliers-directory-form',
                'htmlOptions' => array('role' => 'form', 'enctype' => 'multipart/form-data'),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'enableAjaxValidation' => true,
            ));
            $getallcat = ArchiveFichier::get_allcategory();
            ?>

            <div class="forms-cont"> 
                <div class="forms-heading"><i class="fa fa-cubes"></i> <?php echo Myclass::t('OGO104', '', 'og'); ?></div>
                <div class="row"> 

                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php echo $form->labelEx($pmodel, 'payment_type', array()); ?> 
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">                                                                                     
                            <?php echo $form->dropDownList($pmodel, 'payment_type', array('1' => 'Paypal', '2' => 'Stripe'), array('class' => 'selectpicker', "empty" => Myclass::t('OG118'))); ?>                          
                            <?php echo $form->error($pmodel, 'payment_type'); ?>
                        </div>
                    </div>    

                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                            <?php echo $form->labelEx($pmodel, 'subscription_type', array()); ?> 
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">                                                                                     
                            <?php echo $form->dropDownList($pmodel, 'subscription_type', array('1' => Myclass::t('OGO110', '', 'og'), '2' => Myclass::t('OGO111', '', 'og')), array('class' => 'selectpicker', "empty" => Myclass::t('OG118'))); ?>                          
                            <?php echo $form->error($pmodel, 'subscription_type'); ?>
                        </div>
                    </div> 

                    <div id="catlogo">

                        <div class="form-row1"> 
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                                <?php echo $form->labelEx($pmodel, 'ID_CATEGORIE', array()); ?>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">             
                                <?php echo $form->dropDownList($pmodel, 'ID_CATEGORIE', $getallcat, array('class' => 'form-control', 'empty' => Myclass::t('APP60'))); ?>         
                                <?php echo $form->error($pmodel, 'ID_CATEGORIE'); ?>
                            </div>
                        </div>

                        <div class="form-row1"> 
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                                <?php echo $form->labelEx($pmodel, 'TITRE_FICHIER', array()); ?>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">            
                                <?php echo $form->textField($pmodel, 'TITRE_FICHIER', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                                <?php echo $form->error($pmodel, 'TITRE_FICHIER'); ?>
                            </div>
                        </div>

                        <div class="form-row1"> 
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                                <?php echo $form->labelEx($pmodel, 'image', array()); ?>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">     
                                <?php echo $form->fileField($pmodel, 'image'); ?>                         
                                <?php echo $form->error($pmodel, 'image'); ?>
                            </div>
                        </div>

                    </div>  

                    <div id="price">
                        <div class="form-row1"> 
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                                <?php echo $form->labelEx($pmodel, 'amount', array()); ?>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">            
                                <?php echo $form->textField($pmodel, 'amount', array('value' => '', 'class' => 'form-control', 'size' => 60, 'maxlength' => 255, 'readonly' => true)); ?>
                                <?php echo $form->error($pmodel, 'amount'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 pull-right"> 
                        <?php
                        echo CHtml::tag('button', array(
                            'name' => 'btnSubmit',
                            'type' => 'submit',
                            'class' => 'submit-btn'
                                ), '<i class="fa fa-arrow-circle-right"></i> ' . Myclass::t('OGO103', '', 'og'));
                        ?>
                    </div>                    

                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div> 
</div>   
<?php
$js = <<< EOD
$(document).ready(function(){ 
        
     var subval=$("#SuppliersSubscription_subscription_type").val();
     chnagedrop(subval);    
        
    $("#SuppliersSubscription_subscription_type").change(function(){
        var subval = $(this).val();
        chnagedrop(subval);
    }); 
        
        
    function chnagedrop(subval)
    {
        $('#catlogo').hide();
        $('#price').hide();
        
        if(subval==2)
        {
            $('#catlogo').show();
            $('#price').show();
            $('#SuppliersSubscription_amount').val('125');
        }else  if(subval==1)
        {
            $('#catlogo').hide();
            $('#price').show();
            $('#SuppliersSubscription_amount').val('100');
        }
    }              
});
EOD;
Yii::app()->clientScript->registerScript('_form_payment', $js);
?>
