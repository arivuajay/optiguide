<?php
$topbanner = Myclass::banner_display(7);
if ($topbanner != '') {
    ?>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ad1"> 
        <!--  Optirep top banner- position - 7 -->
        <?php echo $topbanner; ?>
    </div>
<?php } ?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 dashboard-userinfo"> 
    <h2>  <?php echo Myclass::t('OR511', '', 'or') ?>, 
        <span> 
            <?php echo CHtml::link(Yii::app()->user->getState('rep_username'), array('/optirep/repCredential/editprofile')); ?>
        </span> 
    </h2>
     <?php echo Myclass::t('OR512', '', 'or') ?>
</div>

<?php $this->renderPartial('_favbox'); ?>

<?php $this->renderPartial('_notes'); ?>

<?php $this->renderPartial('_calender'); ?>


<div class="col-xs-12 col-sm-7 col-md-8 col-lg-8">
    <div class="cate-bg">    
        <?php
        $stats_disp = Myclass::stats_display();
        if ($stats_disp == "1") {
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
                        )
                    ),
                    'series' => array(
                        array(
                            'name' => Yii::app()->user->name,
                            'data' => $response['visits']
                        )
                    ),
                    "credits" => array(
                        'enabled' => false
                    )
                )
            ));
        } else {
            echo CHtml::link(CHtml::image($this->themeUrl . '/images/chart.jpg'), array('/optirep/repStatistics/payment/'), array('class' => ''));
        }
        ?>
    </div>
</div>

<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
    <div class="cate-bg"> 
        <div class="cate-heading cate-heading4"> 
            <i class="fa fa-envelope"></i> <?php echo Myclass::t('OR037', '', 'or') ?>
                <?php echo CHtml::link(Myclass::t('OR038', '', 'or'), array('/optirep/newsManagement'), array('class' => 'topviewall')); ?> 
        </div>
        <?php
        $latest_news = NewsManagement::model()->latest_rep()->findAll();
        if (!empty($latest_news)) {
            foreach ($latest_news as $latest_new) {
                $dispname = (strlen($latest_new['TITRE']) >= 55) ? substr($latest_new['TITRE'], 0, 55) . '..' : $latest_new['TITRE'];
                ?>
                <div class="lastest-newscont">
                    <div class="lastest-newsconttxt"> 
                        <?php echo CHtml::link($dispname, array('/optirep/newsManagement/view', 'id' => $latest_new['ID_NOUVELLE'])); ?> <br/> 
                    </div>
                    <div class="lastest-date"> <span> <?php echo date("M", strtotime($latest_new['DATE_AJOUT1'])) . ' ' . date("d", strtotime($latest_new['DATE_AJOUT1'])) ?> </span> </div>
                </div>  
            <?php } ?>
        <?php } ?>
    </div>   
</div>

<?php
$bottombanner = Myclass::banner_display(8);
if ($bottombanner != '') {
    ?>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ad1"> 
        <!--  Optirep bottom banner- position - 8 -->
        <?php echo $bottombanner; ?>
    </div>
<?php } ?>