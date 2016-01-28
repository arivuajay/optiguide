<?php
/* @var $this ClassifiedsController */
/* @var $dataProvider CActiveDataProvider */

$this->title = Myclass::t('OGO206', '', 'og');
$this->breadcrumbs = array(
    $this->title,
);

$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerScriptFile($themeUrl . '/js/datatables/jquery.dataTables.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/datatables/dataTables.bootstrap.js', $cs_pos_end);
?>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php //echo CHtml::link('<i class="fa fa-plus"></i>&nbsp;&nbsp; ' . Myclass::t('OGO207', '', 'og'), array('/admin/classifieds/create'), array('class' => 'btn btn-success pull-right')); ?>
         <?php
        $this->widget(
            'application.components.MyTbButton', array(
            'label' => Myclass::t('OGO207', '', 'og'),
            'icon' => 'fa fa-plus',
            'url' => array('/admin/classifieds/create'),
            'buttonType' => 'link',
            'context' => 'success',
            'htmlOptions' => array('class' => 'pull-right'),
                )
        );
        ?>
    </div>
</div>

<div class="col-lg-12 col-md-12">&nbsp;</div>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php
        $classified_categories = CHtml::listData(ClassifiedCategories::model()->findAll(array("order" => "classified_category_id asc")), 'classified_category_id', 'classified_category_name_FR');

        $gridColumns = array(
            array('header' => 'SN.',
                'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            ),
            array(
                'header' => Myclass::t('OGO208', '', 'og'),
                'name' => 'classifiedCategory.classified_category_name_FR',
                'value' => $data->classifiedCategory->classified_category_name_FR,
                'filter' => CHtml::activeDropDownList($model, 'classified_category_id', $classified_categories, array('class' => 'form-control', 'prompt' => 'Tous')),
            ),
            'language',
            'classified_title',
            array(
                'name' => 'created_at',
                'filter' => false
            ),
            array(
                'header' => Myclass::t('APP46'),
                'class' => 'application.components.MyActionButtonColumn',
                'htmlOptions' => array('style' => 'text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
                'template' => '{view}&nbsp;&nbsp;&nbsp;&nbsp;{update}&nbsp;&nbsp;&nbsp;&nbsp;{delete}',
            )
        );

        $this->widget('booster.widgets.TbExtendedGridView', array(
            'filter' => $model,
            'type' => 'striped bordered datatable',
            'dataProvider' => $model->search(),
            'responsiveTable' => true,
            'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  Classifieds</h3></div><div class="panel-body">{items}{pager}</div></div>',
            'columns' => $gridColumns
                )
        );
        ?>
    </div>
</div>