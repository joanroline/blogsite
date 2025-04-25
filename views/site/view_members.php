<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Members</title>
</head>

<?php if (empty($isPdf)): ?>
    <?= Html::a('<i class="fas fa-file-pdf"></i> PDF', ['site/memberspdf'], [
        'class' => 'btn btn-info',
        'target' => '_blank', // open in new tab
        'data-pjax' => 0
    ]) ?>

    <?= Html::a('<i class="fas fa-file-excel"></i> Excel', ['site/membersexcel'], [
        'class' => 'btn btn-success',
        'target' => '_blank',
        'data-pjax' => 0
    ]) ?>

<?php endif; ?>

<body> <br>
    <div class="table-responsive posts mt-5">
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>NO</th>
                    <th>Fname</th>
                    <th>Lname</th>
                    <th>Email</th>
                    <?php if (empty($isPdf)): ?>
                        <th>Action</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($model as $key => $person): ?>
                    <tr>
                        <td><?= ($key + 1) ?></td>
                        <td><?= Html::encode($person->firstname) ?></td>
                        <td><?= Html::encode($person->lastname) ?></td>
                        <td><?= Html::encode($person->email) ?></td>

                        <?php if (empty($isPdf)): ?>
                            <td>
                                <?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['view-member', 'id' => $person->id], ['class' => 'btn btn-primary']) ?>
                                <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['update-members', 'id' => $person->id], ['class' => 'btn btn-primary']) ?>
                                <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete-members', 'id' => $person->id], ['class' => 'btn btn-danger', 'data-confirm' => 'Are you sure you want to delete this member?', 'data-method' => 'post']) ?>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>