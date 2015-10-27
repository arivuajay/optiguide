<?php
/* @var $this PollController */
/* @var $model Poll */

$this->title = 'View sondage résultat ';
$this->breadcrumbs = array(
    'Gérer les sondages' => array('index'),
    $this->title,
);

$expurl = $this->createUrl('poll/view/id/'.$model->id,array("exportresult"=>"1"));
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
            <p><a href="<?php echo $expurl;?>" class="btn btn-info"> <span class="glyphicon glyphicon-download"></span> Export  </a></p>
    </div><!-- /.box-body -->
</div>
<?php
if($model->usertype=='1')
{    ?>


<div class="col-lg-12 col-md-12">&nbsp;</div>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php      
       
        $gridColumns = array(  
                array('header' => 'SN.',
                 'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                ), 
                array(
                'header'  => 'Choice',    
                'name'    => 'pollChoice.label',
                'value'   => $data->pollChoice->label,                
                ),
                array(
                'header'  => 'Professional Type',    
                'name'    => 'professionalType.TYPE_SPECIALISTE_FR',
                'value'   => $data->professionalType->TYPE_SPECIALISTE_FR,                
                ),
                array(
                'header'  => 'Province',    
                'name'    => 'regionDirectory.NOM_REGION_FR',
                'value'   => $data->regionDirectory->NOM_REGION_FR,                
                ),
                array(
                'header'  => 'Ville',    
                'name'    => 'cityDirectory.NOM_VILLE',
                'value'   => $data->cityDirectory->NOM_VILLE,                
                ),
                array(
                'header'  => 'Voted on',    
                'name'    => 'timestamp',                 
                'value'   =>  'date("Y-m-d",$data->timestamp)',                
                ),                 
        );

        $this->widget('booster.widgets.TbExtendedGridView', array(
            'type' => 'striped bordered datatable',
            'ajaxUrl' => $this->createUrl('poll/view/id/'.$model->id),
            'dataProvider' => $vmodel,
            'responsiveTable' => true,
            'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  Gestion des Votes</h3></div><div class="panel-body">{items}{pager}<div class="pull-right">{summary}</div></div></div>',
            'columns' => $gridColumns
            )
        );
        ?>
    </div>
</div>
<?php
}?>
