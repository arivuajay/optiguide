<div class="cate-bg user-right">
    <h2> Internal Messages </h2>
    <div class="row">     
        <?php
        $session_userid = Yii::app()->user->id;
        //$req2 = mysql_query('select  from pm as m1, pm as m2,users where ((m1.user1="'.$_SESSION['userid'].'" and m1.user1read="yes" and users.id=m1.user2) or (m1.user2="'.$_SESSION['userid'].'" and m1.user2read="yes" and users.id=m1.user1)) and m1.id2="1" and m2.id=m1.id group by m1.id order by m1.id desc');
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
                        <th width="20%"> User</th>
                        <th width="18%"> Message </th>
                        <th width="18%"> Date </th>
                    </tr>
                    <?php
                    if (!empty($mymessages)) {

                        $i = 1;
                        foreach ($mymessages as $infos) {
                            $mdisplay = (strlen($infos['message']) > 20) ? substr($infos['message'], 0, 20) . '...' : $infos['message'];
                            
                            $convid = $infos['id1'];
                                    
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
                                <td width="20%"><?php echo $infos['NOM_UTILISATEUR']; ?></td>
                                <td width="18%"><a href=""><?php echo CHtml::link($mdisplay , array('/optiguide/internalMessage/readmessage/convid/'.$convid)); ?></a></td>
                                <td width="18%"><?php echo date('Y/m/d H:i:s', $infos['timestamp']); ?></td>
                            </tr>
                            <?php
                            $i++;
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="3"> No Records Found </td>
                        </tr>
                    <?php } ?> 
                </table>
            </div>
        </div>
    </div>
</div>