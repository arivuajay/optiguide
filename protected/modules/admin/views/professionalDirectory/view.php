<?php
/* @var $this ProfessionalDirectoryController */
/* @var $model ProfessionalDirectory */

$this->title='View #'.$model->ID_SPECIALISTE;
$this->breadcrumbs=array(
	'Professional Directories'=>array('index'),
	'View '.'ProfessionalDirectory',
);
?>
<div class="user-view">
    
    <p>
        <?php        $this->widget(
                'booster.widgets.TbButton', array(
                    'label' => 'Update',
                    'url' => array('update', 'id' =>  $model->ID_SPECIALISTE ),
                    'buttonType' => 'link',
                    'context' => 'primary',
//                    'visible' => UserIdentity::checkAccess(Yii::app()->user->name)
                )
        );
        echo "&nbsp;&nbsp;";
        $this->widget(
                'application.components.MyTbButton', array(
                    'label' => 'Delete',
                    'url' => array('delete', 'id' =>  $model->ID_SPECIALISTE ),
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
            'url' => array('view', 'id' =>  $model->ID_SPECIALISTE , 'export' => 'PDF'),
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
		'ID_SPECIALISTE',
		'ID_CLIENT',
		'PREFIXE_FR',
		'PREFIXE_EN',
		'PRENOM',
		'NOM',
		'ID_TYPE_SPECIALISTE',
		'TYPE_AUTRE',
		'BUREAU',
		'ADRESSE',
		'ADRESSE2',
		'ID_VILLE',
		'CODE_POSTAL',
		'TELEPHONE',
		'TELEPHONE2',
		'TELECOPIEUR',
		'TELECOPIEUR2',
		'SITE_WEB',
		'COURRIEL',
		'DATE_MODIFICATION',
	),
)); ?>
</div>



