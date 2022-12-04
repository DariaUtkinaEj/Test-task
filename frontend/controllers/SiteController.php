<?php

namespace frontend\controllers;

use common\models\Data;
use common\models\Request;
use common\models\User;
use Yii;
use yii\db\Exception;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\UnauthorizedHttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'create' => ['post', 'get'],
                ],
            ],
        ];
    }

    /**
     * @throws UnauthorizedHttpException
     * @throws BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;

        $headers = Yii::$app->request->headers;
        $authorization = $headers->get('Authorization');

        if (!$authorization) {
            throw new UnauthorizedHttpException('No auth key specified');
        }

        $authorization = str_replace('Bearer ', '', $authorization);

        User::checkAuthToken($authorization);

        return parent::beforeAction($action);
    }

    public function actionCreate()
    {
        $bodyParams = Yii::$app->request->getBodyParams();

        $requestModel = new Request([
            'time_usage' => 0,
            'memory_usage' => 0
        ]);
        $requestModel->save();

        foreach ($bodyParams as $key => $param) {
            $this->loadParamToDB($requestModel->id, $key, $param);
        }

        $requestModel->time_usage = microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'];
        $requestModel->memory_usage = memory_get_usage();
        $requestModel->save();

        return 'It took ' .
            (microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']) .
            ' seconds to handle request.' .
            "\n" .
            'It took ' . memory_get_usage() / 1024 .
            ' kilobytes of RAM to handle this request.';

    }

    private function loadParamToDB($requestId, $key, $param, $parentId = null)
    {
        $data = new Data([
            'request_id' => $requestId,
            'parent_id' => $parentId,
            'key' => (string)$key,
            'value' => is_array($param) ? 'array' : $param,
            'type' => gettype($param)
        ]);

        if (!$data->save()) {
            throw new Exception('Unable to save data item', $data->getErrors());
        }

        if (!is_array($param)) return;

        foreach ($param as $key => $item) {
            $this->loadParamToDB($requestId, $key, $item, $data->id);
        }
    }
}
