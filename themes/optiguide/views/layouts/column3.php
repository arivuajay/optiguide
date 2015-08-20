<?php $this->beginContent('//layouts/main'); ?>

<?php if (isset($this->flashMessages)): ?>
    <?php foreach ($this->flashMessages as $key => $message) { ?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 flashmessage"> 
            <div class="alert alert-<?php echo $key; ?> fade in">
                <button type="button" class="close close-sm" data-dismiss="alert">
                    <i class="fa fa-times"></i>
                </button>
                <?php echo $message; ?>
            </div>
        </div>
    <?php } ?>
<?php endif ?>

<div class="col-xs-12 col-sm-3 col-md-3 col-lg-2">  
    <?php
    if (Yii::app()->user->isGuest) {
        $this->widget('OgLoginFormWidget');
    } else {
        ?>
        <div class="pro-login">
            <p>
                <?php echo Myclass::t('OG051', '', 'og'); ?> <b><?php echo Yii::app()->user->name ?></b>
            </p>
            <p>
                <?php echo CHtml::link("<i class='fa fa-sign-out'></i> " . Myclass::t('OG025', '', 'og'), array('/optiguide/default/logout')) ?>
            </p>
        </div>
    <?php } ?>
    
    <div class="ad2"> 
        <?php echo CHtml::image("{$this->themeUrl}/images/ad3.jpg", 'Ad') ?>
    </div>
    <div class="ad2"> 
        <?php echo CHtml::image("{$this->themeUrl}/images/ad4.jpg", 'Ad') ?>
    </div>

    <?php 
   // if (!Yii::app()->user->isGuest)
        $this->widget('OgCalenderWidget'); 
    ?>
  
    <div class="ad2"> 
        <?php 
        echo CHtml::image("{$this->themeUrl}/images/bretonJOBS_logo_noslogan.jpg", 'Ad'); 
        $find_job = CHtml::image("{$this->themeUrl}/images/boutons-find.png", 'Ad');
        echo CHtml::link($find_job, 'http://bretonjobs.com/jobs/', array('target' => '_blank'));
        
        $post_job = CHtml::image("{$this->themeUrl}/images/boutons-post.png", 'Ad');
        echo CHtml::link($post_job, 'http://bretonjobs.com/pricing/', array('target' => '_blank'));
        ?>
    </div>
</div>

<div class="col-xs-12 col-sm-6 col-md-7 col-lg-8">
    <?php echo $content; ?>
</div>

<div class="col-xs-12 col-sm-3 col-md-2  col-lg-2"> 
    <div class="ad3">
        <?php echo CHtml::image("{$this->themeUrl}/images/ad2.jpg", 'Logo') ?>
    </div>
    <div class="ad3">
        <?php echo CHtml::image("{$this->themeUrl}/images/ad6.jpg", 'Logo') ?>
    </div>
      <?php    
     if (!Yii::app()->user->isGuest && Myclass::is_home_page())
    {    
        $pdate = date("Y-m",time());  
        $usertype = Yii::app()->user->getState('role');
        if($usertype=="Professionnels")
        {
            $utype = 1;
        }else if($usertype=="Fournisseurs")
        {
            $utype = 2;
        }else if($usertype=="Detaillants")
        {
            $utype = 3;
        } 
        $criteria = new CDbCriteria;
        $criteria->condition = "polldate like '%$pdate%' and usertype=$utype";
        $poll_rslt = Poll::model()->findAll( $criteria);           
        if(count($poll_rslt)>0)
        {  
           foreach($poll_rslt as $rid)
           {
               $polid = $rid['id'];
           }   
           if($polid!='')
           {    
                $this->widget('EPoll', array('poll_id' => $polid));
           }     
        }         
    }   
     ?>
</div>
<?php $this->endContent(); ?>