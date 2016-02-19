<div class="cate-bg user-right">
    <?php
    $actionpage = Yii::app()->controller->action->id;
    if ($actionpage == "index") {
        $this->renderPartial('_search', array('searchModel' => $searchModel));
        $parampage = "home";
    } elseif ($actionpage == "category") {
        $this->renderPartial('_search_cat', array('searchModel' => $searchModel));
        $parampage = "category";
    }
    ?>
    <span class="text-right">Total Records:<?php echo $item_count;?></span>
    <h2><?php echo Myclass::t('OR040', '', 'or'); ?> </h2>    
    <div class="search-list">        
        <?php
        $sectionid = ($searchModel->ID_SECTION != '') ? "'sectionid' => " . $searchModel->ID_SECTION : '';
        $productid = ($searchModel->PROD_SERVICE != '') ? "'productid' => " . $searchModel->PROD_SERVICE : '';
        if (!empty($model)) {
            foreach ($model as $proftype => $users) {
                ?>
                <h4> <?php echo $proftype ?></h4>
                <ul>
                    <?php foreach ($users as $info) { ?>
                        <li class="noBorder">
                            <?php
                            $dispname = $info['COMPAGNIE'];
                            $param_array[0] = '/optirep/suppliersDirectory/view';
                            $param_array['id'] = $info['ID_FOURNISSEUR'];
                            if ($searchModel->ID_SECTION != '') {
                                $param_array['sectionid'] = $searchModel->ID_SECTION;
                            }
                            if ($searchModel->PROD_SERVICE != '') {
                                $param_array['productid'] = $searchModel->PROD_SERVICE;
                            }
                            if ($parampage != '') {
                                $param_array['disppage'] = $parampage;
                            }

                            $disp_supp = CHtml::link($dispname, $param_array) . ' ';
                            $disp_supp .= $info['NOM_VILLE'] . ", " . $info['ABREVIATION_' . $this->lang] . ", " . $info['NOM_PAYS_' . $this->lang] . " ";

                            if( $info['expiry_status']=="1")
                             $disp_supp .= "<i class='fa fa-eye paidmems'></i>";   

                            echo $disp_supp;
                            ?>
                        </li>
                    <?php } ?>
                </ul>
                <?php
            }
        }else {
            echo Myclass::t('OR043', '', 'or');
        }
        ?>
    </div>
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