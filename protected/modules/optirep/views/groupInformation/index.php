<div class="cate-bg user-right">
    <?php $this->renderPartial('_search', array('searchModel' => $searchModel)); ?>
    <h2><?php echo Myclass::t('OG040', '', 'og'); ?></h2>
    <div class="search-list">
        <?php
        if (!empty($model)) {
            foreach ($model as $category_name => $section_groups) {
                ?>
                <h4> <?php echo $category_name ?></h4>
                <ul>
                    <?php foreach ($section_groups as $sections => $groups) { ?>
                        <li>
                            <h5> <?php echo $sections ?> </h5>
                            <ul>
                                <?php foreach ($groups as $key => $value) { ?>
                                    <li>
                                        <?php
                                        echo CHtml::link($value, array('/optirep/groupInformation/view', 'id' => $key));
                                        ?>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>
                </ul>
                <?php
            }
        } else {
            echo Myclass::t('OG043', '', 'og');
        }
        ?>
    </div>
    <div class="pagination-cont">
        <?php
        $this->widget('CLinkPager', array(
            'pages' => $pages,
            'currentPage' => $pages->getCurrentPage(),
            'itemCount' => $item_count,
            'pageSize' => $page_size,
            'maxButtonCount' => 10,
            'header' => '',
            'selectedPageCssClass' => 'active',
            'htmlOptions' => array(
                'class' => 'pagination',
            ),
        ));
        ?>           
    </div>
</div>