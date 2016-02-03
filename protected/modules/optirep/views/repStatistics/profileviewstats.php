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
                        'text' => 'All profile view count stats'
                    ),
                    'subtitle' => array(
                        'text' => 'Last 6 days'
                    ),
                    'xAxis' => array(
                        'categories' => $response['dates']
                    ),
                    'yAxis' => array(
                        'title' => array(
                            'text' => 'View counts'
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
                        'text' => 'Professionals profile view count stats'
                    ),
                    'subtitle' => array(
                        'text' => 'Last 6 days'
                    ),
                    'xAxis' => array(
                        'categories' => $response['dates']
                    ),
                    'yAxis' => array(
                        'title' => array(
                            'text' => 'View counts'
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
                        'text' => 'Retailers profile view count stats'
                    ),
                    'subtitle' => array(
                        'text' => 'Last 6 days'
                    ),
                    'xAxis' => array(
                        'categories' => $response['dates']
                    ),
                    'yAxis' => array(
                        'title' => array(
                            'text' => 'View counts'
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