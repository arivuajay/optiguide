<div class="cate-bg user-right">
    <?php $this->renderPartial('_search', array('searchModel' => $searchModel)); ?>

    <h2> <?php echo Myclass::t('OG040', '', 'og'); ?> </h2>
    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3 pull-right"> 
        <div class="perpage pull-right"> <span><?php echo Myclass::t('OR630', '', 'or'); ?></span>
            <?php
            $options = array('15' => '15', '30' => '30', '75' => '75', '100' => '100');
            echo CHtml::dropDownList('page_select', $searchModel->listperpage, $options, array("class" => "", "id" => "page_change"));
            ?>
        </div>

    </div>    
    <div class="search-list">
        <?php
        if (!empty($model)) {
            foreach ($model as $proftype => $users) {
                ?>
                <h4> <?php echo $proftype ?></h4>
                <ul>
                    <?php foreach ($users as $info) { ?>
                        <li>
                            <?php
                            $dispname = $info['NOM'] . ' ' . $info['PRENOM'];
                            echo CHtml::link($dispname, array('/optirep/professionalDirectory/view', 'id' => $info['ID_SPECIALISTE'])) . ' ';
                            echo $info['NOM_VILLE'] . ", " . $info['ABREVIATION_' . $this->lang] . ", " . $info['NOM_PAYS_' . $this->lang];
                            ?>
                        </li>
                    <?php } ?>
                </ul>
                <?php
            }
        } else {
            echo Myclass::t('OG043', '', 'og');
        }
        ?>

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
<?php
$js = <<< EOD
$(document).ready(function(){              
    $("#page_change").change(function(){
        var id=$(this).val();
        $("#listperpage").val(id);  
        $("#search-form").submit();   
    });
});
EOD;
Yii::app()->clientScript->registerScript('page_change', $js);
?>
