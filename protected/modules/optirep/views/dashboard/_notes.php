<?php
$urole = Yii::app()->user->rep_role;
$rep_id = Yii::app()->user->id;
?>
<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    <div class="cate-bg"> 
        <div class="cate-heading cate-heading2">  <i class="fa fa-pencil"></i>  My Notes  </div>
        <?php
        $rep_id = Yii::app()->user->id;
        $model_notes = Yii::app()->db->createCommand() //this query contains all the data
            ->select('rn.message,rn.created_at,ru.NOM_UTILISATEUR,ru.NOM_TABLE,ru.ID_RELATION')
            ->from(array('rep_notes rn', 'repertoire_utilisateurs ru'))
            ->where("rn.ID_UTILISATEUR=ru.ID_UTILISATEUR AND ru.status=1 AND (ru.NOM_TABLE='Professionnels' OR ru.NOM_TABLE='Detaillants') AND rn.rep_credential_id =" . $rep_id)
            ->order('rn.id desc')
            ->limit(4)
            ->queryAll();        
       
       if (!empty($model_notes)) {
            foreach ($model_notes as $notes) {
                
                 $nmessage = (strlen($notes['message']) > 35) ? substr($notes['message'], 0, 35) . '..' : $notes['message']; 
                 $uname    = (strlen($notes['NOM_UTILISATEUR']) > 25) ? substr($notes['NOM_UTILISATEUR'], 0, 25) . '..' : $notes['NOM_UTILISATEUR']; 
                 ?>
                 
               <div class="lastest-newscont">
                    <div class="lastest-newsconttxt"> 
                        <strong><?php echo $nmessage; ?></strong><br/> 
                        <span> <b> For : </b> <?php echo $uname; ?></span>
                    </div>
                    <div class="lastest-date"> <span> <?php echo date("M", strtotime($notes['created_at'])) . ' ' . date("d", strtotime($notes['created_at'])) ?> </span> </div>
                </div>  
            <?php }
            ?>
            <div class="viewall"><?php echo CHtml::link(Myclass::t('OG038', '', 'og'), array('/optirep/repNotes'), array('class' => '')); ?></div>        
            <?php
        } else {
            echo "<p class='fav_message'>You have no notes right now.</p>";
        }
        ?>
    </div>
</div>