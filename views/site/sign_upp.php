<?php
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

<div class="signup-container, text-center">
    <?= Html::a('<i class="fab fa-dev fa-2x mb-3" style="color: black;"></i>',['site/index'])?>
    <h2><strong><?= Html::encode($this->title) ?></strong></h2>
    <p class="text-muted">DEV Community is a community of 3,000,045 amazing developers</p>

    <?= Html::a('<i class="fab fa-apple"></i> Sign up with Apple', ['site/auth', 'provider' => 'apple'], ['class' => 'btn-white']) ?>
    <?= Html::a('<i class="fab fa-facebook"></i> Sign up with Facebook', ['site/auth', 'provider' => 'facebook'], ['class' => 'btn-white']) ?>
    <?= Html::a('<i class="fas fa-leaf"></i> Sign up with Forem', ['site/auth', 'provider' => 'forem'], ['class' => 'btn-white']) ?>
    <?= Html::a('<i class="fab fa-github"></i> Sign up with GitHub', ['site/auth', 'provider' => 'github'], ['class' => 'btn-white']) ?>
    <?= Html::a('<i class="fab fa-google"></i> Sign up with Google', ['site/auth', 'provider' => 'google'], ['class' => 'btn-white']) ?>
    <?= Html::a('<i class="fab fa-x-twitter"></i> Sign up with Twitter (X)', ['site/auth', 'provider' => 'twitter'], ['class' => 'btn-white']) ?>
    <?= Html::a('<i class="fas fa-envelope"></i> Sign up with Email', ['site/saveuser'], ['class' => 'btn-white']) ?>

    <div class="small-text">
        By signing up, you are agreeing to our
        <?= Html::a('privacy policy', ['site/privacy']) ?>,
        <?= Html::a('terms of use', ['site/terms']) ?>, and
        <?= Html::a('code of conduct', ['site/conduct']) ?>.
    </div>

    <p class="small-text mt-3">Already have an account? <?= Html::a('Log in.', ['site/login2']) ?></p>
</div>