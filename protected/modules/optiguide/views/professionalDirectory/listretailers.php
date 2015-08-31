<?php
/* @var $this SuppliersDirectoryController */
/* @var $model SuppliersDirectory */
/* @var $form CActiveForm */

$cs_pos_end = CClientScript::POS_END;
$themeUrl = $this->themeUrl;
?>

<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
        <div class="inner-container"> 
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'suppliers-directory-form',
                'htmlOptions' => array('role' => 'form'),
            ));
            ?>
            <div class="forms-cont"> 
                <div class="forms-heading"><i class="fa fa-users"></i> <?php echo Myclass::t('OGO152', '', 'og');?></div>
                <div class="row"> 
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <table class="table table-bordered bckrnd">
                            <tr>   
                                <th><input type="checkbox" class="simple" name="checkall" id="selecctall"></th>
                                <th> <?php echo Myclass::t('OGO156', '', 'og'); ?> </th>       

                            </tr>
                            <?php
                            if (!empty($results)) {
                                foreach ($results as $userinfo) {
                                    ?>
                                    <tr>
                                        <td><input type="checkbox" name="retailerid[]" class="simple checkbox1" value="<?php echo $userinfo['ID_RETAILER']; ?>"></td>
                                        <td>
                                            <?php
                                            $dispname = $userinfo['COMPAGNIE'];
                                            echo CHtml::link($dispname, array('/optiguide/retailerDirectory/view', 'id' => $userinfo['ID_RETAILER']), array('target'=>'_blank')). " " . $userinfo['NOM_VILLE'] . "," . $userinfo['ABREVIATION_' . $this->lang] . "," . $userinfo['NOM_PAYS_' . $this->lang];
                                            ?>
                                        </td>                                 
                                    </tr>    
                                    <?php
                                }
                            } else {
                                ?>
                                <tr><td colspan="2">  <?php echo Myclass::t('OGO155', '', 'og'); ?> .</td></tr>
                            <?php }
                            ?>                         
                        </table>
                    </div>
                    
                     <?php
                    if (!empty($results)) {
                        ?>

                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 pull-right"> 
                        <?php
                        echo CHtml::tag('button', array(
                            'name' => 'btnSubmit',
                            'type' => 'submit',
                            'class' => 'submit-btn',
                            'value' => 'retailersubmit'
                                ), '<i class="fa fa-arrow-circle-right"></i> '.Myclass::t('OGO87', '', 'og'));
                        ?>
                    </div>                      
                   <?php
                    }?>
                    
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
<?php
$msgconfirm = Myclass::t('OGO153', '', 'og');
$delconfirm = Myclass::t('OGO154', '', 'og');
$js = <<< EOD
        
$(document).ready(function(){
        
$("#suppliers-directory-form").submit(function() {
    
   var checked = $(this).find("input[name='retailerid[]']:checked").length;
   
   if ( checked == 0 ) 
    {
        alert( "{$delconfirm}" );
        return false;
    }
        
   var text  = "{$msgconfirm}"+( ( checked == 1 ) ? "?" : "s?" );
   return confirm( text );     
        
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