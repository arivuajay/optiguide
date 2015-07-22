<?php
/* @var $this SuppliersDirectoryController */
/* @var $model SuppliersDirectory */

$this->title='View #'.$model->ID_FOURNISSEUR;
$this->breadcrumbs=array(
	'Suppliers Directories'=>array('index'),
	'View '.'SuppliersDirectory',
);
?>
<div class="user-view">
    
    <p>
        <?php        $this->widget(
                'booster.widgets.TbButton', array(
                    'label' => 'Update',
                    'url' => array('update', 'id' =>  $model->ID_FOURNISSEUR ),
                    'buttonType' => 'link',
                    'context' => 'primary',
//                    'visible' => UserIdentity::checkAccess(Yii::app()->user->name)
                )
        );
        echo "&nbsp;&nbsp;";
        $this->widget(
                'application.components.MyTbButton', array(
                    'label' => 'Delete',
                    'url' => array('delete', 'id' =>  $model->ID_FOURNISSEUR ),
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
            'url' => array('view', 'id' =>  $model->ID_FOURNISSEUR , 'export' => 'PDF'),
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
		'ID_FOURNISSEUR',
		'COMPAGNIE',
		'ID_CLIENT',
		'ID_TYPE_FOURNISSEUR',
		'ADRESSE',
		'ADRESSE2',
		'ID_VILLE',
		'CODE_POSTAL',
		'TELEPHONE',
		'TELECOPIEUR',
		'TITRE_TEL_SANS_FRAIS',
		'TITRE_TEL_SANS_FRAIS_EN',
		'TEL_SANS_FRAIS',
		'TITRE_TEL_SECONDAIRE',
		'TITRE_TEL_SECONDAIRE_EN',
		'TEL_SECONDAIRE',
		'COURRIEL',
		'SITE_WEB',
		'SUCCURSALES',
		'ETABLI_DEPUIS',
		'NB_EMPLOYES',
		'PERSONNEL_NOM1',
		'PERSONNEL_TITRE1',
		'PERSONNEL_TITRE1_EN',
		'PERSONNEL_NOM2',
		'PERSONNEL_TITRE2',
		'PERSONNEL_TITRE2_EN',
		'PERSONNEL_NOM3',
		'PERSONNEL_TITRE3',
		'PERSONNEL_TITRE3_EN',
		'DATE_MODIFICATION',
		'REGIONS_FR',
		'REGIONS_EN',
		'bAfficher_site',
		'iId_fichier',
	),
)); ?>
</div>



