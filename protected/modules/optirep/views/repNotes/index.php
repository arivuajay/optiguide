<div class="cate-bg user-right">
    <h2> <?php echo Myclass::t('OR521', '', 'or') ?> </h2>
    <?php $this->renderPartial('_search', array('searchModel' => $searchModel)); ?>
    <div class="row"> 
        <?php if (Yii::app()->user->rep_role == "admin") { ?>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <?php echo CHtml::link('<i class="fa fa-plus"></i> ' . Myclass::t('OR567', '', 'or'), array('/optirep/repNotes/create'), array("class" => "pull-right")); ?>
            </div>
        <?php } ?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">  
            <div class="table-responsive">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered">
                    <tr>
                        <th width="9%">#</th>
                        <?php if (Yii::app()->user->rep_role != "admin") { ?>
                            <th width="20%"> <?php echo Myclass::t('OR572', '', 'or') ?> </th>
                        <?php } ?>
                        <th width="80%"> <?php echo Myclass::t('OR573', '', 'or') ?> </th>                       
                        <th width="10%"> <?php echo Myclass::t('OR574', '', 'or') ?> </th>
                        <th width="10%"> <?php echo Myclass::t('OR575', '', 'or') ?> </th>
                        <th width="5%"> <?php echo Myclass::t('OR531', '', 'or') ?> </th>
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
                                <?php if (Yii::app()->user->rep_role != "admin") { ?>
                                    <td><?php echo CHtml::link($notes['NOM_UTILISATEUR'], array('/optirep/' . $viewpage . '/view', 'id' => $notes['ID_RELATION']), array('target' => '_blank')) . ' '; ?></td>
                                <?php } ?>
                                <td><?php echo (strlen($notes['message']) > 35) ? substr($notes['message'], 0, 35) . '..' : $notes['message']; ?></td>                                 
                                <td><?php echo $notes['alert_date']; ?></td>                               
                                <td><?php echo $notes['created_at']; ?></td>                               
                                <td>
                                    <?php echo CHtml::link('<i class="fa fa-eye"></i>', array('#'), array("data-toggle" => "modal", "data-target" => "#viewmessage_" . $notes['id'])); ?>&nbsp;
                                    <?php echo CHtml::link('<i class="fa fa-pencil-square-o"></i>', array('/optirep/repNotes/update', 'id' => $notes['id'])); ?>&nbsp;
                                    <?php echo CHtml::link('<i class="fa fa-trash"></i>', array('/optirep/repNotes/delete', 'id' => $notes['id']), array('confirm' => Myclass::t('OR534', '', 'or'))); ?>
                                </td>
                            </tr>
                            <!-- Note Display Box-->
                            <div class="modal fade" id="viewmessage_<?php echo $notes['id']; ?>" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title"><?php echo Myclass::t('OR573', '', 'or') ?></h4>
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
                            <td colspan="6"> <?php echo Myclass::t('OR043', '', 'or') ?> </td>
                        </tr>
                    <?php } ?>
                </table>
                <?php
                $this->widget('CLinkPager', array(
                    'pages' => $pages,
                    'currentPage' => $pages->getCurrentPage(),
                    'itemCount' => $item_count,
                    'pageSize' => $page_size,
                    'maxButtonCount' => 10,
                    'header' => '',
                    'selectedPageCssClass' => 'active',
                    'htmlOptions' => array(
                        'class' => 'pagination',
                    ),
                ));
                ?>
            </div>            
        </div>
    </div>
</div>
