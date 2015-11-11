<div class="cate-bg user-right">
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
                        <?php
                        $img_url = '';
                        if ($model['ID_FICHIER'] > 0) {
                            $pk = $model['ID_FICHIER'];
                            $imageresult = ArchiveFichier::model()->findByPk($pk);
                            if ($imageresult['ID_CATEGORIE'] > 0) {
                                $extypes = array('jpg', 'jpeg', 'png', 'gif', 'bmp');
                                $img_ext = $imageresult['EXTENSION'];
                                if (in_array($img_ext, $extypes)) {
                                    $img_url = Yii::app()->getBaseUrl(true) . '/uploads/archivage/' . $imageresult['ID_CATEGORIE'] . '/' . $imageresult['FICHIER'];
                                    ?>
                                    <img src="<?php echo $img_url; ?>"  alt=""> 
                                    <?php
                                }
                            }
                        }
                        ?>
                        <p>                       
                            <?php echo $model['TEXTE']; ?>
                        </p>
                        <div class="viewall"> <?php echo CHtml::link('<i class="fa fa-arrow-circle-left"></i> ' . Myclass::t('OG016', '', 'og'), array('/optirep/newsManagement'), array("class" => "pull-left")); ?> </div>  
                    </div>
                </div>
                <?php
                $share_url = Yii::app()->createAbsoluteUrl('/optiguide/newsManagement/view', array('id' => $model['ID_NOUVELLE']));
                $share_title = $model['TITRE'];
                $share_summary = $model['SYNOPSYS'];
                $share_image = $img_url;
                ?>

                <span class='st_facebook_large' displayText='Facebook' st_url="<?php echo $share_url ?>" st_title="<?php echo $share_title ?>" st_summary="<?php echo $share_summary ?>" st_image="<?php echo $share_image ?>"></span>

                <span class='st_twitter_large' displayText='Tweet' st_url="<?php echo $share_url ?>" st_title="<?php echo $share_title ?>" st_summary="<?php echo $share_summary ?>" st_image="<?php echo $share_image ?>"></span>

                <span class='st_linkedin_large' displayText='LinkedIn' st_url="<?php echo $share_url ?>" st_title="<?php echo $share_title ?>" st_summary="<?php echo $share_summary ?>" st_image="<?php echo $share_image ?>"></span>

                <span class='st_pinterest_large' displayText='Pinterest' st_url="<?php echo $share_url ?>" st_title="<?php echo $share_title ?>" st_summary="<?php echo $share_summary ?>" st_image="<?php echo $share_image ?>"></span>

                <span class='st_email_large' displayText='Email' st_url="<?php echo $share_url ?>" st_title="<?php echo $share_title ?>" st_summary="<?php echo $share_summary ?>" st_image="<?php echo $share_image ?>"></span>

                <script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
                <script type="text/javascript">
                    stLight.options({
                        publisher: "db446c76-416b-452e-8de5-7bdc02fae4d5",
                        doNotHash: false,
                        doNotCopy: false,
                        hashAddressBar: false
                    });
                </script>
            </div>
        </div>
    </div>    
</div>   