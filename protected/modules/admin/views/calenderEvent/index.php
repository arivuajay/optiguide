<?php
/* @var $this CalenderEventsController */
/* @var $dataProvider CActiveDataProvider */

$this->title='Gestion des événements';
$this->breadcrumbs=array(
	'Gestion des événements',
);
$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerScriptFile($themeUrl . '/js/datatables/jquery.dataTables.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/datatables/dataTables.bootstrap.js', $cs_pos_end);
?>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php echo CHtml::link('<i class="fa fa-plus"></i>&nbsp;&nbsp;Ajouter un événement', array('/admin/calenderEvent/create'), array('class' => 'btn btn-success pull-right')); ?>
    </div>
</div>

<div class="col-lg-12 col-md-12">&nbsp;</div>
<div class="col-lg-12 col-md-12">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="glyphicon glyphicon-search"></i>  Search
                </h3>
                <div class="clearfix"></div>
            </div>
            <section class="content">
                <div class="row">
                    <?php
                    $criteria = new CDbCriteria();
                    $criteria->select = 'YEAR(DATE_AJOUT1) as Year';
                    $criteria->group  = 'YEAR(DATE_AJOUT1)'; 
                    $criteria->order  = 'Year DESC'; 
                    $reslt = CalenderEvent::model()->findAll($criteria);
                   foreach($reslt as $res)
                   {
                      $years[$res->Year] =   $res->Year;
                   }
                     
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'calenderevent-search-form',
                        'method' => 'get',
                        'action' => array('/admin/calenderEvent/index/'),
                        'htmlOptions' => array('role' => 'form')
                    ));
                    ?>

                    <div class="col-lg-3 col-md-3">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'LANGUE', array('class' => ' control-label')); ?>
                            <?php echo $form->dropDownList($model, 'LANGUE', array("FR" => 'Français', "EN" => 'Anglais'), array('class' => 'form-control', 'prompt' => 'Tous')); ?>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'Year', array('class' => ' control-label')); ?>
                            <?php echo $form->dropDownList($model, 'Year', $years, array('class' => 'form-control', 'prompt' => 'Toutes')); ?>                          
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'Emplacement', array('class' => ' control-label')); ?>
                           <?php echo $form->textField($model, 'Emplacement', array('class' => 'form-control', 'size' => 60)); ?>                 
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'keyword', array('class' => ' control-label')); ?>
                           <?php echo $form->textField($model, 'keyword', array('class' => 'form-control', 'size' => 60)); ?>                     
                        </div>
                    </div>                   
                    <div class="col-lg-2 col-md-2">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <?php echo CHtml::submitButton('Search', array('class' => 'btn btn-primary form-control')); ?>
                        </div>
                    </div>
                    <?php $this->endWidget(); ?>
                </div>
            </section>


        </div>
    </div>
</div>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php
        $gridColumns = array(
                'TITRE',
                'LANGUE',
		'DATE_AJOUT1',
		'DATE_AJOUT2',		
                array(
                'header' => 'Actions',
                'class' => 'booster.widgets.TbButtonColumn',
                'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
                'template' => '{update}{delete}',
                )
        );
        
        $groupGridColumns   = $gridColumns;   
        $groupGridColumns[] = array(
            'name'  => 'datedisplay',
            'value' => 'substr($data->DATE_AJOUT1,0,7)',
            'headerHtmlOptions' => array('style'=>'display:none'),
            'htmlOptions' =>array('style'=>'display:none')
        );

        $this->widget('booster.widgets.TbGroupGridView', array(
        //'filter' => $model,
        'type' => 'striped bordered datatable',
        'dataProvider' => $model->search(),        
        'responsiveTable' => true,
        'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>   Événement</h3></div><div class="panel-body">{items}{pager}</div></div>',
        'extraRowColumns'=> array('datedisplay'),
        'extraRowExpression' => '"<b style=\"font-size: 20px; color: #333;\">".date("F",strtotime($data->DATE_AJOUT1))." ".date("Y",strtotime($data->DATE_AJOUT1))."</b>"',
        'extraRowHtmlOptions' => array('style'=>'padding:10px'),
        'columns' => $groupGridColumns
        )
        );
        ?>
    </div>
</div>