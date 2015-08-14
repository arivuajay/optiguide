<?php
/* @var $this PollController */
/* @var $model Poll */

$this->title = 'View sondage résultat ';
$this->breadcrumbs = array(
    'Gérer les sondages' => array('index'),
    $this->title,
);
?>
<div class="box box-info">
    <div class="box-header">
        <i class="fa fa-line-chart"></i>
        <h3 class="box-title"><?php echo CHtml::encode($model->title); ?></h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <?php if ($model->description): ?>
            <p class="description"><?php echo CHtml::encode($model->description); ?></p>
        <?php endif; ?>
        <?php $this->renderPartial('_results', array('model' => $model)); ?>
    </div><!-- /.box-body -->
</div>
