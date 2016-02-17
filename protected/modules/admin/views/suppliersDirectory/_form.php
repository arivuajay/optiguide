<?php
/* @var $this SuppliersDirectoryController */
/* @var $model SuppliersDirectory */
/* @var $form CActiveForm */
?>

<div class="row">
    <div class="col-lg-12 col-xs-12">
        <?php
        $cs_pos_end = CClientScript::POS_END;
        $themeUrl = $this->themeUrl;

        if ($model->ID_FOURNISSEUR) {
            $actn_url = Yii::app()->createUrl('/admin/suppliersDirectory/update', array('id' => $model->ID_FOURNISSEUR));
        } else {
            $actn_url = Yii::app()->createUrl('/admin/suppliersDirectory/create/');
        }
        //check if session exists
        if (Yii::app()->user->hasState("scountry")) {
            //get session variable
            $scountry = Yii::app()->user->getState("scountry");
            $model->country = $scountry;
            $sregion = Yii::app()->user->getState("sregion");
            $model->region = $sregion;
        }
        $suppliertypes = CHtml::listData(SupplierType::model()->findAll(), 'ID_TYPE_FOURNISSEUR', 'TYPE_FOURNISSEUR_FR');
        $country = Myclass::getallcountries();
        $regions = Myclass::getallregions_client($model->country,2);
        $cities = Myclass::getallcities($model->region);
        $archivecats = CHtml::listData(ArchiveCategory::model()->findAll(array("order" => 'NOM_CATEGORIE_FR')), 'ID_CATEGORIE', 'NOM_CATEGORIE_FR');

        $ficherid = $model->iId_fichier;
        $categoryid = 0;
        $ficherimage = '';
        if ($ficherid > 0) {
            $fichres = ArchiveFichier::model()->find("ID_FICHIER=$ficherid");
            $categoryid = $fichres->ID_CATEGORIE;
            $ficherfile = $fichres->FICHIER;
            // $fileurl     =  $themeUrl.'/img/archivage/'.$categoryid.'/'.$ficherfile; 
            $fileurl = Yii::app()->createAbsoluteUrl("/uploads/archivage/" . $categoryid . "/" . $ficherfile);

            if (!file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/archivage/' . $categoryid . '/' . $ficherfile)) {
                $fileurl = Yii::app()->createAbsoluteUrl("/uploads/archivage/noimage.png");
            }
        } else {
            $fileurl = "javascript:void(0);";
        }

        $paymentcounts = 0;
        if ($model->ID_FOURNISSEUR) {
            $paymentcounts = PaymentTransaction::model()->count("NOMTABLE='suppliers' AND user_id=" . $model->ID_FOURNISSEUR);
        }
        ?>
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a id="a_tab_1" href="#tab_1" data-toggle="tab">Renseignements généraux</a></li>
                <li><a id="a_tab_2" href="#tab_2" <?php
                    if (Yii::app()->user->hasState("secondtab")) {
                        echo 'data-toggle="tab"';
                    } elseif ($model->ID_FOURNISSEUR) {
                        echo 'data-toggle="tab"';
                    }
                    ?>>Sélection des produits</a></li>
                <li><a id="a_tab_3" href="#tab_3" <?php
                    if (Yii::app()->user->hasState("thirdtab")) {
                        echo 'data-toggle="tab"';
                    } elseif ($model->ID_FOURNISSEUR) {
                        echo 'data-toggle="tab"';
                    }
                    ?>>Sélection des marques</a></li>
                <li><a id="a_tab_4" href="#tab_4" <?php
                    if (Yii::app()->user->hasState("fourthtab")) {
                        echo 'data-toggle="tab"';
                    } elseif ($model->ID_FOURNISSEUR) {
                        echo 'data-toggle="tab"';
                    }
                    ?>>Subscription Payment</a></li>
                    <?php if ($paymentcounts > 0) { ?>
                    <li><a id="a_tab_5" href="#tab_5" data-toggle="tab">Payment Transactions</a></li>
                <?php } ?>
            </ul>

            <div class="tab-content">                
                <div class="tab-pane active" id="tab_1">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'suppliers-directory-form',
                        'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data'),
                        'action' => $actn_url,
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                        ),
                        'enableAjaxValidation' => true,
                    ));
                    ?>
                    <div class="box box-primary">                        
                        <div class="col-lg-5">
                            <div class="box-header">
                                <h3 class="box-title">Général</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <?php echo $form->labelEx($model, 'ID_TYPE_FOURNISSEUR', array()); ?>                                                        
                                    <?php echo $form->dropDownList($model, 'ID_TYPE_FOURNISSEUR', $suppliertypes, array('class' => 'form-control')); ?>                          
                                    <?php echo $form->error($model, 'ID_TYPE_FOURNISSEUR'); ?>                                   
                                </div>

                                <div class="form-group">
                                    <?php echo $form->labelEx($model, 'COMPAGNIE', array()); ?>
                                    <?php echo $form->textField($model, 'COMPAGNIE', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                                    <?php echo $form->error($model, 'COMPAGNIE'); ?>
                                </div>
                                
                                <?php
                                if (!$model->isNewRecord) {
                                ?>  
                                <div class="form-group">                                   
                                    <?php echo $form->labelEx($model, 'ID_CLIENT', array()); ?>                                                            
                                    <?php echo $model->ID_CLIENT; ?> 
                                </div>
                                <?php
                                }
                                ?>

                                <div class="form-group">
                                    <?php echo $form->labelEx($model, 'country', array()); ?>                                                         
                                    <?php echo $form->dropDownList($model, 'country', $country, array('class' => 'form-control', 'empty' => Myclass::t('APP43'))); ?>                          
                                    <?php echo $form->error($model, 'country'); ?>
                                </div>

                                <div class="form-group">
                                    <?php echo $form->labelEx($model, 'region', array()); ?>
                                    <?php echo $form->dropDownList($model, 'region', $regions, array('class' => 'form-control', 'empty' => Myclass::t('APP44'))); ?>                          
                                    <?php echo $form->error($model, 'region'); ?>
                                </div>

                                <div class="form-group">
                                    <?php echo $form->labelEx($model, 'ID_VILLE', array()); ?>
                                    <?php echo $form->dropDownList($model, 'ID_VILLE', $cities, array('class' => 'form-control', 'empty' => Myclass::t('APP59'))); ?>   
                                    <?php echo $form->error($model, 'ID_VILLE'); ?>
                                </div>
                                <div class="form-group" id="other_city" style="display:none;">
                                        <?php echo $form->labelEx($model, 'autre_ville', array()); ?>
                                        <?php echo $form->textField($model, 'autre_ville', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>   
                                        <?php echo $form->error($model, 'autre_ville'); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo $form->labelEx($model, 'ADRESSE', array()); ?>
                                    <?php echo $form->textField($model, 'ADRESSE', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                                    <?php echo $form->error($model, 'ADRESSE'); ?>
                                </div>

                                <div class="form-group">
                                    <?php echo $form->labelEx($model, 'ADRESSE2', array()); ?>
                                    <?php echo $form->textField($model, 'ADRESSE2', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                                    <?php echo $form->error($model, 'ADRESSE2'); ?>
                                </div>


                                <div class="form-group">
                                    <?php echo $form->labelEx($model, 'CODE_POSTAL', array()); ?>
                                    <?php echo $form->textField($model, 'CODE_POSTAL', array('class' => 'form-control', 'size' => 20, 'maxlength' => 20)); ?>
                                    <?php echo $form->error($model, 'CODE_POSTAL'); ?>
                                </div>

                                <div class="form-group">
                                    <?php echo $form->labelEx($model, 'TELEPHONE', array()); ?>
                                    <?php echo $form->textField($model, 'TELEPHONE', array('class' => 'form-control', 'size' => 20, 'maxlength' => 20)); ?>
                                    <?php echo $form->error($model, 'TELEPHONE'); ?>
                                </div>

                                <div class="form-group">
                                    <?php echo $form->labelEx($model, 'TELECOPIEUR', array()); ?>
                                    <?php echo $form->textField($model, 'TELECOPIEUR', array('class' => 'form-control', 'size' => 20, 'maxlength' => 20)); ?>
                                    <?php echo $form->error($model, 'TELECOPIEUR'); ?>
                                </div>

                                <div class="form-group">
                                    <?php echo $form->labelEx($model, 'COURRIEL', array()); ?>
                                    <?php echo $form->textField($model, 'COURRIEL', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                                    <?php echo $form->error($model, 'COURRIEL'); ?>
                                </div>

                                <div class="form-group">
                                    <?php echo $form->labelEx($model, 'SITE_WEB', array()); ?>
                                    <?php echo $form->textField($model, 'SITE_WEB', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>(http://www.monsite.com )
                                    <?php echo $form->error($model, 'SITE_WEB'); ?>
                                </div>

                                <div class="form-group">
                                    <?php echo $form->labelEx($model, 'archivecat', array()); ?>
                                    <?php echo $form->dropDownList($model, 'archivecat', $archivecats, array('class' => 'form-control', 'options' => array($categoryid => array('selected' => true)))); ?>                          
                                    <?php echo $form->error($model, 'archivecat'); ?>

                                </div>

                                <div class="form-group">
                                    <?php $fichercats = array("0" => "Aucune"); ?>
                                    <?php echo $form->labelEx($model, 'iId_fichier', array()); ?>                                   
                                    <?php echo $form->dropDownList($model, 'iId_fichier', $fichercats, array('class' => 'form-control', 'options' => array($ficherid => array('selected' => true)))); ?>    
                                    <a href="<?php echo $fileurl; ?>" class="viewficherfile"><img src="<?php echo $themeUrl . '/img/preview.gif'; ?>"></a>
                                    <?php echo $form->error($model, 'iId_fichier'); ?>
                                </div>

                                <div class="form-group">
                                    <?php echo $form->labelEx($model, 'TEL_SANS_FRAIS', array()); ?>
                                    <?php echo $form->textField($model, 'TEL_SANS_FRAIS', array('class' => 'form-control', 'size' => 20, 'maxlength' => 20)); ?>
                                    <?php echo $form->error($model, 'TEL_SANS_FRAIS'); ?>
                                </div>

                                <div class="form-group">
                                    <?php echo $form->labelEx($model, 'TEL_SECONDAIRE', array()); ?>
                                    <?php echo $form->textField($model, 'TEL_SECONDAIRE', array('class' => 'form-control', 'size' => 20, 'maxlength' => 20)); ?>
                                    <?php echo $form->error($model, 'TEL_SECONDAIRE'); ?>
                                </div>

                                <div class="form-group"> 
                                    <?php echo $form->labelEx($model, 'pfile', array()); ?>                  
                                    <?php echo $form->fileField($model, 'pfile'); ?>                         
                                    <?php echo $form->error($model, 'pfile'); ?>                                    
                                </div>
                                <?php
                                if ($model->proof_file != '') {
                                    $file_url = Yii::app()->getBaseUrl(true) . '/uploads/user_proofs/' . $model->proof_file;
                                    ?>   
                                    <div class="form-group">    
                                        <a href="<?php echo $file_url; ?>" target="_blank">Click to view the proof</a> 
                                        &nbsp;&nbsp;
                                        <?php
                                        echo CHtml::link('( <i class="fa fa-remove"></i> )', array('/admin/suppliersDirectory/deleteProof', 'id' => $model->ID_FOURNISSEUR, 'file_name' => $model->proof_file), array('confirm' => 'Are you sure?'));
                                        ?>
                                    </div>
                                <?php }
                                ?>
                                                <?php
                                if (!$model->isNewRecord) {
                                    ?>
                                <div class="form-group"> 
                                    <?php echo $form->labelEx($model, 'DATE_MODIFICATION', array()); ?>: 
                                        <?php echo $model->DATE_MODIFICATION; ?>
                                </div>
                                <div class="form-group"> 
                                    <?php echo $form->labelEx($model, 'CREATED_DATE', array()); ?>: 
                                        <?php echo $model->CREATED_DATE; ?>
                                </div>
                                <?php } ?>
                                <div class="box-header">
                                    <h3 class="box-title">Visualisation</h3>
                                </div>
                                <div class="box-body">
                                    <div class="form-group">
                                        <?php echo $form->labelEx($model, 'bAfficher_site', array()); ?>                                    
                                        <?php echo $form->radioButtonList($model, 'bAfficher_site', array('1' => 'Oui', '0' => 'Non'), array('separator' => ' ')); ?> 
                                    </div>
                                    <!--                                      <div class="form-group">
                                    <?php //echo $form->labelEx($umodel, 'MUST_VALIDATE', array()); ?>      
                                    <?php //echo $form->radioButtonList($umodel, 'MUST_VALIDATE', array('1' => 'Oui', '0' => 'Non'), array('separator' => ' '));  ?> 
                                                                        </div>-->
                                    <?php //echo $form->hiddenField($umodel,'bSubscription_envision');  ?>
                                    <?php //echo $form->hiddenField($umodel,'bSubscription_envue');  ?>
                                    <?php //echo $form->hiddenField($umodel,'ABONNE_MAILING');  ?>
                                    <?php //echo $form->hiddenField($umodel,'ABONNE_PROMOTION');  ?>
                                </div>    
                            </div>
                        </div>
                        <div class="col-lg-1"></div>
                        <div class="col-lg-5">
                            <div class="box-header">
                                <h3 class="box-title">Information</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <?php echo $form->labelEx($model, 'SUCCURSALES', array()); ?>                                    
                                    <?php echo $form->textField($model, 'SUCCURSALES', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                                    <?php echo $form->error($model, 'SUCCURSALES'); ?>
                                </div>

                                <div class="form-group">
                                    <?php echo $form->labelEx($model, 'ETABLI_DEPUIS', array()); ?>                                   
                                    <?php echo $form->textField($model, 'ETABLI_DEPUIS', array('class' => 'form-control', 'size' => 20, 'maxlength' => 20)); ?>
                                    <?php echo $form->error($model, 'ETABLI_DEPUIS'); ?>                                   
                                </div>

                                <div class="form-group">
                                    <?php echo $form->labelEx($model, 'NB_EMPLOYES', array()); ?>                                  
                                    <?php echo $form->textField($model, 'NB_EMPLOYES', array('class' => 'form-control', 'size' => 10, 'maxlength' => 10)); ?>
                                    <?php echo $form->error($model, 'NB_EMPLOYES'); ?>                                    
                                </div>
                            </div>
                            <div class="box-header">
                                <h3 class="box-title">Personnel</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <?php echo $form->labelEx($model, 'PERSONNEL_NOM1', array()); ?>                                    
                                    <?php echo $form->textField($model, 'PERSONNEL_NOM1', array('class' => 'form-control', 'size' => 60)); ?>
                                    <?php echo $form->error($model, 'PERSONNEL_NOM1'); ?>
                                </div>

                                <div class="form-group">
                                    <?php echo $form->labelEx($model, 'PERSONNEL_TITRE1', array()); ?>                                   
                                    <?php echo $form->textField($model, 'PERSONNEL_TITRE1', array('class' => 'form-control', 'size' => 60)); ?>
                                    <?php echo $form->error($model, 'PERSONNEL_TITRE1'); ?>                                   
                                </div>

                                <div class="form-group">
                                    <?php echo $form->labelEx($model, 'PERSONNEL_TITRE1_EN', array()); ?>                                  
                                    <?php echo $form->textField($model, 'PERSONNEL_TITRE1_EN', array('class' => 'form-control', 'size' => 60)); ?>
                                    <?php echo $form->error($model, 'PERSONNEL_TITRE1_EN'); ?>                                    
                                </div>
                                <div class="form-group">
                                    <?php echo $form->labelEx($model, 'PERSONNEL_NOM2', array()); ?>                                    
                                    <?php echo $form->textField($model, 'PERSONNEL_NOM2', array('class' => 'form-control', 'size' => 60)); ?>
                                    <?php echo $form->error($model, 'PERSONNEL_NOM2'); ?>
                                </div>

                                <div class="form-group">
                                    <?php echo $form->labelEx($model, 'PERSONNEL_TITRE2', array()); ?>                                   
                                    <?php echo $form->textField($model, 'PERSONNEL_TITRE2', array('class' => 'form-control', 'size' => 60)); ?>
                                    <?php echo $form->error($model, 'PERSONNEL_TITRE2'); ?>                                   
                                </div>

                                <div class="form-group">
                                    <?php echo $form->labelEx($model, 'PERSONNEL_TITRE2_EN', array()); ?>                                  
                                    <?php echo $form->textField($model, 'PERSONNEL_TITRE2_EN', array('class' => 'form-control', 'size' => 60)); ?>
                                    <?php echo $form->error($model, 'PERSONNEL_TITRE2_EN'); ?>                                    
                                </div>
                                <div class="form-group">
                                    <?php echo $form->labelEx($model, 'PERSONNEL_NOM3', array()); ?>                                    
                                    <?php echo $form->textField($model, 'PERSONNEL_NOM3', array('class' => 'form-control', 'size' => 60)); ?>
                                    <?php echo $form->error($model, 'PERSONNEL_NOM3'); ?>
                                </div>

                                <div class="form-group">
                                    <?php echo $form->labelEx($model, 'PERSONNEL_TITRE3', array()); ?>                                   
                                    <?php echo $form->textField($model, 'PERSONNEL_TITRE3', array('class' => 'form-control', 'size' => 60)); ?>
                                    <?php echo $form->error($model, 'PERSONNEL_TITRE3'); ?>                                   
                                </div>

                                <div class="form-group">
                                    <?php echo $form->labelEx($model, 'PERSONNEL_TITRE3_EN', array()); ?>                                  
                                    <?php echo $form->textField($model, 'PERSONNEL_TITRE3_EN', array('class' => 'form-control', 'size' => 60)); ?>
                                    <?php echo $form->error($model, 'PERSONNEL_TITRE3_EN'); ?>                                    
                                </div>
                            </div>
                            <div class="box-header">
                                <h3 class="box-title">Régions dans lesquelles ce fournisseur offre ses services</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <?php echo $form->labelEx($model, 'REGIONS_FR', array()); ?>                                    
                                    <?php echo $form->textArea($model, 'REGIONS_FR', array('class' => 'form-control', 'maxlength' => 1000, 'rows' => 5, 'cols' => 50)); ?>
                                    <?php echo $form->error($model, 'REGIONS_FR'); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo $form->labelEx($model, 'REGIONS_EN', array()); ?>                                    
                                    <?php echo $form->textArea($model, 'REGIONS_EN', array('class' => 'form-control', 'maxlength' => 1000, 'rows' => 5, 'cols' => 50)); ?>
                                    <?php echo $form->error($model, 'REGIONS_EN'); ?>
                                </div>
                            </div>    
                        </div>                        
                    </div>
                    <div class="box-footer">
                        <div class="form-group">
                            <div class="col-lg-12">
                                <?php echo CHtml::submitButton($model->isNewRecord ? 'Ajouter ce fournisseur et passer à l\'étape suivante' : 'Modifier ce fournisseur', array('class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary')); ?>
                            </div>
                        </div>
                    </div>
                    <?php $this->endWidget(); ?>
                </div>
                <div class="tab-pane" id="tab_2">
                    <?php
                    $this->renderPartial('_section_products_form', array('model' => $model, 'form' => $form));
                    ?>
                </div>
                <div class="tab-pane" id="tab_3">
                    <?php
                    $this->renderPartial('_products_marques_form', array('model' => $model, 'form' => $form, 'data_products' => $data_products));
                    ?>
                </div>  

                <div class="tab-pane" id="tab_4">
                    <?php
                    $this->renderPartial('_payment_form', array('model' => $model, 'form' => $form, 'data_products' => $data_products, 'pmodel' => $pmodel));
                    ?>
                </div>  

                <div class="tab-pane" id="tab_5">
                    <?php
                    $this->renderPartial('_payment_transactions', array('model' => $model, 'form' => $form, 'data_products' => $data_products, 'pmodel' => $pmodel));
                    ?>
                </div>  

            </div>


        </div>
    </div>
</div>
<?php
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($themeUrl . '/js/pair-select.min.js', $cs_pos_end);
$ajaxRegionUrl = Yii::app()->createUrl('/admin/suppliersDirectory/getregions');
$ajaxCityUrl = Yii::app()->createUrl('/admin/suppliersDirectory/getcities');
$ajaxFicherUrl = Yii::app()->createUrl('/admin/suppliersDirectory/getfichers');
$ajaxFetchimage = Yii::app()->createUrl('/admin/suppliersDirectory/getficherimage');
$jsoncde = array();

if (Yii::app()->user->hasState("product_ids")) {
    $sess_product_ids = Yii::app()->user->getState("product_ids");
    $jsoncde = json_encode($sess_product_ids);
}

$ajaxproducts = Yii::app()->createUrl('/admin/suppliersDirectory/getproducts');

$pay_type = isset($pmodel->pay_type) ? $pmodel->pay_type : 1;
$ctyval = isset($model->ID_VILLE)?$model->ID_VILLE:'';
$js = <<< EOD
    $(document).ready(function(){
   
// Tabs display    
    $("#a_tab_{$tab}").trigger('click');     
   
// Display the products in multiselect box based on slected category     
    var varray = {$jsoncde}; 
    
    $("#SuppliersDirectory_IDSECTION").change(function(){
        var id=$(this).val();
        var dataString = 'id='+ id;
    
        $.ajax({
            type: "POST",
            url: '{$ajaxproducts}',
            data: dataString,
            cache: false,
            success: function(html){             
                $("#MasterSelectBox").html(html);
                $('#MasterSelectBox').pairMaster();
              
                if(varray.length>0)
                {
                    for (var i = 0; i < varray.length; i++) {
                        var mval = varray[i];                      
                        $("#MasterSelectBox option[value="+mval+"]").remove();
                     }
                }
            
               // Hide the selected values from MasterSelectBox box
                $("#SuppliersDirectory_Products2 option").map(function () {
                     var sval = this.value;
                    $("#MasterSelectBox option[value="+sval+"]").remove();
                });
            }
         });
    }); 
 
// Add the products from multislect box            
    $('#Addmarque').click(function(){
            $('#MasterSelectBox').addSelected('#SuppliersDirectory_Products2');
    });

// Remove the products from multislect box   
    $('#Removemarque').click(function(){
            $('#SuppliersDirectory_Products2').removeSelected('#MasterSelectBox'); 
    });   
 
// Get region for seleted country   
    $("#SuppliersDirectory_country").change(function(){
        var id=$(this).val();
        var dataString = 'id='+ id;
         
        $.ajax({
            type: "POST",
            url: '{$ajaxRegionUrl}',
            data: dataString+'&client_disp=2',
            cache: false,
            success: function(html){             
                $("#SuppliersDirectory_region").html(html);
            }
         });
    });
   
// Get cities for seleted region
   $("#SuppliersDirectory_region").change(function(){
        var id=$(this).val();
        var dataString = 'id='+ id;
            
        $.ajax({
            type: "POST",
            url: '{$ajaxCityUrl}',
            data: dataString,
            cache: false,
            success: function(html){             
                $("#SuppliersDirectory_ID_VILLE").html(html);
            }
         });

    });  

    var ctyval = "{$ctyval}";
    if(ctyval=="-1")
    {    
        $("#other_city").show();
    }     
            
   $("#SuppliersDirectory_ID_VILLE").change(function(){
        var id=$(this).val();
            
        $("#other_city").hide();
        if(id=="-1")
        {    
            $("#other_city").show();
        }    
    }); 
    
// Get the fichers list based on selected ficher category
   var vficherid = {$ficherid};
   var vcatid = {$categoryid}; 
   
     $("#SuppliersDirectory_archivecat").change(function(e){
        var id=$(this).val();
        var dataString = 'id='+ id;
        $.ajax({
            type: "POST",
            url: '{$ajaxFicherUrl}',
            data: dataString,
            cache: false,
            success: function(html){             
                $("#SuppliersDirectory_iId_fichier").html(html);
                if(e.isTrigger)
                $("#SuppliersDirectory_iId_fichier").val(vficherid);                
            }
         });
    }); 

// Trigger the dropdown event on form load if the catid value exist   
    if(vcatid > 0)
    {
        $('#SuppliersDirectory_archivecat').trigger('change');           
    }

// Get the ficher file on select the ficher dropdown.
    $("#SuppliersDirectory_iId_fichier").change(function(e){
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
 
// Select all checkboxes for delete products.   
    $('#selecctall').click(function(event) {  //on click        
        if(this.checked) { // check select status
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"              
            });
        }else{
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                      
            });        
        }
    });  
        
// Check to change check payment type
    $('input[name="PaymentCheques\\[pay_type\\]"]').on('ifChecked', function(event){
     var chkval = $('input[name="PaymentCheques\\[pay_type\\]"]:checked').val();
     
      $("#by_cheque").hide();
      $("#by_free").hide() ; 
      if(chkval=="2")            
      {
          $("#by_cheque").show() ; 
      }else
      {
          $("#by_free").show() ;                 
      }    
            
    });  
            
    var pay_type = {$pay_type};        
    if(pay_type==2)
    {
       $("#by_cheque").show() ;  
    }else
    {
        $("#by_free").show() ;                 
    }  
            
});
EOD;
Yii::app()->clientScript->registerScript('_form', $js);
?>