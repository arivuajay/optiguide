<?php
$this->title = "Retailer Profile Infos";
$this->breadcrumbs[] = $this->title;
?>
<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 subscribe-btncont"> 
        <div class="inner-container"> 
            <h2> <?php echo $messageinfos->retailerDirectory->COMPAGNIE; ?></h2>           

            <div class="forms-cont">                 
                <div class="row"> 
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <table class="table table-bordered" id="bckrnd"> 

                            <?php
                            if (!empty($messageinfos)) {

                                $cityinfo = CityDirectory::model()->findByPk($messageinfos->retailerDirectory->ID_VILLE);
                                $regionid = $cityinfo->ID_REGION;
                                $citynme = $cityinfo->NOM_VILLE;

                                $regioninfo = RegionDirectory::model()->findByPk($regionid);
                                $countryid = $regioninfo->ID_PAYS;
                                $regionnme = $regioninfo->NOM_REGION_EN;

                                $countryname = CountryDirectory::model()->findByPk($countryid)->NOM_PAYS_EN;
                                ?>
                                <tr>                                        
                                    <td><strong>Store name</strong></td>   
                                    <td><?php echo $messageinfos->retailerDirectory->COMPAGNIE; ?></td>   
                                </tr>   

                                <tr>
                                    <td><strong>Type</strong></td>   
                                    <td><?php echo RetailerType::model()->findByPk($messageinfos->retailerDirectory->ID_RETAILER_TYPE)->NOM_TYPE_EN; ?></td>   
                                </tr>

                                <tr>
                                    <td><strong>Grouping </strong></td>   
                                    <td><?php echo RetailerGroup::model()->find("ID_GROUPE=".$messageinfos->retailerDirectory->ID_GROUPE)->NOM_GROUPE;   ?></td>   
                                </tr>

                                <?php if ($messageinfos->retailerDirectory->HEAD_OFFICE_NAME != '') {
                                    ?>                                      
                                    <tr>                                        
                                        <td><strong>Head Office</strong></td>   
                                        <td><?php echo $messageinfos->retailerDirectory->HEAD_OFFICE_NAME; ?></td>  
                                    </tr> 
                                <?php }
                                ?>  

                                <tr>                                        
                                    <td><strong>Establishment's primary profession or activity</strong></td>   
                                    <td><?php
                                            $cat = array();
                                            $cat[] = $messageinfos->retailerDirectory->CATEGORY_1;
                                            $cat[] = $messageinfos->retailerDirectory->CATEGORY_2;
                                            $cat[] = $messageinfos->retailerDirectory->CATEGORY_3;
                                            $cat[] = $messageinfos->retailerDirectory->CATEGORY_4;
                                            $cat[] = $messageinfos->retailerDirectory->CATEGORY_5;
                                            $categories = array("0" => Myclass::t('OG105'), "1" => Myclass::t('OG106'), "2" => Myclass::t('OG107'), "3" => Myclass::t('OG108'), "4" => Myclass::t('OG109'));
                                           
                                            $str = '';
                                            foreach ($cat as $key => $info) {
                                                if ($info == 1) {
                                                    $str[] = $categories[$key];
                                                }
                                            }
                                            if (!empty($str)) {
                                                echo implode(',', $str);
                                            }
                                            ?>
                                    </td>  
                                </tr>   


                                <tr>                                        
                                    <td><strong>Adresse</strong></td>   
                                    <td><?php echo $messageinfos->retailerDirectory->ADRESSE; ?></td>  
                                </tr> 

                                <tr>                                        
                                    <td><strong>Ville</strong></td>   
                                    <td><?php echo $citynme; ?></td>  
                                </tr> 

                                <tr>                                        
                                    <td><strong>Province</strong></td>   
                                    <td><?php echo $regionnme; ?></td>  
                                </tr> 

                                <tr>                                        
                                    <td><strong>Pays</strong></td>   
                                    <td><?php echo $countryname; ?></td>  
                                </tr> 

                                <?php if ($messageinfos->retailerDirectory->CODE_POSTAL != '') {
                                    ?>  
                                    <tr>                                        
                                        <td><strong>Pincode</strong></td>   
                                        <td><?php echo $messageinfos->retailerDirectory->CODE_POSTAL; ?></td>  
                                    </tr> 
                                <?php }
                                ?>

                                <?php if ($messageinfos->retailerDirectory->TELEPHONE != '') {
                                    ?>   
                                    <tr>                                        
                                        <td><strong>Téléphone</strong></td>   
                                        <td><?php echo $messageinfos->retailerDirectory->TELEPHONE; ?></td>  
                                    </tr> 
                                <?php }
                                ?>

                                <?php if ($messageinfos->retailerDirectory->TELEPHONE2 != '') {
                                    ?>  
                                    <tr>                                        
                                        <td><strong>Téléphone 2</strong></td>   
                                        <td><?php echo $messageinfos->retailerDirectory->TELEPHONE2; ?></td>  
                                    </tr> 
                                <?php }
                                ?>

                                <?php if ($messageinfos->retailerDirectory->TELECOPIEUR != '') {
                                    ?>  
                                    <tr>                                        
                                        <td><strong>Fax</strong></td>   
                                        <td><?php echo $messageinfos->retailerDirectory->TELECOPIEUR; ?></td>  
                                    </tr> 
                                <?php }
                                ?>

                                <?php if ($messageinfos->retailerDirectory->URL != '') {
                                    ?>  
                                    <tr>                                        
                                        <td><strong>Store Web site</strong></td>   
                                        <td><?php echo $messageinfos->retailerDirectory->URL; ?></td>  
                                    </tr> 
                                <?php }
                                ?>

                                <?php if ($messageinfos->retailerDirectory->COURRIEL != '') {
                                    ?>  
                                    <tr>                                        
                                        <td><strong>Courriel</strong></td>   
                                        <td><?php echo $messageinfos->retailerDirectory->COURRIEL; ?></td>  
                                    </tr> 
                                <?php }
                                ?>

                                <?php if ($messageinfos->retailerDirectory->established != '') {
                                    ?>  
                                    <tr>                                        
                                        <td><strong>Established since</strong></td>   
                                        <td><?php echo $messageinfos->retailerDirectory->established; ?></td>  
                                    </tr> 
                                <?php }
                                ?>


                                <?php if ($messageinfos->retailerDirectory->no_of_employee != '') {
                                    ?>  
                                    <tr>                                        
                                        <td><strong>Number of employees</strong></td>   
                                        <td><?php echo $messageinfos->retailerDirectory->no_of_employee; ?></td>  
                                    </tr> 
                                <?php }
                                ?>

                                <?php if ($messageinfos->retailerDirectory->services_offered != '') {
                                    ?>  
                                    <tr>                                        
                                        <td><strong>Services offered</strong></td>   
                                        <td><?php echo $messageinfos->retailerDirectory->services_offered; ?></td>  
                                    </tr> 
                                <?php }
                                ?>

                                <?php if ($messageinfos->retailerDirectory->description != '') {
                                    ?>  
                                    <tr>                                        
                                        <td><strong>Description</strong></td>   
                                        <td><?php echo $messageinfos->retailerDirectory->description; ?></td>  
                                    </tr> 
                                <?php }
                                ?>

                                <?php if ($messageinfos->retailerDirectory->turnover != '') {
                                    ?>  
                                    <tr>                                        
                                        <td><strong>TurnOver (in $)</strong></td>   
                                        <td><?php echo $messageinfos->retailerDirectory->turnover; ?></td>  
                                    </tr> 
                                <?php }
                                ?>

                                <?php if ($messageinfos->retailerDirectory->contact_person != '') {
                                    ?>  
                                    <tr>                                        
                                        <td><strong>Contact person</strong></td>   
                                        <td><?php echo $messageinfos->retailerDirectory->contact_person; ?></td>  
                                    </tr> 
                                <?php }
                                ?>

                                <?php if ($messageinfos->retailerDirectory->classification != '') {
                                    ?>  
                                    <tr>                                        
                                        <td><strong>Classification of goods</strong></td>   
                                        <td><?php echo $messageinfos->retailerDirectory->classification; ?></td>  
                                    </tr> 
                                <?php }
                                ?>


                                <?php
                                $retid = $messageinfos->retailerDirectory->ID_RETAILER;
                                $uinfos = UserDirectory::model()->find("ID_RELATION=$retid AND NOM_TABLE='Detaillants' and status=1");

                                if ($uinfos->ABONNE_MAILING != '0' || $uinfos->ABONNE_PROMOTION != '0' ||
                                        $uinfos->bSubscription_envision != '0' || $uinfos->bSubscription_envue != '0' ||
                                        $uinfos->print_envision != '0' || $uinfos->print_envue != '0') {

                                    $disptxt = array();

                                    if ($uinfos->ABONNE_MAILING == 1) {
                                        $disptxt[] = "OPTI-NEWS by e-mail";
                                    }

                                    if ($uinfos->ABONNE_PROMOTION == 1) {
                                        $disptxt[] = "OPTI-PROMOS by e-mail";
                                    }

                                    if ($uinfos->bSubscription_envision == 1) {
                                        $disptxt[] = "Free English digital magazine ENVISION";
                                    }

                                    if ($uinfos->bSubscription_envue == 1) {
                                        $disptxt[] = "Free French digital magazine ENVUE";
                                    }

                                    if ($uinfos->print_envision == 1) {
                                        $disptxt[] = "Envue Print Edition";
                                    }

                                    if ($uinfos->print_envue == 1) {
                                        $disptxt[] = "Envision Print Edition";
                                    }
                                    ?>  
                                    <tr>                                        
                                        <td><strong>Abonnement</strong></td>   
                                        <td><?php
                                            $k = 1;
                                            foreach ($disptxt as $info) {
                                                echo $k . ") " . $info . "<br>";
                                                $k++;
                                            }
                                            ?></td>  
                                    </tr> 
                                    <?php
                                }
                                ?>

                            <?php }
                            ?>                  
                        </table>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>