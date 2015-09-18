

<div class="cate-bg user-right">
    <h2> My Logged in Activities </h2>
    <div class="row"> 
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php
            $this->widget('booster.widgets.TbHighCharts', array(
                'options' => array(
                    'chart' => array(
                        'type' => 'column'
                    ),
                    'title' => array(
                        'text' => 'All Profile view count activities'
                    ),
                    'subtitle' => array(
                        'text' => 'Last 6 days'
                    ),
                    'xAxis' => array(
                        'categories' => $response['dates']
                    ),
                    'yAxis' => array(
                        'title' => array(
                            'text' => 'No.of view counts'
                        ),
                        'min'=> 0, 
                        'max'=> 50,
                    ),
                    'series' => $response['series'],
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
                        'text' => 'Professional profile view count activities'
                    ),
                    'subtitle' => array(
                        'text' => 'Last 6 days'
                    ),
                    'xAxis' => array(
                        'categories' => $response['dates']
                    ),
                    'yAxis' => array(
                        'title' => array(
                            'text' => 'No.of view counts'
                        ),
                        'min'=> 0, 
                        'max'=> 50,
                    ),
                    'series' => $response['series'],
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
                        'text' => 'Professional profile view count activities'
                    ),
                    'subtitle' => array(
                        'text' => 'Last 6 days'
                    ),
                    'xAxis' => array(
                        'categories' => $response['dates']
                    ),
                    'yAxis' => array(
                        'title' => array(
                            'text' => 'No.of view counts'
                        ),
                        'min'=> 0, 
                        'max'=> 50,
                    ),
                    'series' => $response['series'],
                )
            ));
            ?>
        </div>
    </div>
</div>