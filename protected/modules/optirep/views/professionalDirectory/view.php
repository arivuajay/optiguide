<div class="cate-bg user-right">
<?php $this->renderPartial('_search', array('searchModel' => $searchModel)); ?>
<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
        <div class="inner-container eventslist-cont">         
            <h2> <?php echo $model['PRENOM']; ?>  <?php echo $model['NOM']; ?>  , <?php echo $model['TYPE_SPECIALISTE_' . $this->lang]; ?></h2>
            <?php echo CHtml::link('<i class="fa fa-mail-forward"></i> Send message', array('/optirep/internalMessage/createnew/id/'.$model['ID_UTILISATEUR']),array("class"=>"pull-right")); ?>
            <div class="search-list">                   
                <p><strong><?php echo $model['BUREAU']; ?></strong><br>
                    <?php echo $model['ADRESSE']; ?>. <br/> 
                    <?php echo $model['NOM_VILLE']; ?>,  <?php echo $model['NOM_REGION_' . $this->lang]; ?><br/> 
                    <?php echo $model['NOM_PAYS_' . $this->lang]; ?><br/> 
                    <?php echo $model['CODE_POSTAL']; ?>
                </p>
                <p> <?php echo Myclass::t('OG041', '', 'og'); ?> : <?php echo $model['TELEPHONE']; ?><br>                       
                    <?php echo Myclass::t('OG042', '', 'og'); ?> : <?php echo $model['TELECOPIEUR']; ?><br>                      
                </p>
            </div>
            <div class="clearfix"></div>               
            <div class="viewall"> <?php echo CHtml::link('<i class="fa fa-arrow-circle-left"></i> '.Myclass::t('OG016', '', 'og'), array('/optirep/professionalDirectory'),array("class"=>"pull-left")); ?> </div>  
        </div>
    </div>
 <?php
    if (!empty($results)) {?>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scroll-cont brands">  
        <h2> <?php echo Myclass::t('OGO158', '', 'og');?> </h2> 
        <div class="box" id="box1">
            <div class="brands">    
           
                <ul>
                    
                        <?php foreach ($results as $info) { ?>
                        <li>
                            <?php
                            $dispname = $info['COMPAGNIE'];
                            echo CHtml::link($dispname, array('/optirep/retailerDirectory/view', 'id' => $info['ID_RETAILER']), array('target'=>'_blank')) . ' ';   
                            echo $info['NOM_VILLE'].",".$info['ABREVIATION_'.$this->lang].",".$info['NOM_PAYS_'.$this->lang];
                            ?>
                        </li>
                        <?php } ?>                       
                </ul>               
                <p>&nbsp;</p>
            </div>
        </div>
    </div>  
     <?php } ?>      
</div>
</div>  


<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">
    Open Modal
</button>

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Send Message</h4>
            </div>
            <div class="modal-body">
                <?php
                $userto_id = Yii::app()->getRequest()->getQuery('id');
                $uto_infos = UserDirectory::model()->findByPk($userto_id);
                ?>
                <div class="row"> 
                    <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
                        Send To  : <?php echo $uto_infos->NOM_UTILISATEUR; ?>
                    </div>  
                    <div class="col-xs-12 col-sm-6 col-md-8 col-lg-6">
                    </div>    
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <?php
                        echo CHtml::tag('button', array(
                            'name' => 'btnSubmit',
                            'type' => 'submit',
                            'class' => 'register-btn'
                                ), 'Submit');
                        ?>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>