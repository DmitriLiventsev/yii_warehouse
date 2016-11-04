<?php

namespace app\controllers;

use app\models\Category;
use Exception;
use Yii;
use app\models\Product;
use app\models\ProductSearch;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
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
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
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
     * Get form to create a new customer
     *
     * @Method GET
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();

        return $this->render('create', [
            'model' => $model,
            'categories' => Category::listAll(),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @Method POST
     *
     * @throws Exception
     * @return \yii\web\Response
     */
    public function actionAdd()
    {
        $model = new Product();
        $returnData = [
            'errors' => [],
            'item_location' => '',
            'success_message' => 'Product was successful created!'
        ];

        if ($model->load(Yii::$app->request->post())) {
            $model->scenario = 'create-photo-upload';
            $model->picture = UploadedFile::getInstance($model, 'picture');

            if ($model->validate() && $model->save()) {
                $model->picture->saveAs('Uploads' . DIRECTORY_SEPARATOR  . $model->picture->baseName . '.' . $model->picture->extension);

                $returnData['item_location'] = Url::to(['view', 'id' => $model->id]);
            }  else {
                $returnData['errors'] = $model->getErrors();
            }
        } else {
            throw new Exception('Product data not found');
        }

        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = $returnData;

        return $response;
    }

    /**
     * Get form to update a customer
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
            'categories' => Category::listAll(),
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     *
     * @method POST
     *
     * @throws Exception
     * @return mixed
     */
    public function actionEdit($id)
    {
        $returnData = [
            'errors' => [],
            'item_location' => '',
            'success_message' => 'Product was successful edited!'
        ];

        $model = $this->findModel($id);
        $oldPicture = $model->picture;

        if ($model->load(Yii::$app->request->post())) {
            $model->picture = UploadedFile::getInstance($model, 'picture');
            if ($model->picture) {
                $model->scenario = 'update-photo-upload';
                $model->picture->saveAs('Uploads' . DIRECTORY_SEPARATOR  . $model->picture->baseName . '.' . $model->picture->extension);
            } else {
                $model->picture = $oldPicture;
            }

            if ($model->validate() && $model->save()) {
                //Workaround. saveAs should be called only after $model->validate() otherwise tmp file will be moved
                if ($model->picture != $oldPicture) {
                    $model->picture->saveAs('Uploads' . DIRECTORY_SEPARATOR  . $model->picture->baseName . '.' . $model->picture->extension);
                }

                $returnData['item_location'] = Url::to(['view', 'id' => $model->id]);
            } else {
                $returnData['errors'] = $model->getErrors();
            }
        } else {
            throw new Exception('Product data not found');
        }

        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = $returnData;
    }

    /**
     * Deletes an existing Product model.
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
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
