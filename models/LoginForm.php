<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Users;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read Users|null $user
 *
 */
class LoginForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;

    private $_user = false;

    public function attributeLabels()
    {
        return [
            'email' =>'Введите свой email',
            'password' =>'Введите свой пароль'
        ];
    }


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        define('EMAIL_NOT_EXIST', 'Пользователя с таким почтовым ящиком нет в системе!');

        define('NOT_CORRECT_PASSWORD', 'Пользователя с таким почтовым ящиком нет в системе!');

        define('EMPTY_MESSAGE', 'Данное поле не может быть пустым!');

        return [

            [['email', 'password'], 'required','message' => EMPTY_MESSAGE],
            ['email', 'exist', 'targetClass' => '\app\models\Users', 'message' => EMAIL_NOT_EXIST],
            // rememberMe must be a boolean value
            // ['rememberMe', 'boolean'],

            // password is validated by validatePassword()
            ['password', 'validatePassword', 'message' => NOT_CORRECT_PASSWORD],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Почта и пароль пользователя не совпадают!');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[email]]
     *
     * @return Users|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = Users::findByEmail($this->email);
        }

        return $this->_user;
    }
}
