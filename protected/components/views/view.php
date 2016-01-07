<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">   
    <div class="latest-newscont"> 
            <?php 
            $lang = Yii::app()->session['language'];   
            if($lang=="FR")
            {
                $thnksimg = "thankvote-fr.jpeg";
            }else{
                $thnksimg = "thankvote.jpeg";
            }    
            echo CHtml::image(Yii::app()->theme->baseUrl."/images/".$thnksimg, 'Thanks for Poll');?>            
<!--    <h2><?php //echo  Myclass::t('OG151');?></h2>
        <h4><?php //echo $Title;?></h4>
        <?php //$this->render('results', array('model' => $model)); ?>
        <?php //if ($userVote->id): ?>
          <p id="pollvote-<?php //echo $userVote->id ?>">  You voted: <strong><?php //echo $userChoice->label ?></strong>.<br /> </p>
        <?php //endif; ?>         -->
    </div>
</div>
