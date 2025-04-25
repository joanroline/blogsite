<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = '' . $user->username;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="text-center">
  <h1><?= Html::encode($this->title) ?></h1>
  <div class="text-center">
    <?php if (!empty($user->image)): ?>
      <?php
      $binaryData = stream_get_contents($user->image);
      $finfo = new finfo(FILEINFO_MIME_TYPE);
      $mime = $finfo->buffer($binaryData);
      $base64 = base64_encode($binaryData);
      ?>
      <img src="data:<?= $mime ?>;base64,<?= $base64 ?>" alt="You"
           style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%;" />
    <?php else: ?>
      <img src="/images/profileimage.jpg" alt="You"
           style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%;" />
    <?php endif; ?>
  </div>
  <?= Html::a('Edit Profile', ['site/edit'], ['class' => 'btn btn-primary']) ?>
</div>

     
<div class="card shadow mb-4" style="max-width: 600px; margin: auto;">
  <div class="card-header" style="background-color:rgb(169, 185, 202); color: white;">
    
    <div class="card-body">
      <?= DetailView::widget([
        'model' => $user,
        'attributes' => [
          'username',
          'email',
          'firstname',
          'lastname',
          // Do not display password or sensitive fields here
        ],
      ]) ?>
    </div>
  </div>


</div>