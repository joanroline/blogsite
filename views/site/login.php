<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$this->title = 'Join the DEV Community';
$this->registerCss("
    body {
        background-color: white;
        text-align: center; /* Center the content */
        padding: 60px 20px; /* Add padding for mobile responsiveness */
    }
    .signup-container {
        max-width: 420px;
        margin: 0 auto; /* Center the container */
    }
    .btn-white {
        background-color: white;
        border: 1px solid #ccc;
        color: #333;
        font-weight: 500;
        padding: 10px 20px;
        border-radius: 8px;
        width: 100%;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: all 0.2s ease-in-out;
    }
    .btn-white:hover {
        background-color: #f9f9f9;
        border-color: #999;
    }
    .btn-white i {
        font-size: 1.2em;
    }
    .small-text {
        font-size: 0.9em;
        color: #666;
        margin-top: 20px;
    }
");
?>

<div class="signup-container text-center">
    <?= Html::a('<i class="fab fa-dev fa-2x mb-3" style="color: black;"></i>',['site/index'])?>
    <h2><strong><?= Html::encode($this->title) ?></strong></h2>
    <p class="text-muted">DEV Community is a community of 3,000,045 amazing developers</p>

    <?= Html::a('<i class="fab fa-apple"></i> Continue with Apple', ['site/auth', 'provider' => 'apple'], ['class' => 'btn-white']) ?>
    <?= Html::a('<i class="fab fa-facebook"></i> Continue with Facebook', ['site/auth', 'provider' => 'facebook'], ['class' => 'btn-white']) ?>
    <?= Html::a('<i class="fas fa-leaf"></i> Continue with Forem', ['site/auth', 'provider' => 'forem'], ['class' => 'btn-white']) ?>
    <?= Html::a('<i class="fab fa-github"></i> Continue with GitHub', ['site/auth', 'provider' => 'github'], ['class' => 'btn-white']) ?>
    <?= Html::a('<i class="fab fa-google"></i> Continue with Google', ['site/auth', 'provider' => 'google'], ['class' => 'btn-white']) ?>
    <?= Html::a('<i class="fab fa-x-twitter"></i> Continue with Twitter (X)', ['site/auth', 'provider' => 'twitter'], ['class' => 'btn-white']) ?>

    <p style="text-align:center">OR</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'enableClientValidation' => true,
    ]); ?>

    <?= $form->field($model, 'username')->textInput([
        'autofocus' => true,
        'placeholder' => 'username',
    ])->label('<i class="fa fa-envelope"></i> Username') ?>

    <?= $form->field($model, 'password')->passwordInput([
        'placeholder' => 'Enter your password',
    ])->label('<i class="fa fa-lock"></i> Password') ?>

    <?= $form->field($model, 'rememberMe')->checkbox() ?>

    <div class="d-flex justify-content-between align-items-center mb-3">
        
        <div><?= Html::a('Forgot Password?', ['site/request-password-reset'], ['class' => 'text-decoration-none']) ?></div>
    </div>

    <div class="form-group text-center">
        <?= Html::submitButton('Login', ['class' => 'btn btn-primary w-100', 'name' => 'login-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <div class="small-text">
        By signing up, you are agreeing to our
        <?= Html::a('privacy policy', ['site/privacy']) ?>,
        <?= Html::a('terms of use', ['site/terms']) ?>, and
        <?= Html::a('code of conduct', ['site/conduct']) ?>.
    </div>
    <p class="small-text mt-3">New to Dev Community? <?= Html::a('Create account', ['site/saveuser']) ?></p>

</div>