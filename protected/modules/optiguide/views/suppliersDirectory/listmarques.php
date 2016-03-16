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
    $marque_ids_new = Yii::app()->user->getState("marqueid_new");
    
    if (!empty($marque_ids_new)) {
        $mval_new = $marque_ids_new[$pid];
        if ($mval_new != '' ) {
            $exp_str_new = explode(',', $mval_new);
        }
    }
   
} else {
    $exp_str = array();  
    //$mval = 0;
}

$currenturl = Yii::app()->request->url;
$secondstep_url = Yii::app()->createUrl('/optiguide/suppliersDirectory/updateproducts/');
$thirdstep_url  = Yii::app()->createUrl('/optiguide/suppliersDirectory/updatemarques/');

$product_infos = ProductDirectory::model()->findByPk($pid);
$pname = "NOM_PRODUIT_".Yii::app()->session['language'];

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
                <div class="forms-heading"><i class="fa fa-cubes"></i> <?php echo Myclass::t('OGO101', '', 'og'). " - " .$product_infos->$pname; ?></div>
                <div class="row"> 
                    
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scroll-cont brands">
                        <p id="error_brand" class="errorMessage"><?php echo Myclass::t('OG175');?></p> 
                        <div class="box" id="box1">
                            <table class="table table-bordered">    
<!--                            <tr>
                                    <td><input type="checkbox" name="marqueid[]" id="group1" class="simple" value="0" <?php //if ($mval == 0) { ?> checked <?php //} ?>> All brands/Toutes les marques</td>
                                </tr>-->
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
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scroll-cont brands">
                        <p><?php echo Myclass::t('OGO225', '', 'og'); ?></p>
                        <div class="col-xs-8 col-sm-7 col-md-9 col-lg-9">
                                <input type="text" class="form-txtfield" placeholder="<?php echo Myclass::t('OG229'); ?>" id="new_brand">
                                <div style="" id="new_brand_error" class="errorMessage" style="display:none;"></div>
                        </div>
                        <div class="col-xs-4 col-sm-5 col-md-3 col-lg-3">
                            <a href="javascript:void(0)" class="btn btn-success" id="add_brand_link">
                                <?php echo Myclass::t('OGO223', '', 'og'); ?>
                            </a>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scroll-cont brands">
                        
                        <?php if (!empty($get_selected_marques_new)) { ?>
                        <div class="box" id="box1">
                            <table class="table table-bordered">
                                <?php foreach ($get_selected_marques_new as $k => $info_new) {
                                        if (!empty($exp_str_new)) {
                                            if (in_array($k, $exp_str_new)) {
                                                $checked = "checked";
                                            } else {
                                                $checked = '';
                                            }
                                        }
                                        ?>
                                        <tr>
                                            <td><input type="checkbox" name="marqueid_new[]" class="simple checkbox1" <?php echo $checked; ?> value="<?php echo $info_new; ?>"> <?php echo $info_new; ?>

                                            </td>
                                        </tr>    
                                        <?php } ?>
                            </table>
                        </div>
                        <?php } ?>                         
                                
                    </div>
                      <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 pull-right scroll-cont"> 
                        <?php echo CHtml::submitButton(Myclass::t('OGO102', '', 'og'), array('class' => 'btn btn-primary pull-right')); ?>
                    </div> 
                </div>                
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div> 
</div>  
<?php
$ids=Yii::app()->request->getParam('id');
$ajaxbrand = Yii::app()->createUrl('/optiguide/suppliersDirectory/getbrand');
$already = Myclass::t('OGO224', '', 'og');
$empty = Myclass::t('OG232');
$js = <<< EOD
$(document).ready(function(){
        $("#add_brand_link").click(function(){
            $('#new_brand_error').hide();
            var MARQUE = $('#new_brand').val();
            var pid = {$ids};
            if(MARQUE!=''){
                var dataString = 'MARQUE='+ MARQUE+'&pid='+pid;
                $.ajax({
                    type: "POST",
                    url: '{$ajaxbrand}',
                    data: dataString,
                    cache: false,
                    success: function(reps){
                        if(reps=='exit'){
                            $('#new_brand_error').text('{$already}');
                            $('#new_brand_error').show();
                        }else{
                            $('#new_brand_error').hide();
                            $('#new_brand').val('');
                            location.reload();
                        }
                    }
                 });
            }else{
                $('#new_brand_error').text('{$empty}'); 
                $('#new_brand_error').show();
            }
        });
//       var allbrand = '{$mval}';
//        if(allbrand==0)
//        {
//            $("input.checkbox1").attr("disabled", true);       
//        }
//        $("#group1").click(enable_cb);        
   
   $("#error_brand").hide();
   $("#list-marques-form").submit(function(e) {       

    if(!$('input[type=checkbox]:checked').length) {
            $("#error_brand").show();        
            return false;
        }
        return true;
    });   
});

//function enable_cb() {     
//  if (this.checked) {   
//   $("input.checkbox1").attr("disabled", true);   
//  }else
//  {
//   $("input.checkbox1").removeAttr("disabled");
//  }      
//}

EOD;
Yii::app()->clientScript->registerScript('_form_marqueslist', $js);
?>