<?php
/* @var $this CalenderEventsController */
/* @var $model CalenderEvents */
/* @var $form CActiveForm */


$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerCssFile($themeUrl . '/css/datepicker/datepicker3.css');
$cs->registerScriptFile(Yii::app()->baseUrl.'/ckeditor/ckeditor.js');
$cs->registerScriptFile(Yii::app()->baseUrl.'/ckeditor/adapters/jquery.js');
$cs->registerScript(
  'js2',
  '
    var config = {
    toolbar:
    [
     ["Bold", "Italic","Underline", "-", "NumberedList", "BulletedList", "-" ],  
     ["UIColor"],["TextColor"],["Undo","Redo","Link"],
     ["JustifyLeft","JustifyCenter","JustifyRight","JustifyBlock"],
     ["NumberedList","BulletedList","FontSize","Font","Preview"]
    ],
    height:150,
    width:510
    };
    $("#CalenderEvent_TEXTE").ckeditor(config);
  ',
  CClientScript::POS_LOAD
);
$cs->registerScriptFile($themeUrl . '/js/datepicker/bootstrap-datepicker.js', $cs_pos_end);


$startdate = $model->DATE_AJOUT1;
$enddate   = $model->DATE_AJOUT2;

$country   = Myclass::getallcountries();               
$regions   = Myclass::getallregions($model->ID_PAYS);
$cities    = Myclass::getallcities($model->ID_REGION);
?>

