<?php

namespace app\controllers;

use app\models\Actores;
use app\models\ActoresSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

/**
 * ActoresController implements the CRUD actions for Actores model.
 */
class ActoresController extends Controller
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
     * Lists all Actores models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ActoresSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Actores model.
     * @param int $id_actores Id Actores
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_actores)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_actores),
        ]);
    }

    /**
     * Creates a new Actores model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Actores();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_actores' => $model->id_actores]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Actores model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_actores Id Actores
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_actores)
    {
        $model = $this->findModel($id_actores);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_actores' => $model->id_actores]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Actores model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_actores Id Actores
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_actores)
    {
        $this->findModel($id_actores)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Actores model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_actores Id Actores
     * @return Actores the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_actores)
    {
        if (($model = Actores::findOne(['id_actores' => $id_actores])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
