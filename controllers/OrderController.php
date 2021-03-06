<?php

namespace app\controllers;

use Yii;
use app\models\Order;
use app\models\SearchOrder;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\AtacheFile;
use yii\web\UploadedFile;
use yii\filters\AccessControl;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['login', 'logout', 'create', 'index', 'update', 'delete', 'view'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'signup', 'index', 'view','create',],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout', 'create', 'index', 'update', 'delete', 'view'],
                        'roles' => ['@'],
                    ],
                   
                ],
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
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchOrder();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Order model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Order();
     
        if ($model->load(Yii::$app->request->post())) {
           
            $model->user_ip = $model->getUserIp();
            $model->user_brouser = $model->getUserBrouser();
            
            $file = new AtacheFile();
             if(UploadedFile::getInstance($model, 'file')) {
                 
                $file->file = UploadedFile::getInstance($model, 'file');
                if($model->validateFile($file->file)){
                   $model->file = $file->file->name;
                    if ($file->upload()) {
                     if($model->save()){
                        return $this->redirect(['view', 'id' => $model->id]);
                        }
                    } 
                }                
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
        
         if(!empty(UploadedFile::getInstance($model, 'file'))){
                $file = new AtacheFile();
                $file->fiel = UploadedFile::getInstance($model, 'file');
                $model->file = $file->file->name;
                if (!$file->upload()) {                    
                     return $this->render('update', [
                        'model' => $model,
                    ]); 
                }
            }else{
                $model->file = $model->getCurrentFile($model->id)[0];
            } 
            if($model->save()){
              return $this->redirect(['view', 'id' => $model->id]);  
            }
        }
         return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
