<?php
$searchval = isset($_GET['searchval'])?$_GET['searchval']:'';
?>
<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
        <div class="inner-container eventslist-cont"> 
            <h2>  Search Results <?php echo ($searchval!='')?"for '".$searchval."'":'';?></h2>
            <div class="search-list">
                <?php 
                if(!empty($searchresults))
                {    
                    foreach ($searchresults as $infos) { 
                            
                            $expvals = explode('~',$infos);
                            
                            if($expvals[2]=="NEWS")
                            {
                                echo "<div class='news-thumbs search-results'>"
                           .         "<h4>".CHtml::link($expvals[0], array('/optiguide/newsManagement/view', 'id' => $expvals[1]))."<span class='newscolor'> NEWS </span></h4>                         
                                     </div>"; 
                            }
                            
                            if($expvals[2]=="EVENT")
                            {
                                echo "<div class='news-thumbs search-results'>"
                           .         "<h4>".CHtml::link($expvals[0], array('/optiguide/calenderEvent/view', 'id' => $expvals[1]))."<span class='eventcolor'> EVENT </span></h4>                         
                                     </div>"; 
                            }
                            
                            if($expvals[2]=="Miscellaneous")
                            {
                                echo "<div class='news-thumbs search-results'>"
                           .         "<h4>".CHtml::link($expvals[0], array('/optiguide/groupInformation/view', 'id' => $expvals[1]))."<span class='misccolor'> Miscellaneous </span></h4>                         
                                     </div>"; 
                            }
                            
                    }
                }  else {
                 echo "No results found";    
                }    ?>
               <?php
               $this->widget('CLinkPager', array(                   
                    'pages' => $pages,
                    'currentPage'=>$pages->getCurrentPage(),
                    'itemCount'=>$item_count,
                    'pageSize'=>$page_size,
                    'maxButtonCount'=>10,                                  
                    'header'=>'',   
                    'selectedPageCssClass'=>'active',
                    'htmlOptions'=>array(
                        'class'=>'pagination',                               
                    ), 
                ));
            ?>
            </div>
        </div>
    </div>
</div>