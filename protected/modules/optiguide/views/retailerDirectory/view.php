<?php $this->renderPartial('_search', array('searchModel' => $searchModel)); ?>
<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
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
                    <?php echo CHtml::link(Myclass::t('OG016', '', 'og'), array('/optiguide/retailerDirectory'),array('class'=>'basic-btn')); ?>                
            </div>
        </div>
    </div>
