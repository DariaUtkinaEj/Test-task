<?php

namespace backend\controllers;

use common\models\Data;
use common\models\Request;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    public function actionIndex()
    {
        $requests = Request::find()->all();
        return $this->render('index', ['requests' => $requests]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $value = Yii::$app->request->post('value');
        $model->value = $value;

        if ($model->save()) {
            return true;
        }

        return false;
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return true;
    }

    private function findModel($id)
    {
        if (($model = Data::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Requested model does not exist.');
    }
}
