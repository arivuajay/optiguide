<?php
/* @var $this PublicityAdsController */
/* @var $model PublicityAds */
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
    $fileurl = $themeUrl . '/img/archivage/' . $categoryid . '/' . $ficherfile;
} else {
    $fileurl = "javascript:void(0);";
}


$startdate = $model->DATE_DEBUT;
$enddate = $model->DATE_FIN;
?>

<div class="row">
    <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'publicity-ads-form',
                'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'enableAjaxValidation' => true,
            ));
            ?>
            <div class="box-header">
                <h3 class="box-title">Général</h3>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'NO_PUB', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'NO_PUB', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'NO_PUB'); ?>
                    </div>
                </div>


                <div class="form-group">
                    <?php echo $form->labelEx($model, 'CLIENT', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'CLIENT', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'CLIENT'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'PRIX', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-2">
                        <?php echo $form->textField($model, 'PRIX', array('class' => 'form-control', 'size' => 50, 'maxlength' => 50)); ?>
                        <?php echo $form->error($model, 'PRIX'); ?>
                    </div>                    
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'PAYE', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-2">                      
                        <?php echo $form->radioButtonList($model, 'PAYE', array('1' => 'Oui', '0' => 'Non'), array('separator' => ' ')); ?> 
                        <?php echo $form->error($model, 'PAYE'); ?>
                    </div>   
                </div>

                <div class="box-header">
                    <h3 class="box-title">Publicité</h3>
                </div>                         

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'PRIORITE', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">                       
                        <?php echo $form->radioButtonList($model, 'PRIORITE', array('0' => 'Par date', '1' => 'Par nombre d\'impressions '), array('separator' => ' ')); ?> 
                        <?php echo $form->error($model, 'PRIORITE'); ?>
                    </div>
                </div>

                <div id="datedisp">
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'DATE_DEBUT', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">                      
                            <?php echo $form->textField($model, 'DATE_DEBUT', array('class' => 'form-control date', 'readonly' => 'true')); ?>
                            <?php echo $form->error($model, 'DATE_DEBUT'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'DATE_FIN', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">                          
                            <?php echo $form->textField($model, 'DATE_FIN', array('class' => 'form-control date', 'readonly' => 'true')); ?> 
                            <?php echo $form->error($model, 'DATE_FIN'); ?>
                        </div>
                    </div>
                </div>

                <div id="impressdisp">                    

                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'NB_IMPRESSIONS', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                            <?php echo $form->textField($model, 'NB_IMPRESSIONS', array('class' => 'form-control')); ?>
                            <?php echo $form->error($model, 'NB_IMPRESSIONS'); ?>
                        </div>
                    </div>
                </div>   

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'archivecat', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-3">
                        <?php echo $form->dropDownList($model, 'archivecat', $archivecats, array('class' => 'form-control', 'options' => array($categoryid => array('selected' => true)))); ?>                          
                        <?php echo $form->error($model, 'archivecat'); ?>
                    </div>
                    <div class="col-sm-2">
                        <?php $fichercats = array("0" => "Aucune"); ?>
                        <?php echo $form->dropDownList($model, 'ID_FICHIER', $fichercats, array('class' => 'form-control', 'options' => array($ficherid => array('selected' => true)))); ?>    
                        <a href="<?php echo $fileurl; ?>" class="viewficherfile"><img src="<?php echo $themeUrl . '/img/preview.gif'; ?>"></a>
                        <?php echo $form->error($model, 'ID_FICHIER'); ?>
                    </div>
                </div>
                
                 <div class="form-group">
                    <?php echo $form->labelEx($model, 'ID_POSITION', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->dropDownList($model, 'ID_POSITION', array("FR" => 'Français', "EN" => 'Anglais'), array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'ID_POSITION'); ?>
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
                    <?php echo $form->labelEx($model, 'LIEN_URL', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'LIEN_URL', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        <?php echo $form->error($model, 'LIEN_URL'); ?>
                    </div>
                </div>


                <div class="box-header">
                    <h3 class="box-title"> Options d'affichage</h3>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'LANGUE', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-3">
                        <?php echo $form->dropDownList($model, 'LANGUE', array("FR" => 'Français', "EN" => 'Anglais'), array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'LANGUE'); ?>
                    </div>
                    <?php echo $form->labelEx($model, 'ZONE_AFFICHAGE', array('class' => 'col-sm-1 control-label')); ?>
                    <div class="col-sm-2">
                        <?php echo $form->dropDownList($model, 'ZONE_AFFICHAGE', array("FR" => 'Français', "EN" => 'Anglais'), array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'ZONE_AFFICHAGE'); ?>
                    </div>
                </div> 
                
                  <div class="form-group">
                    <?php echo $form->labelEx($model, 'AFFICHER_ACCUEIL', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'AFFICHER_ACCUEIL', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'AFFICHER_ACCUEIL'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'ACCUEIL_SECTION', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                         <?php echo $form->radioButtonList($model, 'ACCUEIL_SECTION', array('1' => 'Oui', '0' => 'Non'), array('separator' => ' ')); ?> 
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
$ajaxFicherUrl = Yii::app()->createUrl('/admin/suppliersDirectory/getfichers');
$ajaxFetchimage = Yii::app()->createUrl('/admin/suppliersDirectory/getficherimage');

$js = <<< EOD
$(document).ready(function(){
        
   $('.year').datepicker({ dateFormat: 'yyyy' });
   $('.date').datepicker({ format: 'yyyy-mm-dd' });     
        
var startdate = '{$startdate}';
var enddate   = '{$enddate}';
if(startdate=='' || enddate=='')
{
   $( "#PublicityAds_DATE_DEBUT" ).datepicker( "setDate" , new Date())
   $( "#PublicityAds_DATE_FIN" ).datepicker( "setDate" , new Date())    
}
    
var PRIORITEradio = $('input[name="PublicityAds\\[PRIORITE\\]"]:checked').val();

if(PRIORITEradio=="0")
{
     $('#impressdisp').hide();            
}  

   
$('input[name="PublicityAds\\[PRIORITE\\]"]').on('ifChecked', function(event){
    var chkval = $('input[name="PublicityAds\\[PRIORITE\\]"]:checked').val();
        
   if(chkval=="1")
   {
        $('#datedisp').hide();  
        $('#impressdisp').show();         
            
   }else  if(chkval=="0")
   {
       $('#impressdisp').hide();  
       $('#datedisp').show();  
   }    
});
        
        
       
// Get the fichers list based on selected ficher category
       
        var vficherid = '{$ficherid}';
        var vcatid    = '{$categoryid}'; 

          $("#PublicityAds_archivecat").change(function(e){
             var id=$(this).val();
             var dataString = 'id='+ id;
             $.ajax({
                 type: "POST",
                 url: '{$ajaxFicherUrl}',
                 data: dataString,
                 cache: false,
                 success: function(html){             
                     $("#PublicityAds_ID_FICHIER").html(html);
                     if(e.isTrigger)
                     $("#PublicityAds_ID_FICHIER").val(vficherid);                
                 }
              });
         }); 

// Trigger the dropdown event on form load if the catid value exist   
                 
    if(vcatid > 0)
    {
        $('#PublicityAds_archivecat').trigger('change');           
    }

// Get the ficher file on select the ficher dropdown.
                 
    $("#PublicityAds_ID_FICHIER").change(function(e){
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