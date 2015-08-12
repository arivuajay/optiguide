<div class="optinews-left"> 
    <div class="optinews-left-heading"> Poll </div>
    <div class="optinews-left-bg polls-bg"> 
        <h4><?php echo $Title;?></h4>
        <?php $this->render('results', array('model' => $model)); ?>
        <?php if ($userVote->id): ?>
          <p id="pollvote-<?php echo $userVote->id ?>">  You voted: <strong><?php echo $userChoice->label ?></strong>.<br /> </p>
        <?php endif; ?>         
    </div>
</div>
