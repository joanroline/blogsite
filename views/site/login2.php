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

        <?= $form->field($model, 'username')->textInput(['placeholder' => 'joanroline']) ?>
        <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Atleast 6 characters']) ?>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div></div>
            <?= Html::a('Forgot password?', ['site/request-password-reset'], ['class' => 'text-muted text-decoration-none']) ?>
        </div>

        <div class="d-grid mb-3">
            <?= Html::submitButton('Log in', ['class' => 'btn btn-dark rounded-pill']) ?>
        </div>

        <div class="text-center mb-3">
            <p class="text-muted">or</p>
            <a href="#" class="btn btn-outline-dark w-100 rounded-pill ">
                <img src="<?= Yii::getAlias('@web') ?>/images/google-icon.png" width="20" class="me-2"> Sign in with Google
            </a>
        </div>

        <div class="text-center">
            <p class="text-muted">New to dev? <?= Html::a('Create Account', ['site/signup'], ['class' => 'text-decoration-none']) ?></p>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
</div>