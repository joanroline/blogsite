<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var ActiveForm $form */
?>
<div class="users">

    <?php $form = ActiveForm::begin(); ?>
<div class = "form-field">
    <h1 class="text-center">Registration Form</h1>

        <?= $form->field($model, 'username') ?>
        <?= $form->field($model, 'firstname') ?>
        <?= $form->field($model, 'lastname') ?>
        <?= $form->field($model, 'email') ?>
        
        <?= $form->field($model, 'gender')->radioList(['male'=>'Male','female'=> 'Female','prefer_not_to_say'=> 'Prefer not to say']) ?>
        
        <div class="form-group">
        <?= Html::submitButton('Register', ['class' => 'btn btn-primary']) ?>
        </div>
        </div>

    <?php ActiveForm::end(); ?>
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



</div><!-- users -->
