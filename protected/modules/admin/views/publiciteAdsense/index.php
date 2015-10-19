<?php
/* @var $this PubliciteAdsenseController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Publicite Adsenses';
$this->breadcrumbs = array(
    'Publicite Adsenses',
);
$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerScriptFile($themeUrl . '/js/datatables/jquery.dataTables.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/datatables/dataTables.bootstrap.js', $cs_pos_end);
?>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php echo CHtml::link('<i class="fa fa-plus"></i>&nbsp;&nbsp;Create PubliciteAdsense', array('/admin/publiciteAdsense/create'), array('class' => 'btn btn-success pull-right')); ?>
    </div>
</div>

<div class="col-lg-12 col-md-12">&nbsp;</div>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php
        $gridColumns = array(
            'publicityPosition.sPosition',        
            'publicityPosition.sFormat',               
            array(             
             'name'    => 'status',
             'htmlOptions' => array('style' => 'width: 180px;text-align:center', 'vAlign' => 'middle'),             
             'type' => 'raw',
             'value' => function($data) {
             echo ($data->status == 1) ? "<i class='fa fa-circle text-green'></i>" : "<i class='fa fa-circle text-red'></i>";
              },
            ),          
            array(
                'name' => 'created_date',
                'filter' => false
            ),
            array(
                'header' => 'Actions',
                'class' => 'booster.widgets.TbButtonColumn',
                'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
                'template' => '{update}&nbsp;&nbsp;&nbsp;{delete}',
            )
        );

        $this->widget('booster.widgets.TbExtendedGridView', array(
           // 'filter' => $model,
            'type' => 'striped bordered datatable',
            'dataProvider' => $model->search(),
            'responsiveTable' => true,
           // 'rowCssClassExpression'=>'($data->status==1)?"ads_active":"ads_expired"',
            'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  Publicite Adsenses</h3></div><div class="panel-body">{items}{pager}</div></div>',
            'columns' => $gridColumns
                )
        );
        ?>
    </div>
</div>