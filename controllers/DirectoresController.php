<?php

namespace app\controllers;

use app\models\Directores;
use app\models\DirectoresSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

/**
 * DirectoresController implements the CRUD actions for Directores model.
 */
class DirectoresController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => \yii\filters\AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'],
                            'matchCallback' => function ($rule, $action) {
                                return !Yii::$app->user->isGuest && Yii::$app->user->identity->role == 'admin';
                            }
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Directores models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new DirectoresSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Directores model.
     * @param int $id_directores Id Directores
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_directores)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_directores),
        ]);
    }

    /**
     * Creates a new Directores model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Directores();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_directores' => $model->id_directores]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Directores model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_directores Id Directores
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_directores)
    {
        $model = $this->findModel($id_directores);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_directores' => $model->id_directores]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Directores model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_directores Id Directores
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_directores)
    {
        $this->findModel($id_directores)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Directores model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_directores Id Directores
     * @return Directores the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_directores)
    {
        if (($model = Directores::findOne(['id_directores' => $id_directores])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
