<div class="cate-bg user-right">
    <?php $this->renderPartial('_search', array('searchModel' => $searchModel)); ?>
    <?php // $country_name = Myclass::getcountries($searchModel->country);?>
    <h2> <?php echo Myclass::t('OR738', '', 'or') ?> </h2>
    <div class="row"> 
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h3> <?php echo Myclass::t('OR742', '', 'or') ?></h3>
            
            <?php
            if($response['total']['retailers']!='' || $response['total']['professionals']!=''){
            $this->widget('booster.widgets.TbHighCharts', array(
            'options' => array(
                'chart' => array(
                    'type' => 'column'
                ),
                'title' => array(
                    'text' => Myclass::t('OR742', '', 'or')
                ),
                'subtitle' => array(
                    'text' => Myclass::t('OR743', '', 'or')
                ),
                'xAxis' => array(
                    'categories' => $response['months'],
                    'crosshair' => true
                ),
                'yAxis' => array(
                    'title' => array(
                        'text' => Myclass::t('OR744', '', 'or')
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
            } else{ ?>
            <span class="center"><?php echo Myclass::t('OR745', '', 'or') ?></span>
            <?php } ?>
        </div>
        
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <hr>
            <h3><?php echo Myclass::t('OR746', '', 'or') ?></h3>
            
            <?php
            if($response['total']['professionals']!=''){
            $this->widget('booster.widgets.TbHighCharts', array(
            'options' => array(
                'chart' => array(
                    'type' => 'column'
                ),
                'title' => array(
                    'text' => Myclass::t('OR746', '', 'or')
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
                        'text' => Myclass::t('OR747', '', 'or')
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
            <span class="pull-right"><?php echo Myclass::t('OR748', '', 'or') ?><?php echo $response['total']['professionals'];?></span>
            <?php }else{?>
            <span class="center"><?php echo Myclass::t('OR745', '', 'or') ?></span>
            <?php } ?>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <hr>
            <h3><?php echo Myclass::t('OR749', '', 'or') ?></h3>
            <?php
            if($response['total']['retailers']!=''){
            $this->widget('booster.widgets.TbHighCharts', array(
                'options' => array(
                    'chart'=> array(
                        'plotBackgroundColor'=> null,
                        'plotBorderWidth'=> null,
                        'plotShadow' => false,
                        'type'=> 'pie'
                    ),
                    'title' => array(
                        'text'=> Myclass::t('OR749', '', 'or')
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
            <span class="pull-right"><?php echo Myclass::t('OR750', '', 'or') ?><?php echo $response['total']['retailers'];?></span>
            <?php }else{?>
            <span class="center"><?php echo Myclass::t('OR745', '', 'or') ?></span>
            <?php } ?>
        </div>
    </div>
</div>
<?php
$js = <<< EOD
$(document).ready(function(){              
    $("#page_change").change(function(){
        var id=$(this).val();
        $("#listperpage").val(id);  
        $("#search-form").submit();   
    });
});
EOD;
Yii::app()->clientScript->registerScript('page_change', $js);
?>
