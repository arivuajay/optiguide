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
    $fileurl = Yii::app()->createAbsoluteUrl("/uploads/archivage/".$categoryid."/".$ficherfile);
    
    if (!file_exists(YiiBase::getPathOfAlias('webroot').'/uploads/archivage/'.$categoryid.'/'.$ficherfile))
    {
        $fileurl = Yii::app()->createAbsoluteUrl("/uploads/archivage/noimage.png");    
    }   
} else {
    $fileurl = "javascript:void(0);";
}

$all_banner_poitions = PublicityPosition::model()->findAll(array('order' => 'iId_position ASC'));
foreach ($all_banner_poitions as $positions) {
    $position_id = $positions['iId_position'];
    $banner_poitions[$position_id] = $positions['sPosition'] . " " . $positions['sFormat'];
}

$publicityZones = CHtml::listData(PublicityZones::model()->findAll(array('order' => 'ID_ZONE ASC','condition' => 'ID_ZONE=2')), 'ID_ZONE', 'NOM_ZONE');
$publicityModules = CHtml::listData(PublicityModules::model()->findAll(array('order' => 'NOM_MODULE ASC')), 'ID_MODULE', 'NOM_MODULE');

//$regions_result = Yii::app()->db->createCommand() //this query contains all the data
//        ->select('p.NOM_PAYS_FR , r.NOM_REGION_FR , r.ID_REGION')
//        ->from(array('repertoire_ville AS v', 'repertoire_region AS r', 'repertoire_pays AS p'))
//        ->where("p.ID_PAYS=r.ID_PAYS AND r.ID_REGION=v.ID_REGION AND (r.NOM_REGION_EN!='N/A' AND r.NOM_REGION_FR!='N/D' )")
//        ->group('r.ID_REGION')
//        ->order('p.NOM_PAYS_FR,r.NOM_REGION_FR')
//        ->queryAll();
//foreach ($regions_result as $regions) {
//    $region_id = $regions['ID_REGION'];
//    $regions_display[$region_id] = $regions['NOM_PAYS_FR'] . " - " . $regions['NOM_REGION_FR'];
//}

