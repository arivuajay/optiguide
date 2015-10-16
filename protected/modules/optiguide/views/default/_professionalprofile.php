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
                                    <td><?php echo $messageinfos->professionalDirectory->NOM; ?></td>   
                                </tr>   
                                
                                 <tr>                                        
                                    <td><strong>Prenom</strong></td>   
                                    <td><?php echo $messageinfos->professionalDirectory->PRENOM; ?></td>   
                                </tr>   

                                <tr>                                        
                                    <td><strong>Adresse</strong></td>   
                                    <td><?php echo $messageinfos->professionalDirectory->ADRESSE; ?></td>  
                                </tr> 

                                <?php if ($messageinfos->professionalDirectory->BUREAU != '') {
                                    ?>                                      
                                    <tr>                                        
                                        <td><strong>Numéro de local/bureau</strong></td>   
                                        <td><?php echo $messageinfos->professionalDirectory->BUREAU; ?></td>  
                                    </tr> 
                                <?php }
                                ?>   

                                <tr>                                        
                                    <td><strong>Ville</strong></td>   
                                    <td><?php echo $messageinfos->professionalDirectory->ID_VILLE; ?></td>  
                                </tr> 

                                <tr>                                        
                                    <td><strong>Province</strong></td>   
                                    <td><?php //echo $messageinfos->professionalDirectory->region; ?></td>  
                                </tr> 

                                <tr>                                        
                                    <td><strong>Pays</strong></td>   
                                    <td><?php //echo $messageinfos->professionalDirectory->country; ?></td>  
                                </tr> 

                                <?php if ($messageinfos->professionalDirectory->TELEPHONE != '') {
                                    ?>   
                                    <tr>                                        
                                        <td><strong>Téléphone</strong></td>   
                                        <td><?php echo $messageinfos->professionalDirectory->TELEPHONE; ?></td>  
                                    </tr> 
                                <?php }
                                ?>

                                <?php if ($messageinfos->professionalDirectory->TELEPHONE2 != '') {
                                    ?>  
                                    <tr>                                        
                                        <td><strong>Téléphone 2</strong></td>   
                                        <td><?php echo $messageinfos->professionalDirectory->TELEPHONE2; ?></td>  
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


                                <?php if ($messageinfos->clientProfiles->CODE_POSTAL != '') {
                                    ?>  
                                    <tr>                                        
                                        <td><strong>Pincode</strong></td>   
                                        <td><?php echo $messageinfos->clientProfiles->CODE_POSTAL; ?></td>  
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
                                    
                                    $exp_disp = implode(',',$disptxt);                                    
                                ?>  
                                    <tr>                                        
                                        <td><strong>Abonnement</strong></td>   
                                        <td><?php echo $exp_disp; ?></td>  
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