<?php

namespace frontend\models;

class Request extends \common\models\Request
{
    public static function getNewModel(): Request
    {
        $requestModel = new self([
            'time_usage' => 0,
            'memory_usage' => 0
        ]);
        $requestModel->save();

        return $requestModel;
    }

    public function saveTimeAndMemoryUsage(): void
    {
        $this->time_usage = microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'];
        $this->memory_usage = memory_get_usage();
        $this->save();
    }
}