<div class="row">
    <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'calender-events-form',
                'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
                'enableAjaxValidation' => true,  
                'clientOptions' => array(
                    'validateOnSubmit' => true,                   
                ),               
            ));
            ?>
            <div class="box-body">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'LANGUE', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->dropDownList($model, 'LANGUE', array("FR" => 'Français', "EN" => 'Anglais'), array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'LANGUE'); ?>
                    </div>
                </div>


                <div class="form-group">
                    <?php echo $form->labelEx($model, 'TITRE', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'TITRE', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'TITRE'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'TEXTE', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">                     
                        <?php echo $form->textArea($model, 'TEXTE', array('class' => 'form-control', 'maxlength' => 5000, 'rows' => 6, 'cols' => 50)); ?>
                        <?php echo $form->error($model, 'TEXTE'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'DATE_AJOUT1', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'DATE_AJOUT1', array('class' => 'form-control date', 'readonly' => 'true')); ?>
                        <?php echo $form->error($model, 'DATE_AJOUT1'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'DATE_AJOUT2', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'DATE_AJOUT2', array('class' => 'form-control date', 'readonly' => 'true')); ?>
                        <?php echo $form->error($model, 'DATE_AJOUT2'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'LIEN_URL', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'LIEN_URL', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'LIEN_URL'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'LIEN_TITRE', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'LIEN_TITRE', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'LIEN_TITRE'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'ID_PAYS', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">                       
                        <?php echo $form->dropDownList($model, 'ID_PAYS', $country, array('class' => 'form-control', 'empty' => Myclass::t('APP43'))); ?>                          
                        <?php echo $form->error($model, 'ID_PAYS'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'ID_REGION', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">                       
                        <?php echo $form->dropDownList($model, 'ID_REGION', $regions, array('class' => 'form-control', 'empty' => Myclass::t('APP44'))); ?>                          
                        <?php echo $form->error($model, 'ID_REGION'); ?>
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
                    <?php echo $form->labelEx($model, 'AFFICHER_SITE', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">                       
                        <?php echo $form->radioButtonList($model, 'AFFICHER_SITE', array('1' => 'Oui', '0' => 'Non'), array('class' => 'myclassv', 'separator' => ' ')); ?> 
                        <?php echo $form->error($model, 'AFFICHER_SITE'); ?>
                    </div>
                </div>
                
                <div id="AFFICHER_OPTIONS" style="display: none;">
                    <div class="form-group">
                        <?php echo $model->AFFICHER_ACCUEIL;?>
                        <?php echo $form->labelEx($model, 'AFFICHER_ACCUEIL', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                            <?php echo $form->radioButtonList($model, 'AFFICHER_ACCUEIL', array('1' => 'Oui', '0' => 'Non'), array('separator' => ' ')); ?> 
                            <?php echo $form->error($model, 'AFFICHER_ACCUEIL'); ?>
                        </div>
                    </div>     

                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'AFFICHER_ARCHIVE', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">                      
                            <?php echo $form->radioButtonList($model, 'AFFICHER_ARCHIVE', array('1' => 'Oui', '0' => 'Non'), array('separator' => ' ')); ?> 
                            <?php echo $form->error($model, 'AFFICHER_ARCHIVE'); ?>
                        </div>
                    </div>
                </div>    



            </div><!-- /.box-body -->
            <div class="box-footer">
                <div class="form-group">
                    <div class="col-sm-0 col-sm-offset-2">
                        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary')); ?>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div><!-- ./col -->
</div>
<?php
$ajaxRegionUrl = Yii::app()->createUrl('/admin/cityDirectory/getregions');
$ajaxCityUrl   = Yii::app()->createUrl('/admin/categoryInformation/getcities');
$js = <<< EOD
$(document).ready(function(){
        
$('.year').datepicker({ dateFormat: 'yyyy' });
$('.date').datepicker({ format: 'yyyy-mm-dd' });     
    
        
var startdate = '{$startdate}';
var enddate   = '{$enddate}';
if(startdate=='' || enddate=='')
{
   $( "#CalenderEvent_DATE_AJOUT1" ).datepicker( "setDate" , new Date())
   $( "#CalenderEvent_DATE_AJOUT2" ).datepicker( "setDate" , new Date())    
}
    
var firstradio = $('input[name="CalenderEvent\\[AFFICHER_SITE\\]"]:checked').val();
if(firstradio=="0")
{
     $('#AFFICHER_OPTIONS').hide();
     $('input[name="CalenderEvent\\[AFFICHER_ARCHIVE\\]"]').attr('disabled',true);       
     $('input[name="CalenderEvent\\[AFFICHER_ACCUEIL\\]"]').attr('disabled',true);      
}else
{
     $('#AFFICHER_OPTIONS').show();
     $('input[name="CalenderEvent\\[AFFICHER_ARCHIVE\\]"]').attr('disabled',true);       
     $('input[name="CalenderEvent\\[AFFICHER_ACCUEIL\\]"]').attr('disabled',true);      
}


        
$('input[name="CalenderEvent\\[AFFICHER_SITE\\]"]').on('ifChecked', function(event){
    var chkval = $('input[name="CalenderEvent\\[AFFICHER_SITE\\]"]:checked').val();

   if(chkval=="1")
   {
        $('#AFFICHER_OPTIONS').show();
        $('input[name="CalenderEvent\\[AFFICHER_ARCHIVE\\]"]').attr('disabled',false);       
        $('input[name="CalenderEvent\\[AFFICHER_ACCUEIL\\]"]').attr('disabled',false);      
   }else if(chkval=="0")
   {
         $('#AFFICHER_OPTIONS').hide();
        $('input[name="CalenderEvent\\[AFFICHER_ARCHIVE\\]"]').attr('disabled',true);       
        $('input[name="CalenderEvent\\[AFFICHER_ACCUEIL\\]"]').attr('disabled',true);      
   }    
});

 $("#CalenderEvent_ID_PAYS").change(function(){
        var id=$(this).val();
        var dataString = 'id='+ id;
            
        $.ajax({
            type: "POST",
            url: '{$ajaxRegionUrl}',
            data: dataString,
            cache: false,
            success: function(html){             
                $("#CalenderEvent_ID_REGION").html(html);
            }
         });
    });
   
   $("#CalenderEvent_ID_REGION").change(function(){
        var id=$(this).val();
        var dataString = 'id='+ id;
            
        $.ajax({
            type: "POST",
            url: '{$ajaxCityUrl}',
            data: dataString,
            cache: false,
            success: function(html){             
                $("#CalenderEvent_ID_VILLE").html(html);
            }
         });

    });

                
});
EOD;
Yii::app()->clientScript->registerScript('_form', $js);
?>