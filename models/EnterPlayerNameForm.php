<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 14.01.19
 * Time: 15:04
 */

namespace app\models;


use yii\base\Model;

class EnterPlayerNameForm extends Model
{
    public $playerOneName;
    public $playerTwoName;

    public function rules()
    {
        return [
            [['playerOneName', 'playerTwoName'], 'required'],
            [['playerOneName', 'playerTwoName'], 'string'],
            ['playerTwoName', 'compare', 'compareAttribute' => 'playerOneName',
                'operator' => '!==']
        ];
    }
}