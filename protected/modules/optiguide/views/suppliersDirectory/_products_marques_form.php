<?php
/* @var $this SuppliersDirectoryController */
/* @var $model SuppliersDirectory */
/* @var $form CActiveForm */

$cs_pos_end = CClientScript::POS_END;
$themeUrl = $this->themeUrl;
$marids = Yii::app()->user->getState("marque_ids");
$proids = Yii::app()->user->getState("product_ids");
$marque_new_all = Yii::app()->user->getState("marque_ids_new_all");
$marque_new = Yii::app()->user->getState("marqueid_new");


$product_flag = 0;
$brand_flag   = 0;
?>

<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 subscribe-btncont"> 
        <div class="inner-container"> 
            <h2> <?php echo Myclass::t('OGO81', '', 'og'); ?> </h2>

            <?php  $this->renderPartial('_menu_steps', array());?>
            
            <?php
            
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'products-marque-form',
                'htmlOptions' => array('role' => 'form'),               
            ));
            ?>

            <div class="forms-cont"> 
                <div class="forms-heading"><i class="fa fa-cubes"></i> <?php echo Myclass::t('OG135'); ?></div>
                <div class="row">                   
                     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <p id="error_choosebrands" class="errorMessage"><?php echo Myclass::t('OG174');?></p>
                         <table class="table table-bordered" id="bckrnd">
                            <tr>   
<!--                            <th><input type="checkbox" class="simple" name="checkall" id="selecctall"></th>-->
                                <th>&nbsp;</th>
                                <th><?php echo Myclass::t('OGO89', '', 'og'); ?></th>
                                <th><?php echo Myclass::t('APP84');?></th>
                                <th>&nbsp;</th>

                            </tr>
                            <?php
                            if (!empty($data_products)) {  
                                $product_flag = 1;
                                foreach ($data_products as $info) {
                                    $listmarques = Yii::app()->createUrl('/optiguide/suppliersDirectory/listmarques/', array('id' => $info->ID_PRODUIT));
                                    $delproducts = Yii::app()->createUrl('/optiguide/suppliersDirectory/delproducts/', array('id' => $info->ID_PRODUIT));
                                    
                                    $mnames = array();
                                    $marque_names = '';
                                    $prd_id = $info->ID_PRODUIT;
                                    
                                    if(isset($marids[$prd_id]))
                                    { 
                                        $prd_marque_ids = $marids[$prd_id];
                                        if($prd_marque_ids!='')
                                        {    
                                            $marqueinfos = MarqueDirectory::model()->findAll(array('condition'=>"ID_MARQUE IN ($prd_marque_ids)",'order'=>'NOM_MARQUE ASC'));

                                            foreach ($marqueinfos as $minfo)
                                            {
                                               $mnames[] = $minfo->NOM_MARQUE;
                                            }  
                                            
                                            if(!empty($mnames))
                                            {
                                                $marque_names = implode(',',$mnames);
                                            }
                                        }
                                            
                                    }
                                    if(isset($marque_new[$prd_id])){
                                        if($marque_names!='')
                                        { 
                                            $marque_names = $marque_names.','.$marque_new[$prd_id];
                                        }  else {
                                            $marque_names = $marque_new[$prd_id];
                                        }
                                    }
                                    if($marque_names=='')
                                    {
                                        $marque_names = "<span class='errorMessage'>".Myclass::t('OG175')."</span>";
                                        $brand_flag   = 1;
                                    }    
                                    ?>
                                    <tr>
<!--                                    <td><input type="checkbox" name="productid[]" class="simple checkbox1" value="<?php //echo $info->ID_PRODUIT; ?>"></td>-->
                                        <td><a href="<?php echo $delproducts;?>" class="sendrequest" onclick="return confirm('<?php echo Myclass::t('OG170'); ?>');"><i class="glyphicon glyphicon-trash"></i></a></td>
                                        <td><?php if(Yii::app()->session['language']== "EN") { echo $info->NOM_PRODUIT_EN; }else{ echo $info->NOM_PRODUIT_FR;} ?> <br>
                                            <?php echo "<span class='dispmarques'> <strong>".Myclass::t('OG171')."</strong>: ".$marque_names."</span>"; ?>
                                        </td>
                                        <td><?php if(Yii::app()->session['language']== "EN") { echo $info->sectionDirectory->NOM_SECTION_EN; }else{ echo $info->sectionDirectory->NOM_SECTION_FR;} ?></td>
                                        <td><a href="<?php echo $listmarques; ?>" class="selectmarque"><?php echo Myclass::t('OG169'); ?></a></td>                                  
                                    </tr>    
                                    <?php
                                }
                            } else {
                                ?>
                                <tr><td colspan="4"> <?php echo Myclass::t('OGO9O', '', 'og'); ?></td></tr>
                            <?php }
                            ?>                         
                        </table>
                     </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 pull-right"> 
                        <?php
                        echo CHtml::tag('button', array(
                            'name' => 'btnSubmit',
                            'type' => 'submit',
                            'class' => 'submit-btn',
                            'value' => 'marquesubmit'
                                ), '<i class="fa fa-arrow-circle-right"></i> ' . Myclass::t('OGO80', '', 'og'));
                        ?>
                    </div>   
                    <?php
                    //if (!empty($data_products)) {
                        ?>

                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                         <?php  // echo CHtml::submitButton(Myclass::t('OGO100', '', 'og') , array('class' => 'btn btn-danger')); ?>
                        </div>     
                    <?php //}
                    ?>
                </div>
            </div>
           <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
<?php
$cs = Yii::app()->getClientScript();

 if (Yii::app()->user->hasState("product_ids")) 
 {     
      $sess_product_ids = Yii::app()->user->getState("product_ids");     
      $jsoncde = json_encode($sess_product_ids);
 }                

$ajaxproducts = Yii::app()->createUrl('/admin/suppliersDirectory/getproducts');
$js = <<< EOD
$(document).ready(function(){
   
   var product_flag = '{$product_flag}';   
   var brand_flag   = '{$brand_flag}';
        
   $("#error_choosebrands").hide();
   $("#products-marque-form").submit(function(e) {       

    if(product_flag=="1" && brand_flag=="1") {
            $("#error_choosebrands").show();        
            return false;
        }
        return true;
    });        
 
// Select all checkboxes for delete products.   
    $('#selecctall').click(function(event) {  //on click        
        if(this.checked) { // check select status
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"              
            });
        }else{
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                      
            });        
        }
    });         
            
});
EOD;
Yii::app()->clientScript->registerScript('_form_marques', $js);
?>