<?php

namespace app\controllers;

use Exception;
use Yii;
use app\models\Category;
use app\models\CategorySearch;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
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
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Category model.
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
     * Get category create form
     *
     * @method GET
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Category();

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @method GET
     *
     * @throws Exception
     * @return mixed
     */
    public function actionAdd()
    {
        $model = new Category();
        $returnData = [
            'errors' => [],
            'item_location' => '',
            'success_message' => 'Category was successful created!'
        ];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($model->validate() && $model->save()) {
                $returnData['item_location'] = Url::to(['view', 'id' => $model->id]);
            } else {
                $returnData['errors'] = $model->getErrors();
            }
        } else {
            throw new Exception('Category data not found');
        }

        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = $returnData;

        return $response;
    }

    /**
     * Get category update form
     *
     * @method GET
     *
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @method POST
     *
     * @param integer $id
     * @throws Exception
     * @return mixed
     */
    public function actionEdit($id)
    {
        $model = $this->findModel($id);
        $returnData = [
            'errors' => [],
            'item_location' => '',
            'success_message' => 'Category was successful edited!'
        ];

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate() && $model->save()) {
                $returnData['item_location'] = Url::to(['view', 'id' => $model->id]);
            } else {
                $returnData['errors'] = $model->getErrors();
            }
        } else {
            throw new Exception('Category data not found');
        }

        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = $returnData;

        return $response;
    }

    /**
     * Deletes an existing Category model.
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
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
