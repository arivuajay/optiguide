<?php $this->renderPartial('_search', array('searchModel' => $searchModel)); ?>

<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
        <div class="inner-container eventslist-cont"> 
            <h2> <?php echo $model['TITRE'] ?></h2>
            
            <?php               
                if ($model['ID_CATEGORIE'] > 0) {
                    $extypes = array('jpg', 'jpeg', 'png', 'gif', 'bmp');
                    $img_ext = $model['EXTENSION'];
                    if (in_array($img_ext, $extypes)) {                       
                        $img_url = Yii::app()->getBaseUrl(true) . '/uploads/archivage/' . $model['ID_CATEGORIE'] . '/' . $model['FICHIER'];
                        ?>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 brand-logo"> <img src="<?php echo $img_url; ?>" width="200" height="200" alt=""> </div>
                        <?php
                    }
                }
                ?>
                
            <div class="search-list">
                <h2> 
                    <?php
                    echo Myclass::t('OG018', '', 'og') . ' ';
                    echo date("Y-m-d", strtotime($model['DATE_AJOUT1'])) . ' ';
                    echo Myclass::t('OG019', '', 'og') . ' ';
                    echo date("Y-m-d", strtotime($model['DATE_AJOUT2']))
                    ?>
                </h2>
                <div class="clearfix"></div>
                <div> 
                    <?php echo $model['TEXTE']; ?>
                    <p>
                        <a target="_blank" href="<?php echo $model['LIEN_URL']; ?>"><?php echo $model['LIEN_TITRE']; ?></a>
                    </p>
                    <div class="clearfix"></div>               
                    <?php echo CHtml::link(Myclass::t('OG016', '', 'og'), array('/optiguide/calenderEvent'), array('class' => 'basic-btn')); ?>
                </div>
            </div>
        </div>
    </div>
</div>