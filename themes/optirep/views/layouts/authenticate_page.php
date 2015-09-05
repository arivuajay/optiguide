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
        $cs->registerCssFile($themeUrl . '/css/bootstrap.min.css');
        ?>
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
          <![endif]-->
        <?php
        $cs->registerCssFile('http://fonts.googleapis.com/css?family=Lato:400,300,700');
        $cs->registerCssFile($themeUrl . '/css/style.css');
        $cs->registerCssFile($themeUrl . '/css/responsive.css');
        $cs->registerCssFile($themeUrl . '/css/font-awesome.css');
        $cs->registerCssFile($themeUrl . '/css/bootstrap-select.min.css');
        $cs->registerCssFile($themeUrl . '/css/bootstrap-switch.min.css');
        $cs->registerCssFile($themeUrl . '/css/pink.css');
        $cs->registerCssFile($themeUrl . '/css/custom.css');
        ?>
    </head>
    <body>
        <?php $this->renderPartial("//layouts/_header"); ?>
        
        <?php echo $content; ?>

        <?php $this->renderPartial("//layouts/_footer"); ?>

        <?php
        $cs_pos_end = CClientScript::POS_END;
        $cs->registerCoreScript('jquery');

        $cs->registerScriptFile($themeUrl . '/js/bootstrap.min.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/bootstrap-select.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/bootstrap-switch.min.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/icheck.min.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/jquery.lionbars.0.3.js', $cs_pos_end);       
        
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