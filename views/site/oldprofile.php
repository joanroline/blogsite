<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var yii\widgets\ActiveForm $form */

$this->title = 'My Profile';
?>

<div class="user-profile">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="profile-form">
        <p>
            <?= Html::a('Edit Profile', ['site/edit'], ['class' => 'btn btn-primary']) ?>
        </p>

        <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data'] // For file upload
        ]); ?>

        <?php if ($user->image): ?>
            <div>
                <label>Current Profile Picture</label><br>
                <?= Html::img(Yii::getAlias('@web/uploads/' . $model->profile_picture), ['alt' => 'Profile Picture', 'width' => '120']) ?>
            </div>
        <?php endif; ?>

        <?= $form->field($user, 'image')->fileInput() ?>

        <?= $form->field($user, 'username')->textInput(['readonly' => true]) ?>

        <?= $form->field($user, 'email')->textInput(['maxlength' => true]) ?>







        <?php ActiveForm::end(); ?>

    </div>

</div>