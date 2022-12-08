<?php

namespace frontend\tests\unit\models;

use frontend\models\Request;

class RequestTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;

    public function testGetNewModel()
    {
        $requestModel = Request::getNewModel();
        verify(get_class($requestModel))->equals('frontend\models\Request');
        verify($requestModel->memory_usage)->equals(0);
        verify($requestModel->time_usage)->equals(0);
    }

    public function testSaveTimeAndMemoryUsage()
    {
        $requestModel = Request::getNewModel();

        sleep(2);

        $requestModel->saveTimeAndMemoryUsage();

        verify($requestModel->time_usage)->greaterThan(2);
        verify($requestModel->memory_usage)->greaterThan(0);
    }
}
