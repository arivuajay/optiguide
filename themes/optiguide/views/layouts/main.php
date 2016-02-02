<!DOCTYPE html>
<html lang="<?php echo Yii::app()->language; ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title><?php echo Yii::app()->name; ?></title>

        <!-- Bootstrap -->
        <?php
        $themeUrl = $this->themeUrl;
        $cs = Yii::app()->getClientScript();
        $cs->registerCssFile($themeUrl . '/css/bootstrap.min.css');
        ?>

        <link href='http://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700' rel='stylesheet' type='text/css'>
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
          <![endif]-->

        <?php
        $cs->registerCssFile($themeUrl . '/css/blue.css');
        $cs->registerCssFile($themeUrl . '/css/font-awesome.css');
        $cs->registerCssFile($themeUrl . '/css/style.css');
        $cs->registerCssFile($themeUrl . '/css/responsive.css');
        $cs->registerCssFile($themeUrl . '/css/nanoscroller.css');
        $cs->registerCssFile($themeUrl . '/css/custom.css');
        ?>
    </head>
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
    <body class="<?php echo Yii::app()->language; ?>">
        <?php $this->renderPartial('//layouts/_header',array('displang'=>$displang)); ?>
         <?php
            echo CHtml::beginForm('', 'post', array('id' => 'langform'));
            echo CHtml::hiddenField('_lang', $changelang, array());
            echo CHtml::endForm();
        ?>
        <div class="body-cont"> 
            <div class="container">
                <div class="row"> 
                    <?php $this->renderPartial('//layouts/_submenu'); ?>

                    <?php echo $content; ?>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
                        <div class="center-ad"> 
                            <!--  Supper Banner (Bottom) - position - 2 -->
                            <?php echo Myclass::banner_display(2);?>
                        </div>  
                    </div>
                </div>
            </div>
        </div>

        <?php $this->renderPartial('//layouts/_footer',array('displang'=>$displang)); ?>

        <?php
        $cs_pos_end = CClientScript::POS_END;

        $cs->registerCoreScript('jquery');

        $cs->registerScriptFile($themeUrl . '/js/bootstrap.min.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/bootstrap-select.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/maps.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/icheck.min.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/jquery.lionbars.0.3.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/jquery.nanoscroller.min.js', $cs_pos_end);
        ?>

        <?php
        $adsclick_update = Yii::app()->createUrl('/optiguide/default/updateadsclick');
        $js = <<< EOD
        $(document).ready(function() {
                $(window).orion({speed: 500});
                $('.indicator').click(function(e) {
                    $(this).parent('li').children('ul:not(.fading)').slideToggle();
                    e.preventDefault();
                });

                $('.selectpicker').selectpicker({
                });

                $('input:checkbox:not(.simple),input:radio').iCheck({
                    checkboxClass: 'icheckbox_flat-blue',
                    radioClass: 'iradio_flat-blue'
                });
                $('.box').lionbars();
                
                
                $('a.adsclick').click(function() 
                { 
                    var adsID   = $(this).attr('id');
                    var adsLINK = $(this).attr('href');
                    var dataString = 'id='+ adsID;
                    $.ajax({
                        type  : "POST",
                        url   : '{$adsclick_update}',
                        data  : dataString,
                        cache : false,
                        success: function(html){             
                            return true;
                        }
                     });
               });
                
            });  
                        
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){ (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o), m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m) })(window,document,'script','//www.google-analytics.com/analytics.js','ga'); ga('create', 'UA-55811455-2', 'auto'); ga('send', 'pageview');
EOD;
        Yii::app()->clientScript->registerScript('_main', $js);
        ?>    
    </body>
  
</html>
