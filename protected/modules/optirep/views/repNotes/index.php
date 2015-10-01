<div class="cate-bg user-right">
    <h2> My Notes </h2>
    <div class="row"> 
        <?php if(Yii::app()->user->rep_role=="admin"){?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <?php echo CHtml::link('<i class="fa fa-plus"></i> Add Note', array('/optirep/repNotes/create'), array("class" => "pull-right")); ?>
        </div>
        <?php }?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">  
            <div class="table-responsive">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered">
                    <tr>
                        <th width="9%">S. No</th>
                        <?php if(Yii::app()->user->rep_role!="admin"){?>
                        <th width="20%"> User</th>
                        <?php }?>
                        <th width="80%"> Notes</th>                       
                        <th width="10%"> Created </th>
                        <th width="5%"> Actions </th>
                    </tr>
                    <?php
                    if (!empty($model)) {
                        $i = ($pages->getCurrentPage() == 0) ? "1" : ($pages->getCurrentPage() * 5) + 1;
                        foreach ($model as $notes) {

                            if ($notes['NOM_TABLE'] == 'Professionnels') {
                                $viewpage = "professionalDirectory";
                            } elseif ($notes['NOM_TABLE'] == 'Detaillants') {
                                $viewpage = "retailerDirectory";
                            }
                            ?>                          
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <?php if(Yii::app()->user->rep_role!="admin"){?>
                                <td><?php echo CHtml::link($notes['NOM_UTILISATEUR'], array('/optirep/' . $viewpage . '/view', 'id' => $notes['ID_RELATION']), array('target' => '_blank')) . ' '; ?></td>
                                <?php }?>
                                <td><?php echo (strlen($notes['message']) > 35) ? substr($notes['message'], 0, 35) . '..' : $notes['message']; ?></td>                                 
                                <td><?php echo $notes['created_at']; ?></td>                               
                                <td>
                                    <?php echo CHtml::link('<i class="fa fa-eye"></i>', array('#'), array("data-toggle" => "modal", "data-target" => "#viewmessage_".$notes['id'])); ?>&nbsp;
                                    <?php echo CHtml::link('<i class="fa fa-pencil-square-o"></i>', array('/optirep/repNotes/update', 'id' => $notes['id'])); ?>&nbsp;
                                    <?php echo CHtml::link('<i class="fa fa-trash"></i>', array('/optirep/repNotes/delete', 'id' => $notes['id'])); ?>
                                </td>
                            </tr>
                            <!-- Note Display Box-->
                            <div class="modal fade" id="viewmessage_<?php echo $notes['id']; ?>" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Notes</h4>
                                        </div>                                       
                                        <div class="modal-body model-form">
                                            <div class="row"> 
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <?php echo nl2br($notes['message']); ?>      
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                           

                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="5"> No records found. </td>
                        </tr>
                    <?php } ?>
                </table>
                <?php
                $this->widget('CLinkPager', array(
                    'pages' => $pages,
                    'currentPage' => $pages->getCurrentPage(),
                    'header' => '',
                    'selectedPageCssClass' => 'active',
                    'htmlOptions' => array(
                        'class' => 'pagination',
                    ),
                ))
                ?>
            </div>
        </div>
    </div>
</div>
