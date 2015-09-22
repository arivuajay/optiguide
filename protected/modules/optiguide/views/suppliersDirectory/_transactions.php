<?php
/* @var $this SuppliersDirectoryController */
/* @var $model SuppliersDirectory */
/* @var $form CActiveForm */
?>
<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 subscribe-btncont"> 
        <div class="inner-container"> 
            <h2> <?php echo Myclass::t('OGO139', '', 'og'); ?> </h2>

            <div class="forms-cont"> 
                <div class="forms-heading"><i class="fa fa-thumb-tack"></i> <?php echo Myclass::t('OGO140', '', 'og'); ?></div>
                <div class="row"> 
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <table class="table table-bordered" id="bckrnd">
                            <tr>   
                                <th><?php echo Myclass::t('OGO141', '', 'og'); ?></th>
                                <th><?php echo Myclass::t('OG138'); ?></th>
                                <th><?php echo Myclass::t('OG142'); ?></th>
                                <th><?php echo Myclass::t('OG140'); ?></th>
                                <th><?php echo "Txn ID"; ?></th>    
                                <th><?php echo Myclass::t('OGO142', '', 'og'); ?></th>
                            </tr> 
                            <?php if(!empty($model)){  
                                foreach ($model as $get_transactions) { ?>
                            <tr>
                                <td><?php echo $get_transactions['item_name']; ?></td>
                                <td><?php echo $get_transactions['total_price']; ?></td>
                                <td><?php echo ($get_transactions['pay_type']==1)?"Paypal":""; ?></td>
                                <td><?php echo $get_transactions['payment_status']; ?></td>
                                <td><?php echo $get_transactions['txn_id']; ?></td>                                
                                <td><?php echo $get_transactions['created_at']; ?></td>
                            </tr>
                            <?php 
                                }
                            
                                }else{?>
                            <tr>
                                 <td colspan="7"><?php echo Myclass::t('OGO143', '', 'og'); ?></td>
                            </tr>
                            <?php }?>
                        </table>
                    </div> 
                     <?php
                        $this->widget('CLinkPager', array(
                            'pages' => $pages,
                            'currentPage'=>$pages->getCurrentPage(),
                            'header' => '',    
                            'selectedPageCssClass'=>'active',
                            'htmlOptions'=>array(
                                'class'=>'pagination',                               
                            ),   
                        ))
                        ?>
                </div>
            </div>

        </div>
    </div>
</div>
