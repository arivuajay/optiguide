<?php
/* @var $this CategoryInformationController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Gestion des catégories d\'associations';
$this->breadcrumbs = array(
  'Gestion des catégories d\'associations',
);
$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerScriptFile($themeUrl . '/js/datatables/jquery.dataTables.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/datatables/dataTables.bootstrap.js', $cs_pos_end);
$btn_title = 'Ajouter une catégorie d\'association';

?>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php echo CHtml::link('<i class="fa fa-plus"></i>&nbsp;&nbsp;'.$btn_title, array('/admin/categoryInformation/create'), array('class' => 'btn btn-success pull-right')); ?>
    </div>
</div>

<div class="col-lg-12 col-md-12">&nbsp;</div>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php
        $gridColumns = array(
            array(
                'name' => 'check-boxes',
                'id' => 'selectedIds',
                'value' => '$data->ID_CATEGORIE',
                'class' => 'CCheckBoxColumn',
                'selectableRows' => 2,
                'checkBoxHtmlOptions' => array('class' => 'catgry simple'),
//              'headerHtmlOptions' => array('class' => 'simple'),
                'headerTemplate' => '<input type="checkbox" id="selectedIds_all" name="selectedIds_all" value="1" class="simple">'
            ),
            'CATEGORIE_FR',
            array(
                'class' => 'booster.widgets.TbButtonColumn',
                'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
                'template' => '{view}',
                'buttons' => array(
                    'view' => array(
                        // 'imageUrl'=>Yii::app()->request->baseUrl.'/css/gridViewStyle/images/gr-plus.png',
                        'url' => 'Yii::app()->createUrl("admin/sectionInformation/index", array("id"=>$data->ID_CATEGORIE))',
                    // 'options' => array('class' => 'editevent'),
                    ),
                )
            )
            ,
            array(
                'header' => Myclass::t('APP46'),
                'class' => 'booster.widgets.TbButtonColumn',
                'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
                'template' => '{update}{delete}',
            )
        );


        $this->beginWidget('CActiveForm', array(
            'id' => 'category-search-form',
            'enableAjaxValidation' => true,
            'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
        ));
        $this->widget('booster.widgets.TbExtendedGridView', array(
            'filter' => $model,
            'type' => 'striped bordered datatable',
            'dataProvider' => $model->search(),
            'responsiveTable' => true,
            'template' => '<div class="panel panel-primary">'
            . '                <div class="panel-heading">'
            . '                       <div class="pull-right">{summary}</div>'
            . '                           <h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Catégories d\'associations</h3>
                               </div>
                               <div class="panel-body">{items}{pager}</div> 
                               <div class="form-group">
                                  <div class="col-lg-12 col-md-12">'.CHtml::SubmitButton('supprimer tous', array('name' => 'btndeleteall', 'class' => 'btn btn-primary deleteall-button')).''
            . '                    </div>'
            . '                </div>'
            . '            </div>',
            'columns' => $gridColumns
                )
        );
        
        ?>
        
           
        
<?php
        $this->endWidget();
        ?>        
    </div>
</div>

<script type="text/javascript">
$(document).ready(function()
{
    $('.deleteall-button').live("click", function(){
        
        var atLeastOneIsChecked = $('input[name=\"selectedIds[]\"]:checked').length > 0;

        if (!atLeastOneIsChecked)
        {
                alert('Please select atleast one Item to delete');
                return false;
        }
        else if(window.confirm('Are you sure you want to delete the Selected?'))
        {
        
                document.getElementById('category-search-form').action='deleteall';
                document.getElementById('category-search-form').submit();
        }else
        {
                  return false;
        }
});

 $('#selectedIds_all').live("click", function(){
          $('.catgry').attr('checked', this.checked);
    });
 
 
 $('.catgry').live("click", function(){    
 
        if($('.catgry').length == $('.catgry:checked').length) {
            $('#selectedIds_all').attr('checked', 'checked');
        } else {
            $('#selectedIds_all').removeAttr('checked');
        }
 
    });
});    
</script>