<?php $this->renderPartial('_search', array('searchModel' => $searchModel)); ?>

<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
        <div class="inner-container eventslist-cont"> 
            <div class="search-list">
                <div class="news-thumbs news-details"> 
                    <h4>
                        <?php echo $model['TITRE']; ?>
                        <span> <?php echo date("Y-m-d", strtotime($model['DATE_AJOUT1'])); ?> </span>
                    </h4> 
                    <div class="clearfix"></div>
                   
                    <p> 
                         <?php
                        if($model['ID_FICHIER']>0)
                        {    
                            $pk = $model['ID_FICHIER'];
                            $imageresult = ArchiveFichier::model()->findByPk($pk);  
                            if ($imageresult['ID_CATEGORIE'] > 0) 
                            {
                                $extypes = array('jpg', 'jpeg', 'png', 'gif', 'bmp');
                                $img_ext = $imageresult['EXTENSION'];
                                if (in_array($img_ext, $extypes)) 
                                {
                                    $img_url = Yii::app()->getBaseUrl(true) . '/uploads/archivage/' . $imageresult['ID_CATEGORIE'] . '/' . $imageresult['FICHIER'];?>
                                    <img src="<?php echo $img_url; ?>"  alt=""> 
                                    <?php
                                }
                            }
                        }       
                        ?>
                        <?php echo $model['TEXTE']; ?>
                    </p>
                    <?php echo CHtml::link(Myclass::t('OG016', '', 'og'), array('/optiguide/newsManagement')); ?>
                </div>
            </div>
        </div>
    </div>
</div>