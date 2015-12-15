<?php
$this->title = 'Sales Rep';
$this->breadcrumbs = array(
    $this->title
);
?>
<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php
        $gridColumns = array(
            array('header' => 'SN.',
                'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            ),
            array(
                'name' => 'rep_username',
                'sortable' => false
            ),
            array(
                'name' => 'rep_password',
                'sortable' => false
            ),            
            array(
                'name' => 'rep_role',
                'sortable' => false
            ),
            array(
                'name' => 'rep_status',
                'type' => 'raw',
                'value' => function($data) {
                    echo ($data->rep_status == 1) ? "<i class='fa fa-circle text-green'></i>" : "<i class='fa fa-circle text-red'></i>";
                },
                'filter' => CHtml::activeDropDownList($model, 'rep_status', array("1" => "Active", "0" => "In-Active"), array('class' => 'form-control', 'prompt' => 'Tous')),
                'sortable' => false
            ),
            array(
                'name' => 'rep_expiry_date',
                 'sortable' => false
            ),
            array(
                'header' => 'Actions',
                'class' => 'booster.widgets.TbButtonColumn',
                'template' => '{view}',
            )
        );

        $this->widget('booster.widgets.TbExtendedGridView', array(
            'filter' => $model,
            'type' => 'striped bordered',
            'dataProvider' => $model->search(),
            'responsiveTable' => true,
            'template' => "<div class='panel panel-primary'><div class='panel-heading'><div class='pull-right'>{summary}</div><h3 class='panel-title'><i class='glyphicon glyphicon-book'></i>  Sales Rep </h3></div>\n<div class='panel-body'>{items}\n{pager}</div></div>",
            'columns' => $gridColumns
                )
        );
        ?>
    </div>
</div>