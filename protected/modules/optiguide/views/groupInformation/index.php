<?php $this->renderPartial('_search', array('searchModel' => $searchModel)); ?>
<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
        <div class="inner-container eventslist-cont"> 
            <h2><?php echo Myclass::t('OG040', '', 'og'); ?></h2>
            <div class="search-list">
                <?php
                if (!empty($model)) {
                    foreach ($model as $category_name => $section_groups) {
                        ?>
                        <h2> <?php echo $category_name ?></h2>
                        <ul>
                            <?php foreach ($section_groups as $sections => $groups) { ?>
                                <li>
                                    <h4> <?php echo $sections ?> </h4>
                                    <ul>
                                        <?php foreach ($groups as $key => $value) { ?>
                                            <li>
                                                <?php
                                                echo CHtml::link($value, array('/optiguide/groupInformation/view', 'id' => $key));
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
                ));
                ?>           
            </div>
        </div>
    </div>
</div>