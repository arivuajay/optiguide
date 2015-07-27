<?php
/* @var $this PublicityAdsController */
/* @var $model PublicityAds */

$this->title='View #'.$model->ID_PUBLICITE;
$this->breadcrumbs=array(
	'Publicity Ads'=>array('index'),
	'View '.'PublicityAds',
);
?>
<div class="user-view">
    
    <p>
        <?php        $this->widget(
                'booster.widgets.TbButton', array(
                    'label' => 'Update',
                    'url' => array('update', 'id' =>  $model->ID_PUBLICITE ),
                    'buttonType' => 'link',
                    'context' => 'primary',
//                    'visible' => UserIdentity::checkAccess(Yii::app()->user->name)
                )
        );
        echo "&nbsp;&nbsp;";
        $this->widget(
                'application.components.MyTbButton', array(
                    'label' => 'Delete',
                    'url' => array('delete', 'id' =>  $model->ID_PUBLICITE ),
                    'buttonType' => 'link',
                    'context' => 'danger',
                    'htmlOptions' => array('confirm' => 'Are you sure you want to delete this item?'),
                    'visible' => UserIdentity::checkAccess(Yii::app()->user->name)
                )
        );
        echo "&nbsp;&nbsp;";
        $this->widget(
                'booster.widgets.TbButton', array(
            'label' => 'Download',
            'url' => array('view', 'id' =>  $model->ID_PUBLICITE , 'export' => 'PDF'),
            'buttonType' => 'link',
            'context' => 'warning',
//                    'visible' => UserIdentity::checkAccess(Yii::app()->user->name)
                )
        );
        ?>
    </p>
    
    <?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
        'htmlOptions' => array('class'=>'table table-striped table-bordered'),
	'attributes'=>array(
		'ID_PUBLICITE',
		'NO_PUB',
		'LANGUE',
		'TITRE',
		'DATE_DEBUT',
		'DATE_FIN',
		'ID_FICHIER',
		'LIEN_URL',
		'MOTS_CLES_RECHERCHE',
		'NB_IMPRESSIONS_FAITES',
		'NB_IMPRESSIONS',
		'PRIORITE',
		'PRIX',
		'PAYE',
		'CLIENT',
		'ZONE_AFFICHAGE',
		'ID_POSITION',
		'AFFICHER_ACCUEIL',
		'DATE_AJOUT',
		'ACCUEIL_SECTION',
	),
)); ?>
</div>



