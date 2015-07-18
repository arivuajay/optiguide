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
                
                array('label' => '<i class="fa fa-dashboard"></i> <span>Détaillants</span>', 'url' => array('/admin/retailerdirectory/index'), 'active' => $_controller == 'retailerdirectory'),
                
                array('label' => '<i class="fa fa-dashboard"></i> <span>Fournisseurs</span>', 'url' => array('/admin/suppliersdirectory/index'), 'active' => $_controller == 'suppliersdirectory'),
                
                
                array('label' => '<i class="fa fa-dashboard"></i> <span>Professionnels</span><i class="fa pull-right fa-angle-left"></i>', 'url' => '#',
                    'itemOptions' => array('class' => 'treeview'),
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span>Gestion des professionnels</span>', 'url' => array('/admin/professionaldirectory/index'), 'active' => $_controller == 'professionaldirectory'),
                       array('label' => '<i class="fa fa-angle-double-right"></i> <span>Gestion des types de professionnels</span>', 'url' => array('/admin/professionaltype/index'), 'active' => $_controller == 'professionaltype'),
                    ),
                ),
                
                array('label' => '<i class="fa fa-dashboard"></i> <span>Associations</span>', 'url' => array('/admin/categoryinformation/index'), 'active' => $_controller == 'categoryinformation'),
                
                  array('label' => '<i class="fa fa-dashboard"></i> <span> Régions</span><i class="fa pull-right fa-angle-left"></i>', 'url' => '#',
                    'itemOptions' => array('class' => 'treeview'),
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span>Countries</span>', 'url' => array('/admin/countrydirectory/index'), 'active' => $_controller == 'countrydirectory'),
                       array('label' => '<i class="fa fa-angle-double-right"></i> <span>Region</span>', 'url' => array('/admin/regiondirectory/index'), 'active' => $_controller == 'regiondirectory'),
                       array('label' => '<i class="fa fa-angle-double-right"></i> <span>Cities</span>', 'url' => array('/admin/citydirectory/index'), 'active' => $_controller == 'citydirectory'),
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
