<?php

namespace backend\controllers;

use Yii;
use common\models\Course;
use common\models\Peserta;
use backend\models\CourseSearch;
use backend\models\PesertaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;

/**
 * CourseController implements the CRUD actions for Course model.
 */
class CourseController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Course models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CourseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Course model.
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
     * Creates a new Course model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Course();

        if ($model->load(Yii::$app->request->post())) {
            $image =UploadedFile::getInstance($model,'image');
            if(!empty($image)){
            $NameImage = $model->nama_course.'-'.date('YmdHis').'.'.$image->extension;
            $model->image = 'uploads/'.$NameImage;
            if ($model->save()){
            $image -> saveAs('uploads/'.$NameImage);
            mkdir('../../frontend/web/uploads/'.$model->nama_course.'/');
            return $this->redirect(['view', 'id' => $model->ID]);
            }
            }
            $model->save();
            mkdir('../../frontend/web/uploads/'.$model->nama_course.'/');
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

//    public function actionDownload($id)
//    {
//    $download = Peserta::findOne($id);
//    $path=Yii::getAlias('@webroot').'web/'.$download->bukti_bayar;
//    if (file_exists($path)) {
//
//        return Yii::$app->response->sendFile($path);
//
//    }
//    }

    /**
     * Updates an existing Course model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $pathlama = '../../frontend/web/uploads/'.$model->nama_course.'/';
        $sementara = $model->image;
        if ($model->load(Yii::$app->request->post())) {
            $image =UploadedFile::getInstance($model,'image');
            if(!empty($image)){
            $NameImage = $model->nama_course.'-'.date('YmdHis').'.'.$image->extension;
            $model->image = 'uploads/'.$NameImage;
            if ($model->save()){
            $image -> saveAs('uploads/'.$NameImage);
            unlink($sementara);
            rename($pathlama,'../../frontend/web/uploads/'.$model->nama_course.'/');
            return $this->redirect(['view', 'id' => $model->ID]);
            }
            }
            $model->image = $sementara;
            $model->save();
            rename($pathlama,'../../frontend/web/uploads/'.$model->nama_course.'/');
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Course model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        rmdir('../../frontend/web/uploads/'.$model->nama_course.'/');
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Course model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Course the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Course::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

     public function actionDpeserta($id)
   {
    $download = Peserta::findOne($id);
    $path='../../frontend/web/uploads/'.$download->coursePeserta->nama_course.'/'.$download->bukti_bayar;
    if (file_exists($path)) {
        return Yii::$app->response->sendFile($path);
    }else{
        echo 'file not exists...';
    }
   }

    public function actionVpeserta($id)
   {
    $download = Peserta::findOne($id);
    $path='../../frontend/web/uploads/'.$download->coursePeserta->nama_course.'/'.$download->bukti_bayar;
    if (file_exists($path)) {
        return Yii::$app->response->sendFile($path,$download->bukti_bayar,['inline'=>true]);
    }else{
        echo 'file not exists...';
    }
   }
}
