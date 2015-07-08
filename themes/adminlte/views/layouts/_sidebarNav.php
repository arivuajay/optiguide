<aside class="left-side sidebar-offcanvas">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left info">
                <p>Hello, <?php echo Inflector::camel2words(Yii::app()->user->name) ?></p>
                <a href="javascript:void(0)">
                    <i class="fa fa-circle text-success"></i> Online
                </a>
            </div>
        </div>

        <?php
        $this->widget('zii.widgets.CMenu', array(
            'activateParents' => true,
            'encodeLabel' => false,
            'activateItems' => true,
            'items' => array(
                array('label' => '<i class="fa fa-dashboard"></i> <span>Dashboard</span>', 'url' => Yii::app()->homeUrl),
                array('label' => '<i class="fa fa-dashboard"></i> <span>Archive Categories</span>', 'url' => array('/admin/archiveCategory/index')),
//                array('label' => '<i class="fa fa-briefcase"></i> <span>Administration</span><i class="fa pull-right fa-angle-left"></i>', 'url' => '#',
//                    'itemOptions' => array('class' => 'treeview'),
//                    'submenuOptions' => array('class' => 'treeview-menu'),
//                    'items' => array(
//                        array('label' => '<i class="fa fa-weixin"></i> <span>Society</span>', 'url' => array('/site/society/index'), 'active' => $_controller == 'society'),
//                        array('label' => '<i class="fa fa-music"></i> <span>Roles</span>', 'url' => array('/site/masterrole/index'), 'active' => $_controller == 'masterrole'),
//                        array('label' => '<i class="fa fa-user"></i> <span>Operator</span>', 'url' => array('/site/user/index'), 'active' => $_controller == 'user'),
//                    ),
//                ),
            ),
            'htmlOptions' => array('class' => 'sidebar-menu')
        ));
        ?>
    </section>
</aside>
