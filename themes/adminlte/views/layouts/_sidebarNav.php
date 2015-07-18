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
        // Current controller name
        $_controller = Yii::app()->controller->id;
        
        $this->widget('zii.widgets.CMenu', array(
            'activateParents' => true,
            'encodeLabel' => false,
            'activateItems' => true,
            'items' => array(
                array('label' => '<i class="fa fa-dashboard"></i> <span>Dashboard</span>', 'url' => Yii::app()->homeUrl),
                
                //array('label' => '<i class="fa fa-dashboard"></i> <span>Détaillants</span>', 'url' => array('/admin/retailerDirectory/index'), 'active' => $_controller == 'retailerdirectory'),
                
               // array('label' => '<i class="fa fa-dashboard"></i> <span>Fournisseurs</span>', 'url' => array('/admin/suppliersDirectory/index'), 'active' => $_controller == 'suppliersdirectory'),
                
                
                array('label' => '<i class="fa fa-dashboard"></i> <span>Professionnels</span><i class="fa pull-right fa-angle-left"></i>', 'url' => '#',
                    'itemOptions' => array('class' => 'treeview'),
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span>Gestion des professionnels</span>', 'url' => array('/admin/professionalDirectory/index'), 'active' => $_controller == 'professionalDirectory'),
                       array('label' => '<i class="fa fa-angle-double-right"></i> <span>Gestion des types de professionnels</span>', 'url' => array('/admin/professionalType/index'), 'active' => $_controller == 'professionalType'),
                    ),
                ),
                
                array('label' => '<i class="fa fa-dashboard"></i> <span>Associations</span>', 'url' => array('/admin/categoryInformation/index'), 'active' => $_controller == 'categoryInformation'),
                
                  array('label' => '<i class="fa fa-dashboard"></i> <span> Régions</span><i class="fa pull-right fa-angle-left"></i>', 'url' => '#',
                    'itemOptions' => array('class' => 'treeview'),
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span>Countries</span>', 'url' => array('/admin/countryDirectory/index'), 'active' => $_controller == 'countryDirectory'),
                       array('label' => '<i class="fa fa-angle-double-right"></i> <span>Region</span>', 'url' => array('/admin/regionDirectory/index'), 'active' => $_controller == 'regionDirectory'),
                       array('label' => '<i class="fa fa-angle-double-right"></i> <span>Cities</span>', 'url' => array('/admin/cityDirectory/index'), 'active' => $_controller == 'cityDirectory'),
                    ),
                ),
                
                array('label' => '<i class="fa fa-dashboard"></i> <span>Archivage</span>', 'url' => array('/admin/archiveCategory/index')),
                
               // array('label' => '<i class="fa fa-dashboard"></i> <span>Utilisateurs</span>', 'url' => array('/admin/userdirectory/index'), 'active' => $_controller == 'userdirectory'),
               
            ),
            'htmlOptions' => array('class' => 'sidebar-menu')
        ));
        ?>
    </section>
</aside>
