<?php
/* @var $this GroupInformationController */
/* @var $model GroupInformation */

$this->title='View #'.$model->ID_GROUPE;
$this->breadcrumbs=array(
	'Group Informations'=>array('index'),
	'View '.'GroupInformation',
);
?>
<div class="user-view">
    
    <p>
        <?php        $this->widget(
                'booster.widgets.TbButton', array(
                    'label' => 'Update',
                    'url' => array('update', 'id' =>  $model->ID_GROUPE ),
                    'buttonType' => 'link',
                    'context' => 'primary',
//                    'visible' => UserIdentity::checkAccess(Yii::app()->user->name)
                )
        );
        echo "&nbsp;&nbsp;";
        $this->widget(
                'application.components.MyTbButton', array(
                    'label' => 'Delete',
                    'url' => array('delete', 'id' =>  $model->ID_GROUPE ),
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
            'url' => array('view', 'id' =>  $model->ID_GROUPE , 'export' => 'PDF'),
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
		'ID_GROUPE',
		'ID_SECTION',
		'NOM_GROUPE',
		'ADRESSE',
		'ADRESSE2',
		'ID_VILLE',
		'CODE_POSTAL',
		'TELEPHONE',
		'TELECOPIEUR',
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



