<?php
/* @var $this PollController */
/* @var $model CActiveDataProvider */

$this->title='Gérer les sondages';
$this->breadcrumbs=array(
	'Gérer les sondages',
);

$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerScriptFile($themeUrl . '/js/datatables/jquery.dataTables.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/datatables/dataTables.bootstrap.js', $cs_pos_end);
?>
<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php //echo CHtml::link('<i class="fa fa-plus"></i>&nbsp;&nbsp;Ajouter un sondages', array('/admin/poll/create'), array('class' => 'btn btn-success pull-right')); ?>
         <?php
        $this->widget(
            'application.components.MyTbButton', array(
            'label' => 'Ajouter un sondages',
            'icon' => 'fa fa-plus',
            'url' => array('/admin/poll/create'),
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
                    $years = array();
                    $criteria = new CDbCriteria();
                    $criteria->select = 'YEAR(polldate) as Year';
                    $criteria->group  = 'YEAR(polldate)'; 
                    $criteria->order  = 'Year DESC'; 
                    $reslt = Poll::model()->findAll($criteria);
                    foreach($reslt as $res)
                    {
                      $years[$res->Year] =   $res->Year;
                    }
                     
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'poll-search-form',
                        'method' => 'get',
                        'action' => array('/admin/poll/index/'),
                        'htmlOptions' => array('role' => 'form')
                    ));
                    ?>
                    
                    <div class="col-lg-3 col-md-3">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'Year', array('class' => ' control-label')); ?>
                            <?php echo $form->dropDownList($model, 'Year', $years, array('class' => 'form-control', 'prompt' => 'Toutes')); ?>                          
                        </div>
                    </div>                                 
                    <div class="col-lg-3 col-md-3">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'title', array('class' => ' control-label')); ?>
                           <?php echo $form->textField($model, 'title', array('class' => 'form-control', 'size' => 60)); ?>                     
                        </div>
                    </div>                   
                    <div class="col-lg-2 col-md-2">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <?php echo CHtml::submitButton('Filtrer', array('class' => 'btn btn-primary form-control')); ?>
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
		'title',             
                array(                   
                   'name' => 'polldate',
                   'value' => 'date("F Y",strtotime($data->polldate))',               
                ), 
//                array(                   
//                   'name' => 'usertype',
//                   'value' => function ($data) {
//                        $usertype = $data->usertype;
//                        if($usertype=="1")
//                        {
//                            $utype = "Professionnels";
//                        }else if($usertype=="2")
//                        {
//                            $utype = "Fournisseurs";
//                        }else if($usertype=="3")
//                        {
//                            $utype = "Detaillants";
//                        }         
//                        return $utype; // $data['name'] for array data, e.g. using SqlDataProvider.
//                    },
//                   'filter' => CHtml::activeDropDownList($model, 'usertype', array("1" => 'Professionals', "2" => 'Suppliers', "3" => 'Optical Retailers', "4" => 'Representatives' , '5' =>'others'), array('class' => 'form-control', 'prompt' => 'Tous')),
//                ),                
                array(
                'header' => 'actes',
                'class' => 'application.components.MyActionButtonColumn',
                'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
                'template' => '{view}&nbsp;&nbsp;&nbsp;{update}&nbsp;&nbsp;&nbsp;{delete}',
                ),
                array(
                'name'  => 'datedisplay',
                'value' => 'substr($data->polldate,0,7)',
                'headerHtmlOptions' => array('style'=>'display:none'),
                'htmlOptions' =>array('style'=>'display:none')
            )
        );
        

        $this->widget('booster.widgets.TbGroupGridView', array(      
            'type' => 'striped bordered datatable',
            'dataProvider' => $model->search(),        
            'responsiveTable' => true,
            'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>   Sondages</h3></div><div class="panel-body">{items}{pager}</div></div>',
            'extraRowColumns'=> array('datedisplay'),
            'extraRowExpression' => '"<b style=\"font-size: 20px; color: #333;\">".date("F",strtotime($data->polldate))." ".date("Y",strtotime($data->polldate))."</b>"',
            'extraRowHtmlOptions' => array('style'=>'padding:10px'),            
            'columns' => $gridColumns
          )
        );
        ?>
    </div>
</div>
 <script>
$(document).ready(function(){
    $.fn.dataTableExt.sErrMode = 'throw';
    });
</script>