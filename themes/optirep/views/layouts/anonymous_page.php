<!DOCTYPE html>
<html lang="<?php echo Yii::app()->language; ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title><?php echo Yii::app()->name; ?></title>

        <?php
        $themeUrl = $this->themeUrl;
        $cs = Yii::app()->getClientScript();
        //  $cs->registerCssFile($themeUrl . '/css/bootstrap.min.css');
        ?>
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
          <![endif]-->
        <link href='http://fonts.googleapis.com/css?family=Lato:400,300,700' rel='stylesheet' type='text/css'>
        <?php
        $cs->registerCssFile($themeUrl . '/css/style.css');
        $cs->registerCssFile($themeUrl . '/css/responsive.css');
        $cs->registerCssFile($themeUrl . '/css/font-awesome.css');
        $cs->registerCssFile($themeUrl . '/css/bootstrap-select.min.css');
        $cs->registerCssFile($themeUrl . '/css/custom.css');
        
        $cs->registerCssFile($themeUrl . '/css/bootstrap-switch.min.css');
        $cs->registerCssFile($themeUrl . '/css/pink.css');
        $cs->registerCssFile($themeUrl . '/css/nanoscroller.css');
        ?>
        <?php
        $currentLang = Yii::app()->language;
        if ($currentLang == 'en') {
            $displang = 'Français';
            $changelang = 'fr';
        } else {
            $displang = 'English';
            $changelang = 'en';
        }
        ?>
    </head>
    <body class="<?php echo $currentLang; ?>">
        <?php
            echo CHtml::beginForm('', 'post', array('id' => 'langform'));
            echo CHtml::hiddenField('_lang', $changelang, array());
            echo CHtml::endForm();
        ?>
        <div class="body-cont"> 
            <div class="container"> 
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 flagicons">                 
                    <?php   
                    $frimage = CHtml::image($this->themeUrl . '/images/fr.png', 'Translate to FR');
                    echo CHtml::link($frimage, 'javascript:void(0);', array("id"=>"FR","class"=>"",'onclick' => "document.getElementById('langform').submit();") ); 
                    echo "&nbsp";
                    $enimage = CHtml::image($this->themeUrl . '/images/en1.png', 'Translate to En');
                    echo CHtml::link($enimage, 'javascript:void(0);', array("id"=>"EN","class"=>"",'onclick' => "document.getElementById('langform').submit();")); 
                    ?>                    
                </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ad1"> 
                        <?php
                        $image = CHtml::image("{$this->themeUrl}/images/logo2.png", 'Logo');
                        echo CHtml::link($image, array('/optirep'))
                        ?>
                    </div>
                    <?php if (isset($this->flashMessages)): ?>
                        <?php foreach ($this->flashMessages as $key => $message) { ?>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 flashmessage"> 
                                <div class="alert alert-<?php echo $key; ?> fade in">
                                    <button type="button" class="close close-sm" data-dismiss="alert">
                                        <i class="fa fa-times"></i>
                                    </button>
                                    <?php echo $message; ?>
                                </div>
                            </div>
                        <?php } ?>
                    <?php endif ?>
                    <?php echo $content; ?>
                </div>
            </div>
        </div>

        <?php $this->renderPartial("//layouts/_footer"); ?>

        <?php
        $cs_pos_end = CClientScript::POS_END;
        $cs->registerCoreScript('jquery');

        //  $cs->registerScriptFile($themeUrl . '/js/bootstrap.min.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/bootstrap-select.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/bootstrap-switch.min.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/bootstrap-number-input.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/icheck.min.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/jquery.lionbars.0.3.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/jquery.nanoscroller.min.js', $cs_pos_end);
        ?>

        <?php
        $js = <<< EOD
            $(document).ready(function () {
                $('.selectpicker').selectpicker();
                
                $("[name='my-checkbox']").bootstrapSwitch();
            }); 
EOD;
        Yii::app()->clientScript->registerScript('_authenticate_page', $js);
        ?>
    </body>
</html>