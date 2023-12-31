<?php

namespace app\services\auth;

use app\models\User;
use Yii;
use yii\base\Model;

class SignupForm extends Model
{
    public $email;
    public $password;
    public $first_name;
    public $last_name;


    public function rules()
    {
        return [
            [['email', 'password','first_name', 'last_name'], 'required', 'message' => Yii::t('app', "The field must be filled out")],
            ['email', 'email'],
            [['email'], 'unique',
                'targetAttribute' => ['email' => 'email'],
                'targetClass' => User::class,
                'message' => \Yii::t("app", "This email is already taken")],
        ];
    }
}
