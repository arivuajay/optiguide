<div class="cate-bg user-right">
    <?php // $this->renderPartial('_search', array('searchModel' => $searchModel)); ?>
    <h2> <?php echo Myclass::t('OR738', '', 'or') ?> </h2>
    <div class="row"> 
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php
            $this->widget('booster.widgets.TbHighCharts', array(
            'options' => array(
                'chart' => array(
                    'type' => 'column'
                ),
                'title' => array(
                    'text' => 'Professional and Retailers subscription in Optiguide.'
                ),
                'subtitle' => array(
                    'text' => 'Last 6 months'
                ),
                'xAxis' => array(
                    'categories' => $response['months'],
                    'crosshair' => true
                ),
                'yAxis' => array(
                    'title' => array(
                        'text' => 'Subscription counts'
                    ),
                    'min' => 0,
                ),
                'tooltip' => array(
                    'headerFormat' => '<span style="font-size:10px">{point.key}</span><table>',
                    'pointFormat' => '<tr><td style="color:{series.color};padding:0">{series.name}: </td><td style="padding:0"><b>{point.y}</b></td></tr>',
                    'footerFormat' => '</table>',
                    'shared' => true,
                    'useHTML' => true
                ),
                'plotOptions' => array(
                    'column' => array(
                        'pointPadding' => 0.2,
                        'borderWidth' => 0
                    )
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
            <hr>
            <?php
            $this->widget('booster.widgets.TbHighCharts', array(
            'options' => array(
                'chart' => array(
                    'type' => 'column'
                ),
                'title' => array(
                    'text' => 'Professional Users Type.'
                ),
                'xAxis' => array(
                    'type' => 'category',
                    'labels' => array(
                            'rotation' => -45,
                            'style' => array(
                                        'fontSize' => '13px',
                                        'fontFamily' => 'Verdana, sans-serif',
                                    ),
                        ),
                ),
                'yAxis' => array(
                    'title' => array(
                        'text' => 'Professional counts'
                    ),
                    'min' => 0,
                ),
                'legend' => array(
                    'enabled' => false,
                ),
                'tooltip' => array(
                    'pointFormat' => 'Professional: <b>{point.y}</b>',
                ),
                'series' => $response['allprofessionals'],
                
            )
        ));
            
            
            ?>
            <span class="pull-right">Total Professional Users:<?php echo $response['total']['professionals'];?></span>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <hr>
            <?php
            $this->widget('booster.widgets.TbHighCharts', array(
                'options' => array(
                    'chart'=> array(
                        'plotBackgroundColor'=> null,
                        'plotBorderWidth'=> null,
                        'plotShadow' => false,
                        'type'=> 'pie'
                    ),
                    'title' => array(
                        'text'=> 'Retailer Users Type'
                    ),
                    'tooltip' => array(
                        'pointFormat'=> '{series.name}: <b>{point.percentage:.1f}%</b>'
                    ),
                    'plotOptions'=> array(
                        'pie'=> array(
                            'allowPointSelect'=> true,
                            'cursor'=> 'pointer',
                            'dataLabels'=> array(
                                'enabled'=> true,
                                'format'=> '<b>{point.name}</b>: {point.percentage:.1f} %',
                                'style'=> array(
                                    'color'=> '(Highcharts.theme && Highcharts.theme.contrastTextColor)' || 'black'
                                )
                            )
                        )
                    ),
                    'series'=> $response['allretailer'],
                    )
        ));
            
            ?>
            <span class="pull-right">Total Retailers Users:<?php echo $response['total']['retailers'];?></span>
        </div>
    </div>
</div>