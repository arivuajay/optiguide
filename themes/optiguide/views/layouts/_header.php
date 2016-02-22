<?php
$profileurl = '';
$popupimg = "popup_alert_EN.jpg";
$lang = Yii::app()->session['language'];   
if (!Yii::app()->user->isGuest) {
    
    $popupimg  = "popup_alert_".$lang.".jpg";
    $popupdisp = "false";
    if(Yii::app()->user->role!="Client")
    {
    
        $mustvalidate = UserDirectory::model()->findByPk(Yii::app()->user->id)->MUST_VALIDATE;
        if($mustvalidate==0)
        {
            $popupdisp = "true";
        }else {
            $popupdisp = "false";
        }
    }    

    if (Yii::app()->user->role == "Professionnels") {
        
        $profileurl = '/optiguide/professionalDirectory/update';
        
    } else if (Yii::app()->user->role == "Detaillants") {
   
        $profileurl = '/optiguide/retailerDirectory/update';
    } else if (Yii::app()->user->role == "Fournisseurs") {
        
        $profileurl = '/optiguide/suppliersDirectory/update';
    }
}

if($lang=="FR"){
    $popupstr = "Merci d’entrer un critère de recherche";
    $placehold_str = "Recherche";
}else{
    $popupstr = 'Please give search value.';
    $placehold_str = "Search";
}
?>

<!-- Popup Modal for alert notification -->
<div id="myModal" data-return="<?php echo $popupdisp;?>" class="modal fade bs-example-modal-sm homepage-popup" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <img src="<?php echo Yii::app()->createAbsoluteUrl("/uploads/archivage/".$popupimg);?>">          
    </div>    
  </div>
</div>

<div class="header"> 
    <div class="header-row1"> 
        <div class="container"> 

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4">
                 <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'search-form',
                        'htmlOptions' => array('role' => 'form'),  
                        'method'=>'get',
                        'action' => $this->createUrl('/optiguide/search/index'),                        
                        )
                    );
                    $searchval = isset($_GET['searchval'])?$_GET['searchval']:'';
                    ?>
                <div class="search-bg4" id="search">
                    <input type="text" id="search_val" class="search-field4" placeholder="<?php echo $placehold_str;?>" value="<?php echo $searchval;?>" name="searchval">
                    <button id="search_submit" class="search-btn4" type="button"> <i class="fa fa-search"></i></button>
                </div> 
                 <?php $this->endWidget(); ?>
            </div>


            <div class="col-xs-12 col-sm-6 col-md-9 col-lg-8">  <ul class="orion-menu red">
                    <li>
                        <?php echo CHtml::link(Myclass::t('OG001', '', 'og'), array('/optiguide/')); ?>
                    </li>  
                    <li>
                        <?php echo CHtml::link(Myclass::t('OG002', '', 'og'), array('/optiguide/default/advertise')); ?>
                    </li>                
                    <li>
                        <?php
                        if (Yii::app()->user->isGuest) {
                            echo CHtml::link(Myclass::t('OG003', '', 'og'), array('/optiguide/default/subscribe'));
                        } else {
                            echo CHtml::link(Myclass::t('OG033', '', 'og'), array($profileurl));
                        }
                        ?>
                    </li> 
                    <li>
                        <?php echo CHtml::link(Myclass::t('OG004', '', 'og'), array('/optiguide/default/contactus')); ?>
                    </li>     
                    <li>
                        <?php echo CHtml::link($displang, 'javascript:void(0);', array('onclick' => "document.getElementById('langform').submit();")); ?>
                    </li> 
                    <li>
                        <?php
                        if (!Yii::app()->user->isGuest)
                            echo CHtml::link('<i class="fa fa-sign-out"></i> ' . Myclass::t('OG025', '', 'og'), array('/optiguide/default/logout'), array('class' => 'loginbg'));
                        ?>
                    </li> 
                </ul></div>


        </div>
    </div>  

    <div class="header-row2">
        <div class="container"> 
            <div class="row">  
                <div class="col-xs-12 col-sm-3 col-md-3  col-lg-3 logo"> 
                    <?php echo CHtml::link(CHtml::image("{$this->themeUrl}/images/logo.jpg", 'Logo'), array('/optiguide/default')); ?>
                </div>                
                <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 ad1"> 
                    <!--  Supper Banner (Top) - position 1 -->
                    <?php echo Myclass::banner_display(1); ?>
                </div>
            </div>
        </div>
    </div>
    
</div>
<?php
Yii::app()->clientScript->registerScript('search', "
    $('#search_submit').click(function(e){      
    
       var searchval = $('#search_val').val();        
       var popupalert_val = '{$popupstr}';
       
       if(searchval=='')
       {
         alert(popupalert_val);
         return false;
       }
       
       $('#search-form').submit();       
       
    });
    
    $('#search input[name=\'searchval\']').on('keydown', function(e) {  
        if (e.keyCode == 13) {   
             $('#search_submit').trigger('click');
             return false;
        }
    });
    
    $('#myModal').modal({
       show : $('#myModal').data('return'),
       backdrop: 'static',
       keyboard: false
    });
");
?>