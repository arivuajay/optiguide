<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ad1"> 
    <?php echo CHtml::image($this->themeUrl . '/images/ad.jpg'); ?>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 dashboard-userinfo"> 
    <h2>  Hello, <span> <?php echo CHtml::link(Yii::app()->user->getState('rep_username'), array('/optirep/repCredential/editprofile')); ?></span> </h2>
    Welcome to your personalized dashboard! Here's some of the thing you can do starting from here: 
</div>

<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    <div class="cate-bg"> 
        <div class="cate-heading">  <i class="fa fa-heart"></i> Favorites  </div>
        <?php
        $rep_id = Yii::app()->user->id;
        $myfavourites = Yii::app()->db->createCommand() //this query contains all the data
                ->select('rr.ID_RETAILER,rr.COMPAGNIE,rt.NOM_TYPE_' . $this->lang)
                ->from(array('rep_favourites rf', 'repertoire_retailer rr', 'repertoire_retailer_type AS rt'))
                ->where("rr.ID_RETAILER=rf.ID_RETAILER AND rt.ID_RETAILER_TYPE=rr.ID_RETAILER_TYPE AND rf.rep_credential_id =" . $rep_id)
                ->order(',rf.id desc')
                ->limit(4)
                ->queryAll();

        $fav_rets = '';
        if (!empty($myfavourites)) {
            foreach ($myfavourites as $favinfo) {
                $fav_rets .= "<div class='fav-cont favusers'>" . CHtml::image($this->themeUrl . '/images/fav.jpg');
                $fav_rets .= CHtml::link($favinfo['COMPAGNIE'], array('/optirep/retailerDirectory/view', 'id' => $favinfo['ID_RETAILER'])) . "<br/> <span> <b> Type : </b> " . $favinfo['NOM_TYPE_' . $this->lang] . "</span> </div>";
            }
            $fav_rets .= "<div class='viewall'>" . CHtml::link(Myclass::t('OG038', '', 'og'), array('/optirep/repFavourites'), array('class' => '')) . "</div>";
        } else {
            $fav_rets = "<p class='fav_message'>You have no favorite retailers right now." . CHtml::link("Click", array('/optirep/retailerDirectory')) . " to see the retailers listing and make it your favorite!!!.</p>";
        }
        echo $fav_rets;
        ?>   
    </div>
</div>

<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    <div class="cate-bg"> 
        <div class="cate-heading cate-heading2">  <i class="fa fa-pencil"></i>  My Notes  </div>
        <?php
        $rep_id = Yii::app()->user->id;
        $criteria = new CDbCriteria();
        $criteria->addCondition('rep_credential_id = "' . $rep_id . '"');
        $criteria->order = 'id DESC';
        $criteria->limit = 3;
        $model_notes = RepNotes::model()->findAll($criteria);
        if (!empty($model_notes)) {
            foreach ($model_notes as $notes) {
                ?>       
                <div class="fav-cont notes-cont"> 
                    <?php echo (strlen($notes['message']) > 100) ? substr($notes['message'], 0, 100) . '..' : $notes['message']; ?>
                </div>         
            <?php }
            ?>
            <div class="viewall"><?php echo CHtml::link(Myclass::t('OG038', '', 'og'), array('/optirep/repNotes'), array('class' => '')); ?></div>        
            <?php
        } else {
            echo "<p class='fav_message'>You have no notes right now." . CHtml::link("Click", array('/optirep/repNotes/create')) . " to make your notes!!!.</p>";
        }
        ?>
    </div>
</div>

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
        <div class="cate-heading cate-heading4"> <i class="fa fa-envelope"></i> Latest News  </div>
        <?php
        $latest_news = NewsManagement::model()->latest_rep()->findAll();
        if (!empty($latest_news)) {
            foreach ($latest_news as $latest_new) {

                $dispname = (strlen($latest_new['TITRE']) >= 55) ? substr($latest_new['TITRE'], 0, 55) . '..' : $latest_new['TITRE'];
                ?>
                <div class="lastest-newscont">
                    <div class="lastest-newsconttxt"> 
                        <strong><?php echo CHtml::link($dispname, array('/optirep/newsManagement/view', 'id' => $latest_new['ID_NOUVELLE'])); ?></strong><br/> 
                        <?php //echo substr($latest_new['SYNOPSYS'],0,50).'...';    ?>
                    </div>
                    <div class="lastest-date"> <span> <?php echo date("M", strtotime($latest_new['DATE_AJOUT1'])) . ' ' . date("d", strtotime($latest_new['DATE_AJOUT1'])) ?> </span> </div>
                </div>  
            <?php } ?>
            <div class="viewall"><?php echo CHtml::link(Myclass::t('OG038', '', 'og'), array('/optirep/newsManagement'), array('class' => '')); ?></div>
        <?php } ?>
    </div>   
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ad1"> 
    <?php echo CHtml::image($this->themeUrl . '/images/ad.jpg'); ?>
</div>