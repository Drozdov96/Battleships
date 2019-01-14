<?php

namespace app\controllers;

use Yii;
use app\models\EnterPlayerNameForm;
use yii\web\Controller;

class GameController extends Controller
{
    public function actionIndex()
    {
        $model = new EnterPlayerNameForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // данные в $model удачно проверены

            // делаем что-то полезное с $model ...

            return $this->render('entry-confirm', ['model' => $model]);
        } else {
            // либо страница отображается первый раз, либо есть ошибка в данных
            return $this->render('index', ['model' => $model]);
        }
    }
}