<?php
/* @var $this SuppliersDirectoryController */
/* @var $model SuppliersDirectory */
/* @var $form CActiveForm */
?>
<?php
// echo $form->hiddenField($model, 'Auth_Acc_Id', array('value' => $author_model->Auth_Acc_Id));
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'select-marques-form',
    'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
    'action' => Yii::app()->createUrl('/admin/suppliersDirectory/addmarques/'),
        ));

 $marids = Yii::app()->user->getState("marque_ids");
 $proids = Yii::app()->user->getState("product_ids");
//echo "<pre>";
// print_r($proids );
// print_r($marids );
//echo "</pre>"; 
 ?> 
<div class="box box-primary">    
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <div class="box">                   
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tr>                              
                                <th>Produits</th>
                                <th>Section</th>
                                <th>&nbsp;</th>
                                <th><input type="checkbox" class="simple" name="checkall" id="selecctall"></th>
                            </tr>
                            <?php
                            if(!empty($data_products))
                            {
                                foreach($data_products as $info)
                                {
                                    $listmarques = Yii::app()->createUrl('/admin/suppliersDirectory/listmarques/',array('id'=>$info->ID_PRODUIT));

                                    ?>
                                     <tr>
                                        <td><?php echo $info->NOM_PRODUIT_FR;?></td>
                                        <td><?php echo $info->sectionDirectory->NOM_SECTION_FR;?></td>
                                        <td><a href="<?php echo $listmarques;?>">Marques</a></td>
                                        <td><input type="checkbox" name="productid[]" class="simple checkbox1" value="<?php echo $info->ID_PRODUIT;?>"></td>
                                    </tr>    
                                 <?php   
                                }
                            }else
                            {?>
                                    <tr><td colspan="4"> Aucun produit n'a été sélectionné</td></tr>
                           <?php }    
                           ?>                         
                        </table>
                    </div><!-- /.box-body -->                    
                </div><!-- /.box -->
            </div><!-- /.col -->                       
        </div><!-- /.row -->
         <?php echo CHtml::submitButton('Terminé', array('class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary')); ?>
        <?php
        if(!empty($data_products))
        {
         echo CHtml::submitButton('effacer', array('class' => 'btn btn-danger')); 
        }
         ?>
    </div>
    <!-- /.box-body -->     
</div>  
<?php $this->endWidget(); ?>