<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Opti-Guide</title>

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
        ?>
    </head>
    <body>
        <?php $this->renderPartial('//layouts/_header'); ?>

        <div class="body-cont"> 
            <div class="container">
                <div class="row"> 

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 submenu-cont">  
                        <nav class="navbar navbar-default submenu">
                            <div class="container-fluid">
                                <!-- Brand and toggle get grouped for better mobile display -->
                                <div class="navbar-header">
                                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                        <span class="sr-only">Toggle navigation</span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                    <a class="navbar-brand" href="#">Submenu</a>
                                </div>

                                <!-- Collect the nav links, forms, and other content for toggling -->
                                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                    <ul class="nav navbar-nav">
                                        <li><a href="#"> Suppliers   </a></li>        
                                        <li><a href="#"> Category  </a></li>          
                                        <li><a href="#"> Brands      </a></li>     
                                        <li><a href="#">  News     </a></li>        
                                        <li><a href="#"> Calendar  </a></li>          
                                        <li><a href="#">  Miscellaneous </a></li>
                                    </ul>
                                </div><!-- /.navbar-collapse -->
                            </div><!-- /.container-fluid -->
                        </nav>
                    </div>

                    <?php echo $content; ?>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
                        <div class="center-ad"> 
                            <a href="#">
                                <?php echo CHtml::image("{$this->themeUrl}/images/center-ad.jpg", 'Logo') ?>
                            </a>
                        </div>  
                    </div>

                </div>
            </div>
        </div>

        <?php $this->renderPartial('//layouts/_footer'); ?>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <?php
        $cs_pos_end = CClientScript::POS_END;
        $cs->registerScriptFile($themeUrl . '/js/bootstrap.min.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/bootstrap-select.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/maps.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/icheck.min.js', $cs_pos_end);
        ?>

        <?php
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
            });
EOD;
        Yii::app()->clientScript->registerScript('_main', $js);
        ?>
    </body>
</html>
