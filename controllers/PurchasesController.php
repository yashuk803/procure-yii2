<?php

namespace app\controllers;

use app\models\Items;
use app\models\MultipleModel;
use app\models\Purchases;
use app\models\PurchasesSearch;
use app\services\purchases\PurchaseManager;
use yii\base\Model;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * PurchasesController implements the CRUD actions for Purchases model.
 */
class PurchasesController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Purchases models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PurchasesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Purchases model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Purchases model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Purchases();
        $modelItems = [new Items()];

        if ($this->request->isPost) {
            try {
                $purchaseManager = new PurchaseManager($this->request->post(), $model);
                $modelId = $purchaseManager->execute();
                return $this->redirect(['view', 'id' => $modelId]);
            } catch (\Exception $e) {

            }
        }

        return $this->render('create', [
            'model' => $model,
            'modelItems' => $modelItems,
        ]);
    }

    /**
     * Updates an existing Purchases model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $modelItems = $model->items ? $model->items : [new Items()];

        if ($this->request->isPost) {
            try {
                $purchaseManager = new PurchaseManager($this->request->post(), $model);
                $modelId = $purchaseManager->execute();
                return $this->redirect(['view', 'id' => $modelId]);
            } catch (\Exception $e) {

            }
        }

        return $this->render('update', [
            'model' => $model,
            'modelItems' => $modelItems,
        ]);
    }


    public function actionValidateForm()
    {
        $post = \Yii::$app->request->post();
        $model = new Purchases();
        $modelItems = [new Items()];

        if (\Yii::$app->request->isAjax && $model->load($post)) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            MultipleModel::createMultiple(Items::class, 'id', $modelItems);
            Model::loadMultiple($modelItems, $post);

            return ArrayHelper::merge(
                ActiveForm::validate($model),
                ActiveForm::validateMultiple($modelItems)
            );
        }
        return true;
    }


    /**
     * Finds the Purchases model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Purchases the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Purchases::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
