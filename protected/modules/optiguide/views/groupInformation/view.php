<?php $this->renderPartial('_search', array('searchModel' => $searchModel)); ?>
<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
        <div class="inner-container eventslist-cont"> 
            <h2> <?php echo $model['NOM_GROUPE'] ?></h2>
            <div class="search-list">
                <p>
                    <?php
                    if ($model['ADRESSE'])
                        echo $model['ADRESSE'] . '<br>';

                    if ($model['ADRESSE2'])
                        echo $model['ADRESSE2'] . '<br>';

                    if ($model['NOM_VILLE'])
                        echo $model['NOM_VILLE'] . ', ';

                    if ($model['NOM_REGION_' . Yii::app()->session['language']])
                        echo $model['NOM_REGION_' . Yii::app()->session['language']] . '<br>';

                    if ($model['NOM_PAYS_' . Yii::app()->session['language']])
                        echo $model['NOM_PAYS_' . Yii::app()->session['language']] . '<br>';

                    if ($model['CODE_POSTAL'])
                        echo $model['CODE_POSTAL'];
                    ?>
                </p>
                <p>
                    <?php
                    if ($model['TELEPHONE'])
                        echo Myclass::t('OG041', '', 'og') . ' : ' . $model['TELEPHONE'] . '<br>';

                    if ($model['TELECOPIEUR'])
                        echo Myclass::t('OG042', '', 'og') . ' : ' . $model['TELECOPIEUR'];
                    ?>
                </p>
                <p>
                    <?php if ($model['COURRIEL']) { ?>
                        <?php echo Myclass::t('Email', '', 'og') . ' : '; ?>
                        <a href="mailto:<?php echo $model['COURRIEL'] ?>"><?php echo $model['COURRIEL']; ?></a><br>
                    <?php } ?>

                    <?php if ($model['SITE_WEB']) { ?>
                        <?php echo Myclass::t('Website', '', 'og') . ' : '; ?>
                        <a href="<?php echo $model['SITE_WEB'] ?>" target="_blank"><?php echo $model['SITE_WEB']; ?></a>
                    <?php } ?>
                </p>
                <p>
                    <?php
                    if ($model['NOM_REPRESENTANT'])
                        echo $model['NOM_REPRESENTANT'] . '<br>';

                    if ($model['TITRE_REPRESENTANT_' . Yii::app()->session['language']])
                        echo $model['TITRE_REPRESENTANT_' . Yii::app()->session['language']];
                    ?>
                </p>
                <div class="clearfix"></div>               
                <?php echo CHtml::link(Myclass::t('OG016', '', 'og'), array('/optiguide/groupInformation'), array('class' => 'basic-btn')); ?>
            </div>
        </div>
    </div>
</div>