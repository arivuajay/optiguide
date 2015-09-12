<?php
if (Myclass::is_home_page()) {
    
    $pdate = date("Y-m", time());
    $usertype = Yii::app()->user->getState('role');
    if ($usertype == "Professionnels") {
        $utype = 1;
    } else if ($usertype == "Fournisseurs") {
        $utype = 2;
    } else if ($usertype == "Detaillants") {
        $utype = 3;
    }else
    {
        $utype = 1;
    }
    
    $criteria = new CDbCriteria;
    $criteria->condition = "polldate like '%$pdate%' and usertype=$utype";
    $poll_rslt = Poll::model()->findAll($criteria);
    if (count($poll_rslt) > 0) {
        foreach ($poll_rslt as $rid) {
            $polid = $rid['id'];
        }
        if($polid != '') {
            $this->widget('EPoll', array('poll_id' => $polid));
        }
    }else
    {?>
     <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">   
        <div class="latest-newscont"> 
             <h2><?php echo  Myclass::t('OG151');?></h2>   
             <p>Please keep a watch...your polling question will be up in this space soon!</p>
        </div>
    </div>     
   <?php }    
}
?>