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
    
    if($usrinfo->rep_role == RepCredentials::ROLE_ADMIN)
    {
      
       if(!empty($response['allprofiles']))
        {   
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
        }else{
            echo Myclass::t('OR777', '', 'or');
        }    
        
    }else if (($usrinfo->rep_role == RepCredentials::ROLE_SINGLE) && Myclass::stats_display())
    {          
        $this->widget('booster.widgets.TbHighCharts', array(
            'options' => array(
                'chart' => array(
                    'type' => 'column'
                ),
                'title' => array(
                    'text' => Myclass::t("OR766", "", "or")
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
                        'text' => Myclass::t("OR767", "", "or")
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
        <p class="pull-right"><?php echo CHtml::link(Myclass::t('OG215'), array('/optirep/repStatistics/statistics'),array("class"=>"more_stats")); ?> </p>
   <?php
    }else{
         
        if (Yii::app()->session['language'] == 'FR') { 
           $imgname = "paytoview-fr.jpg"; 
        }else{
           $imgname = "paytoview-en.jpg"; 
        }
         $image = CHtml::image($this->themeUrl . '/images/'.$imgname, 'satistics');
         echo CHtml::link($image, array('/optirep/repStatistics/payment'));        
    }?>
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
                    <div class="lastest-date"> <span>
                    <?php 
                    if (Yii::app()->session['language'] == 'FR') { 
                                $m= date("n", strtotime($latest_new['DATE_AJOUT1']));
                                $mon = Myclass::getMonths_M($m);
                            }else{
                                $mon = date("M", strtotime($latest_new['DATE_AJOUT1']));
                            }
                        echo $mon . ' ' . date("d", strtotime($latest_new['DATE_AJOUT1'])) ?> </span> </div>
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