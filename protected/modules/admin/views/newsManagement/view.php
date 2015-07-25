<?php
/* @var $this NewsManagementController */
/* @var $model NewsManagement */

$this->title='View #'.$model->ID_NOUVELLE;
$this->breadcrumbs=array(
	'News Managements'=>array('index'),
	'View '.'NewsManagement',
);
?>
<div class="user-view">
    
    <p>
        <?php        $this->widget(
                'booster.widgets.TbButton', array(
                    'label' => 'Update',
                    'url' => array('update', 'id' =>  $model->ID_NOUVELLE ),
                    'buttonType' => 'link',
                    'context' => 'primary',
//                    'visible' => UserIdentity::checkAccess(Yii::app()->user->name)
                )
        );
        echo "&nbsp;&nbsp;";
        $this->widget(
                'application.components.MyTbButton', array(
                    'label' => 'Delete',
                    'url' => array('delete', 'id' =>  $model->ID_NOUVELLE ),
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
            'url' => array('view', 'id' =>  $model->ID_NOUVELLE , 'export' => 'PDF'),
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
		'ID_NOUVELLE',
		'LANGUE',
		'TITRE',
		'SYNOPSYS',
		'TEXTE',
		'ID_FICHIER',
		'LIEN_URL',
		'LIEN_TITRE',
		'HIERARCHIE',
		'DATE_AJOUT1',
		'AFFICHER_SITE',
		'AFFICHER_SECTION',
		'AFFICHER_ACCUEIL',
		'DATE_AJOUT2',
	),
)); ?>
</div>



