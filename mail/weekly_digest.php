<?php
use yii\helpers\Html;
?>

<p>Hello <?= Html::encode($user->username) ?>,</p>

<p>Here are the posts from the past week:</p>

<ul>
<?php foreach ($posts as $post): ?>
    <li>
        <strong><?= Html::encode($post->title) ?></strong><br>
        <?= Html::encode(mb_substr(strip_tags($post->description), 0, 20)) ?><br>
        <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['site/view-post', 'id' => $post->id]) ?>">Read more</a>
    </li>
<?php endforeach; ?>
</ul>

<p>See you next week!</p>
