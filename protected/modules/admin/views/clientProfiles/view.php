<?php
/* @var $this ClientProfilesController */
/* @var $model ClientProfiles */

$this->title='Voir #'.$model->name;
$this->breadcrumbs=array(
	'Les profils des clients'=>array('index'),
	'Voir le profil de client',
);
?>
<div class="user-view">
    
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



