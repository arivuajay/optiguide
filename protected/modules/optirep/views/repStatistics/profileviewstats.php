<div class="cate-bg user-right">
    <h2> <?php echo Myclass::t('OR585', '', 'or') ?> </h2>
    <div class="row"> 
    <?php
    if(!empty($response['allprofiles']))
    {?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php
            $this->widget('booster.widgets.TbHighCharts', array(
                'options' => array(
                    'chart' => array(
                        'type' => 'column'
                    ),
                    'title' => array(
                        'text' => Myclass::t('OR779', '', 'or'),
                    ),
                    'subtitle' => array(
                        'text' => Myclass::t('OR780', '', 'or')
                    ),
                    'xAxis' => array(
                        'categories' => $response['dates']
                    ),
                    'yAxis' => array(
                        'title' => array(
                            'text' => Myclass::t('OR781', '', 'or')
                        ),
                        'min' => 0,
                        'max' => 50,
                    ),
                    'series' => $response['allprofiles'],
                    "credits" => array(
                        'enabled' => false
                    )
                )
            ));
            ?>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php
            $this->widget('booster.widgets.TbHighCharts', array(
                'options' => array(
                    'chart' => array(
                        'type' => 'column'
                    ),
                    'title' => array(
                        'text' => Myclass::t('OR782', '', 'or')
                    ),
                    'subtitle' => array(
                        'text' => Myclass::t('OR780', '', 'or')
                    ),
                    'xAxis' => array(
                        'categories' => $response['dates']
                    ),
                    'yAxis' => array(
                        'title' => array(
                            'text' => Myclass::t('OR781', '', 'or')
                        ),
                        'min' => 0,
                        'max' => 50,
                    ),
                    'series' => $response['professionalviews'],
                    "credits" => array(
                        'enabled' => false
                    )
                )
            ));
            ?>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php
            $this->widget('booster.widgets.TbHighCharts', array(
                'options' => array(
                    'chart' => array(
                        'type' => 'column'
                    ),
                    'title' => array(
                        'text' => Myclass::t('OR783', '', 'or')
                    ),
                    'subtitle' => array(
                        'text' => Myclass::t('OR780', '', 'or')
                    ),
                    'xAxis' => array(
                        'categories' => $response['dates']
                    ),
                    'yAxis' => array(
                        'title' => array(
                            'text' => Myclass::t('OR781', '', 'or')
                        ),
                        'min' => 0,
                        'max' => 50,
                    ),
                    'series' => $response['retailerviews'],
                    "credits" => array(
                        'enabled' => false
                    )
                )
            ));
            ?>        
        </div>
               <?php    
        }else{
            ?>     
             <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
             <?php     echo Myclass::t('OR777', '', 'or');  ?>   
             </div>
       <?php     } 
   ?> 
    </div>
</div>