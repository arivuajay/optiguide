<?php
/* @var $this NewsManagementController */
/* @var $model NewsManagement */
/* @var $form CActiveForm */

$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerCssFile($themeUrl . '/css/datepicker/datepicker3.css');
$cs->registerScriptFile($themeUrl . '/js/datepicker/bootstrap-datepicker.js', $cs_pos_end);

$archivecats = CHtml::listData(ArchiveCategory::model()->findAll(array('order' => 'NOM_CATEGORIE_FR ASC')), 'ID_CATEGORIE', 'NOM_CATEGORIE_FR');


$ficherid = $model->ID_FICHIER;
$categoryid = 0;
$ficherimage = '';
if ($ficherid > 0) {
    $fichres = ArchiveFichier::model()->find("ID_FICHIER=$ficherid");
    $categoryid = $fichres->ID_CATEGORIE;
    $ficherfile = $fichres->FICHIER;
    // $fileurl = $themeUrl . '/img/archivage/' . $categoryid . '/' . $ficherfile;
    $fileurl = Yii::app()->createAbsoluteUrl("/uploads/archivage/" . $categoryid . "/" . $ficherfile);
   if (!file_exists(YiiBase::getPathOfAlias('webroot').'/uploads/archivage/'.$categoryid.'/'.$ficherfile))
    {
        $fileurl = Yii::app()->createAbsoluteUrl("/uploads/archivage/noimage.png");    
    }   
}else {
    $fileurl = "javascript:void(0);";
}

for ($i = 1; $i < 100; $i++) {

    $hierarchie[$i] = $i;
}

$startdate = $model->DATE_AJOUT1;
$enddate = $model->DATE_AJOUT2;
?>

