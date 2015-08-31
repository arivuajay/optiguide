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
        
        $activeclass1 = array();
        $activeclass2 = array();
        $activeclass3 = array();
            
        if(Yii::app()->user->role=="Professionnels")
        {
          $profileurl =   '/optiguide/professionalDirectory/update';
        }else if(Yii::app()->user->role=="Detaillants")
        {
          $profileurl =   '/optiguide/retailerDirectory/update';
        }else if(Yii::app()->user->role=="Fournisseurs")
        {
          $profileurl =   '/optiguide/suppliersDirectory/update';
        }
        
        $module_controller = Yii::app()->controller->id;
        $module_action     = Yii::app()->controller->action->id;
        
        if(($module_controller == "professionalDirectory" || $module_controller == "retailerDirectory" || $module_controller == "suppliersDirectory") && $module_action=="update")
        {
            $activeclass1['class'] = 'active2';
        } 
        
        if($module_controller == "suppliersDirectory")
        {
            if( $module_action=="updateproducts" || $module_action=="updatemarques")
            {    
                $activeclass2['class'] = 'active2';
            }else if( $module_action=="transactions")
            {
                $activeclass3['class'] = 'active2';
            }
        }
        
        if($module_controller == "professionalDirectory")
        {
            if($module_action=="mappingretailers")
            {    
                $activeclass2['class'] = 'active2';
            }else if( $module_action=="listretailers")
            {
                $activeclass3['class'] = 'active2';
            }    
        }  
        
         if($module_controller == "userDirectory" && $module_action=="changepassword")
        {
            $activeclass4['class'] = 'active2';            
        }
        
        ?>
        <div class="pro-login">

            <div class="user-thumb"> <?php echo CHtml::image("{$this->themeUrl}/images/user-img.jpg", 'Ad');?> 
                 <?php echo Myclass::t('OG051', '', 'og'); ?><br/> 
                <b><?php echo Yii::app()->user->name ?></b>
            </div>
            <ul>
                <li> <?php echo CHtml::link(Myclass::t('OG033', '', 'og'), array($profileurl), $activeclass1);?> </li>
                <?php
                if(Yii::app()->user->role=="Fournisseurs")
                {?>
                    <li> <?php echo CHtml::link(Myclass::t('OG059', '', 'og'), array('/optiguide/suppliersDirectory/updateproducts'), $activeclass2);?> </li> 
                    <li> <?php echo CHtml::link(Myclass::t('OGO139', '', 'og'), array('/optiguide/suppliersDirectory/transactions'), $activeclass3);?> </li> 
                <?php                 
                }                
                if(Yii::app()->user->role=="Professionnels")
                {?>
                    <li> <?php echo CHtml::link(Myclass::t('OGO146', '', 'og'), array('/optiguide/professionalDirectory/mappingretailers'), $activeclass2);?> </li>  
                     <li> <?php echo CHtml::link(Myclass::t('OGO149', '', 'og'), array('/optiguide/professionalDirectory/listretailers'), $activeclass3);?> </li> 
                <?php                 
                } ?>    
                <li> <?php echo CHtml::link(Myclass::t('OGO112', '', 'og'), array('/optiguide/userDirectory/changepassword'), $activeclass4);?> </li>
                <li> <?php echo CHtml::link("<i class='fa fa-sign-out'></i> " . Myclass::t('OG025', '', 'og'), array('/optiguide/default/logout')) ?></li>
            </ul>
        </div>
    <?php } ?>

    <div class="ad2"> 
        <!--  Menu - position - 3 -->
        <?php echo Myclass::banner_display(3); ?>
    </div>


    <div class="ad2"> 
        <!--  Island- position - 4 -->
        <?php echo Myclass::banner_display(4); ?>
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
        <!--  Sky Scraper - position - 5 -->
        <?php echo Myclass::banner_display(5); ?>
    </div>


    <div class="ad3">   
        <!--  Parking - position - 6 -->
        <?php echo Myclass::banner_display(6); ?>
    </div>

    <?php
    if (!Yii::app()->user->isGuest && Myclass::is_home_page()) {
        $pdate = date("Y-m", time());
        $usertype = Yii::app()->user->getState('role');
        if ($usertype == "Professionnels") {
            $utype = 1;
        } else if ($usertype == "Fournisseurs") {
            $utype = 2;
        } else if ($usertype == "Detaillants") {
            $utype = 3;
        }
        $criteria = new CDbCriteria;
        $criteria->condition = "polldate like '%$pdate%' and usertype=$utype";
        $poll_rslt = Poll::model()->findAll($criteria);
        if (count($poll_rslt) > 0) {
            foreach ($poll_rslt as $rid) {
                $polid = $rid['id'];
            }
            if ($polid != '') {
                $this->widget('EPoll', array('poll_id' => $polid));
            }
        }
    }
    ?>
</div>
<?php $this->endContent(); ?>