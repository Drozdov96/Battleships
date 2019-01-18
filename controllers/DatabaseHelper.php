<?php

namespace app\controllers;

use \yii\db\Query;
use app\models\Cell;


class DatabaseHelper
{
    /**
     * @param string $playerName
     * @return int
     */
    public static function getPlayerIdFromDb(string $playerName): int
    {

        do{
            $query=(new Query())
                ->select('id')
                ->from('players')
                ->where(['name' => $playerName])
                ->one();

            if(empty($query)){
                \Yii::$app->db->createCommand()->insert('players',
                    ['name'=>$playerName])->execute();
            }
        }while(empty($query));

        $id=$query['id'];
        unset($query);
        return $id;
    }


    /**
     * @param int $idOne
     * @param int $idTwo
     * @return mixed
     */
    public static function createGame(int $idOne, int $idTwo)
    {


        \Yii::$app->db->createCommand()->insert('games',[
            'player_one' => (string)$idOne,
            'player_two' => (string)$idTwo
        ])->execute();

        $query=(new Query())
            ->select('id')
            ->from('games')
            ->where([
                'player_one' => (string)$idOne,
                'player_two' => (string)$idTwo,
                'winner' => null,
                'end_timestamp' => null])
            ->one();

        $id=$query['id'];
        unset($query);
        return $id;
    }


    /**
     * @param int $gameId
     * @param int $ownerId
     * @return bool
     */
    public static function createField(int $gameId, int $ownerId)
    {

        \Yii::$app->db->createCommand()->insert('fields',[
            'game_id' => (string)$gameId,
            'owner' => (string)$ownerId
        ])->execute();

        $query=(new Query())
            ->select(['fields.id', 'games.player_one', 'games.player_two'])
            ->from('fields')
            ->innerJoin('games', 'fields.game_id = games.id')
            ->where([
                'fields.game_id' => (string)$gameId,
                'fields.owner' => (string)$ownerId
            ])
            ->one();

        switch ($ownerId){
            case $query['player_one']:
                \Yii::$app->db->createCommand()->update('games',
                    ['field_one' => $query['id']],
                    'id ='.(string)$gameId)->execute();
                break;
            case $query['player_two']:
                \Yii::$app->db->createCommand()->update('games',
                    ['field_two' => $query['id']],
                    'id='.(string)$gameId)->execute();
                break;
            default:
                return false;
        }

        $id=$query['id'];
        unset($query);
        return $id;
    }


    /**
     * @param int $fieldId
     * @param int $coordX
     * @param int $coordY
     * @param string $state
     * @return mixed
     */
    public static function createCell(int $fieldId, int $coordX, int $coordY,
                                      string $state)
    {
        \Yii::$app->db->createCommand()->insert('cells', [
            'field' => (string)$fieldId,
            'state' => $state,
            'coordinate_x' => (string)$coordX,
            'coordinate_y' => (string)$coordY
        ])->execute();

        $query=(new Query())
            ->select('id')
            ->from('cells')
            ->where([
                'field' => (string)$fieldId,
                'coordinate_x' => (string)$coordX,
                'coordinate_y' => (string)$coordY
            ])
            ->one();

        $id=$query['id'];
        unset($query);
        return $id;
    }


    /**
     * @param int $gameId
     * @return array
     */
    public static function loadGame(int $gameId): array
    {
        $query=(new Query())
            ->from('games')
            ->where([
                'id' => (string)$gameId
            ])
            ->one();

        return $query;
    }


    /**
     * @param int $playerId
     * @return string
     */
    public static function loadPlayer(int $playerId): string
    {
        $query=(new Query())
            ->select('name')
            ->from('players')
            ->where([
                'id' => (string)$playerId
            ])
            ->one();

        $name=$query['name'];
        unset($query);
        return $name;
    }


    public static function loadCell(int $fieldId, int $x, int $y)
    {
        $query=(new Query())
        ->from('cells')
            ->where([
                'field' => (string)$fieldId,
                'coordinate_x' => (string)$x,
                'coordinate_y' => (string)$y
            ])
            ->one();

        return $query;
    }


    public static function changeCellState(int $cellId, string $state)
    {
        \Yii::$app->db->createCommand()->update('cells',
            ['state' => $state], ['id' => (string)$cellId])->execute();
    }


    public static function getShipsNum(int $fieldId)
    {
        $query=(new Query())
            ->select('COUNT(*)')
            ->from('cells')
            ->where([
                'field' => (string)$fieldId,
                'state' => Cell::SHIP_CELL_STATE
            ])
            ->scalar();
        return $query;
    }


    public static function setWinnerAndTime(int $winnerId, int $gameId)
    {
        \Yii::$app->db->createCommand('UPDATE games SET winner='
            .(string)$winnerId.', end_timestamp=current_timestamp 
            WHERE id='.(string)$gameId)->execute();
    }
}