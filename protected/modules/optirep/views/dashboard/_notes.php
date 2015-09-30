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
                ?>       
                <div class="fav-cont notes-cont"> 
                    <?php echo (strlen($notes['message']) > 100) ? substr($notes['message'], 0, 100) . '..' : $notes['message']; ?>
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