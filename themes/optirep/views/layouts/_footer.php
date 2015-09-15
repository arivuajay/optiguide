<div class="footer-cont">
    <div class="footer-row"> 
        <div class="container"> 
            <div class="row"> 
                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">  
                    <?php
                     $prof_query = Yii::app()->db->createCommand() //this query contains all the data
                        ->select('count(*) as profcount')
                        ->from(array('repertoire_specialiste rs', 'repertoire_specialiste_type rst', 'repertoire_ville AS rv', 'repertoire_region AS rr', 'repertoire_pays AS rp','repertoire_utilisateurs as ru'))
                        ->where("rs.ID_SPECIALISTE=ru.ID_RELATION AND rs.ID_TYPE_SPECIALISTE = rst.ID_TYPE_SPECIALISTE AND rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS and ru.status=1 AND ru.NOM_TABLE ='Professionnels' ")
                        ->queryAll();
                     $total_prof   = $prof_query[0]['profcount'];
                     $prof_display = Myclass::format_numbers_words($total_prof);
                    ?>
                    <?php echo CHtml::image("{$this->themeUrl}/images/footer-icon1.jpg", 'Footer Icon1') ?>
                    <h2>  <?php echo $prof_display;?> </h2>   <span>  Professionals </span>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3"> 
                    <?php
                    // Get all records list  with limit
                    $retail_query = Yii::app()->db->createCommand() //this query contains all the data
                    ->select('count(*) as retcount')
                    ->from(array('repertoire_retailer rs', 'repertoire_retailer_type rst','repertoire_ville AS rv' ,  'repertoire_region AS rr','repertoire_pays AS rp','repertoire_utilisateurs as ru'))
                    ->where("rs.ID_RETAILER=ru.ID_RELATION AND rs.ID_RETAILER_TYPE = rst.ID_RETAILER_TYPE AND rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS and ru.status=1 AND ru.NOM_TABLE ='Detaillants' ")
                    ->queryAll();
                    $total_retail   = $retail_query[0]['retcount'];
                    $retail_display = Myclass::format_numbers_words($total_retail);
                    ?>
                    <?php echo CHtml::image("{$this->themeUrl}/images/footer-icon2.jpg", 'Footer Icon2') ?>
                    <h2> <?php echo $retail_display;?> </h2>   <span>  Retailers  </span>
                </div>
                <div class="col-xs-12 col-sm-6 
                     col-md-3 col-lg-3">  
                    <?php
                     $supplier_query = Yii::app()->db->createCommand() //this query contains all the data
                        ->select('count(*) as suppcount')
                        ->from(array('repertoire_fournisseurs f', 'repertoire_fournisseur_type ft', 'repertoire_ville AS rv', 'repertoire_region AS rr', 'repertoire_pays AS rp'))
                        ->where("f.ID_TYPE_FOURNISSEUR = ft.ID_TYPE_FOURNISSEUR AND f.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS and bAfficher_site=1 ")
                        ->queryAll();
                     $total_supp   = $supplier_query[0]['suppcount'];
                     $supp_display = Myclass::format_numbers_words($total_supp); 
                    ?>
                     <?php echo CHtml::image("{$this->themeUrl}/images/footer-icon3.jpg", 'Footer Icon3') ?>
                    <h2>  <?php echo $supp_display;?></h2>  <span>  Suppliers </span>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">  
                    <?php
                    // Get all records list  with limit
                    $rep_query = Yii::app()->db->createCommand() //this query contains all the data
                    ->select('count(*) as retcount')
                    ->from(array('rep_credentials rs','repertoire_utilisateurs as ru'))
                    ->where("rs.rep_credential_id=ru.ID_RELATION AND ru.NOM_TABLE ='rep_credential'")
                    ->queryAll();
                    $total_rep   = $rep_query[0]['retcount'];
                    $rep_display = Myclass::format_numbers_words($total_rep);
                    ?>
                    <?php echo CHtml::image("{$this->themeUrl}/images/footer-icon4.jpg", 'Footer Icon4') ?>
                    <h2>  <?php echo $rep_display;?></h2> <span>  Sales representatives </span>
                </div>
            </div>
        </div>
    </div>
    <div class="copy"> Copyright © 2015  opti-rep.com. All rights reserved. </div>
</div>