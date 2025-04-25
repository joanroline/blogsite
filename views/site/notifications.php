<?php
/** @var yii\web\View $this */
/** @var app\models\Notifications[] $notifications */

$this->title = 'Notifications';
?>

<h1>Notifications</h1>

<?php if (empty($notifications)): ?>
    <p>No notifications.</p>
<?php else: ?>
    <ul>
        <?php foreach ($notifications as $notification): ?>
            <?php if ($notification->post): ?>
                <li style="margin-bottom: 15px;">
                    <strong><?= htmlspecialchars($notification->post->title) ?></strong><br>
                    <p><?= htmlspecialchars($notification->post->content) ?></p>
                    <small>Posted on: <?= Yii::$app->formatter->asDatetime($notification->post->created_at) ?></small>
                </li>
            <?php else: ?>
                <li><em>Post not found (may have been deleted).</em></li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
