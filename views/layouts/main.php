<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\models\Notifications;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\Url;
use yii\web\JqueryAsset;

JqueryAsset::register($this);

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
$this->registerJsFile('@web/js/jquery.min.js', ['position' => \yii\web\View::POS_HEAD]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?= Html::csrfMetaTags() ?>
    <meta charset="<?= Yii::$app->charset ?>">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body class="d-flex flex-column h-100" , style="background-color:rgb(228, 235, 236);">
    <?php $this->beginBody() ?>

    <header id="header">
        <?php
        $action = Yii::$app->controller->action->id;
        $controller = Yii::$app->controller->id;
        $excludedPages = ['login2', 'saveuser', 'signup'];

        $this->registerLinkTag([
            'rel' => 'icon',
            'type' => 'image/png',
            'href' => Yii::getAlias('@web/dev-icon.png')
        ]);

        if (!in_array($action, $excludedPages)) {
            NavBar::begin([
                'brandLabel' => '<i class="fab fa-dev fa-2x mb-3"></i>',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => ['class' => 'navbar navbar-expand-md', 'style' => 'background-color: white; fixed-top'],

            ]);
            $menuItems = [];

            if (Yii::$app->user->isGuest) {
            } else {
                $menutItems[] = ['label' => '', 'options' => ['class' => 'ms-auto']];
                $menuItems[] = [
                    'label' => Html::tag('span', 'Create Post', ['class' => 'btn btn-primary btn-sm text-white']),
                    'url' => ['site/posts'],
                    'encode' => false,
                    'linkOptions' => ['class' => 'nav-link'],
                ];
            }
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav ms-auto'],
                'items' => $menuItems,
            ])

        ?>

            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarNav">

                    <!-- Search Form -->
                    <form class="d-flex" action="<?= Url::to(['post/search']) ?>" method="get">
                        <input class="form-control me-2" type="search" name="q" placeholder="Search..." required>
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>

                    <!-- Right Side -->
                    <ul class="navbar-nav ms-auto">
                        <?php if (Yii::$app->user->isGuest): ?>
                            <li class="nav-item"><?= Html::a('Login', ['/site/login2'], ['class' => 'nav-link']) ?></li>
                            <li class="nav-item"><?= Html::a('Create account', ['/site/signup'], ['class' => 'nav-link btn btn-primary ']) ?></li>
                        <?php else: ?>
                            <?php
                            $notifications = Notifications::find()
                                ->where(['user_id' => Yii::$app->user->id, 'is_read' => false])
                                ->all();

                            $unreadCount = count($notifications);
                            ?>

                            <?= Html::a(
                                '<i class="fa fa-bell fa-lg"></i>' .
                                    ($unreadCount > 0 ?
                                        '<span style="position: absolute; top: -5px; right: -10px; background: red; color: white; border-radius: 50%; padding: 2px 6px; font-size: 12px;">' . $unreadCount . '</span>'
                                        : ''),
                                ['/site/notifications'],
                                ['style' => 'position: relative;', 'encode' => false]
                            ) ?>

                            <?php
                            $user = \app\models\User::findOne(Yii::$app->user->id); // Ensure full model with image is loaded

                            if (!empty($user->image)) {
                                // Check if it's a resource or string
                                $binaryData = is_resource($user->image) ? stream_get_contents($user->image) : $user->image;

                                if ($binaryData !== false && strlen($binaryData) > 0) {
                                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                                    $mime = $finfo->buffer($binaryData);
                                    $base64 = base64_encode($binaryData);
                                    echo '<img src="data:' . $mime . ';base64,' . $base64 . '" alt="You" style="width: 50px; height: 50px; object-fit:cover; border-radius: 50%;" />';
                                
                                } else {
                                    echo '<img src="' . Yii::getAlias('@web/images/profileimage.jpg') . '" alt="Default" style="max-width: 100px; border-radius: 50%;" />';
                                }
                            } else {
                                echo '<img src="' . Yii::getAlias('@web/images/profileimage.jpg') . '" alt="Default" style="max-width: 100px; border-radius: 50%;" />';
                            }
                            ?>

                            <li class="nav-item dropdown">

                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">


                                    <ul class="dropdown-menu">
                                        <li><?= Html::a('Profile', ['/site/profile'], ['class' => 'dropdown-item']) ?></li>
                                        <li><?= Html::a('My Posts', ['/site/my-posts'], ['class' => 'dropdown-item']) ?></li>
                                        <li><?= Html::a('Logout', ['/site/logout'], ['class' => 'dropdown-item', 'data-method' => 'post']) ?></li>
                                    </ul>

                            </li>
                            <?= Yii::$app->user->identity->username ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>

        <?php NavBar::end();
        } ?>

    </header><br>

    <main id="main" class="flex-shrink-0" role="main">
        <div class="container">
            <?php if (!empty($this->params['breadcrumbs'])): ?>
                <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
            <?php endif ?>
            <?= Alert::widget() ?>
            <?= $content ?>


        </div>
    </main>

    <footer id="footer" class="mt-auto py-3 bg-light">
        <div class="container">
            <div class="row text-muted">
                <div class="col-md-6 text-center text-md-start">&copy; My Company <?= date('Y') ?></div>
                <div class="col-md-6 text-center text-md-end"><?= Yii::powered() ?></div>
            </div>
        </div>
    </footer>
    <? Alert::widget() ?>

    <script>
        setTimeout(function() {
            $(".alert").fadeOut(500, function() {
                $(this).remove();
            });
        }, 2000);
    </script>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>