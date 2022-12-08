<?php

namespace common\tests\unit\models;

use Codeception\Verify\Verify;
use common\models\User;
use common\fixtures\UserFixture;
use yii\web\UnauthorizedHttpException;

class UserTest extends \Codeception\Test\Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;


    /**
     * @return array
     */
    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php'
            ]
        ];
    }

    public function testCorrectCheckToken()
    {
        Verify::Callable(function () {
            User::checkAuthToken('not_existing_auth_token');
        })->throws(UnauthorizedHttpException::class, 'No user found by auth key');

        Verify::Callable(function () {
            User::checkAuthToken('expired_auth_token');
        })->throws(UnauthorizedHttpException::class, 'Auth key is expired');

        Verify::Callable(function () {
            User::checkAuthToken('valid_auth_token');
        })->doesNotThrow(UnauthorizedHttpException::class);
    }

    public function testUserCreate()
    {
        Verify::Callable(function () {
            // kuritsa already exists
            User::createNewUser('kuritsa', 'anypassword');
        })->throws(\yii\db\Exception::class, 'Unable to create user due to validation fail');

        Verify::Callable(function () {
            User::createNewUser('not_yet_existing_user', 'anypassword');
        })->doesNotThrow(\yii\db\Exception::class);
    }
}
