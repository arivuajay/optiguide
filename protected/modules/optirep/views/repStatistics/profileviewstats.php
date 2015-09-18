<div class="cate-bg user-right">
    <h2> Users profiles viewed stats </h2>
    <div class="row"> 
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
                )
            ));
            ?>
        </div>
    </div>
</div>