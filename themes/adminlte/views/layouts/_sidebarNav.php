<aside class="left-side sidebar-offcanvas">
    <section class="sidebar">
        <?php if (!Yii::app()->user->isGuest) : ?>
            <div class="user-panel">
                <div class="pull-left image">
                    <?php echo CHtml::image("{$this->themeUrl}/img/avatar5.png", 'User Image', array('class' => 'img-circle')) ?>
                </div>
                <div class="pull-left info">
                    <p>Hello, <?php echo Inflector::camel2words(Yii::app()->user->name) ?></p>
                    <a href="#">
                        <i class="fa fa-circle text-success"></i> Online
                    </a>
                </div>
            </div>
        <?php endif ?>

        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
                <span class="input-group-btn">
                    <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i
                            class="fa fa-search"></i></button>
                </span>
            </div>
        </form>

        <?php
        $_controller = Yii::app()->controller->id;
        
        if($_controller=='group'){
            if(isset($_REQUEST['role'])){
                $auth_group = $_REQUEST['role'] == 'author';
                $perf_group = $_REQUEST['role'] == 'performer';
            }elseif(isset($_REQUEST['id'])){
                $group = Group::model()->findByPk($_REQUEST['id']);
                $auth_group = $group->Group_Is_Author == '1';
                $perf_group = $group->Group_Is_Performer == '1';
            }
        }elseif($_controller=='publishergroup'){
            if(isset($_REQUEST['role'])){
                $pub_group = $_REQUEST['role'] == 'publisher';
                $pro_group = $_REQUEST['role'] == 'producer';
            }elseif(isset($_REQUEST['id'])){
                $group = PublisherGroup::model()->findByPk($_REQUEST['id']);
                $pub_group = $group->Pub_Group_Is_Publisher == '1';
                $pro_group = $group->Pub_Group_Is_Producer == '1';
            }
        }
        
        $this->widget('zii.widgets.CMenu', array(
            'activateParents' => true,
            'encodeLabel' => false,
            'activateItems' => true,
            'items' => array(
                array('label' => '<i class="fa fa-dashboard"></i> <span>Dashboard</span>', 'url' => Yii::app()->homeUrl),
                array('label' => '<i class="fa fa-briefcase"></i> <span>Administration</span><i class="fa pull-right fa-angle-left"></i>', 'url' => '#',
                    'itemOptions' => array('class' => 'treeview'),
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('label' => '<i class="fa fa-weixin"></i> <span>Society</span>', 'url' => array('/site/society/index'), 'active' => $_controller=='society'),
                        array('label' => '<i class="fa fa-music"></i> <span>Roles</span>', 'url' => array('/site/masterrole/index'), 'active' => $_controller=='masterrole'),
                        array('label' => '<i class="fa fa-user"></i> <span>Operator</span>', 'url' => array('/site/user/index'), 'active' => $_controller=='user'),
                    ),
                ),
                array('label' => '<i class="fa fa-cog"></i> <span>Master</span><i class="fa pull-right fa-angle-left"></i>', 'url' => '#',
                    'itemOptions' => array('class' => 'treeview'),
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('label' => '<i class="fa fa-usd"></i> <span>Currencies</span>', 'url' => array('/site/mastercurrency/index'), 'active' => $_controller=='mastercurrency'),
                        array('label' => '<i class="fa fa-globe"></i> <span>Countries</span>', 'url' => array('/site/mastercountry/index'), 'active' => $_controller=='mastercountry'),
                        array('label' => '<i class="fa fa-file-code-o"></i> <span>Document Status</span>', 'url' => array('/site/masterdocumentstatus/index'), 'active' => $_controller=='masterdocumentstatus'),
                        array('label' => '<i class="fa fa-file-audio-o"></i> <span>Document Type</span>', 'url' => array('/site/masterdocumenttype/index'), 'active' => $_controller=='masterdocumenttype'),
                        array('label' => '<i class="fa fa-file"></i> <span>Documents</span>', 'url' => array('/site/masterdocument/index'), 'active' => $_controller=='masterdocument'),
                        array('label' => '<i class="fa fa-group"></i> <span>Internal position</span>', 'url' => array('/site/masterinternalposition/index'), 'active' => $_controller=='masterinternalposition'),
                        array('label' => '<i class="fa fa-bullseye"></i> <span>International Number</span>', 'url' => array('/site/masterinternationalnumber/index'), 'active' => $_controller=='masterinternationalnumber'),
                        array('label' => '<i class="fa fa-file-image-o"></i> <span>Labels</span>', 'url' => array('/site/masterlabel/index'), 'active' => $_controller=='masterlabel'),
                        array('label' => '<i class="fa fa-file-o"></i> <span>Legal Form</span>', 'url' => array('/site/masterlegalform/index'), 'active' => $_controller=='masterlegalform'),
                        array('label' => '<i class="fa fa-language"></i> <span>Languages</span>', 'url' => array('/site/masterlanguage/index'), 'active' => $_controller=='masterlanguage'),
                        array('label' => '<i class="fa fa-copyright"></i> <span>Managed rights</span>', 'url' => array('/site/mastermanagedrights/index'), 'active' => $_controller=='mastermanagedrights'),
                        array('label' => '<i class="fa fa-female"></i> <span>Marital Status</span>', 'url' => array('/site/mastermaritalstatus/index'), 'active' => $_controller=='mastermaritalstatus'),
                        array('label' => '<i class="fa fa-flag"></i> <span>Nationalities</span>', 'url' => array('/site/masternationality/index'), 'active' => $_controller=='masternationality'),
                        array('label' => '<i class="fa fa-building"></i> <span>Organization</span>', 'url' => array('/site/organization/index'), 'active' => $_controller=='organization'),
                        array('label' => '<i class="fa fa-tty"></i> <span>Pseudonym Types</span>', 'url' => array('/site/masterpseudonymtypes/index'), 'active' => $_controller=='masterpseudonymtypes'),
                        array('label' => '<i class="fa fa-paypal"></i> <span>Payment Methods</span>', 'url' => array('/site/masterpaymentmethod/index'), 'active' => $_controller=='masterpaymentmethod'),
                        array('label' => '<i class="fa fa-male"></i> <span>Profession</span>', 'url' => array('/site/masterprofession/index'), 'active' => $_controller=='masterprofession'),
                        array('label' => '<i class="fa fa-building-o"></i> <span>Region</span>', 'url' => array('/site/masterregion/index'), 'active' => $_controller=='masterregion'),
                        array('label' => '<i class="fa fa-share-alt"></i> <span>Share Definition</span>', 'url' => array('/site/sharedefinitionperrole/index'), 'active' => $_controller=='sharedefinitionperrole'),
                        array('label' => '<i class="fa fa-list"></i> <span>Types</span>', 'url' => array('/site/mastertype/index'), 'active' => $_controller=='mastertype'),
                        array('label' => '<i class="fa fa-newspaper-o"></i> <span>Types of events</span>', 'url' => array('/site/mastereventtype/index'), 'active' => $_controller=='mastereventtype'),
                        array('label' => '<i class="fa fa-at"></i> <span>RightHolder Type</span>', 'url' => array('/site/mastertyperights/index'), 'active' => $_controller=='mastertyperights'),
                        array('label' => '<i class="fa fa-institution"></i> <span>Territories</span>', 'url' => array('/site/masterterritories/index'), 'active' => $_controller=='masterterritories'),
                        array('label' => '<i class="fa fa-suitcase"></i> <span>Works Category</span>', 'url' => array('/site/masterworkscategory/index'), 'active' => $_controller=='masterworkscategory'),
                    ),
                ),
                array('label' => '<i class="fa fa-briefcase"></i> <span>Documentation</span><i class="fa pull-right fa-angle-left"></i>', 'url' => '#',
                    'itemOptions' => array('class' => 'treeview'),
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('label' => '<i class="fa fa-group"></i> <span>Members</span><i class="fa pull-right fa-angle-left"></i>', 'url' => '#',
                            'itemOptions' => array('class' => 'treeview innertree'),
                            'submenuOptions' => array('class' => 'treeview-menu'),
                            'items' => array(
                                array('label' => '<i class="fa fa-book"></i> <span>Author</span>', 'url' => array('/site/authoraccount/index'), 'active' => $_controller=='authoraccount'),
                                array('label' => '<i class="fa fa-music"></i> <span>Performer</span>', 'url' => array('/site/performeraccount/index'), 'active' => $_controller=='performeraccount'),
                                array('label' => '<i class="fa fa-microphone"></i> <span>Publisher</span>', 'url' => array('/site/publisheraccount/index'), 'active' => $_controller=='publisheraccount'),
                                array('label' => '<i class="fa fa-money"></i> <span>Producer</span>', 'url' => array('/site/produceraccount/index'), 'active' => $_controller=='produceraccount'),
                                array('label' => '<i class="fa fa-book"></i> <span>Authors Group</span>', 'url' => array('/site/group/index/role/author'), 'active' => $auth_group),
                                array('label' => '<i class="fa fa-music"></i> <span>Performers Group</span>', 'url' => array('/site/group/index/role/performer'), 'active' => $perf_group),
                                array('label' => '<i class="fa fa-microphone"></i> <span>Publishers Group</span>', 'url' => array('/site/publishergroup/index/role/publisher'), 'active' => $pub_group),
                                array('label' => '<i class="fa fa-money"></i> <span>Producers Group</span>', 'url' => array('/site/publishergroup/index/role/producer'), 'active' => $pro_group),
                            ),
                        ),
                        array('label' => '<i class="fa fa-sliders"></i> <span>Works</span>', 'url' => array('/site/work/index'), 'active' => $_controller=='work'),
                        array('label' => '<i class="fa fa-volume-up"></i> <span>Recordings</span>', 'url' => array('/site/recording/index'), 'active' => $_controller=='recording'),
                    ),
                ),
