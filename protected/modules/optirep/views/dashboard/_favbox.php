<?php
$urole = Yii::app()->user->rep_role;
$rep_id = Yii::app()->user->id;
?>
<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    <div class="cate-bg"> 
        <div class="cate-heading">  <?php echo ($urole == "admin") ? "<i class='fa fa-users'></i> My Representatives" : "<i class='fa fa-heart'></i> Favorites"; ?></div>
        <?php
        if ($urole == "admin") {
            $my_usrs = '';
            $myusers = RepCredentials::model()->findAll(array("limit" => "4", "order" => "rep_credential_id desc", "condition" => "rep_parent_id=" . $rep_id));
            $myusers = array();
            if (!empty($myusers)) {
                foreach ($myusers as $uinfo) {
                    $my_usrs .= "<div class='fav-cont favusers'>" . CHtml::image($this->themeUrl . '/images/fav.jpg');
                    $my_usrs .= $uinfo['rep_username'] . "</div>";
                }
                $my_usrs .= "<div class='viewall'>" . CHtml::link(Myclass::t('OG038', '', 'og'), array('/optirep/repAccounts/'), array('class' => '')) . "</div>";
            } else {
                $my_usrs = "<p class='fav_message'>You have no representative users right now." . CHtml::link("Click", array('/optirep/repAccounts')) . " to add your users!!!.</p>";
            }
            echo $my_usrs;
        } else {
//          $myfavourites = Yii::app()->db->createCommand() //this query contains all the data
//                    ->select('rr.ID_RETAILER,rr.COMPAGNIE,rt.NOM_TYPE_' . $this->lang)
//                    ->from(array('rep_favourites rf', 'repertoire_retailer rr', 'repertoire_retailer_type AS rt'))
//                    ->where("rr.ID_RETAILER=rf.ID_RETAILER AND rt.ID_RETAILER_TYPE=rr.ID_RETAILER_TYPE AND rf.rep_credential_id =" . $rep_id)
//                    ->order(',rf.id desc')
//                    ->limit(4)
//                    ->queryAll();
            
            $myfavourites = Yii::app()->db->createCommand() //tihs query contains all the data
                    ->select('ru.NOM_UTILISATEUR,ru.NOM_TABLE,ru.ID_RELATION')
                    ->from(array('rep_favourites rf', 'repertoire_utilisateurs ru'))
                    ->where("rf.ID_UTILISATEUR=ru.ID_UTILISATEUR AND ru.status=1 AND (ru.NOM_TABLE='Professionnels' OR ru.NOM_TABLE='Detaillants') AND rf.rep_credential_id =" . $rep_id)
                    ->order('rf.id desc')
                    ->limit(4)
                    ->queryAll();

            $fav_rets = '';
            if (!empty($myfavourites)) {
                foreach ($myfavourites as $favinfo) {
                    $fav_rets .= "<div class='fav-cont favusers'>" . CHtml::image($this->themeUrl . '/images/fav.jpg');
                    $utype = '';                  
                    if($favinfo['NOM_TABLE']=='Professionnels')
                    {
                        $viewpage = "professionalDirectory";
                        $utype    = "Professionals";
                    }elseif($favinfo['NOM_TABLE']=='Detaillants')
                    {
                        $viewpage = "retailerDirectory";
                        $utype    = "Retailers";
                    }    
                    $fav_rets .= CHtml::link($favinfo['NOM_UTILISATEUR'], array('/optirep/'.$viewpage.'/view', 'id' => $favinfo['ID_RELATION'])) . "<br/> <span> <b> Type : </b> " . $utype . "</span> </div>";
                }
                $fav_rets .= "<div class='viewall'>" . CHtml::link(Myclass::t('OG038', '', 'og'), array('/optirep/repFavourites'), array('class' => '')) . "</div>";
            } else {
                $fav_rets = "<p class='fav_message'>You have no favorite users right now.See the retailers and professionals users and make it your favorite!!!.</p>";
            }
            echo $fav_rets;
        }
        ?>   
    </div>
</div>