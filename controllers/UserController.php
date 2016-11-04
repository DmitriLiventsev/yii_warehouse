<?php

namespace app\controllers;

use Exception;
use Yii;
use app\models\UserIdentity;
use app\models\UserIdentitySearch;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for UserIdentity model.
 */
class UserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'roles' => ['@'],
                    ]
                ]
            ],

            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all UserIdentity models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserIdentitySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserIdentity model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Get form to create new customer
     *
     * @method GET
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserIdentity();

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new UserIdentity model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @method POST
     *
     * @throws Exception
     * @return mixed
     */
    public function actionAdd()
    {
        $model = new UserIdentity();

        $returnData = [
            'errors' => [],
            'item_location' => '',
            'success_message' => 'User was successful created!'
        ];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($model->validate() && $model->save()) {
                $returnData['item_location'] = Url::to(['view', 'id' => $model->id]);
            } else {
                $returnData['errors'] = $model->getErrors();
            }
        } else {
            throw new Exception('User data not found');
        }

        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = $returnData;

        return $response;
    }


    /**
     * Deletes an existing UserIdentity model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the UserIdentity model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserIdentity the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserIdentity::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