<div class="row">
    <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'news-management-form',
                'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'enableAjaxValidation' => true,
            ));
            ?>
            <div class="box-body">              
                <div class="box-header">
                    <h3 class="box-title">Général</h3>
                </div>
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
                    <?php echo $form->labelEx($model, 'SYNOPSYS', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">                 
                        <?php echo $form->textArea($model, 'SYNOPSYS', array('class' => 'form-control', 'maxlength' => 500, 'rows' => 6, 'cols' => 50)); ?>
                        <?php echo $form->error($model, 'SYNOPSYS'); ?>
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
                    <?php echo $form->labelEx($model, 'archivecat', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->dropDownList($model, 'archivecat', $archivecats, array('class' => 'form-control', 'options' => array($categoryid => array('selected' => true)))); ?>                          
                        <?php echo $form->error($model, 'archivecat'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php $fichercats = array("0" => "Aucune"); ?>
                    <?php echo $form->labelEx($model, 'ID_FICHIER', array('class' => 'col-sm-2 control-label')); ?>  
                    <div class="col-sm-5">
                        <?php echo $form->dropDownList($model, 'ID_FICHIER', $fichercats, array('class' => 'form-control', 'options' => array($ficherid => array('selected' => true)))); ?>    
                        <a href="<?php echo $fileurl; ?>" class="viewficherfile"><img src="<?php echo $themeUrl . '/img/preview.gif'; ?>"></a>
                    </div>
                    <?php echo $form->error($model, 'ID_FICHIER'); ?>
                </div>


                <div class="form-group" style="display:none;">
                    <?php echo $form->labelEx($model, 'LIEN_TITRE', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'LIEN_TITRE', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'LIEN_TITRE'); ?>
                    </div>
                </div>

                <div class="form-group" style="display:none;">
                    <?php echo $form->labelEx($model, 'LIEN_URL', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'LIEN_URL', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'LIEN_URL'); ?>
                    </div>
                </div>
                
                <div class="box-header">
                    <h3 class="box-title">Visualisation</h3>
                </div>

                <div class="form-group" style="display:none;">
                    <?php echo $form->labelEx($model, 'HIERARCHIE', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">                       
                        <?php echo $form->dropDownList($model, 'HIERARCHIE', $hierarchie, array('class' => 'form-control')); ?>  
                        <?php echo $form->error($model, 'HIERARCHIE'); ?>
                    </div>
                </div>


                <div class="form-group">
                    <?php echo $form->labelEx($model, 'AFFICHER_SITE', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">                       
                        <?php echo $form->radioButtonList($model, 'AFFICHER_SITE', array('1' => 'Oui', '0' => 'Non'), array('class' => 'myclassv', 'separator' => ' ')); ?> 
                        <?php echo $form->error($model, 'AFFICHER_SITE'); ?>
                    </div>
                </div>

                <div class="form-group" style="display:none;">
                    <?php echo $form->labelEx($model, 'AFFICHER_SECTION', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">                      
                        <?php echo $form->radioButtonList($model, 'AFFICHER_SECTION', array('1' => 'Dans sa section', '0' => 'Archives'), array('separator' => ' ')); ?> 
                        <?php echo $form->error($model, 'AFFICHER_SECTION'); ?>
                    </div>
                </div>

                <div class="form-group" style="display:none;">
                    <?php echo $form->labelEx($model, 'AFFICHER_ACCUEIL', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->radioButtonList($model, 'AFFICHER_ACCUEIL', array('1' => 'Oui', '0' => 'Non'), array('separator' => ' ')); ?> 
                        <?php echo $form->error($model, 'AFFICHER_ACCUEIL'); ?>
                    </div>
                </div>



            </div><!-- /.box-body -->
            <div class="box-footer">
                <div class="form-group">
                    <div class="col-sm-0 col-sm-offset-2">
                        <?php echo CHtml::submitButton($model->isNewRecord ? 'Ajouter cette nouvelle' : 'Modifier cette nouvelle', array('class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary')); ?>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div><!-- ./col -->
</div>

<?php
$ajaxFicherUrl = Yii::app()->createUrl('/admin/NewsManagement/getfichers');
$ajaxFetchimage = Yii::app()->createUrl('/admin/NewsManagement/getficherimage');

$js = <<< EOD
$(document).ready(function(){
        
   $('.year').datepicker({ dateFormat: 'yyyy' });
   $('.date').datepicker({ format: 'yyyy-mm-dd' });     
        
var startdate = '{$startdate}';
var enddate   = '{$enddate}';
if(startdate=='' || enddate=='')
{
   $( "#NewsManagement_DATE_AJOUT1" ).datepicker( "setDate" , new Date())
   $( "#NewsManagement_DATE_AJOUT2" ).datepicker( "setDate" , new Date())    
}
    
var firstradio = $('input[name="NewsManagement\\[AFFICHER_SITE\\]"]:checked').val();
if(firstradio==0)
{
     $('input[name="NewsManagement\\[AFFICHER_SECTION\\]"]').attr('disabled',true);       
     $('input[name="NewsManagement\\[AFFICHER_ACCUEIL\\]"]').attr('disabled',true);      
}  


        
$('input[name="NewsManagement\\[AFFICHER_SITE\\]"]').on('ifChecked', function(event){
    var chkval = $('input[name="NewsManagement\\[AFFICHER_SITE\\]"]:checked').val();
        
   if(chkval=="1")
   {
        $('input[name="NewsManagement\\[AFFICHER_SECTION\\]"]').attr('disabled',false);       
        $('input[name="NewsManagement\\[AFFICHER_ACCUEIL\\]"]').attr('disabled',false);      
   }else  if(chkval=="0")
   {
        $('input[name="NewsManagement\\[AFFICHER_SECTION\\]"]').attr('disabled',true);       
        $('input[name="NewsManagement\\[AFFICHER_ACCUEIL\\]"]').attr('disabled',true);      
   }    
});
        
        
       
// Get the fichers list based on selected ficher category
       
        var vficherid = '{$ficherid}';
        var vcatid    = '{$categoryid}'; 

          $("#NewsManagement_archivecat").change(function(e){
             var id=$(this).val();
             var dataString = 'id='+ id;
             $.ajax({
                 type: "POST",
                 url: '{$ajaxFicherUrl}',
                 data: dataString,
                 cache: false,
                 success: function(html){             
                     $("#NewsManagement_ID_FICHIER").html(html);
                     if(e.isTrigger)
                     $("#NewsManagement_ID_FICHIER").val(vficherid);                
                 }
              });
         }); 

// Trigger the dropdown event on form load if the catid value exist   
                 
    if(vcatid > 0)
    {
        $('#NewsManagement_archivecat').trigger('change');           
    }

// Get the ficher file on select the ficher dropdown.
                 
    $("#NewsManagement_ID_FICHIER").change(function(e){
        var id=$(this).val();
        var dataString = 'id='+ id;
        $.ajax({
            type: "POST",
            url: '{$ajaxFetchimage}',
            data: dataString,
            cache: false,
            success: function(html){             
                $(".viewficherfile").attr("href", html);                         
            }
         });
    }); 
 
// Click to preview the ficher file in popup window   
            
 $('.viewficherfile').click(function(event) {
        event.preventDefault();           
        window.open($(this).attr("href"), "popupWindow", "width=600,height=600,scrollbars=yes");
    });    
        
        
});
EOD;
Yii::app()->clientScript->registerScript('_form', $js);
?>