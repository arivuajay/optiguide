<?php
/* @var $this CategoryInformationController */
/* @var $model CategoryInformation */

$this->title='View #'.$model->ID_CATEGORIE;
$this->breadcrumbs=array(
	'Category Informations'=>array('index'),
	'View '.'CategoryInformation',
);
?>
<div class="user-view">
    
    <p>
        <?php        $this->widget(
                'booster.widgets.TbButton', array(
                    'label' => 'Update',
                    'url' => array('update', 'id' =>  $model->ID_CATEGORIE ),
                    'buttonType' => 'link',
                    'context' => 'primary',
//                    'visible' => UserIdentity::checkAccess(Yii::app()->user->name)
                )
        );
        echo "&nbsp;&nbsp;";
        $this->widget(
                'application.components.MyTbButton', array(
                    'label' => 'Delete',
                    'url' => array('delete', 'id' =>  $model->ID_CATEGORIE ),
                    'buttonType' => 'link',
                    'context' => 'danger',
                    'htmlOptions' => array('confirm' => 'Are you sure you want to delete this item?'),
                   // 'visible' => UserIdentity::checkAccess(Yii::app()->user->name)
                )
        );
        echo "&nbsp;&nbsp;";
        $this->widget(
                'booster.widgets.TbButton', array(
            'label' => 'Download',
            'url' => array('view', 'id' =>  $model->ID_CATEGORIE , 'export' => 'PDF'),
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
		'ID_CATEGORIE',
		'CATEGORIE_FR',
		'CATEGORIE_EN',
		'NOM_ASSOCIATION_FR',
		'NOM_ASSOCIATION_EN',
		'ADRESSE',
		'ADRESSE2',
		'ID_VILLE',
		'CODE_POSTAL',
		'TELEPHONE',
		'TELECOPIEUR',
		'TEL_SANS_FRAIS',
		'COURRIEL',
		'SITE_WEB',
		'PREFIXE_REPRESENTANT_FR',
		'PREFIXE_REPRESENTANT_EN',
		'NOM_REPRESENTANT',
		'TITRE_REPRESENTANT_FR',
		'TITRE_REPRESENTANT_EN',
	),
)); ?>
</div>



