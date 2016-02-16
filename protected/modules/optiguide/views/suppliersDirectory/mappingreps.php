<?php
/* @var $this SuppliersDirectoryController */
/* @var $model SuppliersDirectory */
/* @var $form CActiveForm */

$cs_pos_end = CClientScript::POS_END;
$themeUrl   = $this->themeUrl;
$rdatas    = array();

foreach ($results as $userinfo)
{
    $rep_profile_firstname = ""; 
    if($userinfo['rep_profile_firstname']!="")
     $rep_profile_firstname =  ucfirst($userinfo['rep_profile_firstname']);  

    $rep_profile_lastname = ""; 
    if($userinfo['rep_profile_lastname']!="")
     $rep_profile_lastname =  ucfirst($userinfo['rep_profile_lastname']); 
                                    
    $rid = $userinfo['rep_credential_id'];
    $dispname = $rep_profile_firstname." ".$rep_profile_lastname.", ".$userinfo['NOM_VILLE'].", ".$userinfo['ABREVIATION_EN'].", ".$userinfo['NOM_PAYS_EN'];
    $rdatas[$rid]= $dispname;  
}
?>

<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 subscribe-btncont"> 
        <div class="inner-container"> 
            <h2> <?php echo Myclass::t('OGO171', '', 'og'); ?> </h2>


            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'suppliers-directory-form',
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
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <?php echo Myclass::t('OGO172', '', 'og'); ?> 
                            <?php                           
                            $data = array();
                            $htmlOptions = array('size' => '8', 'multiple' => 'true', 'id' => 'MasterSelectBox', 'class' => 'form-control');
                            echo $form->listBox($model, 'Reps1', $rdatas, $htmlOptions);
                            ?>  
                        </div>
                    </div>

                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">                           
                            <div class="col-sm-5">
                                <a href='javascript:void(0);' class="btn btn-info btn-sm" id="Addrep"><?php echo Myclass::t('OGO86', '', 'og'); ?></a>
                            </div>
                            <div class="col-sm-5">
                                <a href='javascript:void(0);' class="btn btn-danger btn-sm" id="Removerep"><?php echo Myclass::t('OGO87', '', 'og'); ?></a>          
                            </div>
                        </div>  
                    </div>    

                    <div class="form-row1"> 
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <?php echo Myclass::t('OGO173', '', 'og'); ?> 
                            <?php
                            $htmlOptions = array('size' => '8', 'multiple' => 'true', 'class' => 'form-control', 'options' => $selected);
                            echo $form->listBox($model, 'Reps2', $data, $htmlOptions);
                            ?>
                           <?php echo $form->error($model, 'Reps2'); ?>
                        </div>
                        
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 pull-right"> 
                        <?php
                        echo CHtml::tag('button', array(
                            'name' => 'btnSubmit',
                            'type' => 'submit',
                            'class' => 'submit-btn'
                                ), '<i class="fa fa-arrow-circle-right"></i> ' . Myclass::t('OG120'));
                        ?>
                    </div>   
                    
                    <?php $this->endWidget(); ?>
                </div>
            </div>                    
        </div>
    </div> 
</div>   
<?php
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($themeUrl . '/js/pair-select.min.js', $cs_pos_end);
$js = <<< EOD
$(document).ready(function(){
        
    $('#MasterSelectBox').pairMaster();
 
    // Add the retailers from multislect box            
    $('#Addrep').click(function(){
            $('#MasterSelectBox').addSelected('#RepCredentials_Reps2');
    });

    // Remove the retailers from multislect box   
    $('#Removerep').click(function(){
            $('#RepCredentials_Reps2').removeSelected('#MasterSelectBox'); 
    });     

});
EOD;
Yii::app()->clientScript->registerScript('_form_mappingrep', $js);
?>