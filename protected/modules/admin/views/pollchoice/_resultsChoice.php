<div class="result">
    <!--  <div class="label">-->
    <div class="">
        <?php echo CHtml::encode($choice->label); ?>
    </div>   
    <div class="progress progress-striped">
        <div style="width: <?php echo $percent; ?>%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-primary">
            <span class="sr-only">40% Complete (success)</span>
        </div>
    </div>
    <div class="totals">
        <span class="percent"><?php echo $percent; ?>%</span>
        <span class="votes">(<?php echo $voteCount; ?> <?php echo $voteCount == 1 ? 'Vote' : 'Votes'; ?>)</span>
    </div>
</div>
