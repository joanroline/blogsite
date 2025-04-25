<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;


?>

<!--<div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center bg-light ">-->
<div class="row shadow-lg rounded-4 overflow-hidden justify-content-center mx-auto" style="max-width: 900px; width: 100%">


    <!-- Left Panel: Illustration & Text -->
    <div class="col-md-6 d-none d-md-flex flex-column justify-content-center align-items-center p-5 text-center" style="background-color: #c8e6d2;">

        <!-- <img src="<? //= Yii::getAlias('@web') 
                        ?>/images/storyteller.avif" class="img-fluid mb-4" style="max-height: 300px;">-->
        <?= Html::img('@web/web/images/storyteller.avif') ?>

        <!-- <img src="@web/web/uploads/login.jpg" class="img-fluid mb-4" style="max-height: 300px;"alt="Log in">-->

    </div>

    <!-- Right Panel: Login Form -->
    <div class="col-md-6 p-5 d-flex flex-column justify-content-center" style="background-color: #c8e6d2;">
        <?= Html::a('<i class="fab fa-dev fa-2x mb-3" style="color: black; "></i>', ['site/index']) ?>
        <h3 class=" mb-3 fw-bold" style="font-family: 'Cursive';">Join the dev Community</h3>
        <p class="mb-4">Its a new day, share your dev journey with us</p>

        <?php $form = ActiveForm::begin(); ?>

        <?= Html::a('<i class="fab fa-apple me-2"></i>Sign up with Apple', ['site/index', 'provider' => 'apple'], ['class' => 'btn btn-light border shadow-sm']) ?><br>
        <?= Html::a('<i class="fab fa-facebook"></i> Sign up with Facebook', ['site/index', 'provider' => 'facebook'], ['class' => 'btn btn-light border shadow-sm']) ?><br>
        <?= Html::a('<i class="fas fa-leaf"></i> Sign up with Forem', ['site/index', 'provider' => 'forem'], ['class' => 'btn btn-light border shadow-sm']) ?><br>
        <?= Html::a('<i class="fab fa-github"></i> Sign up with GitHub', ['site/index', 'provider' => 'github'], ['class' => 'btn btn-light border shadow-sm']) ?><br>
        <?= Html::a('<i class="fab fa-google"></i> Sign up with Google', ['site/index', 'provider' => 'google'], ['class' => 'btn btn-light border shadow-sm']) ?><br>
        <?= Html::a('<i class="fab fa-x-twitter"></i> Sign up with Twitter (X)', ['site/index', 'provider' => 'twitter'], ['class' => 'btn btn-light border shadow-sm']) ?><br>
        <?= Html::a('<i class="fas fa-envelope"></i> Sign up with Email', ['site/saveuser'], ['class' => 'btn btn-light border shadow-sm']) ?>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div></div>
            
        </div>

        <div class="small-text">
        By signing up, you are agreeing to our 
        <?= Html::a('privacy policy', ['site/privacy']) ?>,
        <?= Html::a('terms of use', ['site/terms']) ?>, and
        <?= Html::a('code of conduct', ['site/conduct']) ?>.
    </div>

    <p class="small-text mt-3">Already have an account? <?= Html::a('Log in.', ['site/login2']) ?></p>

        <?php ActiveForm::end(); ?>
    </div>
</div>
</div>