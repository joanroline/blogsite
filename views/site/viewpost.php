<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Comments;
use app\models\Likes;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var ActiveForm $form */

$commentModel = new Comments();
$commentModel->post_id = $post->id;

$this->title = Html::encode($post->title);
?>
<div class="posts  mt-5">
    <br>
    <h1>Posts</h1>
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title"><?= Html::encode($post->title) ?></h5>
            <?php if ($post->coverImage): ?>
                <img src="data:<?= $post->cover_image_type ?>;base64,<?= base64_encode($model->cover_image) ?>" style="max-width:100%; height:auto;" />
            <?php endif; ?>
            <p class="card-text"><?= nl2br(Html::encode($post->description)) ?></p>
            <small class="text-muted">Posted on <?= Yii::$app->formatter->asDatetime($post->created_at) ?></small>
        </div>
    </div>

    
    <!---<h2>Comments</h2>-->
    <?php foreach ($post->comments as $comment): ?>
        <div class="comment border p-2 mb-2">
            <p><strong><?= Html::encode($comment->user->username) ?>:</strong> <?= Html::encode($comment->content) ?></p>

            <?php foreach ($comment->replies as $reply): ?>
                <div class="ml-4 reply">
                    <p><strong><?= Html::encode($reply->user->username) ?>:</strong> <?= Html::encode($reply->content) ?></p>
                </div>
            <?php endforeach; ?>

            <!-- Reply Form -->
            <?php if (!Yii::$app->user->isGuest): ?>
                <?= Html::beginForm(['site/add-comment'], 'post') ?>
                <?= Html::hiddenInput('post_id', $post->id) ?>
                <?= Html::hiddenInput('parent_id', $comment->id) ?>
                <?= Html::textarea('content', '', ['class' => 'form-control', 'rows' => 2]) ?>
                <?= Html::submitButton('Reply', ['class' => 'btn btn-sm btn-primary mt-1']) ?>
                <?= Html::endForm() ?>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

    <!--Add Comment-->
    <?php if (!Yii::$app->user->isGuest): ?>
                <h4>Add a Comment</h4>

                <?php $form = ActiveForm::begin([
                    'action' => ['site/add-comment'],
                    'method' => 'post',
                ]); ?>

                <?= $form->field($commentModel, 'content')->textarea(['rows' => 3]) ?>
                <?= Html::hiddenInput('post_id', $post->id) ?>

                <div class="form-group">
                    <?= Html::submitButton('Post Comment', ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            <?php endif; ?>
<!---LIkes-->
<?php
                                            $hasLiked = Likes::find()->where(['post_id' => $post->id, 'user_id' => Yii::$app->user->id,])->exists();
                                            $likeCount = Likes::find()->where(['post_id' => $post->id])->count();
                                            ?>

                                            <?= Html::a($hasLiked ? '🥵Unlike' : ' ❤️ Like', ['site/like', 'id' => $post->id], [
                                                'class' => 'btn btn-sm btn-outline-primary',
                                            ]) ?>
                                            <span><?= $likeCount ?> ❤️likes</span>

