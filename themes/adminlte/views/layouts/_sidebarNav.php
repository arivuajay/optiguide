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
         $uid = Yii::app()->user->id;
        
        // Current controller name
        $_controller = Yii::app()->controller->id;
        $_action = Yii::app()->controller->action->id;
        $this->widget('application.components.MyMenu', array(
            'activateParents' => true,
            'encodeLabel' => false,
            'activateItems' => true,
            'items' => array(
                array('label' => '<i class="fa fa-dashboard"></i> <span>Dashboard</span>', 'url' => Yii::app()->homeUrl),
                array('label' => '<i class="fa fa-cog"></i> <span>Administration</span><i class="fa pull-right fa-angle-left"></i>', 'url' => '#',
                    'itemOptions' => array('class' => 'treeview'),
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'visible' => '1',
                    'items' => array(                      
                        array('label' => '<i class="fa fa-music"></i> <span>Roles</span>', 'url' => array('/admin/masterrole/index') , 'visible' => '1'),
                        array('label' => '<i class="fa fa-user"></i> <span>Users</span>', 'url' => array('/admin/admin/index') , 'visible' => '1' ),
                    ),
                ),
                array('label' => '<i class="fa fa-bell"></i> <span> Client Profiles</span><i class="fa pull-right fa-angle-left"></i>', 'url' => '#',
                    'itemOptions' => array('class' => 'treeview'),
                    'submenuOptions' => array('class' => 'treeview-menu'),
                     'visible' => '1',
                    'items' => array(    
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span>Category Types </span>', 'url' => array('/admin/clientCategoryTypes/index'), 'active' => ($_controller == 'clientCategoryTypes'),  'visible' => '1'),
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span>Category Names </span>', 'url' => array('/admin/clientCategory/index'), 'active' => ($_controller == 'clientCategory'),  'visible' => '1'),
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span>Profils D\'employés </span>', 'url' => array('/admin/employeeProfiles/index'), 'active' => ($_controller == 'employeeProfiles'),  'visible' => '1'),
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span>Les profils des clients</span>', 'url' => array('/admin/clientProfiles/index'), 'active' => ($_controller == 'clientProfiles'),  'visible' => '1'),
                       // array('label' => '<i class="fa fa-angle-double-right"></i> <span>Rappelez-vous des alertes</span>', 'url' => array('/admin/clientMessages/index'), 'active' => ( $_controller == 'clientMessages')),
                    ),
                ),
                array('label' => '<i class="fa fa-newspaper-o"></i> <span>Nouvelles</span>', 'url' => array('/admin/newsManagement/index'), 'active' => ($_controller == 'newsManagement') ,  'visible' => '1'),
                array('label' => '<i class="fa fa-calendar"></i> <span>Calendrier</span>', 'url' => array('/admin/calenderEvent/index'), 'active' => $_controller == 'calenderEvent',  'visible' => '1'),
                array('label' => '<i class="fa fa-briefcase"></i> <span>Publicité</span><i class="fa pull-right fa-angle-left"></i>', 'url' => '#',
                    'itemOptions' => array('class' => 'treeview'),
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span>Gestion des publicités</span>', 'url' => array('/admin/publicityAds/index'), 'active' => ($_controller == 'publicityAds'),  'visible' => '1'),
                         array('label' => '<i class="fa fa-angle-double-right"></i> <span>Gestion des adSense</span>', 'url' => array('/admin/publiciteAdsense/index'), 'active' => ($_controller == 'publiciteAdsense'),  'visible' => '1'),
                    ),
                ),
                array('label' => '<i class="fa fa-list"></i> <span>Saviez-vous que ?</span>', 'url' => array('/admin/managementAdvice/index'), 'active' => $_controller == 'managementAdvice',  'visible' => '1'),
                array('label' => '<i class="fa fa-folder"></i> <span> Produits & Services</span><i class="fa pull-right fa-angle-left"></i>', 'url' => '#',
                    'itemOptions' => array('class' => 'treeview'),
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span>Gestion des produits & services</span>', 'url' => array('/admin/productDirectory/index'), 'active' => $_controller == 'productDirectory' ,  'visible' => '1'),
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span>Gestion des sections</span>', 'url' => array('/admin/sectionDirectory/index'), 'active' => $_controller == 'sectionDirectory' ,  'visible' => '1'),
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span>Gestion des marques</span>', 'url' => array('/admin/marqueDirectory/index'), 'active' => $_controller == 'marqueDirectory' ,  'visible' => '1'),
                    ),
                ),
              //  array('label' => '<i class="fa fa-users"></i> <span>NA Utilisateurs </span>', 'url' => array('/admin/userDirectory/index'), 'active' => $_controller == 'userDirectory' ,  'visible' => '1'),
