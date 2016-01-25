<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
<div class="cate-bg user-right">
<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
        <div class="inner-container eventslist-cont"> 
            <div class="search-list">
                <div class="news-thumbs news-details"> 
                    <h4>  <?php echo Myclass::t('OR715', '', 'or') ?> </h4> 
                    <?php if (Yii::app()->language == 'en') { ?>
                    <div class="clearfix"></div>
<!--                    <p>With Opti-Rep, you can finally keep all the information you need within reach. Find all the suppliers, brands and professionals’ details and contact information faster and easier than ever before. Our key-indicators and statistics allow you to create customized strategy for your ECP’s, You will have all in hands to assist your clients in achieving maximum sales and growth in their specific market; Perfect to help you and your clients meet your own objectives!</p>
                    <p>Stay in touch with the optical industry. Opti-Rep provides you the latest news and the upcoming not-to-be-missed events, directly on you smartphone. </p>
                    <p>Coordination tool are also provided for teams. You can finally manage and keep track with all you representatives, coast to coast.</p>-->
                    <p><b>Search for Optical stores</b> </p>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-4"> 
                    <?php  $image = CHtml::image("{$this->themeUrl}/images/Retailers.png", 'optirep'); echo CHtml::link($image, array('/optirep'));?>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-8"> 
                    <ul>
                        <li>A complete list of optical stores, updated daily, accompanied by an interactive map</li>
                        <li>Easy search by selecting one or more criteria: Name, Type of Store, Group,Professional Categories, City, Province and Postal Code</li>
                        <li>Geo-localization: map display with possibility to create an itinerary and display directions</li>
                        <li>A versatile profile record: ad an optical store to your favorites, send an email, report a change, add notes</li>
                        <li>Live referential data interface: view and monitor professionals working in selected optical stores and click to access the profile.</li>
                    </ul>
                    </div>
                    
                    <div class="clearfix"></div>
                    <p><b>Search for Optical Professionals</b></p>
                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-8"> 
                    <ul>
                        <li>A complete list of optical professionals, updated daily, accompanied by an interactive map</li>
                        <li>Easy search by selecting one or more criteria: Name, Professional Categories, City, Province and Postal Code</li>
                        <li>Geo-localization: map display with possibility to create an itinerary and display directions</li>
                        <li>A versatile profile record: ad a professional to your favorites, send an email, report a change, add notes</li>
                        <li>Live referential data interface: view and monitor the optical stores where the selected professional is working and click to access the optical store profile.</li>
                    </ul>
                    
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-4"> 
                    <?php  $image = CHtml::image("{$this->themeUrl}/images/Professionals.png", 'optirep'); echo CHtml::link($image, array('/optirep'));?>
                    </div>
                    <div class="clearfix"></div>
                    <p><b>Search Suppliers</b></p>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-4"> 
                    <?php  $image = CHtml::image("{$this->themeUrl}/images/Supplier.png", 'optirep'); echo CHtml::link($image, array('/optirep'));?>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-8"> 
                    <ul>
                        <li>A list of optical distributors available with their coordinates. </li>
                        <li>A profile is displayed when the supplier is an <a href="http://www.opti-guide.com/">Opti-Guide</a> member</li>
                        <li>Easy search by selecting one or more criteria: Company Name, Type of Supplier, Brand, Product or Service Category.</li>
                    </ul>
                    </div>
                    <div class="clearfix"></div>
                    <p><b>Calendar</b></p>
                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-8">
                        Find all national and international optical events with relevant information. Accessible directly on the account home page.
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-4"> 
                    <?php  $image = CHtml::image("{$this->themeUrl}/images/Calendar.png", 'optirep'); echo CHtml::link($image, array('/optirep'));?>
                    </div>
                    <div class="clearfix"></div>
                    <p><b>News</b></p>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-4"> 
                    <?php  $image = CHtml::image("{$this->themeUrl}/images/News.png", 'optirep'); echo CHtml::link($image, array('/optirep'));?>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-8">
                     Access to all the Canadian and international news concerning the optical industry, as well as important updates about optical retail stores and professionals. Accessible directly on the account home page.
                    </div>
                    <div class="clearfix"></div>
                    <p><b>My Notes</b></p>
                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-8">
                        Add, modify or delete notes attributed to colleagues, suppliers and clients. Amend professional profiles. Accessible directly on the account home page.
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-4"> 
                    <?php  $image = CHtml::image("{$this->themeUrl}/images/Notes.png", 'optirep'); echo CHtml::link($image, array('/optirep'));?>
                    </div>
                    <div class="clearfix"></div>
                    <p><b>Favourites</b></p>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-4"> 
                    <?php  $image = CHtml::image("{$this->themeUrl}/images/Favorites.png", 'optirep'); echo CHtml::link($image, array('/optirep'));?>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-8">
                        A personalized list of favourite optical stores and professionals to keep handy for rapid referral and follow-ups.
                    </div>
                    <div class="clearfix"></div>
                    <p><b>Messages</b></p>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        An interactive internal messaging service to reach actual and potential clients (professionals & optical retailers).
                    </div>
                    <div class="clearfix"></div>
                    <p><b>Statistics</b></p>
                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-8">
                        Current stats on the Canadian optical industry, organized by city, and province (extra monthly fee applicable)
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-4">
                        <?php  $image = CHtml::image("{$this->themeUrl}/images/Stats.png", 'optirep'); echo CHtml::link($image, array('/optirep'));?>
                    </div>
                    <div class="clearfix"></div>
                    <p><b>Classified</b></p>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        Optical professionals can post classified ads, at no cost, to promote the sale of their office, equipment or services. A good way for sales representatives to stay informed of upcoming changes in the market.
                    </div>
                    <div class="clearfix"></div>
                    <p><b>Miscellaneous</b></p>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 last-pag">
                        Includes other players in the optical industry such as associations, foundations, organizations, institutions, governments, and more.
                    </div>
                    <div class="clearfix"></div>
                    <h4> <?php echo Myclass::t('OR759', '', 'or') ?> </h4> 
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-4 last-pag">
                        <?php  $image = CHtml::image("{$this->themeUrl}/images/Rep profile.jpg", 'optirep'); echo CHtml::link($image, array('/optirep'));?>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-8">
                    <ul>
                        <li>Users can personalize the profile with a picture</li>
                        <li>Easily change profile information.</li>
                        <li>Add represented brands and territory</li>
                        <li>View and monitor account expiration date</li>
                        <li>Renew membership directly in the account</li>
                    </ul>
                    </div>
                    <div class="clearfix"></div>
                     <h4> <?php echo Myclass::t('OR760', '', 'or') ?> </h4> 
                     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 last-pag">
                        <ul>
                            <li>Free administration account with the purchase of two or more representative accounts</li>
                            <li>Reduced price (per account and per month)</li>
                            <li>Possibility to create, modify and delete sales representative accounts</li>
                            <li>Daily activity follow-up of each representative: connect and view sales representative profiles</li>
                        </ul>
                     </div>
                     <h4> <?php echo Myclass::t('OR761', '', 'or') ?> </h4> 
                     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 last-pag">Opti-Rep.com is an interactive website adapted to all types of devices: desktop computers, laptops, smart phones and tablets. No need to install an application for usage.</div>
                     <h4> <?php echo Myclass::t('OR762', '', 'or') ?> </h4> 
                     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 last-pag">Membership options per month, six months or the entire year. Renewal available by confirmation and direct payment directly in the online account.</div>
                      
                        <?php } else { ?>
                    
<!--                    <p>Opti-Rep regroupe toutes les informations dont vous avez besoin à portée de main.</p>
                    <p>Trouvez plus facilement et rapidement que jamais les coordonnées et les informations sur les fournisseurs, les marques et les professionnels dont vous avez besoin pour bien servir vos clients et les aider à maximiser leurs ventes! Obtenez de plus des statistiques clés sur vos clients, afin d’établir des stratégies plus personnalisées; parfait pour l’atteinte de vos objectifs et ceux de votre clientèle.</p>
                    <p>Cette plateforme conçue spécifiquement pour les représentants vous offre de plus les dernières nouvelles de l’industrie de l’optique et les prochains événements à ne pas manquer. Rester au cœur de l’action n’a jamais été plus simple.</p>
                    <p>Plusieurs outils de coordination sont aussi offerts dans cet outil adapté aux équipes de représentants. Découvrez dès maintenant comment vous aussi pourrez mieux gérer et suivre vos représentants, de Montréal à Saskatoon et de Charlottetown à Vancouver.</p>-->
                    <p><b>Recherche de boutiques d’optique</b> </p>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-4"> 
                    <?php  $image = CHtml::image("{$this->themeUrl}/images/Retailers French.png", 'optirep'); echo CHtml::link($image, array('/optirep'));?>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-8"> 
                    <ul>
                        <li>Une liste de détaillants complète, mise à jour quotidiennement et accompagnée d’une carte interactive</li>
                        <li>Une recherche facilitée par la sélection d’un ou plusieurs critères : Nom, Type boutique, Regroupement, Catégorie professionnelle, Ville, Province et Code postal</li>
                        <li>Géolocalisation : affichage d’une carte avec possibilité de créer un visualisable avec instructions routières</li>
                        <li>Une fiche de profil polyvalente : ajouter le détaillant à vos favoris, envoyer courriel, signaler un changement, ajouter une note</li>
                        <li>Interface de données référentielles : visualiser le(s) professionnel(s) qui travaille(nt) dans la boutique sélectionnée et cliquez pour accéder à leur profil</li>
                    </ul>
                    </div>
                    
                    <div class="clearfix"></div>
                    <p><b>Recherche de professionnels de la vue</b></p>
                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-8"> 
                    <ul>
                        <li>Une liste de professionnels complète, mise à jour quotidiennement et accompagnée d’une carte interactive</li>
                        <li>Une recherche facilitée par la sélection d’un ou plusieurs critères : Nom, Type professionnel, Ville, Province et Code postal</li>
                        <li>Géo localisation : affichage d’une carte avec possibilité de créer un visualisable avec instructions routières</li>
                        <li>Une fiche de profil polyvalente : ajouter le professionnel à vos favoris, un courriel, signaler un changement, ajouter une note</li>
                        <li>Interface de données référentielles : visualiser la (ou les) boutique dans laquelle travaille le professionnel sélectionné et cliquez pour accéder au profil de la boutique</li>
                    </ul>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-4"> 
                    <?php  $image = CHtml::image("{$this->themeUrl}/images/Professionals French.png", 'optirep'); echo CHtml::link($image, array('/optirep'));?>
                    </div>
                    <div class="clearfix"></div>
                    <p><b>Recherche de fournisseurs</b></p>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-4"> 
                    <?php  $image = CHtml::image("{$this->themeUrl}/images/Suppliers French.png", 'optirep'); echo CHtml::link($image, array('/optirep'));?>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-8"> 
                    <ul>
                        <li>Une liste des fournisseurs de l’optique avec possibilité de voir leurs coordonnées. Un profil détaillé s’affichera si le fournisseur est membre de <a href="http://www.opti-guide.com/">Opti-Guide.com</a></li>
                        <li>Une recherche facilitée par la sélection d’un ou plusieurs critères : Nom l’entreprise, Type de fournisseur, Marque et Catégorie de produits et services</li>
                    </ul>
                    </div>
                    <div class="clearfix"></div>
                    <p><b>Calendrier</b></p>
                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-8">
                        Tous les évènements nationaux et internationaux de l’optique et informations utiles à leur sujet. Accessible directement en page d’accueil du compte.
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-4"> 
                    <?php  $image = CHtml::image("{$this->themeUrl}/images/Calendar.png", 'optirep'); echo CHtml::link($image, array('/optirep'));?>
                    </div>
                    <div class="clearfix"></div>
                    <p><b>Nouvelles</b></p>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-4"> 
                    <?php  $image = CHtml::image("{$this->themeUrl}/images/News French.png", 'optirep'); echo CHtml::link($image, array('/optirep'));?>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-8">
                         Accès à toutes les nouvelles de l’industrie de l’optique au Canada et l’étranger ainsi qu’aux mises à jour importantes des bureaux d’optiques et professionnels de la vue. Accessible directement en page d’accueil du compte.
                    </div>
                    <div class="clearfix"></div>
                    <p><b>Mes Notes</b></p>
                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-8">
                        Ajouter, modifier, supprimer des notes attribuées à des profils de détaillants et professionnels. Disponible dans le compte du représentant ainsi que sur la page d’accueil.
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-4"> 
                    <?php  $image = CHtml::image("{$this->themeUrl}/images/Notes.png", 'optirep'); echo CHtml::link($image, array('/optirep'));?>
                    </div>
                    <div class="clearfix"></div>
                    <p><b>Favoris</b></p>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-4"> 
                    <?php  $image = CHtml::image("{$this->themeUrl}/images/Favorites French.png", 'optirep'); echo CHtml::link($image, array('/optirep'));?>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-8">
                        Une liste personnalisable des comptes détaillants et professionnels afin de les garder en mémoire et effectuer un suivi plus rapidement.
                    </div>
                    <div class="clearfix"></div>
                    <p><b>Messages</b></p>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        Un système de messagerie interne pour communiquer avec les actuels et futurs.
                    </div>
                    <div class="clearfix"></div>
                    <p><b>Statistiques</b></p>
                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-8">
                        Une ressource qui regorge de données très utiles sur l’industrie l’optique au Canada présenté de façon dynamique et réparties par province et par ville. (Des frais mensuels supplémentaires s’appliquent)
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-4">
                        <?php  $image = CHtml::image("{$this->themeUrl}/images/Stats.png", 'optirep'); echo CHtml::link($image, array('/optirep'));?>
                    </div>
                    <div class="clearfix"></div>
                    <p><b>Petites Annonces</b></p>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                      Une section permettant aux professionnels de la vue gratuitement des petites annonces pour vendre leur boutique, de l’équipement ou un service, un bon moyen pour les représentants de se tenir informé des changements à venir.
                    </div>
                    <div class="clearfix"></div>
                    <p><b>Divers</b></p>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 last-pag">
                        Une liste de tous les intervenants du monde l’optique tels que les fondations, établissements d’enseignement et bien plus encore.          
                    </div>
                    <div class="clearfix"></div>
                    <h4> <?php echo Myclass::t('OR759', '', 'or') ?> </h4> 
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-4 last-pag">
                        <?php  $image = CHtml::image("{$this->themeUrl}/images/Rep profile French.png", 'optirep'); echo CHtml::link($image, array('/optirep'));?>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-8">
                    <ul>
                        <li>Possibilité de personnaliser le profil avec une photo</li>
                        <li>Changer les informations du profil</li>
                        <li>Ajouter les marques représentées et le territoire couvert</li>
                        <li>Visualiser et surveiller la date d’expiration du compte</li>
                        <li>Renouveler l’abonnement directement dans le compte</li>
                    </ul>
                    </div>
                    <div class="clearfix"></div>
                     <h4> <?php echo Myclass::t('OR760', '', 'or') ?> </h4> 
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 last-pag">
                        <ul>
                            <li>Ouverture d’un compte administrateur gratuit à l’achat de deux comptes représentants ou plus</li>
                            <li>Un prix réduit (prix par compte et par mois)</li>
                            <li>Possibilité de créer, modifier, supprimer des comptes de représentants</li>
                            <li>Suivi des actions de chaque représentant : connexion et profils</li>
                        </ul>
                    </div>
                     <h4> <?php echo Myclass::t('OR761', '', 'or') ?> </h4> 
                     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 last-pag">
                         Opti-Rep.com est un site web interactif qui s’adapte à tous types d’appareils : ordinateur bureau, ordinateur portable, tablettes, téléphone intelligent. Il n’est pas nécessaire d’installer une application pour l’utiliser.
                     </div>
                     <h4> <?php echo Myclass::t('OR762', '', 'or') ?> </h4> 
                     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 last-pag">
                         Options d’abonnement au mois, aux 6 mois ou à l’année. Renouvellement disponible par confirmation et paiement directement dans le compte en ligne. 
                     </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>    
</div>    
</div>    