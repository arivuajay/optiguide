<?php
/* @var $this RetailerDirectoryController */
/* @var $model RetailerDirectory */

$this->title='View #'.$model->ID_RETAILER;
$this->breadcrumbs=array(
	'Retailer Directories'=>array('index'),
	'View '.'RetailerDirectory',
);
?>
<div class="user-view">
    
    <p>
        <?php        $this->widget(
                'booster.widgets.TbButton', array(
                    'label' => 'Update',
                    'url' => array('update', 'id' =>  $model->ID_RETAILER ),
                    'buttonType' => 'link',
                    'context' => 'primary',
//                    'visible' => UserIdentity::checkAccess(Yii::app()->user->name)
                )
        );
        echo "&nbsp;&nbsp;";
        $this->widget(
                'application.components.MyTbButton', array(
                    'label' => 'Delete',
                    'url' => array('delete', 'id' =>  $model->ID_RETAILER ),
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
            'url' => array('view', 'id' =>  $model->ID_RETAILER , 'export' => 'PDF'),
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
		'ID_RETAILER',
		'ID_CLIENT',
		'COMPAGNIE',
		'ID_VILLE',
		'ADRESSE',
		'ADRESSE2',
		'CODE_POSTAL',
		'TELEPHONE',
		'TELEPHONE2',
		'TELECOPIEUR',
		'TELECOPIEUR2',
		'URL',
		'COURRIEL',
		'TEL_1800',
		'DATE_MODIFICATION',
		'ID_RETAILER_TYPE',
		'ID_GROUPE',
		'GROUPE',
		'HEAD_OFFICE_NAME',
		'CATEGORY_1',
		'CATEGORY_2',
		'CATEGORY_3',
		'CATEGORY_4',
		'CATEGORY_5',
	),
)); ?>
</div>



