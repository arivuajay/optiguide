<?php
/* @var $this ClientProfilesController */
/* @var $model ClientProfiles */

$this->title='View #'.$model->name;
$this->breadcrumbs=array(
	'Client Profiles'=>array('index'),
	'View '.'ClientProfiles',
);
?>
<div class="user-view">
    
    <p>
        <?php        $this->widget(
                'booster.widgets.TbButton', array(
                    'label' => 'Update',
                    'url' => array('update', 'id' =>  $model->client_id ),
                    'buttonType' => 'link',
                    'context' => 'primary',
//                    'visible' => UserIdentity::checkAccess(Yii::app()->user->name)
                )
        );
        echo "&nbsp;&nbsp;";
        $this->widget(
                'application.components.MyTbButton', array(
                    'label' => 'Delete',
                    'url' => array('delete', 'id' =>  $model->client_id ),
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
            'url' => array('view', 'id' =>  $model->client_id , 'export' => 'PDF'),
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
		'client_id',
		'name',
		'company',
		'job_title',
		'member_type',
		'category',
		'address',
		'local_number',
		'country',
		'region',
		'ville',
		'phonenumber1',
		'phonenumber2',
		'mobile_number',
		'tollfree_number',
		'fax',
		'email',
		'site_address',
		'subscription',
		'created_date',
		'modified_date',
	),
)); ?>
</div>



