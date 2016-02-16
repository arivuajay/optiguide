<?php
$disppage = Yii::app()->request->getParam('disppage');
if ($disppage == "home") {
    $this->renderPartial('_search', array('searchModel' => $searchModel));
} else if ($disppage == "category") {
    $this->renderPartial('_search_cat', array('searchModel' => $searchModel));
}
$lang = Yii::app()->session['language'];

 $cur_date = strtotime("now");
 
if ($model['profile_expirydate'] != '') {
    $expdate  = strtotime($model['profile_expirydate']);   
    $disp = ($expdate > $cur_date) ? 1 : 0;
} else {
    $disp = 0;
}

if ($model['logo_expirydate'] != '') {
    $l_expdate = strtotime($model['logo_expirydate']);  
    $ldisp = ($l_expdate > $cur_date) ? "1" : "0";  
} else {
    $ldisp = 0;
}


?>

<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">  
        <div class="inner-container eventslist-cont">            
            <h2> <?php echo $model['COMPAGNIE']; ?> </h2>
            <div class="row"> 

                <?php               
                if ($model['ID_CATEGORIE'] > 0 && $ldisp=="1") {
                    $extypes = array('jpg', 'jpeg', 'png', 'gif', 'bmp');
                    $img_ext = $model['EXTENSION'];
                    $siteweb = $model['SITE_WEB'];
                    if (in_array($img_ext, $extypes)) {
                        $img_url = Yii::app()->getBaseUrl(true) . '/uploads/archivage/' . $model['ID_CATEGORIE'] . '/' . $model['FICHIER'];
                        ?>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 brand-logo">
                            <?php
                            if($siteweb!="")
                            {?>  
                               <a target="_blank" href="<?php echo $siteweb;?>" ><img src="<?php echo $img_url; ?>" width="200" height="200" alt=""></a> 
                            <?php
                            }else{?>
                                <img src="<?php echo $img_url; ?>" width="200" height="200" alt="">     
                            <?php   
                            } ?>    
                            </div>
                        <?php
                    }
                }
                ?>

                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">  
                    <div class="search-list ">
                        <h2><?php echo Myclass::t('OG071', '', 'og'); ?> </h2>
                        <div class="clearfix"></div>                     
                        <p> 
                            <?php echo $model['ADRESSE']; ?> <br/> 
                            <?php echo $model['NOM_VILLE']; ?>,  <?php echo $model['NOM_REGION_' . $lang]; ?><br/> 
                            <?php echo $model['NOM_PAYS_' . $this->lang]; ?><br/> 
                            <?php echo $model['CODE_POSTAL']; ?>
                        </p>
                        <?php if ($disp == 1) { ?>
                            <p>
                                <?php echo Myclass::t('OG041', '', 'og'); ?> : <?php echo $model['TELEPHONE']; ?><br>                       
                                <?php
                                if ($model['TELECOPIEUR'] != '') {
                                    echo Myclass::t('OG042', '', 'og') . ' : ' . $model['TELECOPIEUR'] . '<br>';
                                }
                                ?>                            
                                <?php
                                if ($model['TEL_SANS_FRAIS'] != '') {
                                    echo Myclass::t('OG068', '', 'og') . ' : ' . $model['TEL_SANS_FRAIS'] . '<br>';
                                }
                                ?>
                                <?php
                                if ($model['TEL_SECONDAIRE'] != '') {
                                    echo Myclass::t('OG069', '', 'og') . ' : ' . $model['TEL_SECONDAIRE'];
                                }
                                ?>                          
                            </p>                                                   
                            <p>
                                <?php
                                if ($model['COURRIEL'] != '') {
                                    echo Myclass::t('APP6');
                                    ?> : <a href="mailto:<?php echo $model['COURRIEL']; ?>"><?php echo $model['COURRIEL'] . '<br>'; ?></a>
                                <?php } ?>
                                <?php
                                if ($model['SITE_WEB'] != '') {
                                    echo Myclass::t('APP76');
                                    ?> : <a href="<?php echo $model['SITE_WEB']; ?>" target="_blank"><?php echo $model['SITE_WEB']; ?></a>
                                <?php } ?>  
                            </p>
                        <?php } ?>
                    </div>
                </div>


                <?php if ($disp == 1) { ?>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">  
                        <div class="search-list company-infom">
                            <h2><?php echo Myclass::t('OG072', '', 'og'); ?> </h2>
                            <p><?php
                                if ($model['SUCCURSALES'] != '') {
                                    echo "<b>" . Myclass::t('OG130') . "</b> : " . $model['SUCCURSALES'] . "<br/>";
                                }
                                echo "<b>" . Myclass::t('OG102') . "</b> : " . $model['TYPE_FOURNISSEUR_' . $lang] . "<br/>";
                                if ($model['ETABLI_DEPUIS'] != '') {
                                    echo "<b>" . Myclass::t('OG128') . "</b> : " . $model['ETABLI_DEPUIS'] . "<br/>";
                                }
                                if ($model['NB_EMPLOYES'] != '') {
                                    echo "<b>" . Myclass::t('OG129') . "</b> : " . $model['NB_EMPLOYES'] . "<br/>";
                                }
                                ?>                            
                            </p> 
                            <?php
                            $firstname = "";
                            $secondname = "";
                            $thirdname = "";
                            $name1 = $model['PERSONNEL_NOM1'];
                            $title1_fr = $model['PERSONNEL_TITRE1'];
                            $title1_en = $model['PERSONNEL_TITRE1_EN'];
                            $name2 = $model['PERSONNEL_NOM2'];
                            $title2_fr = $model['PERSONNEL_TITRE2'];
                            $title2_en = $model['PERSONNEL_TITRE2_EN'];
                            $name3 = $model['PERSONNEL_NOM3'];
                            $title3_fr = $model['PERSONNEL_TITRE3'];
                            $title3_en = $model['PERSONNEL_TITRE3_EN'];

                            if ($name1 != '' || $name2 != '' || $name3 != '') {
                                ?>    
                                <b><?php echo Myclass::t('OG131'); ?></b> 
                                <ul>                        
                                    <?php
                                    if ($name1 != '') {
                                        $information1 = ($lang == "EN") ? $title1_en : $title1_fr;
                                        echo $firstname = "<li>" . $name1 . " , " . $information1 . "</li>";
                                    }
                                    if ($name2 != '') {
                                        $information2 = ($lang == "EN") ? $title2_en : $title2_fr;
                                        echo $secondname = "<li>" . $name2 . " , " . $information2 . "</li>";
                                    }
                                    if ($name3 != '') {
                                        $information3 = ($lang == "EN") ? $title3_en : $title3_fr;
                                        echo $thirdname = "<li>" . $name3 . " , " . $information3 . "</li>";
                                    }
                                    ?>
                                </ul>
                                <?php
                            }
                            ?>

                            <?php
                            if ($model['REGIONS_' . $lang] != '') {
                                echo "<p><b>" . Myclass::t('OG070', '', 'og') . "</b> <br/>" . $model['REGIONS_' . $lang] . "</p>";
                            }
                            ?>
                        </div>
                    </div>
                     <?php
                    if (!empty($supplierproducts)) {?>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scroll-cont brands">  
                        <h2> <?php echo Myclass::t('OG073', '', 'og'); ?> </h2> 
                        <div class="box" id="box1">
                            <div class="brands">                         
                                <ul>
                                   <?php
                                        foreach ($supplierproducts as $pkey => $products) {
                                            $exp_key = explode('~', $pkey);
                                            ?>    
                                            <li class="noBorder"><?php echo $exp_key[1]; ?>
                                                <?php
                                                if (!empty($products)) {
                                                    ?>    
                                                    <ul>
                                                        <?php
                                                        foreach ($products as $brand) {
                                                            ?>
                                                            <li class="noBorder"><?php echo $brand['NOM_MARQUE']; ?></li>       
                                                        <?php }
                                                        ?>
                                                    </ul>    
                                                <?php }
                                                ?>  
                                            </li>                                                        
                                            <?php
                                        }                                    
                                    ?>
                                </ul>
                                <p>&nbsp;</p>
                            </div>
                        </div>
                    </div>   
                    <?php
                    }    ?>
                    <?php if (!empty($results)) { ?>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scroll-cont brands">  
                            <h2> <?php echo Myclass::t('OGO181', '', 'og'); ?> </h2> 
                            <div class="repbox" id="repbox">
                                <div class="brands">   
                                    <ul>
                                        <?php foreach ($results as $info) {
                                          
                                               $rep_profile_firstname = ""; 
                                               if($info['rep_profile_firstname']!="")
                                                $rep_profile_firstname =  ucfirst($info['rep_profile_firstname']);  
                                               
                                               $rep_profile_lastname = ""; 
                                               if($info['rep_profile_lastname']!="")
                                                $rep_profile_lastname =  ucfirst($info['rep_profile_lastname']); 
                                               
                                              ?>
                                            <li>
                                                <?php
                                                $dispname = $rep_profile_firstname." ".$rep_profile_lastname.", ".$info['NOM_VILLE'].", ".$info['ABREVIATION_EN'].", ".$info['NOM_PAYS_EN'];
                                                echo $dispname;
                                                ?>
                                                <?php
                                                if($info['rep_territories']!= ""){ ?>
                                                <br>
                                                <b>Territories :</b> <?php echo $info['rep_territories'];?>
                                                <?php } ?>
                                                <?php
                                                if($info['rep_brands']!= "")
                                                {
                                                    $prd_marque_ids = $info['rep_brands'];
                                                    $marqueinfos = MarqueDirectory::model()->findAll(array('condition'=>"ID_MARQUE IN ($prd_marque_ids)",'order'=>'NOM_MARQUE ASC'));

                                                    foreach ($marqueinfos as $minfo)
                                                    {
                                                       $mnames[] = $minfo->NOM_MARQUE;
                                                    }  

                                                    if(!empty($mnames))
                                                    {
                                                        $marque_names = implode(' , ',$mnames);
                                                    }
                                                ?>
                                                <br>
                                                <b>Brands :</b> <?php echo $marque_names;?>
                                                <?php 
                                                } ?>
                                            <?php
                                            echo $sess_id    = Yii::app()->user->id;
                                            if( isset(Yii::app()->user->role) && ( Yii::app()->user->role == "Professionnels" || Yii::app()->user->role == "Fournisseurs" || Yii::app()->user->role == "Detaillants")  )
                                            {    
                                            ?>    
                                                <br>
                                           <?php echo CHtml::link('<i class="fa fa-mail-forward"></i> ' . Myclass::t('OR621', '', 'or'), array('#'), array("class" => "addfav-btn", "data-toggle" => "modal", "id"=>"msgtrigger_".$info['ID_UTILISATEUR'], "data-target" => "#sendmessage" ,"data-uid"=>$info['ID_UTILISATEUR'] , "data-nom"=> ucwords($info['NOM_UTILISATEUR']) )); ?>
                                           <?php 
                                            } ?>                            
                                        </li>
                                        <?php } ?>                       
                                    </ul>               
                                    <p>&nbsp;</p>
                                </div>
                            </div>
                        </div>  
                    <?php } ?>         

                <?php } ?>

            </div>             
        </div>
        <p class="backbtn">
            <?php 
                $pre_url=Yii::app()->request->urlReferrer; 
                $marqueids=Yii::app()->request->getParam('marqueid');
                    if(empty($pre_url)){
                        if ($disppage == "category") {
                            echo CHtml::link( Myclass::t('OG016', '', 'og'), array('/optiguide/suppliersDirectory/category'), array("class" => "basic-btn"));   
                        }else if (empty($marqueids))  {
                            echo CHtml::link( Myclass::t('OG016', '', 'og'), array('/optiguide/suppliersDirectory'), array("class" => "basic-btn"));   
                        }else{
                            echo CHtml::link( Myclass::t('OG016', '', 'og'), array('/optiguide/marqueDirectory'), array("class" => "basic-btn"));   
                        }
              ?>
              <?php }else{?>
                  <a class='basic-btn' href="<?php echo $pre_url; ?>"><?php echo Myclass::t('OG016', '', 'og');?>  </a>
              <?php }?>
        </p>   
        <?php //echo CHtml::link(Myclass::t('OG016', '', 'og'), array('/optiguide/suppliersDirectory'), array('class' => 'basic-btn')); ?>
    </div>
