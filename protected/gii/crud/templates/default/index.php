<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $dataProvider CActiveDataProvider */

<?php
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->title='$label';\n";
echo "\$this->breadcrumbs=array(
	'$label',
);\n";

echo "\$themeUrl = \$this->themeUrl;\n";
echo "\$cs = Yii::app()->getClientScript();\n";
echo "\$cs_pos_end = CClientScript::POS_END;\n\n";

echo "\$cs->registerScriptFile(\$themeUrl . '/js/datatables/jquery.dataTables.js', \$cs_pos_end);\n";
echo "\$cs->registerScriptFile(\$themeUrl . '/js/datatables/dataTables.bootstrap.js', \$cs_pos_end);\n";
?>
?>
<div class="col-lg-12 col-md-12" id="advance-search-block">
    <div class="row mb10" id="advance-search-label">
        <?php
        $search_icon = '<i class="fa fa-angle-right"></i>';
        echo "<?php echo CHtml::link('{$search_icon} Show Advance Search', 'javascript:void(0);', array('class' => 'pull-right')); ?>"
        ?>
    </div>
    <div class="row" id="advance-search-form">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="glyphicon glyphicon-search"></i>  Search
                </h3>
                <div class="clearfix"></div>
            </div>
            <section class="content">
                <div class="row">
                    <?php echo "<?php \$form=\$this->beginWidget('CActiveForm', array(
	'id'=>'search-form',
	'method'=>'get',
        'action' => array('/site/" . str_replace('-', '', $this->class2id($this->modelClass)) . "/index'),
        'htmlOptions' => array('role' => 'form')
)); ?>\n"; ?>

                     <?php
                     $restrict = $this->giiGenerateHiddenFields();
                foreach ($this->tableSchema->columns as $column) {
                    if ($column->autoIncrement || in_array($column->name, $restrict))
                        continue;
                    ?>
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <?php echo "<?php echo " . $this->generatesearchActiveLabel($this->modelClass, $column, '') . "; ?>\n"; ?>
                            <?php echo "<?php echo " . $this->generateSearchActiveField($this->modelClass, $column) . "; ?>\n"; ?>
                            <?php echo "<?php echo \$form->error(\$searchModel,'{$column->name}'); ?>\n"; ?>
                        </div>
                    </div>
                    <?php
                }
                ?>
                    <div class="col-lg-2 col-md-2">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <?php echo "<?php echo CHtml::submitButton('Search', array('class' => 'btn btn-primary form-control')); ?>\n"; ?>
                        </div>
                    </div>
                    <?php echo "<?php " ?> $this->endWidget(); ?>
                </div>
            </section>


        </div>
    </div>
</div>

<?php echo "<?php"; ?> if ($search) { ?>
    <div class="col-lg-12 col-md-12">
        <div class="row">
<?php echo "<?php\n"; ?>
        $gridColumns = array(
<?php
$count=0;
$activeFields = $this->giiGenerateActiveInActiveFields();
foreach($this->tableSchema->columns as $column)
{
    if($column->isPrimaryKey || in_array($column->name, $restrict))
		continue;
	if(++$count==7)
		echo "\t\t/*\n";
        if(in_array($column->name, $activeFields)):
            $green = '<i class="fa fa-circle text-green"></i>';
            $red = '<i class="fa fa-circle text-red"></i>';
            echo "\t\tarray(
                'name' => 'Active',
                'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle'),
                'type' => 'raw',
                'value' => function(\$data) {
                    echo (\$data->{$column->name} == 1) ? '{$green}' : '{$red}';
                },
            ),\n";
        else:
            echo "\t\t'".$column->name."',\n";
        endif;
}
if($count>=7)
	echo "\t\t*/\n";
?>
		array(
                'header' => 'Actions',
                'class' => 'booster.widgets.TbButtonColumn',
                'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
                'template' => '{view}{update}{delete}',
            )
            );

            $this->widget('booster.widgets.TbExtendedGridView', array(
            'type' => 'striped bordered',
            'dataProvider' => $searchModel->search(),
            'responsiveTable' => true,
            'template' => "<div class='panel panel-primary'><div class='panel-heading'><div class='pull-right'>{summary}</div><h3 class='panel-title'><i class='glyphicon glyphicon-search'></i> Search Results</h3></div>\n<div class='panel-body'>{items}\n{pager}</div></div>",
            'columns' => $gridColumns
                )
        );
        ?>
    </div>
    </div>
<?php echo "<?php"; ?> } ?>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <div class="col-lg-4 col-md-4 row">
            <div class="form-group">
                <label class="control-label">Spotlight Search: </label>
                <input type="text" class="form-control inline" name="base_table_search" id="base_table_search" />
            </div>
        </div>
        <?php echo "<?php"; ?> echo CHtml::link('<i class="fa fa-plus"></i>&nbsp;&nbsp;Create <?php echo $this->modelClass; ?>', array('/site/<?php echo strtolower($this->modelClass); ?>/create'), array('class' => 'btn btn-success pull-right')); ?>
    </div>
</div>

<div class="col-lg-12 col-md-12">
    <div class="row">
<?php echo "<?php\n"; ?>
        $gridColumns = array(
<?php
$count=0;
foreach($this->tableSchema->columns as $column)
{
    if($column->isPrimaryKey || in_array($column->name, $restrict))
		continue;
	if(++$count==7)
		echo "\t\t/*\n";
        if(in_array($column->name, $activeFields)):
            $green = '<i class="fa fa-circle text-green"></i>';
            $red = '<i class="fa fa-circle text-red"></i>';
            echo "\t\tarray(
                'name' => 'Active',
                'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle'),
                'type' => 'raw',
                'value' => function(\$data) {
                    echo (\$data->{$column->name} == 1) ? '{$green}' : '{$red}';
                },
            ),\n";
        else:
            echo "\t\t'".$column->name."',\n";
        endif;
}
if($count>=7)
	echo "\t\t*/\n";
?>
		array(
                'header' => 'Actions',
                'class' => 'booster.widgets.TbButtonColumn',
                'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
                'template' => '{view}{update}{delete}',
            )
            );

            $this->widget('booster.widgets.TbExtendedGridView', array(
            'type' => 'striped bordered datatable',
            'dataProvider' => $model->dataProvider(),
            'responsiveTable' => true,
            'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  <?php echo $label?></h3></div><div class="panel-body">{items}{pager}</div></div>',
            'columns' => $gridColumns
                )
        );
        ?>
    </div>
</div>