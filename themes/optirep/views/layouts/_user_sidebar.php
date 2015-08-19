<div class="user-left cate-bg"> 
    <div class="user-deatils"> 
        <p> <?php echo CHtml::image("{$this->themeUrl}/images/user-img.jpg", 'Profile Image'); ?></p>
        <p> <?php echo CHtml::link(Yii::app()->user->username, '/optirep/salesRep/dashboard')?> <a href="#"></a></p>
        <p> <i class="fa fa-sign-out"></i> 
            <?php echo CHtml::link('Logout', '/optirep/default/logout')?>
        </p>
    </div>

    <?php
    $this->widget('zii.widgets.CMenu', array(
        'items' => array(
            // Important: you need to specify url as 'controller/action',
            // not just as 'controller' even if default action is used.
            array('label' => 'Change Password', 'url' => array('/optirep/salesRep/changePassword')),
        ),
        'activeCssClass' => 'active2'
    ));
    ?>
</div> 