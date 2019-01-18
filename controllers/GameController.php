<?php

namespace app\controllers;

use Yii;
use app\models\EnterPlayerNameForm;
use yii\web\Controller;
use app\models\Game;
use yii\base\Module;

class GameController extends Controller
{
    /**
     * @var Game
     */
    protected $game;

    public function __construct($id, Module $module, array $config = [])
    {
        parent::__construct($id, $module, $config);

        if(!empty($gameId=Yii::$app->session->get('gameId'))){
            $this->game=new Game();
            $this->game->loadGame($gameId);
        }
    }

    public function actionIndex()
    {
        $model = new EnterPlayerNameForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // данные в $model удачно проверены

            // делаем что-то полезное с $model ...

            $this->createGame($model->playerOneName, $model->playerTwoName);
            return $this->actionPlacementPhase();
        } else {
            // либо страница отображается первый раз, либо есть ошибка в данных
            return $this->render('index', ['model' => $model]);
        }
    }

    public function actionPlacementPhase()
    {
        $postArr=Yii::$app->request->post();
        if(!empty(Yii::$app->request->post('submit_btn_place'))) {
            if($this->game->fieldEmpty(Game::FIELD_ONE_NUM)) {
                if (Helper::verifyInputFieldArray($postArr)){
                    $this->game->setField(Game::FIELD_ONE_NUM,
                        Helper::convertFieldArrayToString($postArr));

                    return $this->render('placementPhase',
                        ['playerName' => $this->game->playerTwo->playerName]);
                }else{
                    return $this->render('placementPhase',
                        ['playerName' => $this->game->playerOne->playerName]);
                }
            }else{
                if (Helper::verifyInputFieldArray($postArr)){
                    $this->game->setField(Game::FIELD_TWO_NUM,
                        Helper::convertFieldArrayToString($postArr));

                    return $this->runGame();
                }else{
                    return $this->render('placementPhase',
                        ['playerName' => $this->game->playerTwo->playerName]);
                }
            }
        }else{
            return $this->render('placementPhase',
                ['playerName' => $this->game->playerOne->playerName]);
        }
    }

    protected function createGame(string $playerOne, string $playerTwo)
    {
        $this->game=new Game();
        $this->game->createGame($playerOne, $playerTwo);
    }

    protected function runGame()
    {
        Yii::$app->session->set('currentPlayerNum', Game::PLAYER_ONE_NUM);
        return $this->render('game', [
            'playerName' => $this->game->playerOne->playerName,
            'fieldOne' => $this->game->getFieldOne(),
            'fieldTwo' => $this->game->getFieldTwo()]);
    }

    protected function doStep(string $x, string $y)
    {
        $this->game->doStep($x, $y);

        $currentPlayerNum= Yii::$app->session->get('currentPlayerNum');

        if($this->game->checkEndGame($currentPlayerNum)){
            unset($_SESSION['gameId']);
            if($currentPlayerNum===Game::PLAYER_ONE_NUM){
                return $this->render('endGame', [
                    'playerName' => $this->game->playerOne->playerName
                ]);
            }else{
                return $this->render('endGame', [
                    'playerName' => $this->game->playerTwo->playerName
                ]);
            }
        }elseif($currentPlayerNum===Game::PLAYER_ONE_NUM){
            return $this->render('game', [
                'playerName' => $this->game->playerOne->playerName,
                'fieldOne' => $this->game->getFieldOne(),
                'fieldTwo' => $this->game->getFieldTwo()]);
        }else{
            return $this->render('game', [
                'playerName' => $this->game->playerOne->playerName,
                'fieldOne' => $this->game->getFieldTwo(),
                'fieldTwo' => $this->game->getFieldOne()]);
        }
    }

}