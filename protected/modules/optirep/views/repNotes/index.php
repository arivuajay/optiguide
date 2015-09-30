<div class="cate-bg user-right">
    <h2> My Notes </h2>
    <div class="row"> 
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">  
            <div class="table-responsive">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered">
                    <tr>
                        <th width="9%">S. No</th>
                         <th width="20%"> User</th>
                        <th width="80%"> Notes</th>                       
                        <th width="10%"> Created </th>
                        <th width="5%"> Actions </th>
                    </tr>
                    <?php                   
                    if (!empty($model)) {
                        $i = ($pages->getCurrentPage()==0)?"1":($pages->getCurrentPage()*5)+1;
                        foreach ($model as $notes) { 
                            
                            if($notes['NOM_TABLE']=='Professionnels')
                            {
                                $viewpage = "professionalDirectory";
                            }elseif($notes['NOM_TABLE']=='Detaillants')
                            {
                                $viewpage = "retailerDirectory";
                            } 
                            ?>                          
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo CHtml::link($notes['NOM_UTILISATEUR'], array('/optirep/'.$viewpage.'/view', 'id' => $notes['ID_RELATION']), array('target' => '_blank')) . ' '; ?></td>
                                <td><?php echo nl2br($notes['message']);?></td>                                 
                                <td><?php echo $notes['created_at']; ?></td>                               
                                <td>
                                    <?php echo CHtml::link( '<i class="fa fa-trash"></i>', array('/optirep/repNotes/delete', 'id' => $notes['id'])); ?>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="4"> No Records Found </td>
                        </tr>
                    <?php } ?>
                </table>
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
<?php
$js = <<< EOD
    $(document).ready(function () {
        
       
    });
EOD;
Yii::app()->clientScript->registerScript('_rep_notes_index', $js);
?>