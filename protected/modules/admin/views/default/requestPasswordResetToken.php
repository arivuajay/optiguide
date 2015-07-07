<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

$this->title = 'Reset Password';
$this->breadcrumbs[] = $this->title;
?>

<div class="form-box" id="login-box">
    <div class="header"><?= Html::encode($this->title) ?></div>
    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
    <div class="body bg-gray">
        <?= $form->field($model, 'email') ?>
    </div>
    <div class="footer">
        <?= Html::submitButton('Send', ['class' => 'btn bg-olive btn-block']) ?>
        <p><?= Html::a('Back to login', ['site/login']) ?></p>
    </div>
    <?php ActiveForm::end(); ?>
</div>







