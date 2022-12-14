<?php

namespace app\models;

use Yii;
use yii\base\Model;


/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $confirmPassword;
    public $verifyCode;

    public function attributeLabels()
    {
        return [
            'username' =>'Имя',
            'email' =>'E-mail',
            'password' =>'Пароль',
            'confirmPassword' => 'Подтвердить пароль',
            'verifyCode' => 'Введите символы с картинки'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {

        define('TAKEN_USERNAME', 'Пользователь с таким именем уже существует!');
        define('TOOSHORT_USERNAME', 'Имя пользователя не может быть меньше 2х символов!');

        define('TAKEN_EMAIL', 'Пользователь с таким email уже существует!');
        define('NOT_EMAIL', 'Вы заполнили почтовый ящик некорректно!');

        define('TOOSHORT_PASSWORD', 'Пароль не может быть меньше 6 символов!');

        define('EMPTY_MESSAGE', 'Данное поле не может быть пустым!');
        define('TOOLONG_FIELD', 'Данное поле не может быть больше 255 символов!');

        define('PWDS_DISMATCHED', 'Ваши введенные пароли не совпадают!');

        define('NOT_CAPTCHA', 'Вы ввели неверно симфолы с картинки! Пожалуйста, повторите ввод');

        return [
            ['username', 'trim'],
            ['username', 'required','message' => EMPTY_MESSAGE],
            ['username', 'unique', 'targetClass' => '\app\models\Users', 'message' => TAKEN_USERNAME],
            ['username', 'string', 'min' => 2, 'max' => 255, 'tooShort' => TOOSHORT_USERNAME, 'tooLong' => TOOLONG_FIELD],

            ['email', 'trim'],
            ['email', 'required', 'message' => EMPTY_MESSAGE],
            ['email', 'email','message' => NOT_EMAIL],
            ['email', 'string', 'max' => 255, 'tooLong' => TOOLONG_FIELD],
            ['email', 'unique', 'targetClass' => '\app\models\Users', 'message' => TAKEN_EMAIL],

            ['password', 'required','message' => EMPTY_MESSAGE],
            ['password', 'string', 'min' => 6,'tooShort' => TOOSHORT_PASSWORD],

            ['confirmPassword', 'required', 'message' => EMPTY_MESSAGE],
            ['confirmPassword', 'compare', 'compareAttribute'=>'password', 'message' => PWDS_DISMATCHED],

            ['verifyCode', 'captcha','message' => NOT_CAPTCHA],
        ];
    }

    /**
     * Signs user up.
     *
     * @return Users|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate(['username', 'email', 'password'])) {
            return null;
        }

        $user = new Users();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->created_at = date('Y-m-d');
        $user->updated_at = date('Y-m-d');

        if($user->save()){
            //todo возможно добаить if на проверку присвоения роли
            self::addUserRole($user);
            return $user;
        }else{
            return null;
        }
    }

    //создание Role Based Access Control (RBAC) роли пользователя
    private static function addUserRole($user)
    {
        //todo возможно тоже вынести, поэтому без хардкода
        $RBACrole = "user";

        $userRole = Yii::$app->authManager->getRole($RBACrole);
        Yii::$app->authManager->assign($userRole, $user->getId());
    }


}