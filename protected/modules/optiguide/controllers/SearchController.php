<?php

class SearchController extends OGController
{
    public $lang;

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
        $this->lang = Yii::app()->session['language'];
    }
    
    public function actionIndex()
    {  
        $searchresults = array();
        $searchresults_news = array();
        $searchresults_cals = array();
        $searchresults_grps = array();
        $searchval = isset($_GET['searchval'])?$_GET['searchval']:'';
        $current_date = date("Y-m-d");

        // News 

        $newscriteria = new CDbCriteria();
        if ($searchval!='') {                                
            $newscriteria->addSearchCondition('TITRE', $searchval);
        }
        $newscriteria->addCondition('LANGUE = "' . Yii::app()->session['language'] . '"');
        $newscriteria->order = 'TITRE ASC';

        $ncount   = NewsManagement::model()->count($newscriteria);
        $nmodel   = NewsManagement::model()->findAll($newscriteria);

        if(!empty($nmodel))
        {    
            foreach($nmodel as $newsinfo)
            {
//                    $searchresults_news[] = "<div class='news-thumbs search-results'>"
//                            . "<h4>".CHtml::link($newsinfo['TITRE'], array('/optiguide/newsManagement/view', 'id' => $newsinfo['ID_NOUVELLE']))."<span> NEWS </span></h4>                         
//                        </div>"; 
                $searchresults_news[] = $newsinfo['TITRE'].'~'.$newsinfo['ID_NOUVELLE'].'~'.'NEWS';
            }
        }  


        // Calender events

        $calcriteria = new CDbCriteria();
        $calcriteria->addCondition('LANGUE = "' . Yii::app()->session['language'] . '"');
        if ($searchval!='') {           
            $calcriteria->addSearchCondition('TITRE', $searchval);
        }
        $calcriteria->addCondition('DATE_AJOUT1 >= "' . $current_date . '"');
        $calcriteria->addCondition('AFFICHER_SITE = 1');
        $calcriteria->order = 'TITRE ASC';

        $calcount = CalenderEvent::model()->count($calcriteria);
        $calmodel = CalenderEvent::model()->findAll($calcriteria);

        if(!empty($calmodel))
        {    
            foreach($calmodel as $event)
            {
//                    $searchresults_cals[] = "<div class='news-thumbs search-results'>"
//                            . "<h4>".CHtml::link($event['TITRE'], array('/optiguide/calenderEvent/view', 'id' => $event['ID_EVENEMENT'])) ."<span> EVENT </span></h4>                         
//                        </div>";   
                 $searchresults_cals[] = $event['TITRE'].'~'.$event['ID_EVENEMENT'].'~'.'EVENT';
            } 
        }

        // Miscellaneous

        $grpcriteria = new CDbCriteria();           
        if ($searchval!='') {           
            $grpcriteria->addSearchCondition('NOM_GROUPE', $searchval);
        }
        $grpcriteria->order = 'NOM_GROUPE ASC';

        $grpcount = GroupInformation::model()->count($grpcriteria);
        $grpmodel = GroupInformation::model()->findAll($grpcriteria);

         if(!empty($grpmodel))
        {    
            foreach($grpmodel as $ginfo)
            {
//                    $searchresults_grps[] = "<div class='news-thumbs search-results'>"
//                            . "<h4>".CHtml::link($ginfo['NOM_GROUPE'], array('/optiguide/groupInformation/view', 'id' => $ginfo['ID_GROUPE'])) ."<span> Miscellaneous </span></h4>                         
//                        </div>";    
                  $searchresults_grps[] = $ginfo['NOM_GROUPE'].'~'.$ginfo['ID_GROUPE'].'~'.'Miscellaneous';
            } 
        }  

        // Merge all results
        $searchresults = array_merge($searchresults_news,$searchresults_cals,$searchresults_grps);

        // Sort alphatic order the merge results
        usort($searchresults, function($a,$b) {
            if ($a[0] == $b[0]) return 0; 
            return $a[0] < $b[0] ? -1 : 1;
          });           

        // Set pagination for the results
        $page = Yii::app()->request->getParam('page');
        $page = isset($page) ? $page : 1;
        $limit = 0;

        if ($page > 1) {
            $offset = $page - 1;
            $limit = LISTPERPAGE * $offset;
        }

        // Split the result values for the pages
        $newArray = array_slice($searchresults, $limit, LISTPERPAGE, true);    

        // Total search item counts
        $item_count =   $ncount+$calcount+$grpcount;

        $pages = new CPagination($item_count);
        $pages->setPageSize(LISTPERPAGE);           

        $this->render('index',array(
            'searchresults' => $newArray,               
            'item_count' => $item_count,
            'page_size' => LISTPERPAGE,
            'pages' => $pages)
        );
    }
        
 function array_qsort2 (&$array, $column=0, $order="ASC") {
        $oper = ($order == "ASC")?">":"<";
        if(!is_array($array)) return;
        usort($array, create_function('$a,$b',"return (\$a['$column'] $oper \$b['$column']);")); 
        reset($array);
    }

}