//                array('label' => '<i class="fa fa-group"></i> <span>Members</span><i class="fa pull-right fa-angle-left"></i>', 'url' => '#',
//                    'itemOptions' => array('class' => 'treeview'),
//                    'submenuOptions' => array('class' => 'treeview-menu'),
//                    'items' => array(
//                        array('label' => '<i class="fa fa-book"></i> <span>Authors</span>', 'url' => array('/site/group/index/role/author'), 'active' => $_controller=='authoraccount'),
//                        array('label' => '<i class="fa fa-music"></i> <span>Performers</span>', 'url' => array('/site/group/index/role/performer'), 'active' => $_controller=='authoraccount'),
//                        array('label' => '<i class="fa fa-microphone"></i> <span>Publishers</span>', 'url' => array('/site/publishergroup/index/role/publisher'), 'active' => $_controller=='authoraccount'),
//                        array('label' => '<i class="fa fa-money"></i> <span>Producers</span>', 'url' => array('/site/publishergroup/index/role/producer'), 'active' => $_controller=='authoraccount'),
//                    ),
//                ),
//                array('label' => '<i class="fa fa-th"></i> <span>Number Assignment</span>', 'url' => array('/site/numberassignment/index'), 'active' => $_controller=='authoraccount'),
            ),
            'htmlOptions' => array('class' => 'sidebar-menu')
        ));
        ?>
    </section>
</aside>