$sectiontypes = CHtml::listData(SectionDirectory::model()->findAll(array("order" => "NOM_SECTION_FR")), 'ID_SECTION', 'NOM_SECTION_FR');

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

                <div id="datedisp" <?php if($model->PRIORITE == "1"){ ?>  style="display: none;" <?php } ?>>
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
                        <?php echo $form->error($model, 'ID_FICHIER'); ?>
                    </div>
                    <div class="col-sm-2">
                        <?php $fichercats = array(); ?>
                        <?php echo $form->dropDownList($model, 'ID_FICHIER', $fichercats, array('class' => 'form-control', "empty" => "Aucune", 'options' => array($ficherid => array('selected' => true)))); ?>    
                        <a href="<?php echo $fileurl; ?>" class="viewficherfile"><img src="<?php echo $themeUrl . '/img/preview.gif'; ?>"></a>
                    </div>
                </div>
                
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'ID_POSITION', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->dropDownList($model, 'ID_POSITION', $banner_poitions, array('class' => 'form-control')); ?>
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
                        <?php echo $form->textField($model, 'LIEN_URL', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>(http://www.monsite.com )
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
                        <?php echo $form->dropDownList($model, 'ZONE_AFFICHAGE', $publicityZones, array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'ZONE_AFFICHAGE'); ?>
                    </div>
                </div> 

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'AFFICHER_ACCUEIL', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->radioButtonList($model, 'AFFICHER_ACCUEIL', array('1' => 'Oui', '0' => 'Non'), array('separator' => ' ')); ?> 
                    </div>
                </div>

                <div class="form-group" id="secure_section" <?php if ($model->AFFICHER_ACCUEIL == 1) { ?> style="display: none;" <?php } ?>>
                    <?php echo $form->labelEx($model, 'ACCUEIL_SECTION', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->radioButtonList($model, 'ACCUEIL_SECTION', array('1' => 'Oui', '0' => 'Non'), array('separator' => ' ')); ?> 
                    </div>
                </div>

                <div class="form-group">
                    <label for="plusieurs" class="col-sm-2 control-label"></label>
                    <div class="col-sm-5">
                        <p><b>Utilisez la touche CTRL pour en choisir plusieurs</b></p>
                    </div>
                </div>

                <div class="form-group" id="secure_modules" <?php if ($model->AFFICHER_ACCUEIL == 1) { ?> style="display: none;" <?php } ?>>
                    <label for="Afficher" class="col-sm-2 control-label"></label>
                    <div class="col-sm-5">
                        Afficher dans les sections sécurisées suivantes :
                        <?php
                        $options_modules = $selected_modules;
                        $htmlOptions = array('size' => '7', 'multiple' => 'true', 'id' => 'publicityModules', 'class' => 'form-control','options'=>$options_modules);
                        echo $form->listBox($model, 'publicityModules', $publicityModules, $htmlOptions);
                        ?>  
                    </div>
                </div>

                <div class="form-group" id="secure_category" <?php if ($model->AFFICHER_ACCUEIL == 1 && $model->ZONE_AFFICHAGE==1) { ?> style="display: none;" <?php } ?>>
                    <label for="associées" class="col-sm-2 control-label"></label>
                    <div class="col-sm-5">
                        Catégories associées pour les fournisseurs (optionnel) :
                        <?php  
                        $options_sections = $selected_sections;
                        $htmlOptions = array('size' => '15', 'multiple' => 'true', 'id' => 'section', 'class' => 'form-control','options'=>$options_sections);
                        echo $form->listBox($model, 'section', $sectiontypes, $htmlOptions);
                        ?>  
                    </div>
                </div>

                <div class="form-group"  id="secure_keywords" <?php if ($model->AFFICHER_ACCUEIL == 1 && $model->ZONE_AFFICHAGE==1) { ?> style="display: none;" <?php } ?>>
                    <label for="recherche" class="col-sm-2 control-label"></label>
                    <div class="col-sm-5">
                        Mots clés pour la recherche (optionnel):
                        <?php echo $form->textField($model, 'MOTS_CLES_RECHERCHE', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                        * sans séparateur : oeil yeux lunettes verres contact couleur bleu...
                    </div>
                </div>


            </div><!-- /.box-body -->
            <div class="box-footer">
                <div class="form-group">
                    <div class="col-sm-0 col-sm-offset-2">
                        <?php echo CHtml::submitButton($model->isNewRecord ? 'Ajouter cette publicité' : 'Save', array('class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary')); ?>
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
    
    $("#secure_category").show();  
    $("#secure_keywords").show(); 
    $("#secure_section").show();  
    
        
 $("#PublicityAds_ZONE_AFFICHAGE").change(function(e){
    var id=$(this).val();
    var chkval = $('input[name="PublicityAds\\[AFFICHER_ACCUEIL\\]"]:checked').val();
    if(id==2)
    {    
      $("#secure_category").show();  
      $("#secure_keywords").show(); 
      $("#secure_section").show();  
      if(chkval=="0")
      {
        $('#secure_modules').show();              
      }    
    }else
    {
      $("#secure_category").hide();  
      $("#secure_keywords").hide(); 
      $("#secure_section").hide();  
      $('#secure_modules').hide();          
    }   
        
        
 });
        
 $('input[name="PublicityAds\\[AFFICHER_ACCUEIL\\]"]').on('ifChecked', function(event){
    var chkval = $('input[name="PublicityAds\\[AFFICHER_ACCUEIL\\]"]:checked').val();
    var securityzone = $("#PublicityAds_ZONE_AFFICHAGE").val();   
   if(chkval=="0" && securityzone=="2")
   {
        $('#secure_modules').show();              
   }else 
   {
       $('#secure_modules').hide();  
   }    
});     
        
        
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