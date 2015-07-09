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
                
                array('label' => '<i class="fa fa-dashboard"></i> <span>Directories</span><i class="fa pull-right fa-angle-left"></i>', 'url' => '#',
                    'itemOptions' => array('class' => 'treeview'),
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span>Countries</span>', 'url' => array('/admin/countrydirectory/index'), 'active' => $_controller == 'CountryDirectoryController'),
                       array('label' => '<i class="fa fa-angle-double-right"></i> <span>Region</span>', 'url' => array('/admin/regiondirectory/index'), 'active' => $_controller == 'masterrole'),
                       array('label' => '<i class="fa fa-angle-double-right"></i> <span>Cities</span>', 'url' => array('/admin/citydirectory/index'), 'active' => $_controller == 'user'),
                    ),
                ),
            ),
            'htmlOptions' => array('class' => 'sidebar-menu')
        ));
        ?>
    </section>
</aside>
