<?php
/* @var $this CityDirectoryController */
/* @var $dataProvider CActiveDataProvider */

$this->title = Myclass::t('APP42');
$this->breadcrumbs=array(
	Myclass::t('APP42'),
);
$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerScriptFile($themeUrl . '/js/datatables/jquery.dataTables.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/datatables/dataTables.bootstrap.js', $cs_pos_end);
?>
<?php
        $dataTree = array();
     
       // echo "<pre>"; print_r($models); exit;
        foreach ($models as $model):
           $ctycnt = '';
            $children = array();
            if ($model->cityDirectory) {
                foreach ($model->cityDirectory as $cities) {
                    $children[] = array('text' => CHtml::link($cities->NOM_VILLE, array('/admin/citydirectory/update/', 'id'=>$cities->ID_VILLE), array('id' => $cities->ID_VILLE)));
                }
            }
            if(!empty($children)){ $ctycnt = '('.count($children).')'; }
            $dataTree[] = array('children' => $children, 'text' => $model->NOM_REGION_FR.$ctycnt);           
        endforeach;
        
        //$staticval =  array( 'all_cnt' => Myclass::t('All countries')  );
 ?>
<?php
$regval = '';
$drp_val['class']   = 'form-control';
$drp_val['empty']   = 'Any region';        
if(isset($postinfo['regid']))
{    
    $drp_val['options'] =  array( $postinfo['regid'] => array('selected'=>true));
}  
if (isset($postinfo['ctyname']))
{    
    $ctyval = $postinfo['ctyname'];
}
 
$form = $this->beginWidget('CActiveForm', array(
                            'id' => 'region-directory-form',
                            'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),   
                            'action' => $this->createUrl('citydirectory/index'),
        ));
$regions = Myclass::getallregions();  
?>
     <div class="box-body">
                <div class="form-group">
                    <?php echo $form->labelEx($Rmodel, 'ID_REGION', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->dropDownList($Rmodel, 'ID_REGION', $regions, $drp_val); ?>                       
                    </div>
                </div>
                 <div class="form-group">
                    <?php echo $form->labelEx($Rmodel, 'NOM_VILLE', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($Rmodel, 'NOM_VILLE', array('value'=>$ctyval , 'class' => 'form-control', 'size' => 10, 'maxlength' => 10)); ?>
                    </div>
                </div>
         <div class="box-footer">
                <div class="form-group">
                    <div class="col-sm-5 col-sm-offset-2">
                        <?php echo CHtml::submitButton('Search', array('class' => 'btn btn-primary')); ?>
                    </div>
                </div>
            </div>
     </div>   
<?php $this->endWidget(); ?>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php echo CHtml::link('<i class="fa fa-plus"></i>&nbsp;&nbsp;'.Myclass::t('APP504').' '.Myclass::t('APP41'), array('/admin/citydirectory/create'), array('class' => 'btn btn-success pull-right')); ?>
    </div>
</div>

<div class="col-lg-12 col-md-12">&nbsp;</div>

<div class="col-lg-12 col-md-12">
    <div class="row">
       <div class="panel panel-primary">
            <div class="panel-heading"><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  <?php echo Myclass::t('APP42');?> </h3></div>
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