<?php
/* @var $this RegionDirectoryController */
/* @var $dataProvider CActiveDataProvider */

$this->title = Myclass::t('APP107');
$this->breadcrumbs = array(
    $this->title ,
);

$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerScriptFile($themeUrl . '/js/datatables/jquery.dataTables.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/datatables/dataTables.bootstrap.js', $cs_pos_end);
?>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php echo CHtml::link('<i class="fa fa-plus"></i>&nbsp;&nbsp;' . Myclass::t('APP504').' '.Myclass::t('APP106'), array('/admin/regiondirectory/create'), array('class' => 'btn btn-success pull-right')); ?>
    </div>
</div>

<div class="col-lg-12 col-md-12">&nbsp;</div>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php
        $dataTree = array();
        foreach ($models as $model):
            $children = array();
            if ($model->repertoireRegions) {
                foreach ($model->repertoireRegions as $regions) {
                    $children[] = array('text' => CHtml::link($regions->NOM_REGION_EN, array('/admin/regiondirectory/update/', 'id'=>$regions->ID_REGION), array('id' => $regions->ID_REGION)));
                }
            }

            $dataTree[] = array('children' => $children, 'text' => $model->NOM_PAYS_EN);
        endforeach;
        ?>
        <div class="panel panel-primary">
            <div class="panel-heading"><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  <?php echo Myclass::t('APP107');?> </h3></div>
            <div class="panel-body">
                <?php
                $this->widget('CTreeView', array(
                    'id' => 'category-treeview',
                    'data' => $dataTree,
                    'collapsed' => true,
                    'htmlOptions' => array(
                        'class' => 'treeview-famfamfam',
                    ),
                ));
                ?>

                <?php
                $this->widget('CLinkPager', array(
                    'pages' => $pages,
                    'header' => '',
                    'prevPageLabel' => '«',
                    'nextPageLabel' => '»',
                    'selectedPageCssClass' => 'active',
                    'htmlOptions' => array('class' => 'pagination pull-right'),
                ));
                ?>
            </div></div>
    </div>
</div>