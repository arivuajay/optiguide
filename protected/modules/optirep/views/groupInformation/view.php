<div class="cate-bg user-right">
<?php $this->renderPartial('_search', array('searchModel' => $searchModel)); ?>
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

                if ($model['NOM_REGION_'.$this->lang])
                    echo $model['NOM_REGION_'.$this->lang] . '<br>';

                if ($model['NOM_PAYS_'.$this->lang])
                    echo $model['NOM_PAYS_'.$this->lang] . '<br>';

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
                    <?php echo Myclass::t('OG075', '', 'og') . ' : '; ?>
                    <a href="mailto:<?php echo $model['COURRIEL'] ?>"><?php echo $model['COURRIEL']; ?></a><br>
                <?php } ?>

                <?php if ($model['SITE_WEB']) { ?>
                    <?php echo Myclass::t('OG076', '', 'og') . ' : '; ?>
                    <a href="<?php echo $model['SITE_WEB'] ?>" target="_blank"><?php echo $model['SITE_WEB']; ?></a>
                <?php } ?>
            </p>
            <p>
                <?php
                if ($model['NOM_REPRESENTANT'])
                    echo $model['NOM_REPRESENTANT'] . '<br>';

                if ($model['TITRE_REPRESENTANT_'.$this->lang])
                    echo $model['TITRE_REPRESENTANT_'.$this->lang];
                ?>
            </p>
            <div class="clearfix"></div>      
            <div class="viewall">
            <?php $pre_url=Yii::app()->request->urlReferrer; 
                  if(empty($pre_url)){?>
                <?php echo CHtml::link('<i class="fa fa-arrow-circle-left"></i> '.Myclass::t('OG016', '', 'og'), array('/optirep/groupInformation'),array("class"=>"pull-left")); ?>
            <?php }else{?>
                <a class='pull-left' href="<?php echo $pre_url; ?>"><i class="fa fa-arrow-circle-left"></i><?php echo Myclass::t('OG016', '', 'og');?>  </a>
            <?php }?>
            </div>
        </div>
</div>