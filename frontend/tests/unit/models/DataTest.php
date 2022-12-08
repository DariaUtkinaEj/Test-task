<?php

namespace frontend\tests\unit\models;

use frontend\models\Request;
use frontend\models\Data;

class DataTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;

    public function testLoadParamToDBInteger()
    {
        $requestModel = Request::getNewModel();
        $data = ['test_integer' => 1];

        foreach ($data as $key => $param) {
            Data::loadParamToDB($requestModel->id, $key, $param);
        }

        $savedData = Data::find()->one();

        verify($savedData->type)->equals('integer');
    }

    public function testLoadParamToDBString()
    {
        $requestModel = Request::getNewModel();
        $data = ['test_integer' => 'string'];

        foreach ($data as $key => $param) {
            Data::loadParamToDB($requestModel->id, $key, $param);
        }

        $savedData = Data::find()->one();

        verify($savedData->type)->equals('string');
    }

    public function testLoadParamToDBBoolean()
    {
        $requestModel = Request::getNewModel();
        $data = ['test_integer' => true];

        foreach ($data as $key => $param) {
            Data::loadParamToDB($requestModel->id, $key, $param);
        }

        $savedData = Data::find()->one();

        verify($savedData->type)->equals('boolean');
    }

    public function testLoadParamToDBArray()
    {
        $requestModel = Request::getNewModel();

        $data = [
            'test_array1' => [
                'test_array2' => [
                    'test_array3' => [
                        'first_value' => 1,
                        'second_value' => 2
                    ]
                ],
                14 => 'asggkgdskgdslgkdslkg'
            ]
        ];

        foreach ($data as $key => $param) {
            Data::loadParamToDB($requestModel->id, $key, $param);
        }

        $savedData = Data::find()->all();

        verify(count($savedData))->equals(6);

        foreach ($data as $key => $param) {
            if (is_array($param)) {
                $param = 'array';
            }

            $checkSavedToDB = Data::findOne([
                'key' => (string)$key,
                'value' => (string)$param,
            ]);

            verify($checkSavedToDB)->notNull();
        }
    }
}
