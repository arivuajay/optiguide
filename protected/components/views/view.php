<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">   
    <div class="latest-newscont"> 
        <h2><?php echo  Myclass::t('OG151');?></h2>
        <h4><?php echo $Title;?></h4>
        <?php $this->render('results', array('model' => $model)); ?>
        <?php if ($userVote->id): ?>
          <p id="pollvote-<?php echo $userVote->id ?>">  You voted: <strong><?php echo $userChoice->label ?></strong>.<br /> </p>
        <?php endif; ?>         
    </div>
</div>
