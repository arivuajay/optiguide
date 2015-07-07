<?php
/* @var $this UsersController */
/* @var $model Users */

//$this->breadcrumbs=array(
//	'Users'=>array('index'),
//	'Register',
//);
//
//$this->menu=array(
//	array('label'=>'List Users', 'url'=>array('index')),
//	array('label'=>'Manage Users', 'url'=>array('admin')),
//);
?>

<!--<h1>Register Users</h1>-->



<?php
$baseUrl = Yii::app()->baseUrl;
$themeUrl = Yii::app()->theme->baseUrl;
?>

<body class="minimal login-page">
    <script> var boxtest = localStorage.getItem('boxed');
    if (boxtest === 'true') {
        document.body.className += ' boxed-layout';
    }</script>
    <a href="<?php echo Yii::app()->baseUrl?>" id="return-arrow"> <i class="fa fa-arrow-circle-left fa-3x text-light"></i> <span class="text-light"> Return <br>
            to Website </span> </a>

    <!-- Start: Main -->
   <?php $this->renderPartial('_form', array('model'=>$model)); ?>
    <!-- End: Main -->

    <div class="overlay-black"></div>

    <script type="text/javascript">
        $(document).ready(function () {
            "use strict";

            // Init Theme Core
//            Core.init();

            // Enable Ajax Loading
            Ajax.init();

            // Init Full Page BG(Backstretch) plugin
            $.backstretch("<?php echo $themeUrl; ?>/css/frontend/img/stock/splash/2.jpg");



        });
    </script>
</body>