//                array('label' => '<i class="fa fa-users"></i> <span>Détaillants</span>', 'url' => array('/admin/retailerDirectory/index'), 'active' => $_controller == 'retailerdirectory' ,  'visible' => '1'),
                array('label' => '<i class="fa fa-users"></i> <span> Détaillants</span><i class="fa pull-right fa-angle-left"></i>', 'url' => '#',
                    'itemOptions' => array('class' => 'treeview'),
                     'visible' => '1',
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span>Gestion des détaillants</span>', 'url' => array('/admin/retailerDirectory/index'), 'active' => $_controller == 'retailerdirectory',  'visible' => '1'),
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span> Gestion des regroupement de détaillants</span>', 'url' => array('/admin/retailerGroup/index'), 'active' => ($_controller == 'paymentTransaction' && $_action=="index"),  'visible' => '1'),
                    ),
                ),
                array('label' => '<i class="fa fa-group"></i> <span> Fournisseurs</span><i class="fa pull-right fa-angle-left"></i>', 'url' => '#',
                    'itemOptions' => array('class' => 'treeview'),
                     'visible' => '1',
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span>Gestion des fournisseurs</span>', 'url' => array('/admin/suppliersDirectory/index'), 'active' => $_controller == 'suppliersDirectory',  'visible' => '1'),
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span>Fournisseurs Transactions De Paiement </span>', 'url' => array('/admin/paymentTransaction/index'), 'active' => ($_controller == 'paymentTransaction' && $_action=="index"),  'visible' => '1'),
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span>Paramètres </span>', 'url' => array('/admin/supplierSubscriptionPrice/index'), 'active' => ($_controller == 'supplierSubscriptionPrice'&& $_action=="index"),  'visible' => '1'),
                    ),
                ),
                array('label' => '<i class="fa fa-briefcase"></i> <span>Professionnels</span><i class="fa pull-right fa-angle-left"></i>', 'url' => '#',
                    'itemOptions' => array('class' => 'treeview'),
                    'visible' => '1',
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span>Gestion des professionnels</span>', 'url' => array('/admin/professionalDirectory/index'), 'active' => $_controller == 'professionalDirectory' ,  'visible' => '1'),
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span>Gestion des types de professionnels</span>', 'url' => array('/admin/professionalType/index'), 'active' => $_controller == 'professionalType' ,  'visible' => '1'),
                    ),
                ),
                array('label' => '<i class="fa fa-group"></i> <span>Associations</span>', 'url' => array('/admin/categoryInformation/index'), 'active' => $_controller == 'categoryInformation' ,  'visible' => '1'),
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
                array('label' => '<i class="fa fa-gear"></i> <span>Archivage</span>', 'url' => array('/admin/archiveCategory/index'),  'visible' => '1'),
                // array('label' => '<i class="fa fa-dashboard"></i> <span>Utilisateurs</span>', 'url' => array('/admin/userdirectory/index'), 'active' => $_controller == 'userdirectory'),
                array('label' => '<i class="fa fa-line-chart"></i> <span>Sondages</span>', 'url' => array('/admin/poll/index'), 'active' => $_controller == 'poll',  'visible' => '1'),
                
                array('label' => '<i class="fa fa-folder"></i> <span>Classifieds</span>', 'url' => array('/admin/classifieds/index'), 'active' => $_controller == 'classifieds',  'visible' => '1'),
                array('label' => '<i class="fa fa-user"></i> <span> Opti-rep</span><i class="fa pull-right fa-angle-left"></i>', 'url' => '#',
                    'itemOptions' => array('class' => 'treeview'),
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'visible' => '1',
                    'items' => array(      
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span>Sales Rep</span>', 'url' => array('/admin/repCredential/index'), 'active' => ($_controller == 'repCredential' && $_action=="index"),  'visible' => '1'),
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span>Transactions de paiement Optirep</span>', 'url' => array('/admin/paymentTransaction/reptransaction'), 'active' => ($_controller == 'paymentTransaction' && $_action=="reptransaction"),  'visible' => '1'),
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span>Paramètres </span>', 'url' => array('/admin/supplierSubscriptionPrice/statsprice'), 'active' => $_controller == 'supplierSubscriptionPrice' && $_action=="statsprice",  'visible' => '1'),
                    ),
                ),
                array('label' => '<i class="fa fa-file-excel-o"></i> <span> Export de données</span><i class="fa pull-right fa-angle-left"></i>', 'url' => '#',
                    'itemOptions' => array('class' => 'treeview'),
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'visible' => '1',
                    'items' => array(      
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span>Professionnel</span>', 'url' => array('/admin/exportDatas/index'), 'active' => ($_controller == 'exportDatas' && $_action=="index"),  'visible' => '1'),
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span>Détaillant</span>', 'url' => array('/admin/exportDatas/retailerIndex'), 'active' => ($_controller == 'exportDatas' && $_action=="retailerIndex"),  'visible' => '1'),                       
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span>Fournisseur</span>', 'url' => array('/admin/exportDatas/supplierIndex'), 'active' => ($_controller == 'exportDatas' && $_action=="supplierIndex"),  'visible' => '1'),                       
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span>Clients</span>', 'url' => array('/admin/exportDatas/clientIndex'), 'active' => ($_controller == 'exportDatas' && $_action=="clientIndex"),  'visible' => '1'),                       
                    ),
                ),
            ),
            'htmlOptions' => array('class' => 'sidebar-menu')
        ));
        ?>
    </section>
</aside>
