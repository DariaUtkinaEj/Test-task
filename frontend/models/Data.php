<?php

namespace frontend\models;

use yii\db\Exception;

class Data extends \common\models\Data
{
    public static function loadParamToDB($requestId, $key, $param, $parentId = null, $nestingLevel = 0)
    {
        $data = new Data([
            'request_id' => $requestId,
            'parent_id' => $parentId,
            'key' => (string)$key,
            // `value` expects string, because we need to store strings, integers, float, long text — everything
            'value' => is_array($param) ? 'array' : (string)$param,
            'type' => gettype($param),
            'nesting_level' => $nestingLevel
        ]);

        if (!$data->save()) {
            throw new Exception('Unable to save data item', $data->getErrors());
        }

        if (!is_array($param)) return;

        $nestingLevel++;

        foreach ($param as $key => $item) {
            self::loadParamToDB($requestId, $key, $item, $data->id, $nestingLevel);
        }
    }
}
