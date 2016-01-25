<?php
/* @var $this AdminController */
/* @var $model Admin */

$this->title='View #'.$model->admin_id;
$this->breadcrumbs=array(
	'Admins'=>array('index'),
	'View '.'Admin',
);
?>
<div class="user-view">
    
    <p>
        <?php        $this->widget(
                'booster.widgets.TbButton', array(
                    'label' => 'Update',
                    'url' => array('update', 'id' =>  $model->admin_id ),
                    'buttonType' => 'link',
                    'context' => 'primary',
//                    'visible' => UserIdentity::checkAccess(Yii::app()->user->name)
                )
        );
        echo "&nbsp;&nbsp;";
        $this->widget(
                'application.components.MyTbButton', array(
                    'label' => 'Delete',
                    'url' => array('delete', 'id' =>  $model->admin_id ),
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
            'url' => array('view', 'id' =>  $model->admin_id , 'export' => 'PDF'),
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
		'admin_id',
		'admin_name',
		'admin_username',
		'admin_password',
		'admin_status',
		'admin_email',
		'created_date',
		'admin_last_login',
		'admin_login_ip',
		'role',
	),
)); ?>
</div>



