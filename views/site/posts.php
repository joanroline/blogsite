<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Posts $model */
/** @var ActiveForm $form */

$this->title = 'Create Post';
?>

<div class="max-w-4xl mx-auto bg-white p-8 rounded shadow ">
    <h1 class="text-2xl font-bold mb-4"><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'coverImageFile')->fileInput() ?><br>

    <?= $form->field($model, 'title')->textInput(['placeholder' => 'New post title here...']) ?><br>

    <?= $form->field($model, 'tags')->textInput(['placeholder' => 'Add up to 4 tags...']) ?><br>

    <?= $form->field($model, 'description')->textarea(['rows' => 10, 'placeholder' => 'Write your post content here...']) ?>

    <div class="flex gap-4 mt-4">
        <?= Html::submitButton('Publish', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>