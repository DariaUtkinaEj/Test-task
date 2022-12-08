<?php

namespace frontend\controllers;

use frontend\models\Data;
use frontend\models\Request;
use common\models\User;
use Yii;
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
        $requestModel = Request::getNewModel();

        foreach ($bodyParams as $key => $param) {
            Data::loadParamToDB($requestModel->id, $key, $param);
        }

        $requestModel->saveTimeAndMemoryUsage();

        return 'It took ' .
            (microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']) .
            ' seconds to handle request.' .
            "\n" .
            'It took ' . memory_get_usage() / 1024 .
            ' kilobytes of RAM to handle this request.';
    }
}