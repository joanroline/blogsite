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
                <?php foreach ($members as $key => $person): ?>
                    <tr>
                        <td><?= ($key + 1) ?></td>
                        <td><?= Html::encode($person->firstname) ?></td>
                        <td><?= Html::encode($person->lastname) ?></td>
                        <td><?= Html::encode($person->email) ?></td>

                    
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>
