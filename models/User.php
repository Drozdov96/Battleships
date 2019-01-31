<?php

namespace app\models;

use app\controllers\DatabaseHelper;

class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
{
    public $id;
    public $name;
    public $password;
    public $authkey;
    public $accesstoken;

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        $user=DatabaseHelper::getPlayerForId($id);
        return empty($user)? null : new static($user);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $user=DatabaseHelper::getPlayerIdByToken($token);
        return empty($user)? null : new static($user);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $user=DatabaseHelper::getPlayerIdByName($username);
        return empty($user)? null : new static($user);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authkey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authkey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
}
