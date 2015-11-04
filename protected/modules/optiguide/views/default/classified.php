<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 classified tab-cont"> 
        <div>
            <?php if (Yii::app()->language == 'en') { ?>
                <p>Our classified ad section is a free service for all optical practioners in the Canadian optical industry. All submitted classified ads will also be printed in Envision: seeing beyond. Please send your text (maximum 50 words) to info@bretoncom.com or fax it to 450 629-6044.
                </p>
            <?php } else { ?>
                <p>Vous désirez placer une petite annonce? Communiquez avec nous par courriel à info@bretoncom.com ou par télécopieur au 450 629-6044. Les petites annonces sont gratuites pour les professionnels de l’optique et sont aussi imprimée dans Envue : voir plus loin.
                </p>
            <?php } ?>

            <?php
            $classfied_category1 = ClassifiedCategories::model()->find(array('condition' => 'classified_category_id = 1'));
            $classfied_category2 = ClassifiedCategories::model()->find(array('condition' => 'classified_category_id = 2'));
            $classfied_category3 = ClassifiedCategories::model()->find(array('condition' => 'classified_category_id = 3'));
            $name = 'classified_category_name_' . strtoupper(Yii::app()->language);
            $cat_name1 = $classfied_category1->$name;
            $cat_name2 = $classfied_category2->$name;
            $cat_name3 = $classfied_category3->$name;
            ?>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#classified1" aria-controls="classified1" role="tab" data-toggle="tab">
                        <i class="fa fa-suitcase"></i> <?php echo $cat_name1; ?>
                    </a>
                </li>
                <li role="presentation">
                    <a href="#classified2" aria-controls="classified2" role="tab" data-toggle="tab">
                        <i class="fa fa-wrench"></i> <?php echo $cat_name2; ?>
                    </a>
                </li>
                <li role="presentation">
                    <a href="#classified3" aria-controls="classified3" role="tab" data-toggle="tab">
                        <i class="fa fa-gears"></i> <?php echo $cat_name3; ?>
                    </a>
                </li>

            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane  fade in active" id="classified1">
                    <?php
                    $classfieds1 = Classifieds::model()->findAll(array('condition' => 'classified_category_id = 1 AND language = "' . strtoupper(Yii::app()->language) . '"'));
                    if (!empty($classfieds1)) {
                        foreach ($classfieds1 as $classfied1) {
                            ?>
                            <div class="news-thumbs"> 
                                <h4> <?php echo $classfied1->classified_title ?>
                                    <span> <?php echo Myclass::dateFormat($classfied1->created_at) ?></span>
                                </h4> 
                                <div class="clearfix"></div>
                                <p>
                                    <?php echo $classfied1->classified_message ?>
                                </p>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <div role="tabpanel" class="tab-pane fade " id="classified2">
                    <?php
                    $classfieds2 = Classifieds::model()->findAll(array('condition' => 'classified_category_id = 2 AND language = "' . strtoupper(Yii::app()->language) . '"'));
                    if (!empty($classfieds2)) {
                        foreach ($classfieds2 as $classfied2) {
                            ?>
                            <div class="news-thumbs"> 
                                <h4> <?php echo $classfied2->classified_title ?>
                                    <span> <?php echo Myclass::dateFormat($classfied2->created_at) ?></span>
                                </h4> 
                                <div class="clearfix"></div>
                                <p>
                                    <?php echo $classfied2->classified_message ?>
                                </p>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="classified3">
                    <?php
                    $classfieds3 = Classifieds::model()->findAll(array('condition' => 'classified_category_id = 3 AND language = "' . strtoupper(Yii::app()->language) . '"'));
                    if (!empty($classfieds3)) {
                        foreach ($classfieds3 as $classfied3) {
                            ?>
                            <div class="news-thumbs"> 
                                <h4> <?php echo $classfied3->classified_title ?>
                                    <span> <?php echo Myclass::dateFormat($classfied3->created_at) ?></span>
                                </h4> 
                                <div class="clearfix"></div>
                                <p>
                                    <?php echo $classfied3->classified_message ?>
                                </p>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

