<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 subscribe-btncont"> 
        <div class="inner-container"> 
            <h2> Client Profile </h2>           

            <div class="forms-cont"> 
                <div class="forms-heading"><i class="fa fa-user"></i> <?php echo $messageinfos->clientProfiles->name; ?> infos</div>
                <div class="row"> 
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <table class="table table-bordered" id="bckrnd"> 

                            <?php
                            if (!empty($messageinfos)) {
                                ?>
                                <tr>                                        
                                    <td><strong>Nom</strong></td>   
                                    <td><?php echo $messageinfos->clientProfiles->name; ?></td>   
                                </tr>    

                                <?php if ($messageinfos->clientProfiles->company != '') {
                                    ?> 
                                    <tr>                                        
                                        <td><strong>Entreprise</strong></td>   
                                        <td><?php echo $messageinfos->clientProfiles->company; ?></td>  
                                    </tr>  
                                <?php }
                                ?>  


                                <?php if ($messageinfos->clientProfiles->job_title != '') {
                                    ?> 
                                    <tr>                                        
                                        <td><strong>Fonction</strong></td>   
                                        <td><?php echo $messageinfos->clientProfiles->job_title; ?></td>  
                                    </tr>                                     
                                <?php }
                                ?> 

                                <tr>                                        
                                    <td><strong>Type</strong></td>   
                                    <td><?php echo ($messageinfos->clientProfiles->member_type == "free_member") ? "Abonné libre" : "Annonceur"; ?></td>  
                                </tr> 

                                <tr>                                        
                                    <td><strong>Catégorie Type</strong></td>   
                                    <td><?php echo $messageinfos->clientProfiles->ctype; ?></td>  
                                </tr>                                 

                                <tr>                                        
                                    <td><strong>Catégorie Nom</strong></td>   
                                    <td><?php echo $messageinfos->clientProfiles->cname; ?></td>  
                                </tr> 

                                <tr>                                        
                                    <td><strong>Adresse</strong></td>   
                                    <td><?php echo $messageinfos->clientProfiles->address; ?></td>  
                                </tr> 

                                <?php if ($messageinfos->clientProfiles->local_number != '') {
                                    ?>                                      
                                    <tr>                                        
                                        <td><strong>Numéro de local/bureau</strong></td>   
                                        <td><?php echo $messageinfos->clientProfiles->local_number; ?></td>  
                                    </tr> 
                                <?php }
                                ?>   

                                <tr>                                        
                                    <td><strong>Ville</strong></td>   
                                    <td><?php echo $messageinfos->clientProfiles->ville; ?></td>  
                                </tr> 

                                <tr>                                        
                                    <td><strong>Province</strong></td>   
                                    <td><?php echo $messageinfos->clientProfiles->region; ?></td>  
                                </tr> 

                                <tr>                                        
                                    <td><strong>Pays</strong></td>   
                                    <td><?php echo $messageinfos->clientProfiles->country; ?></td>  
                                </tr> 

                                <?php if ($messageinfos->clientProfiles->phonenumber1 != '') {
                                    ?>   
                                    <tr>                                        
                                        <td><strong>Téléphone</strong></td>   
                                        <td><?php echo $messageinfos->clientProfiles->phonenumber1; ?></td>  
                                    </tr> 
                                <?php }
                                ?>

                                <?php if ($messageinfos->clientProfiles->phonenumber2 != '') {
                                    ?>  
                                    <tr>                                        
                                        <td><strong>Téléphone 2</strong></td>   
                                        <td><?php echo $messageinfos->clientProfiles->phonenumber2; ?></td>  
                                    </tr> 
                                <?php }
                                ?>

                                <?php if ($messageinfos->clientProfiles->mobile_number != '') {
                                    ?>  
                                    <tr>                                        
                                        <td><strong>Cellulaire</strong></td>   
                                        <td><?php echo $messageinfos->clientProfiles->mobile_number; ?></td>  
                                    </tr> 
                                <?php }
                                ?>


                                <?php if ($messageinfos->clientProfiles->tollfree_number != '') {
                                    ?>  
                                    <tr>                                        
                                        <td><strong>Sans frais</strong></td>   
                                        <td><?php echo $messageinfos->clientProfiles->tollfree_number; ?></td>  
                                    </tr> 
                                <?php }
                                ?>

                                <?php if ($messageinfos->clientProfiles->fax != '') {
                                    ?>  
                                    <tr>                                        
                                        <td><strong>Fax</strong></td>   
                                        <td><?php echo $messageinfos->clientProfiles->fax; ?></td>  
                                    </tr> 
                                <?php }
                                ?>

                                <?php if ($messageinfos->clientProfiles->email != '') {
                                    ?>  
                                    <tr>                                        
                                        <td><strong>Courriel</strong></td>   
                                        <td><?php echo $messageinfos->clientProfiles->email; ?></td>  
                                    </tr> 
                                <?php }
                                ?>

                                <?php if ($messageinfos->clientProfiles->site_address != '') {
                                    ?>  
                                    <tr>                                        
                                        <td><strong>Website</strong></td>   
                                        <td><?php echo $messageinfos->clientProfiles->site_address; ?></td>  
                                    </tr> 
                                <?php }
                                ?>
                                    
                                <?php if ($messageinfos->clientProfiles->Optipromo != '0' || $messageinfos->clientProfiles->Optinews != '0' ||
                                         $messageinfos->clientProfiles->Envision_print != '0' || $messageinfos->clientProfiles->Envision_digital != '0' ||
                                        $messageinfos->clientProfiles->Envue_print != '0' || $messageinfos->clientProfiles->Envue_digital != '0') {
                                    
                                    $disptxt = array();
                                    if($messageinfos->clientProfiles->Optipromo==1){
                                        $disptxt[] = "Opti promo";
                                    }
                                    if($messageinfos->clientProfiles->Optinews==1){
                                        $disptxt[] = "Opti news";
                                    }
                                    if($messageinfos->clientProfiles->Envision_print==1){                                        
                                        $disptxt[] = "Envision print";
                                    }
                                    if($messageinfos->clientProfiles->Envision_digital==1){                                        
                                        $disptxt[] = "Envision digital";
                                    }
                                    if($messageinfos->clientProfiles->Envue_print==1){                                        
                                        $disptxt[] = "Envue print";
                                    }
                                    if($messageinfos->clientProfiles->Envue_digital==1){
                                        $disptxt[] = "Envue digital";
                                    }    
                                                                   
                                ?>  
                                    <tr>                                        
                                        <td><strong>Abonnement</strong></td>   
                                        <td><?php
                                        $k=1;
                                        foreach($disptxt as $info)
                                        {    
                                            echo $k.") ".$info."<br>";
                                            $k++;
                                        }    ?></td>  
                                    </tr> 
                                <?php }
                                ?>
                                    

                                <?php
                            }
                            ?>                  
                        </table>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>