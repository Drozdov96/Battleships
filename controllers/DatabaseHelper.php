<?php

namespace app\controllers;

use \yii\db\Query;

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
     * @return bool
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
     * @return bool
     */
    public static function createCell(int $fieldId, int $coordX, int $coordY,
                                      string $state)
    {
        \Yii::$app->db->createCommand()->insert('cells', [
            'field' => (string)$fieldId,
            'state' => $state,
            'coordinate_x' => (string)$coordX,
            'coordinate_y' => (string)$coordY
        ]);

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
        $query=self::$dbc->query("SELECT * FROM games WHERE id=".
            (string)$gameId);
        $result=$query->fetch();

        unset($query);
        return $result;
    }

    /**
     * @param int $playerId
     * @return string
     */
    public static function loadPlayer(int $playerId): string
    {
        if(!isset(self::$dbc)){
            return false;
        }

        $query=self::$dbc->query("SELECT name FROM players WHERE id=".
            (string)$playerId);
        $result=$query->fetch();

        $name=$result['name'];
        unset($result, $query);
        return $name;
    }

    /**
     * @param int $fieldId
     * @param int $x
     * @param int $y
     * @return bool
     */
    public static function loadCell(int $fieldId, int $x, int $y)
    {
        if(!isset(self::$dbc)){
            return false;
        }

        $query=self::$dbc->query("SELECT * FROM cells WHERE field=".
            (string)$fieldId." AND coordinate_x=".(string)$x." AND coordinate_y=".(string)$y);
        $result=$query->fetch();

        unset($query);
        return $result;
    }

    /**
     * @param int $cellId
     * @param string $state
     * @return bool
     */
    public static function changeCellState(int $cellId, string $state)
    {
        if(!isset(self::$dbc)){
            return false;
        }

        self::$dbc->query("UPDATE cells SET state='${state}' WHERE id=".
            (string)$cellId);
    }

    /**
     * @param int $fieldId
     * @return bool|int
     */
    public static function getShipsNum(int $fieldId)
    {
        if(!isset(self::$dbc)){
            return false;
        }

        $query=self::$dbc->query("SELECT * FROM cells WHERE field=".
            (string)$fieldId." AND state='ship'");
        $result=$query->fetchAll();
        $shipsNum=count($result);
        unset($query, $result);
        return $shipsNum;
    }

    /**
     * @param int $winnerId
     * @param int $gameId
     * @return bool
     */
    public static function setWinnerAndTime(int $winnerId, int $gameId)
    {
        if(!isset(self::$dbc)){
            return false;
        }

        self::$dbc->query("UPDATE games SET winner=".(string)$winnerId." , end_timestamp=current_timestamp WHERE id=".
            (string)$gameId);
    }
}