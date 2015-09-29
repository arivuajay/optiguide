<div class="cate-bg user-right">
    <?php $this->renderPartial('_search', array('searchModel' => $searchModel)); ?>
    <div class="row"> 
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
            <div class="inner-container eventslist-cont">         
                <h2> <?php echo $model['PRENOM']; ?>  <?php echo $model['NOM']; ?>  , <?php echo $model['TYPE_SPECIALISTE_' . $this->lang]; ?></h2>
            </div>
        </div>    
        <?php
        $rep_id = Yii::app()->user->id;
        $userid = $model['ID_UTILISATEUR'];      
        $criteria = new CDbCriteria;
        $criteria->condition = 'rep_credential_id=:repid and ID_UTILISATEUR= :retid';
        $criteria->params = array(":repid" => $rep_id, ":retid" => $userid);
        $favourites = RepFavourites::model()->find($criteria);
        $fav_user = $favourites->ID_UTILISATEUR;
       ?>
       <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 pull-right"> 
           <div class="addfav-btn">          
               <input name="FAV" type="checkbox" id="FAV" value="<?php echo $model['ID_UTILISATEUR']; ?>" <?php
               if ($fav_user !='') {
                   echo "checked=checked";
               }
               ?>>  Add to Favorites 
           </div>
            <?php echo CHtml::link('<i class="fa fa-mail-forward"></i> Send message', array('/optirep/internalMessage/createnew/id/' . $model['ID_UTILISATEUR']), array("class" => "pull-right")); ?>
            <?php echo CHtml::link('<i class="fa fa-exclamation-triangle"></i> Report a change', array('/optirep/professionalDirectory/reportuser/id/' . $model['ID_SPECIALISTE']), array("class" => "pull-right","data-toggle" => "modal","data-target"=>"#sendMessage")); ?>
       </div>
                
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">         
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
        </div>     
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">            
           <div class="viewall"> <?php echo CHtml::link('<i class="fa fa-arrow-circle-left"></i> ' . Myclass::t('OG016', '', 'og'), array('/optirep/professionalDirectory'), array("class" => "pull-left")); ?> </div>  
        </div>        
           
        <?php if (!empty($results)) { ?>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scroll-cont brands">  
                <h2> <?php echo Myclass::t('OGO158', '', 'og'); ?> </h2> 
                <div class="box" id="box1">
                    <div class="brands">    

                        <ul>

                            <?php foreach ($results as $info) { ?>
                                <li>
                                    <?php
                                    $dispname = $info['COMPAGNIE'];
                                    echo CHtml::link($dispname, array('/optirep/retailerDirectory/view', 'id' => $info['ID_RETAILER']), array('target' => '_blank')) . ' ';
                                    echo $info['NOM_VILLE'] . "," . $info['ABREVIATION_' . $this->lang] . "," . $info['NOM_PAYS_' . $this->lang];
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

<!-- Report Modal Box-->
<div class="modal fade" id="sendMessage" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Send Report</h4>
            </div>
             <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'report_form',
                'htmlOptions' => array('role' => 'form'),               
            ));
            ?>
            <div class="modal-body model-form">
                <div class="row"> 
                     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <label>Report as </label>
                        <select class="selectpicker" name="report_reason">
                            <option value="moved">Moved</option>
                            <option value="closed">Closed</option>                         
                        </select>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <label>Comments </label>
                        <textarea class="form-field-textarea" name="report_message"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <?php
                echo CHtml::tag('button', array(
                    'name' => 'ReportSubmit',
                    'type' => 'submit',
                    'class' => 'register-btn'
                        ), 'Send');
                ?>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
<?php
$ajaxUpdatefav = Yii::app()->createUrl('/optirep/repFavourites/updatefav');
$js = <<< EOD
$(document).ready(function(){
        
    $('input').iCheck({
                    checkboxClass: 'icheckbox_flat-pink',
                    radioClass: 'iradio_flat-pink'
                });
        
    $('.box').lionbars();    
        
    $('input[name="FAV"]').on('ifClicked', function(event){      
      
        var ret_val =  $(this).attr("value");   
        if($(this).attr('checked')){
            var fav_status = 'removefav';
        }else{
       
            var fav_status = 'addfav';
        }
        
        var dataString = 'id='+ ret_val+'&favstatus='+fav_status;
           $.ajax({
               type: "POST",
               url: '{$ajaxUpdatefav}',
               data: dataString,
               cache: false,
               success: function(html){             
               }
            });
      
    });  

        
});
EOD;
Yii::app()->clientScript->registerScript('_form_view', $js);
?>