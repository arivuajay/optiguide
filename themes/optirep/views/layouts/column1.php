<?php $this->beginContent("//layouts/authenticate_page"); ?>
<div class="body-cont repadmincont"> 
    <div class="container"> 
        <div class="row">
            <?php 
            if(!Yii::app()->user->isGuest)
            { 
                $this->renderPartial('//layouts/_submenu');
            } ?>
            <?php echo $content; ?>
        </div>
    </div>
</div>
<?php $this->endContent(); ?>