<?php
/* @var $this SuppliersDirectoryController */
/* @var $model SuppliersDirectory */
/* @var $form CActiveForm */
?>

<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 subscribe-btncont"> 
        <div class="inner-container"> 
            <h2><?php  echo Myclass::t('OGO189','','og');?> </h2>

            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'archive-directory-form',
                'htmlOptions' => array('role' => 'form', 'enctype' => 'multipart/form-data'),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),               
            ));
            $getallcat = ArchiveFichier::get_allcategory();
            ?>

            <div class="forms-cont">                 
                <div class="row"> 

                    <div id="catlogo">
                        <div class="form-row1"> 
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                                <?php echo $form->labelEx($fmodel, 'ID_CATEGORIE', array()); ?>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">             
                                <?php echo $form->dropDownList($fmodel, 'ID_CATEGORIE', $getallcat, array('class' => 'form-control', 'empty' => Myclass::t('APP60'))); ?>         
                                <?php echo $form->error($fmodel, 'ID_CATEGORIE'); ?>
                            </div>
                        </div>

                        <div class="form-row1"> 
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                                <?php echo $form->labelEx($fmodel, 'TITRE_FICHIER_EN', array()); ?>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">            
                                <?php echo $form->textField($fmodel, 'TITRE_FICHIER_EN', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                                <?php echo $form->error($fmodel, 'TITRE_FICHIER_EN'); ?>
                            </div>
                        </div>

                        <div class="form-row1"> 
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                                <?php echo $form->labelEx($fmodel, 'image', array()); ?>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">     
                                <?php echo $form->fileField($fmodel, 'image'); ?>                         
                                <?php echo $form->error($fmodel, 'image'); ?>
                            </div>
                        </div>
                        <?php 
                        if(isset($fmodel->ID_CATEGORIE))
                        {    
                            $img_url = Yii::app()->getBaseUrl(true) . '/uploads/archivage/' . $fmodel->ID_CATEGORIE.'/'. $fmodel->FICHIER; ?>
                            <div class="form-row1"> 
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> &nbsp;</div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">     
                                    <img src="<?php echo $img_url; ?>" width="200" height="200" alt=""> 
                                </div>
                            </div>
                        <?php 
                        }
                        ?>
                    </div>  

                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 pull-right"> 
                        <?php
                        echo CHtml::tag('button', array(
                            'name' => 'btnSubmit',
                            'type' => 'submit',
                            'class' => 'submit-btn'
                                ), '<i class="fa fa-arrow-circle-right"></i> Update');
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
        
});
EOD;
Yii::app()->clientScript->registerScript('_form_updatelogo', $js);
?>
