<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use app\models\Posts;
use app\models\Comments;
use app\models\Likes;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;
use kartik\mpdf\Pdf;

$this->title = 'DEV Community';

?>
<div class="site-index">
    <div class="container">
        <div class="row gx-4">

            <div class="col-12 col-md-3 col-lg-3 md-3">
                <?php if (Yii::$app->user->isGuest): ?>
                    <div class="p-2 bg-light rounded shadow-sm ">
                        <h5><b>DEV Community is a community of 3,000,045 amazing developers</b></h5><br>
                        <p>We're a place where coders share, stay up-to-date and grow their careers.</p>
                        <?= Html::a('Create account', ['site/signup'], ['class' => ' btn btn-outline-primary btn-sm']) ?> <br>
                        <?= Html::a('Login', ['site/login2'], ['class' => ' btn btn-link btn-sm']) ?>
                    </div><br>
                <?php endif; ?>
                <?= Html::a('Home', ['site/index'], ['class' => ' btn btn- btn-sm']) ?><br>
                <?= Html::a('DEV++', ['site/index'], ['class' => ' btn btn- btn-sm']) ?><br>
                <?= Html::a('Podcasts', ['site/index'], ['class' => ' btn btn- btn-sm']) ?><br>
                <?= Html::a('Videos', ['site/index'], ['class' => ' btn btn- btn-sm']) ?><br>
                <?= Html::a('Tags', ['site/index'], ['class' => ' btn btn- btn-sm']) ?><br>
                <?= Html::a('DEV Help', ['site/index'], ['class' => ' btn btn- btn-sm']) ?><br>
                <?= Html::a('Forem Shop', ['site/index'], ['class' => ' btn btn- btn-sm']) ?><br>
                <?= Html::a('Advertise on DEV', ['site/index'], ['class' => ' btn btn- btn-sm']) ?><br>
                <?= Html::a('DEV Challenges', ['site/index'], ['class' => ' btn btn- btn-sm']) ?><br>
                <?= Html::a('DEV Showcase', ['site/index'], ['class' => ' btn btn- btn-sm']) ?><br>
                <?= Html::a('About', ['site/index'], ['class' => ' btn btn- btn-sm']) ?><br>
                <?= Html::a('Contact', ['site/index'], ['class' => ' btn btn- btn-sm']) ?><br>
                <?= Html::a('Free Postgress Database', ['site/index'], ['class' => ' btn btn- btn-sm']) ?><br>
                <?= Html::a('Software Comparisons', ['site/index'], ['class' => ' btn btn- btn-sm']) ?><br>
            </div>

            <div class="col-12 col-md-9 col-lg-6 mb-3">
                <h3 class="mb-2">Our latest blogs</h3>

                <div class="p-2 bg-white rounded shadow-sm">
                    <?php if (!empty($posts)): ?>
                        <div class="row g-2">
                            <?php foreach ($posts as $post): ?>
                                <?php
                                $commentModel = Yii::createObject([
                                    'class' => Comments::class,
                                    'post_id' => $post->id
                                ]);
                                ?>
                                <div class="col-12 mb-2">
                                    <div class="card shadow-sm w-100" style="border-radius: 10px; overflow: hidden;">
                                        <div class="card-body d-flex flex-column p-2">
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
                                                <img src="data:<?= $mimeType ?>;base64,<?= $base64 ?>" alt="Cover Image"
                                                    style="width: 100%; max-width: 600px; height: auto;" />


                                            <?php endif; ?>



                                            <h5 class="card-title" style="text-decoration: underline; font-weight: bold; font-size: 1rem;">
                                                <?= Html::a(Html::encode((string) $post->title), ['view-post', 'id' => $post->id], ['style' => 'color: #333; text-decoration: none;']) ?>
                                            </h5>
                                            <h6 class="card-subtitle mb-1 text-muted" style="font-size: 0.8rem;">
                                                Posted on: <?= Yii::$app->formatter->asDatetime($post->created_at) ?>
                                            </h6>
                                            <h7><strong>Author:</strong> <?= Html::encode($post->author?->username ?? 'Unknown Author') ?></h7>
                                            <p class="card-text flex-grow-1" style="font-size: 0.9rem;">
                                                <?= Html::encode(\yii\helpers\StringHelper::truncateWords($post->description, 20)) ?>
                                            </p>
                                            <a href="<?= Yii::$app->urlManager->createUrl(['site/view-post', 'id' => $post->id]) ?>" class="btn btn-link p-0" style="font-size: 0.9rem;">Read More</a>

                                            <!-- Likes -->
                                            <?php
                                            $hasLiked = Likes::find()->where(['post_id' => $post->id, 'user_id' => Yii::$app->user->id,])->exists();
                                            $likeCount = Likes::find()->where(['post_id' => $post->id])->count();
                                            ?>

                                            <?= Html::a($hasLiked ? '🥵Unlike' : ' ❤️ Like', ['site/like', 'id' => $post->id], ) ?>
                                            <span><?= $likeCount ?> ❤️likes</span>

                                            <!-- Comments -->
                                            <?php if (!Yii::$app->user->isGuest): ?>
                                                <?php $form = ActiveForm::begin(['action' => ['site/comment', 'id' => $post->id]]); ?>
                                                <?= $form->field($commentModel, 'content')->textarea(['rows' => 3, 'placeholder' => 'Add a comment']) ?>
                                                <?= Html::submitButton('Comment', ['class' => 'btn btn-success']) ?>
                                                <?php ActiveForm::end(); ?>
                                            <?php else: ?>
                                                <p><a href="<?= Url::to(['site/login2']) ?>"></a></p>
                                            <?php endif; ?>

                                            <!-- Comments and replies -->
                                            <h4>Comments:</h4>
                                            <?php foreach ($post->comments as $comment): ?>
                                                <div style="margin-left: <?= $comment->parent_id ? '40px' : '0' ?>;">
                                                    <strong><?= $comment->user->username ?></strong>: <?= Html::encode($comment->content) ?>
                                                    <small class="text-muted"><?= Yii::$app->formatter->asRelativeTime($comment->created_at) ?></small>

                                                    <!-- Reply Form -->
                                                    <?php $replyModel = new Comments(); ?>
                                                    <?php $form = ActiveForm::begin([
                                                        'action' => ['site/reply', 'id' => $comment->id],
                                                        'method' => 'post',
                                                    ]); ?>
                                                    <?= $form->field($replyModel, 'content')->textarea(['rows' => 2, 'placeholder' => 'Reply...'])->label(false) ?>
                                                    <?= Html::submitButton('Reply', ['class' => 'btn btn-sm btn-outline-secondary']) ?>
                                                    <?php ActiveForm::end(); ?>


                                                    <!-- Replies -->
                                                    <?php foreach ($comment->replies as $reply): ?>
                                                        <div style="margin-left: 40px;">
                                                            <strong><?= Html::encode($reply->user->username) ?></strong>: <?= Html::encode($reply->content) ?>
                                                            <small class="text-muted"><?= Yii::$app->formatter->asRelativeTime($reply->created_at) ?></small>
                                                        </div>
                                                    <?php endforeach; ?>

                                                </div>
                                            <?php endforeach; ?>

                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p>No posts available.</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-12 col-lg-3 d-none d-lg-block">
                <div class="p-2 bg-light rounded shadow-sm h-100">
                    <div class="p-2 bg-light rounded shadow-sm ">
                        <h5>Trends</h5>
                        <p>What's trending in the dev world?</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>