<?php

namespace app\controllers;

use Yii;
use app\models\EnterPlayerNameForm;
use yii\web\Controller;
use app\models\Game;
use yii\base\Module;

class GameController extends Controller
{
    protected $game;
    public const NEW_GAME_NUM=-1;

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

            return $this->render('entry-confirm', ['model' => $model]);
        } else {
            // либо страница отображается первый раз, либо есть ошибка в данных
            return $this->render('index', ['model' => $model]);
        }
    }

//    protected function runPlacementPhase()
//    {
//        if(isset($_POST['submit_btn_place'])) {
//            if($this->game->fieldEmpty(Game::FIELD_ONE_NUM)) {
//                if (Helper::verifyInputFieldArray($_POST)){
//                    $this->game->setField(Game::FIELD_ONE_NUM, Helper::convertFieldArrayToString($_POST));
//                    echo HtmlHelper::getShipsPlacementPage($this->game->playerTwo->playerName);
//                }else{
//                    echo HtmlHelper::getShipsPlacementPage($this->game->playerOne->playerName);
//                }
//            }else{
//                if (Helper::verifyInputFieldArray($_POST)){
//                    $this->game->setField(Game::FIELD_TWO_NUM, Helper::convertFieldArrayToString($_POST));
//                    header("Refresh:0; url=index.php?state=startGame");
//                    exit;
//                }else{
//                    echo HtmlHelper::getShipsPlacementPage($this->game->playerTwo->playerName);
//                }
//            }
//        }else{
//            echo HtmlHelper::getShipsPlacementPage($this->game->playerOne->playerName);
//        }
//    }
//
//    protected function createGame(string $playerOne, string $playerTwo)
//    {
//        $this->game=new Game();
//        $this->game->createGame($playerOne, $playerTwo);
//        header("Refresh:0; url=index.php?state=preparePhase");
//        exit;
//    }
//
//    protected function runSetNamesPhase()
//    {
//        echo HtmlHelper::getPlayersNamePage();
//    }
//
//    protected function runGame()
//    {
//        $_SESSION['currentPlayerNum']=Game::PLAYER_ONE_NUM;
//        echo HtmlHelper::getGamePage($this->game->playerOne->playerName,
//            $this->game->getFieldOne(), $this->game->getFieldTwo());
//    }
//
//    protected function doStep(string $x, string $y)
//    {
//        $this->game->doStep($x, $y);
//
//        if($this->game->checkEndGame($_SESSION['currentPlayerNum'])){
//            unset($_SESSION['gameId']);
//            if($_SESSION['currentPlayerNum']===Game::PLAYER_ONE_NUM){
//                echo HtmlHelper::getEndGamePage($this->game->playerOne->playerName);
//            }else{
//                echo HtmlHelper::getEndGamePage($this->game->playerTwo->playerName);
//            }
//        }elseif($_SESSION['currentPlayerNum']===Game::PLAYER_ONE_NUM){
//            echo HtmlHelper::getGamePage($this->game->playerOne->playerName,
//                $this->game->getFieldOne(), $this->game->getFieldTwo());
//        }else{
//            echo HtmlHelper::getGamePage($this->game->playerTwo->playerName,
//                $this->game->getFieldTwo(),$this->game->getFieldOne());
//        }
//    }
//
//    /**
//     * @param string $state
//     */
//    public function doRoute(string $state)
//    {
//        switch ($state){
//            case 'preparePhase':
//                $this->runPlacementPhase();
//                break;
//            case 'startGame':
//                $this->runGame();
//                break;
//            case 'doStep':
//                $this->doStep($_GET['x'], $_GET['y']);
//                unset($_GET['x'], $_GET['y']);
//                break;
//            case 'setNames':
//                $this->createGame($_POST['playerOneName'], $_POST['playerTwoName']);
//                break;
//            default:
//                $this->runSetNamesPhase();
//        }
//    }
}