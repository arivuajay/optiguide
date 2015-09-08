<div class="cate-bg user-right">
<?php $this->renderPartial('_search', array('searchModel' => $searchModel)); ?>
<div class="row"> 
  <?php
    $rep_id     = Yii::app()->user->id;
    $retailerid = $model['ID_RETAILER'];
    $criteria = new CDbCriteria;
    $criteria->condition = 'rep_credential_id=:repid and ID_RETAILER= :retid'; 
    $criteria->params = array(":repid" => $rep_id, ":retid" => $retailerid);
    $favourites = RepFavourites::model()->find($criteria);
    $fav_retailer = $favourites->ID_RETAILER;
    
    $param_id = Yii::app()->getRequest()->getQuery('id');
   
  ?>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8"> 
        <div class="inner-container eventslist-cont">         
                <h2> <?php echo $model['COMPAGNIE']; ?></h2>
               
                <div class="search-list">                   
                    <p> <?php echo $model['ADRESSE']; ?>. <br/> 
                         <?php echo $model['NOM_VILLE']; ?>,  <?php echo $model['NOM_REGION_'.$this->lang]; ?><br/> 
                         <?php echo $model['NOM_PAYS_'.$this->lang]; ?><br/> 
                         <?php echo $model['CODE_POSTAL']; ?>
                   </p>
                    <p> <?php echo Myclass::t('OG041', '', 'og');?> : <?php echo $model['TELEPHONE']; ?><br>                       
                        <?php echo Myclass::t('OG042', '', 'og');?> : <?php echo $model['TELECOPIEUR']; ?><br>  
                         <?php echo Myclass::t('OG046', '', 'og');?> : <?php echo $model['TEL_1800']; ?><br>    
                   </p>
                   <p><?php 
                    $cat = array();
                    $cat[] = $model['CATEGORY_1'];
                    $cat[] = $model['CATEGORY_2'];
                    $cat[] = $model['CATEGORY_3'];
                    $cat[] = $model['CATEGORY_4'];
                    $cat[] = $model['CATEGORY_5'];                   
                    $categories  = array("0"=>Myclass::t('OG105'),"1"=>Myclass::t('OG106'),"2"=>Myclass::t('OG107'),"3"=>Myclass::t('OG108'),"4"=>Myclass::t('OG109'));
                    echo Myclass::t('OG050', '', 'og');?> : <?php 
                    $str = '';
                        foreach($cat as $key =>  $info)
                        {
                            if( $info==1)
                                {
                                    $str[] = $categories[$key];                                
                                }
                        }
                    if(!empty($str))
                    {
                        echo implode(',',$str);
                    }
                   ?></p>
                </div>
                <div class="clearfix"></div>                
                 <div class="viewall"> <?php echo CHtml::link('<i class="fa fa-arrow-circle-left"></i> '.Myclass::t('OG016', '', 'og'), array('/optirep/retailerDirectory'),array("class"=>"pull-left")); ?> </div>  
            </div>
        </div>
    
     <div class="col-xs-12 col-sm-5 col-md-4 col-lg-4 addfav">         
         <div class="addfav-btn">          
          <input name="FAV" type="checkbox" id="FAV" value="<?php echo $model['ID_RETAILER']; ?>" <?php if($fav_retailer==$param_id){ echo "checked=checked";} ?>>  Add to Favorites 
         </div>
     </div>
    
    <?php
    if (!empty($results)) {?>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scroll-cont brands">  
        <h2> <?php echo Myclass::t('OGO157', '', 'og');?> </h2> 
        <div class="box" id="box1">
            <div class="brands">               
                <ul>
                    <?php foreach ($results as $info) { ?>
                    <li>
                        <?php
                        $dispname = $info['NOM'].','.$info['PRENOM'];
                        echo CHtml::link($dispname, array('/optirep/professionalDirectory/view', 'id' => $info['ID_SPECIALISTE']), array('target'=>'_blank')) . ' ';   
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
<?php
$ajaxUpdatefav = Yii::app()->createUrl('/optirep/retailerDirectory/updatefav');
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