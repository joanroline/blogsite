<?php
/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body><br>
    <!--<div class="table posts mt-5">
    <table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>NO</th>
            <th>Title</th>
            <th>Description</th>
            <th>Created at</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>-->
    
    <?php /*foreach ($model as $key => $person): ?>
            <tr>
                <td><?= ($key + 1) ?></td>
                <td><?= Html::encode($person->title) ?></td>
                <td><?= Html::encode($person->description) ?></td>
                <td><?= Html::encode($person->created_at) ?></td>
                <td> 
                <?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['view-post', 'id' => $person->id], ['class' => 'btn btn-primary']) ?>    
                <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['update-posts', 'id' => $person->id], ['class' => 'btn btn-primary']) ?>   
                <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete-posts', 'id' => $person->id], ['class' => 'btn btn-danger','data-confirm'=>'Are you sure you want to delete this post?','data-method'=>'post'])?>            
            </td>   
            </tr>
        <?php endforeach; */?>
   <!-- </tbody>
</table>
    </div>-->
<br>
<br>
    <div class="container" mt-5>
    <h1 style="text-align: center; color: rgb(221, 21, 98); font-size: 36px; font-weight: bold; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 30px;">
    Take a look at our weekly posts</h1>

    <div class="row" style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center;">
    <?php foreach ($model as $post): ?>
        <div class="col-md-4" style="display: flex;">
            <div class="card mb-4 shadow-sm" style="border-radius: 15px; overflow: hidden; width: 100%;">
                <div class="card-body" style="display: flex; flex-direction: column;">
                    <h5 class="card-title" style="text-decoration: underline; font-weight: bold;">
                        <?= Html::a(Html::encode((string) $post->title), ['view-post', 'id' => $post->id], ['style' => 'color: #333; text-decoration: none;']) ?>
                    </h5>
                    <?php if ($post->coverImage): ?>
    <img src="<?= Yii::getAlias('@web/uploads/' . $post->coverImage) ?>" class="img-fluid mb-2" style="border-radius: 10px;" />
<?php endif; ?>


                    <h6 class="card-subtitle mb-2 text-muted">
                        Posted on: <?= Yii::$app->formatter->asDatetime($post->created_at) ?>
                    </h6>
                    <h7 class="card-subtitle mb-2 text-muted">
                        Posted by:<?= Html::encode($post->author->username) ?>
                    </h7>
                    <p class="card-text" style="flex-grow: 1;">
                        <?= Html::encode(\yii\helpers\StringHelper::truncateWords($post->description, 20)) ?>
                    </p>
                    <a href="<?= Yii::$app->urlManager->createUrl(['site/view-post', 'id' => $post->id]) ?>" class="btn btn-link">Read More</a>
                    <div class="mt-3 d-flex justify-content-between">
                        <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['update-posts', 'id' => $post->id], ['class' => 'btn btn-warning btn-sm']) ?>
                        <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete-posts', 'id' => $post->id], ['class' => 'btn btn-danger btn-sm', 'data-method' => 'post', 'data-confirm' => 'Are you sure you want to delete this post?']) ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<style>
    .row {
        column-gap: 15px;
    }
    .card {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease-in-out;
    }
    .card:hover {
        transform: scale(1.05);
    }
</style>


    <br> <!-- Line break after the row -->
</div>

</div>

</div>

</div>


</body>
</html>


