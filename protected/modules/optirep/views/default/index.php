<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 landing-left">  
    <h2> <?php echo Myclass::t('OG194'); ?> </h2>
    <?php if (Yii::app()->language == 'en') { ?>
    <p>With Opti-Rep, you can finally keep all the information you need within reach. Find all the suppliers, brands and professionals’ details and contact information faster and easier than ever before. Our key-indicators and statistics allow you to create customized strategy for your ECP’s, You will have all in hands to assist your clients in achieving maximum sales and growth in their specific market; Perfect to help you and your clients meet your own objectives!</p>
    <p>Stay in touch with the optical industry. Opti-Rep provides you the latest news and the upcoming not-to-be-missed events, directly on you smartphone. </p>
    <p>Coordination tool are also provided for teams. You can finally manage and keep track with all you representatives, coast to coast.</p>
    <?php } else { ?>
    <p>Opti-Rep regroupe toutes les informations dont vous avez besoin à portée de main. </p>
    <p>Trouvez plus facilement et rapidement que jamais les coordonnées et les informations sur les fournisseurs, les marques et les professionnels dont vous avez besoin pour bien servir vos clients et les aider à maximiser leurs ventes! Obtenez de plus des statistiques clés sur vos clients, afin d’établir des stratégies plus personnalisées; parfait pour l’atteinte de vos objectifs et ceux de votre clientèle.</p>
    <p>Cette plateforme conçue spécifiquement pour les représentants vous offre de plus les dernières nouvelles de l’industrie de l’optique et les prochains événements à ne pas manquer. Rester au cœur de l’action n’a jamais été plus simple.</p>
    <p>Plusieurs outils de coordination sont aussi offerts dans cet outil adapté aux équipes de représentants. Découvrez dès maintenant comment vous aussi pourrez mieux gérer et suivre vos représentants, de Montréal à Saskatoon et de Charlottetown à Vancouver.</p>
    <?php }  ?>
</div>

<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 landing-left"> 
    <?php 
    $image = CHtml::image("{$this->themeUrl}/images/site-screen.jpg", 'Site Screen', array("width" => "673", "height" => "434")); 
    echo CHtml::link($image, array('/optirep/dashboard/'));
    ?>
</div>

<div class="clearfix"> </div>
<?php if(Yii::app()->user->isGuest){ ?>
<div class="col-xs-12 col-sm-8 col-md-6 col-lg-4 col-sm-offset-2 col-md-offset-3 col-lg-offset-4">
    <?php $this->renderPartial('_login_form', array('model' => $model)); ?>
</div>
<?php } ?>