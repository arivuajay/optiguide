<div class="cate-bg user-right">
    <h2> Internal Messages </h2>
    <div class="row">     
        <?php
        $rep_id = Yii::app()->user->id;
        // Get rep usetable id
        $condition  = " NOM_TABLE='rep_credentials' AND ID_RELATION='$rep_id' ";
        $ufrm_infos = UserDirectory::model()->find($condition);
        $session_userid = $ufrm_infos->ID_UTILISATEUR;
                
        $mymessages = Yii::app()->db->createCommand() //this query contains all the data
                ->select('m1.id1, m1.timestamp,m1.message,m1.timestamp, count(m2.id1) as reps, users.ID_UTILISATEUR as userid, users.NOM_UTILISATEUR')
                ->from(array('internal_message m1', 'internal_message m2', 'repertoire_utilisateurs users'))
                ->where("((m1.user1='$session_userid' and users.ID_UTILISATEUR=m1.user2) or (m1.user2='$session_userid' and users.ID_UTILISATEUR=m1.user1)) and m1.id2='1' and m2.id1=m1.id1")
                ->group('m1.id1')
                ->order('m1.id1 desc')
                ->queryAll();       
        ?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">  
            <div class="table-responsive">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered">
                    <tr>
                        <th width="9%">S. No</th>
                        <th width="20%"> Send To</th>
                        <th width="18%"> Message </th>
                         <th width="18%"> Date </th>
                    </tr>
                    <?php
                    if(!empty($mymessages))
                    {
                        
                     $i=1;  
                     foreach($mymessages as $infos)
                     {
                         $mdisplay = (strlen($infos['message']) > 20) ? substr($infos['message'], 0, 20) . '...' : $infos['message'];
                         $convid = $infos['id1'];
                         //SELECT * FROM internal_message WHERE( (user1='34159' AND user1read="no") OR (user2='34159' AND user2read="no") ) AND id1='2'
                         // Check the message unread
                         $unreadcount = 0;
                         $unreadmessages = Yii::app()->db->createCommand() //this query contains all the data
                            ->select('*')
                            ->from(array('internal_message'))
                            ->where("( (user1='$session_userid' AND user1read='no') OR (user2='$session_userid' AND user2read='no') ) AND id1='$convid'")
                            ->queryAll();
                         $unreadcount  = count($unreadmessages);
                         $hglightclass = ($unreadcount>0)?"highlight":'';
                            ?>  
                     <tr class="<?php echo $hglightclass;?>">
                        <td width="9%"><?php echo $i; ?></td>
                        <td width="20%"><?php echo $infos['NOM_UTILISATEUR'];?></td>
                         <td width="18%"><?php echo CHtml::link($mdisplay , array('/optirep/internalMessage/readmessage/convid/'.$convid)); ?></td>
                        <td width="18%"><?php echo date('Y/m/d H:i:s' ,$infos['timestamp']); ?></td>
                     </tr>
                    <?php 
                       $i++;
                     }
                    }else{?>
                    <tr>
                        <td colspan="4"> No Records Found </td>
                    </tr>
                    <?php }?> 
                </table>
            </div>
        </div>
    </div>
</div>