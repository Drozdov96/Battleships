<?php

/* @var $model app\models\EnterPlayerNameForm */

use yii\helpers\Html;
?>
<p>Вы ввели следующую информацию:</p>

<ul>
    <li><label>Player 1</label>: <?= Html::encode($model->playerOneName) ?></li>
    <li><label>Player 2</label>: <?= Html::encode($model->playerTwoName) ?></li>
</ul>