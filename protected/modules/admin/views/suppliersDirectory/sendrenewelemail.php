<?php
/* @var $this SuppliersDirectoryController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Expired fournisseurs';
$this->breadcrumbs = array(
    'Gestion des fournisseurs',
);
$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerScriptFile($themeUrl . '/js/datatables/jquery.dataTables.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/datatables/dataTables.bootstrap.js', $cs_pos_end);
?>
<div class="col-lg-12 col-md-12">&nbsp;</div>
<form method="post" action="/admin/admin/create" id="admin-form" class="form-horizontal" role="form">     
<div class="col-lg-12 col-md-12">
    <div class="box box-primary">  
            <div class="box-header">
                        <h3 class="box-title">Send Renewal Email</h3>
                    </div>
        <div class="box-body">
            <div class="row">                
                <div class="col-md-4">                   
                   
                    <div class="form-group">  
                        <label class="col-sm-2">Subject</label>
                        <div class="col-sm-10">    
                            <?php
                            echo CHtml::textField('Text', 'some value', array('id' => 'idTextField',
                                'class' => 'form-control'));
                            ?>
                        </div>
                        <div class="col-sm-4">&nbsp;</div> 
                    </div>
                    <div class="form-group">  
                        <label class="col-sm-2">Content</label>
                        <div class="col-sm-10">  
                            <?php
                            echo CHtml::textArea('Content', $content, array('id' => 'widget', 'class' => 'form-control',
                            ));
                            ?>
                        </div>
                        <div class="col-sm-6">&nbsp;</div> 
                    </div>
                    <div class="col-lg-12">
                        <?php //echo CHtml::submitButton('Send', array('class'=>'btn btn-primary')); ?>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="col-lg-12 col-md-12"><p>Total Expire Users : <?php echo $total_expire_users; ?></p></div>
                    <table class="table table-bordered">
                        <tr>       
                            <th><input type="checkbox" class="simple" name="checkall" id="selecctall"></th>
                            <th>Bureau / Nom de compagnie</th>
                            <th>Type de fournisseurs</th>
                            <th>Expiry date</th>    
                        </tr>
                        <?php
                        if (!empty($expiry_users)) {
                            foreach ($expiry_users as $info) {
                                ?>
                                <tr>
                                    <td><input type="checkbox" name="uid[]" class="simple checkbox1" value="<?php echo $info->userDirectory2->ID_UTILISATEUR; ?>"></td>
                                    <td><?php echo $info->COMPAGNIE; ?></td>
                                    <td><?php echo $info->supplierType->TYPE_FOURNISSEUR_FR; ?></td>
                                    <td><?php echo ($info->profile_expirydate != "0000-00-00 00:00:00") ? date("d-m-Y", strtotime($info->profile_expirydate)) : "-"; ?></td>                                        
                                </tr>    
                                <?php
                            }
                        } else {
                            ?>
                            <tr><td colspan="4"> Aucun produit n'a été sélectionné</td></tr>
                        <?php }
                        ?>                         
                    </table>
                    <div class="col-lg-12">
                    <?php //echo CHtml::submitButton('Send', array('class'=>'btn btn-primary')); ?>
                    </div>
                </div><!-- /.col -->                       
            </div><!-- /.row -->

        </div>
        <!-- /.box-body -->     
    </div>  
</div>
</form>    
<?php
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