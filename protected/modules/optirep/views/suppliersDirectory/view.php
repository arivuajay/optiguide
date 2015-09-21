<div class="cate-bg user-right">
    <?php
    $disppage = Yii::app()->request->getParam('disppage');
    if ($disppage == "home") {
        $this->renderPartial('_search', array('searchModel' => $searchModel));
    } else if ($disppage == "category") {
        $this->renderPartial('_search_cat', array('searchModel' => $searchModel));
    }
    $lang = Yii::app()->session['language'];

    if ($model['expirydate'] != '') {
        $expdate = strtotime($model['expirydate']);
        $cur_date = strtotime("now");
        $disp = ($expdate > $cur_date) ? 1 : 0;
    } else {
        $disp = 0;
    }
    ?>
    <h2> <?php echo $model['COMPAGNIE']; ?> </h2>    
    <div class="row">
        <?php
        if ($model['ID_CATEGORIE'] > 0 && $disp==1) {
            $extypes = array('jpg', 'jpeg', 'png', 'gif', 'bmp');
            $img_ext = $model['EXTENSION'];
            if (in_array($img_ext, $extypes)) {
                $img_url = Yii::app()->getBaseUrl(true) . '/uploads/archivage/' . $model['ID_CATEGORIE'] . '/' . $model['FICHIER'];
                ?>
                <div class="col-xs-12 col-sm-7 col-md-8 col-lg-8 brand-logo">   <img src="<?php echo $img_url; ?>"  alt="">  </div>
                <?php
            }
        }
        ?>


        <!-- Contact information-->
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">  
            <div class="search-list">
                <h2><i class="fa fa-map-marker"></i> <?php echo Myclass::t('OG071', '', 'og'); ?> </h2>
                <div class="clearfix"></div>
                <p> 
                    <?php echo $model['ADRESSE']; ?>. <br/> 
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

                        if ($model['TEL_SANS_FRAIS'] != '') {
                            echo Myclass::t('OG068', '', 'og') . ' : ' . $model['TEL_SANS_FRAIS'] . '<br>';
                        }

                        if ($model['TEL_SECONDAIRE'] != '') {
                            echo Myclass::t('OG069', '', 'og') . ' : ' . $model['TEL_SECONDAIRE'] . '<br>';
                        }
                        ?>                          
                    </p>                                                   
                    <p>
                        <?php
                        if ($model['COURRIEL'] != '') {
                            echo Myclass::t('APP6');
                            ?> : <a href="mailto:<?php echo $model['COURRIEL']; ?>"><?php echo $model['COURRIEL']; ?></a><br/>
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

        <!--  Company information-->
        <?php if ($disp == 1) { ?>

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">  
                <div class="search-list">
                    <h2><i class="fa fa-building-o"></i>  <?php echo Myclass::t('OG072', '', 'og'); ?> </h2>
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

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scroll-cont brands">  
                <h2> <i class="fa fa-cubes"></i> <?php echo Myclass::t('OG073', '', 'og'); ?> </h2> 
                <div class="box" id="box1">
                    <div class="brands">
                        <p>
                        </p>
                        <ul>
                            <?php
                            if (!empty($supplierproducts)) {
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
                            }
                            ?>
                        </ul>
                        <p></p>
                    </div>
                </div>
            </div>

             <?php
             if (!empty($results)) {?>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scroll-cont brands">  
                <h2> <i class="fa fa-users"></i> <?php echo Myclass::t('OGO181', '', 'og'); ?> </h2> 
                <div class="repbox" id="repbox">
                    <div class="brands">
                        <p>
                        </p>
                        <ul>
                            <?php foreach ($results as $info) { ?>
                            <li>
                                <?php
                                $dispname = $info['rep_username'];
                                echo $dispname;
                                ?>
                            </li>
                            <?php } ?>                       
                        </ul>              
                        <p></p>
                    </div>
                </div>
            </div>
            <?php } ?>   

        <?php } ?>    

    </div>

    <div class="viewall"> <?php echo CHtml::link('<i class="fa fa-arrow-circle-left"></i> ' . Myclass::t('OG016', '', 'og'), array('/optirep/suppliersDirectory'), array("class" => "pull-left")); ?> </div>  
</div>
<?php
$js = <<< EOD
$(document).ready(function(){        
     $('.box').lionbars();    
     $('.repbox').lionbars();    
});
EOD;
Yii::app()->clientScript->registerScript('_form_view', $js);
?>