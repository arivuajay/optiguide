<div class="cate-bg user-right">
    <h2> <?php echo Myclass::t('OR586', '', 'or') ?> </h2>
    <div class="row"> 
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php
            $this->widget('booster.widgets.TbHighCharts', array(
                'options' => array(
                    'chart' => array(
                        'type' => 'spline'
                    ),
                    'title' => array(
                        'text' => 'Loggedin Activities'
                    ),
                    'subtitle' => array(
                        'text' => 'Last 6 days'
                    ),
                    'xAxis' => array(
                        'categories' => $response['dates']
                    ),
                    'yAxis' => array(
                        'title' => array(
                            'text' => 'No.of Times Loggedin'
                        ),
                        'min' => 0,
                    ),
                    'series' => $response['series'],
                    "credits" => array(
                        'enabled' => false
                    )
                )
            ));
            ?>
        </div>
    </div>
</div>