<?php
/* @var $this SuppliersDirectoryController */
/* @var $model SuppliersDirectory */
/* @var $form CActiveForm */
$pid = Yii::app()->getRequest()->getQuery('id');

if (Yii::app()->user->hasState("product_ids")) {
    $marque_ids = Yii::app()->user->getState("marque_ids");
    if (!empty($marque_ids)) {
        $mval = $marque_ids[$pid];
        if ($mval != 0) {
            $exp_str = explode(',', $mval);
        }
    }
} else {
    $exp_str = array();
    $mval = 0;
}

$currenturl = Yii::app()->request->url;
$secondstep_url = Yii::app()->createUrl('/optiguide/suppliersDirectory/updateproducts/');
$thirdstep_url  = Yii::app()->createUrl('/optiguide/suppliersDirectory/updatemarques/');
?> 
<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 subscribe-btncont"> 
        <div class="inner-container"> 
           <?php   
          if (Yii::app()->user->hasState("relationid")) 
          {
            $relid  = Yii::app()->user->relationid;             
           ?>
              <h2> <?php echo Myclass::t('OG059', '', 'og'); ?> </h2>
            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 steps-cont <?php echo $act_class2; ?>">  
                <a href="<?php echo $secondstep_url; ?>"> <h4> <?php echo Myclass::t('OGO82', '', 'og'); ?> 1 </h4> <span> <?php echo Myclass::t('OG059', '', 'og'); ?></span> </a>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 steps-cont <?php echo $act_class3; ?>">  
                <a href="<?php echo $thirdstep_url; ?>"> <h4> <?php echo Myclass::t('OGO82', '', 'og'); ?>  2 </h4> <span> <?php echo Myclass::t('OG135'); ?></span> </a>
            </div>
           
          <?php 
          }else{  ?> 
             <h2> <?php echo Myclass::t('OGO81', '', 'og'); ?> </h2>           
            <?php  $this->renderPartial('_menu_steps', array());?>
         <?php }?>   
          
            
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'list-marques-form',
                'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
            ));
            ?>
            <div class="forms-cont">  
                <div class="forms-heading"><i class="fa fa-cubes"></i> <?php echo Myclass::t('OGO101', '', 'og'); ?></div>
                <div class="row"> 
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scroll-cont brands">
                        <div class="box" id="box1">
                            <table class="table table-bordered">    
                                <tr>
                                    <td><input type="checkbox" name="marqueid[]" id="group1" class="simple" value="0" <?php if ($mval == 0) { ?> checked <?php } ?>> All brands/Toutes les marques</td>
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
                        </div>    
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 pull-right"> 
                        <?php echo CHtml::submitButton(Myclass::t('OGO102', '', 'og'), array('class' => 'btn btn-primary')); ?>
                    </div>   
                </div>                
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div> 
</div>  
<?php
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
Yii::app()->clientScript->registerScript('_form_marqueslist', $js);
?>