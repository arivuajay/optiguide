<?php
$urole = Yii::app()->user->rep_role;
$rep_id = Yii::app()->user->id;

if ($urole == "admin") {
    $myusers = RepCredentials::model()->findAll(array("limit" => "4", "order" => "rep_credential_id desc", "condition" => "rep_parent_id=" . $rep_id));
    $viewall = (!empty($myusers)) ? CHtml::link(Myclass::t('OR038', '', 'or'), array('/optirep/repAccounts'), array('class' => 'topviewall')) : '';
} else {
    $myfavourites = Yii::app()->db->createCommand() //tihs query contains all the data
            ->select('ru.NOM_UTILISATEUR,ru.NOM_TABLE,ru.ID_RELATION')
            ->from(array('rep_favourites rf', 'repertoire_utilisateurs ru'))
            ->where("rf.ID_UTILISATEUR=ru.ID_UTILISATEUR AND ru.status=1 AND (ru.NOM_TABLE='Professionnels' OR ru.NOM_TABLE='Detaillants') AND rf.rep_credential_id =" . $rep_id)
            ->order('rf.id desc')
            ->limit(4)
            ->queryAll();
    $viewall = (!empty($myfavourites)) ? CHtml::link(Myclass::t('OR038', '', 'or'), array('/optirep/repFavourites'), array('class' => 'topviewall')) : '';
}
?>
<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    <div class="cate-bg"> 
        <div class="cate-heading">  
            <?php echo ($urole == "admin") ? "<i class='fa fa-users'></i> " . Myclass::t('OR513', '', 'or') : "<i class='fa fa-heart'></i> " . Myclass::t('OR514', '', 'or'); ?>
            <?php echo $viewall; ?>
        </div>
        <?php
        if ($urole == "admin") {
            $my_usrs = '';
            if (!empty($myusers)) {
                foreach ($myusers as $uinfo) {
                    $my_usrs .= "<div class='fav-cont favusers'>" . CHtml::image($this->themeUrl . '/images/fav.jpg');
                    $my_usrs .= $uinfo['rep_username'] . "</div>";
                }
            } else {
                $my_usrs = "<p class='fav_message'>" . Myclass::t('OR515', '', 'or') .  Myclass::t('OR516', array(':url'=>'/optirep/repAccounts'), 'or') . "</p>";
            }
            echo $my_usrs;
        } else {

            $fav_rets = '';
            if (!empty($myfavourites)) {
                foreach ($myfavourites as $favinfo) {
                    $fav_rets .= "<div class='fav-cont favusers'>" . CHtml::image($this->themeUrl . '/images/fav.jpg');
                    $utype = '';
                    if ($favinfo['NOM_TABLE'] == 'Professionnels') {
                        $viewpage = "professionalDirectory";
                        $utype = "Professionals";
                    } elseif ($favinfo['NOM_TABLE'] == 'Detaillants') {
                        $viewpage = "retailerDirectory";
                        $utype = "Retailers";
                    }
                    $fav_rets .= CHtml::link($favinfo['NOM_UTILISATEUR'], array('/optirep/' . $viewpage . '/view', 'id' => $favinfo['ID_RELATION'])) . "<br/> <span> <b> Type : </b> " . $utype . "</span> </div>";
                }
            } else {
                $fav_rets = "<p class='fav_message'>" . Myclass::t('OR517', '', 'or') . "</p>";
            }
            echo $fav_rets;
        }
        ?>   
    </div>
</div>