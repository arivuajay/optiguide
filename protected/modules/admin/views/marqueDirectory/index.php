<?php
/* @var $this MarqueDirectoryController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Gestion des marques';
$this->breadcrumbs = array(
    'Gestion des marques',
);
$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerScriptFile($themeUrl . '/js/datatables/jquery.dataTables.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/datatables/dataTables.bootstrap.js', $cs_pos_end);
?>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php //echo CHtml::link('<i class="fa fa-plus"></i>&nbsp;&nbsp;Ajouter une marque', array('/admin/marqueDirectory/create'), array('class' => 'btn btn-success pull-right')); ?>
        <?php
        $this->widget(
            'application.components.MyTbButton', array(
            'label' => 'Ajouter une marque',
            'icon' => 'fa fa-plus',
            'url' => array('/admin/marqueDirectory/create'),
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
        $gridColumns = array(
            'NOM_MARQUE',
            array(
                'name' => 'Produits',              
                'type' => 'raw',
                'filter' => false,
                  //call the method 'gridDataColumn' from the controller
                'value' => array($this, 'gridDataColumn'),
            ),
            array(
                'header' => 'Actes',
                'class'  => 'application.components.MyActionButtonColumn',
                'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
                'template' => '{update}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{delete}',
            )
        );

        $this->widget('booster.widgets.TbExtendedGridView', array(
            'filter' => $model,
            'type' => 'striped bordered datatable',
            'dataProvider' => $model->search(),
            'responsiveTable' => true,
            'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  Gestion des marques</h3></div><div class="panel-body">{items}{pager}</div></div>',
            'columns' => $gridColumns
                )
        );
        ?>
    </div>
</div>
<div class="modal fade" id="products-disp-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-folder-open-o"></i> Produits et services associés :</h4>
                <div id="product_contents"></div>
            </div>
            
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php
$cs_pos_end = CClientScript::POS_END;
$themeUrl = $this->themeUrl;
$ajax_getproducts = Yii::app()->createUrl('/admin/marqueDirectory/getproducts');
$js = <<< EOD
$(document).ready(function()
{   
    $('.popupmarque').live('click',function(event){
        event.preventDefault();
        var marque_id = $(this).attr("id");      
        var dataString = 'id='+marque_id;
            
        $.ajax({
            type: "POST",
            url: '{$ajax_getproducts}',
            data: dataString,
            cache: false,
            success: function(html){             
                $("#product_contents").html(html);               
            }
         });
       
    });
  
});     
EOD;
Yii::app()->clientScript->registerScript('_form', $js);
?>