</div>

<!-- Send Message Modal Box-->
<div class="modal fade" id="sendmessage" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo Myclass::t('OR621', '', 'or') ?></h4>
            </div>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'send_message_form',
                'htmlOptions' => array('role' => 'form'),
                'action' => Yii::app()->createUrl('/optiguide/internalMessage/createnew'),
            ));
            ?>
            <div class="modal-body model-form">
                <div class="row"> 
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <label><?php echo Myclass::t('OR643', '', 'or') ?>: </label>   
                        <span id="repusername">&nbsp</span>                     
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <label><?php echo Myclass::t('OR624', '', 'or') ?> </label>    
                        <p>
                        <?php echo $form->textArea($internalmodel, 'message', array('class' => 'form-field-textarea', "id" => "messageval", 'maxlength' => 1000, 'rows' => 5, 'cols' => 50)); ?> 
                        </p>    
                        <div style="display:none;" class="errorMessage" id="message_error">
                            <?php echo Myclass::t('OR644', '', 'or') ?>
                        </div>
                    </div>
                </div>
            </div>            
            <?php echo $form->hiddenField($internalmodel, 'user2', array("id" => "user2")); ?>
            <input type="hidden" name="pagename" value="<?php echo $disppage;?>">
            <div class="modal-footer">
                <div class="pull-right">
                <?php
                echo CHtml::tag('button', array(
                    'name' => 'SendMessage',
                    'type' => 'submit',
                    'class' => 'submit-btn'
                        ), Myclass::t('OR639', '', 'or'));
                ?>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
<?php
$js = <<< EOD
$(document).ready(function(){
        $('.repbox').lionbars();
        
        
        $(".addfav-btn").click(function(){
            $("#message_error").hide();
        
            var uid = $(this).data("uid");
            var nom = $(this).data("nom");
            $("#repusername").html(nom);
            $("#user2").val(uid);
        })
        
        $('#send_message_form').on('submit', function() {
               
         var msgval= $("#messageval").val();      
         $("#message_error").hide();
         if(msgval=='')
         {
              $("#message_error").show();
              return false; 
         }    
    }); 
});
EOD;
Yii::app()->clientScript->registerScript('_form_listrep', $js);
?>