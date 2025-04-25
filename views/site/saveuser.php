<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var ActiveForm $form */
?>
<div class="saveuser">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'image')->fileInput()?>
    <?= $form->field($model, 'firstname') ?>
    <?= $form->field($model, 'lastname') ?>
    <?= $form->field($model, 'email') ?>
    <?= $form->field($model, 'username') ?>
    <?= $form->field($model, 'password',['template' => '{label}<div class="input-group">{input}<div class="input-group-append"><span class="input-group-text"><i class="fa fa-eye toggle-password"></i></span>
         </div></div>{error}',])->passwordInput(['id' => 'password-field']) ?>
        <?= $form->field($model, 'confirm_password', [
         'template' => '{label}<div class="input-group">{input}<div class="input-group-append">
        <span class="input-group-text"><i class="fa fa-eye toggle-password"></i></span>
         </div></div>{error}',])->passwordInput(['id' => 'confirm-password']) ?>
          <?= $form->field($model, 'gender')->radioList(['male'=>'Male','female'=> 'Female','prefer_not_to_say'=> 'Prefer not to say']) ?>
        <br>

    <div class="form-group">
        <?= Html::submitButton('Register', ['class' => 'btn btn-primary']) ?>
    </div>
    <div style= text-align:center><p>Already have an account <a class="btn btn-primary" href="http://localhost/blog/site/login" role="button">Login</a> </p>
    </div>
    

    <script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".toggle-password").forEach(function (eyeIcon) {
        eyeIcon.addEventListener("click", function () {
            let passwordField = this.closest(".input-group").querySelector("input");
            passwordField.type = passwordField.type === "password" ? "text" : "password";
            this.classList.toggle("fa-eye");
            this.classList.toggle("fa-eye-slash");
        });
    });
});
</script>
    <?php ActiveForm::end(); ?>

</div><!-- saveuser -->