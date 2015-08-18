<?php
/* @var $this SuppliersDirectoryController */
/* @var $model SuppliersDirectory */
/* @var $form CActiveForm */

$cs_pos_end = CClientScript::POS_END;
$themeUrl = $this->themeUrl;
$marids = Yii::app()->user->getState("marque_ids");
$proids = Yii::app()->user->getState("product_ids");
?>

<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 subscribe-btncont"> 
        <div class="inner-container"> 
            <h2> <?php echo Myclass::t('OGO81', '', 'og'); ?> </h2>

            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 steps-cont">  
                <a href="<?php echo Yii::app()->createUrl('/optiguide/suppliersDirectory/create/'); ?>"> <h4> <?php echo Myclass::t('OGO82', '', 'og'); ?> 1 </h4> <span> <?php echo Myclass::t('OG112'); ?>  </span> </a>
            </div>

            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 steps-cont">  
                <a href="<?php echo Yii::app()->createUrl('/optiguide/suppliersDirectory/addproducts/'); ?>"> <h4> <?php echo Myclass::t('OGO82', '', 'og'); ?> 2 </h4> <span> <?php echo Myclass::t('OG059', '', 'og'); ?></span> </a>
            </div>

            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 steps-cont active-stpe">  
                <a href="<?php echo Yii::app()->createUrl('/optiguide/suppliersDirectory/addmarques/'); ?>"> <h4> <?php echo Myclass::t('OGO82', '', 'og'); ?> 3 </h4> <span> <?php echo Myclass::t('OG135'); ?></span> </a>
            </div>

            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 steps-cont ">  
                <a href="#"> <h4> <?php echo Myclass::t('OGO82', '', 'og'); ?> 4 </h4> <span> <?php echo Myclass::t('OG136'); ?> </span> </a>
            </div>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'suppliers-directory-form',
                'htmlOptions' => array('role' => 'form'),               
            ));
            ?>

            <div class="forms-cont"> 
                <div class="forms-heading"><i class="fa fa-cubes"></i> <?php echo Myclass::t('OG135'); ?></div>
                <div class="row"> 
                     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                         <table class="table table-bordered" id="bckrnd">
                            <tr>   
                                <th><input type="checkbox" class="simple" name="checkall" id="selecctall"></th>
                                <th><?php echo Myclass::t('OGO89', '', 'og'); ?></th>
                                <th><?php echo Myclass::t('APP84');?></th>
                                <th>&nbsp;</th>

                            </tr>
                            <?php
                            if (!empty($data_products)) {
                                foreach ($data_products as $info) {
                                    $listmarques = Yii::app()->createUrl('/optiguide/suppliersDirectory/listmarques/', array('id' => $info->ID_PRODUIT));
                                    ?>
                                    <tr>
                                        <td><input type="checkbox" name="productid[]" class="simple checkbox1" value="<?php echo $info->ID_PRODUIT; ?>"></td>
                                        <td><?php if(Yii::app()->session['language']== "EN") { echo $info->NOM_PRODUIT_EN; }else{ echo $info->NOM_PRODUIT_FR;} ?></td>
                                        <td><?php if(Yii::app()->session['language']== "EN") { echo $info->sectionDirectory->NOM_SECTION_EN; }else{ echo $info->sectionDirectory->NOM_SECTION_FR;} ?></td>
                                        <td><a href="<?php echo $listmarques; ?>"><?php echo Myclass::t('OG010', '', 'og'); ?></a></td>                                  
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
                            'class' => 'submit-btn'
                                ), '<i class="fa fa-arrow-circle-right"></i> ' . Myclass::t('OGO80', '', 'og'));
                        ?>
                    </div>   
                    <?php
                    if (!empty($data_products)) {
                        ?>

                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4"> 
                         <?php   echo CHtml::submitButton(Myclass::t('OGO100', '', 'og') , array('class' => 'btn btn-danger')); ?>
                        </div>     
                    <?php }
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
Yii::app()->clientScript->registerScript('_form', $js);
?>