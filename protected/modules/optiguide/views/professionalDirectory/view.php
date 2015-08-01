<?php $this->renderPartial('_search', array('searchModel' => $searchModel)); ?>
<!--[ID_SPECIALISTE] => 8511
[ID_CLIENT] => 4593
[PREFIXE_FR] => 
[PREFIXE_EN] => 
[PRENOM] => Daphne
[NOM] => Archibald
[ID_TYPE_SPECIALISTE] => 4
[TYPE_AUTRE] => 
[BUREAU] => Princess Margaret Hospital Craniofacial Unit
[ADRESSE] => 610 University Ave.
[ADRESSE2] => 
[ID_VILLE] => 751
[CODE_POSTAL] => M5G 2M9
[TELEPHONE] => 416 946-2000 # 5517
[TELEPHONE2] => 
[TELECOPIEUR] => 416 946-6576
[TELECOPIEUR2] => 
[SITE_WEB] => 
[COURRIEL] => daphne.archibald@uhn.on.ca
[DATE_MODIFICATION] => 2014-01-31 10:48:57
[TYPE_SPECIALISTE_EN] => Ocularist
[NOM_VILLE] => Toronto
[NOM_REGION_EN] => Ontario
[ABREVIATION_EN] => ON
[NOM_PAYS_EN] => Canada-->
<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
        <div class="inner-container eventslist-cont">         
                <h2> <?php echo $model['PRENOM']; ?>  <?php echo $model['NOM']; ?>  , <?php echo $model['TYPE_SPECIALISTE_EN']; ?></h2>
                <div class="search-list">                   
                    <p><strong>Banfield Ocular Prosthetics Services</strong><br>
                        671 Main St. <br/> 
                        Dartmouth, Nova Scotia<br/> 
                        Canada<br/> 
                   </p>
                    <p>Tel : 902 468-2610<br>
                       Tel #2 : 1 800 565-1027<br>
                        Fax : 450 629-6044<br>                      
                   </p>
                </div>
                <div class="clearfix"></div>
                <div class="event-details-txt"> 
                    <?php echo CHtml::link(Myclass::t('OG016', '', 'og'), array('/optiguide/professionalDirectory')); ?>
                </div>
            </div>
        </div>
    </div>
</div>