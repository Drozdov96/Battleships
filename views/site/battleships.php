<?php

/* @var $this yii\web\View */

//use yii\helpers\Html;

$this->title='Морской бой';

$testQu=Yii::$app->db->createCommand('SELECT * FROM players')->queryAll();

foreach ($testQu as $value){
    var_dump($value);
    echo '<br>';
}
