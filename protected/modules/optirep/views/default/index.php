<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 landing-left">
       <h2> <?php echo Myclass::t('OG194'); ?> </h2>
       <?php if (Yii::app()->language == 'en') { ?>
       <p>Opti-Rep is a platform especially created for sales departments and sales representatives in the Canadian optical industry. It gives you the practical and useful information you need to better prospect new optical stores and extend your clientele.</p>
       <p>With Opti-Rep you can easily and rapidly find retailers and eyecare professionals’ coordinates and profiles and benefit from a complete solution that will maximise your efforts. Manage your follow ups, obtain key stats, plus find the latest news and events in only a few clicks.</p>
       <p>Coordinate your sales team with the help of an administrator’s account offered at no charge when opening two or more sales representatives’ accounts. Follow their actions and guide them in order to simplify and improve your working relations.</p>
       <p>Now is the time to discover the most complete sales tool in the optical industry, covering Canada from coast to coast. </p>
    <?php } else { ?>
       <p>Opti-Rep.com est une plateforme conçue spécifiquement pour les départements des ventes et représentants du domaine de l’optique au Canada. Ayez à portée de main toutes les informations dont vous avez besoin pour prospecter de nouvelles boutiques et étendre votre clientèle.</p>
       <p>En plus de trouver rapidement et facilement les coordonnées et profils des détaillants et des professionnels de la vue, bénéficiez d’un outil de travail complet qui vous aidera à maximiser vos efforts. Gérez vos suivis, obtenez des statistiques clés, soyez à l’affut des dernières nouvelles et évènements en quelques clics seulement.</p>
       <p>Coordonnez votre équipe de représentants à l’aide d’un compte administrateur totalement gratuit dès l’ouverture de deux comptes ou plus. Suivez leurs actions et conseillez-les afin de simplifier et améliorer vos relations de travail.</p>
       <p>Découvrez dès aujourd’hui l’outil le plus complet du monde de l’optique qui dessert le Canada d’est en ouest.</p>
    <?php }  ?>
       <div class="signup-cont">
          <?php echo CHtml::link(Myclass::t('OR763', '', 'or'), '/optirep/default/features') ?>    
        </div>
</div>
    
<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 landing-left"> 
       <?php
       if (Yii::app()->language == 'en') {
            $image = CHtml::image("{$this->themeUrl}/images/optirep.jpg", 'optirep');
       }  else {
            $image = CHtml::image("{$this->themeUrl}/images/optirep-fr.jpg", 'optirep');    
       }       
       echo CHtml::link($image, array('/optirep'));
       ?>
</div>
   
<div class="clearfix"> </div>
 
 <?php if(Yii::app()->user->isGuest){ ?>
    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-4 col-lg-offset-1">
        <?php $this->renderPartial('_login_form', array('model' => $model)); ?>
    </div>
    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6 ">
        <div class="signup-cont">
           <p> <?php echo Myclass::t('OR506', '', 'or') ?><br/>  </p>
          <?php echo CHtml::link(Myclass::t('OR507', '', 'or'), '/optirep/repCredential/step1') ?>    
        </div>
    </div>
<?php } ?>
