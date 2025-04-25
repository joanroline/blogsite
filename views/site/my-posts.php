<?php

use yii\helpers\Html;

/** @var $posts app\models\Posts[] */

$this->title = 'My Posts';
?>

<h1>My Posts</h1>

<?php foreach ($posts as $post): ?>
    <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
        <?php if (!empty($post->coverimage)): ?>
            <?php
            // Convert to string if it's a resource
            $imageData = is_resource($post->coverimage) ? stream_get_contents($post->coverimage) : $post->coverimage;

            // Get MIME type
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->buffer($imageData);

            // Encode
            $base64 = base64_encode($imageData);
            ?>
            <img src="data:<?= $mimeType ?>;base64,<?= $base64 ?>" alt="Cover Image" width="700" />
        <?php else: ?>
            <p><em>No cover image available.</em></p>
        <?php endif; ?>

        <h5><?= Html::encode($post->title) ?></h5>
        <p><?= nl2br(Html::encode($post->description)) ?></p>
        <small class=" text-muted">Posted on <?= Yii::$app->formatter->asDatetime($post->created_at) ?></small>
        <div class="mt-2">
            <p><strong>❤️</strong> <?= count($post->likes) ?>

                <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['update-posts', 'id' => $post->id], ['class' => 'btn btn-warning']) ?>
                <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete-posts', 'id' => $post->id], ['class' => 'btn btn-danger', 'data-method' => 'post', 'data-confirm' => 'Are you sure you want to delete this post?']) ?><br><br>


            </p>
        </div>
    </div>
<?php endforeach; ?>