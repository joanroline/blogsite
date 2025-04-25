<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var ActiveForm $form */
?>

<div class =mt-5></div><br>
  <h1>User Profile</h1>

<p>Username: <?= Html::encode($model->username) ?></p>
<p>FirstName: <?= Html::encode($model->firstname) ?></p>
<p>LastName: <?= Html::encode($model->lastname) ?></p>
<p>Email: <?= Html::encode($model->email) ?></p>


<?= Html::a('Edit Profile', ['update-members', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
<a href="http://localhost/blog/site/view-members" class="btn btn-link" role="button">Back</a>

</div>


