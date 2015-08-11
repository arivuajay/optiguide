<?php
/* @var $this PollController */
/* @var $model Poll */

$this->title='Ajouter un sondages';
$this->breadcrumbs=array(
	'Gérer les sondages'=>array('index'),
	$this->title,
);
?>
<div class="user-create">
  <?php echo $this->renderPartial('_form', array('model'=>$model,'choices'=>$choices)); ?>
</div>
