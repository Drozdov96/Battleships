<?php

namespace app\models;


use yii\base\Model;

class EnterPlayerNameForm extends Model
{
    /**
     * @var string
     */
    public $playerOneName;
    /**
     * @var string
     */
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