<?php
$this->title = 'Dashboard';
$this->breadcrumbs = array(
    $this->title
);

$profesional_count = ProfessionalDirectory::model()->count();
$retailer_count = RetailerDirectory::model()->count();
$supplier_count = SuppliersDirectory::model()->count();
$rep_count = RepCredentials::model()->count("rep_role='single'");
$view = "View All <i class='fa fa-arrow-circle-right'></i>";
?>
<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3><?php echo $profesional_count; ?></h3>
                <p> Professionals </p>
            </div>
            <div class="icon"> <i class="ion-briefcase"></i> </div>
            <?php echo CHtml::link($view, array('/admin/professionalDirectory/index'), array("class" => 'small-box-footer')); ?>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3><?php echo $retailer_count; ?></h3>
                <p>Retailers </p>
            </div>
            <div class="icon">  <i class="ion-person-stalker"></i>  </div>
            <?php echo CHtml::link($view, array('/admin/retailerDirectory/index'), array("class" => 'small-box-footer')); ?>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3><?php echo $supplier_count; ?></h3>
                <p>Suppliers </p>
            </div>
            <div class="icon"> <i class="ion-android-social"></i></div>
            <?php echo CHtml::link($view, array('/admin/suppliersDirectory/index'), array("class" => 'small-box-footer')); ?>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3><?php echo $rep_count; ?></h3>
                <p>Reps</p>
            </div>
            <div class="icon"><i class="ion-ios7-people"></i></div>
            <a href="javascript:void(0);" class="small-box-footer">
                &nbsp;
            </a>
        </div>
    </div><!-- ./col -->

   
    <div class="col-lg-6 col-xs-12">
        <?php   
        // Display register stats per month for optiguide.com
        $months = array();
        for ($i = 0; $i < 6; $i++) {
            array_push($months, date("M Y", strtotime($i . " months ago")));
        }

        $response['months'] = array();
        foreach ($months as $month) {
            array_push($response["months"], $month);
        }
        
        $usertypes = array("Professionals","Retailers","Suppliers");
        
        foreach($usertypes as $key => $utype)
        {    
            // Count  profile view counts  per month
            $response['viewcounts'] = array();
            $viewcounts = '';
            foreach ($months as $month) {
                
                $searchdate = date("Y-m",strtotime($month));
                if($utype=="Professionals")
                {    
                    $viewcounts = ProfessionalDirectory::model()->count(" CREATED_DATE like '%$searchdate%'");
                }  
                
                if($utype=="Retailers")
                { 
                    $viewcounts = RetailerDirectory::model()->count(" CREATED_DATE like '%$searchdate%'");
                }
                
                if($utype=="Suppliers")
                {
                   $viewcounts = SuppliersDirectory::model()->count(" CREATED_DATE like '%$searchdate%'"); 
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
                    'text' => 'Users registered in Optiguide.com.'
                ),
                'subtitle' => array(
                    'text' => 'Last 6 months'
                ),
                'xAxis' => array(
                    'categories' => $response['months'],
                    'crosshair' =>  true
                ),
                'yAxis' => array(
                    'title' => array(
                        'text' => 'Registered counts'
                    ),
                    'min' => 0,
                ),
                'tooltip' => array(
                    'headerFormat' => '<span style="font-size:10px">{point.key}</span><table>',
                    'pointFormat' =>  '<tr><td style="color:{series.color};padding:0">{series.name}: </td><td style="padding:0"><b>{point.y}</b></td></tr>',
                    'footerFormat' => '</table>',
                    'shared' =>  true,
                    'useHTML' => true
                ),
                'plotOptions' => array(
                    'column' => array(
                        'pointPadding' => 0.2,
                        'borderWidth' =>  0
                        )
                  ),
                'series' => $response['allprofiles']           
            )    
        ));
        ?>
    </div><!-- /.row -->
    
    <div class="col-lg-6 col-xs-12">
        <?php   
        // Display register stats per month for optiguide.com
        $months = array();
        $response = array();
        
        for ($i = 0; $i < 6; $i++) {
            array_push($months, date("M Y", strtotime($i . " months ago")));
        }

        $response['months'] = array();
        foreach ($months as $month) {
            array_push($response["months"], $month);
        }
        
        $usertypes = array("Rep-Single","Rep-Admin");
        
        foreach($usertypes as $key => $utype)
        {    
            // Count  profile view counts  per month
            $response['viewcounts'] = array();
            $viewcounts = '';
            foreach ($months as $month) {
                
                $searchdate = date("Y-m",strtotime($month));
                $condition_type = ($utype=="Rep-Single")?"single":"admin";
                $viewcounts = RepCredentials::model()->count("rep_role='$condition_type' AND created_at like '%$searchdate%'");
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
                    'text' => 'Users registered in Optirep.com.'
                ),
                'subtitle' => array(
                    'text' => 'Last 6 months'
                ),
                'xAxis' => array(
                    'categories' => $response['months'],
                    'crosshair' =>  true
                ),
                'yAxis' => array(
                    'title' => array(
                        'text' => 'Registered counts'
                    ),
                    'min' => 0,
                ),
                'tooltip' => array(
                    'headerFormat' => '<span style="font-size:10px">{point.key}</span><table>',
                    'pointFormat' =>  '<tr><td style="color:{series.color};padding:0">{series.name}: </td><td style="padding:0"><b>{point.y}</b></td></tr>',
                    'footerFormat' => '</table>',
                    'shared' =>  true,
                    'useHTML' => true
                ),
                'plotOptions' => array(
                    'column' => array(
                        'pointPadding' => 0.2,
                        'borderWidth' =>  0
                        )
                  ),
                'series' => $response['allprofiles']           
            )    
        ));
        ?>
    </div><!-- /.row -->
       
