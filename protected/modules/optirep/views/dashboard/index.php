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
        /** Loggedin Activities **/
//        $stats_disp = Myclass::stats_display();
//        if ($stats_disp == "1" || true) {
//            $this->widget('booster.widgets.TbHighCharts', array(
//                'options' => array(
//                    'chart' => array(
//                        'type' => 'spline'
//                    ),
//                    'title' => array(
//                        'text' => 'Loggedin Activities'
//                    ),
//                    'subtitle' => array(
//                        'text' => 'Last 6 days'
//                    ),
//                    'xAxis' => array(
//                        'categories' => $response['dates']
//                    ),
//                    'yAxis' => array(
//                        'title' => array(
//                            'text' => 'No.of Times Loggedin'
//                        )
//                    ),
//                    'series' => array(
//                        array(
//                            'name' => Yii::app()->user->name,
//                            'data' => $response['visits']
//                        )
//                    ),
//                    "credits" => array(
//                        'enabled' => false
//                    )
//                )
//            ));
//        } else {
//            echo CHtml::link(CHtml::image($this->themeUrl . '/images/chart.jpg'), array('/optirep/repStatistics/payment/'), array('class' => ''));
//        }
        
        /** Users registered in optiguide **/
        $months = array();
        for ($i = 0; $i < 6; $i++) {
            array_push($months, date("M Y", strtotime($i . " months ago")));
        }

        $response['months'] = array();
        foreach ($months as $month) {
            array_push($response["months"], $month);
        }

        $usertypes = array("Professionals", "Retailers");

        foreach ($usertypes as $key => $utype) {
            // Count  profile view counts  per month
            $response['viewcounts'] = array();
            $viewcounts = '';
            foreach ($months as $month) {

                $searchdate = date("Y-m", strtotime($month));
                if ($utype == "Professionals") {
                    $per_mount_counts = Yii::app()->db->createCommand() //this query contains all the data
                            ->select('count(*) as pro_per_month_count,ID_SPECIALISTE , NOM , PRENOM , TYPE_SPECIALISTE_' . $this->lang . ' ,  NOM_VILLE ,  NOM_REGION_' . $this->lang . ' , ABREVIATION_' . $this->lang . ' ,  NOM_PAYS_' . $this->lang . '')
                            ->from(array('repertoire_specialiste rs', 'repertoire_specialiste_type rst', 'repertoire_ville AS rv', 'repertoire_region AS rr', 'repertoire_pays AS rp','repertoire_utilisateurs as ru'))
                            ->where("rs.ID_SPECIALISTE=ru.ID_RELATION AND rs.ID_TYPE_SPECIALISTE = rst.ID_TYPE_SPECIALISTE AND rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS and ru.status=1 AND ru.NOM_TABLE ='Professionnels' AND rs.CREATED_DATE LIKE '%$searchdate%' ")
                            ->group('rst.ID_TYPE_SPECIALISTE')
                            ->queryAll();
                        
                     foreach($per_mount_counts as $per_mount_count){
                         $viewcount = $viewcount + $per_mount_count['pro_per_month_count'];
                     }
                        
                    $viewcounts =$viewcount;
                    $viewcount=0;
                    
                }

                if ($utype == "Retailers") {
                    $ret_mount_counts = Yii::app()->db->createCommand() // this query get the total number of items,
                        ->select('count(*) as ret_per_month_count , NOM_TYPE_EN')
                        ->from(array('repertoire_retailer rs', 'repertoire_retailer_type rst', 'repertoire_ville AS rv', 'repertoire_region AS rr', 'repertoire_pays AS rp', 'repertoire_utilisateurs as ru'))
                        ->where("rs.ID_RETAILER=ru.ID_RELATION AND rs.ID_RETAILER_TYPE = rst.ID_RETAILER_TYPE AND rs.ID_VILLE = rv.ID_VILLE AND rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS and ru.status=1 AND ru.NOM_TABLE ='Detaillants' AND rs.CREATED_DATE LIKE '%$searchdate%'")
                        ->group('rst.ID_RETAILER_TYPE')
                        ->queryAll();
                    foreach($ret_mount_counts as $ret_mount_count){
                         $viewcount = $viewcount + $ret_mount_count['ret_per_month_count'];
                     }                        
                    $viewcounts =$viewcount;
                    $viewcount= 0;
                    
                }

                array_push($response["viewcounts"], (int) $viewcounts);
            }

            $response['allprofiles'][$key]['name'] = $utype;
            $response['allprofiles'][$key]['data'] = $response["viewcounts"];
        }
        
        $this->widget('booster.widgets.TbHighCharts', array(
            'options' => array(
                'chart' => array(
                    'type' => 'column'
                ),
                'title' => array(
                    'text' => 'Users subscription in Optiguide.'
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