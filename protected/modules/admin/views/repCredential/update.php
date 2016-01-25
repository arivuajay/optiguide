<?php
/* @var $this UserDirectoryController */
/* @var $model UserDirectory */

$this->title='Modifier Sales Rep: '. $profile->rep_profile_firstname;
$this->breadcrumbs=array(	
	'Modifier Sales Rep',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', compact('model','tab', 'data_products','pmodel','profile')); ?>
</div>