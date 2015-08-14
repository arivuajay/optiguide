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
                
                array('label' => '<i class="fa fa-newspaper-o"></i> <span>Nouvelles</span>', 'url' => array('/admin/newsManagement/index'), 'active' => $_controller == 'newsManagement'),
                
                
                array('label' => '<i class="fa fa-calendar"></i> <span>Calendrier</span>', 'url' => array('/admin/calenderEvent/index'), 'active' => $_controller == 'calenderEvent'),
                
                 array('label' => '<i class="fa fa-photo"></i> <span>Publicité</span>', 'url' => array('/admin/publicityAds/index'), 'active' => $_controller == 'publicityAds'),
                
                array('label' => '<i class="fa fa-list"></i> <span>Saviez-vous que ?</span>', 'url' => array('/admin/managementAdvice/index'), 'active' => $_controller == 'managementAdvice'),
                
                array('label' => '<i class="fa fa-folder"></i> <span> Produits & Services</span><i class="fa pull-right fa-angle-left"></i>', 'url' => '#',
                    'itemOptions' => array('class' => 'treeview'),
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span>Gestion des produits & services</span>', 'url' => array('/admin/productDirectory/index'), 'active' => $_controller == 'productDirectory'),
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span>Gestion des sections</span>', 'url' => array('/admin/sectionDirectory/index'), 'active' => $_controller == 'sectionDirectory'),
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span>Gestion des marques</span>', 'url' => array('/admin/marqueDirectory/index'), 'active' => $_controller == 'marqueDirectory'),
                    ),
                ),
                array('label' => '<i class="fa fa-users"></i> <span>Détaillants</span>', 'url' => array('/admin/retailerDirectory/index'), 'active' => $_controller == 'retailerdirectory'),
                
                array('label' => '<i class="fa fa-users"></i> <span>Fournisseurs</span>', 'url' => array('/admin/suppliersDirectory/index'), 'active' => $_controller == 'suppliersdirectory'),
                
                array('label' => '<i class="fa fa-briefcase"></i> <span>Professionnels</span><i class="fa pull-right fa-angle-left"></i>', 'url' => '#',
                    'itemOptions' => array('class' => 'treeview'),
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span>Gestion des professionnels</span>', 'url' => array('/admin/professionalDirectory/index'), 'active' => $_controller == 'professionalDirectory'),
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span>Gestion des types de professionnels</span>', 'url' => array('/admin/professionalType/index'), 'active' => $_controller == 'professionalType'),
                    ),
                ),
                array('label' => '<i class="fa fa-group"></i> <span>Associations</span>', 'url' => array('/admin/categoryInformation/index'), 'active' => $_controller == 'categoryInformation'),
              
                array('label' => '<i class="fa fa-globe"></i> <span> Régions</span><i class="fa pull-right fa-angle-left"></i>', 'url' => '#',
                    'itemOptions' => array('class' => 'treeview'),
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('label' => '<i class="fa fa-globe"></i> <span>Pays</span>', 'url' => array('/admin/countryDirectory/index'), 'active' => $_controller == 'countryDirectory'),
                        array('label' => '<i class="fa fa-building-o"></i> <span>Régions</span>', 'url' => array('/admin/regionDirectory/index'), 'active' => $_controller == 'regionDirectory'),
                        array('label' => '<i class="fa fa-building"></i> <span>Villes</span>', 'url' => array('/admin/cityDirectory/index'), 'active' => $_controller == 'cityDirectory'),
                    ),
                ),
                array('label' => '<i class="fa fa-gear"></i> <span>Archivage</span>', 'url' => array('/admin/archiveCategory/index')),
            // array('label' => '<i class="fa fa-dashboard"></i> <span>Utilisateurs</span>', 'url' => array('/admin/userdirectory/index'), 'active' => $_controller == 'userdirectory'),
                
                 array('label' => '<i class="fa fa-line-chart"></i> <span>Sondages</span>', 'url' => array('/admin/poll/index'), 'active' => $_controller == 'poll'),
                
                  array('label' => '<i class="fa fa-bell"></i> <span>Client Profiles</span>', 'url' => array('/admin/clientProfiles/index'), 'active' => $_controller == 'clientProfiles'),
            ),
            'htmlOptions' => array('class' => 'sidebar-menu')
        ));
        ?>
    </section>
</aside>
