<?php

namespace console\controllers;

use common\models\User;
use yii\console\Controller;
use yii\console\Exception;

class UserController extends Controller
{
    /**
     * @throws Exception
     */
    public function actionAuth($username, $password): void
    {
        $user = User::findByUsername($username);

        if (!$user) {
            throw new Exception('Incorrect username or password');
        }

        if (!$user->validatePassword($password)) {
            throw new Exception('Incorrect username or password');
        }

        if (time() > $user->auth_expires_at) {
            $user->generateAuthKey();
            $user->save();
        }

        echo 'Success! Your key: ' . $user->auth_key;
    }

    /**
     * @throws \yii\db\Exception
     */
    public function actionCreate($username, $password): void
    {
        User::createNewUser($username, $password);

        echo 'Created ' . $username . ' successfully';
    }
}
