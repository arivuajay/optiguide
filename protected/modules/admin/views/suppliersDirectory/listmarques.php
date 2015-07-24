<?php
/* @var $this SuppliersDirectoryController */
/* @var $model SuppliersDirectory */
/* @var $form CActiveForm */
$this->title = 'List the marques for the products';
$this->breadcrumbs = array(
    'Suppliers Directories' => array('index'),
    $this->title,
);
?>
<?php
// echo $form->hiddenField($model, 'Auth_Acc_Id', array('value' => $author_model->Auth_Acc_Id));
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'list-marques-form',
    'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
        ));

$pid = Yii::app()->getRequest()->getQuery('id');

if (Yii::app()->user->hasState("product_ids")) 
{
    $marque_ids = Yii::app()->user->getState("marque_ids");
    if (!empty($marque_ids)) 
    {
        $mval = $marque_ids[$pid];       
        if($mval!=0)
        {    
            $exp_str = explode(',', $mval);
        }  
    }
} else {
    $exp_str = array();
    $mval = 0;
}
?> 
<div class="box box-primary">    
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <div class="box-header">
                    <h3 class="box-title">Cochez les marques distribuées</h3>
                </div>
                <div class="box">                   
                    <div class="box-body">
                        <table class="table table-bordered">    
                            <tr>
                                <td><input type="checkbox" name="marqueid[]" id="group1" class="simple" value="0" <?php if($mval==0){ ?> checked <?php }?>> All brands/Toutes les marques</td>
                            </tr>
                            <?php
                            if (!empty($get_selected_marques)) {


                                foreach ($get_selected_marques as $k => $info) {

                                    if (!empty($exp_str)) {
                                        if (in_array($k, $exp_str)) {
                                            $checked = "checked";
                                        } else {
                                            $checked = '';
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td><input type="checkbox" name="marqueid[]" class="simple checkbox1" <?php echo $checked; ?> value="<?php echo $k; ?>"> <?php echo $info; ?>

                                        </td>
                                    </tr>    
                                    <?php
                                }
                            }
                            ?>                         
                        </table>
                    </div><!-- /.box-body -->                    
                </div><!-- /.box -->
            </div><!-- /.col -->                       
        </div><!-- /.row -->
        <?php echo CHtml::submitButton('Save', array('class' => 'btn btn-primary')); ?>       
    </div>
    <!-- /.box-body -->     
</div>  
<?php
$this->endWidget();
$js = <<< EOD
    $(document).ready(function(){
        var allbrand = '{$mval}';
        if(allbrand==0)
        {
            $("input.checkbox1").attr("disabled", true);       
        }
        $("#group1").click(enable_cb);         
});
function enable_cb() {     
  if (this.checked) {   
   $("input.checkbox1").attr("disabled", true);   
  }else
  {
   $("input.checkbox1").removeAttr("disabled");
  }      
}
EOD;
Yii::app()->clientScript->registerScript('_form', $js);
?>