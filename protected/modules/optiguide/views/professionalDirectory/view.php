<?php $this->renderPartial('_search', array('searchModel' => $searchModel)); ?>
<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
        <div class="inner-container eventslist-cont">         
                <h2> <?php echo $model['PRENOM']; ?>  <?php echo $model['NOM']; ?>  , <?php echo $model['TYPE_SPECIALISTE_EN']; ?></h2>
                <div class="search-list">                   
                    <p><strong><?php echo $model['BUREAU']; ?></strong><br>
                         <?php echo $model['ADRESSE']; ?>. <br/> 
                         <?php echo $model['NOM_VILLE']; ?>,  <?php echo $model['NOM_REGION_EN']; ?><br/> 
                         <?php echo $model['NOM_PAYS_EN']; ?><br/> 
                         <?php echo $model['CODE_POSTAL']; ?>
                   </p>
                    <p>Tel : <?php echo $model['TELEPHONE']; ?><br>                       
                        Fax : <?php echo $model['TELECOPIEUR']; ?><br>                      
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