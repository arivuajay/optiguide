<?php
/* @var $this UserDirectoryController */
/* @var $model UserDirectory */

$this->title='View #'.$model->ID_UTILISATEUR;
$this->breadcrumbs=array(
	'User Directories'=>array('index'),
	'View '.'UserDirectory',
);
?>
<div class="user-view">
    
    <p>
        <?php        $this->widget(
                'booster.widgets.TbButton', array(
                    'label' => 'Update',
                    'url' => array('update', 'id' =>  $model->ID_UTILISATEUR ),
                    'buttonType' => 'link',
                    'context' => 'primary',
//                    'visible' => UserIdentity::checkAccess(Yii::app()->user->name)
                )
        );
        echo "&nbsp;&nbsp;";
        $this->widget(
                'application.components.MyTbButton', array(
                    'label' => 'Delete',
                    'url' => array('delete', 'id' =>  $model->ID_UTILISATEUR ),
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
            'url' => array('view', 'id' =>  $model->ID_UTILISATEUR , 'export' => 'PDF'),
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
		'ID_UTILISATEUR',
		'LANGUE',
		'PREFIXE',
		'NOM_UTILISATEUR',
		'USR',
		'PWD',
		'COURRIEL',
		'ABONNE_MAILING',
		'ABONNE_PROMOTION',
		'ABONNE_TRANSITION',
		'IS_FIRST_LOG',
		'NOM_TABLE',
		'ID_RELATION',
		'MUST_VALIDATE',
		'sGuid',
		'bSubscription_envision',
		'bSubscription_envue',
	),
)); ?>
</div>



