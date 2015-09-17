<div class="cate-bg user-right">
    <h2> My Notes </h2>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">  
     <?php echo CHtml::link('<i class="fa fa-plus"></i> Create New', array('/optirep/repNotes/create'),array("class"=>"pull-right")); ?>
    </div>    
    <div class="row"> 
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">  
            <div class="table-responsive">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered">
                    <tr>
                        <th width="9%">S. No</th>
                        <th width="80%"> Notes</th>
                        <th width="10%"> Created </th>
                        <th width="5%"> Actions </th>
                    </tr>
                    <?php                   
                    if (!empty($model)) {
                        $i = ($pages->getCurrentPage()==0)?"1":($pages->getCurrentPage()*5)+1;
                        foreach ($model as $notes) { ?>                          
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $notes['message'];?></td>
                                <td><?php echo $notes['created_at']; ?></td>                               
                                <td>
                                    <?php echo CHtml::link( '<i class="fa fa-pencil"></i>', array('/optirep/repNotes/update', 'id' => $notes['id'])); ?>
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