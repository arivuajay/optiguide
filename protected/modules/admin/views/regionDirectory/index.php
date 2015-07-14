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
 <?php
        $dataTree = array();
     
       // echo "<pre>"; print_r($models); exit;
        foreach ($models as $model):
           $regcnt = '';
            $children = array();
            if ($model->repertoireRegions) {
                foreach ($model->repertoireRegions as $regions) {
                    $children[] = array('text' => CHtml::link($regions->NOM_REGION_FR, array('/admin/regiondirectory/update/', 'id'=>$regions->ID_REGION), array('id' => $regions->ID_REGION)));
                }
            }
            if(!empty($children)){ $regcnt = '('.count($children).')'; }
            $dataTree[] = array('children' => $children, 'text' => $model->NOM_PAYS_FR.$regcnt);           
        endforeach;
        
        //$staticval =  array( 'all_cnt' => Myclass::t('All countries')  );
 ?>
 <?php
$regval = '';
$drp_val['class']   = 'form-control';
$drp_val['empty']   = 'Any country';        
if(isset($postinfo['cntryid']))
{    
    $drp_val['options'] =  array( $postinfo['cntryid'] => array('selected'=>true));
}  
if (isset($postinfo['regname']))
{    
    $regval = $postinfo['regname'];
}
 
$form = $this->beginWidget('CActiveForm', array(
                            'id' => 'region-directory-form',
                            'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),   
                            'action' => $this->createUrl('regiondirectory/index'),
        ));
$countries = Myclass::getallcountries();  
?>
     <div class="box-body">
                <div class="form-group">
                    <?php echo $form->labelEx($Rmodel, 'ID_PAYS', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->dropDownList($Rmodel, 'ID_PAYS', $countries, $drp_val); ?>                       
                    </div>
                </div>
                 <div class="form-group">
                    <?php echo $form->labelEx($Rmodel, 'NOM_REGION_FR', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($Rmodel, 'NOM_REGION_FR', array('value'=>$regval , 'class' => 'form-control', 'size' => 10, 'maxlength' => 10)); ?>
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
        <?php echo CHtml::link('<i class="fa fa-plus"></i>&nbsp;&nbsp;' . Myclass::t('APP504').' '.Myclass::t('APP106'), array('/admin/regiondirectory/create'), array('class' => 'btn btn-success pull-right')); ?>
    </div>
</div>

<div class="col-lg-12 col-md-12">&nbsp;</div>

<div class="col-lg-12 col-md-12">
    <div class="row">       
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