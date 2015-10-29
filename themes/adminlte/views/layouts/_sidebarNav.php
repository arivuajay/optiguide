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
        $_action = Yii::app()->controller->action->id;
        $this->widget('zii.widgets.CMenu', array(
            'activateParents' => true,
            'encodeLabel' => false,
            'activateItems' => true,
            'items' => array(
                array('label' => '<i class="fa fa-dashboard"></i> <span>Dashboard</span>', 'url' => Yii::app()->homeUrl),
                array('label' => '<i class="fa fa-newspaper-o"></i> <span>Nouvelles</span>', 'url' => array('/admin/newsManagement/index'), 'active' => $_controller == 'newsManagement'),
                array('label' => '<i class="fa fa-calendar"></i> <span>Calendrier</span>', 'url' => array('/admin/calenderEvent/index'), 'active' => $_controller == 'calenderEvent'),
                array('label' => '<i class="fa fa-briefcase"></i> <span>Publicité</span><i class="fa pull-right fa-angle-left"></i>', 'url' => '#',
                    'itemOptions' => array('class' => 'treeview'),
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span>Gestion des publicités</span>', 'url' => array('/admin/publicityAds/index'), 'active' => ($_controller == 'publicityAds')),
                         array('label' => '<i class="fa fa-angle-double-right"></i> <span>Gestion des adSense</span>', 'url' => array('/admin/publiciteAdsense/index'), 'active' => ($_controller == 'publiciteAdsense')),
                    ),
                ),
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
                array('label' => '<i class="fa fa-folder"></i> <span> Fournisseurs</span><i class="fa pull-right fa-angle-left"></i>', 'url' => '#',
                    'itemOptions' => array('class' => 'treeview'),
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span>Gestion des fournisseurs</span>', 'url' => array('/admin/suppliersDirectory/index'), 'active' => $_controller == 'suppliersDirectory'),
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span>Fournisseurs Transactions De Paiement </span>', 'url' => array('/admin/paymentTransaction/index'), 'active' => ($_controller == 'paymentTransaction' && $_action=="index")),
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span>Paramètres </span>', 'url' => array('/admin/supplierSubscriptionPrice/index'), 'active' => ($_controller == 'supplierSubscriptionPrice'&& $_action=="index")),
                    ),
                ),
                array('label' => '<i class="fa fa-briefcase"></i> <span>Professionnels</span><i class="fa pull-right fa-angle-left"></i>', 'url' => '#',
                    'itemOptions' => array('class' => 'treeview'),
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span>Gestion des professionnels</span>', 'url' => array('/admin/professionalDirectory/index'), 'active' => $_controller == 'professionalDirectory'),
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span>Gestion des types de professionnels</span>', 'url' => array('/admin/professionalType/index'), 'active' => $_controller == 'professionalType'),
                    ),
                ),
                array('label' => '<i class="fa fa-group"></i> <span>Associations</span>', 'url' => array('/admin/categoryInformation/index'), 'active' => $_controller == 'categoryInformation'),
               /*
                array('label' => '<i class="fa fa-globe"></i> <span> Régions</span><i class="fa pull-right fa-angle-left"></i>', 'url' => '#',
                    'itemOptions' => array('class' => 'treeview'),
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('label' => '<i class="fa fa-globe"></i> <span>Pays</span>', 'url' => array('/admin/countryDirectory/index'), 'active' => $_controller == 'countryDirectory'),
                        array('label' => '<i class="fa fa-building-o"></i> <span>Régions</span>', 'url' => array('/admin/regionDirectory/index'), 'active' => $_controller == 'regionDirectory'),
                        array('label' => '<i class="fa fa-building"></i> <span>Villes</span>', 'url' => array('/admin/cityDirectory/index'), 'active' => $_controller == 'cityDirectory'),
                    ),
                ),
                * 
                */
                array('label' => '<i class="fa fa-gear"></i> <span>Archivage</span>', 'url' => array('/admin/archiveCategory/index')),
                // array('label' => '<i class="fa fa-dashboard"></i> <span>Utilisateurs</span>', 'url' => array('/admin/userdirectory/index'), 'active' => $_controller == 'userdirectory'),
                array('label' => '<i class="fa fa-line-chart"></i> <span>Sondages</span>', 'url' => array('/admin/poll/index'), 'active' => $_controller == 'poll'),
                array('label' => '<i class="fa fa-bell"></i> <span> Client Profiles</span><i class="fa pull-right fa-angle-left"></i>', 'url' => '#',
                    'itemOptions' => array('class' => 'treeview'),
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(    
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span>Category Types </span>', 'url' => array('/admin/clientCategoryTypes/index'), 'active' => ($_controller == 'clientCategoryTypes')),
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span>Category Names </span>', 'url' => array('/admin/clientCategory/index'), 'active' => ($_controller == 'clientCategory')),
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span>Profils D\'employés </span>', 'url' => array('/admin/employeeProfiles/index'), 'active' => ($_controller == 'employeeProfiles')),
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span>Les profils des clients</span>', 'url' => array('/admin/clientProfiles/index'), 'active' => ($_controller == 'clientProfiles')),
                       // array('label' => '<i class="fa fa-angle-double-right"></i> <span>Rappelez-vous des alertes</span>', 'url' => array('/admin/clientMessages/index'), 'active' => ( $_controller == 'clientMessages')),
                    ),
                ),
                array('label' => '<i class="fa fa-folder"></i> <span> Opti-rep</span><i class="fa pull-right fa-angle-left"></i>', 'url' => '#',
                    'itemOptions' => array('class' => 'treeview'),
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(      
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span>Sales Rep</span>', 'url' => array('/admin/repCredential/index'), 'active' => ($_controller == 'repCredential' && $_action=="index")),
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span>Transactions de paiement Optirep</span>', 'url' => array('/admin/paymentTransaction/reptransaction'), 'active' => ($_controller == 'paymentTransaction' && $_action=="reptransaction")),
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span>Paramètres </span>', 'url' => array('/admin/supplierSubscriptionPrice/statsprice'), 'active' => $_controller == 'supplierSubscriptionPrice' && $_action=="statsprice"),
                    ),
                ),
            ),
            'htmlOptions' => array('class' => 'sidebar-menu')
        ));
        ?>
    </section>
</aside>
