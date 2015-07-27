<?php
/* @var $this CalendarEventsController */
/* @var $model CalendarEvents */

$this->title='View #'.$model->ID_EVENEMENT;
$this->breadcrumbs=array(
	'Calendar Events'=>array('index'),
	'View '.'CalendarEvents',
);
?>
<div class="user-view">
    
    <p>
        <?php        $this->widget(
                'booster.widgets.TbButton', array(
                    'label' => 'Update',
                    'url' => array('update', 'id' =>  $model->ID_EVENEMENT ),
                    'buttonType' => 'link',
                    'context' => 'primary',
//                    'visible' => UserIdentity::checkAccess(Yii::app()->user->name)
                )
        );
        echo "&nbsp;&nbsp;";
        $this->widget(
                'application.components.MyTbButton', array(
                    'label' => 'Delete',
                    'url' => array('delete', 'id' =>  $model->ID_EVENEMENT ),
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
            'url' => array('view', 'id' =>  $model->ID_EVENEMENT , 'export' => 'PDF'),
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
		'ID_EVENEMENT',
		'LANGUE',
		'DATE_AJOUT1',
		'DATE_AJOUT2',
		'TITRE',
		'TEXTE',
		'LIEN_URL',
		'LIEN_TITRE',
		'AFFICHER_SITE',
		'AFFICHER_ACCUEIL',
		'AFFICHER_ARCHIVE',
		'ID_PAYS',
		'ID_REGION',
		'ID_VILLE',
	),
)); ?>
</div>



