<?php

namespace app\services\auth;

use app\models\User;
use yii\base\Model;

class AuthManager extends Model
{

    private $_user = false;


    public function signUp(SignupForm $signupForm)
    {
        $user = new User();
        $user->first_name = $signupForm->first_name;
        $user->last_name = $signupForm->last_name;
        $user->email = $signupForm->email;
        $user->username = $signupForm->email;
        $user->password = $signupForm->password;
        $user->save();
    }

    public function login(LoginForm $loginForm)
    {
        return \Yii::$app->user->login($this->getUser($loginForm), $loginForm->rememberMe ? 3600*24*30 : 0);
    }


    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    private function getUser($loginForm)
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($loginForm->username);
        }

        return $this->_user;
    }
}
